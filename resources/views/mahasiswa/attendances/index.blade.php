@extends('layouts.mahasiswa')

@section('title', 'Riwayat Absensi')

@push('styles')
<style>
.attendance-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin-bottom: 20px;
}
@media (max-width: 768px) { .attendance-stats { grid-template-columns: repeat(2, 1fr); } }

.att-stat-card {
    background: var(--card-glass-bg);
    backdrop-filter: blur(30px) saturate(160%);
    border: 1px solid var(--card-glass-border);
    border-radius: var(--radius-lg);
    padding: 14px 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.07), inset 0 1px 0 rgba(255,255,255,0.5);
    animation: fadeInUp 0.4s cubic-bezier(0.22,1,0.36,1) both;
    transition: all 0.22s ease;
}
.att-stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }
.att-stat-icon { width: 40px; height: 40px; border-radius: 11px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
.att-stat-val { font-family: var(--font-display); font-size: 1.55rem; font-weight: 800; line-height: 1; }
.att-stat-lbl { font-family: var(--font-label); font-size: 0.6rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-3); margin-top: 2px; }

.att-stat-card:nth-child(1) { animation-delay: 0.05s; }
.att-stat-card:nth-child(2) { animation-delay: 0.10s; }
.att-stat-card:nth-child(3) { animation-delay: 0.15s; }
.att-stat-card:nth-child(4) { animation-delay: 0.20s; }
</style>
@endpush

@section('content')

@php
$total  = $attendances->count();
$hadir  = $attendances->where('status','hadir')->count();
$izin   = $attendances->where('status','izin')->count();
$sakit  = $attendances->where('status','sakit')->count();
$alpa   = $attendances->where('status','alpa')->count();
$pct    = $total > 0 ? round($hadir / $total * 100) : 0;
@endphp

<div class="attendance-stats">
    <div class="att-stat-card">
        <div class="att-stat-icon" style="background:var(--info-light);color:var(--secondary);"><i class="bi bi-calendar3"></i></div>
        <div>
            <div class="att-stat-val" style="color:var(--secondary);">{{ $total }}</div>
            <div class="att-stat-lbl">Total Pertemuan</div>
        </div>
    </div>
    <div class="att-stat-card">
        <div class="att-stat-icon" style="background:var(--success-light);color:var(--success);"><i class="bi bi-check2-circle"></i></div>
        <div>
            <div class="att-stat-val" style="color:var(--success);">{{ $hadir }}</div>
            <div class="att-stat-lbl">Hadir ({{ $pct }}%)</div>
        </div>
    </div>
    <div class="att-stat-card">
        <div class="att-stat-icon" style="background:var(--warning-light);color:var(--warning);"><i class="bi bi-bandaid"></i></div>
        <div>
            <div class="att-stat-val" style="color:var(--warning);">{{ $sakit + $izin }}</div>
            <div class="att-stat-lbl">Izin / Sakit</div>
        </div>
    </div>
    <div class="att-stat-card">
        <div class="att-stat-icon" style="background:var(--danger-light);color:var(--danger);"><i class="bi bi-x-circle"></i></div>
        <div>
            <div class="att-stat-val" style="color:var(--danger);">{{ $alpa }}</div>
            <div class="att-stat-lbl">Alpa</div>
        </div>
    </div>
</div>
<div class="mhs-card">
    <div class="mhs-card-header">
        <h6 class="mhs-card-title">
            <span class="mhs-card-icon" style="background:var(--info-light);color:var(--secondary);">
                <i class="bi bi-calendar-check"></i>
            </span>
            Riwayat Absensi Perkuliahan
        </h6>
        @if($total > 0)
        <span class="mhs-badge {{ $pct >= 75 ? 'success' : 'danger' }}">
            <i class="bi bi-{{ $pct >= 75 ? 'check-circle' : 'exclamation-triangle' }} me-1"></i>
            Kehadiran {{ $pct }}%
        </span>
        @endif
    </div>
    <div style="overflow-x:auto;">
        @if($attendances->isNotEmpty())
        <table class="mhs-table">
            <thead>
                <tr>
                    <th style="padding-left:18px;">Tanggal</th>
                    <th>Mata Kuliah</th>
                    <th>Dosen Pengampu</th>
                    <th style="text-align:center;">Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendances as $att)
                <tr style="animation:fadeInUp 0.3s ease {{ $loop->index * 0.02 }}s both;">
                    <td style="padding-left:18px;font-weight:600;font-size:0.83rem;">{{ \Carbon\Carbon::parse($att->date)->format('d M Y') }}</td>
                    <td style="font-weight:600;">{{ $att->subject->name ?? '-' }}</td>
                    <td style="color:var(--text-2);font-size:0.82rem;"><i class="bi bi-person me-1"></i>{{ $att->lecturer->name ?? '-' }}</td>
                    <td style="text-align:center;">
                        @if($att->status === 'hadir')
                            <span class="mhs-badge success">Hadir</span>
                        @elseif($att->status === 'izin')
                            <span class="mhs-badge cyan">Izin</span>
                        @elseif($att->status === 'sakit')
                            <span class="mhs-badge warning">Sakit</span>
                        @else
                            <span class="mhs-badge danger">Alpa</span>
                        @endif
                    </td>
                    <td style="font-size:0.77rem;color:var(--text-2);">{{ $att->notes ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="mhs-empty" style="padding:48px 20px;">
            <i class="bi bi-calendar-x"></i>
            <p>Belum ada riwayat absensi tercatat.</p>
        </div>
        @endif
    </div>
</div>
@endsection
