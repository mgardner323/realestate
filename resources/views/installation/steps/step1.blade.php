<!-- Step 1: Agency Information -->
<div class="space-y-6">
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Agency Information</h2>
        <p class="text-gray-600">Tell us about your real estate agency</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="agencyName" class="block text-sm font-medium text-gray-700 mb-2">
                Agency Name <span class="text-red-500">*</span>
            </label>
            <input type="text" name="agencyName" id="agencyName" 
                value="{{ old('agencyName', $installationData['agencyName'] ?? '') }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors {{ $errors->has('agencyName') ? 'border-red-300' : '' }}"
                placeholder="Enter your agency name" required>
            @error('agencyName') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
            @enderror
        </div>

        <div>
            <label for="agencyEmail" class="block text-sm font-medium text-gray-700 mb-2">
                Email Address <span class="text-red-500">*</span>
            </label>
            <input type="email" name="agencyEmail" id="agencyEmail"
                value="{{ old('agencyEmail', $installationData['agencyEmail'] ?? '') }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors {{ $errors->has('agencyEmail') ? 'border-red-300' : '' }}"
                placeholder="contact@youragency.com" required>
            @error('agencyEmail') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
            @enderror
        </div>

        <div>
            <label for="agencyPhone" class="block text-sm font-medium text-gray-700 mb-2">
                Phone Number
            </label>
            <input type="text" name="agencyPhone" id="agencyPhone"
                value="{{ old('agencyPhone', $installationData['agencyPhone'] ?? '') }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors {{ $errors->has('agencyPhone') ? 'border-red-300' : '' }}"
                placeholder="(555) 123-4567">
            @error('agencyPhone') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
            @enderror
        </div>

        <div class="md:col-span-2">
            <label for="agencyAddress" class="block text-sm font-medium text-gray-700 mb-2">
                Business Address
            </label>
            <textarea name="agencyAddress" id="agencyAddress" rows="3"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors {{ $errors->has('agencyAddress') ? 'border-red-300' : '' }}"
                placeholder="123 Main Street, City, State 12345">{{ old('agencyAddress', $installationData['agencyAddress'] ?? '') }}</textarea>
            @error('agencyAddress') 
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
            @enderror
        </div>
    </div>
</div>