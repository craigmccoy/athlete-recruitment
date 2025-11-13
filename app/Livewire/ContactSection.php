<?php

namespace App\Livewire;

use App\Mail\ContactSubmissionNotification;
use App\Models\AthleteProfile;
use App\Models\ContactSubmission;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ContactSection extends Component
{
    public $name = '';
    public $email = '';
    public $organization = '';
    public $message = '';

    protected $rules = [
        'name' => 'required|min:2',
        'email' => 'required|email',
        'message' => 'required|min:10',
    ];

    public function submitForm()
    {
        $this->validate();

        // Save to database
        $submission = ContactSubmission::create([
            'name' => $this->name,
            'email' => $this->email,
            'organization' => $this->organization,
            'message' => $this->message,
        ]);

        // Send email notification to athlete
        try {
            $athleteProfile = AthleteProfile::where('is_active', true)->first();
            
            if ($athleteProfile && $athleteProfile->email) {
                Mail::to($athleteProfile->email)
                    ->send(new ContactSubmissionNotification($submission));
            }
        } catch (\Exception $e) {
            // Log the error but don't fail the submission
            \Log::error('Failed to send contact notification email: ' . $e->getMessage());
        }

        session()->flash('message', 'Thank you for your message! I will get back to you soon.');

        // Reset form
        $this->reset(['name', 'email', 'organization', 'message']);
    }

    public function render()
    {
        $athleteProfile = AthleteProfile::where('is_active', true)->first();
        
        return view('livewire.contact-section', [
            'athleteProfile' => $athleteProfile,
        ]);
    }
}
