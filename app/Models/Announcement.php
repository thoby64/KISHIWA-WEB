<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'featured_image',
        'is_urgent',
        'is_published',
        'published_at',
        'created_by',
        'updated_by',
        'published_by'
    ];

    protected $casts = [
        'is_urgent' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function publisher()
    {
        return $this->belongsTo(User::class, 'published_by');
    }

    /**
     * Get the featured image URL
     */
    public function getFeaturedImageUrlAttribute()
    {
        return $this->featured_image ? asset($this->featured_image) : asset('img/default-announcement.jpg');
    }

    /**
     * Check if announcement has a featured image
     */
    public function hasFeaturedImage()
    {
        return !empty($this->featured_image);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($announcement) {
            if ($announcement->featured_image) {
                $fullPath = public_path($announcement->featured_image);
                if (file_exists($fullPath)) {
                    @unlink($fullPath);
                }
            }
        });
    }
}