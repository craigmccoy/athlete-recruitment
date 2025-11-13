<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class OAuthAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    #[Test]
    public function it_redirects_to_google_oauth_provider()
    {
        $response = $this->get(route('social.redirect', ['provider' => 'google']));

        $response->assertRedirect();
        $this->assertStringContainsString('google', $response->headers->get('Location'));
    }

    #[Test]
    public function it_rejects_invalid_oauth_provider()
    {
        $response = $this->get(route('social.redirect', ['provider' => 'invalid']));

        $response->assertNotFound();
    }

    #[Test]
    public function it_allows_existing_user_to_login_via_oauth()
    {
        // Create existing user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'name' => 'Test User',
        ]);

        // Mock Socialite
        $abstractUser = Mockery::mock(SocialiteUser::class);
        $abstractUser->shouldReceive('getId')->andReturn('google-id-123');
        $abstractUser->shouldReceive('getEmail')->andReturn('test@example.com');
        $abstractUser->shouldReceive('getName')->andReturn('Test User');

        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        // Attempt OAuth callback
        $response = $this->get(route('social.callback', ['provider' => 'google']));

        // Assert redirected to dashboard
        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);

        // Assert provider info saved
        $user->refresh();
        $this->assertEquals('google', $user->provider);
        $this->assertEquals('google-id-123', $user->provider_id);
        $this->assertNotNull($user->provider_linked_at);
    }

    #[Test]
    public function it_denies_access_for_non_existing_user()
    {
        // Mock Socialite with non-existing user email
        $abstractUser = Mockery::mock(SocialiteUser::class);
        $abstractUser->shouldReceive('getId')->andReturn('google-id-456');
        $abstractUser->shouldReceive('getEmail')->andReturn('nonexistent@example.com');
        $abstractUser->shouldReceive('getName')->andReturn('Non Existent');

        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        // Attempt OAuth callback
        $response = $this->get(route('social.callback', ['provider' => 'google']));

        // Assert redirected to login with error
        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    #[Test]
    public function it_updates_provider_info_on_subsequent_logins()
    {
        // Create user with old provider info
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'provider' => 'github',
            'provider_id' => 'old-id',
        ]);

        // Mock Socialite with Google credentials
        $abstractUser = Mockery::mock(SocialiteUser::class);
        $abstractUser->shouldReceive('getId')->andReturn('new-google-id');
        $abstractUser->shouldReceive('getEmail')->andReturn('test@example.com');

        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        // Login via Google
        $this->get(route('social.callback', ['provider' => 'google']));

        // Assert provider updated to Google
        $user->refresh();
        $this->assertEquals('google', $user->provider);
        $this->assertEquals('new-google-id', $user->provider_id);
    }

    #[Test]
    public function it_handles_oauth_exception_gracefully()
    {
        // Mock Socialite to throw exception
        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('user')->andThrow(new \Exception('OAuth failed'));

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        // Attempt OAuth callback
        $response = $this->get(route('social.callback', ['provider' => 'google']));

        // Assert redirected with error
        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    #[Test]
    public function it_accepts_multiple_oauth_providers()
    {
        $allowedProviders = ['google', 'github', 'facebook', 'twitter', 'linkedin'];

        foreach ($allowedProviders as $provider) {
            // Mock each provider to avoid actual OAuth calls
            $mockProvider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
            $mockProvider->shouldReceive('redirect')->andReturn(redirect("https://{$provider}.com/oauth"));

            Socialite::shouldReceive('driver')->with($provider)->andReturn($mockProvider);

            $response = $this->get(route('social.redirect', ['provider' => $provider]));
            
            // Should redirect successfully (not 404)
            $response->assertRedirect();
        }
    }

    #[Test]
    public function it_maintains_password_for_oauth_users()
    {
        // Create user with password (as created by user:create --random-password)
        $originalPassword = bcrypt('initial-random-password');
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => $originalPassword,
        ]);

        $this->assertNotNull($user->password);

        // Mock Socialite
        $abstractUser = Mockery::mock(SocialiteUser::class);
        $abstractUser->shouldReceive('getId')->andReturn('google-123');
        $abstractUser->shouldReceive('getEmail')->andReturn('test@example.com');

        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        // Login via OAuth
        $this->get(route('social.callback', ['provider' => 'google']));

        // User should still have their original password (not changed)
        $user->refresh();
        $this->assertNotNull($user->password);
        $this->assertEquals($originalPassword, $user->password);
        $this->assertEquals('google', $user->provider);
    }

    #[Test]
    public function it_maintains_provider_info_after_login()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'provider' => 'google',
            'provider_id' => 'google-123',
            'provider_linked_at' => now()->subDays(5),
        ]);

        $originalLinkedAt = $user->provider_linked_at;

        // Mock Socialite
        $abstractUser = Mockery::mock(SocialiteUser::class);
        $abstractUser->shouldReceive('getId')->andReturn('google-123');
        $abstractUser->shouldReceive('getEmail')->andReturn('test@example.com');

        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        // Login
        $this->get(route('social.callback', ['provider' => 'google']));

        $user->refresh();
        
        // Provider info should remain the same (not updated on same provider login)
        $this->assertEquals('google', $user->provider);
        $this->assertEquals('google-123', $user->provider_id);
    }
}
