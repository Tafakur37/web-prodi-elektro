@extends('layouts.app')

@section('title', 'Daftar UKM')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h5 class="fw-bold text-dark mb-1">Unit Kegiatan Mahasiswa (UKM)</h5>
            <p class="text-secondary mb-0 small">Temukan dan ikuti kegiatan yang sesuai dengan minat Anda di kampus.</p>
        </div>
    </div>

    <div class="row g-4">
        @forelse($ukms as $ukm)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="bg-primary bg-opacity-10 p-4 text-center d-flex align-items-center justify-content-center" style="height: 150px;">
                    @if($ukm->logo)
                        <img src="{{ asset('storage/ukm/' . $ukm->logo) }}" alt="{{ $ukm->name }}" class="img-fluid" style="max-height: 100px;">
                    @else
                        <i class="bi bi-people-fill text-primary" style="font-size: 4rem;"></i>
                    @endif
                </div>
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-2">{{ $ukm->name }}</h5>
                    <p class="text-secondary small mb-4">{{ \Illuminate\Support\Str::limit($ukm->description ?? 'Belum ada deskripsi.', 120) }}</p>
                    
                    <div class="mt-auto">
                        <hr class="border-light">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="small fw-bold text-secondary">Kontak:</span>
                            <span class="badge bg-light text-dark border">{{ $ukm->contact ?? 'Tidak tersedia' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 text-center py-5">
                <i class="bi bi-box text-muted" style="font-size: 4rem;"></i>
                <h5 class="text-dark fw-bold mt-3">Belum ada data UKM</h5>
                <p class="text-secondary small mb-0">Daftar Unit Kegiatan Mahasiswa belum ditambahkan ke dalam sistem.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
