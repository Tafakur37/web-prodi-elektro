<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('lecturers')->orderBy('semester', 'asc')->orderBy('name', 'asc')->get();
        $dosens = \App\Models\User::where('role', 'dosen')->orderBy('name', 'asc')->get();
        $prefix = request()->is('staff/*') ? 'staff' : 'admin';
        return view('subjects.index', compact('subjects', 'dosens', 'prefix'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:subjects,code',
            'name' => 'required|string|max:255',
            'sks' => 'required|integer|min:1',
            'semester' => 'required|integer|min:1',
            'kkm_uts' => 'required|integer|min:0|max:100',
            'kkm_uas' => 'required|integer|min:0|max:100',
            'meetings' => 'required|integer|min:1',
            'weight_task' => 'required|integer|min:0|max:100',
            'weight_uts' => 'required|integer|min:0|max:100',
            'weight_uas' => 'required|integer|min:0|max:100',
            'lecturers' => 'nullable|array',
            'lecturers.*' => 'exists:users,id',
        ]);

        if (($request->weight_task + $request->weight_uts + $request->weight_uas) !== 100) {
            return back()->withErrors(['weight_task' => 'Total bobot (Tugas + UTS + UAS) harus bernilai persis 100%.'])->withInput();
        }

        $subject = Subject::create($request->except('lecturers'));
        
        if ($request->has('lecturers')) {
            $subject->lecturers()->sync($request->lecturers);
        }
        
        app(\App\Services\ActivityLoggerService::class)->log('create', 'Mata Kuliah', "Menambahkan matkul baru: {$request->name}");
        return back()->with('success', 'Mata Kuliah berhasil ditambahkan.');
    }

    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'code' => 'required|unique:subjects,code,'.$subject->id,
            'name' => 'required|string|max:255',
            'sks' => 'required|integer|min:1',
            'semester' => 'required|integer|min:1',
            'kkm_uts' => 'required|integer|min:0|max:100',
            'kkm_uas' => 'required|integer|min:0|max:100',
            'meetings' => 'required|integer|min:1',
            'weight_task' => 'required|integer|min:0|max:100',
            'weight_uts' => 'required|integer|min:0|max:100',
            'weight_uas' => 'required|integer|min:0|max:100',
            'lecturers' => 'nullable|array',
            'lecturers.*' => 'exists:users,id',
        ]);

        if (($request->weight_task + $request->weight_uts + $request->weight_uas) !== 100) {
            return back()->withErrors(['weight_task' => 'Total bobot (Tugas + UTS + UAS) harus bernilai persis 100%.'])->withInput();
        }

        $subject->update($request->except('lecturers'));
        
        if ($request->has('lecturers')) {
            $subject->lecturers()->sync($request->lecturers);
        } else {
            $subject->lecturers()->detach();
        }
        
        app(\App\Services\ActivityLoggerService::class)->log('update', 'Mata Kuliah', "Memperbarui matkul: {$subject->name}");
        return back()->with('success', 'Mata Kuliah berhasil diperbarui.');
    }

    public function destroy(Subject $subject)
    {
        app(\App\Services\ActivityLoggerService::class)->log('delete', 'Mata Kuliah', "Menghapus matkul: {$subject->name}");
        $subject->delete();
        return back()->with('success', 'Mata Kuliah berhasil dihapus.');
    }
}
