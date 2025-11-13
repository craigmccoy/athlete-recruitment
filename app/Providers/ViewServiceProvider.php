<?php

namespace App\Providers;

use App\Models\AthleteProfile;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share athlete profile with all views (cached for 1 hour)
        View::composer('*', function ($view) {
            $athleteProfile = \Cache::remember('active_athlete_profile', 3600, function () {
                return AthleteProfile::where('is_active', true)
                    ->with([
                        'footballProfile',
                        'basketballProfile',
                        'baseballProfile',
                        'soccerProfile',
                        'trackProfile'
                    ])
                    ->first();
            });
            $view->with('sharedAthleteProfile', $athleteProfile);
        });
    }
}
