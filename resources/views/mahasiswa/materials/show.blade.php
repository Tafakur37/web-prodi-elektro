@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('mahasiswa.materials.index') }}" class="btn btn-outline-secondary rounded-pill px-4 mb-3 d-inline-block">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar Materi
            </a>
            <h3 class="fw-bold mb-1 text-dark border-start border-4 border-primary ps-3">{{ $material->title }}</h3>
            <p class="text-muted ms-3 mb-0">{{ $material->subject ? $material->subject->name : 'Materi Umum' }} &bull; Diunggah pada {{ $material->created_at->format('d M Y') }}</p>
        </div>
        <a href="{{ route('mahasiswa.materials.download', $material->id) }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="bi bi-download me-2"></i> Unduh File Asli
        </a>
    </div>

    <div class="row">
        <!-- Sidebar Detail Materi -->
        <div class="col-lg-3 mb-4 mb-lg-0">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3"><i class="bi bi-info-circle text-primary me-2"></i> Detail Materi</h6>
                    <div class="mb-3">
                        <small class="text-muted d-block">Dosen Pengampu</small>
                        <strong>{{ $material->user->name ?? 'Tidak diketahui' }}</strong>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Tipe Dokumen</small>
                        <span class="badge bg-secondary text-uppercase">{{ $material->file_type }}</span>
                    </div>
                    <div class="mb-4">
                        <small class="text-muted d-block">Deskripsi</small>
                        <p class="mb-0 small">{{ $material->description ?: 'Tidak ada deskripsi yang ditambahkan.' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Area Preview File -->
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-0 d-flex flex-column" style="min-height: 600px; background: #f8f9fa; border-radius: 1rem; overflow: hidden;">
                    
                    @if(in_array(strtolower($material->file_type), ['pdf']))
                        <!-- PDF Preview -->
                        <iframe src="{{ asset('storage/' . $material->file_path) }}" width="100%" height="100%" style="border: none; flex-grow: 1;" allowfullscreen></iframe>
                    @elseif(in_array(strtolower($material->file_type), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                        <!-- Image Preview -->
                        <div class="d-flex justify-content-center align-items-center h-100 p-4" style="flex-grow: 1;">
                            <img src="{{ asset('storage/' . $material->file_path) }}" alt="{{ $material->title }}" class="img-fluid rounded shadow-sm" style="max-height: 80vh; object-fit: contain;">
                        </div>
                    @else
                        <!-- No Preview Available -->
                        <div class="d-flex flex-column justify-content-center align-items-center h-100 p-5 text-center" style="flex-grow: 1;">
                            <i class="bi bi-file-earmark-arrow-down text-secondary opacity-50 mb-3" style="font-size: 5rem;"></i>
                            <h5 class="fw-bold text-dark">Pratinjau Tidak Tersedia</h5>
                            <p class="text-muted mb-4">File dengan format <strong>.{{ strtoupper($material->file_type) }}</strong> tidak dapat dipratinjau langsung di dalam browser.</p>
                            <a href="{{ route('mahasiswa.materials.download', $material->id) }}" class="btn btn-primary rounded-pill px-4">
                                <i class="bi bi-download me-2"></i> Silakan Unduh untuk Melihat
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
