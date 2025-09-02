<!-- Step 3: Admin Account -->
<div class="space-y-6">
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Admin Account</h2>
        <p class="text-gray-600">Create your administrator account to manage the platform</p>
    </div>

    <div class="max-w-lg mx-auto space-y-6">
        <div>
            <label for="adminName" class="block text-sm font-medium text-gray-700 mb-2">
                Full Name <span class="text-red-500">*</span>
            </label>
            <input type="text" name="adminName" id="adminName"
                value="{{ old('adminName', $installationData['adminName'] ?? '') }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors {{ $errors->has('adminName') ? 'border-red-300' : '' }}"
                placeholder="John Doe" required>
            @error('adminName') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
            @enderror
        </div>

        <div>
            <label for="adminEmail" class="block text-sm font-medium text-gray-700 mb-2">
                Email Address <span class="text-red-500">*</span>
            </label>
            <input type="email" name="adminEmail" id="adminEmail"
                value="{{ old('adminEmail', $installationData['adminEmail'] ?? '') }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors {{ $errors->has('adminEmail') ? 'border-red-300' : '' }}"
                placeholder="admin@youragency.com" required>
            @error('adminEmail') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
            @enderror
        </div>

        <div>
            <label for="adminPassword" class="block text-sm font-medium text-gray-700 mb-2">
                Password <span class="text-red-500">*</span>
            </label>
            <input type="password" name="adminPassword" id="adminPassword"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors {{ $errors->has('adminPassword') ? 'border-red-300' : '' }}"
                placeholder="Choose a secure password" required>
            <p class="text-sm text-gray-500 mt-1">Minimum 8 characters required</p>
            @error('adminPassword') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
            @enderror
        </div>

        <div>
            <label for="adminPasswordConfirmation" class="block text-sm font-medium text-gray-700 mb-2">
                Confirm Password <span class="text-red-500">*</span>
            </label>
            <input type="password" name="adminPasswordConfirmation" id="adminPasswordConfirmation"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors {{ $errors->has('adminPasswordConfirmation') ? 'border-red-300' : '' }}"
                placeholder="Confirm your password" required>
            @error('adminPasswordConfirmation') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
            @enderror
        </div>
    </div>

    <!-- Installation Summary -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mt-8">
        <h3 class="text-lg font-semibold text-blue-900 mb-3">Installation Summary</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <span class="font-medium text-blue-800">Agency:</span>
                <span class="text-blue-600">{{ $installationData['agencyName'] ?? 'Not set' }}</span>
            </div>
            <div>
                <span class="font-medium text-blue-800">Email:</span>
                <span class="text-blue-600">{{ $installationData['agencyEmail'] ?? 'Not set' }}</span>
            </div>
            <div>
                <span class="font-medium text-blue-800">SEO Title:</span>
                <span class="text-blue-600">{{ $installationData['seoTitle'] ?? 'Not set' }}</span>
            </div>
            <div>
                <span class="font-medium text-blue-800">Admin:</span>
                <span class="text-blue-600">{{ old('adminName', $installationData['adminName'] ?? 'Not set') }}</span>
            </div>
        </div>
    </div>
</div>