<div class="bg-gray-50 min-h-screen">
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Back Navigation -->
        <div class="mb-8">
            <a href="/properties" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-2">
                    <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                </svg>
                Back to Properties
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
            
            <!-- Left Column: Image Gallery -->
            <div class="flex flex-col gap-4">
                <!-- Main Image -->
                <div>
                    @if($property->image)
                        <img src="{{ $property->image }}" 
                             alt="{{ $property->title }}" 
                             class="w-full h-auto object-cover rounded-lg shadow-lg aspect-[4/3]">
                    @else
                        <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?q=80&w=2000&auto=format&fit=crop" 
                             alt="{{ $property->title }}" 
                             class="w-full h-auto object-cover rounded-lg shadow-lg aspect-[4/3]">
                    @endif
                </div>
                
                <!-- Thumbnail Images -->
                <div class="grid grid-cols-4 gap-2 sm:gap-4">
                    @if($property->image)
                        <img src="{{ $property->image }}" 
                             alt="Thumbnail 1" 
                             class="w-full h-auto object-cover rounded-md cursor-pointer border-2 border-indigo-500 shadow-md">
                    @else
                        <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?q=80&w=200&auto=format&fit=crop" 
                             alt="Thumbnail 1" 
                             class="w-full h-auto object-cover rounded-md cursor-pointer border-2 border-indigo-500 shadow-md">
                    @endif
                    <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=200&auto=format&fit=crop" 
                         alt="Thumbnail 2" 
                         class="w-full h-auto object-cover rounded-md cursor-pointer opacity-70 hover:opacity-100 transition-opacity">
                    <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?q=80&w=200&auto=format&fit=crop" 
                         alt="Thumbnail 3" 
                         class="w-full h-auto object-cover rounded-md cursor-pointer opacity-70 hover:opacity-100 transition-opacity">
                    <img src="https://images.unsplash.com/photo-1605276374104-dee2a0ed3cd6?q=80&w=200&auto=format&fit=crop" 
                         alt="Thumbnail 4" 
                         class="w-full h-auto object-cover rounded-md cursor-pointer opacity-70 hover:opacity-100 transition-opacity">
                </div>
            </div>

            <!-- Right Column: Property Details -->
            <div class="space-y-6">
                <!-- Title, Price, Location -->
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800">
                        {{ $property->title }}
                    </h1>
                    <div class="mt-2 flex items-baseline gap-4">
                         <span class="text-3xl font-bold text-indigo-600">${{ number_format($property->price) }}</span>
                         @if($property->location)
                         <span class="text-md text-gray-500 flex items-center gap-1">
                            <!-- Heroicon: map-pin -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.1.4-.24.635-.431l.002-.002a7.18 7.18 0 002.433-2.31.75.75 0 00-1.06-1.06 5.682 5.682 0 01-1.74-1.657l-.002-.004A5.717 5.717 0 0010 12c-1.392 0-2.675.52-3.626 1.378l-.004.004a5.68 5.68 0 01-1.74 1.657.75.75 0 101.06 1.06 7.18 7.18 0 002.434 2.309l.002.002c.234.191.449.331.635.431.097.05.192.098.28.14l.018.008.006.003zM10 8a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                            {{ $property->location }}
                         </span>
                         @endif
                    </div>
                    @if($property->type)
                        <div class="mt-2">
                            <span class="inline-block bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-medium capitalize">
                                {{ $property->type }}
                            </span>
                        </div>
                    @endif
                </div>

                <hr class="border-gray-200">

                <!-- Description -->
                @if($property->description)
                <div>
                    <h2 class="text-xl font-semibold text-gray-700 mb-2">Description</h2>
                    <p class="text-gray-600 leading-relaxed">
                        {{ $property->description }}
                    </p>
                </div>
                @endif

                <!-- Key Features -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Key Features</h2>
                    <ul class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                        @if($property->bedrooms)
                        <li class="flex items-center gap-3">
                            <!-- Heroicon: check-circle -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-green-500">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-700">{{ $property->bedrooms }} Bedrooms</span>
                        </li>
                        @endif
                        @if($property->bathrooms)
                        <li class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-green-500">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-700">{{ $property->bathrooms }} Bathrooms</span>
                        </li>
                        @endif
                        @if($property->area)
                        <li class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-green-500">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-700">{{ number_format($property->area) }} sqft</span>
                        </li>
                        @endif
                        @if($property->is_featured)
                        <li class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-green-500">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-700">Featured Property</span>
                        </li>
                        @endif
                        <li class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-green-500">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-700">Professional Photography</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-green-500">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-700">Modern Design</span>
                        </li>
                    </ul>
                </div>

                <!-- Contact Section -->
                <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Interested in This Property?</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <button class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition-colors duration-200">
                            Contact Agent
                        </button>
                        <button class="border border-indigo-600 text-indigo-600 px-6 py-3 rounded-lg font-semibold hover:bg-indigo-50 transition-colors duration-200">
                            Schedule Tour
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>