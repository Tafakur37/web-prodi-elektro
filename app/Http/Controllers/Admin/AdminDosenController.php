<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * AdminDosenController
 * Admin adalah role inti — memiliki akses penuh ke semua data dosen dan mahasiswa.
 * Staff hanya memanggil kontroller yang sama melalui route-nya masing-masing.
 */
class AdminDosenController extends Controller
{
    // ─────────────────────────────────────────────────────────────────────────
    //  DATA DOSEN
    // ─────────────────────────────────────────────────────────────────────────

    public function dosenIndex(Request $request)
    {
        $query = User::where('role', 'dosen');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name',  'like', "%{$search}%")
                  ->orWhere('nip',   'like', "%{$search}%")
                  ->orWhere('nuptk', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status_pegawai')) {
            $query->where('status_pegawai', $request->status_pegawai);
        }

        if ($request->filled('jabatan_fungsional')) {
            $query->where('jabatan_fungsional', $request->jabatan_fungsional);
        }

        $dosen = $query->orderBy('name', 'asc')->paginate(15)->withQueryString();

        $jabatanOptions = User::where('role', 'dosen')
            ->whereNotNull('jabatan_fungsional')
            ->distinct()->orderBy('jabatan_fungsional')
            ->pluck('jabatan_fungsional');

        // Gunakan view yang sama dengan staff — view sudah role-aware
        return view('staff.dosen.index', compact('dosen', 'jabatanOptions'));
    }

    public function dosenUpdate(Request $request, User $dosen)
    {
        abort_if($dosen->role !== 'dosen', 403, 'Bukan akun dosen.');

        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'nuptk'               => 'nullable|string|max:20',
            'nip'                 => 'nullable|string|max:25',
            'gender'              => 'nullable|in:L,P',
            'tanggal_lahir'       => 'nullable|date',
            'status_pegawai'      => 'nullable|in:PNS,PPPK,CPNS,Honor',
            'status_keaktifan'    => 'nullable|in:Aktif,Tidak Aktif',
            'pangkat_terakhir'    => 'nullable|string|max:100',
            'golongan_terakhir'   => 'nullable|string|max:10',
            'tmt_pangkat'         => 'nullable|date',
            'jabatan_fungsional'  => 'nullable|string|max:100',
            'tmt_jabfung'         => 'nullable|date',
            'sertifikasi_dosen'   => 'nullable|in:Sertifikasi Dosen,Belum Sertifikasi Dosen',
            'tahun_serdos'        => 'nullable|integer|min:1990|max:2099',
            'masa_kerja_golongan' => 'nullable|integer|min:0|max:99',
        ]);

        $dosen->update($validated);

        return back()->with('success', "Data dosen {$dosen->name} berhasil diperbarui.");
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  DATA MAHASISWA (2-step: cohort → tabel)
    // ─────────────────────────────────────────────────────────────────────────

    public function studentsIndex(Request $request)
    {
        $availableCohorts = User::where('role', 'mahasiswa')
            ->whereNotNull('cohort')
            ->distinct()->orderBy('cohort', 'asc')
            ->pluck('cohort');

        // Step 1: pilih cohort
        if (!$request->filled('cohort')) {
            $cohortStats = [];
            foreach ($availableCohorts as $cohort) {
                $cohortStats[$cohort] = User::where('role', 'mahasiswa')
                    ->where('cohort', $cohort)->count();
            }
            return view('staff.students.cohort', compact('availableCohorts', 'cohortStats'));
        }

        // Step 2: tabel mahasiswa per cohort
        $selectedCohort = $request->cohort;
        $query = User::where('role', 'mahasiswa')->where('cohort', $selectedCohort);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nim',  'like', "%{$search}%");
            });
        }

        $students = $query->orderBy('name', 'asc')->paginate(20)->withQueryString();

        return view('staff.students.index', compact('students', 'availableCohorts', 'selectedCohort'));
    }

    public function studentsUpdate(Request $request, User $student)
    {
        abort_if($student->role !== 'mahasiswa', 403, 'Bukan akun mahasiswa.');

        $request->validate([
            'name'             => 'required|string|max:255',
            'nim'              => 'required|unique:users,nim,' . $student->id,
            'cohort'           => 'nullable|integer',
            'gender'           => 'nullable|in:L,P',
            'status_keaktifan' => 'nullable|in:Aktif,Tidak Aktif',
        ]);

        $student->update([
            'name'             => $request->name,
            'nim'              => $request->nim,
            'cohort'           => $request->cohort,
            'gender'           => $request->gender,
            'status_keaktifan' => $request->status_keaktifan,
        ]);

        return back()->with('success', "Data mahasiswa {$student->name} berhasil diperbarui!");
    }

    public function studentsResetPassword(Request $request, User $student)
    {
        abort_if($student->role !== 'mahasiswa', 403, 'Bukan akun mahasiswa.');

        $request->validate(['password' => 'required|min:6|confirmed']);

        $student->update(['password' => Hash::make($request->password)]);

        return back()->with('success', "Password {$student->name} berhasil direset!");
    }
}
