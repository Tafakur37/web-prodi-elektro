<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\Suggestion;
use Illuminate\Support\Facades\Auth;

class KaprodiDashboardController extends Controller
{
    public function index()
    {
        $suggestions = Suggestion::with('user')
            ->visibleFor(Auth::id())
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        return view('kaprodi.dashboard', compact('suggestions'));
    }
}
