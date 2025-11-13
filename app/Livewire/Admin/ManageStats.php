<?php

namespace App\Livewire\Admin;

use App\Models\AthleteProfile;
use App\Models\SeasonStat;
use Livewire\Component;

class ManageStats extends Component
{
    public $stats;
    public $athleteProfile;
    public $sport;
    
    // Form fields
    public $editingId = null;
    public $season_year;
    public $competitions = 0;
    public $notes;
    
    // Dynamic stats based on sport
    public $statFields = [];

    public function rules()
    {
        return [
            'season_year' => 'required|integer|min:2000|max:2030',
            'competitions' => 'required|integer|min:0',
        ];
    }

    public function mount()
    {
        $this->athleteProfile = AthleteProfile::where('is_active', true)->first();
        $this->sport = $this->athleteProfile?->sport ?? 'football';
        $this->loadStats();
        $this->initializeStatFields();
    }

    public function loadStats()
    {
        if (!$this->athleteProfile) {
            $this->stats = collect();
            return;
        }
        
        $this->stats = SeasonStat::where('athlete_profile_id', $this->athleteProfile->id)
            ->orderBy('season_year', 'desc')
            ->get();
    }

    private function initializeStatFields()
    {
        // Initialize stat fields based on sport with default values
        $this->statFields = match($this->sport) {
            'basketball' => [
                'points_per_game' => 0,
                'rebounds_per_game' => 0,
                'assists_per_game' => 0,
                'field_goal_percentage' => 0,
            ],
            'baseball' => [
                'batting_average' => 0,
                'home_runs' => 0,
                'rbis' => 0,
                'stolen_bases' => 0,
            ],
            'soccer' => [
                'goals' => 0,
                'assists' => 0,
                'shots' => 0,
                'shots_on_goal' => 0,
            ],
            'track' => [
                'best_time' => '',
                'personal_record' => '',
                'medals' => 0,
            ],
            default => [ // Football
                'receptions' => 0,
                'receiving_yards' => 0,
                'yards_per_catch' => 0,
                'touchdowns' => 0,
            ],
        };
    }

    public function create()
    {
        if (!$this->athleteProfile) {
            session()->flash('error', 'Please create an athlete profile first before adding stats.');
            return redirect()->route('admin.profile');
        }
        
        $this->resetForm();
        $this->editingId = 'new';
    }

    public function edit($id)
    {
        $stat = SeasonStat::findOrFail($id);
        $this->editingId = $id;
        $this->season_year = $stat->season_year;
        $this->competitions = $stat->competitions;
        $this->notes = $stat->notes;
        
        // Load stats from JSON
        $this->statFields = $stat->stats ?? $this->statFields;
    }

    public function save()
    {
        if (!$this->athleteProfile) {
            session()->flash('error', 'Please create an athlete profile first.');
            return redirect()->route('admin.profile');
        }
        
        $this->validate();

        // Auto-calculate yards per catch for football
        if ($this->sport === 'football' && isset($this->statFields['receptions']) && isset($this->statFields['receiving_yards'])) {
            $this->statFields['yards_per_catch'] = $this->statFields['receptions'] > 0 
                ? round($this->statFields['receiving_yards'] / $this->statFields['receptions'], 2) 
                : 0;
        }

        $data = [
            'athlete_profile_id' => $this->athleteProfile->id,
            'sport' => $this->sport,
            'season_year' => $this->season_year,
            'competitions' => $this->competitions,
            'stats' => $this->statFields, // Save all sport-specific stats as JSON
            'notes' => $this->notes,
        ];

        if ($this->editingId === 'new') {
            SeasonStat::create($data);
            session()->flash('message', 'Season stats added successfully!');
        } else {
            SeasonStat::findOrFail($this->editingId)->update($data);
            session()->flash('message', 'Season stats updated successfully!');
        }

        $this->resetForm();
        $this->loadStats();
    }

    public function delete($id)
    {
        SeasonStat::findOrFail($id)->delete();
        session()->flash('message', 'Season stats deleted successfully!');
        $this->loadStats();
    }

    public function cancel()
    {
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->editingId = null;
        $this->season_year = null;
        $this->competitions = 0;
        $this->notes = null;
        $this->initializeStatFields(); // Reset stat fields to defaults
    }

    public function render()
    {
        return view('livewire.admin.manage-stats');
    }
}
