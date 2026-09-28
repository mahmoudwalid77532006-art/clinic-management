<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Doctor;


class DoctorTimeOff extends Model
{
    protected $fillable = [
        'doctor_id',
        'date',
        'start_time',
        'end_time',
        'reason',
    ];
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}