<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            DoctorSeeder::class,
            ServiceSeeder::class,
            DepartmentSeeder::class, // بعد الأطباء والخدمات: بينشئ الأقسام ويربطهم بيها
            PatientSeeder::class,
            AppointmentSeeder::class,
            VisitSeeder::class,
            PrescriptionSeeder::class,
        ]);
    }
}
