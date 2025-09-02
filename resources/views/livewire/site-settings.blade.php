<div class="bg-gray-100 min-h-screen py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Site Settings</h1>
            <p class="mt-1 text-sm text-gray-600">Manage your site's branding and homepage content.</p>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                {{ session('error') }}
            </div>
        @endif

        <!-- Container for settings sections -->
        <div class="space-y-8">

            <!-- Section 1: Logo Management -->
            <div class="bg-white shadow-sm rounded-xl overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Logo Management</h2>
                    <p class="mt-1 text-sm text-gray-500">Update your company's logo.</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        <!-- Left Column: Instructions -->
                        <div class="md:col-span-1">
                            <h3 class="text-base font-medium text-gray-900">Site Logo</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Upload your site logo. Recommended format: SVG, PNG (with transparent background). Max size: 1MB.
                            </p>
                        </div>
                        
                        <!-- Right Column: Form Elements -->
                        <div class="md:col-span-2 space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Current Logo</label>
                                <div class="mt-2 flex items-center justify-center w-48 h-24 bg-gray-50 border-2 border-dashed border-gray-300 rounded-md p-2">
                                    @if($currentLogoPath)
                                        <img src="{{ asset($currentLogoPath) }}" alt="Current Site Logo" class="max-h-full max-w-full object-contain">
                                    @else
                                        <div class="text-center text-gray-400">
                                            <svg class="mx-auto h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <p class="mt-1 text-xs">No logo uploaded</p>
                                        </div>
                                    @endif
                                </div>
                                @if($currentLogoPath)
                                    <button 
                                        wire:click="removeLogo" 
                                        wire:confirm="Are you sure you want to remove the current logo?"
                                        class="mt-2 text-sm text-red-600 hover:text-red-500">
                                        Remove current logo
                                    </button>
                                @endif
                            </div>

                            <div>
                                <label for="logo-upload" class="block text-sm font-medium text-gray-700">Upload New Logo</label>
                                <div class="mt-2 flex items-center space-x-4">
                                    <label for="logo-upload" class="cursor-pointer bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <span>Choose file</span>
                                        <input id="logo-upload" wire:model="logo" type="file" class="sr-only" accept="image/*">
                                    </label>
                                    <span class="text-sm text-gray-500">
                                        @if($logo)
                                            {{ $logo->getClientOriginalName() }}
                                        @else
                                            No file chosen
                                        @endif
                                    </span>
                                </div>
                                @error('logo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                
                                @if($logo)
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-600">Preview:</p>
                                        <img src="{{ $logo->temporaryUrl() }}" alt="Logo Preview" class="mt-1 max-w-32 max-h-16 object-contain border border-gray-200 rounded">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex justify-end">
                    <button 
                        wire:click="saveLogo" 
                        wire:loading.attr="disabled"
                        wire:target="saveLogo"
                        class="bg-indigo-600 text-white font-semibold px-4 py-2 rounded-md text-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150 disabled:opacity-50">
                        <span wire:loading.remove wire:target="saveLogo">Save Logo</span>
                        <span wire:loading wire:target="saveLogo">Saving...</span>
                    </button>
                </div>
            </div>
            <!-- End Section 1 -->

            <!-- Section 2: Homepage Hero Management -->
            <div class="bg-white shadow-sm rounded-xl overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Homepage Hero Management</h2>
                    <p class="mt-1 text-sm text-gray-500">Set the primary image or video for the homepage hero section.</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        <!-- Left Column: Instructions -->
                        <div class="md:col-span-1">
                            <h3 class="text-base font-medium text-gray-900">Hero Media</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Use a high-resolution image (1920x1080) or a short video (MP4, under 10MB) for the best results.
                            </p>
                        </div>

                        <!-- Right Column: Form Elements -->
                        <div class="md:col-span-2 space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Current Hero Media</label>
                                <div class="mt-2 flex items-center justify-center w-full aspect-video bg-gray-50 border-2 border-dashed border-gray-300 rounded-md overflow-hidden">
                                    @if($currentHeroPath)
                                        @if(str_ends_with($currentHeroPath, '.mp4'))
                                            <video class="object-cover w-full h-full" controls>
                                                <source src="{{ asset($currentHeroPath) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @else
                                            <img src="{{ asset($currentHeroPath) }}" alt="Current Hero Media" class="object-cover w-full h-full">
                                        @endif
                                    @else
                                        <div class="text-center text-gray-400">
                                            <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <p class="mt-2 text-sm">No hero media uploaded</p>
                                            <p class="text-xs text-gray-300">Using default background</p>
                                        </div>
                                    @endif
                                </div>
                                @if($currentHeroPath)
                                    <button 
                                        wire:click="removeHero" 
                                        wire:confirm="Are you sure you want to remove the current hero media?"
                                        class="mt-2 text-sm text-red-600 hover:text-red-500">
                                        Remove current hero media
                                    </button>
                                @endif
                            </div>

                            <div>
                                <label for="hero-upload" class="block text-sm font-medium text-gray-700">Upload New Image/Video</label>
                                <div class="mt-2 flex items-center space-x-4">
                                    <label for="hero-upload" class="cursor-pointer bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <span>Choose file</span>
                                        <input id="hero-upload" wire:model="heroMedia" type="file" class="sr-only" accept="image/*,video/mp4">
                                    </label>
                                    <span class="text-sm text-gray-500">
                                        @if($heroMedia)
                                            {{ $heroMedia->getClientOriginalName() }}
                                        @else
                                            JPG, PNG, MP4 up to 10MB
                                        @endif
                                    </span>
                                </div>
                                @error('heroMedia') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                
                                @if($heroMedia)
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-600">Preview:</p>
                                        @if(str_ends_with($heroMedia->getClientOriginalName(), '.mp4'))
                                            <video class="mt-1 max-w-xs aspect-video object-cover border border-gray-200 rounded" controls>
                                                <source src="{{ $heroMedia->temporaryUrl() }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @else
                                            <img src="{{ $heroMedia->temporaryUrl() }}" alt="Hero Preview" class="mt-1 max-w-xs aspect-video object-cover border border-gray-200 rounded">
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex justify-end">
                    <button 
                        wire:click="saveHero" 
                        wire:loading.attr="disabled"
                        wire:target="saveHero"
                        class="bg-indigo-600 text-white font-semibold px-4 py-2 rounded-md text-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150 disabled:opacity-50">
                        <span wire:loading.remove wire:target="saveHero">Save Hero</span>
                        <span wire:loading wire:target="saveHero">Saving...</span>
                    </button>
                </div>
            </div>
            <!-- End Section 2 -->

        </div>

    </div>
</div>
