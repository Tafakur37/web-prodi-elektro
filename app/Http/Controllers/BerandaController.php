<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BerandaController extends Controller
{
    public function index()
    {
        // JIKA MAU: Otomatis lempar ke dashboard kalau sudah login
        if (Auth::check()) {
            return redirect()->route('home');
        }

        // Tampilkan halaman landing page (pastikan file ini ada di resources/views/beranda.blade.php)
        return view('beranda');
    }
}