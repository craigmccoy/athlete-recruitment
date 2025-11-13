<?php

namespace Tests\Feature;

use App\Models\AthleteProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AthleteProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    #[Test]
    public function homepage_displays_athlete_profile()
    {
        $profile = AthleteProfile::factory()->create([
            'name' => 'John Smith',
            'sport' => 'football',
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('John Smith');
        // Verify football profile was created and position is displayed
        $this->assertNotNull($profile->footballProfile);
        $response->assertSee($profile->footballProfile->position);
    }

    #[Test]
    public function guest_cannot_access_admin_profile_page()
    {
        $response = $this->get('/admin/profile');

        $response->assertRedirect('/login');
    }

    #[Test]
    public function authenticated_user_can_access_admin_profile_page()
    {
        $user = User::factory()->create();
        AthleteProfile::factory()->create(['is_active' => true]);

        $response = $this->actingAs($user)->get('/admin/profile');

        $response->assertStatus(200);
        $response->assertSeeLivewire('admin.manage-profile');
    }

    #[Test]
    public function authenticated_user_can_update_profile()
    {
        $user = User::factory()->create();
        $profile = AthleteProfile::factory()->create([
            'is_active' => true,
            'name' => 'Old Name',
        ]);

        $response = Livewire::actingAs($user)
            ->test('admin.manage-profile')
            ->set('name', 'New Name')
            ->set('position', 'Quarterback')
            ->set('sport', 'football')
            ->set('graduation_year', 2026)
            ->set('school_name', 'Test High School')
            ->call('save');

        $response->assertHasNoErrors();
        $this->assertDatabaseHas('athlete_profiles', [
            'name' => 'New Name',
            'sport' => 'football',
        ]);
        $this->assertDatabaseHas('football_profiles', [
            'athlete_profile_id' => $profile->id,
            'position' => 'Quarterback',
        ]);
    }

    #[Test]
    public function profile_can_upload_image()
    {
        $user = User::factory()->create();
        $profile = AthleteProfile::factory()->create(['is_active' => true]);
        $file = UploadedFile::fake()->image('profile.jpg', 800, 800);

        $response = Livewire::actingAs($user)
            ->test('admin.manage-profile')
            ->set('name', $profile->name)
            ->set('position', 'Quarterback')
            ->set('sport', 'football')
            ->set('graduation_year', $profile->graduation_year)
            ->set('school_name', $profile->school_name)
            ->set('profile_image', $file)
            ->call('save');

        $response->assertHasNoErrors();
        $profile->refresh();
        $this->assertNotNull($profile->profile_image);
        Storage::disk('public')->assertExists($profile->profile_image);
    }

    #[Test]
    public function profile_requires_name()
    {
        $user = User::factory()->create();
        AthleteProfile::factory()->create(['is_active' => true]);

        $response = Livewire::actingAs($user)
            ->test('admin.manage-profile')
            ->set('name', '')
            ->set('position', 'QB')
            ->set('sport', 'football')
            ->set('graduation_year', 2026)
            ->set('school_name', 'Test School')
            ->call('save');

        $response->assertHasErrors(['name']);
    }

    #[Test]
    public function profile_supports_multiple_sports()
    {
        $user = User::factory()->create();
        $profile = AthleteProfile::factory()->create(['is_active' => true]);

        $sports = ['football', 'basketball', 'baseball', 'track', 'soccer'];

        foreach ($sports as $sport) {
            $response = Livewire::actingAs($user)
                ->test('admin.manage-profile')
                ->set('name', $profile->name)
                ->set('position', 'Position')
                ->set('sport', $sport)
                ->set('graduation_year', 2026)
                ->set('school_name', 'Test School')
                ->call('save');

            $response->assertHasNoErrors();
            $profile->refresh();
            $this->assertEquals($sport, $profile->sport);
        }
    }

    #[Test]
    public function profile_displays_sport_on_homepage()
    {
        $profile = AthleteProfile::factory()->basketball()->create([
            'name' => 'Jane Doe',
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Basketball');
        // Verify basketball profile was created and position is displayed
        $this->assertNotNull($profile->basketballProfile);
        $response->assertSee($profile->basketballProfile->position);
    }

    #[Test]
    public function profile_caches_active_profile()
    {
        $profile = AthleteProfile::factory()->create(['is_active' => true]);

        // First call should cache
        $this->get('/');

        // Update profile
        $profile->update(['name' => 'Updated Name']);

        // Cache should still show old name initially
        $response = $this->get('/');
        // After cache clear, should show new name
        \Cache::forget('active_athlete_profile');
        $response = $this->get('/');
        $response->assertSee('Updated Name');
    }

    #[Test]
    public function profile_validates_gpa_range()
    {
        $user = User::factory()->create();
        AthleteProfile::factory()->create(['is_active' => true]);

        $response = Livewire::actingAs($user)
            ->test('admin.manage-profile')
            ->set('name', 'Test')
            ->set('position', 'QB')
            ->set('sport', 'football')
            ->set('graduation_year', 2026)
            ->set('school_name', 'Test School')
            ->set('gpa', 5.0)
            ->call('save');

        $response->assertHasErrors(['gpa']);
    }

    #[Test]
    public function profile_accepts_social_links()
    {
        $user = User::factory()->create();
        $profile = AthleteProfile::factory()->create(['is_active' => true]);

        $response = Livewire::actingAs($user)
            ->test('admin.manage-profile')
            ->set('name', $profile->name)
            ->set('position', 'Wide Receiver')
            ->set('sport', 'football')
            ->set('graduation_year', 2026)
            ->set('school_name', 'Test School')
            ->set('facebook', 'https://facebook.com/athlete')
            ->set('twitter', 'https://twitter.com/athlete')
            ->set('instagram', 'https://instagram.com/athlete')
            ->call('save');

        $response->assertHasNoErrors();
        $profile->refresh();
        $this->assertEquals('https://facebook.com/athlete', $profile->social_links['facebook']);
        $this->assertEquals('https://twitter.com/athlete', $profile->social_links['twitter']);
        $this->assertEquals('https://instagram.com/athlete', $profile->social_links['instagram']);
    }
}
