<div class="bg-gray-50 font-sans">

    <!-- Header / Navigation -->
    <header class="bg-white shadow-sm">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="text-2xl font-bold text-gray-800">
                    <a href="/" class="flex items-center">
                        @if($logoPath)
                            <img src="{{ asset($logoPath) }}" alt="Company Logo" class="h-8 max-w-32 object-contain">
                        @else
                            RealtyCo
                        @endif
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#" class="text-gray-600 hover:text-indigo-600 transition-colors">Buy</a>
                    <a href="#" class="text-gray-600 hover:text-indigo-600 transition-colors">Sell</a>
                    <a href="#" class="text-gray-600 hover:text-indigo-600 transition-colors">Rent</a>
                    <a href="/properties" class="text-gray-600 hover:text-indigo-600 transition-colors font-semibold text-indigo-600">Properties</a>
                    <a href="/about" class="text-gray-600 hover:text-indigo-600 transition-colors">About</a>
                    
                    <!-- Calculators Dropdown -->
                    <div 
                        x-data="{ open: false }" 
                        @mouseenter="open = true" 
                        @mouseleave="open = false" 
                        class="relative"
                    >
                        <!-- Dropdown Trigger Button -->
                        <button 
                            @click="open = !open" 
                            class="flex items-center text-gray-600 hover:text-indigo-600 transition-colors focus:outline-none"
                        >
                            <span>Calculators</span>
                            <!-- Arrow Icon -->
                            <svg class="ml-1 h-4 w-4 transform transition-transform duration-200" 
                                 :class="{'rotate-180': open}" 
                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Dropdown Panel -->
                        <div 
                            x-show="open" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            class="absolute z-10 right-0 mt-2 w-64 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                            style="display: none;"
                        >
                            <div class="py-1" role="menu" aria-orientation="vertical">
                                <!-- Mortgage Calculator -->
                                <a href="/mortgage-calculator" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                                    <svg class="h-6 w-6 mr-3 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                    </svg>
                                    <div>
                                        <p class="font-medium">Mortgage Calculator</p>
                                        <p class="text-xs text-gray-500">Estimate your monthly payments</p>
                                    </div>
                                </a>
                                
                                <!-- Affordability Calculator -->
                                <a href="/affordability-calculator" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                                    <svg class="h-6 w-6 mr-3 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                    </svg>
                                    <div>
                                        <p class="font-medium">Affordability Calculator</p>
                                        <p class="text-xs text-gray-500">Find out how much house you can afford</p>
                                    </div>
                                </a>
                                
                                <!-- Refinance Calculator -->
                                <a href="/refinance-calculator" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                                    <svg class="h-6 w-6 mr-3 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                                    </svg>
                                    <div>
                                        <p class="font-medium">Refinance Calculator</p>
                                        <p class="text-xs text-gray-500">See if refinancing is right for you</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- News Dropdown -->
                    <div 
                        x-data="{ open: false }" 
                        @click.away="open = false" 
                        @keydown.escape.window="open = false" 
                        class="relative"
                    >
                        <!-- Dropdown Trigger Button -->
                        <button 
                            @click="open = !open" 
                            class="flex items-center text-gray-600 hover:text-indigo-600 transition-colors focus:outline-none"
                        >
                            <span>News</span>
                            <!-- Arrow Icon -->
                            <svg class="ml-1 h-4 w-4 transform transition-transform duration-200" 
                                 :class="{'rotate-180': open}" 
                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Dropdown Panel -->
                        <div 
                            x-show="open" 
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 origin-top-right bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 z-10"
                            style="display: none;"
                        >
                            <!-- All News Link -->
                            <a href="/blog" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                               @click="open = false">
                                All News
                            </a>
                            
                            <!-- Dynamic Category Links -->
                            @foreach($categories as $category)
                                <a href="/news/{{ $category->slug }}" 
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                   @click="open = false">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Communities Dropdown -->
                    <div 
                        x-data="{ open: false }" 
                        @click.away="open = false" 
                        @keydown.escape.window="open = false" 
                        class="relative"
                    >
                        <!-- Dropdown Trigger Button -->
                        <button 
                            @click="open = !open" 
                            class="flex items-center text-gray-600 hover:text-indigo-600 transition-colors focus:outline-none"
                        >
                            <span>Communities</span>
                            <!-- Arrow Icon -->
                            <svg class="ml-1 h-4 w-4 transform transition-transform duration-200" 
                                 :class="{'rotate-180': open}" 
                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Dropdown Panel -->
                        <div 
                            x-show="open" 
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-56 origin-top-right bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 z-10"
                            style="display: none;"
                        >
                            @if($communities->count() > 0)
                                <!-- Dynamic Community Links -->
                                @foreach($communities as $community)
                                    <a href="/communities/{{ $community->slug }}" 
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 border-b border-gray-100 last:border-b-0"
                                       @click="open = false">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ $community->name }}
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <div class="px-4 py-2 text-sm text-gray-500 text-center">
                                    No communities available yet
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="/admin/dashboard" class="text-gray-600 hover:text-indigo-600 transition-colors">
                                Admin
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-gray-600 text-white px-5 py-2 rounded-full hover:bg-gray-700 transition-colors">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="/login" class="text-gray-600 hover:text-indigo-600 transition-colors">
                            Login
                        </a>
                        <a href="/register" class="bg-indigo-600 text-white px-5 py-2 rounded-full hover:bg-indigo-700 transition-colors">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <!-- Page Header -->
    <section class="bg-gradient-to-r from-indigo-600 to-blue-600 py-12">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Property Listings</h1>
            <p class="text-xl text-indigo-100 max-w-2xl mx-auto">Find your perfect home from our extensive collection of premium properties</p>
        </div>
    </section>

    <!-- Main Content -->
    <main class="py-8">
        <div class="container mx-auto px-6">
        
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
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200">
        <div class="container mx-auto px-6 py-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <p class="text-gray-600">&copy; 2024 RealtyCo. All rights reserved.</p>
                <div class="flex mt-4 md:mt-0 space-x-6">
                    <a href="#" class="text-gray-500 hover:text-indigo-600">Privacy Policy</a>
                    <a href="#" class="text-gray-500 hover:text-indigo-600">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

</div>