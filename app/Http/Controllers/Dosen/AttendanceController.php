<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Services\AttendanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function __construct(private AttendanceService $attendanceService) {}

    public function index(Request $request)
    {
        $filterData = $this->attendanceService->getFilterData();

        $subject_id = $request->subject_id;
        $cohort = $request->cohort;
        $date = $request->date ?: date('Y-m-d');

        $students = collect();
        $selectedSubject = null;
        $existingAttendances = [];

        if ($subject_id && $cohort) {
            $result = $this->attendanceService->getStudentsWithAttendance(
                $subject_id, $cohort, $date, Auth::id()
            );
            $students = $result['students'];
            $selectedSubject = $result['selectedSubject'];
            $existingAttendances = $result['existingAttendances'];
        }

        return view('dosen.attendances.index', array_merge(
            $filterData,
            compact('students', 'subject_id', 'cohort', 'date', 'selectedSubject', 'existingAttendances')
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'attendances' => 'required|array',
        ]);

        $this->attendanceService->store(
            $request->attendances, Auth::id(), $request->subject_id, $request->date
        );

        return redirect()->back()->with('success', 'Absensi disimpan!');
    }
}
