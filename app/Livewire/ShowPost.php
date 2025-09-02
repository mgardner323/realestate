<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class ShowPost extends Component
{
    public Post $post;

    public function mount(Post $post)
    {
        // Only allow published posts to be viewed
        if (!$post->is_published) {
            abort(404);
        }
        
        $this->post = $post;
    }

    public function render()
    {
        return view('livewire.show-post');
    }
}
