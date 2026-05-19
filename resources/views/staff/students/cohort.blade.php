@extends('layouts.app')

@section('title', 'Data Mahasiswa')

@php
    $routeBase  = (auth()->user()->role === 'admin') ? 'admin' : 'staff';
    $indexRoute = "{$routeBase}.students.index";
@endphp

@push('styles')
<style>
    /* ─── Cohort Card Grid ─── */
    .cohort-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
    }

    .cohort-select-card {
        background: #fff;
        border: 2px solid #e2e8f0;
        border-radius: 18px;
        padding: 28px 20px 24px;
        text-align: center;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
        transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
        display: block;
        position: relative;
        overflow: hidden;
    }

    .cohort-select-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: linear-gradient(90deg, #6366f1, #818cf8);
        opacity: 0;
        transition: opacity 0.22s;
    }

    .cohort-select-card:hover {
        border-color: #6366f1;
        box-shadow: 0 8px 24px rgba(99,102,241,0.18);
        transform: translateY(-4px);
        color: inherit;
    }

    .cohort-select-card:hover::before { opacity: 1; }

    .cohort-year-badge {
        width: 68px; height: 68px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #818cf8);
        color: #fff; font-weight: 800; font-size: 1.25rem;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 14px;
        box-shadow: 0 4px 12px rgba(99,102,241,0.35);
        transition: transform 0.22s;
    }

    .cohort-select-card:hover .cohort-year-badge { transform: scale(1.08); }

    .cohort-year-text { font-size: 1.05rem; font-weight: 700; color: #1e293b; margin-bottom: 6px; }

    .cohort-count {
        font-size: .82rem; color: #64748b;
        background: #f1f5f9; border-radius: 20px;
        padding: 3px 12px; display: inline-block;
    }

    .cohort-arrow {
        position: absolute; bottom: 14px; right: 16px;
        font-size: 1.1rem; color: #cbd5e1;
        transition: color 0.2s, transform 0.2s;
    }
    .cohort-select-card:hover .cohort-arrow { color: #6366f1; transform: translateX(3px); }

    .empty-state { text-align: center; padding: 60px 20px; }
    .empty-state-icon {
        width: 80px; height: 80px; border-radius: 50%;
        background: #f1f5f9; color: #94a3b8; font-size: 2.2rem;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">

    {{-- ── Header ── --}}
    <div class="d-flex align-items-start justify-content-between mb-4 gap-3 flex-wrap">
        <div>
            <h4 class="fw-bold mb-1"><i class="bi bi-mortarboard me-2 text-success"></i>Data Mahasiswa</h4>
            <p class="text-muted mb-0 small">Pilih angkatan (cohort) untuk melihat daftar mahasiswa.</p>
        </div>
        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2 fs-6">
            {{ count($availableCohorts) }} Angkatan Terdaftar
        </span>
    </div>

    {{-- ── Info Banner ── --}}
    <div class="alert border-0 rounded-3 mb-4 d-flex align-items-center gap-3"
         style="background: linear-gradient(135deg, #ede9fe, #dbeafe); border-left: 4px solid #6366f1 !important;">
        <i class="bi bi-info-circle-fill text-primary fs-5"></i>
        <div class="small text-primary fw-semibold">
            Silakan pilih angkatan di bawah untuk menampilkan daftar mahasiswa beserta data lengkapnya.
        </div>
    </div>

    {{-- ── Cohort Grid ── --}}
    @if($availableCohorts->isEmpty())
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <div class="empty-state">
                    <div class="empty-state-icon"><i class="bi bi-people"></i></div>
                    <h5 class="fw-bold text-dark mb-2">Belum Ada Data Mahasiswa</h5>
                    <p class="text-muted small mb-0">Belum ada mahasiswa terdaftar dengan cohort/angkatan.</p>
                </div>
            </div>
        </div>
    @else
        <div class="cohort-grid">
            @foreach($availableCohorts as $cohort)
            <a href="{{ route($indexRoute, ['cohort' => $cohort]) }}"
               class="cohort-select-card" id="cohort-card-{{ $cohort }}">
                <div class="cohort-year-badge">{{ substr($cohort, -2) }}</div>
                <div class="cohort-year-text">Angkatan {{ $cohort }}</div>
                <span class="cohort-count">
                    <i class="bi bi-people me-1"></i>{{ $cohortStats[$cohort] ?? 0 }} Mahasiswa
                </span>
                <i class="bi bi-arrow-right cohort-arrow"></i>
            </a>
            @endforeach
        </div>
    @endif

</div>
@endsection
