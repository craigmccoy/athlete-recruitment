<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title' => null]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['title' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <?php
        $athlete = $sharedAthleteProfile ?? null;
        $sportProfile = $athlete?->sportProfile();
        $position = $sportProfile?->position ?? 'Athlete';
        $sportName = $athlete?->sport ? ucfirst($athlete->sport) : 'Football';
        
        $defaultPageTitle = $athlete ? "{$athlete->name} - {$position} ({$sportName}) | Class of {$athlete->graduation_year}" : config('app.name', 'Athlete Portfolio');
        
        $pageTitle = $title ?: $defaultPageTitle;
        $pageDescription = $athlete ? "{$athlete->name} is a {$position} ({$sportName}) from {$athlete->school_name}. View stats, highlights, and recruitment information." : 'High school athlete recruitment portfolio showcasing stats, highlights, and achievements.';
        $pageImage = $athlete && $athlete->profile_image ? asset('storage/' . $athlete->profile_image) : asset('images/default-og.jpg');
        $pageUrl = url()->current();
    ?>

    <!-- Primary Meta Tags -->
    <title><?php echo e($pageTitle); ?></title>
    <meta name="title" content="<?php echo e($pageTitle); ?>">
    <meta name="description" content="<?php echo e($pageDescription); ?>">
    <meta name="keywords" content="athlete recruitment, <?php echo e($position); ?>, <?php echo e($sportName); ?>, <?php echo e($athlete?->school_name ?? 'high school'); ?>, sports recruitment, college recruiting">
    <meta name="author" content="<?php echo e($athlete?->name ?? config('app.name')); ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="profile">
    <meta property="og:url" content="<?php echo e($pageUrl); ?>">
    <meta property="og:title" content="<?php echo e($pageTitle); ?>">
    <meta property="og:description" content="<?php echo e($pageDescription); ?>">
    <meta property="og:image" content="<?php echo e($pageImage); ?>">
    <?php if($athlete): ?>
    <meta property="profile:first_name" content="<?php echo e(explode(' ', $athlete->name)[0] ?? ''); ?>">
    <meta property="profile:last_name" content="<?php echo e(explode(' ', $athlete->name)[1] ?? ''); ?>">
    <?php endif; ?>

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo e($pageUrl); ?>">
    <meta property="twitter:title" content="<?php echo e($pageTitle); ?>">
    <meta property="twitter:description" content="<?php echo e($pageDescription); ?>">
    <meta property="twitter:image" content="<?php echo e($pageImage); ?>">

    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo e($pageUrl); ?>">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>


    <!-- Structured Data (JSON-LD) -->
    <?php if($athlete): ?>
    <?php
        $structuredData = [
            "@context" => "https://schema.org",
            "@type" => "Person",
            "name" => $athlete->name,
            "jobTitle" => $athlete->position,
            "affiliation" => [
                "@type" => "EducationalOrganization",
                "name" => $athlete->school_name
            ],
            "alumniOf" => [
                "@type" => "EducationalOrganization",
                "name" => $athlete->school_name
            ],
            "description" => $pageDescription,
            "url" => $pageUrl
        ];
        
        if ($athlete->profile_image) {
            $structuredData['image'] = asset('storage/' . $athlete->profile_image);
        }
        
        if ($athlete->email) {
            $structuredData['email'] = $athlete->email;
        }
    ?>
    <script type="application/ld+json"><?php echo json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?></script>
    <?php endif; ?>
