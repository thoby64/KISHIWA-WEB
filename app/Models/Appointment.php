<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'guardian_name',
        'guardian_email',
        'child_name',
        'child_age',
        'message',
        'appointment_date',
        'location',
        'is_confirmed',
        'confirmed_by',
        'confirmed_at'
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
        'is_confirmed' => 'boolean',
        'confirmed_at' => 'datetime',
    ];

    public function confirmer()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }
}