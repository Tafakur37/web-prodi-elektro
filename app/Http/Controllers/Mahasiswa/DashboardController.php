<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Ambil jadwal utama + overrides untuk cohort mahasiswa ini
        $baseSchedules = Schedule::with(['dosen', 'subject', 'overrides'])
            ->where('cohort', $user->cohort) 
            ->get();

        // 2. Buat rentang 7 Hari (Senin - Minggu minggu ini)
        $startOfWeek = \Carbon\Carbon::now()->startOfWeek(); // Senin
        $weeklySchedules = [];

        $indonesianDays = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu',
        ];

        for ($i = 0; $i < 7; $i++) {
            $currentDate = $startOfWeek->copy()->addDays($i);
            $dayNameEnglish = $currentDate->format('l');
            $dayNameIndo = $indonesianDays[$dayNameEnglish];

            // Filter jadwal dasar yang harinya sesuai
            $schedulesToday = $baseSchedules->filter(function($schedule) use ($dayNameIndo) {
                return $schedule->day === $dayNameIndo;
            })->map(function($schedule) use ($currentDate) {
                $item = clone $schedule;
                // Cek apakah ada override untuk tanggal ini
                $activeOverride = $schedule->overrides->firstWhere('override_date', $currentDate->format('Y-m-d'));
                
                if ($activeOverride) {
                    $item->is_overridden = true;
                    $item->override_status = $activeOverride->status;
                    if ($activeOverride->status === 'changed') {
                        $item->start_time = \Carbon\Carbon::parse($activeOverride->new_start_time)->format('H:i');
                        $item->end_time = \Carbon\Carbon::parse($activeOverride->new_end_time)->format('H:i');
                        $item->room = $activeOverride->new_room;
                    }
                    $item->override_note = $activeOverride->note;
                } else {
                    $item->is_overridden = false;
                }
                
                return $item;
            });

            $weeklySchedules[] = [
                'date'      => $currentDate,
                'day_name'  => $dayNameIndo,
                'schedules' => $schedulesToday->sortBy('start_time')->values()
            ];
        }

        return view('mahasiswa.dashboard', compact('weeklySchedules'));
    }
}