<div class="bg-gray-100 min-h-screen">
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-8 text-center">Property Listings</h1>
        
        <!-- Search Filters -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">🔍 Search Properties with Elasticsearch</h2>
            
            <!-- General Search Field -->
            <div class="mb-6">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">🚀 General Search</label>
                <input type="text" 
                       id="search"
                       wire:model.live="search" 
                       placeholder="Search properties, descriptions, locations..." 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors text-lg">
                <p class="text-xs text-gray-500 mt-1">Powered by Elasticsearch - Try searching for "luxury", "apartment", "Miami", etc.</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Location Filter -->
                <div>
                    <label for="searchLocation" class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                    <input type="text" 
                           id="searchLocation"
                           wire:model.live="searchLocation" 
                           placeholder="Enter location..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                </div>
                
                <!-- Type Filter -->
                <div>
                    <label for="searchType" class="block text-sm font-medium text-gray-700 mb-2">Property Type</label>
                    <select id="searchType"
                            wire:model.live="searchType" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                        <option value="">Any Type</option>
                        <option value="sale">For Sale</option>
                        <option value="rent">For Rent</option>
                    </select>
                </div>
                
                <!-- Min Price Filter -->
                <div>
                    <label for="minPrice" class="block text-sm font-medium text-gray-700 mb-2">Min Price</label>
                    <input type="number" 
                           id="minPrice"
                           wire:model.live="minPrice" 
                           placeholder="0" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                </div>
                
                <!-- Max Price Filter -->
                <div>
                    <label for="maxPrice" class="block text-sm font-medium text-gray-700 mb-2">Max Price</label>
                    <input type="number" 
                           id="maxPrice"
                           wire:model.live="maxPrice" 
                           placeholder="No limit" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                </div>
            </div>
            
            <!-- Clear Filters Button -->
            <div class="mt-4 flex justify-end">
                <button wire:click="clearFilters" 
                        class="px-4 py-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-colors">
                    Clear All Filters
                </button>
            </div>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($properties as $property)
                <x-property-card :property="$property" />
            @endforeach
        </div>
        
        @if($properties->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $properties->links() }}
            </div>
        @endif
    </div>
</div>