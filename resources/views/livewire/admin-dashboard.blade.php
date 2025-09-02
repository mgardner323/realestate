<div class="flex h-screen bg-gray-200">
    <!-- Sidebar -->
    <aside class="bg-gray-800 text-white w-64 space-y-6 py-7 px-2">
        <!-- Logo -->
        <div class="text-white flex items-center space-x-2 px-4">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
            </svg>
            <span class="text-2xl font-extrabold">RealtyCo Admin</span>
        </div>

        <!-- Navigation -->
        <nav>
            <a href="/admin/dashboard" class="block py-2.5 px-4 rounded transition duration-200 bg-gray-700">
                Dashboard
            </a>
            <a href="/properties" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                Properties
            </a>
            <a href="/admin/subscribers" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                Subscribers
            </a>
            <a href="/blog" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                Blog Posts
            </a>
            <a href="/admin/blog/create" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                Create Post
            </a>
            <a href="/admin/communities" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                Communities
            </a>
            <a href="/admin/settings" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                Site Settings
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="flex justify-between items-center p-4 bg-white border-b-2 border-gray-200">
            <div class="flex items-center space-x-4">
                <h1 class="text-xl font-semibold">Dashboard</h1>
            </div>
            <div class="flex items-center space-x-4">
                <span class="font-semibold">{{ auth()->user()->name }}</span>
                <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
            <div class="container mx-auto">
                <!-- Welcome Message -->
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Welcome back, {{ auth()->user()->name }}!</h2>
                    <p class="text-gray-600">Here's an overview of your real estate platform.</p>
                </div>

                <!-- Stat Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Total Properties Card -->
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <div class="flex items-center">
                            <div class="bg-blue-500 p-3 rounded-full text-white">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-600 text-sm">Total Properties</p>
                                <p class="text-2xl font-bold">{{ number_format($totalProperties) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Users Card -->
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <div class="flex items-center">
                            <div class="bg-green-500 p-3 rounded-full text-white">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-600 text-sm">Total Users</p>
                                <p class="text-2xl font-bold">{{ number_format($totalUsers) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Newsletter Subscribers Card -->
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <div class="flex items-center">
                            <div class="bg-yellow-500 p-3 rounded-full text-white">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-600 text-sm">Newsletter Subscribers</p>
                                <p class="text-2xl font-bold">{{ number_format($totalSubscribers) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Blog Posts Card -->
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <div class="flex items-center">
                            <div class="bg-red-500 p-3 rounded-full text-white">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-600 text-sm">Blog Posts</p>
                                <p class="text-2xl font-bold">{{ number_format($totalPosts) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Stat Cards -->

                <!-- Quick Actions -->
                <div class="mt-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="/admin/blog/create" class="bg-indigo-600 text-white p-4 rounded-lg hover:bg-indigo-700 transition-colors text-center">
                            <div class="text-lg font-semibold">Create Blog Post</div>
                            <div class="text-sm opacity-90">Write a new article</div>
                        </a>
                        <a href="/admin/subscribers" class="bg-green-600 text-white p-4 rounded-lg hover:bg-green-700 transition-colors text-center">
                            <div class="text-lg font-semibold">Manage Subscribers</div>
                            <div class="text-sm opacity-90">View newsletter list</div>
                        </a>
                        <a href="/properties" class="bg-blue-600 text-white p-4 rounded-lg hover:bg-blue-700 transition-colors text-center">
                            <div class="text-lg font-semibold">View Properties</div>
                            <div class="text-sm opacity-90">Browse all listings</div>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="w-full bg-red-600 text-white p-4 rounded-lg hover:bg-red-700 transition-colors text-center">
                                <div class="text-lg font-semibold">Logout</div>
                                <div class="text-sm opacity-90">Sign out of admin</div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
