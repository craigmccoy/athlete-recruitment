<div>
    <?php if (isset($component)) { $__componentOriginal1a4a318d932e02d86670f282a316cd31 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a4a318d932e02d86670f282a316cd31 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.action-section','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('action-section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
         <?php $__env->slot('title', null, []); ?> 
            <?php echo e(__('OAuth Connections')); ?>

         <?php $__env->endSlot(); ?>

         <?php $__env->slot('description', null, []); ?> 
            <?php echo e(__('Manage your social login connections. You can link your account to OAuth providers for easier sign-in.')); ?>

         <?php $__env->endSlot(); ?>

         <?php $__env->slot('content', null, []); ?> 
            <div class="max-w-xl text-sm text-gray-600">
                <!--[if BLOCK]><![endif]--><?php if($provider): ?>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="flex items-center space-x-3">
                            <!-- Provider Icon -->
                            <div class="flex-shrink-0">
                                <?php if (isset($component)) { $__componentOriginal142e5ed3d54b03eeebbc6fd2cfba4907 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal142e5ed3d54b03eeebbc6fd2cfba4907 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.oauth-icon','data' => ['provider' => $provider,'size' => 'w-8 h-8']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('oauth-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['provider' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($provider),'size' => 'w-8 h-8']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal142e5ed3d54b03eeebbc6fd2cfba4907)): ?>
<?php $attributes = $__attributesOriginal142e5ed3d54b03eeebbc6fd2cfba4907; ?>
<?php unset($__attributesOriginal142e5ed3d54b03eeebbc6fd2cfba4907); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal142e5ed3d54b03eeebbc6fd2cfba4907)): ?>
<?php $component = $__componentOriginal142e5ed3d54b03eeebbc6fd2cfba4907; ?>
<?php unset($__componentOriginal142e5ed3d54b03eeebbc6fd2cfba4907); ?>
<?php endif; ?>
                            </div>

                            <!-- Provider Info -->
                            <div>
                                <div class="font-semibold text-gray-900"><?php echo e(ucfirst($provider)); ?></div>
                                <div class="text-xs text-gray-500">
                                    Linked <?php echo e($provider_linked_at ? $provider_linked_at->diffForHumans() : 'recently'); ?>

                                </div>
                            </div>
                        </div>

                        <!-- Unlink Button -->
                        <?php if (isset($component)) { $__componentOriginal656e8c5ea4d9a4fa173298297bfe3f11 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal656e8c5ea4d9a4fa173298297bfe3f11 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.danger-button','data' => ['wire:click' => 'unlinkProvider','wire:loading.attr' => 'disabled']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('danger-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'unlinkProvider','wire:loading.attr' => 'disabled']); ?>
                            <?php echo e(__('Unlink')); ?>

                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal656e8c5ea4d9a4fa173298297bfe3f11)): ?>
<?php $attributes = $__attributesOriginal656e8c5ea4d9a4fa173298297bfe3f11; ?>
<?php unset($__attributesOriginal656e8c5ea4d9a4fa173298297bfe3f11); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal656e8c5ea4d9a4fa173298297bfe3f11)): ?>
<?php $component = $__componentOriginal656e8c5ea4d9a4fa173298297bfe3f11; ?>
<?php unset($__componentOriginal656e8c5ea4d9a4fa173298297bfe3f11); ?>
<?php endif; ?>
                    </div>

                    <p class="mt-4 text-xs text-gray-500">
                        <strong>Note:</strong> A password was automatically set when you connected via OAuth. You can update it in the "Update Password" section if needed.
                    </p>
                <?php else: ?>
                    <!--[if BLOCK]><![endif]--><?php if($this->availableProviders): ?>
                        <p class="text-sm text-gray-600 mb-4">Connect your account with an OAuth provider for easier sign-in:</p>
                        <div class="space-y-3">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $this->availableProviders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $availableProvider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('social.redirect', ['provider' => $availableProvider['name']])); ?>" 
                                   class="w-full inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    <?php if (isset($component)) { $__componentOriginal142e5ed3d54b03eeebbc6fd2cfba4907 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal142e5ed3d54b03eeebbc6fd2cfba4907 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.oauth-icon','data' => ['provider' => $availableProvider['name'],'class' => 'mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('oauth-icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['provider' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($availableProvider['name']),'class' => 'mr-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal142e5ed3d54b03eeebbc6fd2cfba4907)): ?>
<?php $attributes = $__attributesOriginal142e5ed3d54b03eeebbc6fd2cfba4907; ?>
<?php unset($__attributesOriginal142e5ed3d54b03eeebbc6fd2cfba4907); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal142e5ed3d54b03eeebbc6fd2cfba4907)): ?>
<?php $component = $__componentOriginal142e5ed3d54b03eeebbc6fd2cfba4907; ?>
<?php unset($__componentOriginal142e5ed3d54b03eeebbc6fd2cfba4907); ?>
<?php endif; ?>
                                    Connect with <?php echo e($availableProvider['display_name']); ?>

                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <p class="text-sm text-gray-500">No OAuth providers are currently configured.</p>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
         <?php $__env->endSlot(); ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a4a318d932e02d86670f282a316cd31)): ?>
<?php $attributes = $__attributesOriginal1a4a318d932e02d86670f282a316cd31; ?>
<?php unset($__attributesOriginal1a4a318d932e02d86670f282a316cd31); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a4a318d932e02d86670f282a316cd31)): ?>
<?php $component = $__componentOriginal1a4a318d932e02d86670f282a316cd31; ?>
<?php unset($__componentOriginal1a4a318d932e02d86670f282a316cd31); ?>
<?php endif; ?>
</div>
<?php /**PATH /var/www/html/resources/views/livewire/manage-oauth-connections.blade.php ENDPATH**/ ?>