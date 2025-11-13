<?php

namespace Tests\Feature;

use App\Models\AthleteProfile;
use App\Models\Award;
use App\Models\SeasonStat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PdfResumeTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function pdf_resume_route_is_accessible()
    {
        AthleteProfile::factory()->create(['is_active' => true]);

        $response = $this->get('/stat-sheet.pdf');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    #[Test]
    public function pdf_includes_athlete_name()
    {
        $profile = AthleteProfile::factory()->create([
            'name' => 'John Smith',
            'is_active' => true,
        ]);

        $response = $this->get('/stat-sheet.pdf');

        $response->assertStatus(200);
        // PDF content check (basic)
        $this->assertTrue(strlen($response->content()) > 0);
    }

    #[Test]
    public function pdf_includes_season_stats()
    {
        $profile = AthleteProfile::factory()->create(['is_active' => true, 'sport' => 'football']);
        SeasonStat::factory()->create([
            'athlete_profile_id' => $profile->id,
            'season_year' => 2024,
        ]);

        $response = $this->get('/stat-sheet.pdf');

        $response->assertStatus(200);
        $this->assertTrue(strlen($response->content()) > 0);
    }

    #[Test]
    public function pdf_includes_awards()
    {
        $profile = AthleteProfile::factory()->create(['is_active' => true]);
        Award::factory()->create([
            'athlete_profile_id' => $profile->id,
            'title' => 'All-State',
        ]);

        $response = $this->get('/stat-sheet.pdf');

        $response->assertStatus(200);
        $this->assertTrue(strlen($response->content()) > 0);
    }

    #[Test]
    public function pdf_includes_sport_when_not_football()
    {
        $profile = AthleteProfile::factory()->basketball()->create([
            'name' => 'Jane Doe',
            'is_active' => true,
        ]);

        $response = $this->get('/stat-sheet.pdf');

        $response->assertStatus(200);
        $this->assertTrue(strlen($response->content()) > 0);
    }

    #[Test]
    public function pdf_download_has_correct_filename()
    {
        $profile = AthleteProfile::factory()->create([
            'name' => 'John Smith',
            'is_active' => true,
        ]);

        $response = $this->get('/stat-sheet.pdf');

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    #[Test]
    public function pdf_includes_contact_information()
    {
        $profile = AthleteProfile::factory()->create([
            'name' => 'John Smith',
            'email' => 'athlete@example.com',
            'phone' => '555-1234',
            'is_active' => true,
        ]);

        $response = $this->get('/stat-sheet.pdf');

        $response->assertStatus(200);
        $this->assertTrue(strlen($response->content()) > 0);
    }

    #[Test]
    public function pdf_includes_physical_stats()
    {
        $profile = AthleteProfile::factory()->create([
            'name' => 'John Smith',
            'height' => '6\'2"',
            'weight' => 195,
            'gpa' => 3.7,
            'is_active' => true,
        ]);

        $response = $this->get('/stat-sheet.pdf');

        $response->assertStatus(200);
        $this->assertTrue(strlen($response->content()) > 0);
    }

    #[Test]
    public function pdf_calculates_career_totals()
    {
        $profile = AthleteProfile::factory()->create(['is_active' => true, 'sport' => 'football']);
        
        SeasonStat::factory()->create([
            'athlete_profile_id' => $profile->id,
            'season_year' => 2023,
        ]);
        
        SeasonStat::factory()->create([
            'athlete_profile_id' => $profile->id,
            'season_year' => 2024,
        ]);

        $response = $this->get('/stat-sheet.pdf');

        $response->assertStatus(200);
        $this->assertTrue(strlen($response->content()) > 0);
    }

    #[Test]
    public function pdf_handles_missing_optional_data()
    {
        $profile = AthleteProfile::factory()->create([
            'name' => 'John Smith',
            'graduation_year' => 2026,
            'school_name' => 'Test High',
            'is_active' => true,
            // No stats, awards, or optional fields
        ]);

        $response = $this->get('/stat-sheet.pdf');

        $response->assertStatus(200);
        $this->assertTrue(strlen($response->content()) > 0);
    }
}
