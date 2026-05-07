@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-custom p-4 text-center bg-white shadow-sm mb-4">
                <div class="position-relative d-inline-block mx-auto mb-3">
                    @php 
                        $avatar = auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=2c3e50&color=fff';
                    @endphp
                    <img src="{{ $avatar }}" class="rounded-circle border p-1" width="120" height="120" style="object-fit: cover;">
                </div>
                <h5 class="fw-bold mb-0 text-dark">{{ auth()->user()->name }}</h5>
                <p class="text-muted small mb-3">Staff Administrasi Elektro</p>
                
                <form action="{{ route('staff.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="file" name="photo" id="photoInput" class="d-none" onchange="this.form.submit()">
                    <button type="button" onclick="document.getElementById('photoInput').click()" class="btn btn-light btn-sm fw-bold border text-secondary w-100">
                        <i class="bi bi-camera me-1"></i> Ganti Foto
                    </button>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card card-custom p-4 bg-white shadow-sm">
                <h5 class="fw-bold mb-4">Informasi Personal</h5>
                
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Nomor Telepon</label>
                        <input type="text" name="phone" class="form-control" value="{{ auth()->user()->phone ?? '-' }}">
                    </div>
                    <hr>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection