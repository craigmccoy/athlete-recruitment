<?php

namespace App\Livewire\Admin;

use App\Models\AthleteProfile;
use App\Models\FootballProfile;
use App\Models\BasketballProfile;
use App\Models\BaseballProfile;
use App\Models\SoccerProfile;
use App\Models\TrackProfile;
use Livewire\Component;
use Livewire\WithFileUploads;

class ManageProfile extends Component
{
    use WithFileUploads;

    public $profile;
    public $sportProfile;
    
    // Universal athlete data
    public $name, $sport, $graduation_year, $school_name;
    public $location, $height, $weight, $gpa;
    public $email, $phone, $bio, $story;
    public $facebook, $twitter, $instagram;
    public $profile_image;
    public $existing_image;
    
    // Sport-specific fields (dynamically used based on sport)
    public $position, $jersey_number;
    
    // Football-specific
    public $forty_yard_dash, $bench_press, $squat, $vertical_jump;
    public $skill_speed, $skill_route, $skill_catching, $skill_iq, $skill_leadership;
    
    // Basketball-specific
    public $wingspan, $sprint_speed;
    public $skill_shooting, $skill_ball_handling, $skill_defense, $skill_rebounding, $skill_passing;
    
    // Baseball-specific
    public $sixty_yard_dash, $exit_velocity, $batting_stance, $throwing_hand;
    public $skill_hitting, $skill_fielding, $skill_pitching, $skill_base_running, $skill_arm_strength;
    
    // Soccer-specific
    public $preferred_foot;
    public $skill_dribbling, $skill_soccer_passing, $skill_shooting_soccer, $skill_defending, $skill_stamina;
    
    // Track-specific
    public $events, $personal_records;

    protected $rules = [
        'name' => 'required|string|max:255',
        'sport' => 'required|string',
        'graduation_year' => 'required|integer|min:2020|max:2030',
        'school_name' => 'required|string|max:255',
        'gpa' => 'nullable|numeric|min:0|max:4.0',
        'email' => 'nullable|email',
        'profile_image' => 'nullable|image|max:5120', // 5MB max
    ];

    public function mount()
    {
        $this->profile = AthleteProfile::where('is_active', true)
            ->with(['footballProfile', 'basketballProfile', 'baseballProfile', 'soccerProfile', 'trackProfile'])
            ->first();
        
        if ($this->profile) {
            // Load universal data
            $this->fill([
                'name' => $this->profile->name,
                'sport' => $this->profile->sport ?? 'football',
                'graduation_year' => $this->profile->graduation_year,
                'school_name' => $this->profile->school_name,
                'location' => $this->profile->location,
                'height' => $this->profile->height,
                'weight' => $this->profile->weight,
                'gpa' => $this->profile->gpa,
                'email' => $this->profile->email,
                'phone' => $this->profile->phone,
                'bio' => $this->profile->bio,
                'story' => $this->profile->story,
                'facebook' => $this->profile->social_links['facebook'] ?? '',
                'twitter' => $this->profile->social_links['twitter'] ?? '',
                'instagram' => $this->profile->social_links['instagram'] ?? '',
            ]);
            $this->existing_image = $this->profile->profile_image;
            
            // Load sport-specific data
            $this->loadSportSpecificData();
        } else {
            // Set defaults for new profiles
            $this->sport = 'football';
            $this->graduation_year = now()->year + 1;
            $this->setDefaultSkills();
        }
    }
    
    protected function loadSportSpecificData()
    {
        $sport = $this->profile->sport ?? 'football';
        $sportProfile = $this->profile->sportProfile();
        
        if (!$sportProfile) {
            $this->setDefaultSkills();
            return;
        }
        
        $this->sportProfile = $sportProfile;
        
        // Load common fields
        $this->position = $sportProfile->position ?? '';
        $this->jersey_number = $sportProfile->jersey_number ?? '';
        
        // Load sport-specific fields and skills
        match($sport) {
            'football' => $this->loadFootballData($sportProfile),
            'basketball' => $this->loadBasketballData($sportProfile),
            'baseball' => $this->loadBaseballData($sportProfile),
            'soccer' => $this->loadSoccerData($sportProfile),
            'track' => $this->loadTrackData($sportProfile),
            default => null,
        };
    }
    
