<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Services\AchievementService;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function __construct(private AchievementService $achievementService) {}

    public function index(Request $request)
    {
        $cohort = ($request->has('cohort') && $request->cohort != '') ? $request->cohort : null;
        $achievements = $this->achievementService->getAll($cohort);
        $formData = $this->achievementService->getFormData();

        return view('staff.achievements.index', array_merge(
            compact('achievements'),
            $formData
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'level' => 'required|string|max:100',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif,doc,docx,ppt,pptx,xls,xlsx,zip|max:10240'
        ]);

        $this->achievementService->store($request->all(), $request->file('attachment'));

        return redirect()->back()->with('success', 'Prestasi berhasil ditambahkan!');
    }

    public function destroy(Achievement $achievement)
    {
        $this->achievementService->destroy($achievement);
        return redirect()->back()->with('success', 'Prestasi berhasil dihapus!');
    }
}
