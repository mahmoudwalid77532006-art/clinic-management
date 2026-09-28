<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'department_id',
        'price',
        'duration_minutes',
        'description',
        'is_active',
    ];
    public function appointments()
{
    return $this->hasMany(Appointment::class);
}
public function doctors()
{
    return $this->belongsToMany(Doctor::class);
}
public function department()
{
    return $this->belongsTo(Department::class);
}
}