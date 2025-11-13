<?php

namespace Database\Seeders;

use App\Models\AthleteProfile;
use App\Models\SeasonStat;
use App\Models\Award;
use App\Models\Highlight;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class AthleteProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create athlete profile
        $athlete = AthleteProfile::create([
            'name' => 'Marcus Johnson',
            'sport' => 'football',
            'graduation_year' => 2026,
            'school_name' => 'Lincoln High School',
            'location' => 'Dallas, Texas',
            'height' => '6\'2"',
            'weight' => 185,
            'gpa' => 3.85,
            'email' => 'marcus.johnson@example.com',
            'phone' => '(214) 555-0123',
            'bio' => 'Elite wide receiver with explosive speed, exceptional route-running ability, and proven leadership on and off the field. Committed to excellence in athletics and academics.',
            'story' => "My football journey began in 6th grade when I joined my first organized team. What started as a way to stay active quickly became my passion. Over the years, I've developed into a versatile wide receiver known for my route-running precision, reliable hands, and ability to make plays in crucial moments.\n\nAs a team captain, I lead by example both in practice and games. I'm equally committed to my academic success, maintaining a 3.85 GPA while taking honors courses. My goal is to compete at the collegiate level while pursuing a degree in Business Administration.\n\nI bring energy, dedication, and a strong work ethic to everything I do. I'm looking for a program where I can continue to grow as both an athlete and a student.",
            'social_links' => [
                'twitter' => 'https://twitter.com/example',
                'instagram' => 'https://instagram.com/example',
                'hudl' => 'https://hudl.com/example',
            ],
            'is_active' => true,
        ]);
        
        // Create football-specific profile
        \App\Models\FootballProfile::create([
            'athlete_profile_id' => $athlete->id,
            'position' => 'Wide Receiver',
            'jersey_number' => '7',
            'forty_yard_dash' => 4.45,
            'bench_press' => 225,
            'squat' => 315,
            'vertical_jump' => 36.5,
            'skills' => [
                'Speed & Agility' => 95,
                'Route Running' => 92,
                'Hands & Catching' => 94,
                'Football IQ' => 88,
                'Leadership' => 90,
            ],
        ]);

        // Create season stats
        SeasonStat::create([
            'athlete_profile_id' => $athlete->id,
            'sport' => 'football',
            'season_year' => 2024,
            'competitions' => 10,
            'stats' => [
                'receptions' => 58,
                'receiving_yards' => 982,
                'yards_per_catch' => 16.9,
                'touchdowns' => 14,
            ],
            'notes' => 'Team MVP, led conference in receiving TDs',
        ]);

        SeasonStat::create([
            'athlete_profile_id' => $athlete->id,
            'sport' => 'football',
            'season_year' => 2023,
            'competitions' => 10,
            'stats' => [
                'receptions' => 42,
                'receiving_yards' => 687,
                'yards_per_catch' => 16.4,
                'touchdowns' => 9,
            ],
            'notes' => 'Second Team All-Conference',
        ]);

        SeasonStat::create([
            'athlete_profile_id' => $athlete->id,
            'sport' => 'football',
            'season_year' => 2022,
            'competitions' => 9,
            'stats' => [
                'receptions' => 28,
                'receiving_yards' => 412,
                'yards_per_catch' => 14.7,
                'touchdowns' => 5,
            ],
            'notes' => 'Varsity debut season',
        ]);

        // Create awards
        Award::create([
            'athlete_profile_id' => $athlete->id,
            'title' => 'All-Conference First Team',
            'description' => 'District 6-5A Division I',
            'year' => 2024,
            'icon' => '🏆',
            'color' => 'yellow',
            'order' => 1,
        ]);

        Award::create([
            'athlete_profile_id' => $athlete->id,
            'title' => 'Team Captain',
            'description' => 'Elected by coaches and teammates',
            'year' => 2024,
            'icon' => '⭐',
            'color' => 'blue',
            'order' => 2,
        ]);

        Award::create([
            'athlete_profile_id' => $athlete->id,
            'title' => 'Academic All-State',
            'description' => '3.85 GPA - Honors Student',
            'year' => 2024,
            'icon' => '📚',
            'color' => 'green',
            'order' => 3,
        ]);

        Award::create([
            'athlete_profile_id' => $athlete->id,
            'title' => 'Team MVP',
            'description' => 'Most Valuable Player Award',
            'year' => 2024,
            'icon' => '🥇',
            'color' => 'purple',
            'order' => 4,
        ]);

        Award::create([
            'athlete_profile_id' => $athlete->id,
            'title' => 'All-Conference Second Team',
            'description' => 'District 6-5A Division I',
            'year' => 2023,
            'icon' => '🏅',
            'color' => 'blue',
            'order' => 5,
        ]);

        // Create highlights
        Highlight::create([
            'athlete_profile_id' => $athlete->id,
            'title' => '2024 Senior Season Highlights',
            'description' => 'Complete season highlight reel featuring 14 touchdowns and 982 receiving yards',
            'type' => 'video',
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'duration' => '5:30',
            'order' => 1,
            'is_featured' => true,
            'is_active' => true,
        ]);

        Highlight::create([
            'athlete_profile_id' => $athlete->id,
            'title' => 'Playoff Game vs. Central - 3 TD Performance',
            'description' => '8 receptions, 156 yards, 3 touchdowns in district championship',
            'type' => 'video',
            'video_url' => 'https://www.hudl.com/video/example',
            'duration' => '4:15',
            'order' => 2,
            'is_featured' => true,
            'is_active' => true,
        ]);

        Highlight::create([
            'athlete_profile_id' => $athlete->id,
            'title' => 'Best Catches - 2024',
            'description' => 'One-handed grabs, contested catches, and spectacular plays',
            'type' => 'video',
            'video_url' => 'https://youtu.be/dQw4w9WgXcQ',
            'duration' => '3:20',
            'order' => 3,
            'is_featured' => false,
            'is_active' => true,
        ]);

        Highlight::create([
            'athlete_profile_id' => $athlete->id,
            'title' => 'Speed & Route Running Showcase',
            'description' => 'Film breakdown of route concepts and separation technique',
            'type' => 'video',
            'video_url' => '',
            'duration' => '2:45',
            'order' => 4,
            'is_featured' => false,
            'is_active' => true,
        ]);

        // Create photo highlights (using external URLs for demo - in production these would be uploaded files)
        Highlight::create([
            'athlete_profile_id' => $athlete->id,
            'title' => 'Game Day Action',
            'description' => 'Championship game touchdown celebration',
            'type' => 'photo',
            'photo_path' => 'https://images.unsplash.com/photo-1560272564-c83b66b1ad12?w=1200&q=80',
            'order' => 5,
            'is_featured' => false,
            'is_active' => true,
        ]);

        Highlight::create([
            'athlete_profile_id' => $athlete->id,
            'title' => 'Team Captain',
            'description' => 'Leading the team onto the field',
            'type' => 'photo',
            'photo_path' => 'https://images.unsplash.com/photo-1566577739112-5180d4bf9390?w=1200&q=80',
            'order' => 6,
            'is_featured' => false,
            'is_active' => true,
        ]);

        Highlight::create([
            'athlete_profile_id' => $athlete->id,
            'title' => 'Practice Hard',
            'description' => 'Training session - route running drills',
            'type' => 'photo',
            'photo_path' => 'https://images.unsplash.com/photo-1478760329108-5c3ed9d495a0?w=1200&q=80',
            'order' => 7,
            'is_featured' => false,
            'is_active' => true,
        ]);

        Highlight::create([
            'athlete_profile_id' => $athlete->id,
            'title' => 'Awards Night',
            'description' => 'Receiving Team MVP award',
            'type' => 'photo',
            'photo_path' => 'https://images.unsplash.com/photo-1517649763962-0c623066013b?w=1200&q=80',
            'order' => 8,
            'is_featured' => false,
            'is_active' => true,
        ]);

        Highlight::create([
            'athlete_profile_id' => $athlete->id,
            'title' => 'Team Spirit',
            'description' => 'Celebrating with teammates after big win',
            'type' => 'photo',
            'photo_path' => 'https://images.unsplash.com/photo-1547347298-4074fc3086f0?w=1200&q=80',
            'order' => 9,
            'is_featured' => false,
            'is_active' => true,
        ]);

        // Create testimonials
        Testimonial::create([
            'athlete_profile_id' => $athlete->id,
            'author_name' => 'Coach Mike Anderson',
            'author_title' => 'Head Football Coach',
            'author_organization' => 'Lincoln High School',
            'relationship' => 'Coach',
            'content' => 'Marcus is one of the most dedicated and talented athletes I\'ve coached in my 15-year career. His work ethic is unmatched, and his leadership on and off the field has been instrumental to our team\'s success. He has the physical tools and mental toughness to excel at the next level.',
            'date' => now()->subMonths(1),
            'is_featured' => true,
            'is_active' => true,
            'order' => 1,
        ]);

        Testimonial::create([
            'athlete_profile_id' => $athlete->id,
            'author_name' => 'Sarah Williams',
            'author_title' => 'AP English Teacher',
            'author_organization' => 'Lincoln High School',
            'relationship' => 'Teacher',
            'content' => 'Marcus excels in the classroom just as he does on the field. He consistently demonstrates critical thinking skills, participates actively in discussions, and maintains excellent grades despite a demanding athletic schedule. His time management and dedication are truly impressive.',
            'date' => now()->subMonths(2),
            'is_featured' => true,
            'is_active' => true,
            'order' => 2,
        ]);

        Testimonial::create([
            'athlete_profile_id' => $athlete->id,
            'author_name' => 'James Cooper',
            'author_title' => 'Quarterback',
            'author_organization' => 'Lincoln High School',
            'relationship' => 'Teammate',
            'content' => 'Playing with Marcus has made me a better quarterback. His route running is precise, and he has incredible hands. What stands out most is his attitude - he\'s always encouraging teammates and pushing everyone to be better. He\'s a true leader and someone I trust in crucial moments.',
            'date' => now()->subMonths(3),
            'is_featured' => false,
            'is_active' => true,
            'order' => 3,
        ]);

        Testimonial::create([
            'athlete_profile_id' => $athlete->id,
            'author_name' => 'David Martinez',
            'author_title' => 'Athletic Director',
            'author_organization' => 'Lincoln High School',
            'relationship' => 'Athletic Director',
            'content' => 'Marcus represents everything we want in a student-athlete. His commitment to academics, leadership qualities, and athletic performance make him an outstanding representative of our program. College coaches will be fortunate to have him.',
            'date' => now()->subMonths(4),
            'is_featured' => false,
            'is_active' => true,
            'order' => 4,
        ]);
    }
}
