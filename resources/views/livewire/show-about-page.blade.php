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
                    <a href="/about" class="text-gray-600 hover:text-indigo-600 transition-colors font-semibold text-indigo-600">About</a>
                    
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
    <section class="bg-gradient-to-r from-indigo-600 to-blue-600 py-16">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">About Us</h1>
            <p class="text-xl text-indigo-100 max-w-2xl mx-auto">Get to know the team that's dedicated to helping you find your perfect home</p>
        </div>
    </section>

    <!-- Main Content -->
    <main class="py-16">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <!-- Photo Section -->
                @if($aboutPhoto)
                <div class="text-center mb-12">
                    <div class="relative inline-block">
                        <img 
                            src="{{ asset($aboutPhoto) }}" 
                            alt="About Our Real Estate Agency" 
                            class="rounded-lg shadow-2xl max-w-full h-auto mx-auto object-cover max-h-96"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-lg"></div>
                    </div>
                </div>
                @endif

                <!-- Content Section -->
                <div class="bg-gray-50 rounded-2xl p-8 md:p-12 shadow-lg">
                    @if($aboutText)
                        <div class="prose prose-lg prose-indigo max-w-none text-gray-700 leading-relaxed">
                            {!! $aboutText !!}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="bg-white rounded-xl p-8 shadow-sm">
                                <svg class="mx-auto h-16 w-16 text-indigo-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-6m-8 0H3m2 0h6M9 7h6m-6 4h6m-6 4h6m-6 4h6"/>
                                </svg>
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Welcome to Our Real Estate Agency</h2>
                                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                                    We are dedicated to helping you find your dream home. Our experienced team of real estate professionals is committed to providing exceptional service and expertise to guide you through every step of your property journey.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Call to Action Section -->
                <div class="mt-16 text-center">
                    <div class="bg-indigo-600 rounded-2xl p-8 text-white">
                        <h2 class="text-3xl font-bold mb-4">Ready to Find Your Dream Home?</h2>
                        <p class="text-xl text-indigo-100 mb-8 max-w-2xl mx-auto">
                            Let our experienced team help you navigate the real estate market and find the perfect property for your needs.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a 
                                href="/properties" 
                                class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-full text-indigo-600 bg-white hover:bg-gray-50 transition-colors duration-200 shadow-lg hover:shadow-xl"
                            >
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2V7zm16 0v1H5V7a1 1 0 011-1h12a1 1 0 011 1zM5 11h14" />
                                </svg>
                                Browse Properties
                            </a>
                            <a 
                                href="#" 
                                class="inline-flex items-center justify-center px-8 py-3 border-2 border-white text-base font-medium rounded-full text-white bg-transparent hover:bg-white hover:text-indigo-600 transition-colors duration-200"
                            >
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                Contact Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>
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