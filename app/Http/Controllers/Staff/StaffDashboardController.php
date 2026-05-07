<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Announcement;
use App\Models\Suggestion;
use Carbon\Carbon;

class StaffDashboardController extends Controller
{
    public function index()
    {
        $staff = Auth::user();

        // 1. Statistik
        $dosenCount = User::where('role', 'dosen')->count();
        $mahasiswaCount = User::where('role', 'mahasiswa')->count();
        $cohortCount = User::where('role', 'mahasiswa')->whereNotNull('cohort')->distinct('cohort')->count('cohort');

        // 2. Pengumuman
        $announcements = Announcement::orderBy('created_at', 'desc')->take(5)->get();

        // 3. Jadwal Hari Ini per Cohort
        $today = Carbon::today();
        $todayEnglish = $today->format('l');
        $dayMap = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        $dayIndo = $dayMap[$todayEnglish] ?? $todayEnglish;

        $todaySchedules = Schedule::where('day', $dayIndo)
            ->with(['subject', 'dosen'])
            ->orderBy('start_time')
            ->get()
            ->groupBy('cohort');

        // 4. Notifikasi (Mengambil dari notifiable trait)
        $notifications = $staff->notifications()->take(5)->get();

        // 5. Jadwal Mingguan Semua Cohort
        $weeklySchedules = Schedule::with(['subject', 'dosen'])
            ->orderByRaw("FIELD(day, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('start_time')
            ->get()
            ->groupBy('cohort');

        // 6. Kotak Saran Mahasiswa
        $suggestions = Suggestion::with('user')
            ->visibleFor($staff->id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('staff.dashboard', compact(
            'staff',
            'dosenCount',
            'mahasiswaCount',
            'cohortCount',
            'announcements',
            'todaySchedules',
            'notifications',
            'dayIndo',
            'weeklySchedules',
            'suggestions'
        ));
    }
}

