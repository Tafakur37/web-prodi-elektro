<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\PermissionHelper;
use Symfony\Component\HttpFoundation\Response;

/**
 * =============================================================================
 * CHECK PERMISSION MIDDLEWARE — SIMelek
 * =============================================================================
 *
 * Middleware untuk membatasi akses ke route berdasarkan fitur + aksi.
 * Berbeda dengan RoleManager (yang cek role saja), middleware ini cek
 * permission spesifik dari config/permissions.php.
 *
 * Penggunaan di route:
 *   Route::get('/documents', [...])->middleware('permission:documents,view_all');
 *   Route::post('/documents', [...])->middleware('permission:documents,create');
 *
 * Admin selalu diloloskan tanpa dicek (Super Role).
 * =============================================================================
 */

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $feature, string $action): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (!PermissionHelper::can($feature, $action)) {
            // Jika request AJAX, kembalikan JSON error
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki izin untuk melakukan aksi ini.',
                ], 403);
            }

            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk fitur ini.');
        }

        return $next($request);
    }
}
