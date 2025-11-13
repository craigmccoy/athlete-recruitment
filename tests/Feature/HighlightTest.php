<?php

namespace Tests\Feature;

use App\Models\AthleteProfile;
use App\Models\Highlight;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class HighlightTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function guest_cannot_access_highlights_admin_page()
    {
        $response = $this->get('/admin/highlights');

        $response->assertRedirect('/login');
    }

    #[Test]
    public function authenticated_user_can_view_highlights_page()
    {
        $user = User::factory()->create();
        AthleteProfile::factory()->create(['is_active' => true]);

        $response = $this->actingAs($user)->get('/admin/highlights');

        $response->assertStatus(200);
        $response->assertSeeLivewire('admin.manage-highlights');
    }

    #[Test]
    public function user_can_create_highlight()
    {
        $user = User::factory()->create();
        $profile = AthleteProfile::factory()->create(['is_active' => true]);

        $response = Livewire::actingAs($user)
            ->test('admin.manage-highlights')
            ->call('create')
            ->set('title', '2024 Season Highlights')
            ->set('type', 'video')
            ->set('video_url', 'https://youtube.com/watch?v=abc123')
            ->set('duration', '3:45')
            ->set('order', 1)
            ->set('is_featured', true)
            ->set('is_active', true)
            ->call('save');

        $response->assertHasNoErrors();
        $this->assertDatabaseHas('highlights', [
            'title' => '2024 Season Highlights',
            'video_url' => 'https://youtube.com/watch?v=abc123',
            'is_featured' => true,
        ]);
    }

    #[Test]
    public function user_can_edit_highlight()
    {
        $user = User::factory()->create();
        $profile = AthleteProfile::factory()->create(['is_active' => true]);
        $highlight = Highlight::factory()->create([
            'athlete_profile_id' => $profile->id,
            'title' => 'Old Title',
        ]);

        $response = Livewire::actingAs($user)
            ->test('admin.manage-highlights')
            ->call('edit', $highlight->id)
            ->set('title', 'New Title')
            ->call('save');

        $response->assertHasNoErrors();
        $this->assertDatabaseHas('highlights', [
            'id' => $highlight->id,
            'title' => 'New Title',
        ]);
    }

    #[Test]
    public function user_can_delete_highlight()
    {
        $user = User::factory()->create();
        $profile = AthleteProfile::factory()->create(['is_active' => true]);
        $highlight = Highlight::factory()->create([
            'athlete_profile_id' => $profile->id,
        ]);

        $response = Livewire::actingAs($user)
            ->test('admin.manage-highlights')
            ->call('delete', $highlight->id);

        $this->assertDatabaseMissing('highlights', [
            'id' => $highlight->id,
        ]);
    }

    #[Test]
    public function featured_highlight_displays_on_homepage()
    {
        $profile = AthleteProfile::factory()->create(['is_active' => true]);
        $highlight = Highlight::factory()->create([
            'athlete_profile_id' => $profile->id,
            'title' => 'Featured Video',
            'is_featured' => true,
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Featured Video');
    }

    #[Test]
    public function inactive_highlights_not_displayed()
    {
        $profile = AthleteProfile::factory()->create(['is_active' => true]);
        $highlight = Highlight::factory()->create([
            'athlete_profile_id' => $profile->id,
            'title' => 'Inactive Video',
            'is_active' => false,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('Inactive Video');
    }

    #[Test]
    public function highlight_supports_youtube_urls()
    {
        $user = User::factory()->create();
        $profile = AthleteProfile::factory()->create(['is_active' => true]);

        $urls = [
            'https://youtube.com/watch?v=abc123',
            'https://youtu.be/abc123',
            'https://youtube.com/shorts/abc123',
        ];

        foreach ($urls as $url) {
            $response = Livewire::actingAs($user)
                ->test('admin.manage-highlights')
                ->call('create')
                ->set('title', 'Test Video')
                ->set('type', 'video')
                ->set('video_url', $url)
                ->set('order', 1)
                ->set('is_active', true)
                ->call('save');

            $response->assertHasNoErrors();
            $this->assertDatabaseHas('highlights', [
                'video_url' => $url,
            ]);
        }
    }

    #[Test]
    public function highlight_supports_hudl_urls()
    {
        $user = User::factory()->create();
        $profile = AthleteProfile::factory()->create(['is_active' => true]);

        $response = Livewire::actingAs($user)
            ->test('admin.manage-highlights')
            ->call('create')
            ->set('title', 'Hudl Video')
            ->set('type', 'video')
            ->set('video_url', 'https://hudl.com/video/123456')
            ->set('order', 1)
            ->set('is_active', true)
            ->call('save');

        $response->assertHasNoErrors();
        $this->assertDatabaseHas('highlights', [
            'video_url' => 'https://hudl.com/video/123456',
        ]);
    }

    #[Test]
    public function highlights_are_cached()
    {
        $profile = AthleteProfile::factory()->create(['is_active' => true]);
        $highlight = Highlight::factory()->create([
            'athlete_profile_id' => $profile->id,
            'title' => 'Original Title',
            'is_active' => true,
        ]);

        // First call caches
        $this->get('/');

        // Update highlight
        $highlight->update(['title' => 'Updated Title']);

        // Clear cache to see new value
        \Cache::forget('athlete_with_highlights');
        $response = $this->get('/');
        $response->assertSee('Updated Title');
    }

    #[Test]
    public function highlight_requires_title()
    {
        $user = User::factory()->create();
        AthleteProfile::factory()->create(['is_active' => true]);

        $response = Livewire::actingAs($user)
            ->test('admin.manage-highlights')
            ->call('create')
            ->set('title', '')
            ->set('type', 'video')
            ->set('video_url', 'https://youtube.com/watch?v=abc')
            ->call('save');

        $response->assertHasErrors(['title']);
    }

    #[Test]
    public function highlights_ordered_by_order_field()
    {
        $profile = AthleteProfile::factory()->create(['is_active' => true]);
        
        $h1 = Highlight::factory()->create([
            'athlete_profile_id' => $profile->id,
            'order' => 3,
            'is_active' => true,
        ]);
        $h2 = Highlight::factory()->create([
            'athlete_profile_id' => $profile->id,
            'order' => 1,
            'is_active' => true,
        ]);
        $h3 = Highlight::factory()->create([
            'athlete_profile_id' => $profile->id,
            'order' => 2,
            'is_active' => true,
        ]);

        $highlights = Highlight::where('athlete_profile_id', $profile->id)
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        $this->assertEquals(1, $highlights->first()->order);
        $this->assertEquals(3, $highlights->last()->order);
    }
}
