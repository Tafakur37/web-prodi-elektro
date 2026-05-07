<?php

namespace App\Services;

use App\Models\Material;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MaterialService
{
    /**
     * Ambil daftar cohort unik dari mahasiswa.
     */
    public function getAvailableCohorts()
    {
        return User::where('role', 'mahasiswa')
            ->whereNotNull('cohort')
            ->distinct()
            ->pluck('cohort')
            ->sort();
    }

    /**
     * Ambil semua materi (untuk Admin — bisa filter by cohort).
     */
    public function getAll(?string $cohort = null)
    {
        $query = Material::with(['subject', 'user']);

        if ($cohort) {
            $query->where('cohort', $cohort);
        }

        return $query->latest()->get();
    }

    /**
     * Ambil materi milik dosen tertentu.
     */
    public function getByUser(int $userId)
    {
        return Material::with('subject')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Ambil materi grouped by subject (untuk view mahasiswa).
     */
    public function getBySubjectGrouped(string $cohort)
    {
        $materials = Material::with(['subject', 'user'])
            ->where('cohort', $cohort)
            ->orderBy('created_at', 'desc')
            ->get();

        return $materials->groupBy(function ($item) {
            return $item->subject ? $item->subject->name : 'Materi Umum';
        });
    }

    /**
     * Ambil daftar mata kuliah untuk form create.
     */
    public function getSubjectsForForm()
    {
        return Subject::orderBy('semester', 'asc')->orderBy('name', 'asc')->get();
    }

    /**
     * Simpan materi baru (digunakan oleh Admin dan Dosen).
     */
    public function store(array $data, UploadedFile $file, int $userId): Material
    {
        $fileName = $file->getClientOriginalName();
        $fileExtension = $file->getClientOriginalExtension();
        $filePath = $file->storeAs('materials', uniqid() . '_' . $fileName, 'public');

        return Material::create([
            'subject_id'  => $data['subject_id'] ?? null,
            'user_id'     => $userId,
            'title'       => $data['title'],
            'description' => $data['description'] ?? '',
            'file_name'   => $fileName,
            'file_path'   => $filePath,
            'file_type'   => strtolower($fileExtension),
            'cohort'      => $data['cohort'],
            'target_role' => $data['target_role'] ?? 'mahasiswa',
        ]);
    }

    /**
     * Hapus materi beserta file-nya.
     * Jika ownerId diberikan, akan cek kepemilikan terlebih dahulu.
     */
    public function destroy(Material $material, ?int $ownerId = null): bool
    {
        if ($ownerId !== null && $material->user_id !== $ownerId) {
            return false; // Akses ditolak
        }

        if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();
        return true;
    }

    /**
     * Download file materi dengan pengecekan akses.
     */
    public function download(Material $material, User $user)
    {
        // Mahasiswa hanya bisa download materi dari cohort sendiri
        if ($user->role === 'mahasiswa' && $material->cohort != $user->cohort) {
            return null;
        }

        if (!Storage::disk('public')->exists($material->file_path)) {
            return null;
        }

        return Storage::disk('public')->download($material->file_path, $material->file_name);
    }

    /**
     * Cek apakah user bisa mengakses materi tertentu.
     */
    public function canAccess(Material $material, User $user): bool
    {
        // Admin & Staff bisa akses semua
        if (in_array($user->role, ['admin', 'staff'])) {
            return true;
        }

        // Mahasiswa hanya bisa akses materi dari cohort sendiri
        if ($user->role === 'mahasiswa') {
            return $material->cohort == $user->cohort;
        }

        // Dosen bisa akses materi sendiri
        if ($user->role === 'dosen') {
            return $material->user_id === $user->id;
        }

        return false;
    }
}
