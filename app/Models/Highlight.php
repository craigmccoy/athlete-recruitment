<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Highlight extends Model
{
    use HasFactory;
    protected $fillable = [
        'athlete_profile_id',
        'title',
        'description',
        'type',
        'video_url',
        'photo_path',
        'thumbnail_url',
        'duration',
        'order',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        // Clear cache when highlights are updated
        static::saved(function () {
            \Cache::forget('athlete_with_highlights');
        });

        static::deleted(function () {
            \Cache::forget('athlete_with_highlights');
        });
    }

    public function athleteProfile(): BelongsTo
    {
        return $this->belongsTo(AthleteProfile::class);
    }
}
