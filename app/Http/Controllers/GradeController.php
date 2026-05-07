<?php

namespace App\Http\Controllers;

use App\Services\GradeService;
use App\Services\GradeCalculatorService;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function __construct(private GradeService $gradeService) {}

    /**
     * Menampilkan Halaman Utama Input Nilai (Berlaku untuk Admin, Staff & Dosen)
     */
    public function inputNilai()
    {
        $formData = $this->gradeService->getInputFormData();

        // Tentukan path view berdasarkan prefix URL
        if (request()->is('staff/*')) {
            $viewPath = 'staff.nilai.index';
        } elseif (request()->is('dosen/*')) {
            $viewPath = 'dosen.nilai.index';
        } else {
            $viewPath = 'admin.grades.index';
        }

        return view($viewPath, $formData);
    }

    /**
     * API untuk Mendapatkan Mata Kuliah berdasarkan Semester (Cascading Filter)
     */
    public function getSubjects(Request $request)
    {
        $subjects = $this->gradeService->getSubjectsBySemester($request->semester, $request->search);
        return response()->json($subjects);
    }

    /**
     * API untuk mengambil daftar mahasiswa (Partial View)
     */
    public function getStudents(Request $request)
    {
        $data = $this->gradeService->getStudentsWithGrades($request->subject_id, $request->cohort);
        return view('staff.nilai.partial_students', $data);
    }

    /**
     * Menyimpan atau Memperbarui Nilai Mahasiswa (Support AJAX)
     */
    public function storeNilai(Request $request, GradeCalculatorService $gradeCalculator)
    {
        $request->validate([
            'subject_id' => 'required',
            'cohort'     => 'required',
            'scores'     => 'required|array'
        ]);

        $isAjax = $request->ajax() || $request->wantsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest';

        $result = $this->gradeService->storeGrades(
            $request->scores, $request->subject_id, $request->cohort, $gradeCalculator
        );

        if ($isAjax) {
            $statusCode = $result['status'] === 'success' ? 200 : 500;
            return response()->json($result, $statusCode);
        }

        if ($result['status'] === 'success') {
            return back()->with('success', 'Data nilai berhasil diperbarui!');
        }

        return back()->with('error', 'Terjadi kesalahan sistem saat menyimpan nilai.');
    }
}
