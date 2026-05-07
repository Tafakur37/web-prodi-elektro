<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Services\AttendanceService;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function __construct(private AttendanceService $attendanceService) {}

    public function index()
    {
        $attendances = $this->attendanceService->getStudentAttendances(Auth::id());
        return view('mahasiswa.attendances.index', compact('attendances'));
    }
}
