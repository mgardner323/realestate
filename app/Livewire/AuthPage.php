<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Kreait\Firebase\Factory;
use Livewire\Component;

class AuthPage extends Component
{
    public $view = 'login'; // Track whether showing login or register form

    public function mount()
    {
        // Determine view state based on current route
        if (request()->routeIs('register') || request()->routeIs('register.post')) {
            $this->view = 'register';
        } else {
            $this->view = 'login';
        }
        
        // Handle POST fallback when JavaScript is disabled
        if (request()->isMethod('POST')) {
            $this->handleFallbackAuth();
        }
    }
    
    /**
     * Handle authentication fallback when JavaScript is disabled
     */
    private function handleFallbackAuth()
    {
        // Set error message for display
        session()->flash('error', 'JavaScript is required for authentication. Please enable JavaScript and try again.');
        
        // The component will automatically render with the error message
        // No redirect needed as we're already handling the POST request
    }

    public function verifyToken(string $token)
    {
        try {
            // Initialize Firebase with service account
            $factory = (new Factory)->withServiceAccount(base_path('../gcp-credentials.json'));
            $auth = $factory->createAuth();

            // Verify the ID token
            $verifiedIdToken = $auth->verifyIdToken($token);
            $uid = $verifiedIdToken->claims()->get('sub');
            $firebaseUser = $auth->getUser($uid);

            // Find or create user in our local database
            $user = User::updateOrCreate(
                ['firebase_uid' => $uid],
                [
                    'name' => $firebaseUser->displayName ?? $firebaseUser->email ?? 'User',
                    'email' => $firebaseUser->email,
                    'password' => Hash::make(uniqid()), // Random password since they use Firebase auth
                    'role' => 'client', // Default role for new users
                ]
            );

            // Log the user in
            Auth::login($user);

            // Redirect based on user role
            if ($user->isAdmin()) {
                return redirect('/admin/dashboard');
            } else {
                return redirect('/');
            }

        } catch (\Exception $e) {
            // Log error for debugging
            \Log::error('Firebase token verification failed: ' . $e->getMessage());
            
            // Return error response
            session()->flash('error', 'Authentication failed. Please try again.');
            return null;
        }
    }

    public function render()
    {
        return view('livewire.auth-page')->layout('components.layouts.app');
    }
}
