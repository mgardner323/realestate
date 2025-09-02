<div class="bg-gray-100 min-h-screen">
    <div class="container mx-auto p-4 sm:p-6 lg:p-8 max-w-7xl">

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">MLS Providers</h1>
                <p class="text-gray-600">Manage your MLS data providers and their API credentials.</p>
            </div>
            @if (!$isCreating && !$isEditing)
                <button wire:click="create" type="button" class="mt-4 md:mt-0 bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition-colors flex items-center gap-2">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add New Provider
                </button>
            @endif
        </div>

        <!-- Session Message -->
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('message') }}
            </div>
        @endif

        <!-- Add/Edit Form Card -->
        @if ($isCreating || $isEditing)
            <div class="bg-white rounded-lg shadow-xl p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">
                    {{ $isEditing ? 'Edit Provider: ' . $editingProvider->name : 'Add New Provider' }}
                </h2>
                <form wire:submit="saveProvider" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Provider Name</label>
                            <input type="text" 
                                   wire:model="name" 
                                   id="name" 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" 
                                   placeholder="e.g., Bridge Interactive MLS">
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <!-- Slug -->
                        <div>
                            <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                            <input type="text" 
                                   wire:model="slug" 
                                   id="slug" 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-mono" 
                                   placeholder="e.g., bridge-mls">
                            <p class="text-xs text-gray-500 mt-1">A unique identifier (no spaces, use dashes)</p>
                            @error('slug') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- API URL -->
                        <div class="md:col-span-2">
                            <label for="api_url" class="block text-sm font-medium text-gray-700 mb-2">API URL</label>
                            <input type="url" 
                                   wire:model="api_url" 
                                   id="api_url" 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-mono" 
                                   placeholder="https://api.bridgedataoutput.com/api/v2">
                            @error('api_url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- API Key -->
                        <div class="md:col-span-2">
                            <label for="api_key" class="block text-sm font-medium text-gray-700 mb-2">API Key</label>
                            <input type="password" 
                                   wire:model="api_key" 
                                   id="api_key" 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-mono" 
                                   placeholder="{{ $isEditing ? 'Enter new API key to update' : 'Enter your API key' }}">
                            <p class="text-xs text-gray-500 mt-1">Your key will be encrypted and stored securely</p>
                            @error('api_key') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex gap-4 pt-6 border-t border-gray-200">
                        <button type="button" 
                                wire:click="cancel" 
                                class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition-colors">
                            <span wire:loading.remove wire:target="saveProvider">
                                {{ $isEditing ? 'Update Provider' : 'Save Provider' }}
                            </span>
                            <span wire:loading wire:target="saveProvider">
                                Saving...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        @endif

        <!-- Providers Table Card -->
        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-800">Current Providers</h3>
                <p class="text-gray-600 mt-1">{{ count($providers) }} provider{{ count($providers) !== 1 ? 's' : '' }} configured</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-8 py-4 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Provider Name</th>
                            <th class="px-8 py-4 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                            <th class="px-8 py-4 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">API URL</th>
                            <th class="px-8 py-4 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-8 py-4 text-right text-sm font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($providers as $provider)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-8 py-4 text-sm font-medium text-gray-900">{{ $provider->name }}</td>
                                <td class="px-8 py-4 text-sm text-gray-500 font-mono bg-gray-50 rounded">{{ $provider->slug }}</td>
                                <td class="px-8 py-4 text-sm text-gray-500 font-mono">
                                    {{ isset($provider->credentials['api_url']) ? $provider->credentials['api_url'] : 'Not configured' }}
                                </td>
                                <td class="px-8 py-4">
                                    @if($provider->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-4 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <button wire:click="edit({{ $provider->id }})" 
                                                class="text-indigo-600 hover:text-indigo-900 transition-colors" 
                                                title="Edit Provider">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <button wire:click="delete({{ $provider->id }})" 
                                                wire:confirm="Are you sure you want to delete this MLS provider? This action cannot be undone."
                                                class="text-red-600 hover:text-red-900 transition-colors" 
                                                title="Delete Provider">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 012 0v6a1 1 0 11-2 0V8z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="h-12 w-12 text-gray-300 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                        <p class="text-lg font-medium mb-2">No MLS providers found</p>
                                        <p class="text-sm">Click "Add New Provider" to get started with your first MLS integration.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
