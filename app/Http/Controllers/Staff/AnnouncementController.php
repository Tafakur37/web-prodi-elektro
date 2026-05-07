<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Services\AnnouncementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function __construct(private AnnouncementService $announcementService) {}

    public function index()
    {
        $announcements = $this->announcementService->getAll();
        return view('staff.announcements.index', compact('announcements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'target_role' => 'required|in:all,dosen,mahasiswa'
        ]);

        $this->announcementService->store($request->all(), Auth::id());

        return back()->with('success', 'Pengumuman berhasil disiarkan!');
    }

    public function destroy($id)
    {
        $this->announcementService->destroy($id);
        return back()->with('success', 'Pengumuman berhasil dihapus!');
    }
}