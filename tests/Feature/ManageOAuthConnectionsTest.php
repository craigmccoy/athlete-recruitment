<?php

namespace Tests\Feature;

use App\Livewire\ManageOAuthConnections;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ManageOAuthConnectionsTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_displays_connected_oauth_provider()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'provider' => 'google',
            'provider_id' => 'google-123',
            'provider_linked_at' => now()->subDays(3),
        ]);

        Livewire::actingAs($user)
            ->test(ManageOAuthConnections::class)
            ->assertSee('Google')
            ->assertSee('Linked')
            ->assertSee('Unlink');
    }

    #[Test]
    public function it_shows_available_providers_when_not_connected()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'provider' => null,
        ]);

        // Mock Google as configured
        config([
            'fortify.oauth_providers.google' => true,
            'services.google.client_id' => 'test-id',
            'services.google.client_secret' => 'test-secret',
        ]);

        Livewire::actingAs($user)
            ->test(ManageOAuthConnections::class)
            ->assertSee('Connect your account')
            ->assertSee('Connect with Google');
    }

    #[Test]
    public function it_allows_unlinking_when_password_exists()
    {
        // OAuth users now always have a password (random if not set by user)
        // This test verifies that unlinking works when password exists
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'provider' => 'google',
            'provider_id' => 'google-123',
            'provider_linked_at' => now(),
        ]);

        Livewire::actingAs($user)
            ->test(ManageOAuthConnections::class)
            ->call('unlinkProvider')
            ->assertDispatched('show-alert');

        // Provider should be unlinked
        $user->refresh();
        $this->assertNull($user->provider);
        $this->assertNull($user->provider_id);
        $this->assertNull($user->provider_linked_at);
    }

    #[Test]
    public function it_successfully_unlinks_oauth_provider_with_password()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'provider' => 'google',
            'provider_id' => 'google-123',
            'provider_linked_at' => now(),
        ]);

        Livewire::actingAs($user)
            ->test(ManageOAuthConnections::class)
            ->call('unlinkProvider')
            ->assertDispatched('show-alert');

        // Provider should be unlinked
        $user->refresh();
        $this->assertNull($user->provider);
        $this->assertNull($user->provider_id);
        $this->assertNull($user->provider_linked_at);
    }

    #[Test]
    public function it_hides_section_when_no_providers_configured()
    {
        $user = User::factory()->create([
            'provider' => null,
        ]);

        // Disable all OAuth providers
        config([
            'fortify.oauth_providers.google' => false,
            'fortify.oauth_providers.github' => false,
        ]);

        Livewire::actingAs($user)
            ->test(ManageOAuthConnections::class)
            ->assertSee('No OAuth providers are currently configured');
    }

    #[Test]
    public function it_detects_available_oauth_providers()
    {
        $user = User::factory()->create(['provider' => null]);

        // Configure multiple providers
        config([
            'fortify.oauth_providers.google' => true,
            'fortify.oauth_providers.github' => true,
            'services.google.client_id' => 'google-id',
            'services.google.client_secret' => 'google-secret',
            'services.github.client_id' => 'github-id',
            'services.github.client_secret' => 'github-secret',
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageOAuthConnections::class);

        $availableProviders = $component->get('availableProviders');
        
        $this->assertCount(2, $availableProviders);
        $this->assertEquals('google', $availableProviders[0]['name']);
        $this->assertEquals('github', $availableProviders[1]['name']);
    }

    #[Test]
    public function it_only_shows_enabled_and_configured_providers()
    {
        $user = User::factory()->create(['provider' => null]);

        // Google enabled but not configured
        config([
            'fortify.oauth_providers.google' => true,
            'services.google.client_id' => null,
            'services.google.client_secret' => null,
        ]);

        $component = Livewire::actingAs($user)
            ->test(ManageOAuthConnections::class);

        $availableProviders = $component->get('availableProviders');
        
        // Should be empty since Google is not configured
        $this->assertCount(0, $availableProviders);
    }
}
