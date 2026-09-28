<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Doctor extends Model
{
    protected $fillable = [
        'user_id',
        'department_id',
        'is_active',
        'specialty',
        'bio',
        'slot_duration_minutes',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function timeoffs()
    {
        return $this->hasMany(DoctorTimeOff::class);
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }
    public function visits()
{
    return $this->hasMany(Visit::class);
}
public function services()
{
    return $this->belongsToMany(Service::class);
}
}