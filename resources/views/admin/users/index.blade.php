@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="container-fluid text-white pb-5">
    <div class="mb-4">
        <h2 class="fw-bold" style="letter-spacing: -1px;">Manajemen Pengguna</h2>
        <p class="text-secondary small">Kelola akses sistem untuk Admin, Dosen, dan Mahasiswa.</p>
    </div>

    <div class="card border-0 shadow-sm mb-5" style="background: #15191d; border-radius: 12px;">
        <div
            class="card-header bg-primary bg-opacity-10 py-3 border-0 d-flex justify-content-between align-items-center gap-3">
            <div class="d-flex align-items-center gap-3 flex-grow-1">
                <h5 class="mb-0 text-primary fw-bold small text-uppercase">
                    <i class="bi bi-shield-lock me-2"></i>Admin, Staff & Dosen
                </h5>
                <a href="{{ route('admin.users.create') }}" class="btn btn-success btn-sm px-4">
                    <i class="bi bi-plus-circle me-1"></i>Buat Akun Baru
                </a>
            </div>
            <div class="position-relative" style="width: 300px;">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-dark border-secondary text-secondary"><i
                            class="bi bi-search"></i></span>
                    <input type="text" id="searchStaff"
                        class="form-control bg-dark border-secondary text-white shadow-none"
                        placeholder="Cari admin/dosen/staff..." autocomplete="off">
                </div>
                <div id="suggestStaff" class="list-group position-absolute w-100 shadow-lg d-none autocomplete-box">
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0 align-middle">
                <thead>
                    <tr class="small text-secondary border-bottom border-secondary border-opacity-10">
                        <th class="ps-4 py-3">NAMA LENGKAP</th>
                        <th>EMAIL / USERNAME</th>
                        <th>ROLE</th>
                        <th class="text-end pe-4">AKSI</th>
                    </tr>
                </thead>
                <tbody id="staffTableBody">
                    {{-- Filter hanya yang BUKAN mahasiswa untuk tabel atas --}}
                    @foreach($users->whereIn('role', ['admin', 'staff', 'dosen', 'sesprodi', 'kaprodi']) as $user)
                    <tr class="border-bottom border-secondary border-opacity-10 staff-row">
                        <td class="ps-4 py-3">
                            <div class="fw-bold staff-name text-white">{{ $user->name }}</div>
                            <div class="text-secondary small">Dibuat: {{ $user->created_at->format('d M Y') }}</div>
                        </td>
                        <td class="text-info small fw-mono staff-username">
                            {{ $user->email }}
                        </td>
                        <td>
                            @php
                            $badgeClass = match($user->role) {
                            'admin' => 'bg-danger text-danger',
                            'staff' => 'bg-primary text-primary',
                            'dosen' => 'bg-success text-success',
                            default => 'bg-warning text-warning'
                            };
                            @endphp
                            <span
                                class="badge {{ $badgeClass }} bg-opacity-10 border border-opacity-25 px-3 py-1 small text-uppercase">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="dropdown">
                                <button class="btn btn-link text-secondary p-0" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots-vertical fs-5"></i></button>
                                <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow border-secondary">
                                    <li><a class="dropdown-item small" href="javascript:void(0)"
                                            onclick="openResetModal('{{ $user->id }}', '{{ $user->name }}')"><i
                                                class="bi bi-key me-2 text-warning"></i>Reset Password</a></li>
                                    <li>
                                        <hr class="dropdown-divider border-secondary opacity-50">
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus akun ini secara permanen?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="dropdown-item small text-danger"><i
                                                    class="bi bi-trash me-2"></i>Hapus Akun</button>
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

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0 text-info small text-uppercase"><i class="bi bi-people me-2"></i>Database Mahasiswa</h5>
        <div class="d-flex gap-2">
            <div class="position-relative" style="width: 300px;">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-dark border-secondary text-secondary"><i
                            class="bi bi-search"></i></span>
                    <input type="text" id="searchStudent"
                        class="form-control bg-dark border-secondary text-white shadow-none"
                        placeholder="Cari mahasiswa..." autocomplete="off">
                </div>
                <div id="suggestStudent" class="list-group position-absolute w-100 shadow-lg d-none autocomplete-box">
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="background: #15191d; border-radius: 12px;">
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0 align-middle">
                <thead style="background: #1c2227;">
                    <tr class="small text-secondary border-bottom border-secondary border-opacity-10">
                        <th class="ps-4 py-3">NIM</th>
                        <th>NAMA MAHASISWA</th>
                        <th class="text-center">ANGKATAN</th>
                        <th class="text-end pe-4">AKSI</th>
                    </tr>
                </thead>
                <tbody id="studentTableBody">
                    {{-- Filter Khusus Mahasiswa --}}
                    @forelse($users->where('role', 'mahasiswa') as $student)
                    <tr class="border-bottom border-secondary border-opacity-10 student-row">
                        <td class="ps-4 py-3 fw-mono text-info small student-nim">{{ $student->nim ?? '-' }}</td>
                        <td class="fw-bold student-name text-white">{{ $student->name }}</td>
                        <td class="text-center">
                            <span class="badge rounded-pill bg-dark border border-secondary px-3 py-1 small">
                                Cohort {{ $student->cohort ?? '?' }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="dropdown">
                                <button class="btn btn-link text-secondary p-0" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots-vertical fs-5"></i></button>
                                <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow border-secondary">
                                    <li><a class="dropdown-item small" href="javascript:void(0)"
                                            onclick="openResetModal('{{ $student->id }}', '{{ $student->name }}')"><i
                                                class="bi bi-key me-2 text-warning"></i>Reset Password</a></li>
                                    <li>
                                        <hr class="dropdown-divider border-secondary opacity-50">
                                    </li>
                                    <li>
                                        <form action="{{ route('admin.users.destroy', $student->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus akun ini secara permanen?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="dropdown-item small text-danger"><i
                                                    class="bi bi-trash me-2"></i>Hapus Akun</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-secondary">Data mahasiswa tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary shadow-lg">
            <div class="modal-header border-secondary border-opacity-25">
                <h5 class="modal-title text-white small fw-bold text-uppercase">
                    <i class="bi bi-shield-lock me-2 text-warning"></i>Reset Password User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="resetPasswordForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <p class="text-secondary small mb-3">Mengganti password untuk: <strong id="resetTargetName"
                            class="text-info"></strong></p>
                    <div class="mb-3">
                        <label class="form-label small text-secondary">Password Baru</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-secondary"><i
                                    class="bi bi-lock"></i></span>
                            <input type="password" name="password"
                                class="form-control bg-dark border-secondary text-white" id="newPassword" required
                                minlength="8" placeholder="Masukkan password baru">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePass()"><i
                                    class="bi bi-eye"></i></button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-dark border-secondary px-4 py-2 small"
                        data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 py-2 small">Simpan Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .fw-mono {
        font-family: 'Fira Code', monospace;
    }

    .autocomplete-box {
        z-index: 1050;
        top: 100%;
        background: #1c2227;
        border: 1px solid #2d343b;
        border-radius: 0 0 8px 8px;
        overflow: hidden;
    }

    .suggestion-item {
        background: #1c2227;
        color: #fff;
        cursor: pointer;
        border-color: #2d343b;
        transition: 0.2s;
    }

    .suggestion-item:hover {
        background: #00d2ff;
        color: #000;
    }

    .modal-content {
        border-radius: 15px;
    }
