<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\FitnessTest;
use App\Services\FitnessTestService;
use App\Services\GarjasCalculatorService;
use Illuminate\Http\Request;

class FitnessTestController extends Controller
{
    public function __construct(private FitnessTestService $fitnessTestService) {}

    public function index(Request $request)
    {
        $data = $this->fitnessTestService->getIndexData($request->semester, $request->cohort);
        return view('staff.fitness_tests.index', $data);
    }

    public function store(Request $request, GarjasCalculatorService $calculator)
    {
        $request->validate([
            'user_id'          => 'required|exists:users,id',
            'semester'         => 'required|integer',
            'test_date'        => 'required|date',
            'raw_lari'         => 'nullable|numeric|min:0',
            'raw_pull_up'      => 'nullable|integer|min:0',
            'raw_chinning'     => 'nullable|integer|min:0',
            'raw_sit_up'       => 'nullable|integer|min:0',
            'raw_push_up'      => 'nullable|integer|min:0',
            'raw_shuttle_run'  => 'nullable|numeric|min:0',
            'raw_renang'       => 'nullable|numeric|min:0',
        ]);

        $calculated = $this->fitnessTestService->store($request->all(), $calculator);

        return redirect()->back()->with('success', 'Data Garjas berhasil disimpan! Total: ' . $calculated['total_score']);
    }

    public function destroy(FitnessTest $fitnessTest)
    {
        $this->fitnessTestService->destroy($fitnessTest);
        return redirect()->back()->with('success', 'Data Garjas berhasil dihapus!');
    }
}
