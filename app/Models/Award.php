<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Award extends Model
{
    use HasFactory;
    protected $fillable = [
        'athlete_profile_id',
        'title',
        'description',
        'year',
        'icon',
        'color',
        'order',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        // Clear cache when awards are updated
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
