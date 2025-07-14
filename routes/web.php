<?php

use App\Models\Category;
use App\Models\NewsSubscripers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\SingleNewsController;
use App\Http\Controllers\Frontend\NewsSubscripersController;
use App\Http\Controllers\Frontend\Dashboard\ProfileController;
use App\Http\Controllers\Frontend\Dashboard\SettingController;
use App\Http\Controllers\Frontend\Dashboard\NotificationController;
use App\Http\Controllers\HomeController as ControllersHomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes(
    [
        'verify' => true,
    ]
);

Route::redirect('/', '/home');

Route::group(
    [
        'as' => 'frontend.', // prefix the name is (as) (Attribute, Routs)

    ],
    function () {

        // Home Page Route
        Route::get('/home', [HomeController::class, 'index'])->name('home');

        // New Subscriber Controller  Email in index page Route
        Route::post('news_subscribe', [NewsSubscripersController::class, 'store'])->name('news.subscribe');

        // Category Route
        Route::get('category/{slug}', CategoryController::class)->name('category.posts');

        // Single News  oR Details of Post Route
        Route::controller(SingleNewsController::class)->name('single.')->middleware(['auth:web', 'verified', 'blockUser'])->prefix('post')->group(function () {

            Route::get('/{slug}', 'show')->name('posts');
            Route::get('/comments/{slug}', 'getAllComments')->name('post.comments');
            Route::post('/comments/store', 'postAllComments')->name('comments.store');
        });

        //  Contact Us Route
        Route::controller(ContactController::class)->name('contact.')->prefix('contact')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::get('/store', function () {
                abort(404);
            });
        });

        // Block Page
        Route::group([
            'as' => 'block',
        ], function () {
            Route::get('/block', function () {
                return view('frontend.block');
            });
        });

        // Dashboard

        Route::prefix('/account')->name('dashboard.')->middleware(['auth:web', 'verified', 'blockUser'])->group(function () { // web is Guard ,option to select:web
            // Route Profile Management ProfileController
            Route::controller(ProfileController::class)->group(function () {
                // To prevent direct access to delete route

                Route::get('/', 'index')->name('profile');

                // Store Post
                Route::post('/store', 'store')->name('post.store');
                Route::get('/store', function () {
                    abort(404);
                });
                // Edit Post
                Route::get('/edit/{slug}', 'showEditPost')->name('post.edit');
                Route::patch('/edit/{id}', 'updatePost')->name('post.update');
                Route::get('/edit/{id}', function () {
                    abort(404);
                });

                // Delete Image Of Posts

                Route::Post('/image/delete/{id}', 'EditImagePost')->name('post.image.delete');



                // DELETE Post
                Route::delete('/delete/{id}', 'deletePost')->name('post.delete');
                Route::get('/delete/{id}', function () {
                    abort(404);
                });
            });
            // =========================================================================================================================
            // Route of Setting Controller
            Route::controller(SettingController::class)->prefix('setting')->group(function () {
                // To show settings page Data
                Route::get('/', 'index')->name('setting');
                // Store Post
                Route::patch('/update', 'update')->name('setting.update');
                Route::get('/update', function () {
                    abort(404);
                });
                Route::patch('/change-password', 'changePassword')->name('setting.changePassword');
                Route::get('/change-password', function () {
                    abort(404);
                });
            });
            // ===================================================================================================================================
            // Route of Notification Controller
            Route::controller(NotificationController::class)->prefix('notification')->group(function () {
                Route::get('/', 'index')->name('notification');
                Route::get('/mark-as-read', 'markAsRead')->name('notification.mark');
                Route::delete('/delete/{id?}', 'deleteNotification')->name('notification.delete');
            });
        });




        // Search Controller Route
        Route::match(['get', 'post'], 'Search', SearchController::class)->name('search'); // match support get and post
    }



);

// *********************************************** Social Auth Routes***************************************
Route::get('auth/{provider}', [SocialLoginController::class, 'redirect'])->name('social.redirect');
Route::get('auth/{provider}/callback', [SocialLoginController::class, 'callback'])->name('social.callback');
