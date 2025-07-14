<?php

namespace App\Http\Controllers\Admin\Auth\Password;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\SendOtpNotify;
use Ichtrojan\Otp\Otp;
use Illuminate\Support\Facades\Auth;
use Termwind\Components\Raw;

class ForgetPasswordController extends Controller
{
    public $otp2;
    public function __construct()
    {
        $this->otp2 = new Otp;
    }
    public function showEmail()
    {
        return view('admin.auth.passwords.email');
    }
    public function sendEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],

        ]);
        $admin = Admin::where('email', $request->email)->first();
        if (!$admin) {
            return redirect()->route('admin.password.showEmail')->withErrors(['email' => 'The Email is not found please Try again later !']);
        }
        $admin->notify(new SendOtpNotify());
        return redirect()->route('admin.password.ShowOtpForm', ['email' => $admin->email]);
    }
    public function ShowOtpForm($email)
    {

        return view('admin.auth.passwords.confirm', ['email' => $email]);
    }

    public function VerifyOTP(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'token' => ['required', 'min:6'],
        ]);

        $otp = $this->otp2->validate($request->email, $request->token);

        if($otp->status==false){

            return redirect()->back()->withErrors(['token'=>'Code is  invalid!']);
        }
        return redirect()->route('admin.password.showReset',['email'=>$request->email]);
    }
}
