{{-- PARTIAL: AKADEMIK --}}
@php
    use App\Helpers\PermissionHelper;
    $role    = auth()->user()?->role ?? 'guest';
    $isAdmin = $role === 'admin';
    $hasRoute = fn($name) => \Illuminate\Support\Facades\Route::has($name);
    $prefix  = match($role) {
        'admin'    => 'admin',
        'staff'    => 'staff',
        'dosen'    => 'dosen',
        'mahasiswa'=> 'mahasiswa',
        'sesprodi' => 'sesprodi',
        'kaprodi'  => 'kaprodi',
        default    => 'mahasiswa',
    };
@endphp

@sidebar_can('akademik')
<div class="sidebar-section">
    <button class="sidebar-group-toggle {{ request()->routeIs([
        '*.schedules.*', 'staff.exams.*', '*.attendances.*',
        '*.nilai.*', '*.grades.*', '*.materials.*', '*.subjects.*',
        'dosen.meetings.*'
    ]) ? 'open' : '' }}" data-target="group-akademik" aria-label="Toggle Akademik">
        <span class="sidebar-icon"><i class="bi bi-mortarboard"></i></span>
        <span class="sidebar-label">Akademik</span>
        <span class="sidebar-chevron"><i class="bi bi-chevron-right"></i></span>
    </button>
    <div class="sidebar-submenu" id="group-akademik">

        {{-- Jadwal Kuliah --}}
        @if(PermissionHelper::can('schedules', 'view_all') || $isAdmin)
            @php $schedRoute = $isAdmin ? 'admin.schedules.index' : ($hasRoute('staff.schedules.index') ? 'staff.schedules.index' : null); @endphp
            @if($schedRoute && $hasRoute($schedRoute))
                <a class="sidebar-sublink {{ request()->routeIs('*.schedules.*') ? 'active' : '' }}"
                   href="{{ route($schedRoute) }}">
                    <i class="bi bi-calendar3"></i> Jadwal Kuliah
                </a>
            @endif
        @endif

        {{-- Jadwal Ujian (staff/admin) --}}
        @if(PermissionHelper::can('exams', 'view_all') || $isAdmin)
            @if($hasRoute('staff.exams.index'))
                <a class="sidebar-sublink {{ request()->routeIs('staff.exams.*') ? 'active' : '' }}"
                   href="{{ route('staff.exams.index') }}">
                    <i class="bi bi-journal-text"></i> Jadwal Ujian
                </a>
            @endif
        @endif

        {{-- Mata Kuliah --}}
        @if(PermissionHelper::can('subjects', 'view_all') || $isAdmin)
            @php
                $subjectRoute = $isAdmin
                    ? 'admin.subjects.index'
                    : ($hasRoute('staff.subjects.index') ? 'staff.subjects.index' : null);
            @endphp
            @if($subjectRoute && $hasRoute($subjectRoute))
                <a class="sidebar-sublink {{ request()->routeIs('*.subjects.*') ? 'active' : '' }}"
                   href="{{ route($subjectRoute) }}">
                    <i class="bi bi-book"></i> Mata Kuliah
                </a>
            @endif
        @endif

        {{-- Input / Rekap Nilai (admin, dosen, staff) --}}
        @if(PermissionHelper::can('grades', 'create') || PermissionHelper::can('grades', 'recap') || $isAdmin)
            @php
                $nilaiRoute = $isAdmin
                    ? 'admin.nilai.index'
                    : ($role === 'dosen'
                        ? ($hasRoute('dosen.nilai.index') ? 'dosen.nilai.index' : null)
                        : ($hasRoute('staff.grades.recap') ? 'staff.grades.recap' : null));
            @endphp
            @if($nilaiRoute && $hasRoute($nilaiRoute))
                <a class="sidebar-sublink {{ request()->routeIs('*.nilai.*') || request()->routeIs('*.grades.*') ? 'active' : '' }}"
                   href="{{ route($nilaiRoute) }}">
                    <i class="bi bi-pencil-square"></i>
                    {{ ($isAdmin || $role === 'dosen') ? 'Input Nilai' : 'Rekap Nilai' }}
                </a>
            @endif
        @endif

        {{-- Transkrip Nilai (mahasiswa) --}}
        @if($role === 'mahasiswa' && $hasRoute('mahasiswa.nilai.index'))
            <a class="sidebar-sublink {{ request()->routeIs('mahasiswa.nilai.*') ? 'active' : '' }}"
               href="{{ route('mahasiswa.nilai.index') }}">
                <i class="bi bi-award"></i> Transkrip Nilai
            </a>
        @endif

        {{-- Absensi --}}
        @if(PermissionHelper::can('attendances', 'view_all') || PermissionHelper::can('attendances', 'view_own') || PermissionHelper::can('attendances', 'create') || $isAdmin)
            @php
                $absRoute = match($role) {
                    'dosen'    => $hasRoute('dosen.attendances.index')     ? 'dosen.attendances.index'     : null,
                    'staff'    => $hasRoute('staff.attendances.index')     ? 'staff.attendances.index'     : null,
                    'mahasiswa'=> $hasRoute('mahasiswa.attendances.index') ? 'mahasiswa.attendances.index' : null,
                    default    => $hasRoute('staff.attendances.index')     ? 'staff.attendances.index'     : null,
                };
            @endphp
            @if($absRoute)
                <a class="sidebar-sublink {{ request()->routeIs('*.attendances.*') ? 'active' : '' }}"
                   href="{{ route($absRoute) }}">
                    <i class="bi bi-clipboard-check"></i>
                    {{ $role === 'dosen' ? 'Input Absensi' : ($role === 'mahasiswa' ? 'Riwayat Absensi' : 'Pantau Absensi') }}
                </a>
            @endif
        @endif

        {{-- Pertemuan (dosen) --}}
        @if(($role === 'dosen' || $isAdmin) && $hasRoute('dosen.meetings.index'))
            <a class="sidebar-sublink {{ request()->routeIs('dosen.meetings.*') ? 'active' : '' }}"
               href="{{ route('dosen.meetings.index') }}">
                <i class="bi bi-people-fill"></i> Pertemuan
            </a>
        @endif

        {{-- Bahan Ajar --}}
        @if(PermissionHelper::can('materials', 'view_all') || PermissionHelper::can('materials', 'create') || $isAdmin)
            @php
                $matRoute = match($role) {
                    'admin'    => $hasRoute('admin.materials.index')     ? 'admin.materials.index'     : null,
                    'dosen'    => $hasRoute('dosen.materials.index')     ? 'dosen.materials.index'     : null,
                    'mahasiswa'=> $hasRoute('mahasiswa.materials.index') ? 'mahasiswa.materials.index' : null,
                    default    => null,
                };
            @endphp
            @if($matRoute)
                <a class="sidebar-sublink {{ request()->routeIs('*.materials.*') ? 'active' : '' }}"
                   href="{{ route($matRoute) }}">
                    <i class="bi bi-journal-bookmark"></i> Bahan Ajar
                </a>
            @endif
        @endif

    </div>
</div>
@endsidebar_can
