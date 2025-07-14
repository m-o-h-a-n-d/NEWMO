<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\NumberOfView;
use App\Models\Post;
use App\Notifications\NewCommentNotify;
use Illuminate\Http\Request;

class SingleNewsController extends Controller
{
    public function show($slug)
    {
        $SinglePost = Post::active()
            ->whereSlug($slug)
            ->with([
                'images',
                'comments' => function ($query) {
                    $query->comment_active()->latest()->limit(3);
                },
                'category.posts' // نخلي الكاتيجوري يجي مع البوستات بتاعته
            ])
            ->whereHas('category', function ($q) {
                $q->where('status', 1);
            })
            ->firstOrFail(); // لو مفيش بوست نشط أو الكاتيجوري مش نشط → يرجع 404


        // Number of views tracking
        if (auth()->check()) {
            NumberOfView::firstOrCreate([
                'post_id' => $SinglePost->id,
                'user_id' => auth()->id(),
            ], [
                'ip_address' => request()->ip()
            ]);
        } else {
            NumberOfView::firstOrCreate([
                'post_id' => $SinglePost->id,
                'ip_address' => request()->ip()
            ]);
        }
        // 👇 Mark the notification as read (if notify query is sent)
        if (auth()->check() && request()->has('notify')) { //?notify={{ $notify->id }} دي اللي بتضيف باراميتر اسمه notify في نهاية

            // علشان لما المستخدم يضغط على الإشعار:

            // نعرف بالضبط أي إشعار ضغط عليه.

            // نعلّمه كمقروء في قاعدة البيانات باستخدام: => notify

            $notification = auth()->user()
                ->unreadNotifications()
                ->where('id', request('notify'))
                ->first();

            if ($notification) {
                $notification->markAsRead();
            }
        }

        $post_belong_to_category = $SinglePost->category;

        return view('frontend.singleNews', compact('SinglePost', 'post_belong_to_category'));
    }

    public function getAllComments($slug)
    {
        $post = Post::active()->whereSlug($slug)->first();

        if (!$post) {
            return response()->json([
                'message' => 'Post not found or inactive',
                'status' => 404,
            ]);
        }

        $comments = $post->comments()
            ->comment_active()
            ->latest()
            ->with(['user'])
            ->get()
            ->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'comment' => $comment->comment,
                    'user' => [
                        'id' => $comment->user->id,
                        'username' => $comment->user->username,
                        'image_url' => $comment->user->image_url, // 💡 هنا الأساس
                    ],
                ];
            });

        return response()->json([
            'status' => 200,
            'comments' => $comments,
        ]);
    }

    public function postAllComments(Request $request)
    {
        $request->validate([
            'comment' => ['required', 'string', 'max:200'],
            'post_id' => ['required', 'exists:posts,id'],
        ]);

        $key = [
            'comment' => strip_tags($request->comment),
            'post_id' => $request->post_id,
            'user_id' => auth()->id(),
            'ip_address' => $request->ip(),

        ];

        // Notifications

        $comment = Comment::create($key);
        $comment->load('user');

        $post = Post::findOrFail($request->post_id);
        $postOwner = $post->user;
        $commenter = $comment->user;

        if ($postOwner && $postOwner->id !== $commenter->id) { // لو مكانش الي كاتب الكومينت هو هو الي عمل المنشور نفذلي ده

            $postOwner->notify(new NewCommentNotify($post, $comment, $commenter, $postOwner));
            //"ابعت إشعار لصاحب البوست، باستخدام إشعار من نوع NewCommentNotify، مع تمرير بيانات البوست، والكومنت، والشخص اللي علّق، وصاحب البوست نفسه."
        }



        $commentData = [
            'id' => $comment->id,
            'comment' => $comment->comment,
            'user' => [
                'id' => $comment->user->id,
                'username' => $comment->user->username,
                'image_url' => $comment->user->image_url,
            ],
        ];

        return response()->json([
            'message' => 'Comment stored successfully',
            'comment' => $commentData,
            'status' => 201,
        ]);
    }
}
