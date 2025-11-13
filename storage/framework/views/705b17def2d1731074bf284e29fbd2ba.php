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
                        You need to create an athlete profile before you can add season statistics.
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
            + Add Season Stats
        </button>
    </div>

    <!-- Stats Table -->
    <!--[if BLOCK]><![endif]--><?php if($stats->count() > 0): ?>
    <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Season</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sport</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"><?php echo e($sport === 'soccer' ? 'Matches' : ($sport === 'track' ? 'Meets' : 'Games')); ?></th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stats Summary</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo e($stat->season_year); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <?php echo e(ucfirst($stat->sport)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?php echo e($stat->competitions); ?></td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            <!--[if BLOCK]><![endif]--><?php if($stat->stats): ?>
                                <?php
                                    $displayStats = collect($stat->stats)->take(3)->map(function($value, $key) {
                                        return ucwords(str_replace('_', ' ', $key)) . ': ' . (is_numeric($value) ? number_format($value, 1) : $value);
                                    })->join(' | ');
                                ?>
                                <?php echo e($displayStats); ?>

                            <?php else: ?>
                                <span class="text-gray-400">No stats</span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="edit(<?php echo e($stat->id); ?>)" 
                                    wire:loading.attr="disabled"
                                    wire:target="edit(<?php echo e($stat->id); ?>)"
                                    class="text-blue-600 hover:text-blue-900 mr-3 disabled:opacity-50 inline-flex items-center gap-1">
                                Edit
                            </button>
                            <button wire:click="delete(<?php echo e($stat->id); ?>)" 
                                    wire:loading.attr="disabled"
                                    wire:target="delete(<?php echo e($stat->id); ?>)"
                                    onclick="return confirm('Are you sure?')" 
                                    class="text-red-600 hover:text-red-900 disabled:opacity-50 inline-flex items-center gap-1">
                                Delete
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </tbody>
            </table>
        </div>
    </div>
    <?php else: ?>
    <div class="bg-white shadow rounded-lg p-6 text-center text-gray-500">
        No season stats added yet. Click "Add Season Stats" to get started.
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <!-- Edit/Create Form -->
    <!--[if BLOCK]><![endif]--><?php if($editingId): ?>
    <div class="bg-white shadow rounded-lg p-6" 
         x-data 
         x-init="$el.scrollIntoView({ behavior: 'smooth', block: 'start' })">
        <h3 class="text-lg font-medium text-gray-900 mb-4">
            <?php echo e($editingId === 'new' ? 'Add' : 'Edit'); ?> Season Stats
        </h3>
        
        <form wire:submit.prevent="save" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Season Year *</label>
                    <input type="number" wire:model="season_year" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['season_year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e($sport === 'soccer' ? 'Matches' : ($sport === 'track' ? 'Meets' : 'Games')); ?> *</label>
                    <input type="number" wire:model="competitions" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['competitions'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>

            <div class="border-t border-gray-200 pt-4">
                <h4 class="text-md font-medium text-gray-900 mb-4"><?php echo e(ucfirst($sport)); ?> Statistics</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $statFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <?php echo e(ucwords(str_replace('_', ' ', $field))); ?>

                            </label>
                            <!--[if BLOCK]><![endif]--><?php if(in_array($field, ['best_time', 'personal_record'])): ?>
                                <input type="text" 
                                       wire:model="statFields.<?php echo e($field); ?>" 
                                       placeholder="e.g., 10.5s"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            <?php else: ?>
                                <input type="number" 
                                       step="0.01"
                                       wire:model="statFields.<?php echo e($field); ?>" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Notes (optional)</label>
                <textarea wire:model="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
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
<?php /**PATH /var/www/html/resources/views/livewire/admin/manage-stats.blade.php ENDPATH**/ ?>