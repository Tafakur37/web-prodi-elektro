<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Subject;
use App\Models\User;

class AttendanceService
{
    /**
     * Ambil data filter untuk halaman absensi (subjects, cohorts, semesters).
     */
    public function getFilterData(): array
    {
        return [
            'subjects'         => Subject::orderBy('semester', 'asc')->orderBy('name', 'asc')->get(),
            'availableCohorts' => User::where('role', 'mahasiswa')
                ->whereNotNull('cohort')
                ->distinct()
                ->pluck('cohort')
                ->filter(),
            'semesters'        => Subject::distinct()->orderBy('semester', 'asc')->pluck('semester'),
        ];
    }

    /**
     * Ambil data mahasiswa beserta absensi yang sudah ada.
     *
     * @param int         $subjectId   ID mata kuliah
     * @param string      $cohort      Cohort / angkatan
     * @param string      $date        Tanggal absensi
     * @param int|null    $lecturerId  ID dosen (null = semua, untuk staff)
     * @param bool        $filterByGrades Jika true, hanya tampilkan mahasiswa yang punya grade (untuk staff)
     */
    public function getStudentsWithAttendance(int $subjectId, string $cohort, string $date, ?int $lecturerId = null, bool $filterByGrades = false): array
    {
        $studentQuery = User::where('role', 'mahasiswa')->where('cohort', $cohort);

        if ($filterByGrades) {
            $studentQuery->whereHas('grades', function ($q) use ($subjectId) {
                $q->where('subject_id', $subjectId);
            });
        }

        $students = $studentQuery->get();
        $selectedSubject = Subject::find($subjectId);

        // Ambil existing attendances
        $attendanceQuery = Attendance::where('subject_id', $subjectId)->where('date', $date);

        if ($lecturerId) {
            $attendanceQuery->where('lecturer_id', $lecturerId);
        }

        $attendances = $attendanceQuery->get();
        $existingAttendances = [];
        foreach ($attendances as $att) {
            $existingAttendances[$att->student_id] = $att;
        }

        return [
            'students'            => $students,
            'selectedSubject'     => $selectedSubject,
            'existingAttendances' => $existingAttendances,
        ];
    }

    /**
     * Ambil riwayat absensi seorang mahasiswa.
     */
    public function getStudentAttendances(int $studentId)
    {
        return Attendance::where('student_id', $studentId)
            ->with(['subject', 'lecturer'])
            ->orderBy('date', 'desc')
            ->get();
    }

    /**
     * Simpan/update data absensi.
     */
    public function store(array $attendances, int $lecturerId, int $subjectId, string $date): void
    {
        foreach ($attendances as $studentId => $data) {
            Attendance::updateOrCreate(
                [
                    'student_id'  => $studentId,
                    'lecturer_id' => $lecturerId,
                    'subject_id'  => $subjectId,
                    'date'        => $date,
                ],
                [
                    'status' => $data['status'],
                    'notes'  => $data['notes'] ?? '',
                ]
            );
        }
    }
}
