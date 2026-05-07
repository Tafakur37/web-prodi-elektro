<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\ScheduleOverride;
use App\Services\ScheduleService;
use Illuminate\Http\Request;

class ScheduleOverrideController extends Controller
{
    public function __construct(private ScheduleService $scheduleService) {}

    public function store(Request $request, Schedule $schedule)
    {
        $request->validate([
            'override_date' => 'required|date',
            'status' => 'required|in:changed,cancelled',
            'new_start_time' => 'nullable|required_if:status,changed|date_format:H:i',
            'new_end_time' => 'nullable|required_if:status,changed|date_format:H:i',
            'new_room' => 'nullable|required_if:status,changed|string|max:255',
            'note' => 'nullable|string'
        ]);

        $this->scheduleService->storeOverride($schedule, $request->all());

        return back()->with('success', 'Perubahan jadwal berhasil disimpan!');
    }

    public function destroy(ScheduleOverride $override)
    {
        $this->scheduleService->destroyOverride($override);
        return back()->with('success', 'Perubahan jadwal berhasil dihapus (Jadwal kembali normal).');
    }
}
