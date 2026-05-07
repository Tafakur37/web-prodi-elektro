<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Services\MaterialService;

class MaterialController extends Controller
{
    public function __construct(private MaterialService $materialService) {}

    public function index()
    {
        $cohort = auth()->user()->cohort;
        $materialsBySubject = $this->materialService->getBySubjectGrouped($cohort);

        return view('mahasiswa.materials.index', compact('materialsBySubject'));
    }

    public function show(Material $material)
    {
        if (!$this->materialService->canAccess($material, auth()->user())) {
            return back()->with('error', 'Anda tidak memiliki akses ke bahan ajar ini.');
        }

        $material->load(['subject', 'user']);
        return view('mahasiswa.materials.show', compact('material'));
    }

    public function download(Material $material)
    {
        $response = $this->materialService->download($material, auth()->user());

        if (!$response) {
            return back()->with('error', 'File tidak ditemukan atau akses ditolak.');
        }

        return $response;
    }
}