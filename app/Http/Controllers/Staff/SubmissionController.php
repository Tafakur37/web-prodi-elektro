<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Services\SubmissionService;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function __construct(private SubmissionService $submissionService) {}

    public function index()
    {
        $submissions = $this->submissionService->getAllForReview();
        return view('staff.submissions.index', compact('submissions'));
    }

    public function show(Submission $submission)
    {
        $submission->load('user');
        return view('staff.submissions.show', compact('submission'));
    }

    public function updateStatus(Request $request, Submission $submission)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,revision',
            'note' => 'nullable|string',
        ]);

        $this->submissionService->updateStatus($submission, $request->status, $request->note);

        return redirect()->route('staff.submissions.index')->with('success', 'Status pengajuan berhasil diperbarui.');
    }
}
