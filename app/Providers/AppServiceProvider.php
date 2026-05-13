<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use App\Models\BerkasFile;
use App\Models\BerkasFolder;
use App\Policies\BerkasPolicy;
use App\Helpers\PermissionHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(BerkasFile::class, BerkasPolicy::class);
        Gate::policy(BerkasFolder::class, BerkasPolicy::class);

        // -------------------------------------------------------------------
        // Daftarkan Blade directive @can_do untuk cek permission di view
        // Penggunaan: @can_do('documents', 'approve') ... @end_can_do
        // -------------------------------------------------------------------
        Blade::if('can_do', function (string $feature, string $action) {
            return PermissionHelper::can($feature, $action);
        });

        // -------------------------------------------------------------------
        // Daftarkan Blade directive @sidebar_can untuk cek sidebar category
        // Penggunaan: @sidebar_can('manajemen') ... @end_sidebar_can
        // -------------------------------------------------------------------
        Blade::if('sidebar_can', function (string $category) {
            return PermissionHelper::sidebarCan($category);
        });

        // -------------------------------------------------------------------
        // Daftarkan Blade directive @is_admin
        // -------------------------------------------------------------------
        Blade::if('is_admin', function () {
            return PermissionHelper::isAdmin();
        });
    }
}
