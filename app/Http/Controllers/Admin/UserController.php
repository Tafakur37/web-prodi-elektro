<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua user.
     * Mendukung view untuk Admin dan Staff.
     */
    public function index()
    {
        $users = User::latest()->get();

        // Deteksi folder view berdasarkan URL (admin atau staff)
        $viewPath = request()->is('staff/*') ? 'staff.users.index' : 'admin.users.index';

        return view($viewPath, compact('users'));
    }

    /**
     * Menampilkan form pembuatan user (jika tidak pakai modal).
     */
    public function create()
    {
        $viewPath = request()->is('staff/*') ? 'staff.users.create' : 'admin.users.create';
        return view($viewPath);
    }

    /**
     * Menyimpan akun baru ke database.
     * Digunakan bersama oleh Admin dan Staff.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input dengan kondisi cohort untuk mahasiswa
        $rules = [
            'name'     => 'required|string|max:255',
            'gender'   => 'required|in:L,P',
            'nim'      => 'nullable|string|unique:users,nim',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role'     => 'required|in:admin,dosen,mahasiswa,staff,sesprodi,kaprodi',
            'cohort'   => 'nullable|integer|min:1|max:20',
        ];

        // Buat cohort wajib untuk mahasiswa (angka angkatan/semester 1-20)
        if ($request->role === 'mahasiswa') {
            $rules['cohort'] = 'required|integer|min:1|max:20';
        }

        $request->validate($rules);

        // 2. Eksekusi Pembuatan User
        User::create([
            'name'     => $request->name,
            'gender'   => $request->gender,
            'email'    => $request->email,
            'nim'      => $request->nim,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'cohort'   => in_array($request->role, ['mahasiswa']) ? $request->cohort : null,
        ]);

        // 3. Redirect Dinamis
        $redirectRoute = request()->is('staff/*') ? 'staff.users.index' : 'admin.users.index';

        return redirect()->route($redirectRoute)->with('success', "✅ Akun {$request->name} sebagai {$request->role} berhasil didaftarkan!");
    }

    /**
     * Reset Password User.
     */
    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed'
        ]);

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', "Password untuk {$user->name} berhasil diperbarui!");
    }

    /**
     * Menghapus akun secara permanen.
     */
    public function destroy(User $user)
    {
        // Proteksi: Jangan biarkan user menghapus dirinya sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        $user->delete();
        return back()->with('success', 'Akun berhasil dihapus permanen.');
    }

    public function edit(User $user)
    {
        // Pastikan view ini sudah kamu buat
        return view('staff.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required',
        ]);

        $user->update($request->all());

        return redirect()->route('staff.accounts.index')->with('success', 'Data user berhasil diperbarui!');
    }

    // app/Http/Controllers/Admin/UserController.php

    public function suggestions(Request $request)
    {
        $query = $request->get('query');

        $users = User::where('role', 'mahasiswa')
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                    ->orWhere('nim', 'LIKE', "%{$query}%");
            })
            ->limit(10)
            ->get(['id', 'name', 'nim']);

        return response()->json($users);
    }
    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user->update([
            'password' => bcrypt($request->password)
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Password berhasil direset!');
    }

    public function searchUsersForChat(Request $request)
    {
        $query = $request->get('query');
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $users = User::where('id', '!=', auth()->id())
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('nim', 'LIKE', "%{$query}%")
                  ->orWhere('email', 'LIKE', "%{$query}%");
            })
            ->limit(10)
            ->get(['id', 'name', 'nim', 'role', 'profile_photo']);

        return response()->json($users);
    }

    public function unreadChatsCount()
    {
        $count = \App\Models\Chat::where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->where('deleted_by_receiver', false)
            ->count();

        return response()->json(['count' => $count]);
    }
}