<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthLogoutMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (!session()->has('last_activity')) {
                session()->put('last_activity', now());
            }

            $inactiveLimit = 60 * 60;
            $lastActivity = session('last_activity');
            if ($lastActivity && now()->diffInSeconds($lastActivity) > $inactiveLimit) {
                Auth::logout();
                session()->forget('last_activity');
                return redirect('/login')->with('error', 'Session expired. Please login again.');
            }

            session()->put('last_activity', now());
        }

        return $next($request);
    }
}
