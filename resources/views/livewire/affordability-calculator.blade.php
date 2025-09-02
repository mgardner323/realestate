<div class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-lg p-8 space-y-8 bg-white rounded-xl shadow-lg">
        
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-900">Home Affordability Calculator</h1>
            <p class="mt-2 text-sm text-gray-600">Estimate the home price you can afford.</p>
        </div>

        <form wire:submit.prevent="calculate" class="space-y-6">
            <!-- Annual Income Input -->
            <div>
                <label for="annual-income" class="block text-sm font-medium text-gray-700">Annual Income</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <span class="text-gray-500 sm:text-sm">$</span>
                    </div>
                    <input type="number" 
                           name="annual-income" 
                           id="annual-income" 
                           wire:model="annualIncome"
                           required
                           class="block w-full rounded-md border-gray-300 pl-7 pr-3 py-3 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                           placeholder="80000">
                </div>
            </div>

            <!-- Total Monthly Debts Input -->
            <div>
                <label for="monthly-debts" class="block text-sm font-medium text-gray-700">Total Monthly Debts</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <span class="text-gray-500 sm:text-sm">$</span>
                    </div>
                    <input type="number" 
                           name="monthly-debts" 
                           id="monthly-debts" 
                           wire:model="monthlyDebts"
                           required
                           class="block w-full rounded-md border-gray-300 pl-7 pr-3 py-3 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                           placeholder="400">
                </div>
                <p class="mt-2 text-xs text-gray-500">e.g., car payments, student loans, credit cards.</p>
            </div>

            <!-- Calculate Button -->
            <button type="submit"
                    class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-300 text-lg">
                Calculate Affordability
            </button>
        </form>

        <!-- Result Display -->
        <div class="mt-8 p-6 bg-indigo-50 rounded-lg text-center">
            <p class="text-lg font-medium text-indigo-800">Estimated Affordable Home Price</p>
            <p class="text-5xl font-bold text-indigo-600 mt-2">
                @if($estimatedAffordablePrice > 0)
                    ${{ number_format($estimatedAffordablePrice, 0) }}
                @else
                    $0
                @endif
            </p>
        </div>

        <div class="text-center">
            <p class="text-xs text-gray-500">
                *This is an estimate for informational purposes only. Assumes a 36% DTI, 30-year loan, 20% down payment, and current market conditions. Consult a financial advisor.
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