<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'is_read',
        'read_by',
        'read_at',
        'replied_by',
        'replied_at',
        'reply_message'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'replied_at' => 'datetime',
    ];

    public function reader()
    {
        return $this->belongsTo(User::class, 'read_by');
    }

    public function replier()
    {
        return $this->belongsTo(User::class, 'replied_by');
    }
}