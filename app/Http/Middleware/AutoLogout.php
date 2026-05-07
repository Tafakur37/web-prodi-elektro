<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AutoLogout
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $lastActivity = session('lastActivityTime');
            $timeout = config('session.lifetime') * 60; // Convert minutes to seconds

            if ($lastActivity && (time() - $lastActivity > $timeout)) {
                Auth::logout();
                session()->invalidate();
                session()->regenerateToken();

                return redirect()->route('login')->with('error', 'Sesi Anda telah berakhir karena tidak ada aktivitas.');
            }

            // Exclude AJAX polling requests from extending the session
            if (!$request->routeIs('notifications.fetch') && !$request->routeIs('session.keep-alive')) {
                session(['lastActivityTime' => time()]);
            }
        }

        return $next($request);
    }
}
