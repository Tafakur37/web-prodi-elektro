<?php

namespace App\Services;

use App\Models\Document;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DocumentService
{
    /**
     * Ambil dokumen masuk berdasarkan role penerima.
     */
    public function getIncoming(string $receiverRole)
    {
        return Document::where('receiver_role', $receiverRole)->latest()->get();
    }

    /**
     * Ambil dokumen masuk untuk admin (dari mahasiswa).
     */
    public function getIncomingForAdmin()
    {
        return Document::whereHas('user', function ($q) {
            $q->where('role', 'mahasiswa');
        })->latest()->get();
    }

    /**
     * Ambil dokumen yang dikirim oleh user tertentu.
     */
    public function getMyDocuments(int $userId)
    {
        return Document::where('user_id', $userId)->latest()->get();
    }

    /**
     * Simpan dokumen baru + upload file.
     */
    public function store(array $data, UploadedFile $file, int $userId): Document
    {
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('documents', $fileName, 'public');

        return Document::create([
            'user_id'       => $userId,
            'title'         => $data['title'],
            'file_path'     => $filePath,
            'category'      => $data['category'],
            'receiver_role' => $data['receiver_role'],
            'description'   => $data['description'] ?? null,
            'status'        => 'pending',
        ]);
    }

    /**
     * Download file dokumen.
     */
    public function download(Document $document)
    {
        $filePath = storage_path('app/public/' . $document->file_path);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        return null;
    }

    /**
     * Hapus dokumen beserta file-nya.
     */
    public function destroy(Document $document): void
    {
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();
    }
}
