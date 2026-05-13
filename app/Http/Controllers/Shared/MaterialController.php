<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Helpers\PermissionHelper;
use App\Models\Material;
use App\Services\MaterialService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * =============================================================================
 * SHARED MATERIAL CONTROLLER — SIMelek
 * =============================================================================
 *
 * Menangani fitur Bahan Ajar untuk semua role.
 * - Admin/Staff: bisa upload, hapus, lihat semua
 * - Dosen: bisa upload miliknya, lihat semua, hapus miliknya
 * - Mahasiswa: hanya bisa lihat dan download
 *
 * Route yang menggunakan controller ini:
 *   - admin.materials.*
 *   - dosen.materials.*
 *   - mahasiswa.materials.*
 * =============================================================================
 */
class MaterialController extends Controller
{
    public function __construct(private MaterialService $materialService) {}

    /**
     * Tampilkan daftar bahan ajar (semua role).
     */
    public function index(Request $request)
    {
        PermissionHelper::canOrAbort('materials', 'view_all');

        $role = auth()->user()->role;

        try {
            // Admin: tampilkan dengan filter cohort
            if ($role === 'admin') {
                if ($request->has('cohort')) {
                    $selectedCohort = $request->cohort;
                    $materials = $this->materialService->getAll($request->cohort);
                    return view('admin.materials.list', compact('materials', 'selectedCohort'));
                }
                $availableCohorts = $this->materialService->getAvailableCohorts();
                return view('admin.materials.select_cohort', compact('availableCohorts'));
            }

            // Dosen: lihat materi yang bisa diakses + yang dia upload
            if ($role === 'dosen') {
                $materials = $this->materialService->getForRole('dosen');
                return view('dosen.materials.index', compact('materials'));
            }

            // Mahasiswa: lihat materi sesuai angkatan mereka
            $userCohort = auth()->user()->cohort;
            $materials  = $this->materialService->getForMahasiswa($userCohort);
            return view('mahasiswa.materials.index', compact('materials'));

        } catch (\Throwable $e) {
            Log::error('Material index failed: ' . $e->getMessage(), ['exception' => $e]);

            $view = match($role) {
                'admin'    => 'admin.materials.select_cohort',
                'dosen'    => 'dosen.materials.index',
                default    => 'mahasiswa.materials.index',
            };

            return view($view, ['materials' => collect(), 'availableCohorts' => collect()])
                ->with('error', 'Data bahan ajar gagal dimuat.');
        }
    }

    /**
     * Tampilkan form upload bahan ajar.
     */
    public function create(Request $request)
    {
        PermissionHelper::canOrAbort('materials', 'create');

        $availableCohorts = $this->materialService->getAvailableCohorts();
        $role = auth()->user()->role;

        $view = ($role === 'admin') ? 'admin.materials.create' : 'dosen.materials.create';

        return view($view, compact('availableCohorts'));
    }

    /**
     * Simpan bahan ajar baru.
     */
    public function store(Request $request)
    {
        PermissionHelper::canOrAbort('materials', 'create');

        $request->validate([
            'title'       => 'required|string|max:255',
            'cohort'      => 'required|integer',
            'description' => 'nullable|string',
            'file'        => 'required|file|mimes:pdf,doc,docx,ppt,pptx|max:10240',
            'target_role' => 'required|in:mahasiswa,dosen,staff',
        ]);

        try {
            $this->materialService->store($request->all(), $request->file('file'), auth()->id());
        } catch (\Throwable $e) {
            Log::error('Material store failed: ' . $e->getMessage(), ['exception' => $e]);
            return back()->withInput()->with('error', 'Materi gagal dipublikasikan.');
        }

        $role        = auth()->user()->role;
        $redirectRoute = ($role === 'admin')
            ? route('admin.materials.index', ['cohort' => $request->cohort])
            : route('dosen.materials.index');

        return redirect($redirectRoute)
            ->with('success', 'Materi berhasil dipublikasikan untuk Angkatan ' . $request->cohort);
    }

    /**
     * Tampilkan detail materi (mahasiswa).
     */
    public function show(Material $material)
    {
        PermissionHelper::canOrAbort('materials', 'view_all');

        return view('mahasiswa.materials.show', compact('material'));
    }

    /**
     * Download materi.
     */
    public function download(Material $material)
    {
        PermissionHelper::canOrAbort('materials', 'download');

        return $this->materialService->download($material);
    }

    /**
     * Hapus materi.
     * Dosen hanya bisa hapus miliknya. Admin bisa hapus semua.
     */
    public function destroy(Material $material)
    {
        PermissionHelper::canOrAbort('materials', 'delete');

        $role = auth()->user()->role;

        // Dosen: pastikan hanya hapus materi miliknya
        if ($role === 'dosen' && $material->uploaded_by !== auth()->id()) {
            return back()->with('error', 'Anda hanya bisa menghapus materi yang Anda upload.');
        }

        try {
            $this->materialService->destroy($material);
            return back()->with('success', 'Materi berhasil dihapus.');
        } catch (\Throwable $e) {
            Log::error('Material delete failed: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Materi gagal dihapus.');
        }
    }
}
