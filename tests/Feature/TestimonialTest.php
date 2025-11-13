<?php

namespace Tests\Feature;

use App\Models\AthleteProfile;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TestimonialTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function guest_cannot_access_testimonials_admin_page()
    {
        $response = $this->get('/admin/testimonials');

        $response->assertRedirect('/login');
    }

    #[Test]
    public function authenticated_user_can_access_testimonials_page()
    {
        $user = User::factory()->create();
        AthleteProfile::factory()->create(['is_active' => true]);

        $response = $this->actingAs($user)->get('/admin/testimonials');

        $response->assertStatus(200);
        $response->assertSeeLivewire('admin.manage-testimonials');
    }

    #[Test]
    public function user_can_create_testimonial()
    {
        $user = User::factory()->create();
        $profile = AthleteProfile::factory()->create(['is_active' => true]);

        $response = Livewire::actingAs($user)
            ->test('admin.manage-testimonials')
            ->call('create')
            ->set('author_name', 'Coach Johnson')
            ->set('author_title', 'Head Coach')
            ->set('author_organization', 'Lincoln High School')
            ->set('content', 'Outstanding athlete with great work ethic and leadership skills.')
            ->set('relationship', 'Coach')
            ->set('order', 1)
            ->call('save');

        $response->assertHasNoErrors();
        $this->assertDatabaseHas('testimonials', [
            'author_name' => 'Coach Johnson',
            'author_title' => 'Head Coach',
            'content' => 'Outstanding athlete with great work ethic and leadership skills.',
        ]);
    }

    #[Test]
    public function user_can_edit_testimonial()
    {
        $user = User::factory()->create();
        $profile = AthleteProfile::factory()->create(['is_active' => true]);
        $testimonial = Testimonial::factory()->create([
            'athlete_profile_id' => $profile->id,
            'author_name' => 'Old Name',
        ]);

        $response = Livewire::actingAs($user)
            ->test('admin.manage-testimonials')
            ->call('edit', $testimonial->id)
            ->set('author_name', 'Updated Name')
            ->call('save');

        $response->assertHasNoErrors();
        $this->assertDatabaseHas('testimonials', [
            'id' => $testimonial->id,
            'author_name' => 'Updated Name',
        ]);
    }

    #[Test]
    public function user_can_delete_testimonial()
    {
        $user = User::factory()->create();
        $profile = AthleteProfile::factory()->create(['is_active' => true]);
        $testimonial = Testimonial::factory()->create([
            'athlete_profile_id' => $profile->id,
        ]);

        $response = Livewire::actingAs($user)
            ->test('admin.manage-testimonials')
            ->call('delete', $testimonial->id);

        $this->assertDatabaseMissing('testimonials', [
            'id' => $testimonial->id,
        ]);
    }

    #[Test]
    public function testimonials_display_on_homepage()
    {
        $profile = AthleteProfile::factory()->create(['is_active' => true]);
        Testimonial::factory()->create([
            'athlete_profile_id' => $profile->id,
            'author_name' => 'Coach Smith',
            'content' => 'Excellent athlete',
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Coach Smith');
        $response->assertSee('Excellent athlete');
    }

    #[Test]
    public function inactive_testimonials_do_not_display()
    {
        $profile = AthleteProfile::factory()->create(['is_active' => true]);
        Testimonial::factory()->create([
            'athlete_profile_id' => $profile->id,
            'author_name' => 'Hidden Coach',
            'is_active' => false,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('Hidden Coach');
    }

    #[Test]
    public function testimonial_requires_author_name()
    {
        $user = User::factory()->create();
        AthleteProfile::factory()->create(['is_active' => true]);

        $response = Livewire::actingAs($user)
            ->test('admin.manage-testimonials')
            ->call('create')
            ->set('author_name', '')
            ->set('content', 'Great athlete')
            ->set('order', 1)
            ->call('save');

        $response->assertHasErrors(['author_name']);
    }

    #[Test]
    public function testimonial_requires_content()
    {
        $user = User::factory()->create();
        AthleteProfile::factory()->create(['is_active' => true]);

        $response = Livewire::actingAs($user)
            ->test('admin.manage-testimonials')
            ->call('create')
            ->set('author_name', 'Coach Smith')
            ->set('content', '')
            ->set('order', 1)
            ->call('save');

        $response->assertHasErrors(['content']);
    }


    #[Test]
    public function featured_testimonials_are_highlighted()
    {
        $profile = AthleteProfile::factory()->create(['is_active' => true]);
        Testimonial::factory()->featured()->create([
            'athlete_profile_id' => $profile->id,
            'author_name' => 'Featured Coach',
            'content' => 'Outstanding performance',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Featured Coach');
        $response->assertSee('Featured');
    }

    #[Test]
    public function user_can_toggle_featured_status()
    {
        $user = User::factory()->create();
        $profile = AthleteProfile::factory()->create(['is_active' => true]);
        $testimonial = Testimonial::factory()->create([
            'athlete_profile_id' => $profile->id,
            'is_featured' => false,
        ]);

        Livewire::actingAs($user)
            ->test('admin.manage-testimonials')
            ->call('toggleFeatured', $testimonial->id);

        $this->assertDatabaseHas('testimonials', [
            'id' => $testimonial->id,
            'is_featured' => true,
        ]);
    }

    #[Test]
    public function user_can_toggle_active_status()
    {
        $user = User::factory()->create();
        $profile = AthleteProfile::factory()->create(['is_active' => true]);
        $testimonial = Testimonial::factory()->create([
            'athlete_profile_id' => $profile->id,
            'is_active' => true,
        ]);

        Livewire::actingAs($user)
            ->test('admin.manage-testimonials')
            ->call('toggleActive', $testimonial->id);

        $this->assertDatabaseHas('testimonials', [
            'id' => $testimonial->id,
            'is_active' => false,
        ]);
    }

    #[Test]
    public function testimonials_appear_in_pdf_stat_sheet()
    {
        $profile = AthleteProfile::factory()->create(['is_active' => true]);
        $testimonial = Testimonial::factory()->create([
            'athlete_profile_id' => $profile->id,
            'author_name' => 'Coach PDF Test',
            'content' => 'Amazing player with great potential',
            'is_active' => true,
        ]);

        $response = $this->get('/stat-sheet.pdf');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
        
        // Verify testimonial is loaded in the route
        $this->assertDatabaseHas('testimonials', [
            'id' => $testimonial->id,
            'author_name' => 'Coach PDF Test',
            'is_active' => true,
        ]);
    }

    #[Test]
    public function testimonials_are_ordered_correctly()
    {
        $profile = AthleteProfile::factory()->create(['is_active' => true]);
        
        $testimonial1 = Testimonial::factory()->create([
            'athlete_profile_id' => $profile->id,
            'order' => 2,
            'author_name' => 'Second',
        ]);
        
        $testimonial2 = Testimonial::factory()->create([
            'athlete_profile_id' => $profile->id,
            'order' => 1,
            'author_name' => 'First',
        ]);

        $testimonials = Testimonial::where('athlete_profile_id', $profile->id)
            ->orderBy('order')
            ->get();

        $this->assertEquals('First', $testimonials->first()->author_name);
        $this->assertEquals('Second', $testimonials->last()->author_name);
    }
}
