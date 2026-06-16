@extends('layouts.mahasiswa')

@section('title', 'Detail Materi')

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;gap:12px;flex-wrap:wrap;">
    <div style="display:flex;align-items:center;gap:12px;">
        <a href="{{ route('mahasiswa.materials.index') }}" class="mhs-btn mhs-btn-ghost mhs-btn-sm">
            <i class="bi bi-arrow-left"></i> Daftar Materi
        </a>
        <div>
            <h5 style="font-family:var(--font-display);font-weight:700;color:var(--text-1);margin:0 0 2px;font-size:1rem;">{{ $material->title }}</h5>
            <p style="font-size:0.75rem;color:var(--text-3);margin:0;">{{ $material->subject ? $material->subject->name : 'Materi Umum' }} &bull; Diunggah {{ $material->created_at->format('d M Y') }}</p>
        </div>
    </div>
    <a href="{{ route('mahasiswa.materials.download', $material->id) }}" class="mhs-btn mhs-btn-primary mhs-btn-sm">
        <i class="bi bi-download"></i> Unduh File Asli
    </a>
</div>

<div style="display:grid;grid-template-columns:240px 1fr;gap:20px;align-items:start;">

    {{-- Detail Sidebar --}}
    <div class="mhs-card">
        <div class="mhs-card-header" style="padding:14px 16px;">
            <h6 class="mhs-card-title" style="font-size:0.84rem;">
                <span class="mhs-card-icon" style="background:var(--success-light);color:var(--success);width:26px;height:26px;">
                    <i class="bi bi-info-circle"></i>
                </span>
                Detail Materi
            </h6>
        </div>
        <div class="mhs-card-body">
            <div style="margin-bottom:14px;">
                <div class="mhs-section-label">Dosen Pengampu</div>
                <div style="font-size:0.84rem;font-weight:600;color:var(--text-1);">{{ $material->user->name ?? 'Tidak diketahui' }}</div>
            </div>
            <div style="margin-bottom:14px;">
                <div class="mhs-section-label">Tipe Dokumen</div>
                <span class="mhs-badge muted" style="text-transform:uppercase;">{{ $material->file_type }}</span>
            </div>
            <div>
                <div class="mhs-section-label">Deskripsi</div>
                <p style="font-size:0.8rem;color:var(--text-2);margin:0;line-height:1.55;">
                    {{ $material->description ?: 'Tidak ada deskripsi yang ditambahkan.' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Preview Area --}}
    <div class="mhs-card" style="overflow:hidden;">
        <div style="min-height:600px;display:flex;flex-direction:column;background:rgba(0,0,0,0.2);">
            @if(in_array(strtolower($material->file_type), ['pdf']))
                <iframe src="{{ asset('storage/' . $material->file_path) }}"
                    style="width:100%;height:100%;min-height:600px;border:none;flex-grow:1;" allowfullscreen></iframe>

            @elseif(in_array(strtolower($material->file_type), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                <div style="display:flex;justify-content:center;align-items:center;flex-grow:1;padding:20px;">
                    <img src="{{ asset('storage/' . $material->file_path) }}" alt="{{ $material->title }}"
                        style="max-height:80vh;max-width:100%;object-fit:contain;border-radius:var(--radius-lg);">
                </div>

            @else
                <div style="display:flex;flex-direction:column;justify-content:center;align-items:center;flex-grow:1;padding:60px 20px;text-align:center;">
                    <i class="bi bi-file-earmark-arrow-down" style="font-size:4rem;color:var(--text-3);margin-bottom:16px;"></i>
                    <h5 style="font-family:var(--font-display);font-weight:700;color:var(--text-1);margin-bottom:8px;">Pratinjau Tidak Tersedia</h5>
                    <p style="font-size:0.84rem;color:var(--text-2);margin-bottom:20px;">
                        File dengan format <strong>.{{ strtoupper($material->file_type) }}</strong> tidak dapat dipratinjau langsung di browser.
                    </p>
                    <a href="{{ route('mahasiswa.materials.download', $material->id) }}" class="mhs-btn mhs-btn-primary">
                        <i class="bi bi-download"></i> Unduh untuk Melihat
                    </a>
                </div>
            @endif
        </div>
    </div>

</div>

@endsection
