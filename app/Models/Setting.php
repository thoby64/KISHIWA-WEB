<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'updated_by'
    ];

    protected $casts = [
        'value' => 'array', // Allow for complex settings values
    ];

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}