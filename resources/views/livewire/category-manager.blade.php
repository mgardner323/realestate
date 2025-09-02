<div class="bg-gray-100 text-gray-800">
    <div class="container mx-auto p-4 md:p-8">

        <header class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Manage Blog Categories</h1>
            <p class="text-sm text-gray-600 mt-1">Add, edit, or delete categories for your blog posts.</p>
        </header>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="mb-6 p-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 p-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <!-- Main content grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Left Column: Create/Edit Category Form -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">
                        @if($editingId)
                            Edit Category
                        @else
                            Create New Category
                        @endif
                    </h2>
                    <form wire:submit.prevent="save">
                        <div class="mb-4">
                            <label for="category-name" class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                            <input type="text" 
                                   wire:model="name"
                                   id="category-name" 
                                   placeholder="e.g., Technology"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex space-x-3">
                            <button type="submit"
                                    class="flex-1 bg-indigo-600 text-white font-semibold py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-300">
                                @if($editingId)
                                    Update Category
                                @else
                                    Add Category
                                @endif
                            </button>
                            @if($editingId)
                                <button type="button"
                                        wire:click="cancelEdit"
                                        class="bg-gray-600 text-white font-semibold py-2 px-4 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-300">
                                    Cancel
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column: Categories Table -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md">
                   <div class="p-6 border-b border-gray-200">
                     <h2 class="text-xl font-semibold">Existing Categories</h2>
                   </div>
                    <!-- Responsive table wrapper -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Category Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Posts Count
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $category->name }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $category->posts_count }} {{ Str::plural('post', $category->posts_count) }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <button wire:click="edit({{ $category->id }})" 
                                                    class="font-medium text-indigo-600 hover:text-indigo-800 mr-4">
                                                Edit
                                            </button>
                                            <button wire:click="delete({{ $category->id }})" 
                                                    wire:confirm="Are you sure you want to delete this category?"
                                                    class="font-medium text-red-600 hover:text-red-800">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                            No categories found. Create your first category using the form on the left.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
