<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ManageOAuthConnections extends Component
{
    public $provider;
    public $provider_id;
    public $provider_linked_at;

    public function mount()
    {
        $user = Auth::user();
        $this->provider = $user->provider;
        $this->provider_id = $user->provider_id;
        $this->provider_linked_at = $user->provider_linked_at;
    }

    public function unlinkProvider()
    {
        $user = Auth::user();
        
        // Ensure user has a password before unlinking
        if (!$user->password) {
            $this->dispatch('show-alert', [
                'type' => 'error',
                'message' => 'You must set a password before unlinking your OAuth provider.'
            ]);
            return;
        }

        $user->provider = null;
        $user->provider_id = null;
        $user->provider_linked_at = null;
        $user->save();

        $this->provider = null;
        $this->provider_id = null;
        $this->provider_linked_at = null;

        $this->dispatch('show-alert', [
            'type' => 'success',
            'message' => 'OAuth provider unlinked successfully.'
        ]);
    }

    public function getAvailableProvidersProperty()
    {
        $providers = [];
        $enabledProviders = config('fortify.oauth_providers', []);

        foreach ($enabledProviders as $provider => $enabled) {
            if ($enabled && $this->isProviderConfigured($provider)) {
                $providers[] = [
                    'name' => $provider,
                    'display_name' => ucfirst($provider),
                ];
            }
        }

        return $providers;
    }

    private function isProviderConfigured(string $provider): bool
    {
        $config = config("services.{$provider}");
        return !empty($config['client_id']) && !empty($config['client_secret']);
    }

    public function hasOAuthAvailable(): bool
    {
        return $this->provider !== null || count($this->availableProviders) > 0;
    }

    public function render()
    {
        return view('livewire.manage-oauth-connections');
    }
}
