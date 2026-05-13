<?php

namespace App\Services;

use App\Models\BerkasActivity;
use App\Models\BerkasFile;
use App\Models\BerkasFolder;
use Illuminate\Support\Facades\Storage;

class BerkasService
{
    /**
     * Log an activity for a file or folder.
     */
    public function logActivity($user_id, $action, $subject, $description = null)
    {
        BerkasActivity::create([
            'user_id' => $user_id,
            'action' => $action,
            'subject_id' => $subject->id,
            'subject_type' => get_class($subject),
            'description' => $description,
        ]);
    }

    /**
     * Get folder size recursively (in bytes).
     */
    public function getFolderSize(BerkasFolder $folder)
    {
        $size = $folder->files()->sum('size');
        
        foreach ($folder->children as $child) {
            $size += $this->getFolderSize($child);
        }
        
        return $size;
    }

    /**
     * Soft delete folder and all its contents recursively.
     */
    public function trashFolder(BerkasFolder $folder, $userId)
    {
        // Trash files
        foreach ($folder->files as $file) {
            $file->delete(); // Soft delete
            $this->logActivity($userId, 'delete', $file, 'Moved file to trash');
        }

        // Trash children folders
        foreach ($folder->children as $child) {
            $this->trashFolder($child, $userId);
        }

        $folder->delete(); // Soft delete
        $this->logActivity($userId, 'delete', $folder, 'Moved folder to trash');
    }

    /**
     * Restore folder and its contents recursively.
     */
    public function restoreFolder(BerkasFolder $folder, $userId)
    {
        $folder->restore();
        $this->logActivity($userId, 'restore', $folder, 'Restored folder from trash');

        // Restore files
        foreach ($folder->files()->onlyTrashed()->get() as $file) {
            $file->restore();
            $this->logActivity($userId, 'restore', $file, 'Restored file from trash');
        }

        // Restore children
        foreach ($folder->children()->onlyTrashed()->get() as $child) {
            $this->restoreFolder($child, $userId);
        }
    }

    /**
     * Permanently delete folder and all contents, including physical files.
     */
    public function forceDeleteFolder(BerkasFolder $folder, $userId)
    {
        // Permanent delete files and physical files
        foreach ($folder->files()->withTrashed()->get() as $file) {
            $this->forceDeleteFile($file, $userId, false); // Don't log if parent folder is logging
        }

        // Permanent delete children
        foreach ($folder->children()->withTrashed()->get() as $child) {
            $this->forceDeleteFolder($child, $userId);
        }

        $folder->forceDelete();
        $this->logActivity($userId, 'permanent_delete', $folder, 'Permanently deleted folder');
    }

    /**
     * Permanently delete a single file and its physical storage.
     */
    public function forceDeleteFile(BerkasFile $file, $userId, $log = true)
    {
        if (Storage::disk('public')->exists($file->file_path)) {
            Storage::disk('public')->delete($file->file_path);
        }

        $file->forceDelete();
        
        if ($log) {
            $this->logActivity($userId, 'permanent_delete', $file, 'Permanently deleted file');
        }
    }
}
