<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\Service;
use App\Models\User;
use App\Models\Visit;

class DoctorDemoDataService
{
    /**
     * يولّد مواعيد وزيارات وروشتات تجريبية واقعية لدكتور معيّن.
     * آمن يتنادى أكتر من مرة على نفس الدكتور (مش بيكرر بيانات) بفضل firstOrCreate.
     *
     * @return array{appointments:int, visits:int, prescriptions:int}
     */
    public function generateFor(Doctor $doctor): array
    {
        $patients = Patient::all();
        $services = Service::all();
        $admin = User::where('role', 'admin')->first();

        if ($patients->isEmpty() || $services->isEmpty() || ! $admin) {
            // النظام لسه مفيهوش بيانات أساسية (مرضى/خدمات/أدمن)؛ متعملش حاجة.
            return ['appointments' => 0, 'visits' => 0, 'prescriptions' => 0];
        }

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

        $diagnoses = [
            ['diagnosis' => 'التهاب بسيط في الحلق مع ارتفاع طفيف في الحرارة.', 'notes' => 'نصحته بالراحة وشرب سوائل دافئة، ومتابعة بعد أسبوع لو الأعراض استمرت.'],
            ['diagnosis' => 'إجهاد عضلي في أسفل الظهر.', 'notes' => 'تم عمل أشعة، ومفيش كسور. جلسات علاج طبيعي متابعة.'],
            ['diagnosis' => 'ارتفاع بسيط في ضغط الدم.', 'notes' => 'تم ضبط الجرعة الدوائية ومتابعة القياس المنزلي أسبوعيًا.'],
        ];

        $medications = [
            ['medication_name' => 'باراسيتامول', 'dosage' => '500 مج', 'frequency' => '3 مرات يوميًا', 'duration' => '5 أيام', 'instructions' => 'يُؤخذ بعد الأكل مباشرة.'],
            ['medication_name' => 'إيبوبروفين', 'dosage' => '400 مج', 'frequency' => 'مرتين يوميًا', 'duration' => '7 أيام', 'instructions' => 'يُفضّل عدم تناوله على معدة فارغة.'],
            ['medication_name' => 'أوميبرازول', 'dosage' => '20 مج', 'frequency' => 'مرة يوميًا', 'duration' => '14 يوم', 'instructions' => 'يُؤخذ قبل الإفطار بنصف ساعة.'],
            ['medication_name' => 'فيتامين د3', 'dosage' => '1000 وحدة', 'frequency' => 'مرة يوميًا', 'duration' => 'شهر', 'instructions' => 'يُفضّل تناوله مع وجبة تحتوي على دهون.'],
        ];

        $counts = ['appointments' => 0, 'visits' => 0, 'prescriptions' => 0];

        foreach ($pattern as $i => $slot) {
            $patient = $patients[$i % $patients->count()];
            $service = $services[$i % $services->count()];

            $appointment = Appointment::firstOrCreate(
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

            if ($appointment->wasRecentlyCreated) {
                $counts['appointments']++;
            }

            if ($slot['status'] !== 'completed') {
                continue;
            }

            $note = $diagnoses[$i % count($diagnoses)];

            $visit = Visit::firstOrCreate(
                ['appointment_id' => $appointment->id],
                [
                    'patient_id' => $appointment->patient_id,
                    'doctor_id' => $appointment->doctor_id,
                    'diagnosis' => $note['diagnosis'],
                    'notes' => $note['notes'],
                ]
            );

            if ($visit->wasRecentlyCreated) {
                $counts['visits']++;
            }

            $first = $medications[$i % count($medications)];
            $second = $medications[($i + 2) % count($medications)];

            foreach (array_unique([$first['medication_name'], $second['medication_name']]) as $medName) {
                $medData = $medName === $first['medication_name'] ? $first : $second;

                $prescription = Prescription::firstOrCreate(
                    ['visit_id' => $visit->id, 'medication_name' => $medName],
                    $medData
                );

                if ($prescription->wasRecentlyCreated) {
                    $counts['prescriptions']++;
                }
            }
        }

        return $counts;
    }
}
