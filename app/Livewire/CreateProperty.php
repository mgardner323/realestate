<?php

namespace App\Livewire;

use App\Models\Property;
use Livewire\Component;

class CreateProperty extends Component
{
    public $title = '';
    public $description = '';
    public $price = '';
    public $location = '';
    public $type = 'sale';
    public $featured = false;

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'type' => 'required|in:sale,rent',
            'featured' => 'boolean',
        ]);

        Property::create([
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'location' => $this->location,
            'type' => $this->type,
            'featured' => $this->featured,
            'status' => 'active', // Default status
        ]);

        session()->flash('message', 'Property created successfully!');
        return redirect('/admin/properties');
    }

    public function render()
    {
        return view('livewire.create-property');
    }
}
