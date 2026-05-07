<ul class="nav nav-pills flex-column mb-auto">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}" href="{{ route('staff.dashboard') }}">
            <i class="bi bi-speedometer2 me-3 fs-5"></i> Dashboard
        </a>
    </li>

    <!-- AKADEMIK -->
    <li class="nav-item mt-3 mb-1 px-3 text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 1px; font-weight: 600;">
        Akademik
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('staff.schedules.*') ? 'active' : '' }}" href="{{ route('staff.schedules.index') }}">
            <i class="bi bi-calendar-check me-3 fs-5"></i> Jadwal Kuliah
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('staff.exams.*') ? 'active' : '' }}" href="{{ route('staff.exams.index') }}">
            <i class="bi bi-journal-text me-3 fs-5"></i> Jadwal Ujian
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('staff.attendances.*') ? 'active' : '' }}" href="{{ route('staff.attendances.index') }}">
            <i class="bi bi-clipboard-check me-3 fs-5"></i> Pantau Absensi
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('staff.grades.*') ? 'active' : '' }}" href="{{ route('staff.grades.recap') }}">
            <i class="bi bi-bar-chart-line me-3 fs-5"></i> Pantau Nilai
        </a>
    </li>

    <!-- KESISWAAN -->
    <li class="nav-item mt-3 mb-1 px-3 text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 1px; font-weight: 600;">
        Kesiswaan
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('staff.students.*') ? 'active' : '' }}" href="{{ route('staff.students.index') }}">
            <i class="bi bi-people me-3 fs-5"></i> Akun Mahasiswa
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('staff.chats.*') ? 'active' : '' }}" href="{{ route('staff.chats.index') }}">
            <i class="bi bi-chat-dots me-3 fs-5"></i> Chat Mahasiswa
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('staff.achievements.*') ? 'active' : '' }}" href="{{ route('staff.achievements.index') }}">
            <i class="bi bi-trophy me-3 fs-5"></i> Input Prestasi
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('staff.violations.*') ? 'active' : '' }}" href="{{ route('staff.violations.index') }}">
            <i class="bi bi-exclamation-octagon me-3 fs-5"></i> Input Pelanggaran
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('staff.fitness-tests.*') ? 'active' : '' }}" href="{{ route('staff.fitness-tests.index') }}">
            <i class="bi bi-heart-pulse me-3 fs-5"></i> Kesemaptaan (Garjas)
        </a>
    </li>

    <!-- KOMUNIKASI & AKTIVITAS -->
    <li class="nav-item mt-3 mb-1 px-3 text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 1px; font-weight: 600;">
        Komunikasi & Lainnya
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('staff.announcements.*') ? 'active' : '' }}" href="{{ route('staff.announcements.index') }}">
            <i class="bi bi-megaphone me-3 fs-5"></i> Pengumuman
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('staff.subjects.*') ? 'active' : '' }}" href="{{ route('staff.subjects.index') }}">
            <i class="bi bi-book me-3 fs-5"></i> Mata Kuliah
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('staff.documents.*') ? 'active' : '' }}" href="{{ route('staff.documents.index') }}">
            <i class="bi bi-file-earmark-text me-3 fs-5"></i> Dokumen
        </a>
    </li>

    <!-- PENGATURAN -->
    <li class="nav-item mt-3 mb-1 px-3 text-uppercase text-muted" style="font-size: 0.75rem; letter-spacing: 1px; font-weight: 600;">
        Pengaturan
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('staff.profile') ? 'active' : '' }}" href="{{ route('staff.profile') }}">
            <i class="bi bi-person-circle me-3 fs-5"></i> Pengaturan Profil
        </a>
    </li>
</ul>
