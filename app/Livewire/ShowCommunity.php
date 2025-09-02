<?php

namespace App\Livewire;

use App\Models\Community;
use Livewire\Component;

class ShowCommunity extends Component
{
    public Community $community;

    public function mount(Community $community)
    {
        // Only show published communities to public
        if (!$community->is_published) {
            abort(404);
        }
        
        $this->community = $community;
    }

    public function render()
    {
        return view('livewire.show-community', [
            'community' => $this->community
        ])->layout('components.layouts.app', [
            'title' => $this->community->name . ' - Community Information'
        ]);
    }
}
