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
                    <a href="/properties" class="text-gray-600 hover:text-indigo-600 transition-colors">Properties</a>
                    
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
                <div>
                    <a href="#" class="bg-indigo-600 text-white px-5 py-2 rounded-full hover:bg-indigo-700 transition-colors">
                        Contact
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Hero Section -->
        <section class="relative h-[70vh] bg-cover bg-center
            @if($heroPath && str_ends_with($heroPath, '.mp4'))
                bg-black
            @elseif($heroPath)
                bg-black
            @else
                bg-black
            @endif
        " 
        @if($heroPath && !str_ends_with($heroPath, '.mp4'))
            style="background-image: url('{{ asset($heroPath) }}');"
        @elseif(!$heroPath)
            style="background-image: url('https://images.unsplash.com/photo-1568605114967-8130f3a36994?q=80&w=2070&auto=format&fit=crop');"
        @endif
        >
            @if($heroPath && str_ends_with($heroPath, '.mp4'))
                <video autoplay muted loop class="absolute inset-0 w-full h-full object-cover">
                    <source src="{{ asset($heroPath) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            @endif
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
            <div class="relative container mx-auto px-6 h-full flex flex-col items-center justify-center text-center text-white">
                <h1 class="text-4xl md:text-6xl font-bold leading-tight" style="text-shadow: 0 2px 4px rgba(0,0,0,0.4);">Find Your Dream Home</h1>
                <p class="mt-4 text-lg md:text-xl text-gray-200 max-w-2xl" style="text-shadow: 0 2px 4px rgba(0,0,0,0.4);">The perfect place to find the property that's right for you. Start your search today.</p>
                
                <!-- Search Bar -->
                <div class="mt-8 w-full max-w-2xl">
                    <div class="bg-white rounded-full p-2 flex items-center shadow-lg">
                        <input type="text" placeholder="Enter an address, city, or ZIP code" class="flex-grow p-3 bg-transparent border-none focus:outline-none focus:ring-0 text-gray-800 placeholder-gray-500">
                        <a href="/properties" class="bg-indigo-600 text-white font-semibold px-8 py-3 rounded-full hover:bg-indigo-700 transition-colors">
                            Search
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Properties Section -->
        <section class="py-20">
            <div class="container mx-auto px-6">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-gray-800">Featured Properties</h2>
                    <p class="mt-2 text-gray-600">Explore our handpicked selection of premier properties.</p>
                </div>

                <!-- Properties Grid -->
                @if($featuredProperties->count() > 0)
                <div class="mt-12 grid gap-8 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($featuredProperties as $property)
                        <x-property-card :property="$property" />
                    @endforeach
                </div>
                @else
                <div class="mt-12 text-center">
                    <p class="text-gray-600">No featured properties available at this time.</p>
                </div>
                @endif

                <!-- View All Properties Button -->
                <div class="mt-12 text-center">
                    <a href="/properties" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition-colors">
                        View All Properties
                    </a>
                </div>
            </div>
        </section>

        <!-- Newsletter Signup Section -->
        <section class="py-16 bg-gray-100">
            <div class="container mx-auto px-6">
                <livewire:newsletter-signup />
            </div>
        </section>
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