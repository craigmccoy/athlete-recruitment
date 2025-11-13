<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BasketballProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'athlete_profile_id',
        'position',
        'jersey_number',
        'vertical_jump',
        'sprint_speed',
        'wingspan',
        'skills',
    ];

    protected $casts = [
        'skills' => 'array',
        'vertical_jump' => 'decimal:1',
        'sprint_speed' => 'decimal:2',
        'wingspan' => 'decimal:1',
    ];

    protected static function booted(): void
    {
        // Clear cache when sport profile is updated
        static::saved(function () {
            \Cache::forget('active_athlete_profile');
            \Cache::forget('athlete_with_stats');
        });
    }

    public function athleteProfile(): BelongsTo
    {
        return $this->belongsTo(AthleteProfile::class);
    }
}
