<div class="bg-gray-100 antialiased">
    <!-- Main Container -->
    <div class="container mx-auto px-4 py-12">

        <!-- Form Card -->
        <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg p-8">
            
            <!-- Form Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Create Property</h1>
                <p class="text-sm text-gray-500 mt-1">Fill in the information below to add a new property.</p>
            </div>

            @if (session()->has('message'))
                <div class="mb-6 p-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                    {{ session('message') }}
                </div>
            @endif

            <!-- Form -->
            <form wire:submit.prevent="save" class="space-y-6">

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Property Title</label>
                    <input 
                        type="text" 
                        wire:model="title"
                        id="title" 
                        placeholder="e.g., Modern Downtown Apartment"
                        class="mt-1 block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    >
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea 
                        wire:model="description"
                        id="description" 
                        rows="4" 
                        placeholder="A beautiful and spacious apartment with a stunning city view..."
                        class="mt-1 block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    ></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Price and Location (in a grid) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input 
                                type="number" 
                                wire:model="price"
                                id="price" 
                                class="block w-full pl-7 pr-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                placeholder="0.00"
                            >
                        </div>
                        @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <!-- Heroicon: map-pin -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                wire:model="location"
                                id="location" 
                                class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                placeholder="e.g., 123 Main St, Anytown, USA"
                            >
                        </div>
                        @error('location') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Type and Featured (in a grid) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                    <!-- Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                        <select 
                            wire:model="type"
                            id="type" 
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                        >
                            <option value="sale">For Sale</option>
                            <option value="rent">For Rent</option>
                        </select>
                        @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Featured -->
                    <div class="pt-6">
                        <div class="relative flex items-start">
                            <div class="flex items-center h-5">
                                <input 
                                    wire:model="featured"
                                    id="featured" 
                                    type="checkbox" 
                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                                >
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="featured" class="font-medium text-gray-700">Featured Property</label>
                                <p class="text-gray-500">Display this property on the homepage.</p>
                            </div>
                        </div>
                        @error('featured') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="pt-6 border-t border-gray-200">
                    <div class="flex justify-end space-x-4">
                        <a href="/admin/properties" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </a>
                        <button 
                            type="submit" 
                            class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Save Property
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
