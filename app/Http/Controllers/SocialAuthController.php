<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Redirect to OAuth provider
     *
     * @param string $provider (google, github, facebook, etc.)
     */
    public function redirect(string $provider)
    {
        $this->validateProvider($provider);
        
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle OAuth provider callback
     * Only allow login if user already exists in database
     *
     * @param string $provider
     */
    public function callback(string $provider)
    {
        $this->validateProvider($provider);
        
        try {
            // Get user info from OAuth provider
            $providerUser = Socialite::driver($provider)->user();
            
            // Check if user exists in our database by email
            $user = User::where('email', $providerUser->getEmail())->first();
            
            // If user doesn't exist, deny access
            if (!$user) {
                return redirect()->route('login')->withErrors([
                    'email' => "No account found with this {$this->getProviderName($provider)} email. Please contact an administrator."
                ]);
            }
            
            // Update provider info if not set or if different provider
            if (!$user->provider || $user->provider !== $provider) {
                $user->provider = $provider;
                $user->provider_id = $providerUser->getId();
                $user->provider_linked_at = now();
            }
            
            // If user doesn't have a password (OAuth-only account), set a random one
            // This ensures database constraints are met and provides emergency access
            if (!$user->password) {
                $user->password = Hash::make(Str::password(16, true, true, true));
            }
            
            $user->save();
            
            // Log the user in
            Auth::login($user, true);
            
            // Redirect to intended page or admin dashboard
            return redirect()->intended(route('dashboard'));
            
        } catch (\Exception $e) {
            \Log::error('OAuth authentication failed', [
                'provider' => $provider,
                'error' => $e->getMessage()
            ]);
            
            return redirect()->route('login')->withErrors([
                'email' => 'Authentication failed. Please try again or use your password.'
            ]);
        }
    }

    /**
     * Validate the OAuth provider
     *
     * @param string $provider
     * @throws \InvalidArgumentException
     */
    protected function validateProvider(string $provider): void
    {
        $allowedProviders = ['google', 'github', 'facebook', 'twitter', 'linkedin'];
        
        if (!in_array($provider, $allowedProviders)) {
            abort(404, 'Invalid OAuth provider');
        }
    }

    /**
     * Get human-readable provider name
     *
     * @param string $provider
     * @return string
     */
    protected function getProviderName(string $provider): string
    {
        return ucfirst($provider);
    }
}
