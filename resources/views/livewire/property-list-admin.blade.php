<div class="bg-gray-100 antialiased">
    <div class="container mx-auto px-4 sm:px-8 py-8">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold leading-tight text-gray-800">Properties</h2>
            <a href="/admin/properties/create" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create New Property
            </a>
        </div>
        
        @if (session()->has('message'))
            <div class="mt-4 p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                {{ session('message') }}
            </div>
        @endif
        
        <!-- Table Container -->
        <div class="mt-6 bg-white shadow-md rounded-lg overflow-hidden">
            <!-- Responsive Wrapper -->
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <!-- Table Header -->
                    <thead>
                        <tr class="bg-gray-50 border-b-2 border-gray-200">
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Title
                            </th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Location
                            </th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Price
                            </th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Type
                            </th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <!-- Table Body -->
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($properties as $property)
                            <tr>
                                <td class="px-5 py-5 text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ $property->title }}</p>
                                </td>
                                <td class="px-5 py-5 text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ $property->location }}</p>
                                </td>
                                <td class="px-5 py-5 text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">${{ number_format($property->price) }}</p>
                                </td>
                                <td class="px-5 py-5 text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">{{ ucfirst($property->type) }}</p>
                                </td>
                                <td class="px-5 py-5 text-sm">
                                    @if($property->status === 'active')
                                        <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                            <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                            <span class="relative">Active</span>
                                        </span>
                                    @else
                                        <span class="relative inline-block px-3 py-1 font-semibold text-gray-700 leading-tight">
                                            <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                            <span class="relative">Inactive</span>
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-5 text-sm">
                                    <a href="/admin/property/{{ $property->id }}/edit" class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
                                    <button wire:click="delete({{ $property->id }})" wire:confirm="Are you sure you want to delete this property?" class="text-red-600 hover:text-red-900">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-5 text-sm text-center text-gray-500">
                                    No properties found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination -->
        <div class="mt-4">
            {{ $properties->links() }}
        </div>
    </div>
</div>
