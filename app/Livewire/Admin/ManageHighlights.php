<?php

namespace App\Livewire\Admin;

use App\Models\AthleteProfile;
use App\Models\Highlight;
use Livewire\Component;
use Livewire\WithFileUploads;

class ManageHighlights extends Component
{
    use WithFileUploads;

    public $highlights;
    public $athleteProfile;
    public $editingId = null;
    public $title, $description, $type, $video_url, $photo, $duration, $order, $is_featured, $is_active;

    protected function rules()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'type' => 'required|in:video,photo',
            'order' => 'required|integer|min:0',
        ];

        // Add conditional validation based on type
        if ($this->type === 'video') {
            $rules['video_url'] = 'required|url';
        } elseif ($this->type === 'photo') {
            // Only require photo on new uploads
            if ($this->editingId === 'new') {
                $rules['photo'] = 'required|image|max:10240'; // 10MB max
            } else {
                $rules['photo'] = 'nullable|image|max:10240';
            }
        }

        return $rules;
    }

    public function mount()
    {
        $this->athleteProfile = AthleteProfile::where('is_active', true)->first();
        $this->loadHighlights();
    }

    public function loadHighlights()
    {
        if (!$this->athleteProfile) {
            $this->highlights = collect();
            return;
        }
        
        $this->highlights = Highlight::where('athlete_profile_id', $this->athleteProfile->id)
            ->orderBy('order')
            ->get();
    }

    public function create()
    {
        if (!$this->athleteProfile) {
            session()->flash('error', 'Please create an athlete profile first before adding highlights.');
            return redirect()->route('admin.profile');
        }
        
        $this->resetForm();
        $this->editingId = 'new';
    }

    public function edit($id)
    {
        $highlight = Highlight::findOrFail($id);
        $this->editingId = $id;
        $this->title = $highlight->title;
        $this->description = $highlight->description;
        $this->type = $highlight->type;
        $this->video_url = $highlight->video_url;
        $this->photo = null; // Reset photo (will show existing in view)
        $this->duration = $highlight->duration;
        $this->order = $highlight->order;
        $this->is_featured = $highlight->is_featured;
        $this->is_active = $highlight->is_active;
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
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type,
            'video_url' => $this->type === 'video' ? $this->video_url : null,
            'duration' => $this->type === 'video' ? $this->duration : null,
            'order' => $this->order,
            'is_featured' => $this->is_featured ?? false,
            'is_active' => $this->is_active ?? true,
        ];

        // Handle photo upload
        if ($this->photo) {
            // Delete old photo if updating
            if ($this->editingId !== 'new') {
                $highlight = Highlight::find($this->editingId);
                if ($highlight && $highlight->photo_path) {
                    \Storage::disk('public')->delete($highlight->photo_path);
                }
            }

            // Store new photo
            $photoPath = $this->photo->store('highlights', 'public');
            $data['photo_path'] = $photoPath;
        }

        if ($this->editingId === 'new') {
            Highlight::create($data);
            session()->flash('message', 'Highlight added successfully!');
        } else {
            Highlight::findOrFail($this->editingId)->update($data);
            session()->flash('message', 'Highlight updated successfully!');
        }

        $this->resetForm();
        $this->loadHighlights();
    }

    public function delete($id)
    {
        $highlight = Highlight::findOrFail($id);
        
        // Delete photo file if exists
        if ($highlight->photo_path) {
            \Storage::disk('public')->delete($highlight->photo_path);
        }
        
        $highlight->delete();
        session()->flash('message', 'Highlight deleted successfully!');
        $this->loadHighlights();
    }

    public function cancel()
    {
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->editingId = null;
        $this->title = '';
        $this->description = '';
        $this->type = 'video';
        $this->video_url = '';
        $this->photo = null;
        $this->duration = '';
        $this->order = $this->highlights->count();
        $this->is_featured = false;
        $this->is_active = true;
    }

    public function render()
    {
        return view('livewire.admin.manage-highlights');
    }
}
