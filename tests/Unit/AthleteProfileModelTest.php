<?php

namespace Tests\Unit;

use App\Models\AthleteProfile;
use App\Models\Award;
use App\Models\Highlight;
use App\Models\SeasonStat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AthleteProfileModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function athlete_profile_has_season_stats_relationship()
    {
        $profile = AthleteProfile::factory()->create();
        $stat = SeasonStat::factory()->create([
            'athlete_profile_id' => $profile->id,
        ]);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $profile->seasonStats);
        $this->assertTrue($profile->seasonStats->contains($stat));
    }

    #[Test]
    public function athlete_profile_has_highlights_relationship()
    {
        $profile = AthleteProfile::factory()->create();
        $highlight = Highlight::factory()->create([
            'athlete_profile_id' => $profile->id,
        ]);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $profile->highlights);
        $this->assertTrue($profile->highlights->contains($highlight));
    }

    #[Test]
    public function athlete_profile_has_awards_relationship()
    {
        $profile = AthleteProfile::factory()->create();
        $award = Award::factory()->create([
            'athlete_profile_id' => $profile->id,
        ]);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $profile->awards);
        $this->assertTrue($profile->awards->contains($award));
    }

    #[Test]
    public function athlete_profile_casts_social_links_to_array()
    {
        $profile = AthleteProfile::factory()->create([
            'social_links' => [
                'facebook' => 'https://facebook.com/athlete',
                'twitter' => 'https://twitter.com/athlete',
            ],
        ]);

        $this->assertIsArray($profile->social_links);
        $this->assertEquals('https://facebook.com/athlete', $profile->social_links['facebook']);
    }

    #[Test]
    public function athlete_profile_casts_is_active_to_boolean()
    {
        $profile = AthleteProfile::factory()->create([
            'is_active' => true,
        ]);

        $this->assertIsBool($profile->is_active);
        $this->assertTrue($profile->is_active);
    }

    #[Test]
    public function athlete_profile_casts_gpa_to_decimal()
    {
        $profile = AthleteProfile::factory()->create([
            'gpa' => 3.75,
        ]);

        $this->assertEquals('3.75', $profile->gpa);
    }
    
    #[Test]
    public function athlete_profile_has_football_profile_relationship()
    {
        $profile = AthleteProfile::factory()->create(['sport' => 'football']);
        
        $this->assertNotNull($profile->footballProfile);
        $this->assertInstanceOf(\App\Models\FootballProfile::class, $profile->footballProfile);
    }
    
    #[Test]
    public function athlete_profile_has_basketball_profile_relationship()
    {
        $profile = AthleteProfile::factory()->basketball()->create();
        
        $this->assertNotNull($profile->basketballProfile);
        $this->assertInstanceOf(\App\Models\BasketballProfile::class, $profile->basketballProfile);
    }
    
    #[Test]
    public function athlete_profile_sport_profile_helper_returns_correct_profile()
    {
        $footballProfile = AthleteProfile::factory()->create(['sport' => 'football']);
        $basketballProfile = AthleteProfile::factory()->basketball()->create();
        
        $this->assertInstanceOf(\App\Models\FootballProfile::class, $footballProfile->sportProfile());
        $this->assertInstanceOf(\App\Models\BasketballProfile::class, $basketballProfile->sportProfile());
    }

    #[Test]
    public function athlete_profile_clears_cache_on_save()
    {
        $profile = AthleteProfile::factory()->create(['is_active' => true]);

        // Cache should exist
        \Cache::put('active_athlete_profile', $profile, 3600);
        $this->assertTrue(\Cache::has('active_athlete_profile'));

        // Update profile
        $profile->update(['name' => 'Updated Name']);

        // Cache should be cleared
        $this->assertFalse(\Cache::has('active_athlete_profile'));
    }

    #[Test]
    public function athlete_profile_clears_cache_on_delete()
    {
        $profile = AthleteProfile::factory()->create(['is_active' => true]);

        // Cache should exist
        \Cache::put('active_athlete_profile', $profile, 3600);
        $this->assertTrue(\Cache::has('active_athlete_profile'));

        // Delete profile
        $profile->delete();

        // Cache should be cleared
        $this->assertFalse(\Cache::has('active_athlete_profile'));
    }

    #[Test]
    public function athlete_profile_defaults_to_football_sport()
    {
        $profile = AthleteProfile::factory()->create([
            'sport' => 'football',
        ]);

        $this->assertEquals('football', $profile->sport);
    }

    #[Test]
    public function athlete_profile_supports_multiple_sports()
    {
        $basketball = AthleteProfile::factory()->basketball()->create();
        $baseball = AthleteProfile::factory()->baseball()->create();

        $this->assertEquals('basketball', $basketball->sport);
        $this->assertEquals('baseball', $baseball->sport);
    }
}
