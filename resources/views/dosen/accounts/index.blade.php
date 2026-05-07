@extends('layouts.app')

@section('title', 'Kelola Akun')

@section('content')
<div class="container-fluid p-0">
    <h3 class="fw-bold mb-4 text-dark border-start border-4 border-primary ps-3">Kelola Akun</h3>

    <div class="row">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form action="#" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">Email</label>
                            <input type="email" value="{{ $dosen->email }}" class="form-control bg-light" disabled>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">Password Baru</label>
                            <input type="password" name="password" class="form-control" placeholder="Biarkan kosong jika tidak ingin mengubah">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi password baru">
                        </div>
                        <button type="button" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" onclick="alert('Fitur simpan password sedang dalam pengembangan.')">
                            <i class="bi bi-save me-2"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection