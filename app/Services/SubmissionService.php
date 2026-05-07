<?php

namespace App\Services;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SubmissionService
{
    /**
     * Ambil semua submission untuk review staff.
     */
    public function getAllForReview()
    {
        return Submission::with('user')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Ambil submission milik user tertentu.
     */
    public function getByUser(int $userId)
    {
        return Submission::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Simpan submission baru + upload file + notifikasi ke staff.
     */
    public function store(array $data, ?UploadedFile $file, int $userId): Submission
    {
        $filePath = null;
        $fileName = null;

        if ($file) {
            $fileName = $file->getClientOriginalName();
            $filePath = $file->storeAs('submissions', uniqid() . '_' . $fileName, 'public');
        }

        $submission = Submission::create([
            'user_id'     => $userId,
            'title'       => $data['title'],
            'type'        => $data['type'],
            'description' => $data['description'] ?? null,
            'file_name'   => $fileName,
            'file_path'   => $filePath,
            'status'      => 'pending',
        ]);

        // Notifikasi ke semua staff
        $staffs = User::where('role', 'staff')->get();
        $sender = User::find($userId);
        foreach ($staffs as $staff) {
            $staff->notify(new \App\Notifications\SubmissionNotification(
                'Pengajuan Baru',
                ($sender->name ?? 'User') . ' mengajukan ' . $data['type'],
                $submission->id,
                'primary'
            ));
        }

        return $submission;
    }

    /**
     * Update submission (hanya bisa jika status belum approved/rejected).
     */
    public function update(Submission $submission, array $data, ?UploadedFile $file): Submission
    {
        $updateData = [
            'title'       => $data['title'],
            'type'        => $data['type'],
            'description' => $data['description'] ?? null,
            'status'      => 'pending', // Reset status if edited
        ];

        if ($file) {
            // Hapus file lama
            if ($submission->file_path && Storage::disk('public')->exists($submission->file_path)) {
                Storage::disk('public')->delete($submission->file_path);
            }

            $fileName = $file->getClientOriginalName();
            $filePath = $file->storeAs('submissions', uniqid() . '_' . $fileName, 'public');

            $updateData['file_name'] = $fileName;
            $updateData['file_path'] = $filePath;
        }

        $submission->update($updateData);
        return $submission;
    }

    /**
     * Update status submission (review oleh staff).
     */
    public function updateStatus(Submission $submission, string $status, ?string $note = null): void
    {
        $submission->update([
            'status' => $status,
            'note'   => $note,
        ]);

        $statusIndo = match ($status) {
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'revision' => 'Perlu Revisi',
            default    => 'Diperbarui',
        };

        $type = match ($status) {
            'approved' => 'success',
            'rejected' => 'danger',
            'revision' => 'warning',
            default    => 'info',
        };

        $submission->user->notify(new \App\Notifications\SubmissionNotification(
            'Status Pengajuan ' . $statusIndo,
            'Pengajuan ' . $submission->title . ' telah ' . strtolower($statusIndo),
            $submission->id,
            $type
        ));
    }

    /**
     * Hapus submission + file.
     */
    public function destroy(Submission $submission): void
    {
        if ($submission->file_path && Storage::disk('public')->exists($submission->file_path)) {
            Storage::disk('public')->delete($submission->file_path);
        }

        $submission->delete();
    }

    /**
     * Cek apakah submission bisa diedit oleh user.
     */
    public function canEdit(Submission $submission, int $userId): bool
    {
        return $submission->user_id === $userId && !in_array($submission->status, ['approved', 'rejected']);
    }

    /**
     * Cek apakah submission bisa dihapus oleh user.
     */
    public function canDelete(Submission $submission, int $userId): bool
    {
        return $submission->user_id === $userId && $submission->status !== 'approved';
    }
}
