<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\ActivityLog;

class AdminSettingsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $activities = ActivityLog::where('user_id', $user->id)
                                 ->where('action', 'login')
                                 ->latest()
                                 ->take(5)
                                 ->get();

        return view('admin.settings.index', compact('user', 'activities'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete('profiles/' . $user->profile_photo);
            }
            $filename = time() . '_' . $request->file('profile_photo')->getClientOriginalName();
            $request->file('profile_photo')->storeAs('profiles', $filename, 'public');
            $data['profile_photo'] = $filename;
        }

        $user->update($data);
        app(\App\Services\ActivityLoggerService::class)->log('update', 'Settings', 'Updated personal profile');

        return back()->with('success', 'Profile berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('error', 'Password lama tidak cocok!');
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);
        
        app(\App\Services\ActivityLoggerService::class)->log('update_password', 'Settings', 'Updated personal password');

        return back()->with('success', 'Password berhasil diubah!');
    }

    public function updatePreferences(Request $request)
    {
        $request->validate([
            'theme' => 'required|in:light,dark'
        ]);

        auth()->user()->update(['theme' => $request->theme]);
        app(\App\Services\ActivityLoggerService::class)->log('update', 'Settings', 'Changed theme preference to ' . $request->theme);

        return back()->with('success', 'Preferensi tema berhasil disimpan!');
    }
}
