<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'athlete_profile_id',
        'author_name',
        'author_title',
        'author_organization',
        'content',
        'relationship',
        'date',
        'author_image',
        'is_featured',
        'is_active',
        'order',
    ];

    protected $casts = [
        'date' => 'date',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    protected static function booted(): void
    {
        // Clear cache when testimonials are updated
        static::saved(function () {
            \Cache::forget('active_athlete_profile');
            \Cache::forget('athlete_with_stats');
        });

        static::deleted(function () {
            \Cache::forget('active_athlete_profile');
            \Cache::forget('athlete_with_stats');
        });
    }

    public function athleteProfile(): BelongsTo
    {
        return $this->belongsTo(AthleteProfile::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('created_at', 'desc');
    }
}
