<?php

use App\Models\Autharization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Posts\PostController;
use App\Http\Controllers\Admin\Users\UserController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\Contact\ContactController;
use App\Http\Controllers\Admin\Settings\SettingController;
use App\Http\Controllers\Admin\AdminManege\AdminController;
use App\Http\Controllers\Admin\Categories\CategoryController;
use App\Http\Controllers\Admin\Profile\ProfileAdminController;
use App\Http\Controllers\Admin\Autharizations\AutharizeConroller;
use App\Http\Controllers\Admin\Notifications\NotificationController;
use App\Http\Controllers\Admin\Auth\Password\ResetPasswordController;
use App\Http\Controllers\Admin\Auth\Password\ForgetPasswordController;

use App\Http\Controllers\Admin\Mails\MailController;

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


// Block Page
Route::get('/admin/block', function () {
    return view('admin.block');
})->middleware(['auth:admin'])->name('admin.block');

// auth route
Route::prefix('admin')->as('admin.')->middleware(['blockAdmin'])->group(
    function () {
        //Admin Home

        Route::get('/', AdminDashboardController::class)->middleware(['auth:admin'])->name('home');


        // ********************************* Login Admin****************************
        Route::controller(LoginController::class)->group(function () {
            Route::name('login.')->prefix('login')->group(function () {
                Route::get('/', 'showLogin')->name('show');
                Route::post('/check', 'checkLogin')->name('check');
            });
            // ********************************* Logout Admin****************************
            Route::post('/logout', 'AdminLogout')->name('logout');
        });
        // ====================================================================================
        // ********************************* Passwords Admin****************************
        Route::group(['as' => 'password.'], function () {
            // Forget Password
            Route::controller(ForgetPasswordController::class)->prefix('email')->group(function () {
                Route::get('/', 'showEmail')->name('showEmail');
                Route::post('/send', 'sendEmail')->name('sendEmail');
                Route::get('/OTP/{email}', 'ShowOtpForm')->name('ShowOtpForm');
                Route::post('/OTP/Verify', 'VerifyOTP')->name('VerifyOTP');
            });
            // ===========================
            // Reset Password
            Route::controller(ResetPasswordController::class)->prefix('reset')->group(function () {
                Route::get('/{email}', 'showReset')->name('showReset');
                Route::post('/send', 'sendReset')->name('sendReset');
            });
        });
        // ====================================================================================

        // ********************************* Sidebar Admin****************************
        Route::middleware(['auth:admin'])->group(function () {

            Route::resource('mails', MailController::class);
            //************************** Users****************************
            Route::controller(UserController::class)->group(function () {
                Route::resource('users', UserController::class);
                Route::get('/users/block/{id}',  'BlockUser')->name('users.BlockUser');
            });
            //************************** Categories****************************
            Route::controller(CategoryController::class)->group(function () {
                Route::resource('categories', CategoryController::class);
                Route::get('/categories/block/{id}', 'BlockCategory')->name('categories.BlockCategory');
            });

            //************************** Posts****************************
            Route::controller(PostController::class)->group(function () {

                Route::resource('posts', PostController::class);
                Route::get('/posts/block/{id}', 'BlockPost')->name('posts.BlockPost');
                // Delete Image Of Posts
                Route::Post('/image/delete/{id}', 'EditImagePost')->name('posts.EditImagePost');
                Route::delete('/delete/comment/{id}', 'deleteComment')->name('posts.deleteComment');
            });

            //************************** Settings****************************
            Route::resource('settings', SettingController::class);

            //************************** Admins****************************

            Route::controller(AdminController::class)->group(function () {
                Route::resource('admins', AdminController::class);
                Route::get('/admins/block/{id}', 'BlockAdmin')->name('admins.BlockAdmin');
            });

            //************************** Authorizations****************************
            Route::controller(AutharizeConroller::class)->group(function () {
                Route::resource('authorize', AutharizeConroller::class);
            });


            //************************** Contacts****************************

            Route::controller(ContactController::class)->middleware(['markNotificationAdmin'])->group(function () {
                Route::resource('contacts', ContactController::class);
            });
            //************************** Profile Admins****************************
            Route::prefix('profile')->name('profile.')->controller(ProfileAdminController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                // إرسال كود OTP بعد تأكيد كلمة السر
                Route::post('/send-otp', 'sendOtp')->name('send-otp');


                // عرض فورم إدخال الكود
                Route::get('/verify-otp', 'showVerifyOtpForm')->name('verify-otp-form');

                // تحقق الكود
                Route::post('/verify-otp', 'verifyOtp')->name('verify-otp');

                //شكل profile
                Route::get('/show/{id}', 'profile')->name('profile');
            });
            //************************** Notifications****************************
            Route::controller(NotificationController::class)->prefix('notifications')->name('notifications.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::delete('/read',  'clear')->name('markAsRead');
            });
            // ****************************************Search**********************************

            Route::match(['post', 'get'], '/search-redirect', [SearchController::class, 'redirectToSearchTable'])->name('search.redirect');
        });
    }
);
