@extends('layouts.app')

@section('content')
<style>
/* Styling untuk Autocomplete Suggestion */
.search-container {
    position: relative;
    max-width: 400px;
}

#suggestion-box {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    z-index: 1050;
    border-radius: 0 0 12px 12px;
    display: none;
    max-height: 250px;
    overflow-y: auto;
    border: 1px solid #e9ecef;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.suggestion-item {
    padding: 12px 15px;
    cursor: pointer;
    border-bottom: 1px solid #f8f9fa;
    transition: background 0.2s;
}

.suggestion-item:hover {
    background-color: #f1f3f5;
}

.suggestion-item:last-child {
    border-radius: 0 0 12px 12px;
    border-bottom: none;
}
</style>

<div class="card card-custom p-4 bg-white shadow-sm border-0 rounded-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-0 text-dark">
                <i class="bi bi-person-gear me-2 text-primary"></i>Manajemen Akun
            </h5>
            <small class="text-muted">Kelola data mahasiswa, dosen, dan staff prodi</small>
        </div>
        <a href="{{ route('staff.users.create') }}" class="btn btn-primary px-3 rounded-pill shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Akun
        </a>
    </div>

    {{-- Pencarian & Autocomplete --}}
    <div class="search-container mb-4">
        <div class="input-group">
            <span class="input-group-text bg-light border-0 rounded-start-pill px-3">
                <i class="bi bi-search text-muted"></i>
            </span>
            <input type="text" id="user-search" class="form-control bg-light border-0 rounded-end-pill py-2 shadow-none"
                placeholder="Cari nama atau NIM..." autocomplete="off">
        </div>
        <div id="suggestion-box"></div>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <i class="bi bi-check-circle-fill me-2"></i>
            <div>{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <ul class="nav nav-pills mb-4 bg-light p-2 rounded-4" id="pills-tab" role="tablist">
        <li class="nav-item w-50" role="presentation">
            <button class="nav-link active rounded-pill w-100 py-2" id="pills-student-tab" data-bs-toggle="pill"
                data-bs-target="#pills-student" type="button" role="tab">
                <i class="bi bi-mortarboard me-2"></i>Mahasiswa
            </button>
        </li>
        <li class="nav-item w-50" role="presentation">
            <button class="nav-link rounded-pill w-100 py-2" id="pills-staff-tab" data-bs-toggle="pill"
                data-bs-target="#pills-staff" type="button" role="tab">
                <i class="bi bi-person-badge me-2"></i>Dosen & Staff
            </button>
        </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">
        {{-- TAB MAHASISWA --}}
        <div class="tab-pane fade show active" id="pills-student" role="tabpanel">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="text-muted small text-uppercase">
                        <tr>
                            <th class="border-0 px-3">NIM</th>
                            <th class="border-0">Nama Mahasiswa</th>
                            <th class="border-0">Email</th>
                            <th class="border-0 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mahasiswa as $student)
                        <tr>
                            <td class="px-3"><span class="fw-bold text-dark">{{ $student->nim ?? '-' }}</span></td>
                            <td>{{ $student->name }}</td>
                            <td class="text-muted">{{ $student->email }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('staff.users.edit', $student->id) }}"
                                        class="btn btn-sm btn-light rounded-circle p-2">
                                        <i class="bi bi-pencil-square text-primary"></i>
                                    </a>
                                    <form action="{{ route('staff.users.destroy', $student->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus akun ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light rounded-circle p-2">
                                            <i class="bi bi-trash text-danger"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Tidak ada data mahasiswa.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- TAB DOSEN & STAFF --}}
        <div class="tab-pane fade" id="pills-staff" role="tabpanel">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="text-muted small text-uppercase">
                        <tr>
                            <th class="border-0 px-3">Nama</th>
                            <th class="border-0">Role</th>
                            <th class="border-0">Email</th>
                            <th class="border-0 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($others as $person)
                        <tr>
                            <td class="px-3"><span class="fw-bold text-dark">{{ $person->name }}</span></td>
                            <td>
                                <span
                                    class="badge {{ $person->role == 'dosen' ? 'bg-info-subtle text-info border border-info-subtle' : 'bg-dark-subtle text-dark border border-dark-subtle' }} px-3 rounded-pill text-capitalize">
                                    {{ $person->role }}
                                </span>
                            </td>
                            <td class="text-muted">{{ $person->email }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('staff.users.edit', $person->id) }}"
                                        class="btn btn-sm btn-light rounded-circle p-2">
                                        <i class="bi bi-pencil-square text-primary"></i>
                                    </a>
                                    <form action="{{ route('staff.users.destroy', $person->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus akun ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light rounded-circle p-2">
                                            <i class="bi bi-trash text-danger"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-person-x fs-1 d-block mb-2"></i>
                                Tidak ada data staff/dosen.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('user-search');
    const suggestionBox = document.getElementById('suggestion-box');

    searchInput.addEventListener('input', function() {
        let query = this.value;

        if (query.length > 1) {
            // Memanggil route global yang sudah didefinisikan di web.php
            fetch("{{ route('global.users.suggestions') }}?query=" + encodeURIComponent(query))
                .then(response => response.json())
                .then(data => {
                    suggestionBox.innerHTML = '';
                    if (data.length > 0) {
                        suggestionBox.style.display = 'block';
                        data.forEach(user => {
                            let div = document.createElement('div');
                            div.classList.add('suggestion-item');
                            div.innerHTML = `
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary-subtle p-2 rounded-circle me-3">
                                        <i class="bi bi-person text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark small">${user.name}</div>
                                        <div class="text-muted" style="font-size: 11px;">${user.nim || user.role.toUpperCase()}</div>
                                    </div>
                                </div>
                            `;
                            div.addEventListener('click', function() {
                                // Redirect ke halaman edit sesuai ID user yang dipilih
                                window.location.href =
                                    `/staff/users/${user.id}/edit`;
                            });
                            suggestionBox.appendChild(div);
                        });
                    } else {
                        suggestionBox.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error fetching suggestions:', error);
                });
        } else {
            suggestionBox.style.display = 'none';
        }
    });

    // Menutup suggestion box jika user klik di area mana saja selain input atau box itu sendiri
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !suggestionBox.contains(e.target)) {
            suggestionBox.style.display = 'none';
        }
    });
});
</script>
@endsection