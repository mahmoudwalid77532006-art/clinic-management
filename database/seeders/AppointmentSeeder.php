<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        $services = Service::all();
        $admin = User::where('role', 'admin')->first();

        if ($patients->isEmpty() || $doctors->isEmpty() || $services->isEmpty() || ! $admin) {
            return;
        }

        // نمط زمني متنوع لكل طبيب: مواعيد فايتة (مكتملة/ملغية) ومواعيد جاية (مؤكدة/قيد الانتظار)
        $pattern = [
            ['offset' => -6, 'start' => '09:00', 'end' => '09:30', 'status' => 'completed'],
            ['offset' => -4, 'start' => '11:00', 'end' => '11:30', 'status' => 'completed'],
            ['offset' => -2, 'start' => '13:00', 'end' => '13:30', 'status' => 'cancelled'],
            ['offset' => -1, 'start' => '10:00', 'end' => '10:30', 'status' => 'completed'],
            ['offset' => 0, 'start' => '16:00', 'end' => '16:30', 'status' => 'confirmed'],
            ['offset' => 1, 'start' => '09:30', 'end' => '10:00', 'status' => 'confirmed'],
            ['offset' => 2, 'start' => '12:00', 'end' => '12:30', 'status' => 'pending'],
            ['offset' => 4, 'start' => '14:00', 'end' => '14:30', 'status' => 'pending'],
        ];

        $cancellationReasons = [
            'تعارض في موعد المريض.',
            'طلب المريض تأجيل الموعد.',
            'ظرف طارئ للطبيب.',
        ];

        $patientIndex = 0;

        foreach ($doctors as $doctorIndex => $doctor) {
            foreach ($pattern as $i => $slot) {
                $patient = $patients[$patientIndex % $patients->count()];
                $service = $services[($doctorIndex + $i) % $services->count()];
                $patientIndex++;

                Appointment::firstOrCreate(
                    [
                        'doctor_id' => $doctor->id,
                        'patient_id' => $patient->id,
                        'appointment_date' => now()->addDays($slot['offset'])->toDateString(),
                        'start_time' => $slot['start'],
                    ],
                    [
                        'service_id' => $service->id,
                        'end_time' => $slot['end'],
                        'price' => $service->price,
                        'status' => $slot['status'],
                        'cancellation_reason' => $slot['status'] === 'cancelled'
                            ? $cancellationReasons[$i % count($cancellationReasons)]
                            : null,
                        'created_by' => $admin->id,
                    ]
                );
            }
        }
    }
}
