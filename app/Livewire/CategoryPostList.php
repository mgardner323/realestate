<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryPostList extends Component
{
    use WithPagination;
    
    public Category $category;
    
    public function mount(Category $category)
    {
        $this->category = $category;
    }
    
    public function render()
    {
        return view('livewire.category-post-list', [
            'posts' => $this->category->posts()->latest()->paginate(10)
        ])->title($this->category->name . ' - News');
    }
}
