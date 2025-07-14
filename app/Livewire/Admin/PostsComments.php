<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use App\Models\Comment;
use Livewire\Component;

class PostsComments extends Component
{
    public function render()
    {
        $Post_latest= Post::latest()->take(5)->get();
        $Comments=Comment::latest()->take(5)->get();

        return view('livewire.admin.posts-comments', compact('Post_latest','Comments'));
    }
}
