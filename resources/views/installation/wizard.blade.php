<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Installation Wizard - Real Estate Platform</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="flex justify-center items-center mb-6">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full p-4 shadow-lg">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
            <h1 class="text-4xl font-bold text-gray-900 mb-3">Real Estate Platform</h1>
            <p class="text-xl text-gray-600">Installation Wizard</p>
            <p class="text-gray-500 mt-2">Set up your professional real estate platform in just 3 steps</p>
        </div>

        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                @for ($i = 1; $i <= 3; $i++)
                    <div class="flex items-center {{ $i < 3 ? 'flex-1' : '' }}">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full border-2 transition-all duration-200
                                {{ $installation['currentStep'] >= $i ? 'bg-blue-600 border-blue-600 text-white' : 'border-gray-300 text-gray-500' }}">
                                @if ($installation['currentStep'] > $i)
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                @else
                                    <span class="text-sm font-medium">{{ $i }}</span>
                                @endif
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium {{ $installation['currentStep'] >= $i ? 'text-blue-600' : 'text-gray-500' }}">
                                    @if ($i == 1) Agency Information
                                    @elseif ($i == 2) Branding & SEO
                                    @else Admin Account
                                    @endif
                                </h3>
                            </div>
                        </div>
                        @if ($i < 3)
                            <div class="flex-1 mx-4 h-px {{ $installation['currentStep'] > $i ? 'bg-blue-600' : 'bg-gray-300' }} transition-colors duration-200"></div>
                        @endif
                    </div>
                @endfor
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Content Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <form method="POST" action="{{ route('install.process') }}">
                @csrf
                
                @if ($installation['currentStep'] == 1)
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
                                    value="{{ old('agencyName', $installation['agencyName']) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('agencyName') border-red-500 @enderror"
                                    placeholder="Enter your agency name">
                                @error('agencyName') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="agencyEmail" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="agencyEmail" id="agencyEmail"
                                    value="{{ old('agencyEmail', $installation['agencyEmail']) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('agencyEmail') border-red-500 @enderror"
                                    placeholder="contact@youragency.com">
                                @error('agencyEmail') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="agencyPhone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Phone Number
                                </label>
                                <input type="text" name="agencyPhone" id="agencyPhone"
                                    value="{{ old('agencyPhone', $installation['agencyPhone']) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('agencyPhone') border-red-500 @enderror"
                                    placeholder="(555) 123-4567">
                                @error('agencyPhone') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="agencyAddress" class="block text-sm font-medium text-gray-700 mb-2">
                                    Business Address
                                </label>
                                <textarea name="agencyAddress" id="agencyAddress" rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('agencyAddress') border-red-500 @enderror"
                                    placeholder="123 Main Street, City, State 12345">{{ old('agencyAddress', $installation['agencyAddress']) }}</textarea>
                                @error('agencyAddress') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                @elseif ($installation['currentStep'] == 2)
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
                                        value="{{ old('brandPrimaryColor', $installation['brandPrimaryColor']) }}"
                                        class="w-16 h-12 border border-gray-300 rounded-lg cursor-pointer">
                                    <input type="text" name="brandPrimaryColor" id="brandPrimaryColorText"
                                        value="{{ old('brandPrimaryColor', $installation['brandPrimaryColor']) }}"
                                        class="flex-1 px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('brandPrimaryColor') border-red-500 @enderror"
                                        placeholder="#3B82F6">
                                </div>
                                @error('brandPrimaryColor') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="brandSecondaryColor" class="block text-sm font-medium text-gray-700 mb-2">
                                    Secondary Brand Color <span class="text-red-500">*</span>
                                </label>
                                <div class="flex space-x-3">
                                    <input type="color" name="brandSecondaryColor" id="brandSecondaryColor"
                                        value="{{ old('brandSecondaryColor', $installation['brandSecondaryColor']) }}"
                                        class="w-16 h-12 border border-gray-300 rounded-lg cursor-pointer">
                                    <input type="text" name="brandSecondaryColor" id="brandSecondaryColorText"
                                        value="{{ old('brandSecondaryColor', $installation['brandSecondaryColor']) }}"
                                        class="flex-1 px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('brandSecondaryColor') border-red-500 @enderror"
                                        placeholder="#1E40AF">
                                </div>
                                @error('brandSecondaryColor') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="seoTitle" class="block text-sm font-medium text-gray-700 mb-2">
                                    SEO Title <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="seoTitle" id="seoTitle"
                                    value="{{ old('seoTitle', $installation['seoTitle']) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('seoTitle') border-red-500 @enderror"
                                    placeholder="Premier Real Estate Platform">
                                <p class="text-sm text-gray-500 mt-1">This will appear in browser tabs and search results</p>
                                @error('seoTitle') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="seoDescription" class="block text-sm font-medium text-gray-700 mb-2">
                                    SEO Description <span class="text-red-500">*</span>
                                </label>
                                <textarea name="seoDescription" id="seoDescription" rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('seoDescription') border-red-500 @enderror"
                                    placeholder="Find your dream property with our comprehensive real estate platform featuring advanced search, analytics, and modern design.">{{ old('seoDescription', $installation['seoDescription']) }}</textarea>
                                <p class="text-sm text-gray-500 mt-1">This description will appear in search engine results</p>
                                @error('seoDescription') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Color Preview -->
                        <div class="bg-gray-50 rounded-lg p-6 mt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Color Preview</h3>
                            <div class="flex space-x-4">
                                <div class="flex items-center space-x-2">
                                    <div id="primaryColorPreview" class="w-8 h-8 rounded-full shadow-sm" style="background-color: {{ $installation['brandPrimaryColor'] }}"></div>
                                    <span class="text-sm text-gray-600">Primary</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div id="secondaryColorPreview" class="w-8 h-8 rounded-full shadow-sm" style="background-color: {{ $installation['brandSecondaryColor'] }}"></div>
                                    <span class="text-sm text-gray-600">Secondary</span>
                                </div>
                            </div>
                        </div>
                    </div>

                @elseif ($installation['currentStep'] == 3)
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
                                    value="{{ old('adminName', $installation['adminName']) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('adminName') border-red-500 @enderror"
                                    placeholder="John Doe">
                                @error('adminName') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="adminEmail" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="adminEmail" id="adminEmail"
                                    value="{{ old('adminEmail', $installation['adminEmail']) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('adminEmail') border-red-500 @enderror"
                                    placeholder="admin@youragency.com">
                                @error('adminEmail') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="adminPassword" class="block text-sm font-medium text-gray-700 mb-2">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" name="adminPassword" id="adminPassword"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('adminPassword') border-red-500 @enderror"
                                    placeholder="Choose a secure password">
                                <p class="text-sm text-gray-500 mt-1">Minimum 8 characters required</p>
                                @error('adminPassword') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="adminPasswordConfirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    Confirm Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" name="adminPassword_confirmation" id="adminPasswordConfirmation"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('adminPassword_confirmation') border-red-500 @enderror"
                                    placeholder="Confirm your password">
                                @error('adminPassword_confirmation') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Installation Summary -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mt-8">
                            <h3 class="text-lg font-semibold text-blue-900 mb-3">Installation Summary</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="font-medium text-blue-800">Agency:</span>
                                    <span class="text-blue-600">{{ $installation['agencyName'] }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-blue-800">Email:</span>
                                    <span class="text-blue-600">{{ $installation['agencyEmail'] }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-blue-800">SEO Title:</span>
                                    <span class="text-blue-600">{{ $installation['seoTitle'] }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-blue-800">Admin:</span>
                                    <span class="text-blue-600">{{ $installation['adminName'] ?: 'To be created' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Navigation Buttons -->
                <div class="flex justify-between items-center pt-8 border-t border-gray-200 mt-8">
                    <div>
                        @if ($installation['currentStep'] > 1)
                            <button type="submit" name="action" value="previous"
                                class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Previous
                            </button>
                        @endif
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Progress Indicator -->
                        <div class="text-sm text-gray-500">
                            Step {{ $installation['currentStep'] }} of 3
                        </div>

                        @if ($installation['currentStep'] < 3)
                            <button type="submit" name="action" value="next"
                                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                Next Step
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        @else
                            <button type="submit" name="action" value="finish"
                                class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Complete Installation
                            </button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Color picker synchronization
document.addEventListener('DOMContentLoaded', function() {
    // Primary color
    const primaryColorPicker = document.getElementById('brandPrimaryColor');
    const primaryColorText = document.getElementById('brandPrimaryColorText');
    const primaryColorPreview = document.getElementById('primaryColorPreview');

    if (primaryColorPicker && primaryColorText) {
        primaryColorPicker.addEventListener('change', function() {
            primaryColorText.value = this.value;
            if (primaryColorPreview) {
                primaryColorPreview.style.backgroundColor = this.value;
            }
        });

        primaryColorText.addEventListener('input', function() {
            if (/^#[0-9A-F]{6}$/i.test(this.value)) {
                primaryColorPicker.value = this.value;
                if (primaryColorPreview) {
                    primaryColorPreview.style.backgroundColor = this.value;
                }
            }
        });
    }

    // Secondary color
    const secondaryColorPicker = document.getElementById('brandSecondaryColor');
    const secondaryColorText = document.getElementById('brandSecondaryColorText');
    const secondaryColorPreview = document.getElementById('secondaryColorPreview');

    if (secondaryColorPicker && secondaryColorText) {
        secondaryColorPicker.addEventListener('change', function() {
            secondaryColorText.value = this.value;
            if (secondaryColorPreview) {
                secondaryColorPreview.style.backgroundColor = this.value;
            }
        });

        secondaryColorText.addEventListener('input', function() {
            if (/^#[0-9A-F]{6}$/i.test(this.value)) {
                secondaryColorPicker.value = this.value;
                if (secondaryColorPreview) {
                    secondaryColorPreview.style.backgroundColor = this.value;
                }
            }
        });
    }
});
</script>
</body>
</html>