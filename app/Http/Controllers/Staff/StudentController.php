<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'mahasiswa');
        
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nim', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('cohort') && $request->cohort != '') {
            $query->where('cohort', $request->cohort);
        }

        $students = $query->orderBy('cohort', 'asc')->orderBy('name', 'asc')->paginate(20);
        $availableCohorts = User::where('role', 'mahasiswa')->whereNotNull('cohort')->distinct()->pluck('cohort')->filter();

        return view('staff.students.index', compact('students', 'availableCohorts'));
    }

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

        return back()->with('success', 'Password mahasiswa berhasil direset!');
    }
    
    public function update(Request $request, User $student)
    {
        if ($student->role !== 'mahasiswa') {
            abort(403);
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'nim'  => 'required|unique:users,nim,' . $student->id,
            'cohort' => 'nullable|integer'
        ]);

        $student->update([
            'name' => $request->name,
            'nim' => $request->nim,
            'cohort' => $request->cohort
        ]);

        return back()->with('success', 'Data mahasiswa berhasil diperbarui!');
    }
}
