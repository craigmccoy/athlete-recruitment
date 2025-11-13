<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FootballProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'athlete_profile_id',
        'position',
        'jersey_number',
        'forty_yard_dash',
        'bench_press',
        'squat',
        'vertical_jump',
        'skills',
    ];

    protected $casts = [
        'skills' => 'array',
        'forty_yard_dash' => 'decimal:2',
        'bench_press' => 'decimal:1',
        'squat' => 'decimal:1',
        'vertical_jump' => 'decimal:1',
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
