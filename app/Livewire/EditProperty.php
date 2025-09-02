<?php

namespace App\Livewire;

use App\Services\GeminiService;
use Livewire\Component;
use App\Models\Property;

class EditProperty extends Component
{
    public Property $property;
    public $title, $location, $price, $description, $type, $featured;

    public function mount(Property $property)
    {
        $this->property = $property;
        $this->title = $property->title;
        $this->location = $property->location;
        $this->price = $property->price;
        $this->description = $property->description;
        $this->type = $property->type;
        $this->featured = $property->featured ?? false;
    }

    public function generateDescription()
    {
        $gemini = new GeminiService();
        $propertyData = [
            'title' => $this->title,
            'location' => $this->location,
            'price' => $this->price,
        ];
        $this->description = $gemini->generatePropertyDescription($propertyData);
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'type' => 'required|in:sale,rent',
            'featured' => 'boolean',
        ]);

        $this->property->update([
            'title' => $this->title,
            'location' => $this->location,
            'price' => $this->price,
            'description' => $this->description,
            'type' => $this->type,
            'featured' => $this->featured,
        ]);

        session()->flash('message', 'Property updated successfully!');
        return redirect('/admin/properties');
    }

    public function render()
    {
        return view('livewire.edit-property');
    }
}
