<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\Property;
use App\Models\Subscriber;
use App\Models\User;
use Livewire\Component;

class AdminDashboard extends Component
{
    public function render()
    {
        return view('livewire.admin-dashboard', [
            'totalProperties' => Property::count(),
            'totalUsers' => User::count(),
            'totalSubscribers' => Subscriber::count(),
            'totalPosts' => Post::count(),
        ]);
    }
}
