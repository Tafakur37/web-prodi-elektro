@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <div class="card card-custom p-4 mb-4 bg-white border-start border-4 border-danger shadow-sm">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1">Registrasi Akun</h4>
                <p class="text-muted mb-0">Daftarkan Mahasiswa, Dosen, atau Staff baru ke sistem.</p>
            </div>
            <button class="btn btn-danger shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
                <i class="bi bi-person-plus-fill me-1"></i> Tambah Akun
            </button>
        </div>
    </div>

    <div class="card card-custom bg-white shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light small fw-bold text-uppercase">
                        <tr>
                            <th class="ps-4 py-3">Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Cohort</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="ps-4 fw-bold text-dark">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="badge bg-secondary text-capitalize">{{ $user->role }}</span></td>
                            <td>{{ $user->cohort ?? '-' }}</td>
                            <td class="text-center">
                                <form action="{{ route('staff.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus akun ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-link text-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold">Buat Akun Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('staff.users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Role Akun</label>
                        <select name="role" id="roleSelect" class="form-select" onchange="toggleCohortField()" required>
                            <option value="mahasiswa">Mahasiswa</option>
                            <option value="dosen">Dosen</option>
                            <option value="staff">Staff Prodi</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" placeholder="Nama tanpa gelar..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="user@elektro.com" required>
                    </div>
                    <div class="mb-3" id="cohortField">
                        <label class="form-label small fw-bold">Angkatan (Cohort)</label>
                        <input type="number" name="cohort" class="form-control" placeholder="6">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" value="elektro123" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger px-4">Daftarkan Akun</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleCohortField() {
        const role = document.getElementById('roleSelect').value;
        const field = document.getElementById('cohortField');
        field.style.display = (role === 'mahasiswa') ? 'block' : 'none';
    }
    // Jalankan sekali saat load
    toggleCohortField();
</script>
@endsection