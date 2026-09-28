<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'service_id',
        'appointment_date',
        'start_time',
        'end_time',
        'price',
        'status',
        'cancellation_reason',
        'created_by',
    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function visit()
{
    return $this->hasOne(Visit::class);
}

}