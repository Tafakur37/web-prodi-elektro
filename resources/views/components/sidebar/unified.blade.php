{{--
=============================================================================
UNIFIED COLLAPSIBLE SIDEBAR — SIMelek
=============================================================================

Satu sidebar untuk SEMUA role. Item yang muncul dikontrol oleh:
  1. @sidebar_can('kategori')  → cek apakah kategori terlihat oleh role ini
  2. @can_do('fitur', 'aksi') → cek apakah item spesifik boleh diakses

Struktur modular — setiap grup ada di file partial masing-masing:
  partials/akademik.blade.php
  partials/komunikasi.blade.php
  partials/kemahasiswaan.blade.php
  partials/pengaturan.blade.php   (berisi Manajemen + Pengaturan)

Collapsible:
  - Klik judul grup → expand/collapse submenu
  - Animasi smooth via CSS transition
  - State expand dipertahankan selama sesi (via sessionStorage di app.blade.php)
=============================================================================
--}}

@php
    $role   = auth()->user()?->role ?? 'guest';
    $prefix = match($role) {
        'admin'    => 'admin',
        'staff'    => 'staff',
        'dosen'    => 'dosen',
        'mahasiswa'=> 'mahasiswa',
        'sesprodi' => 'sesprodi',
        'kaprodi'  => 'kaprodi',
        default    => 'mahasiswa',
    };
@endphp

<nav class="sidebar-nav" id="sidebarNav">

    {{-- ════════════════════════════════════════════════════════ --}}
    {{-- DASHBOARD                                               --}}
    {{-- ════════════════════════════════════════════════════════ --}}
    <div class="sidebar-section">
        @if(\Illuminate\Support\Facades\Route::has("{$prefix}.dashboard"))
            <a class="sidebar-link {{ request()->routeIs("{$prefix}.dashboard") ? 'active' : '' }}"
               href="{{ route("{$prefix}.dashboard") }}">
                <span class="sidebar-icon"><i class="bi bi-speedometer2"></i></span>
                <span class="sidebar-label">Dashboard</span>
            </a>
        @endif
    </div>

    {{-- ════════════════════════════════════════════════════════ --}}
    {{-- AKADEMIK                                                --}}
    {{-- ════════════════════════════════════════════════════════ --}}
    @include('components.sidebar.partials.akademik')

    {{-- ════════════════════════════════════════════════════════ --}}
    {{-- KOMUNIKASI                                              --}}
    {{-- ════════════════════════════════════════════════════════ --}}
    @include('components.sidebar.partials.komunikasi')

    {{-- ════════════════════════════════════════════════════════ --}}
    {{-- KEMAHASISWAAN                                           --}}
    {{-- ════════════════════════════════════════════════════════ --}}
    @include('components.sidebar.partials.kemahasiswaan')

    {{-- ════════════════════════════════════════════════════════ --}}
    {{-- MANAJEMEN + PENGATURAN                                  --}}
    {{-- ════════════════════════════════════════════════════════ --}}
    @include('components.sidebar.partials.pengaturan')

</nav>
