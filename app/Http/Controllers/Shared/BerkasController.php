<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\BerkasFolder;
use App\Models\BerkasFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BerkasController extends Controller
{
    /**
     * My Drive View (root or specific folder)
     */
    public function index($folder_id = null)
    {
        $user = Auth::user();
        
        $currentFolder = null;
        $breadcrumbs = [];
        
        if ($folder_id) {
            $currentFolder = BerkasFolder::where('id', $folder_id)
                ->where('user_id', $user->id)
                ->firstOrFail();
            
            // Build breadcrumbs
            $temp = $currentFolder;
            while ($temp) {
                array_unshift($breadcrumbs, $temp);
                $temp = $temp->parent;
            }
        }

        // Folders and Files
        $folders = BerkasFolder::where('user_id', $user->id)
            ->where('parent_id', $folder_id)
            ->orderBy('name')
            ->get();

        $files = BerkasFile::where('user_id', $user->id)
            ->where('folder_id', $folder_id)
            ->orderBy('name')
            ->get();

        $viewType = 'drive';

        return view('berkas.drive', compact('currentFolder', 'breadcrumbs', 'folders', 'files', 'user', 'viewType'));
    }

    /**
     * Shared with me View
     */
    public function shared()
    {
        $user = Auth::user();
        
        // Items shared directly with user
        $folders = BerkasFolder::whereHas('shares', function($q) use ($user) {
            $q->where('shared_with_user_id', $user->id)
              ->orWhere('shared_with_role', $user->role);
        })->get();

        $files = BerkasFile::whereHas('shares', function($q) use ($user) {
            $q->where('shared_with_user_id', $user->id)
              ->orWhere('shared_with_role', $user->role);
        })->get();

        $viewType = 'shared';
        $currentFolder = null;
        $breadcrumbs = [];
        return view('berkas.drive', compact('folders', 'files', 'user', 'viewType', 'currentFolder', 'breadcrumbs'));
    }

    /**
     * Recent View
     */
    public function recent()
    {
        $user = Auth::user();
        
        $files = BerkasFile::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();
            
        $folders = collect(); // Empty for recent
        $viewType = 'recent';
        $currentFolder = null;
        $breadcrumbs = [];

        return view('berkas.drive', compact('files', 'folders', 'user', 'viewType', 'currentFolder', 'breadcrumbs'));
    }

    /**
     * Starred View
     */
    public function starred()
    {
        $user = Auth::user();
        
        $folders = BerkasFolder::whereHas('stars', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->get();

        $files = BerkasFile::whereHas('stars', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->get();
        
        $viewType = 'starred';
        $currentFolder = null;
        $breadcrumbs = [];

        return view('berkas.drive', compact('folders', 'files', 'user', 'viewType', 'currentFolder', 'breadcrumbs'));
    }

    /**
     * Trash View
     */
    public function trash()
    {
        $user = Auth::user();
        
        $folders = BerkasFolder::onlyTrashed()->where('user_id', $user->id)->get();
        $files = BerkasFile::onlyTrashed()->where('user_id', $user->id)->get();
        
        $viewType = 'trash';
        $currentFolder = null;
        $breadcrumbs = [];

        return view('berkas.drive', compact('folders', 'files', 'user', 'viewType', 'currentFolder', 'breadcrumbs'));
    }
}
