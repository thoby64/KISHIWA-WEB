<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EventReminder extends Model
{
    protected $fillable = [
        'event_id',
        'reminder_type',
        'minutes_before',
        'scheduled_at',
        'sent_at',
        'is_sent'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'is_sent' => 'boolean',
    ];

    // Reminder type constants
    const TYPE_EMAIL = 'email';
    const TYPE_NOTIFICATION = 'notification';

    /**
     * Get the event that owns the reminder
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Scope for pending reminders
     */
    public function scopePending($query)
    {
        return $query->where('is_sent', false)
                    ->where('scheduled_at', '<=', now());
    }

    /**
     * Scope for unsent reminders
     */
    public function scopeUnsent($query)
    {
        return $query->where('is_sent', false);
    }

    /**
     * Mark reminder as sent
     */
    public function markAsSent()
    {
        $this->update([
            'is_sent' => true,
            'sent_at' => now(),
        ]);
    }

    /**
     * Calculate and set scheduled time based on event time
     */
    public function calculateScheduledTime()
    {
        if ($this->event && $this->event->event_date && $this->event->event_time) {
            $eventDateTime = Carbon::createFromFormat('Y-m-d H:i:s',
                $this->event->event_date->format('Y-m-d') . ' ' . $this->event->event_time->format('H:i:s')
            );

            $this->scheduled_at = $eventDateTime->subMinutes($this->minutes_before);
            $this->save();
        }
    }
}
