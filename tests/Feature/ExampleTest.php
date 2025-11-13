<?php

namespace Tests\Feature;

use App\Models\AthleteProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        // Create an active athlete profile for the homepage
        AthleteProfile::factory()->create(['is_active' => true]);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
