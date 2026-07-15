<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EventTag extends Model
{
    protected $table = 'event_tags';

    protected $fillable = [
        'name',
        'slug'
    ];

    // Boot method to auto-generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->slug) {
                $model->slug = Str::slug($model->name);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('name')) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_tag', 'event_tag_id', 'event_id');
    }

    public function scopePopular($query, $limit = 10)
    {
        return $query->withCount('events')
                     ->orderBy('events_count', 'desc')
                     ->limit($limit);
    }
}
