<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardService
{
    public function overview(): array
    {
        $today = Carbon::today();

        return [
            'totalMahasiswa' => User::where('role', 'mahasiswa')->count(),
            'totalDosen' => User::where('role', 'dosen')->count(),
            'totalUsers' => User::count(),
            'mahasiswaPerCohort' => User::where('role', 'mahasiswa')
                ->select('cohort', DB::raw('count(*) as total'))
                ->whereNotNull('cohort')
                ->groupBy('cohort')
                ->orderBy('cohort', 'desc')
                ->get(),
            'activitiesToday' => ActivityLog::whereDate('created_at', $today)->count(),
            'loginsToday' => ActivityLog::whereDate('created_at', $today)
                ->where('action', 'login')
                ->count(),
            'activities' => ActivityLog::with('user')
                ->latest()
                ->take(5)
                ->get(),
        ];
    }
}
