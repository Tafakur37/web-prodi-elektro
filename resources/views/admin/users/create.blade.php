@extends('layouts.app')

@section('title', 'Buat Akun Baru')

@section('content')
<div class="container-fluid text-white">
    <div class="row">
        <div class="col-md-6">
            <h2 class="fw-bold mb-4">Buat Akun Baru</h2>
            <div class="p-4 rounded shadow-sm" style="background: #222; border: 1px solid #333;">
                @if ($errors->any())
                <div class="alert alert-danger small mb-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if (session('success'))
                <div class="alert alert-success small mb-3">{{ session('success') }}</div>
                @endif

                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label text-secondary">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                            class="form-control bg-dark text-white border-secondary @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" required placeholder="Masukkan nama lengkap">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="gender"
                            class="form-select bg-dark text-white border-secondary @error('gender') is-invalid @enderror" required>
                            <option value="">-- Pilih --</option>
                            <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email"
                            class="form-control bg-dark text-white border-secondary @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" required placeholder="user@example.com">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary">NIM/NIP/Username (opsional)</label>
                        <input type="text" name="nim"
                            class="form-control bg-dark text-white border-secondary @error('nim') is-invalid @enderror"
                            value="{{ old('nim') }}" placeholder="Gunakan NIM, NIP, atau username unik (jika ada)">
                        @error('nim')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary">Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" name="password" id="password"
                                class="form-control bg-dark text-white border-secondary @error('password') is-invalid @enderror"
                                required minlength="8" placeholder="Minimal 8 karakter">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                                <i class="bi bi-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary">Role Akses <span class="text-danger">*</span></label>
                        <select name="role" id="roleSelect"
                            class="form-select bg-dark text-white border-secondary @error('role') is-invalid @enderror"
                            required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Superman)
                            </option>
                            <option value="kaprodi" {{ old('role') == 'kaprodi' ? 'selected' : '' }}>Ketua Prodi
                                (Kaprodi)</option>
                            <option value="sesprodi" {{ old('role') == 'sesprodi' ? 'selected' : '' }}>Sekretaris Prodi
                                (Sesprodi)</option>
                            <option value="dosen" {{ old('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                            <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff Prodi</option>
                            <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa
                            </option>
                        </select>
                        @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4" id="cohortField" style="display: none;">
                        <label class="form-label text-secondary">Angkatan/Cohort <span
                                class="text-danger">*</span></label>
                        <input type="number" name="cohort"
                            class="form-control bg-dark text-white border-secondary @error('cohort') is-invalid @enderror"
                            value="{{ old('cohort') }}" min="1" max="20" placeholder="Contoh: 6 (untuk NIM 2025)">
                        @error('cohort')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">📝 Simpan & Daftarkan Akun</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">← Kembali ke Daftar
                            User</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('roleSelect');
        const cohortField = document.getElementById('cohortField');
        const cohortInput = cohortField.querySelector('input');

        // Role change handler
        roleSelect.addEventListener('change', function() {
            if (this.value === 'mahasiswa') {
                cohortField.style.display = 'block';
                cohortInput.required = true;
            } else {
                cohortField.style.display = 'none';
                cohortInput.required = false;
                cohortInput.value = '';
            }
        });

        // Trigger on load for old values
        roleSelect.dispatchEvent(new Event('change'));
    });

    function togglePassword() {
        const password = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');
        if (password.type === 'password') {
            password.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            password.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
</script>
@endsection
