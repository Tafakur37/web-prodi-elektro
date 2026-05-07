<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RemindAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:remind';
    protected $description = 'Remind dosen to input attendance after a class ends';

    public function handle()
    {
        // Get schedules that ended in the last 5 minutes today
        $now = \Carbon\Carbon::now();
        $today = $now->format('l');
        $dayMap = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        $dayIndo = $dayMap[$today] ?? $today;

        // E.g. Check classes that ended between 5 mins ago and now
        // This command should run every minute
        $fiveMinsAgo = $now->copy()->subMinutes(5)->format('H:i:s');
        $nowTime = $now->format('H:i:s');

        $schedules = \App\Models\Schedule::where('day', $dayIndo)
            ->whereTime('end_time', '<=', $nowTime)
            ->whereTime('end_time', '>', $fiveMinsAgo)
            ->with(['dosen', 'subject'])
            ->get();

        foreach ($schedules as $schedule) {
            // Check if attendance already exists
            $attendanceExists = \App\Models\Attendance::where('subject_id', $schedule->subject_id)
                ->where('date', $now->toDateString())
                ->where('lecturer_id', $schedule->user_id)
                ->exists();

            if (!$attendanceExists && $schedule->dosen) {
                // Determine the cohort, this assumes Schedule has cohort or we pick from somewhere else
                // For now, we will just send a link with subject_id and date
                // If schedule has cohort, we add it. Otherwise, they choose manually.
                $cohort = $schedule->cohort ?? '';
                $url = route('dosen.attendances.index', [
                    'subject_id' => $schedule->subject_id,
                    'cohort' => $cohort,
                    'date' => $now->toDateString()
                ]);

                $schedule->dosen->notify(new \App\Notifications\AppNotification([
                    'title' => 'Pengingat Absensi Kadet',
                    'message' => 'Kelas ' . ($schedule->subject->name ?? 'Mata Kuliah') . ' telah selesai. Jangan lupa mengisi absensi kadet.',
                    'url' => $url,
                    'type' => 'info',
                ]));

                $this->info("Reminder sent to {$schedule->dosen->name} for subject {$schedule->subject_id}");
            }
        }
        
        $this->info('Attendance reminder check completed.');
    }
}
