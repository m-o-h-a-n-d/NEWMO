<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Models\Admin;
use Ichtrojan\Otp\Otp;
use App\Utils\ImageManger;
use Illuminate\Http\Request;
use App\Models\Autharization;
use App\Http\Controllers\Controller;
use App\Notifications\SendOtpNotify;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileAdminController extends Controller
{
    public $otp2;

    public function __construct()
    {
        $this->otp2 = new Otp;
    }


    //Admin Form
    public function index()
    {
        $admin = auth()->guard('admin')->user();
        return view('admin.profile.index', compact('admin'));
    }

    //Admin Form
    public function profile($id)
    {
        $admin = auth()->guard('admin')->user();
      $authorization = Autharization::select('id', 'role')->first(); // أو Autharization لو ده اسم الموديل الحقيقي
        return view('admin.profile.profile', compact('admin','authorization'));
    }


    public function sendOtp(Request $request)
    {
        $admin = auth('admin')->user();

        $request->validate([
            'name' => 'required|string|max:40',
            'username' => 'required|string|max:40|unique:admins,username,' . $admin->id,
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'password' => 'required|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if (!Hash::check($request->password, $admin->password)) {
            return back()->with('error', 'Password does not match current password');
        }

        // تخزين الصورة مؤقتًا إن وجدت
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('temp');
        }

        // تخزين البيانات في السيشن
        session([
            'profile_update_id' => $admin->id,
            'profile_update_data' => $request->except(['password', 'password_confirmation', 'image', '_token']),
            'profile_update_image_path' => $imagePath,
        ]);

        // إرسال OTP
        $admin->notify(new SendOtpNotify());

        return view('admin.profile.show', compact('admin'));
    }


    // التحقق من الكود وتحديث البيانات
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
        ]);

        $otpCheck = $this->otp2->validate($request->email, $request->token);

        if (!$otpCheck->status) {
            return back()->withErrors(['token' => 'Invalid or expired OTP.']);
        }

        $id = session('profile_update_id');
        $data = session('profile_update_data');
        $imagePath = session('profile_update_image_path');

        $admin = Admin::findOrFail($id);

        // تنفيذ التعديل بعد التحقق من الكود
        $admin->update($data);

        if ($imagePath && Storage::exists($imagePath)) {
            $admin->image = ImageManger::updateAdminImage($imagePath, $admin);
            $admin->save();
            Storage::delete($imagePath); // حذف الصورة المؤقتة
        }

        // حذف البيانات من السيشن
        session()->forget(['profile_update_id', 'profile_update_data', 'profile_update_image_path']);

        return redirect()->route('admin.profile.index')->with('success', 'Profile updated successfully!');
    }
}
