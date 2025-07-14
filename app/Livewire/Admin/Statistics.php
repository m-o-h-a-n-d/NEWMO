<?php

namespace App\Livewire\Admin;

use App\Models\Post;
use App\Models\User;
use Livewire\Component;
use App\Models\Category;
use App\Models\Comment;

class Statistics extends Component
{

    
    public function render()
    {
        $users_active = User::whereStatus(1)->count();
        $posts_active = Post::whereStatus(1)->count();
        $category_active = Category::whereStatus(1)->count();
        $category_total = Category::count();
        $comment = Comment::count();



        return view('livewire.admin.statistics', compact(
            'users_active',
            'posts_active',
            'category_active',
            'comment',
            'category_total',
        ));
    }
}
