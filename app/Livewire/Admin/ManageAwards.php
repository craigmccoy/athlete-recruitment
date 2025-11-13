<?php

namespace App\Livewire\Admin;

use App\Models\AthleteProfile;
use App\Models\Award;
use Livewire\Component;

class ManageAwards extends Component
{
    public $awards;
    public $athleteProfile;
    public $editingId = null;
    public $title, $description, $year, $icon, $color, $order;

    protected $rules = [
        'title' => 'required|string|max:255',
        'order' => 'required|integer|min:0',
    ];

    public function mount()
    {
        $this->athleteProfile = AthleteProfile::where('is_active', true)->first();
        $this->loadAwards();
    }

    public function loadAwards()
    {
        if (!$this->athleteProfile) {
            $this->awards = collect();
            return;
        }
        
        $this->awards = Award::where('athlete_profile_id', $this->athleteProfile->id)
            ->orderBy('order')
            ->get();
    }

    public function create()
    {
        if (!$this->athleteProfile) {
            session()->flash('error', 'Please create an athlete profile first before adding awards.');
            return redirect()->route('admin.profile');
        }
        
        $this->resetForm();
        $this->editingId = 'new';
    }

    public function edit($id)
    {
        $award = Award::findOrFail($id);
        $this->editingId = $id;
        $this->title = $award->title;
        $this->description = $award->description;
        $this->year = $award->year;
        $this->icon = $award->icon;
        $this->color = $award->color;
        $this->order = $award->order;
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
            'year' => $this->year,
            'icon' => $this->icon,
            'color' => $this->color ?? 'blue',
            'order' => $this->order,
        ];

        if ($this->editingId === 'new') {
            Award::create($data);
            session()->flash('message', 'Award added successfully!');
        } else {
            Award::findOrFail($this->editingId)->update($data);
            session()->flash('message', 'Award updated successfully!');
        }

        $this->resetForm();
        $this->loadAwards();
    }

    public function delete($id)
    {
        Award::findOrFail($id)->delete();
        session()->flash('message', 'Award deleted successfully!');
        $this->loadAwards();
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
        $this->year = now()->year;
        $this->icon = '🏆';
        $this->color = 'blue';
        $this->order = $this->awards->count();
    }

    public function render()
    {
        return view('livewire.admin.manage-awards');
    }
}
