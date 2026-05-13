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
        'admin.users.*', 'admin.logs.*', '*.documents.*', '*.submissions.*', '*.berkas.*'
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

        {{-- Surat --}}
        @if(PermissionHelper::can('documents', 'create') || PermissionHelper::can('documents', 'view_own') || PermissionHelper::can('documents', 'view_all') || $isAdmin)
            @php
                $suratRoute = match($role) {
                    'admin'    => $hasRoute('admin.documents.index')        ? 'admin.documents.index'        : null,
                    'staff'    => $hasRoute('staff.documents.index')        ? 'staff.documents.index'        : null,
                    'mahasiswa'=> $hasRoute('mahasiswa.submissions.index')  ? 'mahasiswa.submissions.index'  : null,
                    'sesprodi' => $hasRoute('sesprodi.documents.index')     ? 'sesprodi.documents.index'     : null,
                    'kaprodi'  => $hasRoute('kaprodi.documents.index')      ? 'kaprodi.documents.index'      : null,
                    default    => null,
                };
            @endphp
            @if($suratRoute)
                <a class="sidebar-sublink {{ request()->routeIs('*.documents.*') || (request()->routeIs('*.submissions.*') && $role === 'mahasiswa') ? 'active' : '' }}"
                   href="{{ route($suratRoute) }}">
                    <i class="bi bi-envelope-paper"></i> Surat
                </a>
            @endif
        @endif

        {{-- Verifikasi Surat Mahasiswa (Staff) --}}
        @if($role === 'staff' && $hasRoute('staff.submissions.index'))
            <a class="sidebar-sublink {{ request()->routeIs('staff.submissions.*') ? 'active' : '' }}"
               href="{{ route('staff.submissions.index') }}">
                <i class="bi bi-check2-square"></i> Verifikasi Surat
            </a>
        @endif

        {{-- Berkas (File Explorer) --}}
        @if(PermissionHelper::can('berkas', 'view_own') || PermissionHelper::can('berkas', 'view_all') || $isAdmin)
            @php $berkasRoute = "{$prefix}.berkas.index"; @endphp
            @if($hasRoute($berkasRoute))
                <a class="sidebar-sublink {{ request()->routeIs('*.berkas.*') ? 'active' : '' }}"
                   href="{{ route($berkasRoute) }}">
                    <i class="bi bi-folder2-open"></i> Berkas
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
