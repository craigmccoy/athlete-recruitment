<x-guest-layout title="Login">
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        @php
            $oauthProviders = [];
            $enabledProviders = config('fortify.oauth_providers', []);
            
            foreach ($enabledProviders as $provider => $enabled) {
                if ($enabled) {
                    $providerConfig = config("services.{$provider}");
                    if (!empty($providerConfig['client_id']) && !empty($providerConfig['client_secret'])) {
                        $oauthProviders[] = $provider;
                    }
                }
            }
            
            $emailLoginEnabled = config('fortify.email_login_enabled', true);
        @endphp

        <!-- OAuth Sign In Buttons -->
        @if(count($oauthProviders) > 0)
            <div class="space-y-3 mb-6">
                @foreach($oauthProviders as $provider)
                    <a href="{{ route('social.redirect', ['provider' => $provider]) }}" class="w-full inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        <x-oauth-icon :provider="$provider" class="mr-2" />
                        Sign in with {{ ucfirst($provider) }}
                    </a>
                @endforeach
            </div>

            @if($emailLoginEnabled)
                <!-- Divider -->
                <div class="relative flex items-center my-6">
                    <div class="flex-grow border-t border-gray-300"></div>
                    <span class="flex-shrink mx-4 text-gray-600 text-sm">Or continue with email</span>
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>
            @endif
        @endif

        @if($emailLoginEnabled)
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
        @else
            @if(count($oauthProviders) === 0)
                <div class="text-center py-8">
                    <p class="text-gray-600">No authentication methods are currently available. Please contact an administrator.</p>
                </div>
            @endif
        @endif
    </x-authentication-card>
</x-guest-layout>
