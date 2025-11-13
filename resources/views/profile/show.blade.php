<x-app-layout title="Profile Settings">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()) && config('fortify.email_login_enabled', true))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-section-border />
            @endif

            @php
                // Check if any OAuth providers are configured
                $hasOAuthProviders = false;
                $enabledProviders = config('fortify.oauth_providers', []);
                foreach ($enabledProviders as $provider => $enabled) {
                    if ($enabled) {
                        $config = config("services.{$provider}");
                        if (!empty($config['client_id']) && !empty($config['client_secret'])) {
                            $hasOAuthProviders = true;
                            break;
                        }
                    }
                }
                // Also show if user already has a provider linked
                if (Auth::user()->provider) {
                    $hasOAuthProviders = true;
                }
            @endphp

            @if ($hasOAuthProviders)
                <div class="mt-10 sm:mt-0">
                    @livewire('manage-oauth-connections')
                </div>

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-section-border />
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
