<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Services\ScheduleService;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function __construct(private ScheduleService $scheduleService) {}

    public function index(Request $request)
    {
        $cohort = $request->has('cohort') && $request->cohort != '' ? $request->cohort : null;
        $schedules = $this->scheduleService->getAll($cohort);
        $formData = $this->scheduleService->getFormData();

        return view('staff.schedules.index', array_merge(
            compact('schedules'),
            $formData
        ));
    }

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

        $this->scheduleService->store($request->all());

        return redirect()->back()->with('success', 'Jadwal berhasil disimpan!');
    }

    public function destroy(Schedule $schedule)
    {
        $this->scheduleService->destroy($schedule);
        return back()->with('success', 'Jadwal berhasil dihapus!');
    }
}
