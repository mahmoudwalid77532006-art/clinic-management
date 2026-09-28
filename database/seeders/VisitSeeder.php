<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Visit;
use Illuminate\Database\Seeder;

class VisitSeeder extends Seeder
{
    public function run(): void
    {
        $completedAppointments = Appointment::where('status', 'completed')->get();

        $notes = [
            ['diagnosis' => 'التهاب بسيط في الحلق مع ارتفاع طفيف في الحرارة.', 'notes' => 'نصحته بالراحة وشرب سوائل دافئة، ومتابعة بعد أسبوع لو الأعراض استمرت.'],
            ['diagnosis' => 'إجهاد عضلي في أسفل الظهر.', 'notes' => 'تم عمل أشعة، ومفيش كسور. جلسات علاج طبيعي متابعة.'],
            ['diagnosis' => 'ارتفاع بسيط في ضغط الدم.', 'notes' => 'تم ضبط الجرعة الدوائية ومتابعة القياس المنزلي أسبوعيًا.'],
            ['diagnosis' => 'حساسية جلدية موسمية.', 'notes' => 'وصفت كريم موضعي ومضاد هيستامين، مع تجنب المهيجات.'],
            ['diagnosis' => 'نزلة برد مع سعال جاف.', 'notes' => 'أدوية أعراض لمدة 5 أيام، ومتابعة لو استمر السعال.'],
            ['diagnosis' => 'التهاب بالجيوب الأنفية.', 'notes' => 'كورس مضاد حيوي قصير مع غسول أنفي، ومتابعة بعد أسبوعين.'],
            ['diagnosis' => 'فقر دم بسيط.', 'notes' => 'مكملات حديد وفيتامينات مع إعادة تحليل الدم بعد شهر.'],
            ['diagnosis' => 'قلق ووتر نفسي مرتبط بضغط العمل.', 'notes' => 'جلسات متابعة أسبوعية وتمارين استرخاء، مع تقييم لاحق.'],
        ];

        foreach ($completedAppointments as $i => $appointment) {
            Visit::firstOrCreate(
                ['appointment_id' => $appointment->id],
                [
                    'patient_id' => $appointment->patient_id,
                    'doctor_id' => $appointment->doctor_id,
                    'diagnosis' => $notes[$i % count($notes)]['diagnosis'],
                    'notes' => $notes[$i % count($notes)]['notes'],
                ]
            );
        }
    }
}
