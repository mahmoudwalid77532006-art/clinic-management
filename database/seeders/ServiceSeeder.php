<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'كشف عام', 'description' => 'كشف طبي عام لتقييم الحالة الصحية.', 'price' => 150, 'duration_minutes' => 30],
            ['name' => 'كشف أطفال', 'description' => 'كشف متابعة نمو وتطعيمات الأطفال.', 'price' => 180, 'duration_minutes' => 30],
            ['name' => 'كشف عظام', 'description' => 'تقييم إصابات وآلام العظام والمفاصل.', 'price' => 250, 'duration_minutes' => 45],
            ['name' => 'كشف جلدية', 'description' => 'تشخيص وعلاج الأمراض الجلدية.', 'price' => 200, 'duration_minutes' => 30],
            ['name' => 'أشعة تشخيصية', 'description' => 'أشعة عادية لتشخيص الحالة.', 'price' => 300, 'duration_minutes' => 20],
            ['name' => 'تحاليل دم شاملة', 'description' => 'باقة تحاليل دم شاملة.', 'price' => 350, 'duration_minutes' => 15],
            ['name' => 'كشف قلب وأوعية دموية', 'description' => 'تقييم القلب والدورة الدموية مع رسم قلب.', 'price' => 280, 'duration_minutes' => 30],
            ['name' => 'كشف أنف وأذن وحنجرة', 'description' => 'تشخيص وعلاج مشاكل الأنف والأذن والحنجرة.', 'price' => 220, 'duration_minutes' => 30],
            ['name' => 'كشف نساء وتوليد', 'description' => 'متابعة الحمل وكشف أمراض النساء.', 'price' => 260, 'duration_minutes' => 30],
            ['name' => 'كشف عيون', 'description' => 'فحص شامل للعين وقياس النظر.', 'price' => 230, 'duration_minutes' => 25],
            ['name' => 'استشارة تغذية علاجية', 'description' => 'خطة غذائية مخصصة حسب الحالة الصحية.', 'price' => 190, 'duration_minutes' => 40],
            ['name' => 'جلسة علاج طبيعي', 'description' => 'جلسات تأهيل وعلاج طبيعي للإصابات المختلفة.', 'price' => 170, 'duration_minutes' => 45],
            ['name' => 'استشارة نفسية', 'description' => 'جلسة استشارة نفسية فردية مع أخصائي.', 'price' => 240, 'duration_minutes' => 45],
            ['name' => 'رسم قلب كهربائي (ECG)', 'description' => 'رسم كهربية القلب لتشخيص اضطرابات النبض.', 'price' => 120, 'duration_minutes' => 15],
        ];

        foreach ($services as $s) {
            Service::firstOrCreate(
                ['name' => $s['name']],
                array_merge($s, ['is_active' => true])
            );
        }
    }
}
