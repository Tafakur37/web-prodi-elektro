<?php

namespace App\Services;

use App\Models\Meeting;
use App\Models\User;
use Carbon\Carbon;

class MeetingService
{
    /**
     * Ambil daftar meeting untuk dosen tertentu.
     */
    public function getByDosen(int $dosenId)
    {
        return Meeting::where('dosen_id', $dosenId)
            ->with('student')
            ->orderBy('requested_date', 'desc')
            ->get();
    }

    /**
     * Ambil daftar cohort unik dari mahasiswa.
     */
    public function getCohorts()
    {
        return User::where('role', 'mahasiswa')
            ->whereNotNull('cohort')
            ->distinct()
            ->pluck('cohort')
            ->filter();
    }

    /**
     * Ambil mahasiswa berdasarkan cohort.
     */
    public function getStudentsByCohort(string $cohort)
    {
        return User::where('role', 'mahasiswa')
            ->where('cohort', $cohort)
            ->select('id', 'name', 'nim')
            ->get();
    }

    /**
     * Buat jadwal meeting baru (bulk — bisa untuk banyak mahasiswa sekaligus).
     */
    public function store(array $data, User $dosen): void
    {
        foreach ($data['students'] as $studentId) {
            Meeting::create([
                'student_id'     => $studentId,
                'dosen_id'       => $dosen->id,
                'requested_date' => $data['requested_date'],
                'topic'          => $data['topic'],
                'status'         => 'approved', // Dosen initiated
            ]);

            $student = User::find($studentId);
            if ($student) {
                $student->notify(new \App\Notifications\AppNotification([
                    'title'   => 'Jadwal Bimbingan Baru',
                    'message' => "Dosen {$dosen->name} telah menjadwalkan bimbingan untuk Anda pada " . Carbon::parse($data['requested_date'])->translatedFormat('d F Y') . ".",
                    'url'     => '#',
                    'type'    => 'info',
                ]));
            }
        }
    }

    /**
     * Update status meeting (approved/rejected).
     */
    public function updateStatus(Meeting $meeting, string $status, User $dosen): void
    {
        if ($meeting->dosen_id != $dosen->id) {
            abort(403);
        }

        $meeting->update(['status' => $status]);

        $statusText = $status == 'approved' ? 'disetujui' : 'ditolak';
        if ($meeting->student) {
            $meeting->student->notify(new \App\Notifications\AppNotification([
                'title'   => 'Update Status Bimbingan',
                'message' => "Pengajuan bimbingan Anda dengan Dosen {$meeting->dosen->name} telah {$statusText}.",
                'url'     => '#',
                'type'    => $status == 'approved' ? 'success' : 'danger',
            ]));
        }
    }
}
