<?php

namespace App\Services;

use App\Models\Announcement;

class AnnouncementService
{
    /**
     * Ambil semua pengumuman (paginated).
     */
    public function getAll(int $perPage = 10)
    {
        return Announcement::orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Simpan pengumuman baru.
     */
    public function store(array $data, int $userId): Announcement
    {
        return Announcement::create([
            'user_id'     => $userId,
            'title'       => $data['title'],
            'message'     => $data['message'],
            'target_role' => $data['target_role'],
        ]);
    }

    /**
     * Hapus pengumuman.
     */
    public function destroy(int $id): void
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();
    }
}
