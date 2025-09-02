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
        ]);
    }
}
