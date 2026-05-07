<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Ukm;

class UkmController extends Controller
{
    public function index()
    {
        $ukms = Ukm::all();
        return view('mahasiswa.ukms.index', compact('ukms'));
    }
}
