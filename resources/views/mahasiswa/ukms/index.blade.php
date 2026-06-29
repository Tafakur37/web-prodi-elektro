@extends('layouts.mahasiswa')

@section('title', 'Daftar UKM')

@push('styles')
<style>
.ukm-card {
    display: flex;
    flex-direction: column;
    background: var(--card-glass-bg);
    backdrop-filter: blur(40px) saturate(180%);
    -webkit-backdrop-filter: blur(40px) saturate(180%);
    border: 1px solid var(--card-glass-border);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: 0 6px 24px rgba(0,0,0,0.07), inset 0 1px 0 rgba(255,255,255,0.5);
    transition: all 0.28s cubic-bezier(0.34,1.56,0.64,1);
    animation: fadeInUp 0.4s cubic-bezier(0.22,1,0.36,1) both;
}

.ukm-card:hover {
    transform: translateY(-6px) scale(1.01);
    box-shadow: 0 20px 48px rgba(0,89,187,0.15), inset 0 1px 0 rgba(255,255,255,0.7);
    border-color: rgba(0,89,187,0.22);
}

.ukm-card-img {
    height: 130px;
    display: flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, var(--info-light), var(--surface-container));
    border-bottom: 1px solid var(--card-glass-border);
    position: relative;
    overflow: hidden;
}

.ukm-card-img::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse 80% 60% at 50% 50%, rgba(0,89,187,0.06) 0%, transparent 70%);
}

.ukm-card:hover .ukm-card-img::before {
    background: radial-gradient(ellipse 80% 60% at 50% 50%, rgba(0,89,187,0.1) 0%, transparent 70%);
}
</style>
@endpush

@section('content')

<div style="margin-bottom:20px;">
    <h5 style="font-family:var(--font-display);font-weight:700;color:var(--text-1);margin:0 0 6px;">Unit Kegiatan Mahasiswa</h5>
    <p style="font-size:0.83rem;color:var(--text-2);margin:0;">Temukan dan ikuti kegiatan yang sesuai dengan minat Anda di kampus.</p>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(270px,1fr));gap:16px;">
    @forelse($ukms as $ukm)
    <div class="ukm-card" style="animation-delay:{{ $loop->index * 0.05 }}s">

        {{-- UKM Logo --}}
        <div class="ukm-card-img">
            @if($ukm->logo)
                <img src="{{ asset('storage/ukm/' . $ukm->logo) }}" alt="{{ $ukm->name }}" style="max-height:95px;max-width:75%;object-fit:contain;position:relative;z-index:1;transition:transform 0.3s ease;">
            @else
                <i class="bi bi-people-fill" style="font-size:3.2rem;color:var(--secondary);opacity:0.4;position:relative;z-index:1;"></i>
            @endif
        </div>

        {{-- Card Body --}}
        <div class="mhs-card-body" style="flex:1;display:flex;flex-direction:column;">
            <h5 style="font-family:var(--font-display);font-weight:700;font-size:0.93rem;color:var(--text-1);margin:0 0 7px;">{{ $ukm->name }}</h5>
            <p style="font-size:0.77rem;color:var(--text-2);margin:0 0 12px;flex:1;line-height:1.55;">
                {{ \Illuminate\Support\Str::limit($ukm->description ?? 'Belum ada deskripsi.', 110) }}
            </p>
            <div style="padding-top:10px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
                <span style="font-size:0.68rem;font-weight:700;color:var(--text-3);text-transform:uppercase;letter-spacing:0.08em;">Kontak</span>
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
