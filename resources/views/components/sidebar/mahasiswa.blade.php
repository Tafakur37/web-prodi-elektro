<ul class="nav nav-pills flex-column mb-auto">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}" href="{{ route('mahasiswa.dashboard') }}">
            <i class="bi bi-speedometer2 me-3 fs-5"></i> Dashboard
        </a>
    </li>

    <li class="sidebar-heading">Akademik</li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('mahasiswa.attendances.*') ? 'active' : '' }}" href="{{ route('mahasiswa.attendances.index') }}">
            <i class="bi bi-calendar-check me-3 fs-5"></i> Riwayat Absensi
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('mahasiswa.nilai.*') ? 'active' : '' }}" href="{{ route('mahasiswa.nilai.index') }}">
            <i class="bi bi-award me-3 fs-5"></i> Transkrip Nilai
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('mahasiswa.materials.*') ? 'active' : '' }}" href="{{ route('mahasiswa.materials.index') }}">
            <i class="bi bi-journal-text me-3 fs-5"></i> Bahan Ajar
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('mahasiswa.submissions.*') ? 'active' : '' }}" href="{{ route('mahasiswa.submissions.index') }}">
            <i class="bi bi-envelope-paper me-3 fs-5"></i> Surat
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('mahasiswa.berkas.*') ? 'active' : '' }}" href="{{ route('mahasiswa.berkas.index') }}">
            <i class="bi bi-folder2-open me-3 fs-5"></i> Berkas
        </a>
    </li>

    <li class="sidebar-heading">Komunikasi & Aktivitas</li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('mahasiswa.chats.*') ? 'active' : '' }}" href="{{ route('mahasiswa.chats.index') }}">
            <i class="bi bi-chat-dots me-3 fs-5"></i> Chat
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('mahasiswa.ukms.*') ? 'active' : '' }}" href="{{ route('mahasiswa.ukms.index') }}">
            <i class="bi bi-people me-3 fs-5"></i> Daftar UKM
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('mahasiswa.violations.*') ? 'active' : '' }}" href="{{ route('mahasiswa.violations.index') }}">
            <i class="bi bi-exclamation-octagon me-3 fs-5"></i> Riwayat Pelanggaran
        </a>
    </li>

    <li class="sidebar-heading">Pengaturan</li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('mahasiswa.profile.*') ? 'active' : '' }}" href="{{ route('mahasiswa.profile.index') }}">
            <i class="bi bi-person-gear me-3 fs-5"></i> Profil & Akun
        </a>
    </li>
</ul>
