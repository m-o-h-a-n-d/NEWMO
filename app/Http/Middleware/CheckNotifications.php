<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckNotifications
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if ($request->query('notify_admin')) {

                $notification = auth()->guard('admin')->user()
                    ->unreadNotifications()
                    ->where('id', request('notify_admin'))
                    ->first();

                if ($notification) {
                    $notification->markAsRead();
                }

        }
        return $next($request);
    }
}
