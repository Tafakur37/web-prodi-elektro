<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLoggerService
{
    /**
     * Menyimpan log aktivitas ke database.
     *
     * @param string $action Nama aksi (contoh: 'login', 'create', 'update')
     * @param string $module Nama modul (contoh: 'Auth', 'User', 'Grade')
     * @param string|null $description Deskripsi opsional
     * @param int|null $userId ID user (jika null, ambil dari auth)
     */
    public function log(string $action, string $module, ?string $description = null, ?int $userId = null)
    {
        $userId = $userId ?? Auth::id();

        ActivityLog::create([
            'user_id'     => $userId,
            'action'      => $action,
            'module'      => $module,
            'description' => $description,
            'ip_address'  => Request::ip(),
        ]);
    }
}
