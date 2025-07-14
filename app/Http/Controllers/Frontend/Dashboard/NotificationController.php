<?php

namespace App\Http\Controllers\Frontend\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class NotificationController extends Controller
{
    public function index()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return view('frontend.dashboard.notification');
    }
    public function deleteNotification($id = null)
    {
        $notifications = auth()->user()->notifications();

        if ($id) {
            // حذف إشعار محدد
            $notifications->where('id', $id)->delete();
            $msg = 'Notification deleted successfully.';
        } else {
            // حذف كل الإشعارات
            $notifications->delete();
            $msg = 'All notifications deleted successfully.';
        }

        return redirect()->back()->with('success', $msg);
    }

    // Read All Notifications
    public function markAsRead(){
        auth()->user()-> unreadNotifications-> markAsRead();

        return redirect()->back();

    }
}
