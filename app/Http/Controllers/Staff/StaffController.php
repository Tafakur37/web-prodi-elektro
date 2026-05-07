<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Document;
use App\Models\Schedule; // <--- PASTIKAN BARIS INI ADA
use App\Models\Announcement;
use Carbon\Carbon;

class StaffController extends Controller
{
    public function index()
    {
        // 1. Menghitung total mahasiswa
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();
        
        // 2. Menghitung surat/dokumen masuk yang statusnya pending
        $suratMasukCount = Document::where('status', 'pending')->count();
        
        // 3. Mendapatkan nama hari ini dalam bahasa Indonesia
        $hariIni = Carbon::now()->translatedFormat('l'); 
        
        // 4. MENGATASI ERROR: Mendefinisikan $jadwalHariIniCount
        // Menghitung berapa banyak jadwal kuliah pada hari ini
        $jadwalHariIniCount = Schedule::where('day', $hariIni)->count();

        // 5. Mengambil daftar antrian verifikasi dokumen
        $antrianVerifikasi = Document::with('user')
                                    ->where('status', 'pending')
                                    ->orderBy('created_at', 'asc')
                                    ->get();

        // 6. Mengambil riwayat pengumuman
        $riwayatPengumuman = Announcement::orderBy('created_at', 'desc')->get();

        // Kirimkan semua variabel ke view
        return view('staff.dashboard', compact(
            'totalMahasiswa', 
            'suratMasukCount', 
            'jadwalHariIniCount', // Variabel ini sekarang sudah ada
            'antrianVerifikasi',
            'riwayatPengumuman'
        ));
    }
    
    public function profile()
{
    return view('staff.profile'); // Pastikan file resources/views/staff/profile.blade.php ada
}

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Update data user
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('staff.profile')->with('success', 'Profil berhasil diperbarui!');
    }

    public function accountManagement()
{
    // 1. Ambil data Mahasiswa (sesuai perbaikan sebelumnya)
    $mahasiswa = User::where('role', 'mahasiswa')
                ->orderBy('name', 'asc')
                ->paginate(10);

    // 2. MENGATASI ERROR: Ambil data pengguna selain mahasiswa
    // Misalnya untuk tabel "Dosen/Staff Lainnya" di halaman yang sama
    $others = User::whereIn('role', ['dosen', 'admin', 'sesprodi', 'kaprodi'])
                ->orderBy('role', 'asc')
                ->get();

    // 3. Kirimkan kedua variabel ke view
    return view('staff.accounts.index', compact('mahasiswa', 'others'));
}
    
    public function destroy(User $user)
    {
        // Pastikan hanya bisa menghapus mahasiswa
        if ($user->role === 'mahasiswa') {
            $user->delete();
            return redirect()->route('staff.accounts.index')->with('success', 'Akun mahasiswa berhasil dihapus!');
        }

        return redirect()->route('staff.accounts.index')->with('error', 'Hanya akun mahasiswa yang dapat dihapus!');
    }

        
              
}