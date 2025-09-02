<div class="bg-gray-100 flex items-center justify-center min-h-screen font-sans">

    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-lg mx-4">

        <!-- Header -->
        <h1 class="text-3xl font-bold text-gray-800 text-center mb-2">Mortgage Calculator</h1>
        <p class="text-gray-500 text-center mb-8">Estimate your monthly payment.</p>

        <!-- Calculator Form -->
        <form wire:submit.prevent="calculate" class="space-y-6">

            <!-- Loan Amount Input -->
            <div>
                <label for="loan-amount" class="block text-sm font-medium text-gray-700 mb-1">Loan Amount ($)</label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <span class="text-gray-500 sm:text-sm">$</span>
                    </div>
                    <input type="number" 
                           id="loan-amount" 
                           wire:model="loanAmount" 
                           required
                           class="w-full pl-7 pr-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-lg"
                           placeholder="300000">
                </div>
            </div>

            <!-- Interest Rate Input -->
            <div>
                <label for="interest-rate" class="block text-sm font-medium text-gray-700 mb-1">Interest Rate (%)</label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                        <span class="text-gray-500 sm:text-sm">%</span>
                    </div>
                    <input type="number" 
                           id="interest-rate" 
                           wire:model="interestRate" 
                           required 
                           step="0.01"
                           class="w-full pr-8 pl-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-lg"
                           placeholder="6.5">
                </div>
            </div>

            <!-- Loan Term Input -->
            <div>
                <label for="loan-term" class="block text-sm font-medium text-gray-700 mb-1">Loan Term (Years)</label>
                <input type="number" 
                       id="loan-term" 
                       wire:model="loanTermYears" 
                       required
                       class="w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-lg"
                       placeholder="30">
            </div>

            <!-- Calculate Button -->
            <button type="submit"
                    class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-300 text-lg">
                Calculate
            </button>
        </form>

        <!-- Result Display Area -->
        <div class="mt-8 text-center bg-indigo-50 p-6 rounded-lg border border-indigo-200">
            <p class="text-gray-600 text-lg">Your Estimated Monthly Payment</p>
            <p class="text-4xl font-bold text-indigo-800 mt-2">
                @if($monthlyPayment > 0)
                    ${{ number_format($monthlyPayment, 2) }}
                @else
                    $0.00
                @endif
            </p>
        </div>

        <!-- Back to Home Button -->
        <div class="mt-6 text-center">
            <a href="/" class="text-indigo-600 hover:text-indigo-800 transition-colors">
                ← Back to Home
            </a>
        </div>

    </div>

</div>