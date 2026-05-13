<?php

namespace App\Services;

use App\Helpers\PermissionHelper;

/**
 * =============================================================================
 * PERMISSION SERVICE — SIMelek
 * =============================================================================
 *
 * Wrapper service untuk PermissionHelper.
 * Berguna untuk dependency injection di controller dan testing.
 *
 * Selain itu, menyediakan metode-metode high-level untuk logika permission
 * yang lebih kompleks (kombinasi beberapa cek).
 * =============================================================================
 */
class PermissionService
{
    /**
     * Cek apakah user bisa melakukan aksi pada fitur tertentu.
     */
    public function can(string $feature, string $action, $user = null): bool
    {
        return PermissionHelper::can($feature, $action, $user);
    }

    /**
     * Cek dan abort 403 jika tidak punya izin.
     */
    public function authorize(string $feature, string $action, $user = null): void
    {
        PermissionHelper::canOrAbort($feature, $action, $user);
    }

    /**
     * Ambil semua aksi yang diizinkan untuk fitur & user tertentu.
     */
    public function allowedActions(string $feature, $user = null): array
    {
        return PermissionHelper::allowedActions($feature, $user);
    }

    /**
     * Cek apakah user hanya bisa lihat data miliknya sendiri.
     */
    public function isViewOwn(string $feature, $user = null): bool
    {
        return PermissionHelper::isViewOwn($feature, $user);
    }

    /**
     * Scope query Eloquent berdasarkan permission view.
     *
     * Contoh penggunaan:
     *   $query = Violation::query();
     *   $this->permissionService->scopeQuery($query, 'violations', 'user_id');
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $feature
     * @param string $ownerColumn  Kolom foreign key ke user (default: 'user_id')
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeQuery($query, string $feature, string $ownerColumn = 'user_id')
    {
        $user = auth()->user();

        if (!$user) {
            return $query->whereRaw('1 = 0'); // tidak boleh lihat apa-apa
        }

        // Admin: lihat semua
        if ($user->role === 'admin') {
            return $query;
        }

        // Bisa view_all: lihat semua
        if (PermissionHelper::can($feature, 'view_all', $user)) {
            return $query;
        }

        // Hanya view_own: filter ke data milik user ini
        if (PermissionHelper::can($feature, 'view_own', $user)) {
            return $query->where($ownerColumn, $user->id);
        }

        // Tidak ada permission: tidak bisa lihat
        return $query->whereRaw('1 = 0');
    }

    /**
     * Generate array permissions untuk dikirim ke view.
     * Berguna untuk conditional rendering di Blade tanpa Blade directive.
     *
     * Contoh: $permissions = $permissionService->forView('documents');
     * Di Blade: @if($permissions['canApprove'])
     */
    public function forView(string $feature, $user = null): array
    {
        $actions = ['view_own', 'view_all', 'create', 'edit', 'delete', 'approve', 'export', 'monitoring', 'download'];
        $result  = [];

        foreach ($actions as $action) {
            $camelCase        = 'can' . ucfirst(str_replace('_', '', ucwords($action, '_')));
            $result[$camelCase] = PermissionHelper::can($feature, $action, $user);
        }

        return $result;
    }
}
