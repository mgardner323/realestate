<?php

namespace App\Livewire;

use App\Models\Subscriber;
use Livewire\Component;
use Livewire\WithPagination;

class SubscriberList extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.subscriber-list', [
            'subscribers' => Subscriber::latest()->paginate(15)
        ]);
    }
}
