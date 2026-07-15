<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'event_time',
        'location',
        'featured_image',
        'is_published',
        'status',
        'category_id',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_published' => 'boolean',
    ];

    // Status constants
    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_COMPLETED = 'completed';

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(EventTag::class, 'event_tag', 'event_id', 'event_tag_id');
    }

    public function attachments()
    {
        return $this->hasMany(EventAttachment::class);
    }

    public function featuredImage()
    {
        return $this->hasOne(EventAttachment::class)->where('is_featured', true);
    }

    public function activityLogs()
    {
        return $this->hasMany(EventActivityLog::class);
    }

    public function reminders()
    {
        return $this->hasMany(EventReminder::class);
    }

    // Accessor for event_time to handle time formatting
    public function getEventTimeAttribute($value)
    {
        if (!$value) {
            return null;
        }
        
        // Parse the time value if it's in HH:MM:SS format
        if (preg_match('/^\d{2}:\d{2}:\d{2}$/', $value)) {
            return Carbon::createFromTimeString($value);
        }
        
        return Carbon::parse($value);
    }

    // Query scopes for filtering and searching
    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%')
              ->orWhere('description', 'like', '%' . $search . '%')
              ->orWhere('location', 'like', '%' . $search . '%');
        });
    }

    public function scopeByStatus($query, $status)
    {
        if (!$status) {
            return $query;
        }

        return $query->where('status', $status);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('event_date', [$startDate, $endDate]);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now()->toDateString())
                     ->where('status', '!=', self::STATUS_CANCELLED)
                     ->orderBy('event_date');
    }

    public function scopePast($query)
    {
        return $query->where('event_date', '<', now()->toDateString());
    }

    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    public function scopeDrafts($query)
    {
        return $query->where('status', self::STATUS_DRAFT);
    }

    /**
     * Get the featured image URL
     */
    public function getFeaturedImageUrlAttribute()
    {
        return $this->featured_image ? asset($this->featured_image) : asset('img/default-event.jpg');
    }

    /**
     * Check if event has a featured image
     */
    public function hasFeaturedImage()
    {
        return !empty($this->featured_image);
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Delete featured image when event is deleted
        static::deleting(function ($event) {
            if ($event->featured_image) {
                $fullPath = public_path($event->featured_image);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }
        });
    }
}