<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Services\ScheduleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{
    public function __construct(private ScheduleService $scheduleService) {}

    /**
     * Menampilkan daftar jadwal (Admin)
     */
    public function index()
    {
        try {
            $schedules = $this->scheduleService->getAll();
            $formData = $this->scheduleService->getFormData();

            return view('admin.schedules.index', array_merge(
                compact('schedules'),
                $formData
            ));
        } catch (\Throwable $exception) {
            Log::error('Admin schedules failed: ' . $exception->getMessage(), ['exception' => $exception]);

            return view('admin.schedules.index', [
                'schedules' => collect(),
                'subjects' => collect(),
                'dosens' => collect(),
                'availableCohorts' => collect(),
            ])->with('error', 'Jadwal gagal dimuat.');
        }
    }

    /**
     * Menyimpan jadwal baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required',
            'user_id'    => 'required',
            'day'        => 'required',
            'start_time' => 'required',
            'end_time'   => 'required',
            'room'       => 'required',
            'cohort'     => 'required',
        ]);

        try {
            $this->scheduleService->store($request->all());
        } catch (\Throwable $exception) {
            Log::error('Admin schedule store failed: ' . $exception->getMessage(), ['exception' => $exception]);

            return back()->withInput()->with('error', 'Jadwal gagal disimpan.');
        }

        return redirect()->back()->with('success', 'Jadwal berhasil disimpan!');
    }

    /**
     * Menghapus jadwal
     */
    public function destroy(Schedule $schedule)
    {
        try {
            $this->scheduleService->destroy($schedule);
            return back()->with('success', 'Jadwal berhasil dihapus!');
        } catch (\Throwable $exception) {
            Log::error('Admin schedule delete failed: ' . $exception->getMessage(), ['exception' => $exception]);

            return back()->with('error', 'Jadwal gagal dihapus.');
        }
    }
}
