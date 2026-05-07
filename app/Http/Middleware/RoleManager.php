<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class RoleManager
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        // 2. Admin = Super Role → akses semua fitur tanpa batasan
        if ($userRole === 'admin') {
            return $next($request);
        }

        // 3. Cek apakah role user ada dalam daftar yang diizinkan
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        $dashboardRoute = "{$userRole}.dashboard";

        if (Route::has($dashboardRoute)) {
            return redirect()->route($dashboardRoute);
        }

        return redirect('/');
    }
}
