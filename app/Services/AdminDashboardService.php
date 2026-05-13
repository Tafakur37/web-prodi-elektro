<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Document;
use App\Models\Submission;
use App\Models\Attendance;
use App\Models\Violation;
use App\Models\Announcement;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardService
{
    public function overview(): array
    {
        $today = Carbon::today();

        // ── User Stats ────────────────────────────────────────────────────
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();
        $totalDosen     = User::where('role', 'dosen')->count();
        $totalStaff     = User::where('role', 'staff')->count();
        $totalUsers     = User::count();

        // ── Akademik ──────────────────────────────────────────────────────
        $mahasiswaPerCohort = User::where('role', 'mahasiswa')
            ->select('cohort', DB::raw('count(*) as total'))
            ->whereNotNull('cohort')
            ->groupBy('cohort')
            ->orderBy('cohort', 'desc')
            ->get();

        // ── Absensi hari ini ──────────────────────────────────────────────
        $absensiToday = 0;
        try {
            $absensiToday = Attendance::whereDate('created_at', $today)->count();
        } catch (\Exception $e) {}

        // ── Pelanggaran terbaru ───────────────────────────────────────────
        $recentViolations = collect();
        try {
            $recentViolations = Violation::with('user')
                ->latest()
                ->take(5)
                ->get();
        } catch (\Exception $e) {}

        // ── Surat/Dokumen terbaru ─────────────────────────────────────────
        $recentDocuments = collect();
        try {
            $recentDocuments = Submission::with('user')
                ->latest()
                ->take(5)
                ->get();
        } catch (\Exception $e) {}

        // ── Pengumuman terbaru ────────────────────────────────────────────
        $recentAnnouncements = collect();
        try {
            $recentAnnouncements = Announcement::latest()->take(3)->get();
        } catch (\Exception $e) {}

        // ── Activity Log ──────────────────────────────────────────────────
        $activitiesToday = ActivityLog::whereDate('created_at', $today)->count();
        $loginsToday     = ActivityLog::whereDate('created_at', $today)
            ->where('action', 'login')
            ->count();
        $activities = ActivityLog::with('user')->latest()->take(8)->get();

        // ── Mahasiswa terbaru (registrasi baru) ───────────────────────────
        $newMahasiswa = User::where('role', 'mahasiswa')
            ->latest()
            ->take(5)
            ->get();

        return [
            // Counts
            'totalMahasiswa'      => $totalMahasiswa,
            'totalDosen'          => $totalDosen,
            'totalStaff'          => $totalStaff,
            'totalUsers'          => $totalUsers,
            'activitiesToday'     => $activitiesToday,
            'loginsToday'         => $loginsToday,
            'absensiToday'        => $absensiToday,

            // Collections
            'mahasiswaPerCohort'  => $mahasiswaPerCohort,
            'activities'          => $activities,
            'recentViolations'    => $recentViolations,
            'recentDocuments'     => $recentDocuments,
            'recentAnnouncements' => $recentAnnouncements,
            'newMahasiswa'        => $newMahasiswa,
        ];
    }
}
