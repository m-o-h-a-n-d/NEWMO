<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards; // If no guards are provided, use the default guard (usually 'web')

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) { // Check if the user is authenticated
                if($guard=='admin'){
                    return redirect(RouteServiceProvider::AdminHome);
                }
                return redirect(RouteServiceProvider::HOME); // redirect to this route
            }
        }

        return $next($request);
    }
}
