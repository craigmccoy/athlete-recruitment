<?php

namespace App\Livewire;

use App\Models\AthleteProfile;
use Livewire\Component;

class StatsSection extends Component
{
    public function render()
    {
        // Cache stats for 1 hour
        $athlete = \Cache::remember('athlete_with_stats', 3600, function () {
            return AthleteProfile::with(['awards' => function($query) {
                $query->orderBy('order');
            }])->where('is_active', true)->first();
        });

        // Load season stats filtered by current sport (don't cache this part)
        $seasonStats = $athlete ? $athlete->seasonStats()
            ->where('sport', $athlete->sport)
            ->orderBy('season_year', 'desc')
            ->get() : collect();

        return view('livewire.stats-section', [
            'athlete' => $athlete,
            'seasonStats' => $seasonStats,
            'awards' => $athlete->awards ?? collect(),
        ]);
    }
}
