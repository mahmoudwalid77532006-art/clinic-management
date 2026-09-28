<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = [
            ['name' => 'د. أحمد محمد', 'email' => 'doctor1@clinic.test', 'specialty' => 'باطنة', 'bio' => 'استشاري باطنة بخبرة 12 سنة.'],
            ['name' => 'د. سارة عبد الله', 'email' => 'doctor2@clinic.test', 'specialty' => 'أطفال', 'bio' => 'أخصائية طب أطفال.'],
            ['name' => 'د. محمود حسن', 'email' => 'doctor3@clinic.test', 'specialty' => 'عظام', 'bio' => 'استشاري جراحة عظام.'],
            ['name' => 'د. منى إبراهيم', 'email' => 'doctor4@clinic.test', 'specialty' => 'جلدية', 'bio' => 'أخصائية أمراض جلدية وتجميل.'],
        ];

        foreach ($doctors as $d) {
            $user = User::firstOrCreate(
                ['email' => $d['email']],
                ['name' => $d['name'], 'password' => 'password', 'role' => 'doctor']
            );

            Doctor::firstOrCreate(
                ['user_id' => $user->id],
                ['specialty' => $d['specialty'], 'bio' => $d['bio'], 'is_active' => true, 'slot_duration_minutes' => 30]
            );
        }
    }
}
