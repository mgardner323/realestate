<?php

namespace App\Livewire;

use App\Models\Category;
use App\Services\GeminiService;
use Livewire\Component;
use App\Models\Post;

class CreatePost extends Component
{
    public $title = '';
    public $body = '';
    public $category_id = null;

    public function generatePostContent()
    {
        $gemini = new GeminiService();
        $this->body = $gemini->generateBlogPost($this->title);
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        Post::create([
            'title' => $this->title,
            'slug' => \Str::slug($this->title),
            'body' => $this->body,
            'category_id' => $this->category_id,
            'is_published' => true,
        ]);

        session()->flash('message', 'Post created successfully!');
        
        $this->title = '';
        $this->body = '';
        $this->category_id = null;
    }

    public function render()
    {
        return view('livewire.create-post', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }
}
