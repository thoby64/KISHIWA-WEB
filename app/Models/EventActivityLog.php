<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventActivityLog extends Model
{
    protected $table = 'event_activity_logs';

    protected $fillable = [
        'event_id',
        'user_id',
        'action',
        'old_value',
        'new_value',
        'description',
        'ip_address'
    ];

    // Action constants
    const ACTION_CREATED = 'created';
    const ACTION_UPDATED = 'updated';
    const ACTION_DELETED = 'deleted';
    const ACTION_PUBLISHED = 'published';
    const ACTION_STATUS_CHANGED = 'status_changed';
    const ACTION_ATTACHMENT_ADDED = 'attachment_added';
    const ACTION_ATTACHMENT_REMOVED = 'attachment_removed';

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getActionLabel()
    {
        return match($this->action) {
            self::ACTION_CREATED => 'Created',
            self::ACTION_UPDATED => 'Updated',
            self::ACTION_DELETED => 'Deleted',
            self::ACTION_PUBLISHED => 'Published',
            self::ACTION_STATUS_CHANGED => 'Status Changed',
            self::ACTION_ATTACHMENT_ADDED => 'Attachment Added',
            self::ACTION_ATTACHMENT_REMOVED => 'Attachment Removed',
            default => ucfirst($this->action)
        };
    }

    public function getActionColor()
    {
        return match($this->action) {
            self::ACTION_CREATED => 'success',
            self::ACTION_UPDATED => 'info',
            self::ACTION_DELETED => 'danger',
            self::ACTION_PUBLISHED => 'success',
            self::ACTION_STATUS_CHANGED => 'warning',
            self::ACTION_ATTACHMENT_ADDED => 'info',
            self::ACTION_ATTACHMENT_REMOVED => 'warning',
            default => 'secondary'
        };
    }

    public function scopeRecent($query, $limit = 50)
    {
        return $query->latest()->limit($limit);
    }

    public function scopeForEvent($query, $eventId)
    {
        return $query->where('event_id', $eventId);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }
}
