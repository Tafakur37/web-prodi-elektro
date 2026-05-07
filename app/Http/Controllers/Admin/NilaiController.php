<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Pastikan model User sudah benar
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index()
    {
        $semesters = [1, 2, 3, 4, 5, 6, 7, 8];

        // MENGAMBIL DATA DINAMIS:
        // Hanya mengambil nilai cohort unik dari user dengan role 'mahasiswa'
        $cohorts = User::where('role', 'mahasiswa')
            ->whereNotNull('cohort')
            ->select('cohort')
            ->distinct()
            ->orderBy('cohort', 'asc')
            ->get();

        return view('admin.grades.index', compact('semesters', 'cohorts'));
    }
}