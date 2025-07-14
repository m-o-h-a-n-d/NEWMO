<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Autharization;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->only(['showLogin', 'checkLogin']);
        $this->middleware('auth:admin')->only('AdminLogout');
    }
    public function showLogin()
    {

        return  view('admin.auth.login');
    }


    public function checkLogin(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'min:8'],
            'remember' => ['in:on, off']
        ]);



        if (Auth::guard('admin')->attempt(
            ['email' => $request->email, 'password' => $request->password],
            $request->filled('remember')
        )) {


            $permissions = Auth::guard('admin')->user()->authorization->permissions;
            $first_permission = $permissions[0] ?? 'home'; // أو أي صفحة افتراضية
            if (!in_array('home', $permissions)) {
                return redirect()->to('admin/' . $first_permission);
            }
            return redirect()->intended(RouteServiceProvider::AdminHome)
                ->with('success', 'Hello ' . Auth::guard('admin')->user()->name);
        }


        return redirect()->back()->withErrors(['email' => 'These credentials do not match our records.']);
    }
    public function AdminLogout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login.show')->with('success', 'You log out successfully ');
    }
}
