<?php

namespace Database\Factories;

use App\Models\AthleteProfile;
use App\Models\Award;
use Illuminate\Database\Eloquent\Factories\Factory;

class AwardFactory extends Factory
{
    protected $model = Award::class;

    public function definition(): array
    {
        return [
            'athlete_profile_id' => AthleteProfile::factory(),
            'title' => fake()->randomElement([
                'All-District First Team',
                'All-Region',
                'Team MVP',
                'Academic All-State',
                'Team Captain',
                'Offensive Player of the Year',
                'District Champion',
            ]),
            'description' => fake()->optional()->sentence(),
            'year' => fake()->numberBetween(2020, 2024),
            'icon' => fake()->randomElement(['🏆', '🥇', '⭐', '🎖️']),
            'color' => fake()->randomElement(['yellow', 'blue', 'green', 'purple', 'red', 'indigo']),
            'order' => fake()->numberBetween(1, 10),
        ];
    }
}
