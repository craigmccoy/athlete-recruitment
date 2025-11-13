<?php

namespace Database\Factories;

use App\Models\AthleteProfile;
use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestimonialFactory extends Factory
{
    protected $model = Testimonial::class;

    public function definition(): array
    {
        $relationships = ['Coach', 'Teammate', 'Teacher', 'Athletic Director', 'Mentor', 'Trainer'];
        $titles = [
            'Head Football Coach',
            'Offensive Coordinator',
            'Athletic Director',
            'Team Captain',
            'Guidance Counselor',
            'Physical Education Teacher',
            'Strength & Conditioning Coach',
        ];

        return [
            'athlete_profile_id' => AthleteProfile::factory(),
            'author_name' => fake()->name(),
            'author_title' => fake()->randomElement($titles),
            'author_organization' => fake()->company() . ' High School',
            'content' => fake()->paragraph(4),
            'relationship' => fake()->randomElement($relationships),
            'date' => fake()->dateTimeBetween('-2 years', 'now'),
            'author_image' => null,
            'is_featured' => false,
            'is_active' => true,
            'order' => fake()->numberBetween(0, 10),
        ];
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    public function fromCoach(): static
    {
        return $this->state(fn (array $attributes) => [
            'relationship' => 'Coach',
            'author_title' => 'Head Football Coach',
        ]);
    }
}
