<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function index(Request $request)
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

        // Untuk dropdown filter jabatan fungsional
        $jabatanOptions = User::where('role', 'dosen')
            ->whereNotNull('jabatan_fungsional')
            ->distinct()
            ->orderBy('jabatan_fungsional')
            ->pluck('jabatan_fungsional');

        return view('staff.dosen.index', compact('dosen', 'jabatanOptions'));
    }

    public function update(Request $request, User $dosen)
    {
        if ($dosen->role !== 'dosen') {
            abort(403, 'Akses ditolak. Bukan akun dosen.');
        }

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
}
