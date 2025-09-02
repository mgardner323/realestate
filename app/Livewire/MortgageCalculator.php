<?php

namespace App\Livewire;

use Livewire\Component;

class MortgageCalculator extends Component
{
    public $loanAmount = '';
    public $interestRate = '';
    public $loanTermYears = '';
    public $monthlyPayment = 0;

    public function calculate()
    {
        // Validate inputs
        if (empty($this->loanAmount) || empty($this->interestRate) || empty($this->loanTermYears)) {
            $this->monthlyPayment = 0;
            return;
        }

        $P = (float) $this->loanAmount;
        $annualInterestRate = (float) $this->interestRate;
        $loanTermYears = (float) $this->loanTermYears;

        // Additional validation
        if ($P <= 0 || $annualInterestRate < 0 || $loanTermYears <= 0) {
            $this->monthlyPayment = 0;
            return;
        }

        // Check for 0% interest rate edge case
        if ($annualInterestRate == 0) {
            $this->monthlyPayment = $P / ($loanTermYears * 12);
        } else {
            // Convert annual rate to monthly decimal and term to months
            $r = $annualInterestRate / 100 / 12;
            $n = $loanTermYears * 12;

            // Implement the mortgage formula: M = P [ r(1+r)^n ] / [ (1+r)^n – 1 ]
            $numerator = $P * $r * pow(1 + $r, $n);
            $denominator = pow(1 + $r, $n) - 1;
            $this->monthlyPayment = $numerator / $denominator;
        }

        // Ensure result is finite
        if (!is_finite($this->monthlyPayment)) {
            $this->monthlyPayment = 0;
        }
    }

    public function render()
    {
        return view('livewire.mortgage-calculator');
    }
}
