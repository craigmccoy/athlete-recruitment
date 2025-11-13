<div>
    @if (session()->has('message'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('message') }}
        </div>
    @endif

    @if (!$athleteProfile)
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
                        You need to create an athlete profile before you can add testimonials.
                    </p>
                    <div class="mt-3">
                        <a href="{{ route('admin.profile') }}" class="inline-flex items-center px-3 py-2 bg-yellow-600 text-white text-sm rounded-md hover:bg-yellow-700 transition">
                            Create Profile First
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="mb-6">
        <button wire:click="create" 
                wire:loading.attr="disabled"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
            <svg wire:loading wire:target="create" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            + Add Testimonial
        </button>
    </div>

    <!-- Testimonials Grid -->
    @if($testimonials->count() > 0)
    <div class="grid grid-cols-1 gap-6 mb-8">
        @foreach($testimonials as $testimonial)
        <div class="bg-white rounded-lg shadow p-6 {{ $testimonial->is_featured ? 'border-2 border-yellow-400' : 'border border-gray-200' }}">
            <div class="flex justify-between items-start mb-4">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <h3 class="font-bold text-lg text-gray-900">{{ $testimonial->author_name }}</h3>
                        @if($testimonial->is_featured)
                            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">Featured</span>
                        @endif
                        @if(!$testimonial->is_active)
                            <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded">Inactive</span>
                        @endif
                    </div>
                    @if($testimonial->author_title)
                        <p class="text-sm text-gray-600">{{ $testimonial->author_title }}</p>
                    @endif
                    @if($testimonial->author_organization)
                        <p class="text-sm text-gray-500">{{ $testimonial->author_organization }}</p>
                    @endif
                    @if($testimonial->relationship)
                        <p class="text-xs text-gray-500 mt-1">{{ $testimonial->relationship }}</p>
                    @endif
                </div>
                
                <div class="flex space-x-3">
                    <button wire:click="toggleFeatured({{ $testimonial->id }})" 
                            wire:loading.attr="disabled"
                            wire:target="toggleFeatured({{ $testimonial->id }})"
                            class="text-yellow-600 hover:text-yellow-700 disabled:opacity-50 text-sm font-medium inline-flex items-center gap-1">
                        <svg wire:loading wire:target="toggleFeatured({{ $testimonial->id }})" class="animate-spin h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {{ $testimonial->is_featured ? 'Unfeature' : 'Feature' }}
                    </button>
                    <button wire:click="toggleActive({{ $testimonial->id }})" 
                            wire:loading.attr="disabled"
                            wire:target="toggleActive({{ $testimonial->id }})"
                            class="text-gray-600 hover:text-gray-900 disabled:opacity-50 text-sm font-medium inline-flex items-center gap-1">
                        <svg wire:loading wire:target="toggleActive({{ $testimonial->id }})" class="animate-spin h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {{ $testimonial->is_active ? 'Deactivate' : 'Activate' }}
                    </button>
                    <button wire:click="edit({{ $testimonial->id }})" 
                            wire:loading.attr="disabled"
                            wire:target="edit({{ $testimonial->id }})"
                            class="text-blue-600 hover:text-blue-900 disabled:opacity-50 text-sm font-medium inline-flex items-center gap-1">
                        <svg wire:loading wire:target="edit({{ $testimonial->id }})" class="animate-spin h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Edit
                    </button>
                    <button wire:click="delete({{ $testimonial->id }})" 
                            wire:loading.attr="disabled"
                            wire:target="delete({{ $testimonial->id }})"
                            onclick="return confirm('Are you sure you want to delete this testimonial?')"
                            class="text-red-600 hover:text-red-900 disabled:opacity-50 text-sm font-medium inline-flex items-center gap-1">
                        <svg wire:loading wire:target="delete({{ $testimonial->id }})" class="animate-spin h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Delete
                    </button>
                </div>
            </div>

            <p class="text-gray-700 mb-3 italic">"{{ $testimonial->content }}"</p>

            @if($testimonial->date)
            <div class="text-sm text-gray-500">
                <span>{{ $testimonial->date->format('M d, Y') }}</span>
            </div>
            @endif
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-white shadow rounded-lg p-6 text-center text-gray-500">
        No testimonials added yet. Click "Add Testimonial" to get started.
    </div>
    @endif

    <!-- Edit/Create Form -->
    @if($editingId)
    <div class="bg-white shadow rounded-lg p-6" 
         x-data 
         x-init="$el.scrollIntoView({ behavior: 'smooth', block: 'start' })">
        <h3 class="text-lg font-medium text-gray-900 mb-4">
            {{ $editingId === 'new' ? 'Add' : 'Edit' }} Testimonial
        </h3>
        
        <form wire:submit.prevent="save" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Author Name *</label>
                    <input type="text" wire:model="author_name" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    @error('author_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Author Title</label>
                    <input type="text" wire:model="author_title" placeholder="e.g., Head Coach" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    @error('author_title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Organization</label>
                    <input type="text" wire:model="author_organization" placeholder="e.g., Lincoln High School" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    @error('author_organization') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Relationship</label>
                    <select wire:model="relationship" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="">Select...</option>
                        <option value="Coach">Coach</option>
                        <option value="Teammate">Teammate</option>
                        <option value="Teacher">Teacher</option>
                        <option value="Athletic Director">Athletic Director</option>
                        <option value="Mentor">Mentor</option>
                        <option value="Trainer">Trainer</option>
                    </select>
                    @error('relationship') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                    <input type="date" wire:model="date" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    @error('date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Display Order *</label>
                    <input type="number" wire:model="order" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    @error('order') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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
                <label class="block text-sm font-medium text-gray-700 mb-2">Testimonial Content *</label>
                <textarea wire:model="content" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
                @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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
    @endif
</div>
