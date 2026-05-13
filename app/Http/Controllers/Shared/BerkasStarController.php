<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\BerkasStar;
use App\Models\BerkasFolder;
use App\Models\BerkasFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BerkasStarController extends Controller
{
    public function toggleStar(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'type' => 'required|in:file,folder'
        ]);

        $userId = Auth::id();
        $modelClass = $request->type === 'file' ? BerkasFile::class : BerkasFolder::class;
        $modelId = $request->id;

        $existing = BerkasStar::where('user_id', $userId)
            ->where('starrable_id', $modelId)
            ->where('starrable_type', $modelClass)
            ->first();

        if ($existing) {
            $existing->delete();
            return back()->with('success', ucfirst($request->type) . ' dihapus dari berbintang.');
        } else {
            BerkasStar::create([
                'user_id' => $userId,
                'starrable_id' => $modelId,
                'starrable_type' => $modelClass,
            ]);
            return back()->with('success', ucfirst($request->type) . ' ditambahkan ke berbintang.');
        }
    }
}
