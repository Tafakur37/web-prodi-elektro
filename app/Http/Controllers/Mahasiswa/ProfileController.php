<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('mahasiswa.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'nullable|in:L,P',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        $user->name = $request->name;
        $user->gender = $request->gender;

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete('profiles/' . $user->profile_photo);
            }
            $filename = time() . '.' . $request->profile_photo->extension();
            $request->profile_photo->storeAs('profiles', $filename, 'public');
            $user->profile_photo = $filename;
        } elseif ($request->has('remove_photo') && $request->remove_photo == '1') {
            if ($user->profile_photo) {
                Storage::disk('public')->delete('profiles/' . $user->profile_photo);
                $user->profile_photo = null;
            }
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