</head>
<body class="antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="fixed w-full bg-white/95 backdrop-blur-sm shadow-sm z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo/Name -->
                <div class="flex-shrink-0">
                    <a href="#home" class="text-2xl font-bold">
                        <?php
                            $sportProfile = $sharedAthleteProfile?->sportProfile();
                        ?>
                        <?php if($sportProfile?->jersey_number): ?>
                            <span class="text-blue-600">#<?php echo e($sportProfile->jersey_number); ?></span>
                        <?php endif; ?>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex space-x-8">
                    <a href="#home" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition">Home</a>
                    <a href="#about" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition">About</a>
                    <a href="#stats" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition">Stats</a>
                    <a href="#awards" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition">Awards</a>
                    <a href="#highlights" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition">Highlights</a>
                    <a href="#contact" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition">Contact</a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" type="button" class="text-gray-700 hover:text-blue-600 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 bg-white border-t">
                <a href="#home" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md">Home</a>
                <a href="#about" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md">About</a>
                <a href="#stats" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md">Stats</a>
                <a href="#awards" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md">Awards</a>
                <a href="#highlights" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md">Highlights</a>
                <a href="#contact" class="block px-3 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md">Contact</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <?php echo e($slot); ?>

    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
                <!-- About & Contact -->
                <div>
                    <h3 class="text-white text-lg font-semibold mb-4">About</h3>
                    <p class="text-sm mb-6">
                        High school athlete dedicated to excellence in football and academics.
                        Looking for opportunities at the collegiate level.
                    </p>
                    
                    <h3 class="text-white text-lg font-semibold mb-4 mt-6">Navigate</h3>
                    <div class="grid grid-cols-2 gap-x-8 gap-y-2 text-sm">
                        <a href="#about" class="hover:text-white transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            About Me
                        </a>
                        <a href="#stats" class="hover:text-white transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            Statistics
                        </a>
                        <a href="#awards" class="hover:text-white transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            Awards
                        </a>
                        <a href="#highlights" class="hover:text-white transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            Highlights
                        </a>
                        <a href="#testimonials" class="hover:text-white transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            Testimonials
                        </a>
                        <a href="#contact" class="hover:text-white transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            Contact
                        </a>
                    </div>
                </div>

                <!-- Connect & Download -->
                <div>
                    <h3 class="text-white text-lg font-semibold mb-4">Connect</h3>
                    <p class="text-sm mb-4">Follow my athletic journey on social media</p>
                    <div class="flex space-x-4 mb-8">
                        <?php if($sharedAthleteProfile?->social_links['facebook'] ?? null): ?>
                        <a href="<?php echo e($sharedAthleteProfile->social_links['facebook']); ?>" target="_blank" class="bg-gray-800 hover:bg-blue-600 p-3 rounded-lg transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <?php endif; ?>
                        <?php if($sharedAthleteProfile?->social_links['twitter'] ?? null): ?>
                        <a href="<?php echo e($sharedAthleteProfile->social_links['twitter']); ?>" target="_blank" class="bg-gray-800 hover:bg-blue-400 p-3 rounded-lg transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <?php endif; ?>
                        <?php if($sharedAthleteProfile?->social_links['instagram'] ?? null): ?>
                        <a href="<?php echo e($sharedAthleteProfile->social_links['instagram']); ?>" target="_blank" class="bg-gray-800 hover:bg-pink-600 p-3 rounded-lg transition">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                            </svg>
                        </a>
                        <?php endif; ?>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-800">
                        <p class="text-sm text-gray-400 mb-3">Interested in recruiting opportunities?</p>
                        <a href="#contact" class="inline-flex items-center gap-2 text-blue-400 hover:text-blue-300 transition text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Get in touch
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm">
                <p>&copy; <?php echo e(date('Y')); ?> All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button 
        id="back-to-top" 
        class="fixed bottom-8 right-8 bg-blue-600 text-white p-4 rounded-full shadow-lg hover:bg-blue-700 transition-all duration-300 opacity-0 pointer-events-none z-50"
        aria-label="Back to top"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    </button>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        // Close mobile menu when clicking a link
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', function() {
                document.getElementById('mobile-menu').classList.add('hidden');
            });
        });

        // Back to Top Button
        const backToTopButton = document.getElementById('back-to-top');
        
        // Show/hide button based on scroll position
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 500) {
                backToTopButton.classList.remove('opacity-0', 'pointer-events-none');
                backToTopButton.classList.add('opacity-100');
            } else {
                backToTopButton.classList.add('opacity-0', 'pointer-events-none');
                backToTopButton.classList.remove('opacity-100');
            }
        });
        
        // Scroll to top when clicked
        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Skills Section Animation
        const observeSkills = () => {
            const skillsContainer = document.getElementById('skills-container');
            if (!skillsContainer) return;

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const skillItems = entry.target.querySelectorAll('.skill-item');
                        
                        skillItems.forEach((item, index) => {
                            setTimeout(() => {
                                // Fade in the item
                                item.classList.remove('opacity-0', 'translate-x-4');
                                item.classList.add('opacity-100', 'translate-x-0');
                                
                                // Animate the progress bar
                                const bar = item.querySelector('.skill-bar');
                                const value = item.dataset.value;
                                setTimeout(() => {
                                    bar.style.width = value + '%';
                                }, 100);
                            }, index * 150); // Stagger animation
                        });
                        
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.2
            });

            observer.observe(skillsContainer);
        };

        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', observeSkills);
        } else {
            observeSkills();
        }

        // Fade-in Sections on Scroll
        const observeSections = () => {
            const sections = document.querySelectorAll('section');
            
            const sectionObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fadeIn');
                        sectionObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            sections.forEach(section => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(20px)';
                section.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
                sectionObserver.observe(section);
            });
        };

        // Initialize section observer
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', observeSections);
        } else {
            observeSections();
        }

        // Testimonials Carousel
        const initCarousel = () => {
            const carousel = document.getElementById('testimonials-carousel');
            if (!carousel) return;

            const track = document.getElementById('carousel-track');
            const prevBtn = document.getElementById('carousel-prev');
            const nextBtn = document.getElementById('carousel-next');
            const indicators = document.querySelectorAll('.carousel-indicator');
            
            let currentIndex = 0;
            let autoRotateInterval;
            let touchStartX = 0;
            let touchEndX = 0;

            const totalSlides = indicators.length;

            const updateCarousel = () => {
                track.style.transform = `translateX(-${currentIndex * 100}%)`;
                
                // Update indicators
                indicators.forEach((indicator, index) => {
                    if (index === currentIndex) {
                        indicator.classList.add('bg-blue-600');
                        indicator.classList.remove('bg-gray-300');
                    } else {
                        indicator.classList.remove('bg-blue-600');
                        indicator.classList.add('bg-gray-300');
                    }
                });
            };

            const nextSlide = () => {
                currentIndex = (currentIndex + 1) % totalSlides;
                updateCarousel();
            };

            const prevSlide = () => {
                currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
                updateCarousel();
            };

            const goToSlide = (index) => {
                currentIndex = index;
                updateCarousel();
            };

            const startAutoRotate = () => {
                autoRotateInterval = setInterval(nextSlide, 10000);
            };

            const stopAutoRotate = () => {
                clearInterval(autoRotateInterval);
            };

            // Navigation buttons
            prevBtn.addEventListener('click', () => {
                prevSlide();
                stopAutoRotate();
                startAutoRotate();
            });

            nextBtn.addEventListener('click', () => {
                nextSlide();
                stopAutoRotate();
                startAutoRotate();
            });

            // Indicator dots
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    goToSlide(index);
                    stopAutoRotate();
                    startAutoRotate();
                });
            });

            // Touch/Swipe support
            carousel.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
            });

            carousel.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            });

            const handleSwipe = () => {
                if (touchStartX - touchEndX > 50) {
                    // Swipe left - next slide
                    nextSlide();
                    stopAutoRotate();
                    startAutoRotate();
                }
                if (touchEndX - touchStartX > 50) {
                    // Swipe right - previous slide
                    prevSlide();
                    stopAutoRotate();
                    startAutoRotate();
                }
            };

            // Pause on hover
            carousel.addEventListener('mouseenter', stopAutoRotate);
            carousel.addEventListener('mouseleave', startAutoRotate);

            // Start auto-rotation
            startAutoRotate();
        };

        // Initialize carousel
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initCarousel);
        } else {
            initCarousel();
        }
    </script>
    
    <style>
        .animate-fadeIn {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }
    </style>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/components/layouts/app.blade.php ENDPATH**/ ?>