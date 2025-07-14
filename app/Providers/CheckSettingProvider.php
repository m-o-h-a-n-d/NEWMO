<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

class CheckSettingProvider extends ServiceProvider
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
        $setting = Setting::firstOr(function () {
            return Setting::create([
                'side_name' => "news",
                'logo' => '/public/assets/img/logo.png',
                'favicon' => '/img/avatar5.png',
                'email' => 'news@gmail.com',
                'facebook' => 'facebook.com',
                'twitter' => 'https://twitter.com',
                'instagram' => 'https://instagram.com',
                'linkedin' => 'https://linkedin.com',
                'youtube' => 'https://youtube.com',
                'street' => 'Abo Elhol',
                'city' => 'pyramids',
                'country' => 'Egypt',
                'phone' => '01150949593',

            ]);
        });


        $setting->whatsapp= 'https://wa.me/'.'2'.$setting->phone;
        view()->share([ //helper function
            'Settings' => $setting,
        ]);
    }
}
