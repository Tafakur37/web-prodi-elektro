<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AdminLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user');

        // Search by description or user name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by Date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Filter by Action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by Module
        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        $logs = $query->latest()->paginate(15)->withQueryString();

        // Get unique actions and modules for the dropdown filters
        $actions = ActivityLog::select('action')->distinct()->pluck('action');
        $modules = ActivityLog::select('module')->distinct()->pluck('module');

        return view('admin.logs.index', compact('logs', 'actions', 'modules'));
    }
}
