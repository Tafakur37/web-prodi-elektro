<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
    /**
     * Menampilkan form login
     */
    public function showLoginForm() 
    {
        // Jika sudah login, jangan kasih lihat form login, lempar ke beranda/dashboard
        if (Auth::check()) {
            return redirect()->route('beranda');
        }
        return view('auth.login');
    }

    /**
     * Proses Login
     */
    public function login(Request $request)
    {
        $request->validate([
            'nim'      => ['required', 'string'],
            'password' => ['required'],
        ]);

        // Determine if the input is an email or NIM/Username
        $loginField = filter_var($request->nim, FILTER_VALIDATE_EMAIL) ? 'email' : 'nim';

        $credentials = [
            $loginField => $request->nim,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $request->session()->flash('just_logged_in', true);

            // AMBIL DATA USER YANG BARU LOGIN
            $user = Auth::user();
            app(\App\Services\ActivityLoggerService::class)->log('login', 'Auth', 'User logged in', $user->id);

            $dashboardRoute = "{$user->role}.dashboard";
            if (Route::has($dashboardRoute)) {
                return redirect()->route($dashboardRoute);
            }

            // Jika role tidak dikenal, lempar ke beranda
            return redirect()->route('beranda');
        }

        // Jika login gagal
        return back()->withErrors([
            'nim' => 'NIM/Email atau password salah.',
        ])->onlyInput('nim');
    }

    /**
     * Proses Logout
     */
    public function logout(Request $request)
    {
        if (Auth::check()) {
            app(\App\Services\ActivityLoggerService::class)->log('logout', 'Auth', 'User logged out');
        }
        Auth::logout();
        
        // Hancurkan session agar benar-benar bersih
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Kembali ke landing page murni (/)
        return redirect()->route('beranda');
    }
}
