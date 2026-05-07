<ul class="nav nav-pills flex-column mb-auto">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dosen.dashboard') ? 'active' : '' }}" href="{{ route('dosen.dashboard') }}">
            <i class="bi bi-speedometer2 me-3 fs-5"></i> Dashboard
        </a>
    </li>

    <li class="nav-item mt-3 mb-1 px-3">
        <small class="text-secondary text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">Akademik</small>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dosen.attendances.*') ? 'active' : '' }}" href="{{ route('dosen.attendances.index') }}">
            <i class="bi bi-check-circle me-3 fs-5"></i> Input Absensi
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dosen.nilai.*') ? 'active' : '' }}" href="{{ route('dosen.nilai.index') }}">
            <i class="bi bi-pencil-square me-3 fs-5"></i> Input Nilai
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dosen.materials.*') ? 'active' : '' }}" href="{{ route('dosen.materials.index') }}">
            <i class="bi bi-journal-text me-3 fs-5"></i> Bahan Ajar
        </a>
    </li>

    <li class="nav-item mt-3 mb-1 px-3">
        <small class="text-secondary text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">Komunikasi & Aktivitas</small>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dosen.chats.*') ? 'active' : '' }}" href="{{ route('dosen.chats.index') }}">
            <i class="bi bi-chat-dots me-3 fs-5"></i> Chat Mahasiswa
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dosen.meetings.*') ? 'active' : '' }}" href="{{ route('dosen.meetings.index') }}">
            <i class="bi bi-people me-3 fs-5"></i> Bimbingan / Wali
        </a>
    </li>

    <li class="nav-item mt-3 mb-1 px-3">
        <small class="text-secondary text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">Pengaturan</small>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dosen.profile.*') ? 'active' : '' }}" href="{{ route('dosen.profile.index') }}">
            <i class="bi bi-person me-3 fs-5"></i> Profil Saya
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('dosen.accounts.*') ? 'active' : '' }}" href="{{ route('dosen.accounts.index') }}">
            <i class="bi bi-gear me-3 fs-5"></i> Kelola Akun
        </a>
    </li>
</ul>
