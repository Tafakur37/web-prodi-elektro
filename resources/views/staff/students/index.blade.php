@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <div class="card card-custom p-4 mb-4 bg-white border-start border-4 border-primary shadow-sm">
        <h4 class="fw-bold mb-1"><i class="bi bi-people me-2 text-primary"></i>Manajemen Akun Mahasiswa</h4>
        <p class="text-muted mb-0">Pantau dan kelola data akun mahasiswa per angkatan.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <form action="{{ route('staff.students.index') }}" method="GET" class="row g-3">
                <div class="col-md-5">
                    <input type="text" name="search" class="form-control" placeholder="Cari Nama atau NIM..." value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <select name="cohort" class="form-select">
                        <option value="">Semua Angkatan</option>
                        @foreach($availableCohorts as $c)
                            <option value="{{ $c }}" {{ request('cohort') == $c ? 'selected' : '' }}>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-secondary w-100 fw-bold"><i class="bi bi-search me-1"></i> Cari & Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small fw-bold">
                        <tr>
                            <th class="ps-4">NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Angkatan</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $user)
                        <tr>
                            <td class="ps-4 fw-medium">{{ $user->nim }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle bg-primary text-white d-flex justify-content-center align-items-center rounded-circle me-3" style="width: 40px; height: 40px; font-weight: bold;">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $user->name }}</div>
                                        <div class="small text-muted">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-secondary-subtle text-secondary rounded-pill">{{ $user->cohort ?? '-' }}</span></td>
                            <td class="text-center pe-4">
                                <button class="btn btn-sm btn-outline-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $user->id }}" title="Edit Data">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning shadow-sm ms-1" data-bs-toggle="modal" data-bs-target="#modalReset{{ $user->id }}" title="Reset Password">
                                    <i class="bi bi-key"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="modalEdit{{ $user->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content border-0 shadow">
                                    <form action="{{ route('staff.students.update', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header border-bottom-0 pb-0">
                                            <h5 class="modal-title fw-bold">Edit Mahasiswa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-muted">NIM</label>
                                                <input type="text" name="nim" class="form-control" value="{{ $user->nim }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
                                                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-muted">Angkatan (Cohort)</label>
                                                <input type="number" name="cohort" class="form-control" value="{{ $user->cohort }}">
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top-0 pt-0">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary px-4 fw-bold">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Reset Password -->
                        <div class="modal fade" id="modalReset{{ $user->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content border-0 shadow">
                                    <form action="{{ route('staff.students.reset_password', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header bg-warning bg-opacity-25 pb-3">
                                            <h5 class="modal-title fw-bold text-dark"><i class="bi bi-key me-2 text-warning"></i> Reset Password</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="text-muted small mb-4">Anda akan mereset password untuk akun <strong>{{ $user->name }}</strong> ({{ $user->nim }}).</p>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-muted">Password Baru</label>
                                                <input type="password" name="password" class="form-control" required minlength="6">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-muted">Konfirmasi Password Baru</label>
                                                <input type="password" name="password_confirmation" class="form-control" required minlength="6">
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top-0 pt-0">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-warning px-4 fw-bold text-dark">Reset Password</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Tidak ada data mahasiswa yang ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($students->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $students->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
