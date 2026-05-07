<?php

namespace App\Services;

use App\Models\Achievement;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AchievementService
{
    /**
     * Ambil semua prestasi, bisa filter by cohort (paginated).
     */
    public function getAll(?string $cohort = null, int $perPage = 15)
    {
        $query = Achievement::with('user');

        if ($cohort && $cohort !== '') {
            $query->whereHas('user', function ($q) use ($cohort) {
                $q->where('cohort', $cohort);
            });
        }

        return $query->orderBy('date', 'desc')->paginate($perPage);
    }

    /**
     * Ambil daftar cohort dan mahasiswa untuk form.
     */
    public function getFormData(): array
    {
        return [
            'availableCohorts' => User::where('role', 'mahasiswa')
                ->whereNotNull('cohort')
                ->distinct()
                ->pluck('cohort')
                ->filter(),
            'students'         => User::where('role', 'mahasiswa')
                ->orderBy('name', 'asc')
                ->get(),
        ];
    }

    /**
     * Simpan prestasi baru + upload attachment.
     */
    public function store(array $data, ?UploadedFile $file = null): Achievement
    {
        if ($file) {
            $data['attachment'] = $file->store('achievements', 'public');
        }

        return Achievement::create($data);
    }

    /**
     * Hapus prestasi + cleanup attachment.
     */
    public function destroy(Achievement $achievement): void
    {
        if ($achievement->attachment) {
            Storage::disk('public')->delete($achievement->attachment);
        }

        $achievement->delete();
    }
}
