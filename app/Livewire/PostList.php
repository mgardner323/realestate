<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class PostList extends Component
{
    public function delete(Post $post)
    {
        $this->authorize('delete', $post);
        
        $post->delete();
        
        session()->flash('message', 'Post deleted successfully.');
    }

    public function render()
    {
        if (auth()->user() && auth()->user()->isAdmin()) {
            $posts = Post::latest()->get();
        } else {
            $posts = Post::where('is_published', true)->latest()->get();
        }

        return view('livewire.post-list', [
            'posts' => $posts,
            'categories' => \App\Models\Category::all(),
            'communities' => \App\Models\Community::where('is_published', true)->get(),
            'logoPath' => \App\Models\Setting::get('logo_path'),
            'heroPath' => \App\Models\Setting::get('hero_media_path')
        ]);
    }
}
