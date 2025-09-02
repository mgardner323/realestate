<?php

namespace App\Livewire;

use App\Models\Property;
use Livewire\Component;
use Livewire\WithPagination;

class PropertyListAdmin extends Component
{
    use WithPagination;

    public function delete(Property $property)
    {
        $property->delete();
        session()->flash('message', 'Property successfully deleted.');
    }

    public function render()
    {
        return view('livewire.property-list-admin', [
            'properties' => Property::latest()->paginate(10)
        ]);
    }
}
