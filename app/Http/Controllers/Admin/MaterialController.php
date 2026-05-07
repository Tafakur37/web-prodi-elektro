<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Services\MaterialService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MaterialController extends Controller
{
    public function __construct(private MaterialService $materialService) {}

    public function index(Request $request)
    {
        try {
            // 1. Jika ada parameter ?cohort= di URL
            if ($request->has('cohort')) {
                $selectedCohort = $request->cohort;
                $materials = $this->materialService->getAll($request->cohort);
                return view('admin.materials.list', compact('materials', 'selectedCohort'));
            }

            // 2. Tampilan awal (pilih angkatan)
            $availableCohorts = $this->materialService->getAvailableCohorts();
            return view('admin.materials.select_cohort', compact('availableCohorts'));
        } catch (\Throwable $exception) {
            Log::error('Admin materials failed: ' . $exception->getMessage(), ['exception' => $exception]);

            return view('admin.materials.select_cohort', [
                'availableCohorts' => collect(),
            ])->with('error', 'Data bahan ajar gagal dimuat.');
        }
    }

    public function create(Request $request)
    {
        $availableCohorts = $this->materialService->getAvailableCohorts();
        return view('admin.materials.create', compact('availableCohorts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'cohort' => 'required|integer',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx|max:10240',
            'target_role' => 'required|in:mahasiswa,dosen,staff'
        ]);

        try {
            $this->materialService->store($request->all(), $request->file('file'), auth()->id());
        } catch (\Throwable $exception) {
            Log::error('Admin material store failed: ' . $exception->getMessage(), ['exception' => $exception]);

            return back()->withInput()->with('error', 'Materi gagal dipublikasikan.');
        }

        return redirect()->route('admin.materials.index', ['cohort' => $request->cohort])
            ->with('success', 'Materi berhasil dipublikasikan untuk Cohort ' . $request->cohort);
    }

    public function destroy(Material $material)
    {
        try {
            $this->materialService->destroy($material);
            return back()->with('success', 'Materi berhasil dihapus.');
        } catch (\Throwable $exception) {
            Log::error('Admin material delete failed: ' . $exception->getMessage(), ['exception' => $exception]);

            return back()->with('error', 'Materi gagal dihapus.');
        }
    }
}
