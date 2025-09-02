<?php

namespace App\Livewire;

use App\Models\MlsProvider;
use Livewire\Component;

class MlsManager extends Component
{
    // All existing providers
    public $providers;

    // Form properties
    public $name = '';
    public $slug = '';
    public $api_url = '';
    public $api_key = '';

    // State management
    public $isCreating = false;
    public $isEditing = false;
    public ?MlsProvider $editingProvider = null;

    protected function rules()
    {
        // Add unique rule for slug and name when creating
        $slugRule = 'required|alpha_dash|unique:mls_providers,slug';
        $nameRule = 'required|string|min:3|max:255|unique:mls_providers,name';
        
        if ($this->isEditing) {
            $slugRule .= ',' . $this->editingProvider->id;
            $nameRule .= ',' . $this->editingProvider->id;
        }

        return [
            'name' => $nameRule,
            'slug' => $slugRule,
            'api_url' => 'required|url',
            'api_key' => 'required|string|min:10',
        ];
    }

    public function mount()
    {
        $this->loadProviders();
    }

    public function loadProviders()
    {
        $this->providers = MlsProvider::orderBy('name')->get();
    }

    public function create()
    {
        $this->resetForm();
        $this->isCreating = true;
        $this->isEditing = false;
    }

    public function edit(MlsProvider $provider)
    {
        $this->resetForm();
        $this->isEditing = true;
        $this->isCreating = false;
        $this->editingProvider = $provider;

        // Populate form fields (note: we don't populate API key for security)
        $this->name = $provider->name;
        $this->slug = $provider->slug;
        $this->api_url = $provider->credentials['api_url'] ?? '';
        // Don't populate API key for security reasons
    }

    public function saveProvider()
    {
        $this->validate();

        $credentials = [
            'api_url' => $this->api_url,
            'api_key' => $this->api_key,
        ];

        if ($this->isEditing) {
            $this->editingProvider->update([
                'name' => $this->name,
                'slug' => $this->slug,
                'credentials' => $credentials,
            ]);
            session()->flash('message', 'Provider updated successfully.');
        } else {
            MlsProvider::create([
                'name' => $this->name,
                'slug' => $this->slug,
                'credentials' => $credentials,
                'is_active' => true,
            ]);
            session()->flash('message', 'Provider created successfully.');
        }

        $this->resetForm();
        $this->loadProviders();
    }

    public function delete(MlsProvider $provider)
    {
        $provider->delete();
        session()->flash('message', 'Provider deleted successfully.');
        $this->loadProviders();
        $this->resetForm();
    }

    public function cancel()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['name', 'slug', 'api_url', 'api_key', 'isCreating', 'isEditing', 'editingProvider']);
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.mls-manager')->layout('components.layouts.app');
    }
}
