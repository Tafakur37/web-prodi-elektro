<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Schedule;
use App\Models\Exam;
use App\Models\Announcement;
use App\Models\Meeting;
use App\Models\User;
use App\Models\Subject;
use DB;

class DosenDashboardController extends Controller
{
    public function index()
    {
        $dosen = Auth::user();

        // Teaching subjects via pivot
        $subjects = Subject::whereHas('lecturers', function ($q) use ($dosen) {
            $q->where('user_id', $dosen->id);
        })->orderBy('semester')->get();

        // Jadwal Hari Ini
        $today = Carbon::today();
        $todayEnglish = $today->format('l');
        $dayMap = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
        $dayIndo = $dayMap[$todayEnglish] ?? $todayEnglish;

        $todaySchedules = Schedule::where('user_id', $dosen->id)
            ->where('day', $dayIndo)
            ->with('subject')
            ->orderBy('start_time')
            ->get();

        // Jadwal Mingguan (simplified, group by day)
        $weeklySchedules = Schedule::where('user_id', $dosen->id)
            ->orderBy('day')
            ->get()
            ->groupBy('day');

        // Jadwal Ujian
        $exams = Exam::whereHas('subject.lecturers', function ($q) use ($dosen) {
            $q->where('user_id', $dosen->id);
        })->with('subject')
            ->orderBy('date')
            ->take(5)
            ->get();

        // Pengumuman Prodi (latest)
        $announcements = Announcement::whereIn('target_role', ['all', 'dosen'])
            ->orderBy('created_at', 'desc')->take(5)->get();

        // Bimbingan Mahasiswa (pending)
        $bimbingan = Meeting::where('dosen_id', $dosen->id)
            ->where('status', 'pending')
            ->with('student')
            ->orderBy('requested_date', 'desc')
            ->take(5)
            ->get();

        return view('dosen.dashboard', compact(
            'dosen',
            'subjects',
            'todaySchedules',
            'weeklySchedules',
            'exams',
            'announcements',
            'bimbingan'
        ));
    }
}
