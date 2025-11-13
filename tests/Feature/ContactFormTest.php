<?php

namespace Tests\Feature;

use App\Mail\ContactSubmissionNotification;
use App\Models\AthleteProfile;
use App\Models\ContactSubmission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
    }

    #[Test]
    public function contact_form_displays_on_homepage()
    {
        AthleteProfile::factory()->create(['is_active' => true]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Contact');
        $response->assertSeeLivewire('contact-section');
    }

    #[Test]
    public function guest_can_submit_contact_form()
    {
        $profile = AthleteProfile::factory()->create([
            'is_active' => true,
            'email' => 'athlete@example.com',
        ]);

        $response = Livewire::test('contact-section')
            ->set('name', 'Coach Smith')
            ->set('email', 'coach@school.edu')
            ->set('organization', 'University Athletics')
            ->set('message', 'Interested in recruiting you')
            ->call('submitForm');

        $response->assertHasNoErrors();
        
        $this->assertDatabaseHas('contact_submissions', [
            'name' => 'Coach Smith',
            'email' => 'coach@school.edu',
            'organization' => 'University Athletics',
            'message' => 'Interested in recruiting you',
        ]);
    }

    #[Test]
    public function contact_form_sends_email_notification()
    {
        $profile = AthleteProfile::factory()->create([
            'is_active' => true,
            'email' => 'athlete@example.com',
        ]);

        Livewire::test('contact-section')
            ->set('name', 'Coach Smith')
            ->set('email', 'coach@school.edu')
            ->set('organization', 'University')
            ->set('message', 'Test message')
            ->call('submitForm');

        Mail::assertSent(ContactSubmissionNotification::class, function ($mail) use ($profile) {
            return $mail->hasTo($profile->email);
        });
    }

    #[Test]
    public function contact_form_requires_name()
    {
        AthleteProfile::factory()->create(['is_active' => true]);

        $response = Livewire::test('contact-section')
            ->set('name', '')
            ->set('email', 'coach@school.edu')
            ->set('message', 'Test')
            ->call('submitForm');

        $response->assertHasErrors(['name']);
    }

    #[Test]
    public function contact_form_requires_valid_email()
    {
        AthleteProfile::factory()->create(['is_active' => true]);

        $response = Livewire::test('contact-section')
            ->set('name', 'Coach Smith')
            ->set('email', 'invalid-email')
            ->set('message', 'Test')
            ->call('submitForm');

        $response->assertHasErrors(['email']);
    }

    #[Test]
    public function contact_form_requires_message()
    {
        AthleteProfile::factory()->create(['is_active' => true]);

        $response = Livewire::test('contact-section')
            ->set('name', 'Coach Smith')
            ->set('email', 'coach@school.edu')
            ->set('message', '')
            ->call('submitForm');

        $response->assertHasErrors(['message']);
    }

    #[Test]
    public function user_can_view_contact_submissions()
    {
        $user = User::factory()->create();
        $profile = AthleteProfile::factory()->create(['is_active' => true]);
        ContactSubmission::factory()->create([
            'name' => 'Coach Johnson',
            'message' => 'Test message',
        ]);

        $response = $this->actingAs($user)->get('/admin/contacts');

        $response->assertStatus(200);
        $response->assertSee('Coach Johnson');
        $response->assertSeeLivewire('admin.view-contacts');
    }

    #[Test]
    public function guest_cannot_view_contact_submissions()
    {
        $response = $this->get('/admin/contacts');

        $response->assertRedirect('/login');
    }

    #[Test]
    public function user_can_mark_submission_as_read()
    {
        $user = User::factory()->create();
        AthleteProfile::factory()->create(['is_active' => true]);
        $submission = ContactSubmission::factory()->create([
            'is_read' => false,
        ]);

        $response = Livewire::actingAs($user)
            ->test('admin.view-contacts')
            ->call('viewContact', $submission->id);

        $this->assertDatabaseHas('contact_submissions', [
            'id' => $submission->id,
            'is_read' => true,
        ]);
    }

    #[Test]
    public function user_can_delete_submission()
    {
        $user = User::factory()->create();
        AthleteProfile::factory()->create(['is_active' => true]);
        $submission = ContactSubmission::factory()->create();

        $response = Livewire::actingAs($user)
            ->test('admin.view-contacts')
            ->call('delete', $submission->id);

        $this->assertDatabaseMissing('contact_submissions', [
            'id' => $submission->id,
        ]);
    }

    #[Test]
    public function contact_form_resets_after_submission()
    {
        $profile = AthleteProfile::factory()->create([
            'is_active' => true,
            'email' => 'athlete@example.com',
        ]);

        $response = Livewire::test('contact-section')
            ->set('name', 'Coach Smith')
            ->set('email', 'coach@school.edu')
            ->set('organization', 'University')
            ->set('message', 'This is a test message for the contact form.')
            ->call('submitForm');

        // Verify submission was successful
        $response->assertHasNoErrors();
        $this->assertDatabaseHas('contact_submissions', [
            'name' => 'Coach Smith',
            'email' => 'coach@school.edu',
        ]);
    }

    #[Test]
    public function contact_submissions_ordered_by_date_desc()
    {
        $old = ContactSubmission::factory()->create([
            'created_at' => now()->subDays(2),
        ]);
        $new = ContactSubmission::factory()->create([
            'created_at' => now(),
        ]);

        $submissions = ContactSubmission::orderBy('created_at', 'desc')->get();

        $this->assertEquals($new->id, $submissions->first()->id);
        $this->assertEquals($old->id, $submissions->last()->id);
    }
}
