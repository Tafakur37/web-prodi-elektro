<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $query = Exam::with(['subject']);

        if ($request->has('cohort') && $request->cohort != '') {
            $query->where('cohort', $request->cohort);
        }

        $exams = $query->orderBy('date', 'asc')->orderBy('start_time', 'asc')->get();

        $subjects = Subject::all();
        $availableCohorts = User::where('role', 'mahasiswa')->whereNotNull('cohort')->distinct()->pluck('cohort')->filter();

        return view('staff.exams.index', compact('exams', 'subjects', 'availableCohorts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'cohort'     => 'required',
            'date'       => 'required|date',
            'start_time' => 'required',
            'end_time'   => 'required',
            'room'       => 'required',
            'type'       => 'required|in:uts,uas,kuis',
        ]);

        Exam::create($request->all());

        return redirect()->back()->with('success', 'Jadwal ujian berhasil disimpan!');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return back()->with('success', 'Jadwal ujian berhasil dihapus!');
    }
}
