<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminDashboardService;
use Illuminate\Support\Facades\Log;

class AdminDashboardController extends Controller
{
    public function __construct(private AdminDashboardService $dashboardService) {}

    /**
     * Menampilkan Dashboard Statistik Admin
     */
    public function index()
    {
        try {
            return view('admin.dashboard', $this->dashboardService->overview());
        } catch (\Throwable $exception) {
            Log::error('Admin dashboard failed: ' . $exception->getMessage(), [
                'exception' => $exception,
            ]);

            return view('admin.dashboard', [
                'totalMahasiswa' => 0,
                'totalDosen' => 0,
                'totalUsers' => 0,
                'mahasiswaPerCohort' => collect(),
                'activities' => collect(),
                'activitiesToday' => 0,
                'loginsToday' => 0,
            ])->with('error', 'Dashboard gagal dimuat. Silakan coba lagi.');
        }
    }
}
