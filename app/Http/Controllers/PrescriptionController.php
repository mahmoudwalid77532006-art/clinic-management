<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePrescriptionRequest;
use App\Models\Prescription;
use App\Models\Visit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PrescriptionController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = Prescription::with('visit.patient', 'visit.doctor.user');

        if ($user->role === 'doctor') {
            // مهم: لو حساب الدكتور مش مربوط بسجل Doctor، نوقفه برسالة واضحة
            // بدل ما نسيبه يشوف قائمة فاضية وهو مش فاهم ليه (ده كان سبب مشكلة
            // "بيضيف روشتة وبعدين مش بتظهر" — كان بيرجع فلتر doctor_id = null
            // وده بيرجع نتيجة فاضية دايمًا بصمت).
            $doctor = $user->doctor;
            abort_if(! $doctor, 403, 'حسابك كدكتور مش مربوط ببيانات طبيب. كلّم المدير.');

            $query->whereHas('visit', fn ($q) => $q->where('doctor_id', $doctor->id));
        }

        $prescriptions = $query->latest()->get();

        return view('prescriptions.index', compact('prescriptions'));
    }

    public function create()
    {
        $user = auth()->user();
        $query = Visit::with(['patient', 'doctor.user']);

        // نعرض للدكتور زياراته هو بس، عشان لما يضيف روشتة تبقى مرتبطة
        // بزيارة تابعة له فعلاً، وبالتالي تظهر له بعدين في صفحة الروشتات
        // (قبل كده كانت بتتعرض كل الزيارات، فالدكتور ممكن يختار زيارة
        // طبيب تاني بالغلط والروشتة تتحفظ لكن متظهرش له خالص).
        if ($user->role === 'doctor') {
            $doctor = $user->doctor;
            abort_if(! $doctor, 403, 'حسابك كدكتور مش مربوط ببيانات طبيب. كلّم المدير.');
            $query->where('doctor_id', $doctor->id);
        }

        $visits = $query->latest()->get();

        return view('prescriptions.create', compact('visits'));
    }

    public function store(StorePrescriptionRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                Prescription::create($request->validated());
            });
        } catch (\Throwable $e) {
            Log::error('فشل حفظ الروشتة: '.$e->getMessage());

            return back()->withInput()->with('error', 'حصل خطأ أثناء حفظ الروشتة، حاول تاني.');
        }

        return redirect()->route('prescription.index')->with('success', 'تمت إضافة الروشتة.');
    }

    public function show(Prescription $prescription)
    {
        $prescription->load('visit.patient', 'visit.doctor.user');

        return view('prescriptions.show', compact('prescription'));
    }

    public function edit(Prescription $prescription)
    {
        return view('prescriptions.edit', compact('prescription'));
    }

    public function update(StorePrescriptionRequest $request, Prescription $prescription)
    {
        $prescription->update($request->validated());

        return redirect()->route('prescription.index')->with('success', 'تم تحديث الروشتة.');
    }

    public function destroy(Prescription $prescription)
    {
        $prescription->delete();

        return redirect()->route('prescription.index')->with('success', 'تم حذف الروشتة.');
    }
}
