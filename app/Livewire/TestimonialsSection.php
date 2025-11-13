<?php

namespace App\Livewire;

use App\Models\AthleteProfile;
use App\Models\Testimonial;
use Livewire\Component;

class TestimonialsSection extends Component
{
    public $testimonials;

    public function mount()
    {
        $profile = AthleteProfile::where('is_active', true)->first();
        
        if ($profile) {
            $this->testimonials = Testimonial::where('athlete_profile_id', $profile->id)
                ->active()
                ->ordered()
                ->get();
        } else {
            $this->testimonials = collect();
        }
    }

    public function render()
    {
        return view('livewire.testimonials-section');
    }
}
