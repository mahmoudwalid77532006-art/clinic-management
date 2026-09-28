<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Appointment;
use App\Http\Requests\StoreVisitRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VisitController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = Visit::with(['patient', 'doctor.user', 'appointment']);

        if ($user->role === 'doctor') {
            $doctor = $user->doctor;
            abort_if(! $doctor, 403, 'حسابك كدكتور مش مربوط ببيانات طبيب. كلّم المدير.');
            $query->where('doctor_id', $doctor->id);
        }

        $visits = $query->latest()->get();

        return view('visits.index', compact('visits'));
    }

    public function create()
    {
        $user = auth()->user();
        $query = Appointment::with(['patient', 'doctor.user'])
            ->whereDoesntHave('visit')
            ->where('status', 'completed');

        // نفس الفكرة: الدكتور يشوف مواعيده المكتملة بس عشان الزيارة
        // اللي هيسجلها تبقى تابعة له وتظهر له في القائمة بعد الحفظ.
        if ($user->role === 'doctor') {
            $doctor = $user->doctor;
            abort_if(! $doctor, 403, 'حسابك كدكتور مش مربوط ببيانات طبيب. كلّم المدير.');
            $query->where('doctor_id', $doctor->id);
        }

        $appointments = $query->get();

        return view('visits.create', compact('appointments'));
    }

    public function store(StoreVisitRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                Visit::create($request->validated());
            });
        } catch (\Throwable $e) {
            Log::error('فشل تسجيل الزيارة: '.$e->getMessage());

            return back()->withInput()->with('error', 'حصل خطأ أثناء تسجيل الزيارة، حاول تاني.');
        }

        return redirect()->route('visit.index')->with('success', 'تم تسجيل الزيارة.');
    }

    public function show(Visit $visit)
    {
        $visit->load(['patient', 'doctor.user', 'prescriptions']);

        return view('visits.show', compact('visit'));
    }

    public function edit(Visit $visit)
    {
        return view('visits.edit', compact('visit'));
    }

    public function update(StoreVisitRequest $request, Visit $visit)
    {
        $visit->update($request->validated());

        return redirect()->route('visit.index')->with('success', 'تم تحديث الزيارة.');
    }

    public function destroy(Visit $visit)
    {
        $visit->delete();

        return redirect()->route('visit.index')->with('success', 'تم حذف الزيارة.');
    }
}
