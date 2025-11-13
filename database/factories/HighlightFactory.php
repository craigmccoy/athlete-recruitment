<?php

namespace Database\Factories;

use App\Models\AthleteProfile;
use App\Models\Highlight;
use Illuminate\Database\Eloquent\Factories\Factory;

class HighlightFactory extends Factory
{
    protected $model = Highlight::class;

    public function definition(): array
    {
        return [
            'athlete_profile_id' => AthleteProfile::factory(),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'type' => 'video',
            'video_url' => 'https://youtube.com/watch?v=' . fake()->regexify('[A-Za-z0-9]{11}'),
            'thumbnail_url' => null,
            'duration' => fake()->randomElement(['2:30', '3:45', '5:00', '4:15']),
            'order' => fake()->numberBetween(1, 10),
            'is_featured' => false,
            'is_active' => true,
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

    public function hudl(): static
    {
        return $this->state(fn (array $attributes) => [
            'video_url' => 'https://hudl.com/video/' . fake()->numberBetween(100000, 999999),
        ]);
    }
}
