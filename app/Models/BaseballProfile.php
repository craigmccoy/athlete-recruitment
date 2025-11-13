<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BaseballProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'athlete_profile_id',
        'position',
        'jersey_number',
        'sixty_yard_dash',
        'exit_velocity',
        'batting_stance',
        'throwing_hand',
        'skills',
    ];

    protected $casts = [
        'skills' => 'array',
        'sixty_yard_dash' => 'decimal:2',
        'exit_velocity' => 'decimal:1',
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
