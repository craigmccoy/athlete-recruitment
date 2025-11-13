<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrackProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'athlete_profile_id',
        'events',
        'personal_records',
        'skills',
    ];

    protected $casts = [
        'personal_records' => 'array',
        'skills' => 'array',
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
