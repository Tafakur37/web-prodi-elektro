<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\BerkasFolder;
use App\Services\BerkasService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BerkasFolderController extends Controller
{
    protected $berkasService;

    public function __construct(BerkasService $berkasService)
    {
        $this->berkasService = $berkasService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:berkas_folders,id',
        ]);

        $userId = Auth::id();

        if ($request->parent_id) {
            // Ensure user owns parent folder
            BerkasFolder::where('id', $request->parent_id)->where('user_id', $userId)->firstOrFail();
        }

        $folder = BerkasFolder::create([
            'user_id' => $userId,
            'parent_id' => $request->parent_id,
            'name' => $request->name,
        ]);

        $this->berkasService->logActivity($userId, 'create_folder', $folder, 'Created folder ' . $folder->name);

        return back()->with('success', 'Folder berhasil dibuat.');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $folder = BerkasFolder::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        $oldName = $folder->name;
        $folder->update(['name' => $request->name]);
        
        $this->berkasService->logActivity(Auth::id(), 'rename', $folder, "Renamed folder from {$oldName} to {$folder->name}");

        return back()->with('success', 'Folder berhasil diubah namanya.');
    }

    public function destroy($id)
    {
        $folder = BerkasFolder::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $this->berkasService->trashFolder($folder, Auth::id());

        return back()->with('success', 'Folder dipindahkan ke tempat sampah.');
    }

    public function restore($id)
    {
        $folder = BerkasFolder::onlyTrashed()->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $this->berkasService->restoreFolder($folder, Auth::id());

        return back()->with('success', 'Folder berhasil direstore.');
    }

    public function forceDelete($id)
    {
        $folder = BerkasFolder::onlyTrashed()->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $this->berkasService->forceDeleteFolder($folder, Auth::id());

        return back()->with('success', 'Folder dihapus permanen.');
    }
}