    protected function loadFootballData($profile)
    {
        $this->forty_yard_dash = $profile->forty_yard_dash;
        $this->bench_press = $profile->bench_press;
        $this->squat = $profile->squat;
        $this->vertical_jump = $profile->vertical_jump;
        
        $skills = $profile->skills ?? [];
        $this->skill_speed = $skills['Speed & Agility'] ?? 85;
        $this->skill_route = $skills['Route Running'] ?? 85;
        $this->skill_catching = $skills['Hands & Catching'] ?? 85;
        $this->skill_iq = $skills['Football IQ'] ?? 85;
        $this->skill_leadership = $skills['Leadership'] ?? 85;
    }
    
    protected function loadBasketballData($profile)
    {
        $this->vertical_jump = $profile->vertical_jump;
        $this->sprint_speed = $profile->sprint_speed;
        $this->wingspan = $profile->wingspan;
        
        $skills = $profile->skills ?? [];
        $this->skill_shooting = $skills['Shooting'] ?? 85;
        $this->skill_ball_handling = $skills['Ball Handling'] ?? 85;
        $this->skill_defense = $skills['Defense'] ?? 85;
        $this->skill_rebounding = $skills['Rebounding'] ?? 85;
        $this->skill_passing = $skills['Passing'] ?? 85;
    }
    
    protected function loadBaseballData($profile)
    {
        $this->sixty_yard_dash = $profile->sixty_yard_dash;
        $this->exit_velocity = $profile->exit_velocity;
        $this->batting_stance = $profile->batting_stance;
        $this->throwing_hand = $profile->throwing_hand;
        
        $skills = $profile->skills ?? [];
        $this->skill_hitting = $skills['Hitting'] ?? 85;
        $this->skill_fielding = $skills['Fielding'] ?? 85;
        $this->skill_pitching = $skills['Pitching'] ?? 85;
        $this->skill_base_running = $skills['Base Running'] ?? 85;
        $this->skill_arm_strength = $skills['Arm Strength'] ?? 85;
    }
    
    protected function loadSoccerData($profile)
    {
        $this->sprint_speed = $profile->sprint_speed;
        $this->preferred_foot = $profile->preferred_foot;
        
        $skills = $profile->skills ?? [];
        $this->skill_dribbling = $skills['Dribbling'] ?? 85;
        $this->skill_soccer_passing = $skills['Passing'] ?? 85;
        $this->skill_shooting_soccer = $skills['Shooting'] ?? 85;
        $this->skill_defending = $skills['Defending'] ?? 85;
        $this->skill_stamina = $skills['Stamina'] ?? 85;
    }
    
    protected function loadTrackData($profile)
    {
        $this->events = $profile->events;
        $this->personal_records = is_array($profile->personal_records) ? json_encode($profile->personal_records) : $profile->personal_records;
    }
    
    protected function setDefaultSkills()
    {
        // Football defaults
        $this->skill_speed = 85;
        $this->skill_route = 85;
        $this->skill_catching = 85;
        $this->skill_iq = 85;
        $this->skill_leadership = 85;
        
        // Basketball defaults
        $this->skill_shooting = 85;
        $this->skill_ball_handling = 85;
        $this->skill_defense = 85;
        $this->skill_rebounding = 85;
        $this->skill_passing = 85;
        
        // Baseball defaults
        $this->skill_hitting = 85;
        $this->skill_fielding = 85;
        $this->skill_pitching = 85;
        $this->skill_base_running = 85;
        $this->skill_arm_strength = 85;
        
        // Soccer defaults
        $this->skill_dribbling = 85;
        $this->skill_soccer_passing = 85;
        $this->skill_shooting_soccer = 85;
        $this->skill_defending = 85;
        $this->skill_stamina = 85;
    }

    public function save()
    {
        $this->validate();

        // Handle image upload
        $imagePath = $this->existing_image;
        
        if ($this->profile_image) {
            try {
                // Delete old image if it exists
                if ($this->existing_image && \Storage::disk('public')->exists($this->existing_image)) {
                    \Storage::disk('public')->delete($this->existing_image);
                }
                // Store new image
                $imagePath = $this->profile_image->store('profile-images', 'public');
            } catch (\Exception $e) {
                session()->flash('error', 'Image upload failed: ' . $e->getMessage());
                return;
            }
        }

        // Save universal athlete profile data
        $data = [
            'name' => $this->name,
            'sport' => $this->sport,
            'graduation_year' => $this->graduation_year,
            'school_name' => $this->school_name,
            'location' => $this->location,
            'height' => $this->height,
            'weight' => $this->weight,
            'gpa' => $this->gpa,
            'email' => $this->email,
            'phone' => $this->phone,
            'bio' => $this->bio,
            'story' => $this->story,
            'profile_image' => $imagePath,
            'social_links' => [
                'facebook' => $this->facebook,
                'twitter' => $this->twitter,
                'instagram' => $this->instagram,
            ],
        ];

        if ($this->profile) {
            $this->profile->update($data);
        } else {
            $this->profile = AthleteProfile::create($data);
        }

        // Save sport-specific profile
        $this->saveSportSpecificProfile();

        // Reload the profile to get fresh data
        $this->profile->refresh();
        $this->existing_image = $this->profile->profile_image;
        $this->profile_image = null;

        session()->flash('message', 'Profile updated successfully!');
    }
    
