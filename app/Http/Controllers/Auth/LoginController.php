<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Frontend\Controller as FrontendController;

// use Illuminate\Http\Client\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout'); // يعني انا هظبق middleware guest على كل method معدا logout
        $this->middleware('auth')->only('logout');
    }


    protected function loggedOut(Request $request)
    {

        Session::flash('success', 'Yoe be Loged out');
        return redirect()->route('frontend.home');
    }
    protected function authenticated(Request $request, $user)
    {
        Session::flash('success', 'you Login successfully');
        return redirect()->intended(RouteServiceProvider::HOME);
    }
    public function logout(Request $request)
    {
        $this->guard()->logout();
        if ($response = $this->loggedOut($request)) {
            return $response;
        }
        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }
}
