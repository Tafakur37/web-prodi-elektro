<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * index — 2-step:
     *   Tanpa ?cohort → tampilkan pilihan cohort (card grid)
     *   Dengan ?cohort → tampilkan tabel mahasiswa dalam cohort tersebut
     */
    public function index(Request $request)
    {
        $availableCohorts = User::where('role', 'mahasiswa')
            ->whereNotNull('cohort')
            ->distinct()
            ->orderBy('cohort', 'asc')
            ->pluck('cohort');

        // Step 1: belum pilih cohort
        if (!$request->filled('cohort')) {
            // Statistik per cohort
            $cohortStats = [];
            foreach ($availableCohorts as $cohort) {
                $cohortStats[$cohort] = User::where('role', 'mahasiswa')
                    ->where('cohort', $cohort)
                    ->count();
            }
            return view('staff.students.cohort', compact('availableCohorts', 'cohortStats'));
        }

        // Step 2: sudah pilih cohort, tampilkan tabel mahasiswa
        $selectedCohort = $request->cohort;

        $query = User::where('role', 'mahasiswa')->where('cohort', $selectedCohort);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nim',  'like', "%{$search}%");
            });
        }

        $students = $query->orderBy('name', 'asc')->paginate(20)->withQueryString();

        return view('staff.students.index', compact('students', 'availableCohorts', 'selectedCohort'));
    }

    /**
     * Reset password mahasiswa
     */
    public function resetPassword(Request $request, User $student)
    {
        if ($student->role !== 'mahasiswa') {
            abort(403);
        }

        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        $student->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', "Password {$student->name} berhasil direset!");
    }

    /**
     * Update data mahasiswa
     */
    public function update(Request $request, User $student)
    {
        if ($student->role !== 'mahasiswa') {
            abort(403);
        }

        $request->validate([
            'name'             => 'required|string|max:255',
            'nim'              => 'required|unique:users,nim,' . $student->id,
            'cohort'           => 'nullable|integer',
            'gender'           => 'nullable|in:L,P',
            'status_keaktifan' => 'nullable|in:Aktif,Tidak Aktif',
        ]);

        $student->update([
            'name'             => $request->name,
            'nim'              => $request->nim,
            'cohort'           => $request->cohort,
            'gender'           => $request->gender,
            'status_keaktifan' => $request->status_keaktifan,
        ]);

        return back()->with('success', "Data mahasiswa {$student->name} berhasil diperbarui!");
    }
}
