<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ContactRequest;
use App\Models\Admin;
use App\Models\Contact;
use App\Notifications\NewContactNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact');
    }
    public function store(ContactRequest $request)
    {
        $request->validated(); // بيتأكد ان كل البيانات الي احنا ادخلناها صحيحه

        // js تنظيف كل البيانات من الهجمات
        $cleaned = array_map('strip_tags', $request->all());



        // إضافة عنوان الـ IP
        $cleaned['ip_address'] = $request->ip();
        $cleaned['status'] = 0;



        // إنشاء السجل في قاعدة البيانات
        $contact = Contact::create($cleaned);
        // فلاش رسائل الجلسة


        $admins = Admin::get();
        Notification::send($admins, new NewContactNotify($contact));
        if (!$contact) {
            Session::flash('error', 'The contact is not done');
        } else {
            Session::flash('success', 'The contact is done');
        }

        return redirect()->back();
    }
}
