<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\BerkasFile;
use App\Models\BerkasFolder;
use App\Services\BerkasService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class BerkasFileController extends Controller
{
    protected $berkasService;

    public function __construct(BerkasService $berkasService)
    {
        $this->berkasService = $berkasService;
    }

    public function upload(Request $request)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'file|max:10240', // 10MB limit per file
            'folder_id' => 'nullable|exists:berkas_folders,id',
        ]);

        $userId = Auth::id();

        if ($request->folder_id) {
            BerkasFolder::where('id', $request->folder_id)->where('user_id', $userId)->firstOrFail();
        }

        foreach ($request->file('files') as $file) {
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $size = $file->getSize();

            $path = $file->storeAs("berkas/{$userId}", uniqid() . '_' . $originalName, 'public');

            $berkasFile = BerkasFile::create([
                'user_id' => $userId,
                'folder_id' => $request->folder_id,
                'name' => $originalName,
                'file_path' => $path,
                'extension' => $extension,
                'size' => $size,
            ]);

            $this->berkasService->logActivity($userId, 'upload', $berkasFile, "Uploaded file {$originalName}");
        }

        return back()->with('success', 'File berhasil diunggah.');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $file = BerkasFile::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        $oldName = $file->name;
        
        // Ensure extension is kept
        $newName = $request->name;
        if (!preg_match("/\.{$file->extension}$/i", $newName) && $file->extension) {
            $newName .= '.' . $file->extension;
        }

        $file->update(['name' => $newName]);
        
        $this->berkasService->logActivity(Auth::id(), 'rename', $file, "Renamed file from {$oldName} to {$newName}");

        return back()->with('success', 'File berhasil diubah namanya.');
    }

    public function download($id)
    {
        $file = BerkasFile::findOrFail($id);

        // Check policy
        Gate::authorize('viewFile', $file);

        $filePath = storage_path('app/public/' . $file->file_path);

        if (file_exists($filePath)) {
            $this->berkasService->logActivity(Auth::id(), 'download', $file, "Downloaded file {$file->name}");
            return response()->download($filePath, $file->name);
        }

        return back()->withErrors(['error' => 'File tidak ditemukan di server.']);
    }

    public function preview($id)
    {
        $file = BerkasFile::findOrFail($id);

        // Check authorization
        Gate::authorize('viewFile', $file);

        $filePath = storage_path('app/public/' . $file->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan di server.');
        }

        $ext  = strtolower($file->extension);
        $mime = mime_content_type($filePath);

        // Override MIME untuk tipe yang sering salah terdeteksi
        $mimeOverrides = [
            'txt'  => 'text/plain',
            'log'  => 'text/plain',
            'csv'  => 'text/csv',
            'json' => 'application/json',
            'xml'  => 'text/xml',
            'md'   => 'text/plain',
            'html' => 'text/html',
            'htm'  => 'text/html',
            'js'   => 'text/javascript',
            'css'  => 'text/css',
            'php'  => 'text/plain',
            'py'   => 'text/plain',
            'pdf'  => 'application/pdf',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png'  => 'image/png',
            'gif'  => 'image/gif',
            'webp' => 'image/webp',
            'svg'  => 'image/svg+xml',
            'mp4'  => 'video/mp4',
            'webm' => 'video/webm',
            'ogg'  => 'video/ogg',
        ];

        if (isset($mimeOverrides[$ext])) {
            $mime = $mimeOverrides[$ext];
        }

        $headers = [
            'Content-Type'        => $mime,
            'Content-Disposition' => 'inline; filename="' . addslashes($file->name) . '"',
            'X-Content-Type-Options' => 'nosniff',
            // Izinkan embed di iframe untuk PDF (Google Docs viewer)
            'X-Frame-Options'     => 'SAMEORIGIN',
            'Cache-Control'       => 'private, max-age=300',
        ];

        return response()->file($filePath, $headers);
    }

    public function destroy($id)
    {
        $file = BerkasFile::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $file->delete(); // Soft delete
        $this->berkasService->logActivity(Auth::id(), 'delete', $file, 'Moved file to trash');

        return back()->with('success', 'File dipindahkan ke tempat sampah.');
    }

    public function restore($id)
    {
        $file = BerkasFile::onlyTrashed()->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $file->restore();
        $this->berkasService->logActivity(Auth::id(), 'restore', $file, 'Restored file from trash');

        return back()->with('success', 'File berhasil direstore.');
    }

    public function forceDelete($id)
    {
        $file = BerkasFile::onlyTrashed()->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $this->berkasService->forceDeleteFile($file, Auth::id());

        return back()->with('success', 'File dihapus permanen.');
    }
}
