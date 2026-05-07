<?php

namespace App\Services;

use App\Models\Schedule;
use App\Models\ScheduleOverride;
use App\Models\Subject;
use App\Models\User;

class ScheduleService
{
    /**
     * Ambil semua jadwal, bisa filter by cohort.
     */
    public function getAll(?string $cohort = null)
    {
        $query = Schedule::with(['dosen', 'subject', 'overrides']);

        if ($cohort && $cohort !== '') {
            $query->where('cohort', $cohort);
        }

        return $query->orderBy('cohort', 'asc')->orderBy('day', 'asc')->get();
    }

    /**
     * Ambil data yang dibutuhkan form (subjects, dosens, cohorts).
     */
    public function getFormData(): array
    {
        return [
            'subjects'        => Subject::all(),
            'dosens'          => User::where('role', 'dosen')->get(),
            'availableCohorts' => User::where('role', 'mahasiswa')
                ->whereNotNull('cohort')
                ->distinct()
                ->pluck('cohort')
                ->filter(),
        ];
    }

    /**
     * Simpan jadwal baru.
     */
    public function store(array $data): Schedule
    {
        return Schedule::create([
            'subject_id' => $data['subject_id'],
            'user_id'    => $data['user_id'],
            'day'        => $data['day'],
            'start_time' => $data['start_time'],
            'end_time'   => $data['end_time'],
            'room'       => $data['room'],
            'cohort'     => $data['cohort'],
        ]);
    }

    /**
     * Hapus jadwal.
     */
    public function destroy(Schedule $schedule): void
    {
        $schedule->delete();
    }

    /**
     * Simpan atau update override jadwal.
     */
    public function storeOverride(Schedule $schedule, array $data): ScheduleOverride
    {
        $isCancelled = $data['status'] === 'cancelled';

        return $schedule->overrides()->updateOrCreate(
            ['override_date' => $data['override_date']],
            [
                'new_start_time' => $isCancelled ? null : $data['new_start_time'],
                'new_end_time'   => $isCancelled ? null : $data['new_end_time'],
                'new_room'       => $isCancelled ? null : $data['new_room'],
                'status'         => $data['status'],
                'note'           => $data['note'] ?? null,
            ]
        );
    }

    /**
     * Hapus override jadwal.
     */
    public function destroyOverride(ScheduleOverride $override): void
    {
        $override->delete();
    }
}
