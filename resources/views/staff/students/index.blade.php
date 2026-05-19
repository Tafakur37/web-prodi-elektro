@extends('layouts.app')

@section('title', 'Mahasiswa Angkatan ' . $selectedCohort)

@php
    $routeBase      = (auth()->user()->role === 'admin') ? 'admin' : 'staff';
    $indexRoute     = "{$routeBase}.students.index";
    $updateRoute    = "{$routeBase}.students.update";
    $resetPwRoute   = "{$routeBase}.students.reset_password";
@endphp

@push('styles')
<style>
    .filter-card { background:#fff; border:1px solid #e2e8f0; border-radius:14px; box-shadow:0 1px 3px rgba(0,0,0,0.04); }

    /* Avatar */
    .av-circle {
        width:38px; height:38px; border-radius:50%;
        background: linear-gradient(135deg,#10b981,#059669);
        color:#fff; font-weight:700; font-size:.85rem;
        display:flex; align-items:center; justify-content:center; flex-shrink:0;
    }

    /* Status badges */
    .badge-aktif    { background: #dcfce7; color: #166534; }
    .badge-nonaktif { background: #fee2e2; color: #991b1b; }

    /* Row hover */
    .table tbody tr { transition: background 0.15s ease; }
    .table tbody tr:hover { background: #f0fdf4 !important; }

    /* Modal */
    .modal-header-green {
        background: linear-gradient(135deg,#065f46,#059669);
        color:#fff;
    }
    .modal-header-green .btn-close { filter: invert(1); }
    .modal-header-amber {
        background: linear-gradient(135deg,#78350f,#d97706);
        color:#fff;
    }
    .modal-header-amber .btn-close { filter: invert(1); }
    .form-label { font-size:.8rem; font-weight:600; color:#64748b; text-transform:uppercase; letter-spacing:.4px; }
    .form-control, .form-select { border-radius:8px; font-size:.9rem; }
    .form-control:focus, .form-select:focus {
        border-color:#059669;
        box-shadow: 0 0 0 3px rgba(5,150,105,.15);
    }

    /* Back button */
    .btn-back {
        display:inline-flex; align-items:center; gap:6px;
        padding:8px 16px; border-radius:10px;
        background:#f1f5f9; color:#475569; border:none;
        font-size:.85rem; font-weight:600; text-decoration:none;
        transition: all 0.18s;
    }
    .btn-back:hover { background:#e2e8f0; color:#1e293b; }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">

    {{-- ── Back + Header ── --}}
    <div class="mb-4">
        <a href="{{ route($indexRoute) }}" class="btn-back mb-3 d-inline-flex">
            <i class="bi bi-arrow-left"></i> Kembali ke Pilihan Angkatan
        </a>
        <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap">
            <div>
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-mortarboard me-2 text-success"></i>
                    Mahasiswa Angkatan {{ $selectedCohort }}
                </h4>
                <p class="text-muted mb-0 small">Daftar dan manajemen data mahasiswa angkatan {{ $selectedCohort }}.</p>
            </div>
            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2 fs-6">
                {{ $students->total() }} Mahasiswa
            </span>
        </div>
    </div>

    {{-- ── Search ── --}}
    <div class="filter-card p-3 mb-4">
        <form action="{{ route($indexRoute) }}" method="GET" class="row g-2 align-items-end">
            <input type="hidden" name="cohort" value="{{ $selectedCohort }}">
            <div class="col-md-7">
                <label class="form-label mb-1">Cari Mahasiswa</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Cari Nama atau NIM..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-success w-100 fw-bold">
                    <i class="bi bi-search me-1"></i> Cari
                </button>
            </div>
            @if(request('search'))
            <div class="col-md-2">
                <a href="{{ route($indexRoute, ['cohort' => $selectedCohort]) }}" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-x-lg me-1"></i> Reset
                </a>
            </div>
            @endif
        </form>
    </div>

    {{-- ── Tabel Mahasiswa ── --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted" style="font-size:.72rem; font-weight:700; letter-spacing:.5px; text-transform:uppercase;">
                        <tr>
                            <th class="ps-4" style="min-width:55px">#</th>
                            <th style="min-width:120px">NIM</th>
                            <th style="min-width:220px">Nama Mahasiswa</th>
                            <th style="min-width:130px">Jenis Kelamin</th>
                            <th style="min-width:220px">Email</th>
                            <th style="min-width:130px">Status Keaktifan</th>
                            <th class="text-center pe-4" style="min-width:140px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $user)
                        <tr>
                            <td class="ps-4 text-muted small">{{ $students->firstItem() + $loop->index }}</td>
                            <td><span class="font-monospace fw-bold small text-dark">{{ $user->nim ?? '—' }}</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="av-circle">{{ substr($user->name, 0, 1) }}</div>
                                    <div class="fw-bold text-dark small">{{ $user->name }}</div>
                                </div>
                            </td>
                            <td>
                                @if($user->gender === 'L')
                                    <span class="badge rounded-pill" style="background:#dbeafe;color:#1e40af">
                                        <i class="bi bi-gender-male me-1"></i>Laki-laki
                                    </span>
                                @elseif($user->gender === 'P')
                                    <span class="badge rounded-pill" style="background:#fce7f3;color:#9d174d">
                                        <i class="bi bi-gender-female me-1"></i>Perempuan
                                    </span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td class="small text-muted">{{ $user->email }}</td>
                            <td>
                                @if($user->status_keaktifan === 'Aktif')
                                    <span class="badge badge-aktif rounded-pill">Aktif</span>
                                @elseif($user->status_keaktifan === 'Tidak Aktif')
                                    <span class="badge badge-nonaktif rounded-pill">Tidak Aktif</span>
                                @else
                                    <span class="badge rounded-pill" style="background:#f1f5f9;color:#475569">Belum Diset</span>
                                @endif
                            </td>
                            <td class="text-center pe-4">
                                <button class="btn btn-sm btn-outline-primary shadow-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEditMhs{{ $user->id }}"
                                    title="Edit Data">
                                    <i class="bi bi-pencil-square me-1"></i>Edit
                                </button>
                                <button class="btn btn-sm btn-outline-warning shadow-sm ms-1"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalResetMhs{{ $user->id }}"
                                    title="Reset Password">
                                    <i class="bi bi-key"></i>
                                </button>
                            </td>
                        </tr>

                        {{-- ═══ MODAL EDIT MAHASISWA ═══ --}}
                        <div class="modal fade" id="modalEditMhs{{ $user->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
                                    <form action="{{ route($updateRoute, $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header modal-header-green py-3">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="av-circle">{{ substr($user->name, 0, 1) }}</div>
                                                <div>
                                                    <h5 class="modal-title fw-bold mb-0">Edit Mahasiswa</h5>
                                                    <small class="opacity-75">{{ $user->nim ?? 'Belum ada NIM' }}</small>
                                                </div>
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="mb-3">
                                                <label class="form-label">NIM</label>
                                                <input type="text" name="nim" class="form-control font-monospace" value="{{ old('nim', $user->nim) }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Nama Lengkap</label>
                                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-6">
                                                    <label class="form-label">Angkatan (Cohort)</label>
                                                    <input type="number" name="cohort" class="form-control" value="{{ old('cohort', $user->cohort) }}">
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">Jenis Kelamin</label>
                                                    <select name="gender" class="form-select">
                                                        <option value="">— Pilih —</option>
                                                        <option value="L" {{ old('gender', $user->gender) == 'L' ? 'selected':'' }}>Laki-laki (L)</option>
                                                        <option value="P" {{ old('gender', $user->gender) == 'P' ? 'selected':'' }}>Perempuan (P)</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <label class="form-label">Status Keaktifan</label>
                                                <select name="status_keaktifan" class="form-select">
                                                    <option value="">— Pilih —</option>
                                                    <option value="Aktif"       {{ old('status_keaktifan', $user->status_keaktifan) == 'Aktif'       ? 'selected':'' }}>Aktif</option>
                                                    <option value="Tidak Aktif" {{ old('status_keaktifan', $user->status_keaktifan) == 'Tidak Aktif' ? 'selected':'' }}>Tidak Aktif</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top-0 pt-0 pb-4">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success px-4 fw-bold">
                                                <i class="bi bi-floppy me-1"></i> Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- ═══ MODAL RESET PASSWORD ═══ --}}
                        <div class="modal fade" id="modalResetMhs{{ $user->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
                                    <form action="{{ route($resetPwRoute, $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header modal-header-amber py-3">
                                            <h5 class="modal-title fw-bold"><i class="bi bi-key me-2"></i>Reset Password</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <p class="text-muted small mb-4">
                                                Anda akan mereset password untuk akun <strong>{{ $user->name }}</strong> ({{ $user->nim }}).
                                            </p>
                                            <div class="mb-3">
                                                <label class="form-label">Password Baru</label>
                                                <input type="password" name="password" class="form-control" required minlength="6">
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label">Konfirmasi Password Baru</label>
                                                <input type="password" name="password_confirmation" class="form-control" required minlength="6">
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top-0 pt-0 pb-4">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-warning px-4 fw-bold text-dark">
                                                <i class="bi bi-key me-1"></i> Reset Password
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                                Tidak ada mahasiswa ditemukan di angkatan {{ $selectedCohort }}.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if($students->hasPages())
        <div class="card-footer bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
            <span class="text-muted small">
                Menampilkan {{ $students->firstItem() }}–{{ $students->lastItem() }} dari {{ $students->total() }} mahasiswa
            </span>
            {{ $students->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
