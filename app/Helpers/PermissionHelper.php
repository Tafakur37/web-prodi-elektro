<?php

namespace App\Helpers;

/**
 * =============================================================================
 * PERMISSION HELPER — SIMelek
 * =============================================================================
 *
 * Helper global untuk mengecek izin berdasarkan config/permissions.php.
 * Bisa digunakan di Controller, Blade, dan Middleware.
 *
 * Penggunaan di Controller:
 *   PermissionHelper::can('documents', 'approve')  // true/false
 *   PermissionHelper::canOrAbort('documents', 'delete')  // abort 403 jika tidak
 *
 * Penggunaan di Blade (via @if):
 *   @if(can_do('documents', 'approve'))
 *       <button>Approve</button>
 *   @endif
 * =============================================================================
 */

class PermissionHelper
{
    /**
     * Cek apakah user yang sedang login BOLEH melakukan aksi tertentu.
     *
     * @param string $feature  Nama fitur (key di config/permissions.php)
     * @param string $action   Nama aksi (view_own, view_all, create, dll.)
     * @param \App\Models\User|null $user  User yang dicek (default: user login)
     * @return bool
     */
    public static function can(string $feature, string $action, $user = null): bool
    {
        $user = $user ?? auth()->user();

        if (!$user) {
            return false;
        }

        // Admin selalu bisa segalanya
        if ($user->role === 'admin') {
            return true;
        }

        $permissions = config("permissions.{$feature}.{$action}", []);

        return in_array($user->role, $permissions);
    }

    /**
     * Cek permission dan abort 403 jika tidak punya izin.
     */
    public static function canOrAbort(string $feature, string $action, $user = null): void
    {
        if (!static::can($feature, $action, $user)) {
            abort(403, 'Anda tidak memiliki izin untuk melakukan aksi ini.');
        }
    }

    /**
     * Cek apakah user bisa lihat semua data (bukan hanya milik sendiri).
     */
    public static function canViewAll(string $feature, $user = null): bool
    {
        return static::can($feature, 'view_all', $user);
    }

    /**
     * Cek apakah user hanya bisa lihat data miliknya sendiri.
     */
    public static function isViewOwn(string $feature, $user = null): bool
    {
        $user = $user ?? auth()->user();

        if (!$user || $user->role === 'admin') {
            return false; // admin selalu view_all
        }

        $viewOwn  = config("permissions.{$feature}.view_own", []);
        $viewAll  = config("permissions.{$feature}.view_all", []);

        return in_array($user->role, $viewOwn) && !in_array($user->role, $viewAll);
    }

    /**
     * Ambil semua aksi yang diizinkan untuk user & fitur tertentu.
     *
     * @return array  Contoh: ['view_own', 'create']
     */
    public static function allowedActions(string $feature, $user = null): array
    {
        $user = $user ?? auth()->user();

        if (!$user) {
            return [];
        }

        if ($user->role === 'admin') {
            // Admin dapat semua aksi
            return array_keys(config("permissions.{$feature}", []));
        }

        $allActions    = config("permissions.{$feature}", []);
        $allowed       = [];

        foreach ($allActions as $action => $roles) {
            if (in_array($user->role, $roles)) {
                $allowed[] = $action;
            }
        }

        return $allowed;
    }

    /**
     * Cek apakah sidebar category tertentu boleh tampil untuk user.
     */
    public static function sidebarCan(string $category, $user = null): bool
    {
        $user = $user ?? auth()->user();

        if (!$user) {
            return false;
        }

        if ($user->role === 'admin') {
            return true; // admin lihat semua menu
        }

        $allowed = config("permissions.sidebar.{$category}", []);

        return in_array($user->role, $allowed);
    }

    /**
     * Ambil role user yang sedang login.
     */
    public static function role($user = null): ?string
    {
        $user = $user ?? auth()->user();
        return $user?->role;
    }

    /**
     * Cek apakah user adalah admin.
     */
    public static function isAdmin($user = null): bool
    {
        return static::role($user) === 'admin';
    }
}
