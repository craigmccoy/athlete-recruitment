<?php

namespace Database\Factories;

use App\Models\AthleteProfile;
use App\Models\SeasonStat;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeasonStatFactory extends Factory
{
    protected $model = SeasonStat::class;

    public function definition(): array
    {
        return [
            'athlete_profile_id' => AthleteProfile::factory(),
            'sport' => 'football',
            'season_year' => fake()->numberBetween(2020, 2024),
            'competitions' => fake()->numberBetween(8, 12),
            'stats' => $this->footballStats(),
            'notes' => fake()->optional()->sentence(),
        ];
    }

    private function footballStats(): array
    {
        $receptions = fake()->numberBetween(20, 80);
        $receivingYards = fake()->numberBetween(300, 1500);
        
        return [
            'receptions' => $receptions,
            'receiving_yards' => $receivingYards,
            'yards_per_catch' => $receptions > 0 ? round($receivingYards / $receptions, 2) : 0,
            'touchdowns' => fake()->numberBetween(0, 15),
        ];
    }

    public function basketball(): static
    {
        return $this->state(fn (array $attributes) => [
            'sport' => 'basketball',
            'stats' => [
                'points_per_game' => fake()->randomFloat(1, 5, 30),
                'rebounds_per_game' => fake()->randomFloat(1, 2, 12),
                'assists_per_game' => fake()->randomFloat(1, 1, 10),
                'field_goal_percentage' => fake()->randomFloat(1, 35, 55),
            ],
        ]);
    }

    public function baseball(): static
    {
        return $this->state(fn (array $attributes) => [
            'sport' => 'baseball',
            'stats' => [
                'batting_average' => fake()->randomFloat(3, 0.200, 0.400),
                'home_runs' => fake()->numberBetween(0, 25),
                'rbis' => fake()->numberBetween(5, 80),
                'stolen_bases' => fake()->numberBetween(0, 30),
            ],
        ]);
    }

    public function soccer(): static
    {
        return $this->state(fn (array $attributes) => [
            'sport' => 'soccer',
            'stats' => [
                'goals' => fake()->numberBetween(0, 25),
                'assists' => fake()->numberBetween(0, 15),
                'shots' => fake()->numberBetween(20, 100),
                'shots_on_goal' => fake()->numberBetween(10, 60),
            ],
        ]);
    }

    public function track(): static
    {
        return $this->state(fn (array $attributes) => [
            'sport' => 'track',
            'stats' => [
                'best_time' => fake()->randomElement(['10.8s', '11.2s', '22.5s', '48.9s']),
                'personal_record' => fake()->randomElement(['10.5s', '10.9s', '22.1s', '47.8s']),
                'medals' => fake()->numberBetween(0, 10),
            ],
        ]);
    }
}
