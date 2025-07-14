<?php

namespace App\Http\Controllers\Admin\Notifications;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function index()
    {
        // حدد فقط إشعارات الـ "notification" ثم حددها كمقروءة
        auth()->guard('admin')->user()
            ->unreadNotifications
            ->where('data.notification_type', 'notification')
            ->each(function ($notification) {
                $notification->markAsRead();
            });

        $contacts = Contact::select('id', 'status')->get();
        return view('admin.notifications.index', compact('contacts'));
    }

    public function clear()
    {
        $notifications = auth()->guard('admin')->user()
            ->notifications()
            ->where('data->notification_type', 'notification')
            ->get();

        if ($notifications->isEmpty()) {
            return redirect()->back()->with('info', 'There are no notifications to delete.');
        }

        foreach ($notifications as $notification) {
            $notification->delete();
        }

        return redirect()->back()->with('success', 'All notifications have been deleted.');
    }
    
}
