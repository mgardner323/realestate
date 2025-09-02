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
    <div class="bg-gray-100 min-h-screen">
        <div class="container mx-auto p-4 sm:p-6 lg:p-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-8 text-center">Blog</h1>
            
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
                    <p class="text-gray-600 text-lg">No blog posts available at this time.</p>
                </div>
            @endif

            <!-- Back to Home Button -->
            <div class="mt-12 text-center">
                <a href="/" class="text-indigo-600 hover:text-indigo-800 transition-colors">
                    ← Back to Home
                </a>
            </div>
        </div>
    </div>
@endif