@extends('layouts.app')

@section('title', 'Riwayat Pelanggaran Saya')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">
            <i class="bi bi-exclamation-octagon text-danger me-2"></i>
            Riwayat Pelanggaran
        </h1>
    </div>

    <!-- Total Points Alert -->
    @if($totalPoints > 0)
    <div class="alert alert-warning shadow-sm mb-4">
        <div class="d-flex align-items-center">
            <i class="bi bi-exclamation-triangle-fill text-warning me-3 fs-3"></i>
            <div>
                <h5 class="mb-1">Total Poin Pelanggaran Aktif</h5>
                <h3 class="mb-0 fw-bold text-warning">{{ $totalPoints }} Poin</h3>
                <small class="text-muted">Hindari pelanggaran lebih lanjut untuk menjaga IPK!</small>
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-success shadow-sm mb-4">
        <i class="bi bi-check-circle-fill me-2"></i>
        <strong>Bagus!</strong> Belum ada poin pelanggaran aktif.
    </div>
    @endif
</div>

<!-- Violations Table -->
<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h6 class="mb-0"><i class="bi bi-list-ul me-2"></i>Semua Pelanggaran ({{ $violations->count() }})</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Judul</th>
                        <th>Poin</th>
                        <th>Status</th>
                        <th>Dilapor Oleh</th>
                        <th>Tanggal Dibuat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($violations as $violation)
                    <tr>
                        <td>{{ $violation->date->format('d/m/Y') }}</td>
                        <td>
                            <strong class="text-danger">{{ $violation->title }}</strong>
                            @if($violation->description)
                            <br><small class="text-muted">{{ Str::limit($violation->description, 60) }}</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-danger">{{ $violation->point }} poin</span>
                        </td>
                        <td>
                            @if($violation->status === 'aktif')
                            <span class="badge bg-warning text-dark">Aktif</span>
                            @else
                            <span class="badge bg-success">Selesai</span>
                            @endif
                        </td>
                        <td>{{ $violation->reporter->name ?? 'Sistem' }}</td>
                        <td><small class="text-muted">{{ $violation->created_at->format('d/m/Y H:i') }}</small></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="bi bi-shield-check display-4 text-success mb-3 d-block"></i>
                            <h5>Belum ada riwayat pelanggaran</h5>
                            <p class="text-muted">Terus jaga disiplin!</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($violations->count() > 5)
<div class="alert alert-info mt-4">
    <i class="bi bi-info-circle me-2"></i>
    Hanya menampilkan data terbaru. Kontak staff prodi untuk detail lengkap.
</div>
@endif
@endsection