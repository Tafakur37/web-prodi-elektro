<?php

namespace App\Services;

use App\Models\Grade;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GradeService
{
    /**
     * Ambil data form untuk halaman input nilai.
     */
    public function getInputFormData(): array
    {
        return [
            'semesters' => Subject::distinct()->orderBy('semester', 'asc')->pluck('semester'),
            'cohorts'   => User::where('role', 'mahasiswa')
                ->whereNotNull('cohort')
                ->select('cohort')
                ->distinct()
                ->orderBy('cohort', 'asc')
                ->get(),
            'subjects'  => Subject::orderBy('semester', 'asc')->orderBy('name', 'asc')->get(),
        ];
    }

    /**
     * Ambil mata kuliah berdasarkan semester (cascading filter).
     */
    public function getSubjectsBySemester(int $semester, ?string $search = null)
    {
        $query = Subject::where('semester', $semester);

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        return $query->get(['id', 'name as text']);
    }

    /**
     * Ambil daftar mahasiswa beserta nilai untuk mata kuliah tertentu.
     */
    public function getStudentsWithGrades(int $subjectId, string $cohort)
    {
        $subject = Subject::findOrFail($subjectId);

        $students = User::where('role', 'mahasiswa')
            ->where('cohort', $cohort)
            ->with(['grades' => function ($query) use ($subjectId) {
                $query->where('subject_id', $subjectId);
            }])
            ->orderBy('name', 'asc')
            ->get();

        return compact('students', 'subjectId', 'subject');
    }

    /**
     * Simpan/update nilai mahasiswa (batch).
     */
    public function storeGrades(array $scores, int $subjectId, string $cohort, \App\Services\GradeCalculatorService $gradeCalculator): array
    {
        try {
            DB::beginTransaction();

            $subject = Subject::findOrFail($subjectId);

            foreach ($scores as $studentId => $data) {
                $processedData = $gradeCalculator->calculate($data, $subject);
                $processedData['cohort'] = $cohort;

                Grade::updateOrCreate(
                    ['user_id' => $studentId, 'subject_id' => $subjectId],
                    $processedData
                );
            }

            DB::commit();

            app(\App\Services\ActivityLoggerService::class)->log(
                'input_nilai', 'Grade',
                "Input/Update nilai matkul ID: {$subjectId} cohort: {$cohort}"
            );

            return ['status' => 'success', 'message' => 'Semua nilai mahasiswa berhasil disimpan!'];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Gagal simpan nilai: " . $e->getMessage());
            return ['status' => 'error', 'message' => 'Gagal menyimpan data: ' . $e->getMessage()];
        }
    }

    /**
     * Ambil rekap nilai mahasiswa per semester (IPS & IPK).
     */
    public function getRecapData(int $studentId, int $semester): array
    {
        $student = User::findOrFail($studentId);

        $subjects = Subject::where('semester', $semester)
            ->with(['grades' => function ($q) use ($studentId) {
                $q->where('user_id', $studentId);
            }])
            ->orderBy('name', 'asc')
            ->get();

        $allSubjectsCount = $subjects->count();
        $gradedSubjectsCount = $subjects->filter(fn($s) => $s->grades->isNotEmpty())->count();
        $isSemesterComplete = ($allSubjectsCount > 0 && $allSubjectsCount === $gradedSubjectsCount);

        $ips = 0;
        $ipk = 0;
        $totalSksSemester = 0;
        $totalSksKumulatif = 0;

        if ($isSemesterComplete) {
            // Hitung IPS
            $totalMutuSemester = 0;
            foreach ($subjects as $subject) {
                $grade = $subject->grades->first();
                $totalSksSemester += $subject->sks;
                $totalMutuSemester += ($grade->grade_point * $subject->sks);
            }
            $ips = $totalSksSemester > 0 ? ($totalMutuSemester / $totalSksSemester) : 0;

            // Hitung IPK
            $allSubjectsUpToNow = Subject::where('semester', '<=', $semester)
                ->with(['grades' => function ($q) use ($studentId) {
                    $q->where('user_id', $studentId);
                }])->get();

            $isAllComplete = $allSubjectsUpToNow->every(fn($s) => $s->grades->isNotEmpty());

            if ($isAllComplete) {
                $totalMutuKumulatif = 0;
                foreach ($allSubjectsUpToNow as $sub) {
                    $grade = $sub->grades->first();
                    $totalSksKumulatif += $sub->sks;
                    $totalMutuKumulatif += ($grade->grade_point * $sub->sks);
                }
                $ipk = $totalSksKumulatif > 0 ? ($totalMutuKumulatif / $totalSksKumulatif) : 0;
            } else {
                $isSemesterComplete = false;
            }
        }

        return compact('student', 'subjects', 'semester', 'isSemesterComplete', 'ips', 'ipk', 'totalSksSemester', 'totalSksKumulatif');
    }

    /**
     * Ambil data recap filter (semesters + cohorts).
     */
    public function getRecapFilterData(): array
    {
        return [
            'semesters'       => Subject::distinct()->orderBy('semester', 'asc')->pluck('semester'),
            'availableCohorts' => User::where('role', 'mahasiswa')
                ->whereNotNull('cohort')
                ->distinct()
                ->pluck('cohort')
                ->filter(),
        ];
    }

    /**
     * Ambil mahasiswa per cohort (untuk recap).
     */
    public function getStudentsByCohort(string $cohort)
    {
        return User::where('role', 'mahasiswa')
            ->where('cohort', $cohort)
            ->orderBy('name', 'asc')
            ->get();
    }
}
