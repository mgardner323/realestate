@if(auth()->user() && auth()->user()->isAdmin())
    <!-- Admin View - Professional Table Layout -->
    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <!-- Header -->
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Blog Management</h1>
                    <p class="mt-1 text-sm text-gray-600">Manage your blog posts and content</p>
                </div>
                <div class="flex gap-3">
                    <a href="/admin/blog/create" 
                       class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        New Post
                    </a>
                </div>
            </div>

            <!-- Flash Messages -->
            @if (session()->has('message'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('message') }}
                </div>
            @endif

            <!-- Professional Admin Table -->
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                @if($posts->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Title
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Slug
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created At
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($posts as $post)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $post->title }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-600 font-mono bg-gray-100 px-2 py-1 rounded">
                                            {{ $post->slug }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $post->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $post->is_published ? 'Published' : 'Draft' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $post->created_at->format('M j, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="/admin/blog/{{ $post->id }}/edit"
                                               class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1 rounded-md text-xs font-medium transition-colors">
                                                Edit
                                            </a>
                                            <button wire:click="delete({{ $post->id }})" 
                                                    wire:confirm="Are you sure you want to delete this post? This action cannot be undone."
                                                    class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1 rounded-md text-xs font-medium transition-colors">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-12">
                        <div class="text-gray-400 mb-4">
                            <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">No blog posts</h3>
                        <p class="text-gray-500 mb-4">Get started by creating a new post.</p>
                        <a href="/admin/blog/create"
                           class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            Create your first post
                        </a>
                    </div>
                @endif
            </div>

            <!-- Navigation -->
            <div class="mt-6 flex justify-between">
                <a href="/admin/dashboard" class="text-blue-600 hover:text-blue-800 transition-colors">
                    ← Back to Dashboard
                </a>
                <a href="/blog" class="text-blue-600 hover:text-blue-800 transition-colors">
                    View Public Blog →
                </a>
            </div>
        </div>
    </div>
@else
    <!-- Public View - Card Layout -->
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
                                class="flex items-center text-gray-600 hover:text-indigo-600 transition-colors focus:outline-none font-semibold text-indigo-600"
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
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Latest News & Blog</h1>
                <p class="text-xl text-indigo-100 max-w-2xl mx-auto">Stay updated with the latest real estate trends, market insights, and company news</p>
            </div>
        </section>

        <!-- Main Content -->
        <main class="py-8">
            <div class="container mx-auto px-6">
            
            @if($posts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($posts as $post)
                        <article class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition-shadow duration-300">
                            @if($post->featured_image_url)
                                <div class="h-48 overflow-hidden">
                                    <img class="w-full h-full object-cover" 
                                         src="{{ $post->featured_image_url }}" 
                                         alt="{{ $post->title }}">
                                </div>
                            @endif
                            
                            <div class="p-6">
                                <h2 class="text-xl font-bold text-gray-800 mb-3">
                                    <a href="/blog/{{ $post->slug }}" class="hover:text-indigo-600 transition-colors">
                                        {{ $post->title }}
                                    </a>
                                </h2>
                                
                                <p class="text-gray-600 text-sm mb-4">
                                    {{ Str::limit(strip_tags($post->body), 150) }}
                                </p>
                                
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-500 text-xs">
                                        {{ $post->created_at->format('M j, Y') }}
                                    </span>
                                    <a href="/blog/{{ $post->slug }}" 
                                       class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                        Read More →
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="bg-white rounded-xl p-8 shadow-sm">
                        <svg class="mx-auto h-16 w-16 text-indigo-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"/>
                        </svg>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">No Blog Posts Yet</h2>
                        <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                            We're working on creating amazing content for you. Check back soon for the latest real estate insights and news!
                        </p>
                    </div>
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
@endif