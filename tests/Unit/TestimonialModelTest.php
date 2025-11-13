<?php

namespace Tests\Unit;

use App\Models\AthleteProfile;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TestimonialModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function testimonial_belongs_to_athlete_profile()
    {
        $profile = AthleteProfile::factory()->create();
        $testimonial = Testimonial::factory()->create([
            'athlete_profile_id' => $profile->id,
        ]);

        $this->assertInstanceOf(AthleteProfile::class, $testimonial->athleteProfile);
        $this->assertEquals($profile->id, $testimonial->athleteProfile->id);
    }

    #[Test]
    public function athlete_profile_has_many_testimonials()
    {
        $profile = AthleteProfile::factory()->create();
        Testimonial::factory()->count(3)->create([
            'athlete_profile_id' => $profile->id,
        ]);

        $this->assertCount(3, $profile->testimonials);
    }

    #[Test]
    public function active_scope_filters_active_testimonials()
    {
        $profile = AthleteProfile::factory()->create();
        
        Testimonial::factory()->count(2)->create([
            'athlete_profile_id' => $profile->id,
            'is_active' => true,
        ]);
        
        Testimonial::factory()->create([
            'athlete_profile_id' => $profile->id,
            'is_active' => false,
        ]);

        $activeTestimonials = Testimonial::active()->get();

        $this->assertCount(2, $activeTestimonials);
    }

    #[Test]
    public function featured_scope_filters_featured_testimonials()
    {
        $profile = AthleteProfile::factory()->create();
        
        Testimonial::factory()->featured()->count(2)->create([
            'athlete_profile_id' => $profile->id,
        ]);
        
        Testimonial::factory()->create([
            'athlete_profile_id' => $profile->id,
            'is_featured' => false,
        ]);

        $featuredTestimonials = Testimonial::featured()->get();

        $this->assertCount(2, $featuredTestimonials);
    }

    #[Test]
    public function ordered_scope_sorts_by_order_and_created_at()
    {
        $profile = AthleteProfile::factory()->create();
        
        $testimonial1 = Testimonial::factory()->create([
            'athlete_profile_id' => $profile->id,
            'order' => 2,
            'created_at' => now()->subDays(2),
        ]);
        
        $testimonial2 = Testimonial::factory()->create([
            'athlete_profile_id' => $profile->id,
            'order' => 1,
            'created_at' => now()->subDay(),
        ]);
        
        $testimonial3 = Testimonial::factory()->create([
            'athlete_profile_id' => $profile->id,
            'order' => 1,
            'created_at' => now(),
        ]);

        $orderedTestimonials = Testimonial::where('athlete_profile_id', $profile->id)
            ->ordered()
            ->get();

        $this->assertCount(3, $orderedTestimonials);
        // Order by 'order' ASC, then 'created_at' DESC
        // testimonial3: order=1, created_at=now (newest)
        // testimonial2: order=1, created_at=1 day ago
        // testimonial1: order=2, created_at=2 days ago
        $this->assertEquals($testimonial3->id, $orderedTestimonials[0]->id);
        $this->assertEquals($testimonial2->id, $orderedTestimonials[1]->id);
        $this->assertEquals($testimonial1->id, $orderedTestimonials[2]->id);
    }

    #[Test]
    public function testimonial_casts_date_field()
    {
        $testimonial = Testimonial::factory()->create([
            'date' => '2024-01-15',
        ]);

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $testimonial->date);
    }

    #[Test]
    public function testimonial_casts_boolean_fields()
    {
        $testimonial = Testimonial::factory()->create([
            'is_featured' => true,
            'is_active' => false,
        ]);

        $this->assertTrue($testimonial->is_featured);
        $this->assertFalse($testimonial->is_active);
    }

}
