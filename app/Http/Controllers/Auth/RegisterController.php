<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'nim' => 'required|numeric|digits:12|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $nim = $request->nim;

        // 1. Validasi Angka Pertama (Harus 3)
        if (substr($nim, 0, 1) !== "3") {
            return back()->withErrors(['nim' => 'NIM tidak valid (Harus diawali angka 3)'])->withInput();
        }

        // 2. Validasi Kode Prodi (Karakter ke 6-9 harus 0402)
        $kodeProdi = substr($nim, 5, 4);
        if ($kodeProdi !== "0402") {
            return back()->withErrors(['nim' => 'Akses ditolak! Anda bukan mahasiswa Teknik Elektro.'])->withInput();
        }

        // 3. Hitung Cohort (Karakter ke 2-5 adalah Tahun)
        // Rumus: Tahun 2025 = Cohort 6. Berarti (Tahun - 2019)
        $tahun = (int) substr($nim, 1, 4);
        $cohort = $tahun - 2019;

        // Simpan Data
        User::create([
            'name' => $request->name,
            'gender' => $request->gender,
            'nim' => $nim,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'cohort' => $cohort,
            'role' => 'mahasiswa',
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login menggunakan akun Anda.');
    }
}