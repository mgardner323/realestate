<div class="bg-gray-100 min-h-screen">
    <div class="container mx-auto p-4 sm:p-6 lg:p-8 max-w-4xl">
        <div class="bg-white rounded-lg shadow-xl p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">Edit Blog Post</h1>
            
            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('message') }}
                </div>
            @endif

            <form wire:submit="update" class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Post Title</label>
                    <input type="text" 
                           id="title" 
                           wire:model="title" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                           placeholder="Enter blog post title...">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select id="category" 
                            wire:model="category_id"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Select a category (optional)</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="is_published" class="flex items-center space-x-3">
                        <input type="checkbox" 
                               id="is_published" 
                               wire:model="is_published"
                               class="form-checkbox h-4 w-4 text-indigo-600 rounded focus:ring-indigo-500 border-gray-300">
                        <span class="text-sm font-medium text-gray-700">Published</span>
                    </label>
                    <p class="text-xs text-gray-500 mt-1">Uncheck to save as draft</p>
                </div>

                <!-- Featured Image Section -->
                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-800">Featured Image</h3>
                        <button type="button" 
                                wire:click="generateFeaturedImage"
                                class="bg-gradient-to-r from-orange-600 to-red-600 text-white px-4 py-2 rounded-lg hover:from-orange-700 hover:to-red-700 transition-all duration-200 flex items-center gap-2 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                            </svg>
                            Generate Image with AI
                        </button>
                    </div>
                    
                    @if($post->featured_image_url)
                        <div class="mb-4">
                            <img src="{{ asset($post->featured_image_url) }}" 
                                 alt="Featured Image" 
                                 class="w-full max-w-md h-48 object-cover rounded-lg border border-gray-300">
                            <p class="text-xs text-gray-500 mt-2">Current featured image</p>
                        </div>
                    @else
                        <div class="mb-4 p-8 border-2 border-dashed border-gray-300 rounded-lg text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-gray-500 text-sm">No featured image selected</p>
                            <p class="text-gray-400 text-xs mt-1">Click "Generate Image with AI" to create one automatically</p>
                        </div>
                    @endif
                </div>

                <div class="flex gap-4">
                    <button type="button" 
                            wire:click="generatePostContent"
                            class="bg-gradient-to-r from-purple-600 to-blue-600 text-white px-6 py-2 rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-200 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                        </svg>
                        Regenerate with AI
                    </button>
                </div>

                <div>
                    <label for="body" class="block text-sm font-medium text-gray-700 mb-2">Post Content</label>
                    <x-trix-editor wire:model="body" class="mt-1"></x-trix-editor>
                    @error('body') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- SEO Settings Section -->
                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-800">SEO Settings</h3>
                        <button type="button" 
                                wire:click="generateSeoTags"
                                class="bg-gradient-to-r from-green-600 to-teal-600 text-white px-4 py-2 rounded-lg hover:from-green-700 hover:to-teal-700 transition-all duration-200 flex items-center gap-2 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                            </svg>
                            Generate SEO with AI
                        </button>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-2">Meta Title</label>
                            <input type="text" 
                                   id="meta_title" 
                                   wire:model="meta_title" 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="SEO optimized title (around 60 characters)"
                                   maxlength="255">
                            <p class="text-xs text-gray-500 mt-1">Character count: <span x-text="$wire.meta_title.length">0</span>/60 recommended</p>
                            @error('meta_title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
                            <textarea id="meta_description" 
                                      wire:model="meta_description" 
                                      rows="3"
                                      class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                      placeholder="SEO optimized description (around 155 characters)"
                                      maxlength="500"></textarea>
                            <p class="text-xs text-gray-500 mt-1">Character count: <span x-text="$wire.meta_description.length">0</span>/155 recommended</p>
                            @error('meta_description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex gap-4">
                    <button type="submit" 
                            class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition-colors">
                        Update Post
                    </button>
                    <a href="/admin/blog" 
                       class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                        Cancel
                    </a>
                </div>
            </form>

            <!-- Post Info -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="text-sm text-gray-600">
                    <p><strong>Post ID:</strong> {{ $post->id }}</p>
                    <p><strong>Slug:</strong> {{ $post->slug }}</p>
                    <p><strong>Created:</strong> {{ $post->created_at->format('F j, Y g:i A') }}</p>
                    <p><strong>Last Updated:</strong> {{ $post->updated_at->format('F j, Y g:i A') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
