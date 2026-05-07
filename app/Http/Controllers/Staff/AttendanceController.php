<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Services\AttendanceService;
use Illuminate\Http\Request;

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
            // Staff melihat semua absensi (tanpa filter lecturer), dan filter by grades
            $result = $this->attendanceService->getStudentsWithAttendance(
                $subject_id, $cohort, $date, null, true
            );
            $students = $result['students'];
            $selectedSubject = $result['selectedSubject'];
            $existingAttendances = $result['existingAttendances'];
        }

        return view('staff.attendances.index', array_merge(
            $filterData,
            compact('students', 'subject_id', 'cohort', 'date', 'selectedSubject', 'existingAttendances')
        ));
    }
}
