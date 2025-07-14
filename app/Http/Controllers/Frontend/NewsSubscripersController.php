<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\NewSubscribtionMail;
use App\Models\NewsSubscripers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as RoutingController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class NewsSubscripersController  extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) // هنا استخدمت Request عشان فيه Form
    {
        $request->validate([
            'email' => ['required', 'email', 'unique:news_subscripers'], // انت بتسال هل  الاrequest الي جي ده فيه email مطابق للشروط دي  (require, من النوع email , unique في جدول المذكور)
        ]);

        $subscriber = NewsSubscripers::create([ // لو الشرط ده اتحقق خذنلي  البيانات دي في model  ده وقيمه email هجبها من requrdt->email
            'email' => $request->email,
        ]);

        // طب في حاله انا عملت الاشتراك
        if ($subscriber) {
            Mail::to($request->email)->send(new NewSubscribtionMail /*  انا هنا بأخذ نسخه من model وببعتله الdata   */);    //instanse of class
            Session::flash('success', 'Email saved successfully.'); // بخذن في Session Flasher او Auth
            return redirect()->route('frontend.home');
        }
        Session::flash('error', 'Failed to save email.');
        return redirect()->route('frontend.home');
    }
    /**
     * Display the specified resource.
     */
    public function show(NewsSubscripers $newsSubscripers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NewsSubscripers $newsSubscripers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NewsSubscripers $newsSubscripers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewsSubscripers $newsSubscripers)
    {
        //
    }
}
