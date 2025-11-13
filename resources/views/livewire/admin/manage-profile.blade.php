<div x-data>
    @if (session()->has('message'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    @if (!$profile)
        <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Welcome! Let's create your athlete profile</h3>
                    <p class="mt-1 text-sm text-blue-700">
                        Fill out the form below to create your recruitment website. All fields marked with * are required. You can always come back and update this information later.
                    </p>
                </div>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <strong>Validation Errors:</strong>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form wire:submit="save" class="space-y-8">
        <!-- Profile Image -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Profile Image</h3>
            <div class="flex items-start space-x-6">
                <!-- Current Image Preview -->
                <div class="flex-shrink-0" wire:key="image-preview-{{ $existing_image }}">
                    @if($profile_image)
                        <img src="{{ $profile_image->temporaryUrl() }}" alt="Preview" class="w-32 h-32 object-cover rounded-lg border-2 border-gray-300">
                    @elseif($existing_image)
                        <img src="{{ asset('storage/' . $existing_image) }}?t={{ now()->timestamp }}" alt="Current Profile" class="w-32 h-32 object-cover rounded-lg border-2 border-gray-300">
                    @else
                        <div class="w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center border-2 border-gray-300">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Upload Field -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload New Image</label>
                    <input type="file" wire:model="profile_image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    @error('profile_image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    <p class="text-xs text-gray-500 mt-2">Recommended: Square image, at least 400x400px. Max 5MB.</p>
                    @if($profile_image)
                        <p class="text-sm text-green-600 mt-2">✓ New image selected ({{ $profile_image->getClientOriginalName() }})</p>
                    @endif
                    <div wire:loading wire:target="profile_image" class="text-sm text-blue-600 mt-2">
                        Uploading...
                    </div>
                </div>
            </div>
        </div>

        <!-- Basic Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                    <input type="text" wire:model="name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sport *</label>
                    <select wire:model="sport" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach(\App\Helpers\SportConfig::getSports() as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('sport') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Position and Jersey Number - shown for most sports except track -->
                <div x-show="$wire.sport !== 'track'">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Position *</label>
                    <input type="text" wire:model="position" placeholder="e.g., Wide Receiver, Point Guard, Pitcher" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('position') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    <p class="text-xs text-gray-500 mt-1">Position will vary based on selected sport</p>
                </div>

                <div x-show="$wire.sport !== 'track'">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jersey Number</label>
                    <input type="text" wire:model="jersey_number" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Graduation Year *</label>
                    <input type="number" wire:model="graduation_year" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('graduation_year') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">School Name *</label>
                    <input type="text" wire:model="school_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('school_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                    <input type="text" wire:model="location" placeholder="City, State" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>

        <!-- Physical Stats -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Physical Stats</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Height</label>
                    <input type="text" wire:model="height" placeholder='6\'2"' class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Weight (lbs)</label>
                    <input type="number" wire:model="weight" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">GPA</label>
                    <input type="number" step="0.01" wire:model="gpa" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('gpa') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        
        <!-- Sport-Specific Performance Metrics -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Sport-Specific Metrics</h3>
            
            <!-- Football Metrics -->
            <div x-show="$wire.sport === 'football'" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">40-Yard Dash (sec)</label>
                    <input type="number" step="0.01" wire:model="forty_yard_dash" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bench Press (lbs)</label>
                    <input type="number" step="0.1" wire:model="bench_press" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Squat (lbs)</label>
                    <input type="number" step="0.1" wire:model="squat" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Vertical Jump (in)</label>
                    <input type="number" step="0.1" wire:model="vertical_jump" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            
            <!-- Basketball Metrics -->
            <div x-show="$wire.sport === 'basketball'" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sprint Speed (sec)</label>
                    <input type="number" step="0.01" wire:model="sprint_speed" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Vertical Jump (in)</label>
                    <input type="number" step="0.1" wire:model="vertical_jump" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Wingspan (in)</label>
                    <input type="number" step="0.1" wire:model="wingspan" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            
            <!-- Baseball Metrics -->
            <div x-show="$wire.sport === 'baseball'" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">60-Yard Dash (sec)</label>
                    <input type="number" step="0.01" wire:model="sixty_yard_dash" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Exit Velocity (mph)</label>
                    <input type="number" step="0.1" wire:model="exit_velocity" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Batting Stance</label>
                    <select wire:model="batting_stance" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select...</option>
                        <option value="Right">Right</option>
                        <option value="Left">Left</option>
                        <option value="Switch">Switch</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Throwing Hand</label>
                    <select wire:model="throwing_hand" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select...</option>
                        <option value="Right">Right</option>
                        <option value="Left">Left</option>
                    </select>
                </div>
            </div>
            
            <!-- Soccer Metrics -->
            <div x-show="$wire.sport === 'soccer'" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sprint Speed (sec)</label>
                    <input type="number" step="0.01" wire:model="sprint_speed" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Preferred Foot</label>
                    <select wire:model="preferred_foot" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select...</option>
                        <option value="Right">Right</option>
                        <option value="Left">Left</option>
                        <option value="Both">Both</option>
                    </select>
                </div>
            </div>
            
            <!-- Track Metrics -->
            <div x-show="$wire.sport === 'track'" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Events</label>
                    <input type="text" wire:model="events" placeholder="e.g., 100m, 200m, Long Jump" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Comma-separated list of events</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Personal Records (JSON)</label>
                    <textarea wire:model="personal_records" rows="3" placeholder='{"100m": "10.5s", "200m": "21.2s"}' class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    <p class="text-xs text-gray-500 mt-1">JSON format of personal records for each event</p>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" wire:model="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                    <input type="tel" wire:model="phone" placeholder="(555) 123-4567" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>

        <!-- Bio & Story -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Bio & Story</h3>
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Short Bio</label>
                    <textarea wire:model="bio" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    <p class="text-sm text-gray-500 mt-1">Brief description for hero section</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Story</label>
                    <textarea wire:model="story" rows="5" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    <p class="text-sm text-gray-500 mt-1">Detailed story for about section</p>
                </div>
            </div>
        </div>

        <!-- Social Media -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Social Media Links</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Facebook URL</label>
                    <input type="url" wire:model="facebook" placeholder="https://facebook.com/..." class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Twitter/X URL</label>
                    <input type="url" wire:model="twitter" placeholder="https://twitter.com/..." class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Instagram URL</label>
                    <input type="url" wire:model="instagram" placeholder="https://instagram.com/..." class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>

        <!-- Sport-Specific Skills -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Skills (0-100%)</h3>
            
            <!-- Football Skills -->
            <div x-show="$wire.sport === 'football'" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Speed & Agility: {{ $skill_speed }}%</label>
                    <input type="range" wire:model.live="skill_speed" min="0" max="100" class="w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Route Running: {{ $skill_route }}%</label>
                    <input type="range" wire:model.live="skill_route" min="0" max="100" class="w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hands & Catching: {{ $skill_catching }}%</label>
                    <input type="range" wire:model.live="skill_catching" min="0" max="100" class="w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Football IQ: {{ $skill_iq }}%</label>
                    <input type="range" wire:model.live="skill_iq" min="0" max="100" class="w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Leadership: {{ $skill_leadership }}%</label>
                    <input type="range" wire:model.live="skill_leadership" min="0" max="100" class="w-full">
                </div>
            </div>
            
            <!-- Basketball Skills -->
            <div x-show="$wire.sport === 'basketball'" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Shooting: {{ $skill_shooting }}%</label>
                    <input type="range" wire:model.live="skill_shooting" min="0" max="100" class="w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ball Handling: {{ $skill_ball_handling }}%</label>
                    <input type="range" wire:model.live="skill_ball_handling" min="0" max="100" class="w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Defense: {{ $skill_defense }}%</label>
                    <input type="range" wire:model.live="skill_defense" min="0" max="100" class="w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rebounding: {{ $skill_rebounding }}%</label>
                    <input type="range" wire:model.live="skill_rebounding" min="0" max="100" class="w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Passing: {{ $skill_passing }}%</label>
                    <input type="range" wire:model.live="skill_passing" min="0" max="100" class="w-full">
                </div>
            </div>
            
            <!-- Baseball Skills -->
            <div x-show="$wire.sport === 'baseball'" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hitting: {{ $skill_hitting }}%</label>
                    <input type="range" wire:model.live="skill_hitting" min="0" max="100" class="w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fielding: {{ $skill_fielding }}%</label>
                    <input type="range" wire:model.live="skill_fielding" min="0" max="100" class="w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pitching: {{ $skill_pitching }}%</label>
                    <input type="range" wire:model.live="skill_pitching" min="0" max="100" class="w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Base Running: {{ $skill_base_running }}%</label>
                    <input type="range" wire:model.live="skill_base_running" min="0" max="100" class="w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Arm Strength: {{ $skill_arm_strength }}%</label>
                    <input type="range" wire:model.live="skill_arm_strength" min="0" max="100" class="w-full">
                </div>
            </div>
            
            <!-- Soccer Skills -->
            <div x-show="$wire.sport === 'soccer'" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dribbling: {{ $skill_dribbling }}%</label>
                    <input type="range" wire:model.live="skill_dribbling" min="0" max="100" class="w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Passing: {{ $skill_soccer_passing }}%</label>
                    <input type="range" wire:model.live="skill_soccer_passing" min="0" max="100" class="w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Shooting: {{ $skill_shooting_soccer }}%</label>
                    <input type="range" wire:model.live="skill_shooting_soccer" min="0" max="100" class="w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Defending: {{ $skill_defending }}%</label>
                    <input type="range" wire:model.live="skill_defending" min="0" max="100" class="w-full">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stamina: {{ $skill_stamina }}%</label>
                    <input type="range" wire:model.live="skill_stamina" min="0" max="100" class="w-full">
                </div>
            </div>
            
            <!-- Track - No skills section -->
            <div x-show="$wire.sport === 'track'" class="text-gray-500 text-center py-4">
                Track & Field events are skill-specific. Record your personal records in the metrics section above.
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button type="submit" 
                    wire:loading.attr="disabled"
                    class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                <svg wire:loading wire:target="save" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span wire:loading.remove wire:target="save">Save Profile</span>
                <span wire:loading wire:target="save">Saving...</span>
            </button>
        </div>
    </form>
</div>