    protected function saveSportSpecificProfile()
    {
        match($this->sport) {
            'football' => $this->saveFootballProfile(),
            'basketball' => $this->saveBasketballProfile(),
            'baseball' => $this->saveBaseballProfile(),
            'soccer' => $this->saveSoccerProfile(),
            'track' => $this->saveTrackProfile(),
            default => null,
        };
    }
    
    protected function saveFootballProfile()
    {
        $data = [
            'athlete_profile_id' => $this->profile->id,
            'position' => $this->position,
            'jersey_number' => $this->jersey_number,
            'forty_yard_dash' => $this->forty_yard_dash,
            'bench_press' => $this->bench_press,
            'squat' => $this->squat,
            'vertical_jump' => $this->vertical_jump,
            'skills' => [
                'Speed & Agility' => $this->skill_speed,
                'Route Running' => $this->skill_route,
                'Hands & Catching' => $this->skill_catching,
                'Football IQ' => $this->skill_iq,
                'Leadership' => $this->skill_leadership,
            ],
        ];
        
        FootballProfile::updateOrCreate(
            ['athlete_profile_id' => $this->profile->id],
            $data
        );
    }
    
    protected function saveBasketballProfile()
    {
        $data = [
            'athlete_profile_id' => $this->profile->id,
            'position' => $this->position,
            'jersey_number' => $this->jersey_number,
            'vertical_jump' => $this->vertical_jump,
            'sprint_speed' => $this->sprint_speed,
            'wingspan' => $this->wingspan,
            'skills' => [
                'Shooting' => $this->skill_shooting,
                'Ball Handling' => $this->skill_ball_handling,
                'Defense' => $this->skill_defense,
                'Rebounding' => $this->skill_rebounding,
                'Passing' => $this->skill_passing,
            ],
        ];
        
        BasketballProfile::updateOrCreate(
            ['athlete_profile_id' => $this->profile->id],
            $data
        );
    }
    
    protected function saveBaseballProfile()
    {
        $data = [
            'athlete_profile_id' => $this->profile->id,
            'position' => $this->position,
            'jersey_number' => $this->jersey_number,
            'sixty_yard_dash' => $this->sixty_yard_dash,
            'exit_velocity' => $this->exit_velocity,
            'batting_stance' => $this->batting_stance,
            'throwing_hand' => $this->throwing_hand,
            'skills' => [
                'Hitting' => $this->skill_hitting,
                'Fielding' => $this->skill_fielding,
                'Pitching' => $this->skill_pitching,
                'Base Running' => $this->skill_base_running,
                'Arm Strength' => $this->skill_arm_strength,
            ],
        ];
        
        BaseballProfile::updateOrCreate(
            ['athlete_profile_id' => $this->profile->id],
            $data
        );
    }
    
    protected function saveSoccerProfile()
    {
        $data = [
            'athlete_profile_id' => $this->profile->id,
            'position' => $this->position,
            'jersey_number' => $this->jersey_number,
            'sprint_speed' => $this->sprint_speed,
            'preferred_foot' => $this->preferred_foot,
            'skills' => [
                'Dribbling' => $this->skill_dribbling,
                'Passing' => $this->skill_soccer_passing,
                'Shooting' => $this->skill_shooting_soccer,
                'Defending' => $this->skill_defending,
                'Stamina' => $this->skill_stamina,
            ],
        ];
        
        SoccerProfile::updateOrCreate(
            ['athlete_profile_id' => $this->profile->id],
            $data
        );
    }
    
    protected function saveTrackProfile()
    {
        $personalRecords = $this->personal_records;
        if (is_string($personalRecords)) {
            $personalRecords = json_decode($personalRecords, true);
        }
        
        $data = [
            'athlete_profile_id' => $this->profile->id,
            'events' => $this->events,
            'personal_records' => $personalRecords,
            'skills' => null,
        ];
        
        TrackProfile::updateOrCreate(
            ['athlete_profile_id' => $this->profile->id],
            $data
        );
    }

    public function render()
    {
        return view('livewire.admin.manage-profile');
    }
}
