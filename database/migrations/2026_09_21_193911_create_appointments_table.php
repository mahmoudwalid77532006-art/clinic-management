<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('doctors')->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignId('service_id')->constrained('services')->cascadeOnDelete();
            $table->date('appointment_date');
            $table->time('start_time');
            $table->time('end_time');

        $table->decimal('price', 10, 2)
            ->comment('snapshot of service price at booking time');

        $table->enum('status', [
            'pending',
            'confirmed',
            'completed',
            'cancelled',
        ])->default('pending');

        $table->string('cancellation_reason')->nullable();

        $table->foreignId('created_by')
            ->constrained('users')
            ->cascadeOnDelete();


        // Indexes
        $table->index([
            'doctor_id',
            'appointment_date',
            'start_time',
        ]);

        $table->index('patient_id');

        $table->index('status');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};