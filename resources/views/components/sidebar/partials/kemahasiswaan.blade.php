{{-- PARTIAL: KEMAHASISWAAN --}}
@php
    use App\Helpers\PermissionHelper;
    $role    = auth()->user()?->role ?? 'guest';
    $isAdmin = $role === 'admin';
    $hasRoute = fn($name) => \Illuminate\Support\Facades\Route::has($name);
@endphp

{{-- KELOLA MAHASISWA — hanya untuk staff / admin / kaprodi / sesprodi --}}
@sidebar_can('mahasiswa')
<div class="sidebar-section">
    <button class="sidebar-group-toggle {{ request()->routeIs([
        '*.students.*', 'staff.violations.*', '*.fitness-tests.*', '*.achievements.*'
    ]) ? 'open' : '' }}" data-target="group-kemahasiswaan" aria-label="Toggle Kemahasiswaan">
        <span class="sidebar-icon"><i class="bi bi-person-lines-fill"></i></span>
        <span class="sidebar-label">Kemahasiswaan</span>
        <span class="sidebar-chevron"><i class="bi bi-chevron-right"></i></span>
    </button>
    <div class="sidebar-submenu" id="group-kemahasiswaan">

        {{-- Data Mahasiswa --}}
        @if(PermissionHelper::can('users', 'view_all') || $isAdmin)
            @if($hasRoute('staff.students.index'))
                <a class="sidebar-sublink {{ request()->routeIs('staff.students.*') ? 'active' : '' }}"
                   href="{{ route('staff.students.index') }}">
                    <i class="bi bi-mortarboard"></i> Data Mahasiswa
                </a>
            @endif
        @endif

        {{-- Pelanggaran (staff/admin kelola) --}}
        @if(PermissionHelper::can('violations', 'view_all') || $isAdmin)
            @if($hasRoute('staff.violations.index'))
                <a class="sidebar-sublink {{ request()->routeIs('staff.violations.*') ? 'active' : '' }}"
                   href="{{ route('staff.violations.index') }}">
                    <i class="bi bi-exclamation-octagon"></i> Pelanggaran
                </a>
            @endif
        @endif

        {{-- Garjas / Kesemaptaan --}}
        @if(PermissionHelper::can('fitness_tests', 'view_all') || $isAdmin)
            @if($hasRoute('staff.fitness-tests.index'))
                <a class="sidebar-sublink {{ request()->routeIs('staff.fitness-tests.*') ? 'active' : '' }}"
                   href="{{ route('staff.fitness-tests.index') }}">
                    <i class="bi bi-heart-pulse"></i> Garjas (Kesemaptaan)
                </a>
            @endif
        @endif

        {{-- Prestasi --}}
        @if(PermissionHelper::can('achievements', 'view_all') || $isAdmin)
            @if($hasRoute('staff.achievements.index'))
                <a class="sidebar-sublink {{ request()->routeIs('staff.achievements.*') ? 'active' : '' }}"
                   href="{{ route('staff.achievements.index') }}">
                    <i class="bi bi-trophy"></i> Prestasi
                </a>
            @endif
        @endif

    </div>
</div>
@endsidebar_can

{{-- AKTIVITAS MAHASISWA — khusus untuk role mahasiswa --}}
@if($role === 'mahasiswa')
<div class="sidebar-section">
    <button class="sidebar-group-toggle {{ request()->routeIs(['mahasiswa.violations.*', 'mahasiswa.ukms.*']) ? 'open' : '' }}"
            data-target="group-aktivitas-mhs" aria-label="Toggle Aktivitas">
        <span class="sidebar-icon"><i class="bi bi-activity"></i></span>
        <span class="sidebar-label">Aktivitas</span>
        <span class="sidebar-chevron"><i class="bi bi-chevron-right"></i></span>
    </button>
    <div class="sidebar-submenu" id="group-aktivitas-mhs">

        @if($hasRoute('mahasiswa.violations.index'))
            <a class="sidebar-sublink {{ request()->routeIs('mahasiswa.violations.*') ? 'active' : '' }}"
               href="{{ route('mahasiswa.violations.index') }}">
                <i class="bi bi-exclamation-octagon"></i> Riwayat Pelanggaran
            </a>
        @endif

        @if($hasRoute('mahasiswa.ukms.index'))
            <a class="sidebar-sublink {{ request()->routeIs('mahasiswa.ukms.*') ? 'active' : '' }}"
               href="{{ route('mahasiswa.ukms.index') }}">
                <i class="bi bi-people"></i> Daftar UKM
            </a>
        @endif

    </div>
</div>
@endif
