<?php
    // Convert slot content to string
    $pageTitle = isset($title) && $title ? trim(strip_tags($title)) : null;
    $pageHeader = isset($header) && $header ? trim(strip_tags($header)) : 'Admin Dashboard';
?>

<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve(['title' => $pageTitle] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <?php echo e($pageHeader); ?>

            </h2>
            <a href="<?php echo e(url('/')); ?>" target="_blank" class="text-sm text-blue-600 hover:text-blue-800">
                View Website →
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <!-- Admin Navigation -->
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px space-x-8 px-6">
                        <a href="<?php echo e(route('dashboard')); ?>" 
                           class="<?php if(request()->routeIs('dashboard')): ?> border-blue-500 text-blue-600 <?php else: ?> border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 <?php endif; ?> whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Dashboard
                        </a>
                        <a href="<?php echo e(route('admin.profile')); ?>" 
                           class="<?php if(request()->routeIs('admin.profile')): ?> border-blue-500 text-blue-600 <?php else: ?> border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 <?php endif; ?> whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Profile
                        </a>
                        <a href="<?php echo e(route('admin.stats')); ?>" 
                           class="<?php if(request()->routeIs('admin.stats')): ?> border-blue-500 text-blue-600 <?php else: ?> border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 <?php endif; ?> whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Stats
                        </a>
                        <a href="<?php echo e(route('admin.highlights')); ?>" 
                           class="<?php if(request()->routeIs('admin.highlights')): ?> border-blue-500 text-blue-600 <?php else: ?> border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 <?php endif; ?> whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Highlights
                        </a>
                        <a href="<?php echo e(route('admin.awards')); ?>" 
                           class="<?php if(request()->routeIs('admin.awards')): ?> border-blue-500 text-blue-600 <?php else: ?> border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 <?php endif; ?> whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Awards
                        </a>
                        <a href="<?php echo e(route('admin.testimonials')); ?>" 
                           class="<?php if(request()->routeIs('admin.testimonials')): ?> border-blue-500 text-blue-600 <?php else: ?> border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 <?php endif; ?> whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Testimonials
                        </a>
                        <a href="<?php echo e(route('admin.contacts')); ?>" 
                           class="<?php if(request()->routeIs('admin.contacts')): ?> border-blue-500 text-blue-600 <?php else: ?> border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 <?php endif; ?> whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Contacts
                        </a>
                    </nav>
                </div>

                <!-- Page Content -->
                <div class="p-6">
                    <?php echo e($slot); ?>

                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/resources/views/components/layouts/admin.blade.php ENDPATH**/ ?>