@extends('layouts.app')
@section('title', 'Manajemen Pengguna')

@push('styles')
<style>
    .page-title { font-size:1.4rem; font-weight:800; color:#1e293b; margin:0; }
    .page-title i { color:#6366f1; }
    .page-sub   { font-size:0.82rem; color:#94a3b8; margin:4px 0 0; }

    /* ── Table Panel ────────────────────────────── */
    .data-panel {
        background:#fff;
        border:1px solid #e2e8f0;
        border-radius:16px;
        box-shadow:0 1px 3px rgba(0,0,0,.04);
        overflow:hidden;
        margin-bottom:24px;
    }
    .data-panel-header {
        display:flex;
        align-items:center;
        justify-content:space-between;
        padding:16px 20px;
        background:#f8fafc;
        border-bottom:1.5px solid #e2e8f0;
        flex-wrap:wrap;
        gap:12px;
    }
    .panel-title {
        font-size:0.72rem;
        font-weight:800;
        text-transform:uppercase;
        letter-spacing:0.8px;
        color:#64748b;
        display:flex;
        align-items:center;
        gap:8px;
    }
    .panel-title i { color:#6366f1; font-size:1rem; }

    .search-input-wrap {
        position:relative;
        width:280px;
    }
    .search-input-wrap i {
        position:absolute;
        left:11px;
        top:50%;
        transform:translateY(-50%);
        color:#94a3b8;
        font-size:0.85rem;
        pointer-events:none;
    }
    .search-input-wrap input {
        width:100%;
        padding:8px 14px 8px 34px;
        background:#fff;
        border:1.5px solid #e2e8f0;
        border-radius:10px;
        font-size:0.82rem;
        color:#1e293b;
        outline:none;
        transition:.2s;
    }
    .search-input-wrap input:focus {
        border-color:#6366f1;
        box-shadow:0 0 0 3px rgba(99,102,241,.12);
    }

    /* ── Data Table ────────────────────────────── */
    .data-table { width:100%; border-collapse:collapse; }
    .data-table thead tr {
        background:#f8fafc;
        border-bottom:1.5px solid #e2e8f0;
    }
    .data-table thead th {
        padding:11px 16px;
        font-size:0.68rem;
        font-weight:800;
        text-transform:uppercase;
        letter-spacing:0.8px;
        color:#94a3b8;
        white-space:nowrap;
    }
    .data-table tbody tr {
        border-bottom:1px solid #f1f5f9;
        transition:background .12s;
    }
    .data-table tbody tr:last-child { border-bottom:none; }
    .data-table tbody tr:hover { background:#f8fafc; }
    .data-table td { padding:12px 16px; font-size:0.875rem; color:#1e293b; vertical-align:middle; }

    /* ── Role Badges ───────────────────────────── */
    .role-badge {
        display:inline-flex;
        align-items:center;
        padding:3px 12px;
        border-radius:20px;
        font-size:0.68rem;
        font-weight:700;
        letter-spacing:0.5px;
        text-transform:uppercase;
    }
    .role-admin    { background:#fee2e2; color:#b91c1c; }
    .role-staff    { background:#dbeafe; color:#1d4ed8; }
    .role-dosen    { background:#dcfce7; color:#15803d; }
    .role-mahasiswa{ background:#f3e8ff; color:#7e22ce; }
    .role-sesprodi { background:#fef9c3; color:#854d0e; }
    .role-kaprodi  { background:#e0e7ff; color:#4338ca; }
    .role-default  { background:#f1f5f9; color:#64748b; }

    /* ── Cohort Chip ───────────────────────────── */
    .cohort-chip {
        background:#f1f5f9;
        color:#475569;
        font-size:0.72rem;
        font-weight:600;
        padding:3px 10px;
        border-radius:6px;
    }

    /* ── Autocomplete ──────────────────────────── */
    .autocomplete-box {
        z-index:1050;
        top:calc(100% + 4px);
        background:#fff;
        border:1.5px solid #e2e8f0;
        border-radius:10px;
        overflow:hidden;
        box-shadow:0 8px 24px rgba(0,0,0,.1);
    }
    .suggestion-item {
        background:#fff;
        color:#1e293b;
        cursor:pointer;
        font-size:0.82rem;
        padding:9px 14px;
        border-bottom:1px solid #f1f5f9;
        transition:.12s;
    }
    .suggestion-item:hover { background:#f8fafc; color:#6366f1; }

    /* ── Modal Light ───────────────────────────── */
    .modal-content {
        border-radius:16px;
        border:1px solid #e2e8f0;
        box-shadow:0 20px 60px rgba(0,0,0,.12);
    }
    .modal-header {
        background:#f8fafc;
        border-bottom:1.5px solid #e2e8f0;
        border-radius:16px 16px 0 0;
        padding:16px 20px;
    }
    .modal-title {
        font-size:0.875rem;
        font-weight:700;
        text-transform:uppercase;
        letter-spacing:0.5px;
        color:#1e293b;
    }
    .modal-footer { border-top:1px solid #f1f5f9; }
    .modal-label {
        font-size:0.72rem;
        font-weight:700;
        text-transform:uppercase;
        letter-spacing:0.5px;
        color:#94a3b8;
        margin-bottom:6px;
    }
    .modal-input {
        background:#f8fafc;
        border:1.5px solid #e2e8f0;
        border-radius:10px;
        color:#1e293b;
        font-size:0.875rem;
        padding:9px 14px;
        width:100%;
        outline:none;
        transition:.2s;
    }
    .modal-input:focus {
        background:#fff;
        border-color:#6366f1;
        box-shadow:0 0 0 3px rgba(99,102,241,.12);
    }
    .btn-primary-custom {
        background:linear-gradient(135deg,#6366f1,#818cf8);
        color:#fff;
        border:none;
        border-radius:10px;
        padding:9px 24px;
        font-size:0.875rem;
        font-weight:600;
        cursor:pointer;
        transition:.2s;
    }
    .btn-primary-custom:hover { opacity:.9; transform:translateY(-1px); }
    .btn-cancel-custom {
        background:#f1f5f9;
        color:#64748b;
        border:1.5px solid #e2e8f0;
        border-radius:10px;
        padding:9px 20px;
        font-size:0.875rem;
        font-weight:600;
        cursor:pointer;
    }
    .fw-mono { font-family:'Courier New',monospace; }
</style>
@endpush

@section('content')

{{-- Header --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h2 class="page-title"><i class="bi bi-people-fill me-2"></i>Manajemen Pengguna</h2>
        <p class="page-sub">Kelola akses sistem untuk Admin, Dosen, Staff, dan Mahasiswa.</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-sm px-4 py-2 fw-semibold"
       style="background:linear-gradient(135deg,#6366f1,#818cf8);color:#fff;border-radius:10px;border:none;font-size:.82rem;">
        <i class="bi bi-plus-circle me-1"></i> Buat Akun Baru
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show border-0 mb-4"
     style="background:#f0fdf4;color:#15803d;border-radius:12px;" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

{{-- ── Admin / Staff / Dosen Table ───────────────────────────── --}}
<div class="data-panel">
    <div class="data-panel-header">
        <div class="panel-title">
            <i class="bi bi-shield-lock"></i>
            Admin, Staff & Dosen
        </div>
        <div class="search-input-wrap position-relative">
            <i class="bi bi-search"></i>
            <input type="text" id="searchStaff" placeholder="Cari nama, email..." autocomplete="off">
            <div id="suggestStaff" class="autocomplete-box position-absolute w-100 d-none"></div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="padding-left:20px;">Nama Lengkap</th>
                    <th>Email / Username</th>
                    <th>Role</th>
                    <th>Terdaftar</th>
                    <th style="text-align:right;padding-right:20px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="staffTableBody">
                @foreach($users->whereIn('role', ['admin','staff','dosen','sesprodi','kaprodi']) as $user)
                <tr class="staff-row">
                    <td style="padding-left:20px;">
                        <div class="fw-semibold staff-name" style="color:#1e293b;">{{ $user->name }}</div>
                    </td>
                    <td class="staff-username text-secondary fw-mono" style="font-size:.8rem;">
                        {{ $user->email }}
                    </td>
                    <td>
                        @php
                            $roleClass = match($user->role) {
                                'admin'    => 'role-admin',
                                'staff'    => 'role-staff',
                                'dosen'    => 'role-dosen',
                                'sesprodi' => 'role-sesprodi',
                                'kaprodi'  => 'role-kaprodi',
                                default    => 'role-default',
                            };
                        @endphp
                        <span class="role-badge {{ $roleClass }}">{{ $user->role }}</span>
                    </td>
                    <td style="color:#94a3b8;font-size:.8rem;">{{ $user->created_at->format('d M Y') }}</td>
                    <td style="text-align:right;padding-right:20px;">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light border" data-bs-toggle="dropdown"
                                    style="border-radius:8px;">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border"
                                style="border-radius:12px;border-color:#e2e8f0;">
                                <li>
                                    <a class="dropdown-item small py-2" href="javascript:void(0)"
                                       onclick="openResetModal('{{ $user->id }}', '{{ $user->name }}')">
                                        <i class="bi bi-key me-2 text-warning"></i>Reset Password
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                          onsubmit="return confirm('Hapus akun {{ $user->name }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="dropdown-item small py-2 text-danger">
                                            <i class="bi bi-trash me-2"></i>Hapus Akun
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- ── Mahasiswa Table ────────────────────────────────────────── --}}
<div class="d-flex align-items-center justify-content-between mb-3">
    <h6 class="fw-bold mb-0" style="color:#6366f1;font-size:.72rem;text-transform:uppercase;letter-spacing:.8px;">
        <i class="bi bi-mortarboard me-2"></i>Database Mahasiswa
    </h6>
    <div class="search-input-wrap position-relative">
        <i class="bi bi-search"></i>
        <input type="text" id="searchStudent" placeholder="Cari NIM atau nama..." autocomplete="off">
        <div id="suggestStudent" class="autocomplete-box position-absolute w-100 d-none"></div>
    </div>
</div>

<div class="data-panel">
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="padding-left:20px;">NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th style="text-align:center;">Angkatan</th>
                    <th>Terdaftar</th>
                    <th style="text-align:right;padding-right:20px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="studentTableBody">
                @forelse($users->where('role','mahasiswa') as $student)
                <tr class="student-row">
                    <td class="student-nim fw-mono" style="padding-left:20px;font-size:.8rem;color:#6366f1;">
                        {{ $student->nim ?? '-' }}
                    </td>
                    <td class="student-name fw-semibold" style="color:#1e293b;">{{ $student->name }}</td>
                    <td style="text-align:center;">
                        <span class="cohort-chip">Angkatan {{ $student->cohort ?? '?' }}</span>
                    </td>
                    <td style="color:#94a3b8;font-size:.8rem;">{{ $student->created_at->format('d M Y') }}</td>
                    <td style="text-align:right;padding-right:20px;">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light border" data-bs-toggle="dropdown"
                                    style="border-radius:8px;">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border"
                                style="border-radius:12px;border-color:#e2e8f0;">
                                <li>
                                    <a class="dropdown-item small py-2" href="javascript:void(0)"
                                       onclick="openResetModal('{{ $student->id }}', '{{ $student->name }}')">
                                        <i class="bi bi-key me-2 text-warning"></i>Reset Password
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li>
                                    <form action="{{ route('admin.users.destroy', $student->id) }}" method="POST"
                                          onsubmit="return confirm('Hapus akun {{ $student->name }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="dropdown-item small py-2 text-danger">
                                            <i class="bi bi-trash me-2"></i>Hapus Akun
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:50px 20px;color:#94a3b8;">
                        <i class="bi bi-inbox d-block fs-2 mb-2 opacity-50"></i>
                        Data mahasiswa tidak ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ── Reset Password Modal ───────────────────────────────────── --}}
<div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-shield-lock me-2" style="color:#f59e0b;"></i>Reset Password Pengguna
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="resetPasswordForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-body p-4">
                    <p class="mb-3" style="font-size:.875rem;color:#64748b;">
                        Mengganti password untuk:
                        <strong id="resetTargetName" style="color:#6366f1;"></strong>
                    </p>
                    <div class="mb-3">
                        <label class="modal-label">Password Baru</label>
                        <div class="d-flex gap-2">
                            <input type="password" name="password" id="newPassword" class="modal-input"
                                   placeholder="Minimal 8 karakter" minlength="8" required style="flex:1;">
                            <button type="button" class="btn btn-light border" onclick="togglePass('newPassword', 'eyeIcon')"
                                    style="border-radius:10px;padding:9px 14px;">
                                <i class="bi bi-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="modal-label">Konfirmasi Password</label>
                        <div class="d-flex gap-2">
                            <input type="password" name="password_confirmation" id="newPasswordConfirm" class="modal-input"
                                   placeholder="Ulangi password baru" minlength="8" required style="flex:1;">
                            <button type="button" class="btn btn-light border" onclick="togglePass('newPasswordConfirm', 'eyeIconConfirm')"
                                    style="border-radius:10px;padding:9px 14px;">
                                <i class="bi bi-eye" id="eyeIconConfirm"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 px-4 pb-4 gap-2">
                    <button type="button" class="btn-cancel-custom" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-primary-custom">
                        <i class="bi bi-check-lg me-1"></i>Simpan Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openResetModal(id, name) {
        const modal = new bootstrap.Modal(document.getElementById('resetPasswordModal'));
        document.getElementById('resetTargetName').innerText = name;
        document.getElementById('resetPasswordForm').action = `/admin/users/${id}/reset-password`;
        modal.show();
    }

    function togglePass(inputId, iconId) {
        const x = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (x.type === 'password') {
            x.type = 'text';
            icon.classList.replace('bi-eye','bi-eye-slash');
        } else {
            x.type = 'password';
            icon.classList.replace('bi-eye-slash','bi-eye');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        setupSearch('searchStaff',   'suggestStaff',   'staff-row',   'staff-name',   'staff-username');
        setupSearch('searchStudent', 'suggestStudent', 'student-row', 'student-name', 'student-nim');

        function setupSearch(inputId, suggestId, rowClass, nameClass, idClass) {
            const input   = document.getElementById(inputId);
            const suggest = document.getElementById(suggestId);
            if (!input) return;
            const rows = document.querySelectorAll('.' + rowClass);

            input.addEventListener('input', function () {
                const q = this.value.toLowerCase();
                rows.forEach(row => {
                    const nm = row.querySelector('.' + nameClass)?.textContent.toLowerCase() ?? '';
                    const id = row.querySelector('.' + idClass)?.textContent.toLowerCase() ?? '';
                    row.style.display = (nm.includes(q) || id.includes(q)) ? '' : 'none';
                });

                if (q.length < 2) { suggest.classList.add('d-none'); return; }

                const matches = Array.from(rows).filter(r =>
                    r.querySelector('.' + nameClass)?.textContent.toLowerCase().includes(q)
                ).slice(0, 5);

                if (matches.length) {
                    suggest.classList.remove('d-none');
                    suggest.innerHTML = matches.map(row => {
                        const name = row.querySelector('.' + nameClass)?.textContent ?? '';
                        const uid  = row.querySelector('.' + idClass)?.textContent ?? '';
                        return `<div class="suggestion-item d-flex justify-content-between"
                                    onclick="pickSuggestion('${inputId}','${suggestId}','${name.trim()}')">
                                    <span>${name}</span><small style="color:#94a3b8;">${uid}</small>
                                </div>`;
                    }).join('');
                } else {
                    suggest.classList.add('d-none');
                }
            });

            document.addEventListener('click', e => {
                if (!input.contains(e.target)) suggest.classList.add('d-none');
            });
        }
    });

    function pickSuggestion(inputId, suggestId, value) {
        const input = document.getElementById(inputId);
        input.value = value;
        input.dispatchEvent(new Event('input'));
        document.getElementById(suggestId).classList.add('d-none');
    }
</script>
@endpush
@endsection
