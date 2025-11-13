<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AthleteProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'sport',
        'graduation_year',
        'school_name',
        'location',
        'height',
        'weight',
        'gpa',
        'email',
        'phone',
        'bio',
        'story',
        'profile_image',
        'social_links',
        'is_active',
    ];

    protected $casts = [
        'social_links' => 'array',
        'is_active' => 'boolean',
        'gpa' => 'decimal:2',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        // Clear cache when athlete profile is updated or deleted
        static::saved(function () {
            \Cache::forget('active_athlete_profile');
            \Cache::forget('athlete_with_stats');
        });

        static::deleted(function () {
            \Cache::forget('active_athlete_profile');
            \Cache::forget('athlete_with_stats');
        });
    }

    public function seasonStats(): HasMany
    {
        return $this->hasMany(SeasonStat::class);
    }

    public function highlights(): HasMany
    {
        return $this->hasMany(Highlight::class);
    }

    public function awards(): HasMany
    {
        return $this->hasMany(Award::class);
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class);
    }

    // Sport-specific profile relationships
    public function footballProfile()
    {
        return $this->hasOne(FootballProfile::class);
    }

    public function basketballProfile()
    {
        return $this->hasOne(BasketballProfile::class);
    }

    public function baseballProfile()
    {
        return $this->hasOne(BaseballProfile::class);
    }

    public function soccerProfile()
    {
        return $this->hasOne(SoccerProfile::class);
    }

    public function trackProfile()
    {
        return $this->hasOne(TrackProfile::class);
    }

    /**
     * Get the sport-specific profile based on the sport type
     */
    public function sportProfile()
    {
        return match($this->sport) {
            'football' => $this->footballProfile,
            'basketball' => $this->basketballProfile,
            'baseball' => $this->baseballProfile,
            'soccer' => $this->soccerProfile,
            'track' => $this->trackProfile,
            default => null,
        };
    }
}
