<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TherapistDtr extends Model
{
    use HasFactory;

    protected $table = 'therapist_dtr';

    protected $fillable = [
        'user_id',
        'name',
        'date',
        'time_in',
        'time_out',
        'workdescriptions',
        'total_hours',
    ];

    /**
     * Get the user that owns the DTR record.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
