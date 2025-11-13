<div>
    <x-action-section>
        <x-slot name="title">
            {{ __('OAuth Connections') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Manage your social login connections. You can link your account to OAuth providers for easier sign-in.') }}
        </x-slot>

        <x-slot name="content">
            <div class="max-w-xl text-sm text-gray-600">
                @if($provider)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="flex items-center space-x-3">
                            <!-- Provider Icon -->
                            <div class="flex-shrink-0">
                                <x-oauth-icon :provider="$provider" size="w-8 h-8" />
                            </div>

                            <!-- Provider Info -->
                            <div>
                                <div class="font-semibold text-gray-900">{{ ucfirst($provider) }}</div>
                                <div class="text-xs text-gray-500">
                                    Linked {{ $provider_linked_at ? $provider_linked_at->diffForHumans() : 'recently' }}
                                </div>
                            </div>
                        </div>

                        <!-- Unlink Button -->
                        <x-danger-button wire:click="unlinkProvider" wire:loading.attr="disabled">
                            {{ __('Unlink') }}
                        </x-danger-button>
                    </div>

                    <p class="mt-4 text-xs text-gray-500">
                        <strong>Note:</strong> A password was automatically set when you connected via OAuth. You can update it in the "Update Password" section if needed.
                    </p>
                @else
                    @if($this->availableProviders)
                        <p class="text-sm text-gray-600 mb-4">Connect your account with an OAuth provider for easier sign-in:</p>
                        <div class="space-y-3">
                            @foreach($this->availableProviders as $availableProvider)
                                <a href="{{ route('social.redirect', ['provider' => $availableProvider['name']]) }}" 
                                   class="w-full inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    <x-oauth-icon :provider="$availableProvider['name']" class="mr-2" />
                                    Connect with {{ $availableProvider['display_name'] }}
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-sm text-gray-500">No OAuth providers are currently configured.</p>
                        </div>
                    @endif
                @endif
            </div>
        </x-slot>
    </x-action-section>
</div>
