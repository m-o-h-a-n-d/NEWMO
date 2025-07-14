<?php

namespace App\Http\Controllers\Admin\Posts;

use App\Models\Post;
use App\Models\Image;
use App\Models\Comment;
use App\Models\Category;
use App\Utils\ImageManger;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('can:posts');
    }



    public function index(Request $request)
    {
        $query = session('search_query');

        $posts = Post::query();

        if ($query) {
            $posts = Post::search($query); // Meilisearch
        }
        $posts = $posts->latest()->get();

        return view('admin.posts.index', compact('posts', 'query'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $category = Category::all();

        return view('admin.posts.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {


        try {
            DB::beginTransaction();
            // Request ::validate
            $request->validated();

            $request->merge(['slug' => Str::slug($request->title)]);
            // REQUEST Comment_able
            $request->comment_able == 'on' ? $request->merge(['comment_able' => 1]) : $request->merge(['comment_able' => 0]); // تستخدم merge لتحديث قيمة الـ comment_able في الـ request
            // Add admin
            $post = Auth::guard('admin')->user()->posts()->create($request->except(['image', '_token']));
            // Utils => ImageManger
            ImageManger::uploadImage($request, $post);

            Cache::forget('read_more_posts'); // Clear cache for Read More posts
            Cache::forget('latest_posts'); // Clear cache for latest posts
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }


        return redirect()->back()->with('success', 'Post created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        return view('admin.posts.edit', compact('post'));
    }


    // Delete the image of posts
    public  function EditImagePost(Request $request, $image_id)
    {
        $image = Image::find($request->key);

        if (!$image) {
            return  response()->json(['error' => 'Image not found'], 404);
        };

        // Delete the image file from local storage
        ImageManger::deleteImageFromLocal($image->path);

        // Delete the image record from the database
        $image->delete();
        return response()->json(['success' => 'Image deleted successfully'], 200);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id)
    {

        $request->validated();

        $post = Post::with('images')->findOrFail($id);

        // to check if the post has old picture
        $hasOldImages = $post->images->count() > 0;
        $hasNewImages = $request->hasFile('image') && count($request->file('image')) > 0;

        if (! $hasOldImages && ! $hasNewImages) {
            return redirect()->back()->with('error', ' You must upload at least one image');
        }

        // update Comments
        $request->comment_able == 'on' ? $request->merge(['comment_able' => 1]) : $request->merge(['comment_able' => 0]); // تستخدم merge لتحديث قيمة الـ comment_able في الـ request

        // Update Post Data
        $post->update($request->except(['image']));


        // Upload New Image if Exist
        ImageManger::uploadImage($request, $post);


        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        ImageManger::deleteImage($post);
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully');



        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', "Post Deleted Successfully");
    }
    public function BlockPost($id)
    {
        $post = Post::findOrFail($id);

        if ($post->status == 0) {
            // post was Block And convert it to Active
            $post->update([
                'status' => '1',
            ]);
            return redirect()->route('admin.posts.index')->with('success', "Post Active Successfully");
        }
        // post was Active And convert it to Block
        $post->update([
            'status' => '0',
        ]);


        return redirect()->route('admin.posts.index')->with('warning', "Post Blocked Now!");
    }
    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return response()->json(['success' => true]);
    }
}
