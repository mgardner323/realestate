<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">About Us Page Management</h1>
                <p class="mt-1 text-sm text-gray-600">Manage your agency's About Us page content and photo</p>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('message') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 bg-red-50 border border-red-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Photo Management Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Agency Photo</h2>
                    <p class="mt-1 text-sm text-gray-600">Upload a professional photo representing your agency</p>
                </div>
                
                <div class="p-6">
                    <!-- Current Photo Preview -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Photo</label>
                        <div class="relative bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                            @if($currentPhotoPath)
                                <img src="{{ asset($currentPhotoPath) }}" alt="Current About Photo" class="mx-auto max-h-48 rounded-lg shadow-md">
                            @else
                                <div class="text-gray-400">
                                    <svg class="mx-auto h-12 w-12" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <p class="mt-2 text-sm">No photo uploaded yet</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Photo Upload Form -->
                    <form wire:submit.prevent="savePhoto" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload New Photo</label>
                            <div class="relative">
                                <input 
                                    type="file" 
                                    wire:model="aboutPhoto" 
                                    id="photo-upload" 
                                    accept="image/*" 
                                    class="hidden"
                                    onchange="previewImage(this)"
                                >
                                <label 
                                    for="photo-upload" 
                                    class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    Choose File
                                </label>
                            </div>
                            @error('aboutPhoto') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Preview of new photo -->
                        @if($aboutPhoto)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Preview</label>
                                <div class="relative bg-gray-50 border border-gray-300 rounded-lg p-4">
                                    <img src="{{ $aboutPhoto->temporaryUrl() }}" alt="Preview" class="mx-auto max-h-48 rounded-lg shadow-md">
                                </div>
                            </div>
                        @endif

                        <button 
                            type="submit" 
                            {{ !$aboutPhoto ? 'disabled' : '' }}
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white {{ $aboutPhoto ? 'bg-indigo-600 hover:bg-indigo-700' : 'bg-gray-400 cursor-not-allowed' }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Save Photo
                        </button>
                    </form>
                </div>
            </div>

            <!-- Text Content Management Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">About Us Content</h2>
                    <p class="mt-1 text-sm text-gray-600">Create compelling content about your real estate agency</p>
                </div>
                
                <div class="p-6">
                    <form wire:submit.prevent="saveText" class="space-y-4">
                        <!-- Text Editor -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">About Us Text</label>
                            <div wire:ignore>
                                <trix-editor 
                                    input="about-text-input"
                                    class="trix-content border border-gray-300 rounded-md min-h-[200px] focus:ring-indigo-500 focus:border-indigo-500"
                                    x-data
                                    x-on:trix-change="$wire.set('aboutText', $event.target.value)"
                                ></trix-editor>
                                <input id="about-text-input" type="hidden" wire:model.defer="aboutText">
                            </div>
                            @error('aboutText') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- AI Enhancement Button -->
                        <div class="border-t border-gray-200 pt-4">
                            <button 
                                type="button" 
                                wire:click="enhanceText"
                                wire:loading.attr="disabled"
                                wire:target="enhanceText"
                                class="w-full mb-4 inline-flex items-center justify-center px-4 py-3 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 disabled:opacity-50 disabled:cursor-not-allowed shadow-lg hover:shadow-xl transition-all duration-200"
                            >
                                <span wire:loading.remove wire:target="enhanceText" class="flex items-center">
                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    Enhance Text with AI
                                </span>
                                <span wire:loading wire:target="enhanceText" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Enhancing...
                                </span>
                            </button>
                        </div>

                        <!-- Save Text Button -->
                        <button 
                            type="submit" 
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                        >
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                            Save Content
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Preview Section -->
        @if($currentPhotoPath || $aboutText)
        <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Live Preview</h2>
                <p class="mt-1 text-sm text-gray-600">See how your About Us content will appear on the website</p>
            </div>
            
            <div class="p-6 bg-gray-50">
                <div class="max-w-3xl mx-auto">
                    @if($currentPhotoPath)
                        <div class="text-center mb-8">
                            <img src="{{ asset($currentPhotoPath) }}" alt="About Us" class="mx-auto rounded-lg shadow-lg max-h-64 object-cover">
                        </div>
                    @endif
                    
                    @if($aboutText)
                        <div class="prose prose-lg max-w-none text-gray-700">
                            {!! $aboutText !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function previewImage(input) {
        // This function can be used for additional preview functionality if needed
    }
</script>
@endpush