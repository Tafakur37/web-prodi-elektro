<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Services\ViolationService;
use Illuminate\Http\Request;
use App\Http\Requests\Staff\ViolationStoreRequest;
use App\Http\Requests\Staff\ViolationUpdateRequest;

class ViolationController extends Controller
{
    protected $service;

    public function __construct(ViolationService $service)
    {
        $this->service = $service;
    }

    /**
     * Display listing of violations (Staff/Admin)
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $cohort = $request->query('cohort');

        $violations = $this->service->getAll(15, $search, $cohort);
        $cohorts = \App\Models\User::where('role', 'mahasiswa')
            ->whereNotNull('cohort')
            ->distinct()
            ->orderBy('cohort')
            ->pluck('cohort');

        return view('staff.violations.index', compact('violations', 'cohorts'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $students = \App\Models\User::where('role', 'mahasiswa')
            ->select('id', 'name', 'nim', 'cohort')
            ->orderBy('cohort')
            ->orderBy('name')
            ->get();
        $cohorts = $students->pluck('cohort')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        return view('staff.violations.create', compact('students', 'cohorts'));
    }

    /**
     * Store new violation
     */
    public function store(ViolationStoreRequest $request)
    {
        $validated = $request->validated();

        try {
            $this->service->create($validated);

            return redirect()->route('staff.violations.index')
                ->with('success', 'Pelanggaran berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $violation = $this->service->find($id);

        return view('staff.violations.edit', compact('violation'));
    }

    /**
     * Update violation
     */
    public function update(ViolationUpdateRequest $request, $id)
    {
        $validated = $request->validated();

        try {
            $this->service->update($id, $validated);

            return redirect()->route('staff.violations.index')
                ->with('success', 'Pelanggaran berhasil diupdate.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Delete violation
     */
    public function destroy($id)
    {
        try {
            $this->service->delete($id);

            return redirect()->route('staff.violations.index')
                ->with('success', 'Pelanggaran berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
