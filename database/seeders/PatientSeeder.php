<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $patients = [
            ['name' => 'خالد يوسف', 'email' => 'patient1@clinic.test', 'phone' => '01000000001', 'dob' => '1995-04-12', 'address' => 'الزقازيق، الشرقية', 'gender' => 'male'],
            ['name' => 'ياسمين علي', 'email' => 'patient2@clinic.test', 'phone' => '01000000002', 'dob' => '1998-09-03', 'address' => 'القاهرة، مصر الجديدة', 'gender' => 'female'],
            ['name' => 'محمد سعيد', 'email' => 'patient3@clinic.test', 'phone' => '01000000003', 'dob' => '1990-01-20', 'address' => 'المنصورة، الدقهلية', 'gender' => 'male'],
            ['name' => 'نور الهدى طارق', 'email' => 'patient4@clinic.test', 'phone' => '01000000004', 'dob' => '2001-07-15', 'address' => 'الزقازيق، الشرقية', 'gender' => 'female'],
            ['name' => 'عمر فاروق', 'email' => 'patient5@clinic.test', 'phone' => '01000000005', 'dob' => '1988-11-02', 'address' => 'الإسماعيلية', 'gender' => 'male'],
            ['name' => 'سلمى وائل', 'email' => 'patient6@clinic.test', 'phone' => '01000000006', 'dob' => '1993-06-27', 'address' => 'القاهرة، مدينة نصر', 'gender' => 'female'],
        ];

        foreach ($patients as $p) {
            $user = User::firstOrCreate(
                ['email' => $p['email']],
                ['name' => $p['name'], 'password' => 'password', 'role' => 'patient']
            );

            Patient::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'full_name' => $p['name'],
                    'phone' => $p['phone'],
                    'date_of_birth' => $p['dob'],
                    'address' => $p['address'],
                    'gender' => $p['gender'],
                ]
            );
        }
    }
}
