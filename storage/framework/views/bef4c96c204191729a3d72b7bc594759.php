<div>
    <!--[if BLOCK]><![endif]--><?php if(session()->has('message')): ?>
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            <?php echo e(session('message')); ?>

        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!--[if BLOCK]><![endif]--><?php if(!$athleteProfile): ?>
        <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Profile Required</h3>
                    <p class="mt-1 text-sm text-yellow-700">
                        You need to create an athlete profile before you can add highlights.
                    </p>
                    <div class="mt-3">
                        <a href="<?php echo e(route('admin.profile')); ?>" class="inline-flex items-center px-3 py-2 bg-yellow-600 text-white text-sm rounded-md hover:bg-yellow-700 transition">
                            Create Profile First
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <div class="mb-6">
        <button wire:click="create" 
                wire:loading.attr="disabled"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
            <svg wire:loading wire:target="create" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            + Add Highlight
        </button>
    </div>

    <!-- Highlights Grid -->
    <!--[if BLOCK]><![endif]--><?php if($highlights->count() > 0): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $highlights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $highlight): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-white shadow rounded-lg overflow-hidden flex flex-col">
            <div class="aspect-video bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center relative overflow-hidden">
                <!-- Type Badge - Top Right -->
                <div class="absolute top-2 right-2 z-10 flex flex-col items-end gap-2">
                    <span class="text-xs px-2 py-1 rounded font-semibold <?php echo e($highlight->type === 'video' ? 'bg-purple-600 text-white' : 'bg-green-600 text-white'); ?>">
                        <?php echo e(ucfirst($highlight->type)); ?>

                    </span>
                    <!--[if BLOCK]><![endif]--><?php if(!$highlight->is_active): ?>
                    <span class="text-xs px-2 py-1 rounded bg-red-500 text-white">Inactive</span>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                
                <!--[if BLOCK]><![endif]--><?php if($highlight->is_featured): ?>
                <div class="absolute top-2 left-2 bg-yellow-500 text-white text-xs px-2 py-1 rounded z-10">Featured</div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                
                <!--[if BLOCK]><![endif]--><?php if($highlight->type === 'photo' && $highlight->photo_path): ?>
                    <?php
                        // Handle both external URLs (seeder) and uploaded files
                        $photoUrl = str_starts_with($highlight->photo_path, 'http') 
                            ? $highlight->photo_path 
                            : asset('storage/' . $highlight->photo_path);
                    ?>
                    <img src="<?php echo e($photoUrl); ?>" 
                         alt="<?php echo e($highlight->title); ?>" 
                         class="w-full h-full object-cover">
                <?php elseif($highlight->type === 'video' && $highlight->video_url): ?>
                    <?php
                        // Get video thumbnail
                        $thumbnail = \App\Helpers\VideoHelper::getThumbnailUrl($highlight->video_url);
                    ?>
                    <!--[if BLOCK]><![endif]--><?php if($thumbnail): ?>
                        <img src="<?php echo e($thumbnail); ?>" 
                             alt="<?php echo e($highlight->title); ?>" 
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    <?php else: ?>
                        <svg class="w-16 h-16 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <?php else: ?>
                    <svg class="w-16 h-16 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <div class="p-4 flex flex-col flex-grow">
                <div class="flex-grow">
                    <h3 class="font-bold text-gray-900 mb-2"><?php echo e($highlight->title); ?></h3>
                    <p class="text-sm text-gray-600 mb-2"><?php echo e($highlight->description); ?></p>
                    <!--[if BLOCK]><![endif]--><?php if($highlight->type === 'video' && $highlight->duration): ?>
                    <p class="text-xs text-gray-500">Duration: <?php echo e($highlight->duration); ?></p>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                
                <!-- Edit/Delete Actions - Bottom Right -->
                <div class="flex justify-end space-x-2 mt-4 pt-3 border-t border-gray-200">
                    <button wire:click="edit(<?php echo e($highlight->id); ?>)" 
                            wire:loading.attr="disabled"
                            wire:target="edit(<?php echo e($highlight->id); ?>)"
                            class="text-blue-600 hover:text-blue-900 text-sm disabled:opacity-50 inline-flex items-center gap-1">
                        <svg wire:loading wire:target="edit(<?php echo e($highlight->id); ?>)" class="animate-spin h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Edit
                    </button>
                    <button wire:click="delete(<?php echo e($highlight->id); ?>)" 
                            wire:loading.attr="disabled"
                            wire:target="delete(<?php echo e($highlight->id); ?>)"
                            onclick="return confirm('Are you sure?')" 
                            class="text-red-600 hover:text-red-900 text-sm disabled:opacity-50 inline-flex items-center gap-1">
                        <svg wire:loading wire:target="delete(<?php echo e($highlight->id); ?>)" class="animate-spin h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Delete
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    </div>
    <?php else: ?>
    <div class="bg-white shadow rounded-lg p-6 text-center text-gray-500">
        No highlights added yet. Click "Add Highlight" to get started.
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- Edit/Create Form -->
    <!--[if BLOCK]><![endif]--><?php if($editingId): ?>
    <div class="bg-white shadow rounded-lg p-6" 
         x-data 
         x-init="$el.scrollIntoView({ behavior: 'smooth', block: 'start' })">
        <h3 class="text-lg font-medium text-gray-900 mb-4">
            <?php echo e($editingId === 'new' ? 'Add' : 'Edit'); ?> Highlight
        </h3>
        
        <form wire:submit.prevent="save" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                    <input type="text" wire:model="title" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type *</label>
                    <select wire:model.live="type" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="video">Video</option>
                        <option value="photo">Photo</option>
                    </select>
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <!--[if BLOCK]><![endif]--><?php if($type === 'video'): ?>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Video URL *</label>
                        <input type="url" wire:model="video_url" placeholder="https://youtube.com/watch?v=..." class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        <p class="text-xs text-gray-500 mt-1">
                            ✓ Supported: YouTube, YouTube Shorts, Hudl, Vimeo<br>
                            Examples: youtube.com/watch?v=xxxxx, youtu.be/xxxxx, hudl.com/video/xxxxx
                        </p>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['video_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                <?php else: ?>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Photo <?php echo e($editingId === 'new' ? '*' : '(Optional - leave empty to keep current)'); ?>

                        </label>
                        <input type="file" wire:model="photo" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        <p class="text-xs text-gray-500 mt-1">
                            Accepted formats: JPG, PNG, GIF, WebP • Max size: 10MB
                        </p>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        
                        <!--[if BLOCK]><![endif]--><?php if($photo): ?>
                            <div class="mt-2">
                                <img src="<?php echo e($photo->temporaryUrl()); ?>" class="h-32 rounded border">
                            </div>
                        <?php elseif($editingId !== 'new'): ?>
                            <?php
                                $highlight = App\Models\Highlight::find($editingId);
                                if ($highlight && $highlight->photo_path) {
                                    $currentPhotoUrl = str_starts_with($highlight->photo_path, 'http') 
                                        ? $highlight->photo_path 
                                        : asset('storage/' . $highlight->photo_path);
                                }
                            ?>
                            <!--[if BLOCK]><![endif]--><?php if($highlight && $highlight->photo_path): ?>
                                <div class="mt-2">
                                    <p class="text-xs text-gray-500 mb-1">Current photo:</p>
                                    <img src="<?php echo e($currentPhotoUrl); ?>" class="h-32 rounded border">
                                </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <!--[if BLOCK]><![endif]--><?php if($type === 'video'): ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Duration</label>
                        <input type="text" wire:model="duration" placeholder="3:45" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Display Order *</label>
                    <input type="number" wire:model="order" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <div class="flex items-center space-x-6 pt-6">
                    <label class="flex items-center">
                        <input type="checkbox" wire:model="is_featured" class="mr-2">
                        <span class="text-sm text-gray-700">Featured</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" wire:model="is_active" class="mr-2">
                        <span class="text-sm text-gray-700">Active</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea wire:model="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" 
                        wire:click="cancel" 
                        wire:loading.attr="disabled"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                    Cancel
                </button>
                <button type="submit" 
                        wire:loading.attr="disabled"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                    <svg wire:loading wire:target="save" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="save">Save</span>
                    <span wire:loading wire:target="save">Saving...</span>
                </button>
            </div>
        </form>
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /var/www/html/resources/views/livewire/admin/manage-highlights.blade.php ENDPATH**/ ?>