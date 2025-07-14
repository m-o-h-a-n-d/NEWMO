<?php

namespace App\Http\Controllers\Admin\Auth\Password;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends Controller
{
    public function showReset($email)
    {
        return view('admin.auth.passwords.reset', ['email' => $email]);
    }
    public function sendReset(Request $request)
    {

        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
        ]);
        $admin = Admin::where('email', $request->email)->first();
        if (!$admin) {
            return redirect()->back()->with('error', 'Try Again later!');
        }
        $admin->update([
            'password' => bcrypt($request->password),
        ]);
        return redirect()->route('admin.login.show')->with('success', 'the password is Updated ');
    }
}
