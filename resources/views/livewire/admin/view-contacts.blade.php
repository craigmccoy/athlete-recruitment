<div>
    @if (session()->has('message'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('message') }}
        </div>
    @endif

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="text-2xl font-bold text-blue-600">{{ $contacts->count() }}</div>
            <div class="text-sm text-gray-600">Total Messages</div>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <div class="text-2xl font-bold text-green-600">{{ $contacts->where('is_read', true)->count() }}</div>
            <div class="text-sm text-gray-600">Read</div>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <div class="text-2xl font-bold text-red-600">{{ $contacts->where('is_read', false)->count() }}</div>
            <div class="text-sm text-gray-600">Unread</div>
        </div>
    </div>

    <!-- Contacts Table -->
    @if($contacts->count() > 0)
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Organization</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($contacts as $contact)
                <tr class="hover:bg-gray-50 {{ $contact->is_read ? '' : 'bg-blue-50' }}">
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($contact->is_read)
                        <span class="px-2 py-1 text-xs rounded-full bg-gray-200 text-gray-700">Read</span>
                        @else
                        <span class="px-2 py-1 text-xs rounded-full bg-blue-500 text-white">New</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $contact->name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-700">{{ $contact->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-700">{{ $contact->organization ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $contact->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button wire:click="viewContact({{ $contact->id }})" 
                                wire:loading.attr="disabled"
                                wire:target="viewContact({{ $contact->id }})"
                                class="text-blue-600 hover:text-blue-900 mr-3 disabled:opacity-50 inline-flex items-center gap-1">
                            <svg wire:loading wire:target="viewContact({{ $contact->id }})" class="animate-spin h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            View
                        </button>
                        @if($contact->is_read)
                        <button wire:click="markAsUnread({{ $contact->id }})" 
                                wire:loading.attr="disabled"
                                wire:target="markAsUnread({{ $contact->id }})"
                                class="text-gray-600 hover:text-gray-900 mr-3 disabled:opacity-50 inline-flex items-center gap-1">
                            <svg wire:loading wire:target="markAsUnread({{ $contact->id }})" class="animate-spin h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Mark Unread
                        </button>
                        @endif
                        <button wire:click="delete({{ $contact->id }})" 
                                wire:loading.attr="disabled"
                                wire:target="delete({{ $contact->id }})"
                                onclick="return confirm('Are you sure?')" 
                                class="text-red-600 hover:text-red-900 disabled:opacity-50 inline-flex items-center gap-1">
                            <svg wire:loading wire:target="delete({{ $contact->id }})" class="animate-spin h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Delete
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="bg-white shadow rounded-lg p-6 text-center text-gray-500">
        No contact submissions yet.
    </div>
    @endif

    <!-- View Contact Modal -->
    @if($selectedContact)
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-xl font-bold text-gray-900">Contact Submission</h3>
                    <button wire:click="closeModal" 
                            wire:loading.attr="disabled"
                            class="text-gray-400 hover:text-gray-600 disabled:opacity-50">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <div class="text-gray-900">{{ $selectedContact->name }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <a href="mailto:{{ $selectedContact->email }}" class="text-blue-600 hover:text-blue-800">
                            {{ $selectedContact->email }}
                        </a>
                    </div>

                    @if($selectedContact->organization)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Organization</label>
                        <div class="text-gray-900">{{ $selectedContact->organization }}</div>
                    </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                        <div class="bg-gray-50 p-4 rounded-md text-gray-900 whitespace-pre-wrap">{{ $selectedContact->message }}</div>
                    </div>

                    <div class="flex justify-between text-sm text-gray-500 pt-4 border-t">
                        <div>Submitted: {{ $selectedContact->created_at->format('M d, Y g:i A') }}</div>
                        @if($selectedContact->read_at)
                        <div>Read: {{ $selectedContact->read_at->format('M d, Y g:i A') }}</div>
                        @endif
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                    <button wire:click="closeModal" 
                            wire:loading.attr="disabled"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                        Close
                    </button>
                    <a href="mailto:{{ $selectedContact->email }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Reply via Email
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
