<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Visit;

class Patient extends Model
{
    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'date_of_birth',
        'address',
        'gender'
    ];
    public function user()
    {
        return $this->BelongsTo(User::class);
    }
   public function appointments()
{
    return $this->hasMany(Appointment::class);
}
    public function visits()
{
    return $this->hasMany(Visit::class);
}
}