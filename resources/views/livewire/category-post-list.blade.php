<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $category->name }}</h1>
        @if($category->description)
            <p class="text-xl text-gray-600">{{ $category->description }}</p>
        @endif
    </div>

    @if($posts->count() > 0)
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            @foreach($posts as $post)
                <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    @if($post->featured_image)
                        <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" 
                             class="w-full h-48 object-cover">
                    @endif
                    
                    <div class="p-6">
                        <div class="mb-2">
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                {{ $category->name }}
                            </span>
                        </div>
                        
                        <h2 class="text-xl font-semibold text-gray-900 mb-3">
                            <a href="/blog/{{ $post->slug }}" class="hover:text-blue-600 transition-colors">
                                {{ $post->title }}
                            </a>
                        </h2>
                        
                        <p class="text-gray-600 mb-4 line-clamp-3">
                            {{ Str::limit(strip_tags($post->content), 120) }}
                        </p>
                        
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <span>{{ $post->created_at->format('M j, Y') }}</span>
                            <a href="/blog/{{ $post->slug }}" 
                               class="text-blue-600 hover:text-blue-800 font-medium">
                                Read More →
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <div class="text-6xl text-gray-300 mb-4">📰</div>
            <h2 class="text-2xl font-semibold text-gray-600 mb-2">No posts found</h2>
            <p class="text-gray-500">There are no posts in the "{{ $category->name }}" category yet.</p>
        </div>
    @endif
</div>
