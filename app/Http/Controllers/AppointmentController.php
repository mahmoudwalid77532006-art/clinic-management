<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource, scoped by role.
     */
    public function index()
    {
        $user = auth()->user();
        $query = Appointment::with(['doctor.user', 'patient', 'service'])
            ->latest('appointment_date');

        if ($user->role === 'patient') {
            $patient = Patient::where('user_id', $user->id)->firstOrFail();
            $query->where('patient_id', $patient->id);
        } elseif ($user->role === 'doctor') {
            $doctor = Doctor::where('user_id', $user->id)->firstOrFail();
            $query->where('doctor_id', $doctor->id);
        }
        // admin: no filter, sees everything

        $appointments = $query->get();

        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource (patients only).
     */
    public function create()
    {
        if (auth()->user()->role !== 'patient') {
            abort(403, 'المريض بس هو اللي يقدر يحجز موعد.');
        }

        $doctors = Doctor::with('user')->where('is_active', true)->get();
        $services = Service::where('is_active', true)->get();

        return view('appointments.create', compact('doctors', 'services'));
    }

    /**
     * Store a newly created resource in storage (patients only).
     */
    public function store(StoreAppointmentRequest $request)
    {
        if (auth()->user()->role !== 'patient') {
            abort(403, 'المريض بس هو اللي يقدر يحجز موعد.');
        }

        $data = $request->validated();

        $userId = $request->user()->id;
        $patient = Patient::where('user_id', $userId)->firstOrFail();
        $service = Service::findOrFail($data['service_id']);

        $data['patient_id'] = $patient->id;
        $data['price'] = $service->price;
        $data['status'] = 'pending';
        $data['created_by'] = $userId;

        try {
            DB::transaction(function () use ($data) {
                Appointment::create($data);
            });
        } catch (\Throwable $e) {
            Log::error('فشل حجز الموعد: '.$e->getMessage());

            return back()->withInput()->with('error', 'حصل خطأ أثناء حجز الموعد، حاول تاني.');
        }

        return redirect()->route('appointment.index')->with('success', 'تم حجز الموعد بنجاح.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        $this->authorizeView($appointment);

        $appointment->load(['doctor.user', 'patient', 'service']);

        return view('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource (doctor/admin only).
     */
    public function edit(Appointment $appointment)
    {
        $this->authorizeManage($appointment);

        return view('appointments.edit', compact('appointment'));
    }

    /**
     * Update the specified resource in storage (doctor/admin only).
     */
    public function update(Request $request, Appointment $appointment)
    {
        $this->authorizeManage($appointment);

        $data = $request->validate([
            'status' => ['required', 'in:pending,confirmed,completed,cancelled'],
            'cancellation_reason' => ['nullable', 'string', 'max:255'],
        ]);

        $appointment->update($data);

        return redirect()->route('appointment.index')->with('success', 'تم تحديث الموعد.');
    }

    /**
     * Remove the specified resource from storage (doctor/admin only).
     */
    public function destroy(Appointment $appointment)
    {
        $this->authorizeManage($appointment);

        $appointment->delete();

        return redirect()->route('appointment.index')->with('success', 'تم حذف الموعد.');
    }

    /**
     * A patient may only view their own appointment; a doctor only their own;
     * admin may view anything.
     */
    private function authorizeView(Appointment $appointment): void
    {
        $user = auth()->user();

        if ($user->role === 'patient') {
            $patient = Patient::where('user_id', $user->id)->first();
            abort_unless($patient && $appointment->patient_id === $patient->id, 403);
        } elseif ($user->role === 'doctor') {
            $doctor = Doctor::where('user_id', $user->id)->first();
            abort_unless($doctor && $appointment->doctor_id === $doctor->id, 403);
        }
    }

    /**
     * Only admin, or the doctor assigned to the appointment, may manage it.
     */
    private function authorizeManage(Appointment $appointment): void
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return;
        }

        if ($user->role === 'doctor') {
            $doctor = Doctor::where('user_id', $user->id)->first();
            abort_unless($doctor && $appointment->doctor_id === $doctor->id, 403);
            return;
        }

        abort(403, 'مش مسموحلك تعدّل أو تحذف المواعيد.');
    }
}
