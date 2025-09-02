<!-- Step 2: Branding & SEO -->
<div class="space-y-6">
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Branding & SEO</h2>
        <p class="text-gray-600">Customize your platform's appearance and search engine optimization</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="brandPrimaryColor" class="block text-sm font-medium text-gray-700 mb-2">
                Primary Brand Color <span class="text-red-500">*</span>
            </label>
            <div class="flex space-x-3">
                <input type="color" name="brandPrimaryColor" id="brandPrimaryColor"
                    value="{{ old('brandPrimaryColor', $installationData['brandPrimaryColor'] ?? '#3B82F6') }}"
                    class="w-16 h-12 border border-gray-300 rounded-lg cursor-pointer">
                <input type="text" name="brandPrimaryColor" 
                    value="{{ old('brandPrimaryColor', $installationData['brandPrimaryColor'] ?? '#3B82F6') }}"
                    class="flex-1 px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors {{ $errors->has('brandPrimaryColor') ? 'border-red-300' : '' }}"
                    placeholder="#3B82F6" required>
            </div>
            @error('brandPrimaryColor') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
            @enderror
        </div>

        <div>
            <label for="brandSecondaryColor" class="block text-sm font-medium text-gray-700 mb-2">
                Secondary Brand Color <span class="text-red-500">*</span>
            </label>
            <div class="flex space-x-3">
                <input type="color" name="brandSecondaryColor" id="brandSecondaryColor"
                    value="{{ old('brandSecondaryColor', $installationData['brandSecondaryColor'] ?? '#1E40AF') }}"
                    class="w-16 h-12 border border-gray-300 rounded-lg cursor-pointer">
                <input type="text" name="brandSecondaryColor"
                    value="{{ old('brandSecondaryColor', $installationData['brandSecondaryColor'] ?? '#1E40AF') }}"
                    class="flex-1 px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors {{ $errors->has('brandSecondaryColor') ? 'border-red-300' : '' }}"
                    placeholder="#1E40AF" required>
            </div>
            @error('brandSecondaryColor') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
            @enderror
        </div>

        <div class="md:col-span-2">
            <label for="seoTitle" class="block text-sm font-medium text-gray-700 mb-2">
                SEO Title <span class="text-red-500">*</span>
            </label>
            <input type="text" name="seoTitle" id="seoTitle"
                value="{{ old('seoTitle', $installationData['seoTitle'] ?? '') }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors {{ $errors->has('seoTitle') ? 'border-red-300' : '' }}"
                placeholder="Premier Real Estate Platform" required>
            <p class="text-sm text-gray-500 mt-1">This will appear in browser tabs and search results</p>
            @error('seoTitle') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
            @enderror
        </div>

        <div class="md:col-span-2">
            <label for="seoDescription" class="block text-sm font-medium text-gray-700 mb-2">
                SEO Description <span class="text-red-500">*</span>
            </label>
            <textarea name="seoDescription" id="seoDescription" rows="3"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors {{ $errors->has('seoDescription') ? 'border-red-300' : '' }}"
                placeholder="Find your dream property with our comprehensive real estate platform featuring advanced search, analytics, and modern design." required>{{ old('seoDescription', $installationData['seoDescription'] ?? '') }}</textarea>
            <p class="text-sm text-gray-500 mt-1">This description will appear in search engine results</p>
            @error('seoDescription') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
            @enderror
        </div>
    </div>

    <!-- Color Preview -->
    <div class="bg-gray-50 rounded-lg p-6 mt-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Color Preview</h3>
        <div class="flex space-x-4">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 rounded-full shadow-sm" id="primaryColorPreview" 
                     style="background-color: {{ old('brandPrimaryColor', $installationData['brandPrimaryColor'] ?? '#3B82F6') }}"></div>
                <span class="text-sm text-gray-600">Primary</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 rounded-full shadow-sm" id="secondaryColorPreview" 
                     style="background-color: {{ old('brandSecondaryColor', $installationData['brandSecondaryColor'] ?? '#1E40AF') }}"></div>
                <span class="text-sm text-gray-600">Secondary</span>
            </div>
        </div>
    </div>
</div>