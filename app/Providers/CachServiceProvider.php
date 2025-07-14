<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\RelatedNewsSites;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class CachServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Read More POsts
        if (!Cache::has('read_more_posts')) { // is used in List of read more posts in index.php
            $read_more_posts = Post::active()->select('id', 'title', 'slug')->latest()->limit(10)->get();


            Cache::remember('read_more_posts', 3600, function () use ($read_more_posts) {
                return $read_more_posts;
            });
        }

        // Latest Posts
        if (!Cache::has('latest_posts')) {
            $latest_posts = Post::active()->select('id', 'title', 'slug')->latest()->limit(5)->get(); //to get Latest from cache to SingleNews
            Cache::remember('latest_posts', 3600, function () use ($latest_posts) {
                return $latest_posts;
            });
        }


        // Popular posts
        if (!Cache::has('popular')) {
            $popular = Post::active()->withCount('comments')->orderBy('comments_count', 'desc')->limit(3)->get();
            Cache::remember('popular', 3600, function () use ($popular) {
                return $popular;
            });
        }
        $popular = Cache::get('popular'); // popular posts=> the most comments
        $latest_posts = Cache::get('latest_posts'); // latest posts => the most recent
        $read_more_posts = Cache::get('read_more_posts'); // read more posts => the most recent

        view()->share([ //helper function
            'read_more_posts' => $read_more_posts,
            'latest_posts' => $latest_posts,
            'popular' => $popular,


        ]);
    }
}
