@extends('layouts.mahasiswa')

@section('title', 'Riwayat Pelanggaran')

@section('content')

{{-- Total Points Alert --}}
@if($totalPoints > 0)
<div class="mhs-alert danger" style="margin-bottom:20px;">
    <i class="bi bi-exclamation-triangle-fill"></i>
    <div>
        <div style="font-size:0.84rem;font-weight:700;margin-bottom:2px;">Total Poin Pelanggaran Aktif</div>
        <div style="font-size:1.4rem;font-weight:800;">{{ $totalPoints }} Poin</div>
        <div style="font-size:0.75rem;opacity:0.75;margin-top:2px;">Hindari pelanggaran lebih lanjut untuk menjaga IPK!</div>
    </div>
</div>
@else
<div class="mhs-alert success" style="margin-bottom:20px;">
    <i class="bi bi-check-circle-fill"></i>
    <div>
        <strong>Bagus!</strong> Belum ada poin pelanggaran aktif. Terus jaga disiplin!
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