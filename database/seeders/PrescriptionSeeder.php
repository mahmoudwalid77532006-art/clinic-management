<?php

namespace Database\Seeders;

use App\Models\Prescription;
use App\Models\Visit;
use Illuminate\Database\Seeder;

class PrescriptionSeeder extends Seeder
{
    public function run(): void
    {
        $visits = Visit::all();

        $medications = [
            ['medication_name' => 'باراسيتامول', 'dosage' => '500 مج', 'frequency' => '3 مرات يوميًا', 'duration' => '5 أيام', 'instructions' => 'يُؤخذ بعد الأكل مباشرة.'],
            ['medication_name' => 'إيبوبروفين', 'dosage' => '400 مج', 'frequency' => 'مرتين يوميًا', 'duration' => '7 أيام', 'instructions' => 'يُفضّل عدم تناوله على معدة فارغة.'],
            ['medication_name' => 'أموكسيسيلين', 'dosage' => '500 مج', 'frequency' => '3 مرات يوميًا', 'duration' => '7 أيام', 'instructions' => 'يُكمل الكورس كاملًا حتى لو تحسنت الأعراض.'],
            ['medication_name' => 'لوراتادين', 'dosage' => '10 مج', 'frequency' => 'مرة يوميًا', 'duration' => '10 أيام', 'instructions' => 'يُفضّل تناوله مساءً لتجنب النعاس.'],
            ['medication_name' => 'أوميبرازول', 'dosage' => '20 مج', 'frequency' => 'مرة يوميًا', 'duration' => '14 يوم', 'instructions' => 'يُؤخذ قبل الإفطار بنصف ساعة.'],
            ['medication_name' => 'فيتامين د3', 'dosage' => '1000 وحدة', 'frequency' => 'مرة يوميًا', 'duration' => 'شهر', 'instructions' => 'يُفضّل تناوله مع وجبة تحتوي على دهون.'],
            ['medication_name' => 'مكمل حديد', 'dosage' => '65 مج', 'frequency' => 'مرة يوميًا', 'duration' => 'شهر', 'instructions' => 'يُؤخذ مع عصير برتقال لتحسين الامتصاص.'],
            ['medication_name' => 'كريم موضعي مضاد للحساسية', 'dosage' => 'طبقة رقيقة', 'frequency' => 'مرتين يوميًا', 'duration' => '10 أيام', 'instructions' => 'يوضع على مكان الحساسية بعد التنظيف الجيد.'],
            ['medication_name' => 'أدفيل كولد آند سينوس', 'dosage' => 'قرص واحد', 'frequency' => 'كل 8 ساعات', 'duration' => '5 أيام', 'instructions' => 'لا يُستخدم مع أدوية أخرى لنزلات البرد.'],
            ['medication_name' => 'مضاد هيستامين', 'dosage' => '10 مج', 'frequency' => 'مرة يوميًا عند اللزوم', 'duration' => 'حسب الحاجة', 'instructions' => 'تجنب القيادة بعد تناوله مباشرة.'],
        ];

        foreach ($visits as $i => $visit) {
            // كل زيارة تاخد دوائين مختلفين غالبًا لواقعية أكبر
            $first = $medications[$i % count($medications)];
            $second = $medications[($i + 3) % count($medications)];

            Prescription::firstOrCreate(
                ['visit_id' => $visit->id, 'medication_name' => $first['medication_name']],
                $first
            );

            if ($second['medication_name'] !== $first['medication_name']) {
                Prescription::firstOrCreate(
                    ['visit_id' => $visit->id, 'medication_name' => $second['medication_name']],
                    $second
                );
            }
        }
    }
}
