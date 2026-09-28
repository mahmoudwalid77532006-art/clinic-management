<?php

namespace App\Console\Commands;

use App\Models\Doctor;
use App\Models\User;
use App\Services\DoctorDemoDataService;
use Illuminate\Console\Command;

class SeedDoctorDemoData extends Command
{
    /**
     * php artisan clinic:seed-doctor {email}
     * لو الإيميل مش موجود، الأمر هيسألك تختاره من قايمة الأطباء.
     */
    protected $signature = 'clinic:seed-doctor {email? : إيميل الدكتور اللي عايز تولّد له بيانات تجريبية}';

    protected $description = 'يولّد مواعيد وزيارات وروشتات تجريبية لدكتور معيّن (مفيد لأي دكتور اتسجل جديد بعد الـ seeding الأساسي)';

    public function handle(DoctorDemoDataService $demoData): int
    {
        $email = $this->argument('email');

        if (! $email) {
            $doctorEmails = User::where('role', 'doctor')->pluck('email', 'id');

            if ($doctorEmails->isEmpty()) {
                $this->error('مفيش أي حساب دكتور مسجل في النظام لسه.');
                return self::FAILURE;
            }

            $email = $this->choice('اختار الدكتور اللي عايز تولّد له بيانات', $doctorEmails->values()->all());
        }

        $user = User::where('email', $email)->where('role', 'doctor')->first();

        if (! $user) {
            $this->error("مفيش حساب دكتور بالإيميل ده: {$email}");
            return self::FAILURE;
        }

        $doctor = Doctor::where('user_id', $user->id)->first();

        if (! $doctor) {
            $this->error('الحساب ده مسجل كدكتور لكن مفيش صف Doctor مرتبط بيه.');
            return self::FAILURE;
        }

        $counts = $demoData->generateFor($doctor);

        if (array_sum($counts) === 0) {
            $this->warn('كل البيانات كانت موجودة بالفعل، أو مفيش مرضى/خدمات/أدمن في النظام عشان يتولّد عليهم بيانات.');
            return self::SUCCESS;
        }

        $this->info("تم تجهيز بيانات تجريبية للدكتور: {$user->name} ({$email})");
        $this->line("- مواعيد جديدة: {$counts['appointments']}");
        $this->line("- زيارات جديدة: {$counts['visits']}");
        $this->line("- روشتات جديدة: {$counts['prescriptions']}");

        return self::SUCCESS;
    }
}
