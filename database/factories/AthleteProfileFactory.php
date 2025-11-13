<?php

namespace Database\Factories;

use App\Models\AthleteProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class AthleteProfileFactory extends Factory
{
    protected $model = AthleteProfile::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'sport' => 'football',
            'graduation_year' => fake()->numberBetween(2024, 2028),
            'school_name' => fake()->words(2, true) . ' High School',
            'location' => fake()->city() . ', ' . fake()->stateAbbr(),
            'height' => fake()->randomElement(['5\'10"', '6\'0"', '6\'2"', '6\'4"']),
            'weight' => fake()->numberBetween(170, 230),
            'gpa' => fake()->randomFloat(2, 2.5, 4.0),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'bio' => fake()->paragraph(),
            'story' => fake()->paragraphs(3, true),
            'profile_image' => null,
            'social_links' => [
                'facebook' => fake()->url(),
                'twitter' => fake()->url(),
                'instagram' => fake()->url(),
            ],
            'is_active' => true,
        ];
    }
    
    public function configure()
    {
        return $this->afterCreating(function (AthleteProfile $profile) {
            // Create football profile by default
            if ($profile->sport === 'football') {
                \App\Models\FootballProfile::create([
                    'athlete_profile_id' => $profile->id,
                    'position' => fake()->randomElement(['Wide Receiver', 'Quarterback', 'Running Back', 'Linebacker']),
                    'jersey_number' => fake()->numberBetween(1, 99),
                    'forty_yard_dash' => fake()->randomFloat(2, 4.3, 5.0),
                    'bench_press' => fake()->numberBetween(185, 315),
                    'squat' => fake()->numberBetween(225, 405),
                    'vertical_jump' => fake()->randomFloat(1, 28, 42),
                    'skills' => [
                        'Speed & Agility' => fake()->numberBetween(70, 95),
                        'Route Running' => fake()->numberBetween(70, 95),
                        'Hands & Catching' => fake()->numberBetween(70, 95),
                        'Football IQ' => fake()->numberBetween(70, 95),
                        'Leadership' => fake()->numberBetween(70, 95),
                    ],
                ]);
            }
        });
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    public function basketball(): static
    {
        return $this->state(fn (array $attributes) => [
            'sport' => 'basketball',
        ])->afterCreating(function (AthleteProfile $profile) {
            \App\Models\BasketballProfile::create([
                'athlete_profile_id' => $profile->id,
                'position' => fake()->randomElement(['Point Guard', 'Shooting Guard', 'Small Forward', 'Power Forward', 'Center']),
                'jersey_number' => fake()->numberBetween(1, 55),
                'sprint_speed' => fake()->randomFloat(2, 3.0, 4.5),
                'vertical_jump' => fake()->randomFloat(1, 26, 40),
                'wingspan' => fake()->randomFloat(1, 72, 90),
                'skills' => [
                    'Shooting' => fake()->numberBetween(70, 95),
                    'Ball Handling' => fake()->numberBetween(70, 95),
                    'Defense' => fake()->numberBetween(70, 95),
                    'Rebounding' => fake()->numberBetween(70, 95),
                    'Passing' => fake()->numberBetween(70, 95),
                ],
            ]);
        });
    }

    public function baseball(): static
    {
        return $this->state(fn (array $attributes) => [
            'sport' => 'baseball',
        ])->afterCreating(function (AthleteProfile $profile) {
            \App\Models\BaseballProfile::create([
                'athlete_profile_id' => $profile->id,
                'position' => fake()->randomElement(['Pitcher', 'Catcher', 'First Base', 'Shortstop', 'Outfield']),
                'jersey_number' => fake()->numberBetween(1, 99),
                'sixty_yard_dash' => fake()->randomFloat(2, 6.5, 7.5),
                'exit_velocity' => fake()->randomFloat(1, 75, 95),
                'batting_stance' => fake()->randomElement(['Right', 'Left', 'Switch']),
                'throwing_hand' => fake()->randomElement(['Right', 'Left']),
                'skills' => [
                    'Hitting' => fake()->numberBetween(70, 95),
                    'Fielding' => fake()->numberBetween(70, 95),
                    'Pitching' => fake()->numberBetween(70, 95),
                    'Base Running' => fake()->numberBetween(70, 95),
                    'Arm Strength' => fake()->numberBetween(70, 95),
                ],
            ]);
        });
    }
}
