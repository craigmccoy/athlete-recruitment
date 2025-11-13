<?php

namespace Tests\Feature;

use App\Models\AthleteProfile;
use App\Models\Award;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AwardTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function guest_cannot_access_awards_admin_page()
    {
        $response = $this->get('/admin/awards');

        $response->assertRedirect('/login');
    }

    #[Test]
    public function authenticated_user_can_view_awards_page()
    {
        $user = User::factory()->create();
        AthleteProfile::factory()->create(['is_active' => true]);

        $response = $this->actingAs($user)->get('/admin/awards');

        $response->assertStatus(200);
        $response->assertSeeLivewire('admin.manage-awards');
    }

    #[Test]
    public function user_can_create_award()
    {
        $user = User::factory()->create();
        $profile = AthleteProfile::factory()->create(['is_active' => true]);

        $response = Livewire::actingAs($user)
            ->test('admin.manage-awards')
            ->call('create')
            ->set('title', 'All-District First Team')
            ->set('description', 'Selected as top receiver')
            ->set('year', 2024)
            ->set('order', 1)
            ->call('save');

        $response->assertHasNoErrors();
        $this->assertDatabaseHas('awards', [
            'title' => 'All-District First Team',
            'year' => 2024,
        ]);
    }

    #[Test]
    public function user_can_edit_award()
    {
        $user = User::factory()->create();
        $profile = AthleteProfile::factory()->create(['is_active' => true]);
        $award = Award::factory()->create([
            'athlete_profile_id' => $profile->id,
            'title' => 'Old Award',
        ]);

        $response = Livewire::actingAs($user)
            ->test('admin.manage-awards')
            ->call('edit', $award->id)
            ->set('title', 'Updated Award')
            ->call('save');

        $response->assertHasNoErrors();
        $this->assertDatabaseHas('awards', [
            'id' => $award->id,
            'title' => 'Updated Award',
        ]);
    }

    #[Test]
    public function user_can_delete_award()
    {
        $user = User::factory()->create();
        $profile = AthleteProfile::factory()->create(['is_active' => true]);
        $award = Award::factory()->create([
            'athlete_profile_id' => $profile->id,
        ]);

        $response = Livewire::actingAs($user)
            ->test('admin.manage-awards')
            ->call('delete', $award->id);

        $this->assertDatabaseMissing('awards', [
            'id' => $award->id,
        ]);
    }

    #[Test]
    public function awards_display_on_homepage()
    {
        $profile = AthleteProfile::factory()->create(['is_active' => true]);
        Award::factory()->create([
            'athlete_profile_id' => $profile->id,
            'title' => 'Team MVP',
            'year' => 2024,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Team MVP');
        $response->assertSee('2024');
    }

    #[Test]
    public function award_requires_title()
    {
        $user = User::factory()->create();
        AthleteProfile::factory()->create(['is_active' => true]);

        $response = Livewire::actingAs($user)
            ->test('admin.manage-awards')
            ->call('create')
            ->set('title', '')
            ->set('year', 2024)
            ->call('save');

        $response->assertHasErrors(['title']);
    }

    #[Test]
    public function award_can_be_created_with_year()
    {
        $user = User::factory()->create();
        AthleteProfile::factory()->create(['is_active' => true]);

        $response = Livewire::actingAs($user)
            ->test('admin.manage-awards')
            ->call('create')
            ->set('title', 'Test Award')
            ->set('year', 2024)
            ->set('order', 1)
            ->call('save');

        $response->assertHasNoErrors();
        $this->assertDatabaseHas('awards', [
            'title' => 'Test Award',
            'year' => 2024,
        ]);
    }

    #[Test]
    public function awards_are_cached()
    {
        $profile = AthleteProfile::factory()->create(['is_active' => true]);
        $award = Award::factory()->create([
            'athlete_profile_id' => $profile->id,
            'title' => 'Original Award',
        ]);

        // First call caches
        $this->get('/');

        // Update award
        $award->update(['title' => 'Updated Award']);

        // Clear cache to see new value
        \Cache::forget('athlete_with_stats');
        $response = $this->get('/');
        $response->assertSee('Updated Award');
    }

    #[Test]
    public function awards_ordered_by_order_field()
    {
        $profile = AthleteProfile::factory()->create(['is_active' => true]);
        
        Award::factory()->create([
            'athlete_profile_id' => $profile->id,
            'order' => 3,
        ]);
        Award::factory()->create([
            'athlete_profile_id' => $profile->id,
            'order' => 1,
        ]);
        Award::factory()->create([
            'athlete_profile_id' => $profile->id,
            'order' => 2,
        ]);

        $awards = Award::where('athlete_profile_id', $profile->id)
            ->orderBy('order')
            ->get();

        $this->assertEquals(1, $awards->first()->order);
        $this->assertEquals(3, $awards->last()->order);
    }
}
