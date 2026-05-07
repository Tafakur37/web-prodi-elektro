<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Services\MeetingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeetingController extends Controller
{
    public function __construct(private MeetingService $meetingService) {}

    public function index()
    {
        $meetings = $this->meetingService->getByDosen(Auth::id());
        return view('dosen.meetings.index', compact('meetings'));
    }

    public function create()
    {
        $cohorts = $this->meetingService->getCohorts();
        return view('dosen.meetings.create', compact('cohorts'));
    }

    public function getStudents(Request $request)
    {
        $students = $this->meetingService->getStudentsByCohort($request->cohort);
        return response()->json(['students' => $students]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'students' => 'required|array|min:1',
            'students.*' => 'exists:users,id',
            'requested_date' => 'required|date',
            'topic' => 'required|string|max:255',
        ]);

        $this->meetingService->store($request->all(), Auth::user());

        return redirect()->route('dosen.meetings.index')->with('success', 'Jadwal bimbingan berhasil dibuat dan dikirim ke mahasiswa terpilih.');
    }

    public function update(Request $request, $id)
    {
        $meeting = Meeting::findOrFail($id);

        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $this->meetingService->updateStatus($meeting, $request->status, Auth::user());

        return redirect()->back()->with('success', 'Status bimbingan berhasil diperbarui.');
    }
}