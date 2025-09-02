<div class="bg-gray-50 font-sans">

    <!-- Header / Navigation -->
    <header class="bg-white shadow-sm">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="text-2xl font-bold text-gray-800">
                    <a href="/">RealtyCo</a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#" class="text-gray-600 hover:text-indigo-600 transition-colors">Buy</a>
                    <a href="#" class="text-gray-600 hover:text-indigo-600 transition-colors">Sell</a>
                    <a href="#" class="text-gray-600 hover:text-indigo-600 transition-colors">Rent</a>
                    <a href="/properties" class="text-gray-600 hover:text-indigo-600 transition-colors">Properties</a>
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
        <section class="relative h-[70vh] bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1568605114967-8130f3a36994?q=80&w=2070&auto=format&fit=crop');">
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