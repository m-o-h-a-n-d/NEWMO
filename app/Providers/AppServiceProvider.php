<?php

namespace App\Providers;

use App\Models\RelatedNewsSites;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap(); // Use Bootstrap pagination

        \Carbon\Carbon::setLocale('en'); // Set Carbon locale to English to display dates in English
       



        // related sites

    }
}
