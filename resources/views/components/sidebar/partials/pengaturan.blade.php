{{-- PARTIAL: MANAJEMEN & PENGATURAN --}}
@php
    use App\Helpers\PermissionHelper;
    $role    = auth()->user()?->role ?? 'guest';
    $isAdmin = $role === 'admin';
    $hasRoute = fn($name) => \Illuminate\Support\Facades\Route::has($name);
@endphp

{{-- MANAJEMEN (admin / staff / kaprodi / sesprodi) --}}
@sidebar_can('manajemen')
<div class="sidebar-section">
    <button class="sidebar-group-toggle {{ request()->routeIs([
        'admin.users.*', 'admin.logs.*'
    ]) ? 'open' : '' }}" data-target="group-manajemen" aria-label="Toggle Manajemen">
        <span class="sidebar-icon"><i class="bi bi-gear-wide-connected"></i></span>
        <span class="sidebar-label">Manajemen</span>
        <span class="sidebar-chevron"><i class="bi bi-chevron-right"></i></span>
    </button>
    <div class="sidebar-submenu" id="group-manajemen">

        {{-- Users & Akun --}}
        @if(PermissionHelper::can('users', 'view_all') || $isAdmin)
            @if($hasRoute('admin.users.index'))
                <a class="sidebar-sublink {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                   href="{{ route('admin.users.index') }}">
                    <i class="bi bi-people"></i> Users & Akun
                </a>
            @endif
        @endif

        {{-- Log Aktivitas --}}
        @if(PermissionHelper::can('logs', 'view_all') || $isAdmin)
            @if($hasRoute('admin.logs.index'))
                <a class="sidebar-sublink {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}"
                   href="{{ route('admin.logs.index') }}">
                    <i class="bi bi-clock-history"></i> Log Aktivitas
                </a>
            @endif
        @endif

    </div>
</div>
@endsidebar_can

{{-- PENGATURAN (semua role) --}}
@sidebar_can('pengaturan')
<div class="sidebar-section">
    <button class="sidebar-group-toggle {{ request()->routeIs([
        '*.settings.*', '*.profile.*', '*.profile'
    ]) ? 'open' : '' }}" data-target="group-pengaturan" aria-label="Toggle Pengaturan">
        <span class="sidebar-icon"><i class="bi bi-sliders"></i></span>
        <span class="sidebar-label">Pengaturan</span>
        <span class="sidebar-chevron"><i class="bi bi-chevron-right"></i></span>
    </button>
    <div class="sidebar-submenu" id="group-pengaturan">

        {{-- Profil & Akun --}}
        @php
            $profileRoute = match($role) {
                'admin'    => $hasRoute('admin.settings.index')      ? 'admin.settings.index'      : null,
                'staff'    => $hasRoute('staff.profile')             ? 'staff.profile'             : null,
                'mahasiswa'=> $hasRoute('mahasiswa.profile.index')   ? 'mahasiswa.profile.index'   : null,
                'dosen'    => $hasRoute('dosen.profile.index')       ? 'dosen.profile.index'       : null,
                default    => null,
            };
        @endphp
        @if($profileRoute)
            <a class="sidebar-sublink {{ request()->routeIs('*.settings.*') || request()->routeIs('*.profile*') ? 'active' : '' }}"
               href="{{ route($profileRoute) }}">
                <i class="bi bi-person-gear"></i> Profil & Akun
            </a>
        @endif

    </div>
</div>
@endsidebar_can
