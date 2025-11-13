<section id="testimonials" class="py-20 bg-gradient-to-br from-gray-50 to-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Testimonials & Recommendations
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                What coaches, teammates, and mentors are saying
            </p>
        </div>

        <!-- Loading Skeleton -->
        <div wire:loading class="animate-pulse">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @for($i = 0; $i < 3; $i++)
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="h-10 w-10 bg-gray-200 rounded mb-4"></div>
                    <div class="space-y-2 mb-6">
                        <div class="h-3 bg-gray-200 rounded"></div>
                        <div class="h-3 bg-gray-200 rounded w-5/6"></div>
                        <div class="h-3 bg-gray-200 rounded w-4/6"></div>
                    </div>
                    <div class="border-t border-gray-200 pt-4">
                        <div class="h-4 bg-gray-200 rounded w-3/4 mb-2"></div>
                        <div class="h-3 bg-gray-200 rounded w-1/2"></div>
                    </div>
                </div>
                @endfor
            </div>
        </div>

        <!-- Actual Content -->
        <div wire:loading.remove>
        @if($testimonials->isNotEmpty())
            <!-- Carousel Mode -->
            <div class="relative">
                <div id="testimonials-carousel" class="overflow-hidden">
                    <div class="flex transition-transform duration-500 ease-out" id="carousel-track">
                        @foreach($testimonials as $index => $testimonial)
                        <div class="w-full flex-shrink-0 px-4 py-1">
                            <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 {{ $testimonial->is_featured ? 'ring-2 ring-blue-500' : '' }} max-w-3xl mx-auto">
                                @if($testimonial->is_featured)
                                    <div class="flex justify-end mb-2">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">Featured</span>
                                    </div>
                                @endif

                                <!-- Quote Icon -->
                                <div class="text-blue-600 mb-4">
                                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                                    </svg>
                                </div>

                                <!-- Content -->
                                <p class="text-gray-700 mb-6 leading-relaxed italic text-lg">
                                    "{{ $testimonial->content }}"
                                </p>

                                <!-- Author Info -->
                                <div class="border-t border-gray-200 pt-4">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h4 class="font-bold text-gray-900">{{ $testimonial->author_name }}</h4>
                                            @if($testimonial->author_title)
                                                <p class="text-sm text-gray-600">{{ $testimonial->author_title }}</p>
                                            @endif
                                            @if($testimonial->author_organization)
                                                <p class="text-sm text-gray-500">{{ $testimonial->author_organization }}</p>
                                            @endif
                                            @if($testimonial->relationship)
                                                <p class="text-xs text-blue-600 mt-1">{{ $testimonial->relationship }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    @if($testimonial->date)
                                        <p class="text-xs text-gray-400 mt-2">{{ $testimonial->date->format('F Y') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <button id="carousel-prev" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 bg-white rounded-full p-3 shadow-lg hover:bg-gray-50 transition z-10">
                    <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button id="carousel-next" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 bg-white rounded-full p-3 shadow-lg hover:bg-gray-50 transition z-10">
                    <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                <!-- Indicators -->
                <div class="flex justify-center gap-2 mt-6">
                    @for($i = 0; $i < $testimonials->count(); $i++)
                    <button class="carousel-indicator w-2 h-2 rounded-full bg-gray-300 hover:bg-gray-400 transition {{ $i === 0 ? 'bg-blue-600' : '' }}" data-index="{{ $i }}"></button>
                    @endfor
                </div>
            </div>
        @else
        <!-- Empty State for Testimonials -->
        <div class="bg-white rounded-xl shadow-lg px-12 py-20 text-center">
            <svg class="w-20 h-20 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
            </svg>
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Testimonials Coming Soon</h3>
            <p class="text-gray-600 max-w-md mx-auto">Recommendations from coaches and teammates will appear here. Building relationships on and off the field!</p>
        </div>
        @endif
        </div><!-- End wire:loading.remove -->
    </div>
</section>
