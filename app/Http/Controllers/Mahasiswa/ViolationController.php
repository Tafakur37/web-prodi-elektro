<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Services\ViolationService;
use Illuminate\Support\Facades\Auth;

class ViolationController extends Controller
{
    protected $service;

    public function __construct(ViolationService $service)
    {
        $this->service = $service;
    }

    /**
     * Display student's own violations + total points
     */
    public function index()
    {
        $userId = Auth::id();
        $violations = $this->service->getByStudent($userId);
        $totalPoints = $this->service->getTotalPoint($userId);

        return view('mahasiswa.violations.index', compact('violations', 'totalPoints'));
    }
}
