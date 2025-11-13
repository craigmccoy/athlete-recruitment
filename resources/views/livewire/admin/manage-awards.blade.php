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
                        You need to create an athlete profile before you can add awards.
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
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
            <svg wire:loading wire:target="create" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            + Add Award
        </button>
    </div>

    <!-- Awards Grid -->
    @if($awards->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        @foreach($awards as $award)
        <div class="bg-gradient-to-br from-{{ $award->color }}-50 to-{{ $award->color }}-100 rounded-xl p-6 border-2 border-{{ $award->color }}-300 relative">
            <div class="text-4xl mb-3">{{ $award->icon }}</div>
            <h4 class="font-bold text-gray-900 mb-1 text-lg">{{ $award->title }}</h4>
            <p class="text-sm text-gray-600 mb-2">{{ $award->description }}</p>
            @if($award->year)
            <p class="text-xs text-gray-500 mb-3">{{ $award->year }}</p>
            @endif
            <div class="flex justify-end space-x-2 mt-4 pt-4 border-t border-{{ $award->color }}-200">
                <button wire:click="edit({{ $award->id }})" 
                        wire:loading.attr="disabled"
                        wire:target="edit({{ $award->id }})"
                        class="text-blue-600 hover:text-blue-900 text-sm font-medium disabled:opacity-50 inline-flex items-center gap-1">
                    <svg wire:loading wire:target="edit({{ $award->id }})" class="animate-spin h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Edit
                </button>
                <button wire:click="delete({{ $award->id }})" 
                        wire:loading.attr="disabled"
                        wire:target="delete({{ $award->id }})"
                        onclick="return confirm('Are you sure?')" 
                        class="text-red-600 hover:text-red-900 text-sm font-medium disabled:opacity-50 inline-flex items-center gap-1">
                    <svg wire:loading wire:target="delete({{ $award->id }})" class="animate-spin h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Delete
                </button>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-white shadow rounded-lg p-6 text-center text-gray-500">
        No awards added yet. Click "Add Award" to get started.
    </div>
    @endif

    <!-- Edit/Create Form -->
    @if($editingId)
    <div class="bg-white shadow rounded-lg p-6" 
         x-data 
         x-init="$el.scrollIntoView({ behavior: 'smooth', block: 'start' })">
        <h3 class="text-lg font-medium text-gray-900 mb-4">
            {{ $editingId === 'new' ? 'Add' : 'Edit' }} Award
        </h3>
        
        <form wire:submit.prevent="save" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                    <input type="text" wire:model="title" placeholder="All-Conference" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <input type="text" wire:model="description" placeholder="First Team (2024)" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Year</label>
                    <input type="number" wire:model="year" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Icon (Emoji)</label>
                    <input type="text" wire:model="icon" placeholder="🏆" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <p class="text-xs text-gray-500 mt-1">Use emoji like 🏆 ⭐ 📚 🎖️</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Color Theme</label>
                    <select wire:model="color" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="blue">Blue</option>
                        <option value="yellow">Yellow</option>
                        <option value="green">Green</option>
                        <option value="red">Red</option>
                        <option value="purple">Purple</option>
                        <option value="indigo">Indigo</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Display Order *</label>
                    <input type="number" wire:model="order" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    @error('order') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
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
