@extends('layouts.mahasiswa')

@section('title', 'Daftar UKM')

@section('content')

<div style="margin-bottom:20px;">
    <h5 style="font-family:var(--font-display);font-weight:700;color:var(--text-1);margin:0 0 6px;">Unit Kegiatan Mahasiswa</h5>
    <p style="font-size:0.84rem;color:var(--text-2);margin:0;">Temukan dan ikuti kegiatan yang sesuai dengan minat Anda di kampus.</p>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:18px;">
    @forelse($ukms as $ukm)
    <div class="mhs-card" style="display:flex;flex-direction:column;">

        {{-- UKM Logo --}}
        <div style="height:140px;display:flex;align-items:center;justify-content:center;background:var(--primary-light);border-radius:var(--radius-xl) var(--radius-xl) 0 0;border-bottom:1px solid var(--border);">
            @if($ukm->logo)
                <img src="{{ asset('storage/ukm/' . $ukm->logo) }}" alt="{{ $ukm->name }}" style="max-height:100px;max-width:80%;object-fit:contain;">
            @else
                <i class="bi bi-people-fill" style="font-size:3.5rem;color:var(--primary);"></i>
            @endif
        </div>

        {{-- Card Body --}}
        <div class="mhs-card-body" style="flex:1;display:flex;flex-direction:column;">
            <h5 style="font-family:var(--font-display);font-weight:700;font-size:0.95rem;color:var(--text-1);margin:0 0 8px;">{{ $ukm->name }}</h5>
            <p style="font-size:0.78rem;color:var(--text-2);margin:0 0 14px;flex:1;line-height:1.55;">
                {{ \Illuminate\Support\Str::limit($ukm->description ?? 'Belum ada deskripsi.', 120) }}
            </p>
            <div style="padding-top:12px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:0.7rem;font-weight:700;color:var(--text-3);text-transform:uppercase;">Kontak:</span>
                <span class="mhs-badge muted">{{ $ukm->contact ?? 'Tidak tersedia' }}</span>
            </div>
        </div>
    </div>
    @empty
    <div style="grid-column:1/-1;">
        <div class="mhs-card">
            <div class="mhs-empty" style="padding:60px 20px;">
                <i class="bi bi-box"></i>
                <p>Belum ada data UKM yang tersedia.</p>
            </div>
        </div>
    </div>
    @endforelse
</div>

@endsection
