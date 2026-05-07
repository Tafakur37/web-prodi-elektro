<?php

namespace App\Http\Controllers\Sesprodi;

use App\Http\Controllers\Controller;
use App\Models\Suggestion;
use Illuminate\Support\Facades\Auth;

class SesprodiDashboardController extends Controller
{
    public function index()
    {
        $suggestions = Suggestion::with('user')
            ->visibleFor(Auth::id())
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        return view('sesprodi.dashboard', compact('suggestions'));
    }
}
