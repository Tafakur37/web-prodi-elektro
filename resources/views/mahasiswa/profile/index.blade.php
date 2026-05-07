@extends('layouts.app')

@section('title', 'Profil & Kelola Akun')

@section('content')
<div class="container-fluid px-0">
    <div class="row g-4">
        <!-- Tampilan Profil Cepat -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 text-center p-4">
                <div class="position-relative d-inline-block mx-auto mb-3">
                    @if($user->profile_photo)
                        <img src="{{ asset('storage/profiles/' . $user->profile_photo) }}" class="rounded-circle border shadow-sm" width="120" height="120" style="object-fit: cover;">
                    @else
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 120px; height: 120px; margin: 0 auto;">
                            <i class="bi bi-person-fill" style="font-size: 4rem;"></i>
                        </div>
                    @endif
                </div>
                <h5 class="fw-bold text-dark mb-1">{{ $user->name }}</h5>
                <p class="text-secondary mb-3">{{ $user->email }}</p>
                <div class="d-flex justify-content-center gap-2 mb-2">
                    <span class="badge bg-primary px-3 py-2 rounded-pill text-uppercase">{{ $user->role }}</span>
                    @if($user->nim) <span class="badge bg-secondary px-3 py-2 rounded-pill">{{ $user->nim }}</span> @endif
                </div>
                <hr class="border-light my-4">
                <div class="text-start">
                    <p class="small text-muted mb-1">Terdaftar sejak:</p>
                    <p class="fw-bold text-dark">{{ $user->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Form Edit Profil & Password -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-bottom border-light pt-4 pb-3 px-4">
                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-person-gear text-primary me-2"></i> Pengaturan Akun</h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('mahasiswa.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row mb-4">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label class="form-label small fw-bold text-secondary">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control rounded-3" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label class="form-label small fw-bold text-secondary">Jenis Kelamin</label>
                                <select name="gender" class="form-select rounded-3">
                                    <option value="">Pilih</option>
                                    <option value="L" {{ old('gender', $user->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('gender', $user->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-secondary">Foto Profil Baru (Opsional)</label>
                                <input type="file" name="profile_photo" class="form-control rounded-3" accept="image/*">
                                <small class="text-muted d-block mt-1" style="font-size: 0.7rem;">Format: JPG/PNG, Maksimal: 2MB.</small>
                            </div>
                        </div>

                        <hr class="border-light my-4">
                        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-shield-lock text-warning me-2"></i> Ganti Password (Opsional)</h6>
                        <p class="small text-muted mb-4">Biarkan kosong jika Anda tidak ingin mengubah kata sandi.</p>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold text-secondary">Password Baru</label>
                                <input type="password" name="password" class="form-control rounded-3" placeholder="Minimal 8 karakter">
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label small fw-bold text-secondary">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="form-control rounded-3" placeholder="Ulangi password baru">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end pt-3 border-top border-light">
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
