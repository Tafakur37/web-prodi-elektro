<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Services\GradeService;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function __construct(private GradeService $gradeService) {}

    public function recap(Request $request)
    {
        $filterData = $this->gradeService->getRecapFilterData();

        $semester = $request->semester;
        $cohort = $request->cohort;
        $students = collect();

        if ($semester && $cohort) {
            $students = $this->gradeService->getStudentsByCohort($cohort);
        }

        return view('staff.grades.recap', array_merge(
            $filterData,
            compact('semester', 'cohort', 'students')
        ));
    }

    public function getRecapData(Request $request)
    {
        if (!$request->semester || !$request->student_id) {
            return "Data tidak lengkap.";
        }

        $data = $this->gradeService->getRecapData($request->student_id, $request->semester);

        return view('staff.grades.partial_student_grades', $data);
    }
}
