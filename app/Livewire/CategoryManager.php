<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class CategoryManager extends Component
{
    public $name = '';
    public $editingId = null;

    public function save()
    {
        $this->validate([
            'name' => 'required|string|min:2|max:255|unique:categories,name,' . $this->editingId,
        ]);

        if ($this->editingId) {
            // Update existing category
            $category = Category::find($this->editingId);
            $category->update([
                'name' => $this->name,
            ]);
            session()->flash('message', 'Category updated successfully.');
        } else {
            // Create new category
            Category::create([
                'name' => $this->name,
            ]);
            session()->flash('message', 'Category created successfully.');
        }

        $this->reset(['name', 'editingId']);
    }

    public function edit($categoryId)
    {
        $category = Category::find($categoryId);
        $this->name = $category->name;
        $this->editingId = $categoryId;
    }

    public function cancelEdit()
    {
        $this->reset(['name', 'editingId']);
    }

    public function delete($categoryId)
    {
        $category = Category::find($categoryId);
        
        // Check if category has posts
        if ($category->posts()->count() > 0) {
            session()->flash('error', 'Cannot delete category that has posts assigned to it.');
            return;
        }
        
        $category->delete();
        session()->flash('message', 'Category deleted successfully.');
    }

    public function render()
    {
        return view('livewire.category-manager', [
            'categories' => Category::withCount('posts')->orderBy('name')->get(),
        ]);
    }
}
