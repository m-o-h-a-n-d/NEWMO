<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($slug)
    {
        $category = Category::whereSlug($slug)->category_active()->first();
        $posts = $category->posts()->active()->with('images')->paginate(9);





        return view('frontend.category', compact('category', 'posts'));
    }
}
