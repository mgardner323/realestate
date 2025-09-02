<?php

namespace App\Livewire;

use App\Models\Property;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        $featuredProperties = Cache::remember('featured_properties', 3600, function () {
            return Property::where('is_featured', true)->latest()->take(5)->get();
        });

        return view('livewire.home', [
            'featuredProperties' => $featuredProperties,
        ]);
    }
}
