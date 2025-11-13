<?php

namespace App\Livewire\Admin;

use App\Models\AthleteProfile;
use App\Models\Testimonial;
use Livewire\Component;

class ManageTestimonials extends Component
{
    public $testimonials;
    public $athleteProfile;
    public $editingId = null;
    
    // Form fields
    public $author_name = '';
    public $author_title = '';
    public $author_organization = '';
    public $content = '';
    public $relationship = '';
    public $date = '';
    public $is_featured = false;
    public $is_active = true;
    public $order = 0;

    protected $rules = [
        'author_name' => 'required|string|max:255',
        'author_title' => 'nullable|string|max:255',
        'author_organization' => 'nullable|string|max:255',
        'content' => 'required|string|min:10',
        'relationship' => 'nullable|string|max:255',
        'date' => 'nullable|date',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'required|integer|min:0',
    ];

    public function mount()
    {
        $this->athleteProfile = AthleteProfile::where('is_active', true)->first();
        $this->loadTestimonials();
    }

    public function loadTestimonials()
    {
        if (!$this->athleteProfile) {
            $this->testimonials = collect();
            return;
        }
        
        $this->testimonials = Testimonial::where('athlete_profile_id', $this->athleteProfile->id)
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function create()
    {
        if (!$this->athleteProfile) {
            session()->flash('error', 'Please create an athlete profile first before adding testimonials.');
            return redirect()->route('admin.profile');
        }
        
        $this->resetForm();
        $this->editingId = 'new';
    }

    public function edit($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $this->editingId = $id;
        $this->author_name = $testimonial->author_name;
        $this->author_title = $testimonial->author_title;
        $this->author_organization = $testimonial->author_organization;
        $this->content = $testimonial->content;
        $this->relationship = $testimonial->relationship;
        $this->date = $testimonial->date ? $testimonial->date->format('Y-m-d') : '';
        $this->is_featured = $testimonial->is_featured;
        $this->is_active = $testimonial->is_active;
        $this->order = $testimonial->order;
    }

    public function save()
    {
        if (!$this->athleteProfile) {
            session()->flash('error', 'Please create an athlete profile first.');
            return redirect()->route('admin.profile');
        }
        
        $this->validate();

        $data = [
            'athlete_profile_id' => $this->athleteProfile->id,
            'author_name' => $this->author_name,
            'author_title' => $this->author_title,
            'author_organization' => $this->author_organization,
            'content' => $this->content,
            'relationship' => $this->relationship,
            'date' => $this->date ?: null,
            'is_featured' => $this->is_featured,
            'is_active' => $this->is_active,
            'order' => $this->order,
        ];

        if ($this->editingId === 'new') {
            Testimonial::create($data);
            session()->flash('message', 'Testimonial added successfully!');
        } else {
            Testimonial::findOrFail($this->editingId)->update($data);
            session()->flash('message', 'Testimonial updated successfully!');
        }

        $this->resetForm();
        $this->loadTestimonials();
    }

    public function delete($id)
    {
        Testimonial::findOrFail($id)->delete();
        session()->flash('message', 'Testimonial deleted successfully!');
        $this->loadTestimonials();
    }

    public function toggleFeatured($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update(['is_featured' => !$testimonial->is_featured]);
        $this->loadTestimonials();
    }

    public function toggleActive($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update(['is_active' => !$testimonial->is_active]);
        $this->loadTestimonials();
    }

    public function cancel()
    {
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->editingId = null;
        $this->author_name = '';
        $this->author_title = '';
        $this->author_organization = '';
        $this->content = '';
        $this->relationship = '';
        $this->date = '';
        $this->is_featured = false;
        $this->is_active = true;
        $this->order = $this->testimonials->count();
    }

    public function render()
    {
        return view('livewire.admin.manage-testimonials');
    }
}
