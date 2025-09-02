<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Post;
use App\Services\GeminiService;
use Livewire\Component;

class EditPost extends Component
{
    public Post $post;
    public $title = '';
    public $body = '';
    public $is_published = true;
    public $category_id = null;
    public $meta_title = '';
    public $meta_description = '';

    public function mount(Post $post)
    {
        $this->authorize('update', $post);
        
        $this->post = $post;
        $this->title = $post->title;
        $this->body = $post->body;
        $this->is_published = $post->is_published;
        $this->category_id = $post->category_id;
        $this->meta_title = $post->meta_title ?? '';
        $this->meta_description = $post->meta_description ?? '';
    }

    public function generatePostContent()
    {
        $gemini = new GeminiService();
        $this->body = $gemini->generateBlogPost($this->title);
    }

    public function generateSeoTags()
    {
        if (empty($this->body)) {
            session()->flash('error', 'Please add post content before generating SEO tags.');
            return;
        }

        $gemini = new GeminiService();
        $seoTags = $gemini->generateSeoTags($this->body);
        
        $this->meta_title = $seoTags['meta_title'];
        $this->meta_description = $seoTags['meta_description'];
        
        if (!empty($this->meta_title) && !empty($this->meta_description)) {
            session()->flash('message', 'SEO tags generated successfully!');
        } else {
            session()->flash('error', 'Failed to generate SEO tags. Please try again.');
        }
    }

    public function generateFeaturedImage()
    {
        if (empty($this->body)) {
            session()->flash('error', 'Please add post content before generating a featured image.');
            return;
        }

        $gemini = new GeminiService();
        $imagePath = $gemini->generateFeaturedImage($this->body);
        
        if ($imagePath) {
            $this->post->update(['featured_image_url' => $imagePath]);
            $this->post->refresh();
            session()->flash('message', 'Featured image generated successfully!');
        } else {
            session()->flash('error', 'Failed to generate featured image. Please try again.');
        }
    }

    public function update()
    {
        $this->authorize('update', $this->post);

        $this->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'is_published' => 'boolean',
            'category_id' => 'nullable|exists:categories,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $this->post->update([
            'title' => $this->title,
            'slug' => \Str::slug($this->title),
            'body' => $this->body,
            'is_published' => $this->is_published,
            'category_id' => $this->category_id,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
        ]);

        session()->flash('message', 'Post updated successfully!');
        
        return redirect('/admin/blog');
    }

    public function render()
    {
        return view('livewire.edit-post', [
            'categories' => Category::orderBy('name')->get(),
        ])->layout('components.layouts.app');
    }
}
