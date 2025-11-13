<section id="highlights" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Highlights & Media</h2>
            <div class="w-20 h-1 bg-blue-600 mx-auto"></div>
        </div>

        <!-- Loading Skeleton -->
        <div wire:loading class="animate-pulse">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                <!--[if BLOCK]><![endif]--><?php for($i = 0; $i < 6; $i++): ?>
                <div class="bg-gray-200 rounded-xl overflow-hidden">
                    <div class="aspect-video bg-gray-300"></div>
                    <div class="p-4 space-y-2">
                        <div class="h-4 bg-gray-300 rounded"></div>
                        <div class="h-3 bg-gray-300 rounded w-3/4"></div>
                    </div>
                </div>
                <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>

        <!-- Actual Content -->
        <div wire:loading.remove>
        <!-- Featured Video -->
        <!--[if BLOCK]><![endif]--><?php if($featuredHighlight): ?>
        <div class="mb-12">
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl overflow-hidden shadow-2xl">
                <?php
                    $embedUrl = \App\Helpers\VideoHelper::getEmbedUrl($featuredHighlight->video_url);
                ?>
                <!--[if BLOCK]><![endif]--><?php if($embedUrl): ?>
                    <div class="aspect-video">
                        <iframe 
                            src="<?php echo e($embedUrl); ?>" 
                            class="w-full h-full"
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    </div>
                <?php else: ?>
                    <div class="aspect-video bg-gray-700 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-24 h-24 text-white/50 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-white text-lg font-medium"><?php echo e($featuredHighlight->title); ?></p>
                            <p class="text-gray-400 text-sm mt-2"><?php echo e($featuredHighlight->description ?? 'Add video URL to display'); ?></p>
                        </div>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <!--[if BLOCK]><![endif]--><?php if($featuredHighlight->title || $featuredHighlight->description): ?>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-white mb-2"><?php echo e($featuredHighlight->title); ?></h3>
                    <!--[if BLOCK]><![endif]--><?php if($featuredHighlight->description): ?>
                    <p class="text-gray-300"><?php echo e($featuredHighlight->description); ?></p>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!-- Video Grid -->
        <!--[if BLOCK]><![endif]--><?php if($highlights->isNotEmpty()): ?>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php
                $colors = ['blue', 'purple', 'green', 'red', 'yellow', 'indigo'];
            ?>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $highlights->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $highlight): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 group">
                <?php
                    $embedUrl = \App\Helpers\VideoHelper::getEmbedUrl($highlight->video_url);
                ?>
                <!--[if BLOCK]><![endif]--><?php if($embedUrl): ?>
                    <div class="aspect-video relative">
                        <iframe 
                            src="<?php echo e($embedUrl); ?>" 
                            class="w-full h-full"
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                        <!--[if BLOCK]><![endif]--><?php if($highlight->duration): ?>
                        <div class="absolute top-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded"><?php echo e($highlight->duration); ?></div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                <?php else: ?>
                    <div class="aspect-video bg-gradient-to-br from-<?php echo e($colors[$index % count($colors)]); ?>-500 to-<?php echo e($colors[$index % count($colors)]); ?>-700 flex items-center justify-center relative">
                        <svg class="w-16 h-16 text-white/80 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <!--[if BLOCK]><![endif]--><?php if($highlight->duration): ?>
                        <div class="absolute top-2 right-2 bg-black/50 text-white text-xs px-2 py-1 rounded"><?php echo e($highlight->duration); ?></div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <div class="p-4">
                    <h3 class="font-bold text-gray-900 mb-2"><?php echo e($highlight->title); ?></h3>
                    <p class="text-sm text-gray-600"><?php echo e($highlight->description); ?></p>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <!--[if BLOCK]><![endif]--><?php if($highlights->count() > 3): ?>
        <!-- View All Videos Modal Trigger -->
        <div class="text-center mt-8">
            <button onclick="openVideosModal()" 
                    class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                View All <?php echo e($highlights->count()); ?> Videos
            </button>
        </div>

        <!-- All Videos Modal -->
        <div id="videos-modal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 overflow-y-auto">
            <div class="min-h-screen px-4 py-8">
                <div class="max-w-6xl mx-auto">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-white">All Video Highlights</h3>
                        <button onclick="closeVideosModal()" class="text-white hover:text-gray-300 transition">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $highlights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $highlight): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                            <?php
                                $embedUrl = \App\Helpers\VideoHelper::getEmbedUrl($highlight->video_url);
                            ?>
                            <!--[if BLOCK]><![endif]--><?php if($embedUrl): ?>
                                <div class="aspect-video relative">
                                    <iframe 
                                        src="<?php echo e($embedUrl); ?>" 
                                        class="w-full h-full"
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen>
                                    </iframe>
                                    <!--[if BLOCK]><![endif]--><?php if($highlight->duration): ?>
                                    <div class="absolute top-2 right-2 bg-black/70 text-white text-xs px-2 py-1 rounded"><?php echo e($highlight->duration); ?></div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            <?php else: ?>
                                <div class="aspect-video bg-gradient-to-br from-<?php echo e($colors[$index % count($colors)]); ?>-500 to-<?php echo e($colors[$index % count($colors)]); ?>-700 flex items-center justify-center relative">
                                    <svg class="w-16 h-16 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <!--[if BLOCK]><![endif]--><?php if($highlight->duration): ?>
                                    <div class="absolute top-2 right-2 bg-black/50 text-white text-xs px-2 py-1 rounded"><?php echo e($highlight->duration); ?></div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <div class="p-4">
                                <h3 class="font-bold text-gray-900 mb-2"><?php echo e($highlight->title); ?></h3>
                                <p class="text-sm text-gray-600"><?php echo e($highlight->description); ?></p>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <?php else: ?>
        <!-- Empty State for Highlights -->
        <div class="bg-white rounded-xl shadow-lg px-12 py-20 text-center">
            <svg class="w-20 h-20 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Highlights Coming Soon</h3>
            <p class="text-gray-600 max-w-md mx-auto">Game highlights and film will be uploaded throughout the season. Stay tuned!</p>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!-- Photo Gallery -->
        <!--[if BLOCK]><![endif]--><?php if($photos->isNotEmpty()): ?>
        <div class="mt-16">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">Photo Gallery</h3>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $photos->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    // Handle both external URLs (seeder) and uploaded files
                    // Also handle old seeder data that might still use video_url
                    $photoPath = $photo->photo_path ?? $photo->video_url ?? null;
                    if (!$photoPath) continue;
                    $photoUrl = (str_starts_with($photoPath, 'http')) 
                        ? $photoPath 
                        : asset('storage/' . $photoPath);
                ?>
                <a href="<?php echo e($photoUrl); ?>" 
                   class="glightbox aspect-square bg-gray-200 rounded-lg overflow-hidden hover:opacity-90 hover:shadow-xl transition cursor-pointer group relative block"
                   data-gallery="photo-gallery"
                   data-glightbox="title: <?php echo e($photo->title); ?>; description: <?php echo e($photo->description); ?>"
                   data-type="image">
                    <img src="<?php echo e($photoUrl); ?>" 
                         alt="<?php echo e($photo->title); ?>" 
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-300"
                         loading="lazy"
                         crossorigin="anonymous">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition flex items-end p-3">
                        <p class="text-white text-sm font-semibold"><?php echo e($photo->title); ?></p>
                    </div>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>

            <!--[if BLOCK]><![endif]--><?php if($photos->count() > 4): ?>
            <!-- Hidden photos for lightbox -->
            <div class="hidden">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $photos->skip(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $photoPath = $photo->photo_path ?? $photo->video_url;
                    $photoUrl = ($photoPath && str_starts_with($photoPath, 'http')) 
                        ? $photoPath 
                        : asset('storage/' . $photoPath);
                ?>
                <a href="<?php echo e($photoUrl); ?>" 
                   class="glightbox"
                   data-gallery="photo-gallery"
                   data-glightbox="title: <?php echo e($photo->title); ?>; description: <?php echo e($photo->description); ?>"
                   data-type="image">
                    <img src="<?php echo e($photoUrl); ?>" alt="<?php echo e($photo->title); ?>" crossorigin="anonymous">
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>

            <!-- View All Button -->
            <div class="text-center mt-6">
                <button onclick="document.querySelector('.glightbox').click()" 
                        class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    View All <?php echo e($photos->count()); ?> Photos
                </button>
            </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div><!-- End wire:loading.remove -->
    </div>

    <!-- GLightbox CSS & JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox@3.2.0/dist/css/glightbox.min.css">
    <script src="https://cdn.jsdelivr.net/npm/glightbox@3.2.0/dist/js/glightbox.min.js"></script>
    
    <script>
        // Initialize GLightbox
        document.addEventListener('DOMContentLoaded', function() {
            const lightbox = GLightbox({
                selector: '.glightbox',
                touchNavigation: true,
                loop: true,
                autoplayVideos: false,
                descPosition: 'bottom',
                moreLength: 0
            });
        });
        
        // Re-initialize after Livewire updates
        document.addEventListener('livewire:navigated', function() {
            GLightbox({
                selector: '.glightbox',
                touchNavigation: true,
                loop: true,
                autoplayVideos: false,
                descPosition: 'bottom',
                moreLength: 0
            });
        });

        // Videos Modal Functions
        function openVideosModal() {
            document.getElementById('videos-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeVideosModal() {
            document.getElementById('videos-modal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('videos-modal');
                if (modal && !modal.classList.contains('hidden')) {
                    closeVideosModal();
                }
            }
        });
    </script>
</section>
<?php /**PATH /var/www/html/resources/views/livewire/highlights-section.blade.php ENDPATH**/ ?>