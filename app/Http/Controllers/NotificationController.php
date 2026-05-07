<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function fetch()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $unreadNotifications = $user->unreadNotifications()->take(10)->get();
        $unreadCount = $user->unreadNotifications()->count();

        $formatted = $unreadNotifications->map(function ($notification) {
            return [
                'id' => $notification->id,
                'title' => $notification->data['title'] ?? 'Notifikasi',
                'message' => $notification->data['message'] ?? '',
                'type' => $notification->data['type'] ?? 'info',
                'submission_id' => $notification->data['submission_id'] ?? null,
                'time' => $notification->created_at->diffForHumans(),
            ];
        });

        return response()->json([
            'success' => true,
            'count' => $unreadCount,
            'notifications' => $formatted
        ]);
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }
}
