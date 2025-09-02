<?php

namespace App\Livewire;

use Livewire\Component;

class AffordabilityCalculator extends Component
{
    public $annualIncome = '';
    public $monthlyDebts = '';
    public $estimatedAffordablePrice = 0;

    // Calculation constants (assumptions)
    private $dtiRatio = 0.36; // 36% Debt-to-Income Ratio
    private $annualInterestRate = 0.065; // 6.5% Annual Interest Rate
    private $loanTermYears = 30;
    private $pitiEstimateFactor = 0.75; // Assumes 25% of payment goes to Taxes & Insurance
    private $downPaymentPercent = 0.20; // 20% Down Payment

    public function calculate()
    {
        // Validate inputs
        if (empty($this->annualIncome) || empty($this->monthlyDebts)) {
            $this->estimatedAffordablePrice = 0;
            return;
        }

        $annualIncome = (float) $this->annualIncome;
        $monthlyDebts = (float) $this->monthlyDebts;

        // Additional validation
        if ($annualIncome <= 0 || $monthlyDebts < 0) {
            $this->estimatedAffordablePrice = 0;
            return;
        }

        // 1. Calculate Gross Monthly Income
        $grossMonthlyIncome = $annualIncome / 12;

        // 2. Calculate Maximum Allowable Monthly Debt
        $maxMonthlyDebt = $grossMonthlyIncome * $this->dtiRatio;

        // 3. Calculate Maximum Affordable Monthly Housing Payment (PITI)
        $maxPITI = $maxMonthlyDebt - $monthlyDebts;

        if ($maxPITI <= 0) {
            $this->estimatedAffordablePrice = 0;
            return;
        }

        // 4. Estimate Principal & Interest (P&I) portion
        $maxPI = $maxPITI * $this->pitiEstimateFactor;

        // 5. Calculate total loan amount from P&I
        $monthlyInterestRate = $this->annualInterestRate / 12;
        $numberOfPayments = $this->loanTermYears * 12;
        
        // Using the formula for the present value of an ordinary annuity
        $loanAmount = $maxPI * ((pow(1 + $monthlyInterestRate, $numberOfPayments) - 1) / ($monthlyInterestRate * pow(1 + $monthlyInterestRate, $numberOfPayments)));

        // 6. Calculate final home price based on down payment
        $affordableHomePrice = $loanAmount / (1 - $this->downPaymentPercent);

        // Ensure result is finite and positive
        if (!is_finite($affordableHomePrice) || $affordableHomePrice < 0) {
            $this->estimatedAffordablePrice = 0;
        } else {
            $this->estimatedAffordablePrice = $affordableHomePrice;
        }
    }

    public function render()
    {
        return view('livewire.affordability-calculator');
    }
}
