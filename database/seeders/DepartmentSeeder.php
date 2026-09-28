<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\Service;
use Illuminate\Database\Seeder;

/**
 * بينشئ الأقسام الطبية، وبعدين يربط الأطباء والخدمات الموجودين بيها.
 * لازم يتنفّذ بعد DoctorSeeder و ServiceSeeder (متظبط كده في DatabaseSeeder).
 */
class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        // slug => [الاسم, الأيقونة, الوصف]
        $departments = [
            'باطنة' => ['🫀', 'تشخيص وعلاج أمراض الباطنة والقلب والجهاز الهضمي والصدر.'],
            'أطفال' => ['🧸', 'متابعة نمو الأطفال والتطعيمات وعلاج أمراض الطفولة الشائعة.'],
            'عظام' => ['🦴', 'علاج إصابات وآلام العظام والمفاصل والعمود الفقري وجلسات التأهيل.'],
            'جلدية' => ['✨', 'تشخيص وعلاج الأمراض الجلدية والحساسية والعناية بالبشرة.'],
            'نساء وتوليد' => ['🤰', 'متابعة الحمل والولادة وصحة المرأة في كل مراحلها.'],
            'أنف وأذن وحنجرة' => ['👂', 'تشخيص وعلاج أمراض الأنف والأذن والحنجرة والجيوب الأنفية.'],
            'عيون' => ['👁️', 'فحص النظر وعلاج أمراض العيون بأحدث الأجهزة.'],
            'أشعة وتحاليل' => ['🔬', 'أشعة تشخيصية وتحاليل معملية دقيقة بنتائج سريعة.'],
            'تغذية ودعم نفسي' => ['🥗', 'خطط تغذية علاجية وجلسات دعم واستشارات نفسية.'],
        ];

        $byName = [];
        foreach ($departments as $name => [$icon, $description]) {
            $byName[$name] = Department::firstOrCreate(
                ['name' => $name],
                ['icon' => $icon, 'description' => $description, 'is_active' => true]
            );
        }

        // ربط الأطباء بالقسم حسب التخصص (لو التخصص مطابق لاسم قسم)
        foreach (Doctor::whereNull('department_id')->get() as $doctor) {
            if (isset($byName[$doctor->specialty])) {
                $doctor->update(['department_id' => $byName[$doctor->specialty]->id]);
            }
        }

        // ربط الخدمات بالأقسام حسب اسم الخدمة
        $serviceMap = [
            'كشف عام' => 'باطنة',
            'كشف قلب وأوعية دموية' => 'باطنة',
            'رسم قلب كهربائي (ECG)' => 'باطنة',
            'كشف أطفال' => 'أطفال',
            'كشف عظام' => 'عظام',
            'جلسة علاج طبيعي' => 'عظام',
            'كشف جلدية' => 'جلدية',
            'كشف نساء وتوليد' => 'نساء وتوليد',
            'كشف أنف وأذن وحنجرة' => 'أنف وأذن وحنجرة',
            'كشف عيون' => 'عيون',
            'أشعة تشخيصية' => 'أشعة وتحاليل',
            'تحاليل دم شاملة' => 'أشعة وتحاليل',
            'استشارة تغذية علاجية' => 'تغذية ودعم نفسي',
            'استشارة نفسية' => 'تغذية ودعم نفسي',
        ];

        foreach ($serviceMap as $serviceName => $departmentName) {
            Service::where('name', $serviceName)
                ->whereNull('department_id')
                ->update(['department_id' => $byName[$departmentName]->id]);
        }
    }
}
