<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    // To protect against mass assignment vulnerabilities, specify the fillable fields
    protected $fillable = [
        'user_id',
        'name',
        'services',
        'date',
        'time',
        'therapist',
        'amount',
        'quantity',
        'duration',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
