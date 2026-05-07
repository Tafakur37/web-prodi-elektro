<ul class="nav nav-pills flex-column mb-auto">
    {{-- DASHBOARD --}}
    <li class="sidebar-heading">Dashboard</li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2 me-3 fs-5"></i> Dashboard Admin
        </a>
    </li>

    {{-- AKADEMIK --}}
    <li class="sidebar-heading">Akademik</li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.nilai.*') ? 'active' : '' }}" href="{{ route('admin.nilai.index') }}">
            <i class="bi bi-pencil-square me-3 fs-5"></i> Input Nilai
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('staff.grades.*') ? 'active' : '' }}" href="{{ route('staff.grades.recap') }}">
            <i class="bi bi-bar-chart-line me-3 fs-5"></i> Rekap Nilai
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dosen.attendances.*') ? 'active' : '' }}" href="{{ route('dosen.attendances.index') }}">
            <i class="bi bi-calendar-check me-3 fs-5"></i> Input Absensi
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('staff.attendances.*') ? 'active' : '' }}" href="{{ route('staff.attendances.index') }}">
            <i class="bi bi-clipboard-check me-3 fs-5"></i> Pantau Absensi
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}" href="{{ route('admin.schedules.index') }}">
            <i class="bi bi-calendar3 me-3 fs-5"></i> Jadwal Kuliah
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('staff.exams.*') ? 'active' : '' }}" href="{{ route('staff.exams.index') }}">
            <i class="bi bi-journal-text me-3 fs-5"></i> Jadwal Ujian
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.subjects.*') || request()->routeIs('staff.subjects.*') ? 'active' : '' }}" href="{{ route('admin.subjects.index') }}">
            <i class="bi bi-book me-3 fs-5"></i> Mata Kuliah
        </a>
    </li>

    {{-- PENGGUNA --}}
    <li class="sidebar-heading">Pengguna</li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
            <i class="bi bi-people me-3 fs-5"></i> Manajemen User
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('staff.students.*') ? 'active' : '' }}" href="{{ route('staff.students.index') }}">
            <i class="bi bi-mortarboard me-3 fs-5"></i> Mahasiswa
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dosen.accounts.*') ? 'active' : '' }}" href="{{ route('dosen.accounts.index') }}">
            <i class="bi bi-person-badge me-3 fs-5"></i> Dosen
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('staff.violations.*') ? 'active' : '' }}" href="{{ route('staff.violations.index') }}">
            <i class="bi bi-exclamation-octagon me-3 fs-5"></i> Pelanggaran
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('staff.achievements.*') ? 'active' : '' }}" href="{{ route('staff.achievements.index') }}">
            <i class="bi bi-trophy me-3 fs-5"></i> Prestasi
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('staff.fitness-tests.*') ? 'active' : '' }}" href="{{ route('staff.fitness-tests.index') }}">
            <i class="bi bi-heart-pulse me-3 fs-5"></i> Kesemaptaan
        </a>
    </li>

    {{-- KONTEN --}}
    <li class="sidebar-heading">Konten</li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.materials.*') || request()->routeIs('dosen.materials.*') ? 'active' : '' }}" href="{{ route('admin.materials.index') }}">
            <i class="bi bi-journal-bookmark me-3 fs-5"></i> Bahan Ajar
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('staff.announcements.*') ? 'active' : '' }}" href="{{ route('staff.announcements.index') }}">
            <i class="bi bi-megaphone me-3 fs-5"></i> Pengumuman
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('mahasiswa.ukms.*') ? 'active' : '' }}" href="{{ route('mahasiswa.ukms.index') }}">
            <i class="bi bi-people-fill me-3 fs-5"></i> UKM
        </a>
    </li>

    {{-- KOMUNIKASI --}}
    <li class="sidebar-heading">Komunikasi</li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('staff.chats.*') || request()->routeIs('dosen.chats.*') || request()->routeIs('mahasiswa.chats.*') ? 'active' : '' }}" href="{{ route('staff.chats.index') }}">
            <i class="bi bi-chat-dots me-3 fs-5"></i> Chat
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.documents.*') || request()->routeIs('staff.documents.*') || request()->routeIs('mahasiswa.submissions.*') || request()->routeIs('staff.submissions.*') ? 'active' : '' }}" href="{{ route('admin.documents.index') }}">
            <i class="bi bi-envelope-paper me-3 fs-5"></i> Surat & Berkas
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dosen.meetings.*') ? 'active' : '' }}" href="{{ route('dosen.meetings.index') }}">
            <i class="bi bi-calendar-plus me-3 fs-5"></i> Bimbingan
        </a>
    </li>

    {{-- PIMPINAN --}}
    <li class="sidebar-heading">Pimpinan</li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('sesprodi.dashboard') ? 'active' : '' }}" href="{{ route('sesprodi.dashboard') }}">
            <i class="bi bi-diagram-3 me-3 fs-5"></i> Sesprodi
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('kaprodi.dashboard') ? 'active' : '' }}" href="{{ route('kaprodi.dashboard') }}">
            <i class="bi bi-shield-check me-3 fs-5"></i> Kaprodi
        </a>
    </li>

    {{-- SISTEM --}}
    <li class="sidebar-heading">Sistem</li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}" href="{{ route('admin.logs.index') }}">
            <i class="bi bi-clock-history me-3 fs-5"></i> Logs
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
            <i class="bi bi-gear me-3 fs-5"></i> Settings
        </a>
    </li>
</ul>