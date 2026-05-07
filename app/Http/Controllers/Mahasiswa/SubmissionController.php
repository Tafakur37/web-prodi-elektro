<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Services\SubmissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    public function __construct(private SubmissionService $submissionService) {}

    public function index()
    {
        $submissions = $this->submissionService->getByUser(Auth::id());
        return view('mahasiswa.submissions.index', compact('submissions'));
    }

    public function create()
    {
        return view('mahasiswa.submissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:5120',
        ]);

        $this->submissionService->store($request->all(), $request->file('file'), Auth::id());

        return redirect()->route('mahasiswa.submissions.index')->with('success', 'Pengajuan berhasil dikirim.');
    }

    public function show(Submission $submission)
    {
        if ($submission->user_id !== Auth::id()) {
            return back()->with('error', 'Akses ditolak.');
        }

        return view('mahasiswa.submissions.show', compact('submission'));
    }

    public function edit(Submission $submission)
    {
        if (!$this->submissionService->canEdit($submission, Auth::id())) {
            return back()->with('error', 'Akses ditolak atau pengajuan tidak dapat diubah lagi.');
        }

        return view('mahasiswa.submissions.edit', compact('submission'));
    }

    public function update(Request $request, Submission $submission)
    {
        if (!$this->submissionService->canEdit($submission, Auth::id())) {
            return back()->with('error', 'Akses ditolak atau pengajuan tidak dapat diubah lagi.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:5120',
        ]);

        $this->submissionService->update($submission, $request->all(), $request->file('file'));

        return redirect()->route('mahasiswa.submissions.index')->with('success', 'Pengajuan berhasil diperbarui.');
    }

    public function destroy(Submission $submission)
    {
        if (!$this->submissionService->canDelete($submission, Auth::id())) {
            return back()->with('error', 'Akses ditolak atau pengajuan sudah disetujui.');
        }

        $this->submissionService->destroy($submission);

        return back()->with('success', 'Pengajuan berhasil dihapus.');
    }
}
