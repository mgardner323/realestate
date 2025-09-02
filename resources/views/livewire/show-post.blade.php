<div class="bg-gray-100 min-h-screen">
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
        <!-- Back Navigation -->
        <div class="mb-8">
            <a href="/blog" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-2">
                    <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                </svg>
                Back to Blog
            </a>
        </div>

        <article class="bg-white rounded-lg shadow-xl overflow-hidden max-w-4xl mx-auto">
            @if($post->featured_image_url)
                <div class="h-64 md:h-96 overflow-hidden">
                    <img class="w-full h-full object-cover" 
                         src="{{ $post->featured_image_url }}" 
                         alt="{{ $post->title }}">
                </div>
            @endif

            <div class="p-6 md:p-8">
                <!-- Post Header -->
                <header class="mb-8">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                        {{ $post->title }}
                    </h1>
                    <div class="text-gray-600">
                        <time datetime="{{ $post->created_at->toISOString() }}">
                            Published on {{ $post->created_at->format('F j, Y') }}
                        </time>
                    </div>
                </header>

                <!-- Post Content -->
                <div class="prose prose-lg max-w-none">
                    {!! nl2br(e($post->body)) !!}
                </div>
            </div>
        </article>

        <!-- Back to Blog Button -->
        <div class="mt-8 text-center">
            <a href="/blog" class="text-indigo-600 hover:text-indigo-800 transition-colors">
                ← Back to All Posts
            </a>
        </div>
    </div>
</div>