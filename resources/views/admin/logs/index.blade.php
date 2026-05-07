@extends('layouts.app')

@section('title', 'System Activity Logs')

@push('styles')
<style>
    .filter-card {
        background: #1a1e23;
        border: 1px solid #2c3238;
        border-radius: 12px;
    }
    .form-control-dark, .form-select-dark {
        background-color: #2c3238;
        border: 1px solid #3c4248;
        color: #fff;
    }
    .form-control-dark:focus, .form-select-dark:focus {
        background-color: #363c43;
        border-color: #00d2ff;
        color: #fff;
        box-shadow: none;
    }
    /* Specific badge colors */
    .badge-create { background-color: #198754; } /* Success Green */
    .badge-update { background-color: #ffc107; color: #000; } /* Warning Yellow */
    .badge-delete { background-color: #dc3545; } /* Danger Red */
    .badge-login { background-color: #0d6efd; } /* Primary Blue */
    .badge-logout { background-color: #6c757d; } /* Secondary Gray */
    .badge-default { background-color: #0dcaf0; color: #000; } /* Info Cyan */
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0 text-white"><i class="bi bi-clock-history me-2 accent-color"></i> System Activity Logs</h2>
</div>

<!-- Filter Section -->
<div class="filter-card p-4 mb-4 shadow-sm">
    <form action="{{ route('admin.logs.index') }}" method="GET" class="row g-3">
        <div class="col-md-4">
            <label class="form-label text-secondary small text-uppercase fw-bold">Search</label>
            <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0 border-secondary text-secondary"><i class="bi bi-search"></i></span>
                <input type="text" name="search" class="form-control form-control-dark border-start-0" placeholder="Cari user atau deskripsi..." value="{{ request('search') }}">
            </div>
        </div>
        
        <div class="col-md-2">
            <label class="form-label text-secondary small text-uppercase fw-bold">Filter Action</label>
            <select name="action" class="form-select form-select-dark">
                <option value="">Semua Aksi</option>
                @foreach($actions as $act)
                    <option value="{{ $act }}" {{ request('action') == $act ? 'selected' : '' }}>{{ strtoupper($act) }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label text-secondary small text-uppercase fw-bold">Filter Module</label>
            <select name="module" class="form-select form-select-dark">
                <option value="">Semua Modul</option>
                @foreach($modules as $mod)
                    <option value="{{ $mod }}" {{ request('module') == $mod ? 'selected' : '' }}>{{ $mod }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label text-secondary small text-uppercase fw-bold">Filter Tanggal</label>
            <input type="date" name="date" class="form-control form-control-dark" value="{{ request('date') }}">
        </div>

        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-outline-info w-100 me-2"><i class="bi bi-funnel-fill me-1"></i> Filter</button>
            <a href="{{ route('admin.logs.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-counterclockwise"></i></a>
        </div>
    </form>
</div>

<!-- Table Section -->
<div class="stat-card shadow-sm border-0" style="background: #1a1e23;">
    <div class="table-responsive">
        <table class="table table-dark table-hover align-middle mb-0" style="background-color: transparent;">
            <thead style="border-bottom: 2px solid #2c3238;">
                <tr>
                    <th class="text-uppercase text-secondary small tracking-wider py-3">Waktu</th>
                    <th class="text-uppercase text-secondary small tracking-wider py-3">User</th>
                    <th class="text-uppercase text-secondary small tracking-wider py-3">Action</th>
                    <th class="text-uppercase text-secondary small tracking-wider py-3">Module</th>
                    <th class="text-uppercase text-secondary small tracking-wider py-3">Deskripsi</th>
                    <th class="text-uppercase text-secondary small tracking-wider py-3 text-end">IP Address</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr style="border-bottom: 1px solid #2c3238;">
                    <td class="py-3">
                        <span class="d-block fw-bold">{{ $log->created_at->format('d M Y') }}</span>
                        <small class="text-secondary">{{ $log->created_at->format('H:i:s') }}</small>
                    </td>
                    <td>
                        @if($log->user)
                            <span class="d-block fw-bold text-white">{{ $log->user->name }}</span>
                            <small class="text-secondary">{{ strtoupper($log->user->role) }}</small>
                        @else
                            <span class="d-block fw-bold text-secondary">System / Deleted User</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $badgeClass = match($log->action) {
                                'create' => 'badge-create',
                                'update', 'update_password' => 'badge-update',
                                'delete' => 'badge-delete',
                                'login' => 'badge-login',
                                'logout' => 'badge-logout',
                                default => 'badge-default'
                            };
                        @endphp
                        <span class="badge rounded-pill {{ $badgeClass }} px-3 py-2 shadow-sm" style="font-size: 0.75rem;">
                            {{ strtoupper($log->action) }}
                        </span>
                    </td>
                    <td><span class="text-light fw-medium">{{ $log->module }}</span></td>
                    <td><span class="text-secondary">{{ $log->description }}</span></td>
                    <td class="text-end"><span class="font-monospace text-muted small bg-dark px-2 py-1 rounded">{{ $log->ip_address }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-secondary py-5">
                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                        Tidak ada data log yang ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-end">
        {{ $logs->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
