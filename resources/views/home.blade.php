<x-layouts.app>
    <!-- Hero Section -->
    <section id="home" class="relative bg-gradient-to-br from-blue-600 to-blue-800 text-white pt-24 pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Text Content -->
                <div class="text-center lg:text-left">
                    <h1 class="text-5xl md:text-6xl font-bold mb-4">
                        {{ $athleteProfile->name ?? 'Athlete Name' }}
                    </h1>
                    @php
                        $sportProfile = $athleteProfile->sportProfile();
                    @endphp
                    <p class="text-xl md:text-2xl text-blue-100 mb-2">
                        @if($sportProfile?->position){{ $sportProfile->position }}@else Position @endif
                        @if($sportProfile?->jersey_number)<span class="text-white font-semibold">#{{ $sportProfile->jersey_number }}</span>@endif
                        @if($athleteProfile?->sport && $athleteProfile->sport !== 'football')
                            | {{ \App\Helpers\SportConfig::getSports()[$athleteProfile->sport] ?? ucfirst($athleteProfile->sport) }}
                        @endif
                        | Class of {{ $athleteProfile->graduation_year ?? '2026' }}
                    </p>
                    <p class="text-lg text-blue-200 mb-6">{{ $athleteProfile->school_name ?? 'High School' }}</p>
                    
                    <div class="flex flex-wrap gap-4 justify-center lg:justify-start mb-8">
                        @if($athleteProfile?->height)
                        <div class="bg-white/10 backdrop-blur-sm px-6 py-3 rounded-lg">
                            <div class="text-2xl font-bold">{{ $athleteProfile->height }}</div>
                            <div class="text-sm text-blue-200">Height</div>
                        </div>
                        @endif
                        @if($athleteProfile?->weight)
                        <div class="bg-white/10 backdrop-blur-sm px-6 py-3 rounded-lg">
                            <div class="text-2xl font-bold">{{ $athleteProfile->weight }}</div>
                            <div class="text-sm text-blue-200">Weight</div>
                        </div>
                        @endif
                        @if($sportProfile)
                            @if($athleteProfile->sport === 'football' && $sportProfile->forty_yard_dash)
                            <div class="bg-white/10 backdrop-blur-sm px-6 py-3 rounded-lg">
                                <div class="text-2xl font-bold">{{ number_format($sportProfile->forty_yard_dash, 2) }}</div>
                                <div class="text-sm text-blue-200">40-Yd</div>
                            </div>
                            @elseif(in_array($athleteProfile->sport, ['basketball', 'soccer']) && $sportProfile->sprint_speed)
                            <div class="bg-white/10 backdrop-blur-sm px-6 py-3 rounded-lg">
                                <div class="text-2xl font-bold">{{ number_format($sportProfile->sprint_speed, 2) }}</div>
                                <div class="text-sm text-blue-200">Sprint</div>
                            </div>
                            @elseif($athleteProfile->sport === 'baseball' && $sportProfile->sixty_yard_dash)
                            <div class="bg-white/10 backdrop-blur-sm px-6 py-3 rounded-lg">
                                <div class="text-2xl font-bold">{{ number_format($sportProfile->sixty_yard_dash, 2) }}</div>
                                <div class="text-sm text-blue-200">60-Yd</div>
                            </div>
                            @endif
                            
                            @if($athleteProfile->sport === 'football' && $sportProfile->vertical_jump)
                            <div class="bg-white/10 backdrop-blur-sm px-6 py-3 rounded-lg">
                                <div class="text-2xl font-bold">{{ number_format($sportProfile->vertical_jump, 1) }}"</div>
                                <div class="text-sm text-blue-200">Vertical</div>
                            </div>
                            @elseif($athleteProfile->sport === 'basketball' && $sportProfile->vertical_jump)
                            <div class="bg-white/10 backdrop-blur-sm px-6 py-3 rounded-lg">
                                <div class="text-2xl font-bold">{{ number_format($sportProfile->vertical_jump, 1) }}"</div>
                                <div class="text-sm text-blue-200">Vertical</div>
                            </div>
                            @elseif($athleteProfile->sport === 'baseball' && $sportProfile->exit_velocity)
                            <div class="bg-white/10 backdrop-blur-sm px-6 py-3 rounded-lg">
                                <div class="text-2xl font-bold">{{ number_format($sportProfile->exit_velocity, 0) }}</div>
                                <div class="text-sm text-blue-200">Exit Velo</div>
                            </div>
                            @endif
                        @endif
                        @if($athleteProfile?->gpa)
                        <div class="bg-white/10 backdrop-blur-sm px-6 py-3 rounded-lg">
                            <div class="text-2xl font-bold">{{ number_format($athleteProfile->gpa, 1) }}</div>
                            <div class="text-sm text-blue-200">GPA</div>
                        </div>
                        @endif
                    </div>
                    
                    <div class="flex gap-2 sm:gap-4 justify-center lg:justify-start">
                        <a href="#contact" class="bg-white text-blue-600 px-4 sm:px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition flex items-center gap-2 whitespace-nowrap">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="sm:hidden">Contact</span>
                            <span class="hidden sm:block">Contact Me</span>
                        </a>
                        <a href="#highlights" class="border-2 border-white text-white px-4 sm:px-8 py-3 rounded-lg font-semibold hover:bg-white/10 transition flex items-center gap-2 whitespace-nowrap">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="sm:hidden">Highlights</span>
                            <span class="hidden sm:block">View Highlights</span>
                        </a>
                        <a href="{{ url('/stat-sheet.pdf') }}" target="_blank" class="border-2 border-white text-white px-4 sm:px-8 py-3 rounded-lg font-semibold hover:bg-white/10 transition flex items-center gap-2 whitespace-nowrap">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span class="sm:hidden">Stats</span>
                            <span class="hidden sm:block">Stat Sheet</span>
                        </a>
                    </div>
                    
                    <!-- Social Media Links -->
                    @if($athleteProfile?->social_links && (
                        ($athleteProfile->social_links['twitter'] ?? null) || 
                        ($athleteProfile->social_links['instagram'] ?? null) || 
                        ($athleteProfile->social_links['hudl'] ?? null) || 
                        ($athleteProfile->social_links['youtube'] ?? null)
                    ))
                    <div class="flex gap-4 justify-center lg:justify-start mt-6">
                        <p class="text-blue-100 text-sm flex items-center mr-2">Follow me:</p>
                        @if($athleteProfile->social_links['twitter'] ?? null)
                        <a href="{{ $athleteProfile->social_links['twitter'] }}" target="_blank" rel="noopener noreferrer" class="text-white hover:text-blue-200 transition" aria-label="Twitter">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        @endif
                        @if($athleteProfile->social_links['instagram'] ?? null)
                        <a href="{{ $athleteProfile->social_links['instagram'] }}" target="_blank" rel="noopener noreferrer" class="text-white hover:text-blue-200 transition" aria-label="Instagram">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                            </svg>
                        </a>
                        @endif
                        @if($athleteProfile->social_links['hudl'] ?? null)
                        <a href="{{ $athleteProfile->social_links['hudl'] }}" target="_blank" rel="noopener noreferrer" class="text-white hover:text-blue-200 transition" aria-label="Hudl">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L2 7v10l10 5 10-5V7L12 2zm0 2.18L19.82 8 12 11.82 4.18 8 12 4.18zM4 9.5l7 3.5v7l-7-3.5v-7zm9 11v-7l7-3.5v7l-7 3.5z"/>
                            </svg>
                        </a>
                        @endif
                        @if($athleteProfile->social_links['youtube'] ?? null)
                        <a href="{{ $athleteProfile->social_links['youtube'] }}" target="_blank" rel="noopener noreferrer" class="text-white hover:text-blue-200 transition" aria-label="YouTube">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>
                        @endif
                    </div>
                    @endif
                </div>
                
                <!-- Profile Photo -->
                <div class="flex justify-center lg:justify-end">
                    @if($athleteProfile?->profile_image)
                        <img src="{{ asset('storage/' . $athleteProfile->profile_image) }}" alt="{{ $athleteProfile->name }}" class="w-80 h-80 object-cover rounded-2xl border-2 border-white/20 shadow-2xl hover:scale-105 hover:shadow-[0_20px_50px_rgba(0,0,0,0.3)] transition-all duration-300" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="w-80 h-80 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center border-2 border-white/20" style="display: none;">
                            <div class="text-center text-white/70 text-sm">
                                <p>Image not found</p>
                                <p class="text-xs mt-2">{{ $athleteProfile->profile_image }}</p>
                            </div>
                        </div>
                    @else
                        <div class="w-80 h-80 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center border-2 border-white/20">
                            <svg class="w-32 h-32 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">About Me</h2>
                <div class="w-20 h-1 bg-blue-600 mx-auto"></div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <h3 class="text-2xl font-bold text-gray-900">My Story</h3>
                    @if($athleteProfile?->story)
                        @foreach(explode("\n\n", $athleteProfile->story) as $paragraph)
                            <p class="text-gray-700 leading-relaxed">{{ $paragraph }}</p>
                        @endforeach
                    @else
                        <p class="text-gray-700 leading-relaxed">
                            I'm a dedicated high school athlete with a passion for football and a commitment to excellence both on and off the field.
                        </p>
                    @endif
                    
                    <div class="grid grid-cols-2 gap-6 pt-4">
                        @if($athleteProfile->sport !== 'track')
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Position</h4>
                            <p class="text-gray-600">{{ $sportProfile?->position ?? 'N/A' }}</p>
                        </div>
                        @if($sportProfile?->jersey_number)
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Jersey Number</h4>
                            <p class="text-gray-600">#{{ $sportProfile->jersey_number }}</p>
                        </div>
                        @endif
                        @endif
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Grad Year</h4>
                            <p class="text-gray-600">{{ $athleteProfile->graduation_year ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Location</h4>
                            <p class="text-gray-600">{{ $athleteProfile->location ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-2xl p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Skills & Strengths</h3>
                    <div class="space-y-4" id="skills-container">
                        @if($sportProfile?->skills)
                            @foreach($sportProfile->skills as $skillName => $skillValue)
                            <div class="skill-item opacity-0 translate-x-4 transition-all duration-700" data-skill="{{ $skillName }}" data-value="{{ $skillValue }}">
                                <div class="flex justify-between mb-2">
                                    <div class="relative flex items-center gap-2 group">
                                        <span class="font-medium text-gray-700">{{ $skillName }}</span>
                                        <div class="relative">
                                            <svg class="w-4 h-4 text-gray-400 hover:text-blue-500 transition-colors cursor-help" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-3 py-2 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-10">
                                                Proficiency in {{ $skillName }}
                                                <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-900"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-blue-600 font-semibold">{{ $skillValue }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                    <div class="skill-bar h-3 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 transition-all duration-1000 ease-out shadow-sm" style="width: 0%"></div>
                                </div>
                            </div>
                            @endforeach
                        @elseif($athleteProfile->sport === 'track' && $sportProfile)
                            <div class="text-center py-6">
                                <p class="text-gray-600 mb-4">Track & Field Events:</p>
                                <p class="font-semibold text-gray-900">{{ $sportProfile->events ?? 'No events listed' }}</p>
                            </div>
                        @else
                            <p class="text-gray-500 text-center">No skills data available</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    @livewire('stats-section')

    <!-- Highlights Section -->
    @livewire('highlights-section')

    <!-- Testimonials Section -->
    @livewire('testimonials-section')

    <!-- Contact Section -->
    @livewire('contact-section')
</x-layouts.app>
