<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

use function Laravel\Prompts\search;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'search' =>['nullable','string','max:100'],
        ]);
        $keyword= strip_tags($request->search);

        // Search the value of Search like -> title Or Description
        $posts=Post::active()->where('title','LIKE',"%".$keyword.'%')
        ->orWhere('description' , 'LIKE' , "%".$keyword.'%')
        ->paginate(9);
        return  view('frontend.search.search' , compact('posts'));

    }
}
