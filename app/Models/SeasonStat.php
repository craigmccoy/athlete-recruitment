<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeasonStat extends Model
{
    use HasFactory;
    protected $fillable = [
        'athlete_profile_id',
        'sport',
        'season_year',
        'competitions', // Games, matches, meets, etc.
        'stats', // JSON column for sport-specific stats
        'notes',
    ];

    protected $casts = [
        'stats' => 'array',
    ];

    /**
     * Get a stat value from the stats JSON
     */
    public function __get($key)
    {
        // Check if it's in the stats JSON
        if (isset($this->stats[$key])) {
            return $this->stats[$key];
        }
        
        // Otherwise use default Eloquent behavior
        return parent::__get($key);
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        // Clear cache when stats are updated
        static::saved(function () {
            \Cache::forget('athlete_with_stats');
        });

        static::deleted(function () {
            \Cache::forget('athlete_with_stats');
        });
    }

    public function athleteProfile(): BelongsTo
    {
        return $this->belongsTo(AthleteProfile::class);
    }
}
