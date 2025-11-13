<?php

use App\Http\Controllers\SocialAuthController;
use App\Models\AthleteProfile;
use Illuminate\Support\Facades\Route;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

Route::get('/', function () {
    $athleteProfile = AthleteProfile::where('is_active', true)
        ->with(['footballProfile', 'basketballProfile', 'baseballProfile', 'soccerProfile', 'trackProfile'])
        ->first();
    
    // If no profile exists and user is not authenticated, show setup message
    if (!$athleteProfile && !auth()->check()) {
        return view('setup-required');
    }
    
    // If no profile exists but user is authenticated, redirect to admin
    if (!$athleteProfile && auth()->check()) {
        return redirect()->route('admin.profile')
            ->with('message', 'Please create an athlete profile to get started.');
    }
    
    return view('home', ['athleteProfile' => $athleteProfile]);
});

// Sitemap
Route::get('/sitemap.xml', function () {
    $athlete = AthleteProfile::where('is_active', true)->first();
    
    return response()->view('sitemap', ['athlete' => $athlete])
        ->header('Content-Type', 'text/xml');
});

// Robots.txt
Route::get('/robots.txt', function () {
    $content = "User-agent: *\nAllow: /\n\nSitemap: " . url('/sitemap.xml');
    
    return response($content, 200)
        ->header('Content-Type', 'text/plain');
});

// PDF Stat Sheet (public)
Route::get('/stat-sheet.pdf', function () {
    $athlete = AthleteProfile::where('is_active', true)
        ->with([
            'footballProfile',
            'basketballProfile',
            'baseballProfile',
            'soccerProfile',
            'trackProfile',
            'seasonStats' => function($query) {
                $query->orderBy('season_year', 'desc');
            },
            'awards' => function($query) {
                $query->orderBy('year', 'desc');
            },
            'testimonials' => function($query) {
                $query->where('is_active', true)->orderBy('order')->orderBy('created_at', 'desc');
            }
        ])
        ->first();
    
    if (!$athlete) {
        if (auth()->check()) {
            return redirect()->route('admin.profile')
                ->with('error', 'Please create an athlete profile before downloading the stat sheet.');
        }
        abort(404, 'Athlete profile not found. Please check back later.');
    }
    
    // Generate QR Code
    $qrCode = new QrCode(url('/'));
    
    $writer = new PngWriter();
    $result = $writer->write($qrCode);
    
    // Resize the image for PDF
    $qrCodeDataUri = $result->getDataUri();
    
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.athlete-stat-sheet', [
        'athlete' => $athlete,
        'seasonStats' => $athlete->seasonStats,
        'awards' => $athlete->awards,
        'testimonials' => $athlete->testimonials,
        'qrCodeDataUri' => $qrCodeDataUri,
    ]);
    
    $filename = str_replace(' ', '_', $athlete->name) . '_Stat_Sheet.pdf';
    
    return $pdf->download($filename);
});

// OAuth Routes (supports multiple providers: google, github, facebook, etc.)
Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirect'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])->name('social.callback');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/profile', function () {
            return view('admin.profile');
        })->name('profile');
        
        Route::get('/stats', function () {
            return view('admin.stats');
        })->name('stats');
        
        Route::get('/highlights', function () {
            return view('admin.highlights');
        })->name('highlights');
        
        Route::get('/awards', function () {
            return view('admin.awards');
        })->name('awards');
        
        Route::get('/testimonials', function () {
            return view('admin.testimonials');
        })->name('testimonials');
        
        Route::get('/contacts', function () {
            return view('admin.contacts');
        })->name('contacts');
    });
});
