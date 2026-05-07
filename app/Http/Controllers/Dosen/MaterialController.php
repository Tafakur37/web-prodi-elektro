<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Services\MaterialService;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function __construct(private MaterialService $materialService) {}

    public function index()
    {
        $materials = $this->materialService->getByUser(auth()->id());
        return view('dosen.materials.index', compact('materials'));
    }

    public function create()
    {
        $subjects = $this->materialService->getSubjectsForForm();
        $cohorts = $this->materialService->getAvailableCohorts();

        return view('dosen.materials.create', compact('subjects', 'cohorts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cohort' => 'required|string',
            'file' => 'required|file|max:20480',
        ]);

        $this->materialService->store($request->all(), $request->file('file'), auth()->id());

        return redirect()->route('dosen.materials.index')->with('success', 'Bahan ajar berhasil diunggah.');
    }

    public function destroy(Material $material)
    {
        $result = $this->materialService->destroy($material, auth()->id());

        if (!$result) {
            return back()->with('error', 'Akses ditolak.');
        }

        return back()->with('success', 'Bahan ajar berhasil dihapus.');
    }
}
