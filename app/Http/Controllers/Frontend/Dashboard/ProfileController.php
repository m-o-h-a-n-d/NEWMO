<?php

namespace App\Http\Controllers\Frontend\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Image;
use App\Models\Post;
use App\Utils\ImageManger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    public function index()

    {
        $MyPosts = Post::active()->latest()->where('user_id', auth()->user()->id)->with([
            'images',
            'comments' => function ($query) {
                $query->comment_active()->latest();
            },

        ])
            ->get(); // لو مفيش بوست نشط أو الكاتيجوري مش نشط → يرجع 404

        // return $MyPosts->title;




        return view('frontend.dashboard.profile', compact('MyPosts'));
    }
    public function store(PostRequest $request)
    {

        try {


            DB::beginTransaction(); // Start a database transaction
            // Request ::validate
            $request->validated();
            // REQUEST Comment_able
            $request->comment_able == 'on' ? $request->merge(['comment_able' => 1]) : $request->merge(['comment_able' => 0]); // تستخدم merge لتحديث قيمة الـ comment_able في الـ request
            // Add user_id
            $request->merge(['user_id' => auth()->user()->id]);

            $post = Auth::user()->posts()->create($request->except(['image', '_token']));

            // Utils => ImageManger
            ImageManger::uploadImage($request, $post);

            Cache::forget('read_more_posts'); // Clear cache for Read More posts
            Cache::forget('latest_posts'); // Clear cache for latest posts


            DB::commit(); //لو كله تمام، خزّن التغييرات
        } catch (\Exception $e) {
            DB::rollBack(); //لو حصل خطأ، ارجع كل التغييرات
            return redirect()->back()->with('error', 'Something went wrong: ');
        }

        return redirect()->back()->with('success', 'Post created successfully');
    }
    // =======================================================================================

    // Delete the posts
    public function deletePost($id)
    {
        $post = Post::findOrFail($id);
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        ImageManger::deleteImage($post);
        $post->delete();

        return redirect()->back()->with('success', 'Post deleted successfully');
    }
    // =====================================================================================

    // Edit the posts
    public function showEditPost($slug)
    {
        $post = Post::with('images')->whereSlug($slug)->firstOrFail();

        if ($post->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('frontend.dashboard.edit-post', compact('post'));
    }
    // =====================================================================================


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
    // Update the posts
    public function updatePost(PostRequest $request, $id)
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


        return redirect()->route('frontend.dashboard.profile')->with('success', 'Post updated successfully');
    }
}
