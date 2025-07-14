<?php

namespace App\Http\Controllers\Frontend;

use Dom\Comment;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\NumberOfView;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {




        $posts = Post::active()
            ->whereHas('category', function ($q) {
                $q->where('status', 1);
            })
            ->with('images')
            ->latest()
            ->paginate(9);


        $oldest = Post::active()->oldest()->limit(3)->get(); // oldest new
        $greatest = Post::active()->withCount('views')->orderBy('views_count', 'desc')->limit(3)->get(); // most viewed
        $popular = Post::active()->withCount('comments')->orderBy('comments_count', 'desc')->limit(3)->get(); // most commented ->popular
        $categories = Category::category_active()->has('posts', '>', 3)->get();
        $categories_with_posts = $categories->map(function ($category) {
            $category->posts = $category->posts()->active()->limit(5)->get();
            return $category;
        });
        return view('index', compact('posts', 'greatest', 'oldest', 'popular', 'categories_with_posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // تسجيل المشاهدة مرة واحدة فقط لكل يوزر
        if (!NumberOfView::where('post_id', $post->id)
            ->where('user_id', auth()->id())
            ->exists()) {

            NumberOfView::create([
                'post_id' => $post->id,
                'user_id' => auth()->id(),
                'ip_address' => request()->ip(),
            ]);
        }

        return view('frontend.singleNews', compact('post'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
