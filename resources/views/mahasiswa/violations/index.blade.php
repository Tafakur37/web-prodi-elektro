@extends('layouts.mahasiswa')

@section('title', 'Riwayat Pelanggaran')

@push('styles')
<style>
.violation-summary-card {
    border-radius: var(--radius-xl);
    padding: 20px 22px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    animation: fadeInUp 0.4s cubic-bezier(0.22,1,0.36,1) both;
}
.violation-summary-card.has-violation {
    background: var(--danger-light);
    border: 1px solid rgba(186,26,26,0.2);
}
.violation-summary-card.no-violation {
    background: var(--success-light);
    border: 1px solid rgba(0,165,80,0.2);
}
.vscard-icon {
    width: 52px; height: 52px; flex-shrink: 0;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem;
}
.vscard-icon.danger { background: rgba(186,26,26,0.12); color: var(--danger); }
.vscard-icon.success { background: rgba(0,165,80,0.12); color: var(--success); }
.vscard-body { flex: 1; }
.vscard-label { font-family: var(--font-label); font-size: 0.6rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 2px; }
.vscard-label.danger { color: var(--danger); opacity: 0.7; }
.vscard-label.success { color: var(--success); opacity: 0.7; }
.vscard-value { font-family: var(--font-display); font-size: 1.6rem; font-weight: 800; line-height: 1; margin-bottom: 3px; }
.vscard-value.danger { color: var(--danger); }
.vscard-value.success { color: var(--success); }
.vscard-sub { font-size: 0.78rem; opacity: 0.72; }
.vscard-sub.danger { color: var(--danger); }
.vscard-sub.success { color: var(--success); }
</style>
@endpush

@section('content')

{{-- Total Points Alert --}}
@if($totalPoints > 0)
<div class="violation-summary-card has-violation">
    <div class="vscard-icon danger"><i class="bi bi-exclamation-octagon-fill"></i></div>
    <div class="vscard-body">
        <div class="vscard-label danger">Total Poin Pelanggaran Aktif</div>
        <div class="vscard-value danger">{{ $totalPoints }} <small style="font-size:0.9rem;font-weight:600;">Poin</small></div>
        <div class="vscard-sub danger">Hindari pelanggaran lebih lanjut untuk menjaga IPK!</div>
    </div>
</div>
@else
<div class="violation-summary-card no-violation">
    <div class="vscard-icon success"><i class="bi bi-shield-check-fill"></i></div>
    <div class="vscard-body">
        <div class="vscard-label success">Status Pelanggaran</div>
        <div class="vscard-value success">0 <small style="font-size:0.9rem;font-weight:600;">Poin</small></div>
        <div class="vscard-sub success">Bagus! Belum ada poin pelanggaran aktif. Terus jaga disiplin!</div>
    </div>
</div>
@endif

<div class="mhs-card">
    <div class="mhs-card-header">
        <h6 class="mhs-card-title">
            <span class="mhs-card-icon" style="background:var(--danger-light);color:var(--danger);">
                <i class="bi bi-exclamation-octagon"></i>
            </span>
            Semua Pelanggaran ({{ $violations->count() }})
        </h6>
    </div>
    <div style="overflow-x:auto;">
        <table class="mhs-table">
            <thead>
                <tr>
                    <th style="padding-left:20px;">Tanggal</th>
                    <th>Judul & Deskripsi</th>
                    <th>Poin</th>
                    <th>Status</th>
                    <th>Dilaporkan Oleh</th>
                    <th>Tanggal Dibuat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($violations as $violation)
                <tr>
                    <td style="padding-left:20px;font-size:0.8rem;">{{ $violation->date->format('d/m/Y') }}</td>
                    <td>
                        <span style="font-weight:700;color:var(--danger);display:block;margin-bottom:3px;">{{ $violation->title }}</span>
                        @if($violation->description)
                        <span style="font-size:0.72rem;color:var(--text-2);">{{ Str::limit($violation->description, 60) }}</span>
                        @endif
                    </td>
                    <td>
                        <span class="mhs-badge danger">{{ $violation->point }} poin</span>
                    </td>
                    <td>
                        @if($violation->status === 'aktif')
                            <span class="mhs-badge warning">Aktif</span>
                        @else
                            <span class="mhs-badge success">Selesai</span>
                        @endif
                    </td>
                    <td style="font-size:0.8rem;color:var(--text-2);">{{ $violation->reporter->name ?? 'Sistem' }}</td>
                    <td style="font-size:0.72rem;color:var(--text-3);">{{ $violation->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="mhs-empty" style="padding:48px 20px;color:var(--success);">
                            <i class="bi bi-shield-check"></i>
                            <p style="color:var(--text-2);">Belum ada riwayat pelanggaran.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($violations->count() > 5)
<div class="mhs-alert warning" style="margin-top:16px;">
    <i class="bi bi-info-circle"></i>
    Hanya menampilkan data terbaru. Kontak staff prodi untuk detail lengkap.
</div>
@endif

@endsection