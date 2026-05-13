<ul class="nav nav-pills flex-column mb-auto">
    {{-- DASHBOARD --}}
    <li class="sidebar-heading">Dashboard</li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2 me-3 fs-5"></i> Dashboard
        </a>
    </li>

    {{-- AKADEMIK --}}
    <li class="sidebar-heading">Akademik</li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.schedules.*') || request()->routeIs('staff.exams.*') ? 'active' : '' }}" href="{{ route('admin.schedules.index') }}">
            <i class="bi bi-calendar3 me-3 fs-5"></i> Jadwal
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.subjects.*') ? 'active' : '' }}" href="{{ route('admin.subjects.index') }}">
            <i class="bi bi-book me-3 fs-5"></i> Mata Kuliah
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.nilai.*') || request()->routeIs('staff.grades.*') ? 'active' : '' }}" href="{{ route('admin.nilai.index') }}">
            <i class="bi bi-pencil-square me-3 fs-5"></i> Nilai
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('staff.attendances.*') ? 'active' : '' }}" href="{{ route('staff.attendances.index') }}">
            <i class="bi bi-clipboard-check me-3 fs-5"></i> Absensi
        </a>
    </li>

    {{-- PENGGUNA --}}
    <li class="sidebar-heading">Pengguna</li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('staff.students.*') ? 'active' : '' }}" href="{{ route('staff.students.index') }}">
            <i class="bi bi-mortarboard me-3 fs-5"></i> Mahasiswa
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dosen.accounts.*') ? 'active' : '' }}" href="{{ route('dosen.accounts.index') ?? '#' }}">
            <i class="bi bi-person-badge me-3 fs-5"></i> Dosen
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
            <i class="bi bi-people me-3 fs-5"></i> Staff / Admin
        </a>
    </li>

    {{-- AKTIVITAS --}}
    <li class="sidebar-heading">Aktivitas</li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.documents.*') ? 'active' : '' }}" href="{{ route('admin.documents.index') }}">
            <i class="bi bi-envelope-paper me-3 fs-5"></i> Surat
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.berkas.*') ? 'active' : '' }}" href="{{ route('admin.berkas.index') }}">
            <i class="bi bi-folder2-open me-3 fs-5"></i> Berkas
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('staff.chats.*') ? 'active' : '' }}" href="{{ route('staff.chats.index') ?? '#' }}">
            <i class="bi bi-chat-dots me-3 fs-5"></i> Chat
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('staff.announcements.*') ? 'active' : '' }}" href="{{ route('staff.announcements.index') }}">
            <i class="bi bi-megaphone me-3 fs-5"></i> Pengumuman
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.materials.*') ? 'active' : '' }}" href="{{ route('admin.materials.index') }}">
            <i class="bi bi-journal-bookmark me-3 fs-5"></i> Bahan Ajar
        </a>
    </li>

    {{-- MONITORING --}}
    <li class="sidebar-heading">Monitoring</li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('staff.violations.*') ? 'active' : '' }}" href="{{ route('staff.violations.index') }}">
            <i class="bi bi-exclamation-octagon me-3 fs-5"></i> Pelanggaran
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('staff.fitness-tests.*') ? 'active' : '' }}" href="{{ route('staff.fitness-tests.index') }}">
            <i class="bi bi-heart-pulse me-3 fs-5"></i> Garjas
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}" href="{{ route('admin.logs.index') }}">
            <i class="bi bi-clock-history me-3 fs-5"></i> Logs
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="bi bi-bar-chart-line me-3 fs-5"></i> Statistik
        </a>
    </li>

    {{-- PENGATURAN --}}
    <li class="sidebar-heading">Pengaturan</li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.settings.index') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
            <i class="bi bi-person me-3 fs-5"></i> Profil
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="bi bi-palette me-3 fs-5"></i> Tema
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="bi bi-shield-lock me-3 fs-5"></i> Session & Keamanan
        </a>
    </li>
</ul>