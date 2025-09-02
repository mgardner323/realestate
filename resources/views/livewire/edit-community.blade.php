<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Edit Community: {{ $community->name }}</h1>
        <a href="/admin/communities" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            ← Back to Communities
        </a>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-6">
        <form wire:submit.prevent="save">
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Community Name *</label>
                <input 
                    type="text" 
                    id="name"
                    wire:model="name" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                <input 
                    type="text" 
                    id="slug"
                    wire:model="slug" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Leave empty to auto-generate">
                @error('slug') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Statistical Information Section -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-2">
                    <label for="statistical_info" class="block text-sm font-medium text-gray-700">Statistical Information</label>
                    <button 
                        type="button"
                        wire:click="generateStats" 
                        wire:loading.attr="disabled"
                        wire:target="generateStats"
                        class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-1 px-3 rounded text-sm disabled:opacity-50">
                        <span wire:loading.remove wire:target="generateStats">🤖 Generate with AI</span>
                        <span wire:loading wire:target="generateStats">Generating...</span>
                    </button>
                </div>
                
                <div class="relative">
                    <textarea 
                        id="statistical_info"
                        wire:model="statistical_info" 
                        rows="8"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter community statistics, demographics, etc. or use AI generation..."></textarea>
                    @error('statistical_info') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                @if($generatingStats)
                    <div class="mt-2 flex items-center text-purple-600">
                        <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        AI is generating community statistics...
                    </div>
                @endif
            </div>

            <!-- Monthly Events Section -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-2">
                    <label for="monthly_events" class="block text-sm font-medium text-gray-700">Monthly Events</label>
                    <button 
                        type="button"
                        wire:click="generateEvents" 
                        wire:loading.attr="disabled"
                        wire:target="generateEvents"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm disabled:opacity-50">
                        <span wire:loading.remove wire:target="generateEvents">🤖 Generate with AI</span>
                        <span wire:loading wire:target="generateEvents">Generating...</span>
                    </button>
                </div>
                
                <div class="relative">
                    <textarea 
                        id="monthly_events"
                        wire:model="monthly_events" 
                        rows="8"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Describe regular community events, activities, etc. or use AI generation..."></textarea>
                    @error('monthly_events') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                @if($generatingEvents)
                    <div class="mt-2 flex items-center text-green-600">
                        <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        AI is generating community events...
                    </div>
                @endif
            </div>

            <div class="mb-6">
                <label class="flex items-center">
                    <input 
                        type="checkbox" 
                        wire:model="is_published" 
                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                    <span class="ml-2 text-sm text-gray-700">Published</span>
                </label>
            </div>

            <div class="flex justify-end space-x-2">
                <a 
                    href="/admin/communities"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Cancel
                </a>
                <button 
                    type="submit"
                    wire:loading.attr="disabled"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50">
                    <span wire:loading.remove>Update Community</span>
                    <span wire:loading>Updating...</span>
                </button>
            </div>
        </form>
    </div>

    <!-- AI Generation Info Panel -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">AI Content Generation</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <p>Use the "Generate with AI" buttons to automatically create professional content for your community pages. The AI will generate:</p>
                    <ul class="mt-1 list-disc pl-5">
                        <li><strong>Statistical Information:</strong> Demographics, population data, income levels, and other community metrics</li>
                        <li><strong>Monthly Events:</strong> A curated list of community activities, festivals, and regular events</li>
                    </ul>
                    <p class="mt-2 text-xs">Generated content can be edited before saving. AI generation requires an active connection to the Gemini service.</p>
                </div>
            </div>
        </div>
    </div>
</div>
