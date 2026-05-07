@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Overview System')

@section('content')
<div class="mb-4">
    <p class="text-secondary mb-0">Selamat datang kembali, <span class="accent-color fw-bold">{{ auth()->user()->name }}</span>.</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="admin-card p-4 h-100">
            <h6 class="text-secondary">Total Users</h6>
            <h2 class="fw-bold mb-1">{{ $totalUsers ?? 0 }}</h2>
            <small class="text-primary"><i class="bi bi-people"></i> Terdaftar di sistem</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="admin-card p-4 h-100">
            <h6 class="text-secondary">Total Mahasiswa</h6>
            <h2 class="fw-bold mb-1">{{ $totalMahasiswa ?? 0 }}</h2>
            <small class="text-info"><i class="bi bi-mortarboard"></i> Aktif</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="admin-card p-4 h-100">
            <h6 class="text-secondary">Total Dosen</h6>
            <h2 class="fw-bold mb-1">{{ $totalDosen ?? 0 }}</h2>
            <small class="text-success"><i class="bi bi-person-badge"></i> Aktif</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="admin-card p-4 h-100">
            <h6 class="text-secondary">Login Hari Ini</h6>
            <h2 class="fw-bold text-warning mb-1">{{ $loginsToday ?? 0 }}</h2>
            <small class="text-secondary"><i class="bi bi-box-arrow-in-right"></i> Sesi baru</small>
        </div>
    </div>
</div>

<div class="admin-card p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0"><i class="bi bi-bar-chart-steps me-2 accent-color"></i>Distribusi Mahasiswa Per Angkatan</h5>
        <span class="badge bg-info-subtle text-info">{{ $activitiesToday ?? 0 }} aktivitas hari ini</span>
    </div>
    <div class="row g-3">
        @forelse($mahasiswaPerCohort as $item)
            <div class="col-md-3">
                <div class="border rounded p-3 text-center h-100">
                    <span class="text-secondary d-block">Angkatan {{ $item->cohort ?? 'N/A' }}</span>
                    <h3 class="fw-bold mb-0 text-info">{{ $item->total }}</h3>
                    <small>Mahasiswa</small>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center text-secondary py-4">
                    <i class="bi bi-inbox display-6 d-block mb-2"></i>
                    Belum ada data angkatan terdeteksi.
                </div>
            </div>
        @endforelse
    </div>
</div>

<div class="admin-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0"><i class="bi bi-clock-history me-2 accent-color"></i>Log Aktivitas Terakhir</h5>
        <a href="{{ route('admin.logs.index') }}" class="btn btn-outline-info btn-sm">Lihat Semua</a>
    </div>
    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Nama / Role</th>
                    <th>Aksi</th>
                    <th>Waktu</th>
                    <th>IP Address</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activities as $log)
                    <tr>
                        <td>
                            @if($log->user)
                                {{ $log->user->name }}<br>
                                <small class="text-secondary">{{ $log->user->role }}</small>
                            @else
                                <span class="text-secondary">Deleted User</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ strtoupper($log->action) }}</span><br>
                            <small class="text-secondary">{{ $log->module }}</small>
                        </td>
                        <td>{{ $log->created_at->diffForHumans() }}</td>
                        <td><small class="text-secondary">{{ $log->ip_address }}</small></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-secondary py-4">
                            <i class="bi bi-inbox d-block fs-3 mb-2"></i>
                            Belum ada aktivitas tercatat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
