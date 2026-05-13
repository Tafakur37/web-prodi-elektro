@extends('layouts.app')
@section('title', 'Log Aktivitas Sistem')

@push('styles')
<style>
    /* ── Page specific styles ────────────────────────────────────── */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .page-header h2 {
        font-size: 1.4rem;
        font-weight: 800;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-header h2 i { color: #6366f1; }

    /* ── Filter Card ─────────────────────────────────────────────── */
    .filter-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 20px 24px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }

    .filter-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #94a3b8;
        margin-bottom: 6px;
        display: block;
    }

    .filter-input {
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        color: #1e293b;
        font-size: 0.875rem;
        padding: 8px 14px;
        width: 100%;
        transition: all 0.2s;
        outline: none;
    }

    .filter-input:focus {
        background: #ffffff;
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
    }

    .input-with-icon {
        position: relative;
    }

    .input-with-icon i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 0.9rem;
    }

    .input-with-icon input {
        padding-left: 36px;
    }

    .btn-filter {
        background: linear-gradient(135deg, #6366f1, #818cf8);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 9px 20px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
        box-shadow: 0 2px 8px rgba(99,102,241,0.25);
    }

    .btn-filter:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(99,102,241,0.35);
    }

    .btn-reset {
        background: #f1f5f9;
        color: #64748b;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 9px 14px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-reset:hover {
        background: #e2e8f0;
        color: #475569;
    }

    /* ── Table Container ─────────────────────────────────────────── */
    .table-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        overflow: hidden;
    }

    .logs-table {
        width: 100%;
        border-collapse: collapse;
    }

    .logs-table thead tr {
        background: #f8fafc;
        border-bottom: 1.5px solid #e2e8f0;
    }

    .logs-table thead th {
        padding: 13px 16px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #94a3b8;
        white-space: nowrap;
    }

    .logs-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.12s;
    }

    .logs-table tbody tr:last-child { border-bottom: none; }

    .logs-table tbody tr:hover { background: #f8fafc; }

    .logs-table td {
        padding: 12px 16px;
        color: #1e293b;
        font-size: 0.875rem;
        vertical-align: middle;
    }

    /* ── Action Badges ───────────────────────────────────────────── */
    .action-badge {
        display: inline-flex;
        align-items: center;
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .badge-login   { background: #dbeafe; color: #1d4ed8; }
    .badge-logout  { background: #f1f5f9; color: #64748b; }
    .badge-create  { background: #dcfce7; color: #15803d; }
    .badge-update  { background: #fef9c3; color: #854d0e; }
    .badge-delete  { background: #fee2e2; color: #b91c1c; }
    .badge-default { background: #e0e7ff; color: #4338ca; }

    /* ── User cell ───────────────────────────────────────────────── */
    .user-cell-name {
        font-weight: 600;
        color: #1e293b;
        font-size: 0.875rem;
    }

    .user-cell-role {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #94a3b8;
        margin-top: 2px;
    }

    /* ── IP Cell ─────────────────────────────────────────────────── */
    .ip-chip {
        font-family: 'Courier New', monospace;
        font-size: 0.75rem;
        background: #f1f5f9;
        color: #475569;
        padding: 3px 10px;
        border-radius: 6px;
        white-space: nowrap;
    }

    /* ── Time cell ───────────────────────────────────────────────── */
    .time-date {
        font-weight: 700;
        color: #1e293b;
        font-size: 0.875rem;
    }

    .time-hour {
        font-size: 0.75rem;
        color: #94a3b8;
        margin-top: 2px;
    }

    /* ── Module chip ─────────────────────────────────────────────── */
    .module-chip {
        background: #ede9fe;
        color: #6d28d9;
        font-size: 0.72rem;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 6px;
    }

    /* ── Empty State ─────────────────────────────────────────────── */
    .empty-state {
        text-align: center;
        padding: 60px 24px;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 2.5rem;
        display: block;
        margin-bottom: 12px;
        opacity: 0.4;
    }

    .empty-state p {
        font-size: 0.875rem;
        margin: 0;
    }

    /* ── Pagination ──────────────────────────────────────────────── */
    .pagination-wrap {
        padding: 16px 20px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: flex-end;
    }

    .pagination-wrap .pagination { margin: 0; }

    .pagination .page-link {
        border-color: #e2e8f0;
        color: #6366f1;
        border-radius: 8px;
        margin: 0 2px;
        font-size: 0.8rem;
    }

    .pagination .page-item.active .page-link {
        background-color: #6366f1;
        border-color: #6366f1;
    }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <h2>
        <i class="bi bi-clock-history"></i>
        Log Aktivitas Sistem
    </h2>
    <div style="font-size:0.8rem; color:#94a3b8;">
        <i class="bi bi-info-circle me-1"></i>
        Mencatat semua aktivitas pengguna di sistem
    </div>
</div>

{{-- Filter Panel --}}
<div class="filter-panel">
    <form action="{{ route('admin.logs.index') }}" method="GET">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="filter-label">Cari User / Deskripsi</label>
                <div class="input-with-icon">
                    <i class="bi bi-search"></i>
                    <input type="text" name="search" class="filter-input"
                           placeholder="Nama user atau deskripsi..." value="{{ request('search') }}">
                </div>
            </div>

            <div class="col-md-2">
                <label class="filter-label">Filter Aksi</label>
                <select name="action" class="filter-input" style="cursor:pointer;">
                    <option value="">Semua Aksi</option>
                    @foreach($actions as $act)
                        <option value="{{ $act }}" {{ request('action') == $act ? 'selected' : '' }}>
                            {{ strtoupper($act) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="filter-label">Filter Modul</label>
                <select name="module" class="filter-input" style="cursor:pointer;">
                    <option value="">Semua Modul</option>
                    @foreach($modules as $mod)
                        <option value="{{ $mod }}" {{ request('module') == $mod ? 'selected' : '' }}>
                            {{ $mod }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="filter-label">Tanggal</label>
                <input type="date" name="date" class="filter-input" value="{{ request('date') }}">
            </div>

            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn-filter flex-grow-1">
                    <i class="bi bi-funnel-fill"></i> Filter
                </button>
                <a href="{{ route('admin.logs.index') }}" class="btn-reset">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </div>
    </form>
</div>

{{-- Logs Table --}}
<div class="table-panel">
    <div class="table-responsive">
        <table class="logs-table">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>User</th>
                    <th>Aksi</th>
                    <th>Modul</th>
                    <th>Deskripsi</th>
                    <th style="text-align:right;">IP Address</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td>
                        <div class="time-date">{{ $log->created_at->format('d M Y') }}</div>
                        <div class="time-hour">{{ $log->created_at->format('H:i:s') }}</div>
                    </td>
                    <td>
                        @if($log->user)
                            <div class="user-cell-name">{{ $log->user->name }}</div>
                            <div class="user-cell-role">{{ strtoupper($log->user->role) }}</div>
                        @else
                            <div class="user-cell-name" style="color:#94a3b8;">System / Deleted</div>
                        @endif
                    </td>
                    <td>
                        @php
                            $badgeClass = match($log->action) {
                                'create'                    => 'badge-create',
                                'update', 'update_password' => 'badge-update',
                                'delete'                    => 'badge-delete',
                                'login'                     => 'badge-login',
                                'logout'                    => 'badge-logout',
                                default                     => 'badge-default',
                            };
                        @endphp
                        <span class="action-badge {{ $badgeClass }}">
                            {{ strtoupper($log->action) }}
                        </span>
                    </td>
                    <td>
                        <span class="module-chip">{{ $log->module }}</span>
                    </td>
                    <td style="color:#64748b; max-width:280px;">
                        {{ $log->description }}
                    </td>
                    <td style="text-align:right;">
                        <span class="ip-chip">{{ $log->ip_address ?? '-' }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <p>Tidak ada data log yang ditemukan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($logs->hasPages())
    <div class="pagination-wrap">
        {{ $logs->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>

@endsection
