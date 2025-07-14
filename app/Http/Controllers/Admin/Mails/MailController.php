<?php

namespace App\Http\Controllers\Admin\Mails;

use App\Models\Admin;
use App\Models\Mails;
use Illuminate\Http\Request;
use App\Models\Autharization;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewAdminContactNotification;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentAdmin = Auth::guard('admin')->user();

        $mails = Mails::with('admin')
            ->where('role_id', $currentAdmin->role_id)
            ->latest()
            ->get();

        return view('admin.mails.index', compact('mails'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currentRoleId = Auth::guard('admin')->user()->role_id;

        $authorize = Autharization::select('id', 'role')
            ->where('id', '!=', $currentRoleId)
            ->get();

        return view('admin.mails.create', compact('authorize'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'   => ['required', 'max:250'],
            'role_id' => ['required'],
        ]);

        $admin = Auth::guard('admin')->user();

        $mail = Mails::create([
            'title'    => $request->title,
            'role_id'  => $request->role_id,
            'admin_id' => $admin->id,
            'status'   => 0,
        ]);

        $receivers = Admin::where('role_id', $request->role_id)
            ->where('id', '!=', $admin->id)
            ->get();

        if ($receivers->isNotEmpty()) {
            Notification::send($receivers, new NewAdminContactNotification($admin, $request->title, $mail->id));
        }

        return redirect()->route('admin.mails.index')->with('success', 'Message sent successfully to all admins with this role.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        // تحديد الإشعار من الرابط وتعليمه كمقروء
        $notifId = $request->notify_id ?? $request->admins_con;

        if ($notifId) {
            $notification = auth()->guard('admin')->user()
                ->notifications()
                ->where('id', $notifId)
                ->first();

            if ($notification && $notification->unread()) {
                $notification->markAsRead();
            }
        }

        $mails = Mails::with('admin')->findOrFail($id);
        $mails->update(['status' => 1]);

        return view('admin.mails.show', compact('mails'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mails = Mails::findOrFail($id);

        // حذف الإشعارات المرتبطة بنفس العنوان (لو حابب)
        auth()->guard('admin')->user()
            ->notifications()
            ->where('data->title', $mails->title)
            ->delete();

        $mails->delete();

        return redirect()->route('admin.mails.index')->with('success', 'Message and related notifications deleted.');
    }
}