</style>

<script>
    function openResetModal(id, name) {
        const modal = new bootstrap.Modal(document.getElementById('resetPasswordModal'));
        document.getElementById('resetTargetName').innerText = name;

        // Route Reset Password Admin
        document.getElementById('resetPasswordForm').action = `/admin/users/${id}/reset-password`;
        document.getElementById('resetPasswordForm').method = 'POST';

        modal.show();
    }

    function togglePass() {
        const x = document.getElementById("newPassword");
        x.type = x.type === "password" ? "text" : "password";
    }

    document.addEventListener('DOMContentLoaded', function() {
        setupPredictiveSearch('searchStaff', 'suggestStaff', 'staff-row', 'staff-name', 'staff-username');
        setupPredictiveSearch('searchStudent', 'suggestStudent', 'student-row', 'student-name', 'student-nim');

        function setupPredictiveSearch(inputId, suggestId, rowClass, nameClass, idClass) {
            const input = document.getElementById(inputId);
            const suggestBox = document.getElementById(suggestId);
            if (!input) return;

            const rows = document.querySelectorAll('.' + rowClass);

            input.addEventListener('input', function() {
                const query = this.value.toLowerCase();
                rows.forEach(row => {
                    const name = row.querySelector('.' + nameClass).textContent.toLowerCase();
                    const identity = row.querySelector('.' + idClass).textContent.toLowerCase();
                    row.style.display = (name.includes(query) || identity.includes(query)) ? "" :
                        "none";
                });

                if (query.length < 1) {
                    suggestBox.classList.add('d-none');
                    return;
                }
                let matches = Array.from(rows).filter(r => r.querySelector('.' + nameClass).textContent
                    .toLowerCase().includes(query)).slice(0, 5);

                if (matches.length > 0) {
                    suggestBox.classList.remove('d-none');
                    suggestBox.innerHTML = matches.map(row => `
                    <div class="list-group-item suggestion-item small py-2 px-3 border-secondary border-opacity-25" onclick="selectSuggestion('${inputId}', '${suggestId}', '${row.querySelector('.'+nameClass).textContent}')">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>${row.querySelector('.'+nameClass).textContent}</span>
                            <small class="text-info">${row.querySelector('.'+idClass).textContent}</small>
                        </div>
                    </div>
                `).join('');
                } else {
                    suggestBox.classList.add('d-none');
                }
            });
            document.addEventListener('click', (e) => {
                if (!input.contains(e.target)) suggestBox.classList.add('d-none');
            });
        }
    });

    function selectSuggestion(inputId, suggestId, value) {
        const input = document.getElementById(inputId);
        input.value = value;
        input.dispatchEvent(new Event('input'));
        document.getElementById(suggestId).classList.add('d-none');
    }
</script>
@endsection
