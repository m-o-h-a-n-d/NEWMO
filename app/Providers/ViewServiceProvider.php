<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\Models\RelatedNewsSites;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
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


        $categories = Category::category_active()->withCount('posts')->orderBy('posts_count','desc')->get(); // to get categories to SingleNews
       view()->share([
        'categories' => $categories,
        'related_sites' => RelatedNewsSites::all(), // is used in useful Links in footer
       ]);
    }
}
