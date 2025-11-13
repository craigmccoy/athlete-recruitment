<?php

namespace App\Livewire;

use App\Models\AthleteProfile;
use Livewire\Component;

class HighlightsSection extends Component
{
    public function render()
    {
        // Cache highlights for 1 hour
        $athlete = \Cache::remember('athlete_with_highlights', 3600, function () {
            return AthleteProfile::with(['highlights' => function($query) {
                $query->where('is_active', true)->orderBy('order');
            }])->where('is_active', true)->first();
        });

        $allHighlights = $athlete?->highlights ?? collect();
        
        // Separate videos and photos
        $videos = $allHighlights->where('type', 'video');
        $photos = $allHighlights->where('type', 'photo');
        
        $featuredHighlight = $videos->where('is_featured', true)->first();
        $otherVideos = $videos->where('is_featured', false);

        return view('livewire.highlights-section', [
            'featuredHighlight' => $featuredHighlight,
            'highlights' => $otherVideos,
            'photos' => $photos,
        ]);
    }
}
