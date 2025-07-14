<?php

namespace App\Http\Controllers\Frontend\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\SettingRequest;
use App\Models\User;
use App\Utils\ImageManger;
use Flasher\Laravel\Http\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('frontend.dashboard.setting', compact('user'));
    }
    public function update(SettingRequest $request)
    {
        $request->validated();
        $user = User::findOrFail(auth()->user()->id);
        $user->update($request->except('image'));

        ImageManger::updateSettingImage($request, $user); // Update Image in Setting Profile


        return redirect()->route('frontend.dashboard.setting')->with('success', 'Your profile has been updated successfully.');
    }

    public function changePassword(HttpRequest $request)
    {
        // 1. التحقق من صحة البيانات داخل validation bag باسم 'password'
        $request->validate($this->filterPasswordRequest());

        // 2. التأكد من أن كلمة المرور الحالية صحيحة
        if (!Hash::check($request->current_password, auth()->user()->password)) {

            return redirect()->back()->with('error', 'The current password is incorrect.')->withErrors([
                'current_password' => 'The current password is incorrect.',
            ]);
        }

        // 3. تحديث كلمة المرور
        $user = User::findOrFail(auth()->user()->id);
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('frontend.dashboard.setting')->with('success', 'Your password has been changed successfully.');
    }


    //  This method is used to filter the password request validation rules.
    public function filterPasswordRequest(): array
    {
        return [
            'current_password' => ['required', 'min:8'],
            'password' => ['required', 'min:8', 'confirmed'],

        ];
    }
}
