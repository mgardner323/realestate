<?php

namespace App\Livewire;

use App\Models\Subscriber;
use Livewire\Component;

class NewsletterSignup extends Component
{
    public $email;
    public $successMessage = '';

    public function subscribe()
    {
        $validated = $this->validate([
            'email' => 'required|email|unique:subscribers,email'
        ]);

        Subscriber::create($validated);

        $this->successMessage = 'Thank you for subscribing!';
        $this->reset('email');
    }

    public function render()
    {
        return view('livewire.newsletter-signup');
    }
}
