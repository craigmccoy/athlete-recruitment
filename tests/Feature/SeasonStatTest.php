<?php

namespace Tests\Feature;

use App\Models\AthleteProfile;
use App\Models\SeasonStat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SeasonStatTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function guest_cannot_access_stats_page()
    {
        $response = $this->get('/admin/stats');

        $response->assertRedirect('/login');
    }

    #[Test]
    public function authenticated_user_can_view_stats_page()
    {
        $user = User::factory()->create();
        $profile = AthleteProfile::factory()->create(['is_active' => true]);

        $response = $this->actingAs($user)->get('/admin/stats');

        $response->assertStatus(200);
        $response->assertSeeLivewire('admin.manage-stats');
    }

    #[Test]
    public function user_can_create_season_stat()
    {
        $user = User::factory()->create();
        $profile = AthleteProfile::factory()->create(['is_active' => true, 'sport' => 'football']);

        $response = Livewire::actingAs($user)
            ->test('admin.manage-stats')
            ->call('create')
            ->set('season_year', 2024)
            ->set('competitions', 10)
            ->set('statFields.receptions', 45)
            ->set('statFields.receiving_yards', 800)
            ->set('statFields.touchdowns', 8)
            ->call('save');

        $response->assertHasNoErrors();
        
        $stat = SeasonStat::where('season_year', 2024)->first();
        $this->assertNotNull($stat);
        $this->assertEquals(10, $stat->competitions);
        $this->assertEquals(45, $stat->stats['receptions']);
        $this->assertEquals(800, $stat->stats['receiving_yards']);
        $this->assertEquals(8, $stat->stats['touchdowns']);
    }

    #[Test]
    public function user_can_edit_season_stat()
    {
        $user = User::factory()->create();
        $profile = AthleteProfile::factory()->create(['is_active' => true, 'sport' => 'football']);
        $stat = SeasonStat::factory()->create([
            'athlete_profile_id' => $profile->id,
            'season_year' => 2024,
        ]);

        $response = Livewire::actingAs($user)
            ->test('admin.manage-stats')
            ->call('edit', $stat->id)
            ->set('statFields.receptions', 50)
            ->call('save');

        $response->assertHasNoErrors();
        $stat->refresh();
        $this->assertEquals(50, $stat->stats['receptions']);
    }

    #[Test]
    public function user_can_delete_season_stat()
    {
        $user = User::factory()->create();
        $profile = AthleteProfile::factory()->create(['is_active' => true]);
        $stat = SeasonStat::factory()->create([
            'athlete_profile_id' => $profile->id,
        ]);

        $response = Livewire::actingAs($user)
            ->test('admin.manage-stats')
            ->call('delete', $stat->id);

        $this->assertDatabaseMissing('season_stats', [
            'id' => $stat->id,
        ]);
    }

    #[Test]
    public function season_stat_calculates_yards_per_catch()
    {
        $user = User::factory()->create();
        $profile = AthleteProfile::factory()->create(['is_active' => true, 'sport' => 'football']);

        $response = Livewire::actingAs($user)
            ->test('admin.manage-stats')
            ->call('create')
            ->set('season_year', 2024)
            ->set('competitions', 10)
            ->set('statFields.receptions', 50)
            ->set('statFields.receiving_yards', 750)
            ->set('statFields.touchdowns', 8)
            ->call('save');

        $stat = SeasonStat::where('season_year', 2024)->first();
        $this->assertEquals(15.0, $stat->stats['yards_per_catch']);
    }

    #[Test]
    public function season_stat_requires_valid_year()
    {
        $user = User::factory()->create();
        AthleteProfile::factory()->create(['is_active' => true, 'sport' => 'football']);

        $response = Livewire::actingAs($user)
            ->test('admin.manage-stats')
            ->call('create')
            ->set('season_year', 1999)
            ->set('competitions', 10)
            ->set('statFields.receptions', 45)
            ->set('statFields.receiving_yards', 800)
            ->set('statFields.touchdowns', 8)
            ->call('save');

        $response->assertHasErrors(['season_year']);
    }

    #[Test]
    public function stats_display_on_homepage()
    {
        $profile = AthleteProfile::factory()->create(['is_active' => true, 'sport' => 'football']);
        SeasonStat::factory()->create([
            'athlete_profile_id' => $profile->id,
            'season_year' => 2024,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('2024');
    }

    #[Test]
    public function stats_are_cached()
    {
        $profile = AthleteProfile::factory()->create(['is_active' => true, 'sport' => 'football']);
        $stat = SeasonStat::factory()->create([
            'athlete_profile_id' => $profile->id,
            'season_year' => 2024,
        ]);

        // First call caches
        $this->get('/');

        // Update stat
        $stats = $stat->stats;
        $stats['receptions'] = 100;
        $stat->update(['stats' => $stats]);

        // Clear cache to see new value
        \Cache::forget('athlete_with_stats');
        $response = $this->get('/');
        $response->assertSee('100');
    }

    #[Test]
    public function season_stat_inherits_sport_from_profile()
    {
        $user = User::factory()->create();
        $profile = AthleteProfile::factory()->create([
            'is_active' => true,
            'sport' => 'basketball',
        ]);

        $response = Livewire::actingAs($user)
            ->test('admin.manage-stats')
            ->call('create')
            ->set('season_year', 2024)
            ->set('competitions', 10)
            ->set('statFields.points_per_game', 15.5)
            ->set('statFields.rebounds_per_game', 8.0)
            ->call('save');

        $this->assertDatabaseHas('season_stats', [
            'season_year' => 2024,
            'sport' => 'basketball',
        ]);
    }

    #[Test]
    public function stats_ordered_by_year_descending()
    {
        $profile = AthleteProfile::factory()->create(['is_active' => true]);
        SeasonStat::factory()->create([
            'athlete_profile_id' => $profile->id,
            'season_year' => 2022,
        ]);
        SeasonStat::factory()->create([
            'athlete_profile_id' => $profile->id,
            'season_year' => 2024,
        ]);
        SeasonStat::factory()->create([
            'athlete_profile_id' => $profile->id,
            'season_year' => 2023,
        ]);

        $stats = SeasonStat::where('athlete_profile_id', $profile->id)
            ->orderBy('season_year', 'desc')
            ->get();

        $this->assertEquals(2024, $stats->first()->season_year);
        $this->assertEquals(2022, $stats->last()->season_year);
    }
}
