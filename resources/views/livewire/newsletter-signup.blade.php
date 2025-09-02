<!-- Newsletter Signup Form Component -->
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg">
    
    <!-- Heading -->
    <div class="text-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Subscribe to our Newsletter</h2>
        <p class="text-gray-500 mt-2">Get the latest real estate news and updates delivered to your inbox.</p>
    </div>

    @if($successMessage)
        <!-- Success Message -->
        <div class="mb-6 text-center">
            <p class="text-green-600 font-semibold">🎉 {{ $successMessage }}</p>
            <p class="text-gray-500 text-sm">We'll keep you updated with our latest properties and insights.</p>
        </div>
    @else
        <!-- Form -->
        <form wire:submit.prevent="subscribe" class="w-full">
            <div class="flex items-center">
                <input 
                    type="email" 
                    wire:model="email"
                    placeholder="Enter your email" 
                    required
                    class="w-full px-4 py-3 text-gray-700 bg-gray-50 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-300"
                />
                <button 
                    type="submit" 
                    class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-r-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-300"
                >
                    Subscribe
                </button>
            </div>
            @error('email') 
                <p class="mt-2 text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </form>
    @endif

</div>
