@extends('layouts.mahasiswa')
@section('title', 'Dashboard')

@push('styles')
<style>
/* ================================================================
   DASHBOARD LAYOUT
================================================================ */
.dash-layout {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 20px;
    align-items: start;
}
@media (max-width: 1100px) { .dash-layout { grid-template-columns: 1fr; } }

/* ── HERO STRIP ─────────────────────────────────────────────── */
.hero-strip {
    background: var(--primary-container);
    border-radius: var(--radius-xl);
    padding: 24px 28px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 18px;
    position: relative;
    overflow: hidden;
}

.hero-strip::after {
    content: '';
    position: absolute;
    right: -40px; top: -60px;
    width: 200px; height: 200px;
    border-radius: 50%;
    background: rgba(255,255,255,0.03);
}

.hero-avatar {
    width: 52px; height: 52px; flex-shrink: 0;
    border-radius: var(--radius-md);
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.15);
    display: flex; align-items: center; justify-content: center;
    font-family: var(--font-display);
    font-size: 1.4rem; font-weight: 800; color: #fff;
    overflow: hidden;
}
.hero-avatar img { width: 100%; height: 100%; object-fit: cover; }

.hero-text { flex: 1; position: relative; z-index: 1; }
.hero-greeting {
    font-family: var(--font-label);
    font-size: 0.6rem; text-transform: uppercase;
    letter-spacing: 0.14em; color: rgba(255,255,255,0.45);
    margin-bottom: 4px;
}
.hero-name {
    font-family: var(--font-display);
    font-size: 1.1rem; font-weight: 800;
    color: #fff; margin-bottom: 3px;
}
.hero-sub { font-size: 0.8rem; color: rgba(255,255,255,0.5); }

.hero-meta {
    position: relative; z-index: 1;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: var(--radius-md);
    padding: 10px 16px;
    text-align: right; flex-shrink: 0;
}
.hero-meta .date-lbl {
    font-family: var(--font-label);
    font-size: 0.58rem; color: rgba(255,255,255,0.4);
    text-transform: uppercase; letter-spacing: 0.1em; display: block; margin-bottom: 3px;
}
.hero-meta .date-val {
    font-family: var(--font-display);
    font-size: 0.78rem; font-weight: 700; color: rgba(255,255,255,0.85);
}

/* ── QUICK NAV ──────────────────────────────────────────────── */
.quick-nav {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 10px;
    margin-bottom: 20px;
}
@media (max-width: 768px) { .quick-nav { grid-template-columns: repeat(3, 1fr); } }

.quick-nav-item {
    display: flex; flex-direction: column; align-items: center;
    gap: 7px; padding: 14px 8px;
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: var(--radius-lg);
    text-decoration: none; color: var(--text-2);
    font-size: 0.72rem; font-weight: 600;
    text-align: center;
    transition: all 0.2s cubic-bezier(0.4,0,0.2,1);
}

.quick-nav-item:hover {
    border-color: rgba(0,89,187,0.2);
    color: var(--secondary);
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,89,187,0.08);
    background: rgba(255,255,255,0.9);
}

.quick-nav-icon {
    width: 38px; height: 38px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
}

/* ── SECTION HEADER (reusable) ──────────────────────────────── */
.sec-header {
    display: flex; align-items: center;
    justify-content: space-between;
    padding: 14px 18px;
    border-bottom: 1px solid var(--outline-variant);
    background: var(--surface-container-low);
}
.sec-title {
    display: flex; align-items: center; gap: 9px;
    font-family: var(--font-display);
    font-size: 0.83rem; font-weight: 700;
    color: var(--primary-container); margin: 0;
}
.sec-icon {
    width: 26px; height: 26px;
    border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.8rem; flex-shrink: 0;
}

/* ── JADWAL HARI INI — timeline style ───────────────────────── */
.schedule-timeline { padding: 16px 18px; }

.schedule-slot {
    display: flex; gap: 14px;
    padding: 12px 0;
    border-bottom: 1px solid var(--surface-container-high);
}
.schedule-slot:last-child { border-bottom: none; padding-bottom: 0; }

.slot-time {
    flex-shrink: 0; width: 54px;
    font-family: var(--font-label);
    font-size: 0.68rem; font-weight: 600;
    color: var(--secondary); text-align: center;
    line-height: 1.3;
}
.slot-time .time-end { color: var(--outline); }

.slot-dot {
    flex-shrink: 0; width: 8px;
    display: flex; flex-direction: column; align-items: center; gap: 0;
    padding-top: 4px;
}
.slot-dot-circle {
    width: 8px; height: 8px; border-radius: 50%;
    background: var(--secondary); flex-shrink: 0;
}
.slot-dot-line {
    width: 1px; flex: 1; background: var(--outline-variant);
    margin-top: 3px;
}

.slot-body { flex: 1; min-width: 0; }
.slot-subject {
    font-weight: 700; font-size: 0.88rem;
    color: var(--on-surface); margin-bottom: 2px;
}
.slot-subject.cancelled { text-decoration: line-through; color: var(--danger); }
.slot-lecturer { font-size: 0.76rem; color: var(--text-2); margin-bottom: 6px; }
.slot-meta {
    display: flex; gap: 12px;
    font-family: var(--font-label); font-size: 0.62rem;
    color: var(--outline);
}
.slot-chip {
    display: inline-flex; align-items: center; gap: 3px;
    padding: 2px 8px; border-radius: 20px;
    font-family: var(--font-label); font-size: 0.6rem;
    font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;
    margin-top: 5px;
}
.slot-chip.cancelled { background: var(--danger-light); color: var(--danger); }
.slot-chip.changed   { background: var(--warning-light); color: var(--warning); }

/* ── WEEKLY TABLE ───────────────────────────────────────────── */
.week-today { background: rgba(0,89,187,0.04) !important; }

/* ── FITNESS TABS ───────────────────────────────────────────── */
.tab-row { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 14px; }
.tab-pill {
    padding: 4px 13px; border-radius: 20px;
    border: 1px solid var(--outline-variant);
    background: transparent; color: var(--text-2);
    font-family: var(--font-label); font-size: 0.68rem; font-weight: 600;
    cursor: pointer; transition: all 0.15s; letter-spacing: 0.04em;
}
.tab-pill.active, .tab-pill:hover {
    background: var(--secondary); border-color: var(--secondary); color: #fff;
}

/* ── FITNESS ENTRY ──────────────────────────────────────────── */
.fit-entry {
    background: var(--surface-container-low);
    border: 1px solid var(--outline-variant);
    border-radius: var(--radius-md);
    padding: 14px; margin-bottom: 10px;
}
.fit-entry:last-child { margin-bottom: 0; }

.fit-score-row {
    display: flex; align-items: center;
    justify-content: space-between; margin-bottom: 10px;
}
.fit-score-big {
    font-family: var(--font-display);
    font-size: 2.2rem; font-weight: 800;
    color: var(--danger); line-height: 1;
}
.fit-grid {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 6px; margin-top: 10px;
}
.fit-metric {
    background: #fff; border: 1px solid var(--outline-variant);
    border-radius: 6px; padding: 7px 9px;
}
.fit-metric-lbl { font-family: var(--font-label); font-size: 0.6rem; color: var(--outline); display: block; }
.fit-metric-val { font-weight: 700; font-size: 0.82rem; color: var(--on-surface); }
.fit-metric-score { font-weight: 800; font-size: 0.78rem; }
.fit-metric-score.ok   { color: var(--success); }
.fit-metric-score.fail { color: var(--danger); }

/* ── ACHIEVEMENT ITEM ───────────────────────────────────────── */
.ach-item {
    display: flex; align-items: flex-start; gap: 12px;
    padding: 11px 0; border-bottom: 1px solid var(--surface-container-high);
    text-decoration: none; color: inherit;
    transition: opacity 0.15s; cursor: pointer;
}
.ach-item:last-child { border-bottom: none; padding-bottom: 0; }
.ach-item:hover { opacity: 0.75; }
.ach-icon {
    width: 34px; height: 34px; flex-shrink: 0;
    background: rgba(255,200,0,0.08);
    border: 1px solid rgba(255,200,0,0.18);
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
}
.ach-item h6 { font-size: 0.83rem; font-weight: 700; margin: 0 0 2px; color: var(--on-surface); }
.ach-item p  { font-size: 0.74rem; color: var(--text-2); margin: 0 0 5px; line-height: 1.45; }

/* ── EXAM ITEM ──────────────────────────────────────────────── */
.exam-item {
    display: flex; gap: 13px; align-items: center;
    padding: 11px 0; border-bottom: 1px solid var(--surface-container-high);
}
.exam-item:last-child { border-bottom: none; }
.exam-date-box {
    width: 42px; flex-shrink: 0; text-align: center;
    background: rgba(0,89,187,0.07);
    border: 1px solid rgba(0,89,187,0.14);
    border-radius: var(--radius-md); padding: 6px 4px;
}
.exam-date-box .eday { font-size: 1.15rem; font-weight: 800; color: var(--secondary); line-height: 1; }
.exam-date-box .emon { font-size: 0.58rem; font-weight: 700; color: var(--secondary); opacity: 0.7; text-transform: uppercase; }
.exam-body h6 { font-size: 0.84rem; font-weight: 700; margin: 0 0 3px; }
.exam-meta { font-size: 0.72rem; color: var(--text-3); display: flex; gap: 10px; }

/* ── ANNOUNCEMENT ITEM ──────────────────────────────────────── */
.ann-item {
    display: block; text-decoration: none; color: inherit;
    padding: 11px 0; border-bottom: 1px solid var(--surface-container-high);
    transition: opacity 0.15s;
}
.ann-item:last-child { border-bottom: none; }
.ann-item:hover { opacity: 0.75; }
.ann-item h6 { font-size: 0.83rem; font-weight: 700; margin: 0 0 3px; }
.ann-item p  { font-size: 0.74rem; color: var(--text-2); margin: 0 0 4px; line-height: 1.5; }
.ann-time { font-family: var(--font-label); font-size: 0.62rem; color: var(--outline); }

/* ── VIOLATION ALERT ────────────────────────────────────────── */
.violation-alert {
    background: var(--danger-light);
    border: 1px solid rgba(186,26,26,0.18);
    border-radius: var(--radius-lg);
    overflow: hidden; margin-bottom: 14px;
}
.violation-alert-head {
    padding: 10px 16px;
    background: rgba(186,26,26,0.08);
    border-bottom: 1px solid rgba(186,26,26,0.12);
    display: flex; align-items: center; gap: 7px;
    font-size: 0.83rem; font-weight: 700; color: var(--danger);
}
.violation-body { padding: 12px 16px; }
.violation-item {
    padding: 10px 12px; margin-bottom: 8px;
    background: rgba(186,26,26,0.05);
    border: 1px solid rgba(186,26,26,0.12);
    border-radius: var(--radius-sm);
}
.violation-item:last-child { margin-bottom: 0; }
.v-title { font-size: 0.83rem; font-weight: 700; color: var(--danger); margin-bottom: 3px; }
.v-desc  { font-size: 0.77rem; color: var(--on-surface); margin-bottom: 4px; }
.v-meta  { font-family: var(--font-label); font-size: 0.62rem; color: var(--outline); }

/* ── IPK RING ───────────────────────────────────────────────── */
.ipk-wrap { text-align: center; padding: 6px 0 10px; }
.ipk-ring-svg { transform: rotate(-90deg); }
.ipk-ring-bg { fill: none; stroke: var(--surface-container-high); stroke-width: 7; }
.ipk-ring-fg { fill: none; stroke: var(--secondary); stroke-width: 7; stroke-linecap: round;
    transition: stroke-dashoffset 1.5s cubic-bezier(0.4,0,0.2,1); }
.ipk-center { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; }
.ipk-val { font-family: var(--font-display); font-size: 1.35rem; font-weight: 800; color: var(--on-surface); line-height: 1; }
.ipk-lbl { font-family: var(--font-label); font-size: 0.58rem; color: var(--outline); text-transform: uppercase; letter-spacing: 0.1em; margin-top: 3px; }
.ipk-verdict { font-size: 0.78rem; color: var(--text-2); margin-top: 8px; font-weight: 500; }

/* ── BIMBINGAN TABLE ─────────────────────────────────────────── */
.mtg-empty { padding: 20px; text-align: center; }
.mtg-empty i { font-size: 1.5rem; display: block; margin-bottom: 8px; color: var(--outline); }
.mtg-empty p { font-size: 0.83rem; color: var(--outline); margin: 0; }

/* ── KOTAK SARAN ────────────────────────────────────────────── */
.saran-body { padding: 18px; }
</style>
@endpush

@section('content')

{{-- ============================================================ --}}
{{-- HERO                                                          --}}
{{-- ============================================================ --}}
<div class="hero-strip">
    <div class="hero-avatar">
        @if(auth()->user()->profile_photo)
            <img src="{{ asset('storage/profiles/' . auth()->user()->profile_photo) }}" alt="Avatar">
        @else
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        @endif
    </div>
    <div class="hero-text">
        <div class="hero-greeting">Portal Akademik Mahasiswa</div>
        <div class="hero-name">{{ auth()->user()->name }}</div>
        <div class="hero-sub">Selamat datang — pantau jadwal, nilai, dan aktivitas akademik Anda</div>
    </div>
    <div class="hero-meta d-none d-md-block">
        <span class="date-lbl">Hari ini</span>
        <span class="date-val">{{ \Carbon\Carbon::now()->isoFormat('ddd, D MMM Y') }}</span>
    </div>
</div>

{{-- ============================================================ --}}
{{-- QUICK NAVIGATION                                              --}}
{{-- ============================================================ --}}
<div class="quick-nav">
    <a href="{{ route('mahasiswa.attendances.index') }}" class="quick-nav-item">
        <div class="quick-nav-icon" style="background:rgba(0,89,187,0.08);color:var(--secondary);">
            <i class="bi bi-calendar-check"></i>
        </div>
        Absensi
    </a>
    <a href="{{ route('mahasiswa.nilai.index') }}" class="quick-nav-item">
        <div class="quick-nav-icon" style="background:rgba(0,104,118,0.08);color:var(--cyan);">
            <i class="bi bi-bar-chart-line"></i>
        </div>
        Nilai
    </a>
    <a href="{{ route('mahasiswa.materials.index') }}" class="quick-nav-item">
        <div class="quick-nav-icon" style="background:rgba(0,165,80,0.08);color:var(--success);">
            <i class="bi bi-journal-text"></i>
        </div>
        Bahan Ajar
    </a>
    <a href="{{ route('mahasiswa.chats.index') }}" class="quick-nav-item">
        <div class="quick-nav-icon" style="background:rgba(103,80,164,0.08);color:var(--purple);">
            <i class="bi bi-chat-dots"></i>
        </div>
        Chat
    </a>
    <a href="{{ route('mahasiswa.submissions.index') }}" class="quick-nav-item">
        <div class="quick-nav-icon" style="background:rgba(138,95,0,0.08);color:var(--warning);">
            <i class="bi bi-envelope-paper"></i>
        </div>
        Surat
    </a>
</div>

{{-- ============================================================ --}}
{{-- MAIN GRID                                                     --}}
{{-- ============================================================ --}}
@php
$todayData = collect($weeklySchedules)->first(fn($d) => $d['date']->isToday());
@endphp

<div class="dash-layout">

    {{-- ══════════ KOLOM KIRI ══════════ --}}
    <div>

        {{-- 1. JADWAL HARI INI --}}
        <div class="mhs-card" style="margin-bottom:18px;">
            <div class="sec-header">
                <h6 class="sec-title">
                    <span class="sec-icon" style="background:rgba(0,89,187,0.08);color:var(--secondary);">
                        <i class="bi bi-calendar3"></i>
                    </span>
                    Jadwal Hari Ini
                    <span class="mhs-badge primary" style="font-size:0.58rem;">{{ \Carbon\Carbon::now()->format('d M') }}</span>
                </h6>
            </div>

            @if($todayData && $todayData['schedules']->isNotEmpty())
            <div class="schedule-timeline">
                @foreach($todayData['schedules'] as $schedule)
                @php
                    $cancelled = $schedule->is_overridden && $schedule->override_status === 'cancelled';
                    $changed   = $schedule->is_overridden && $schedule->override_status !== 'cancelled';
                @endphp
                <div class="schedule-slot">
                    <div class="slot-time">
                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                        <div class="time-end">{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</div>
                    </div>
                    <div class="slot-dot">
                        <div class="slot-dot-circle" style="{{ $cancelled ? 'background:var(--danger)' : ($changed ? 'background:var(--warning)' : '') }}"></div>
                        @if(!$loop->last)<div class="slot-dot-line"></div>@endif
                    </div>
                    <div class="slot-body">
                        <div class="slot-subject {{ $cancelled ? 'cancelled' : '' }}">{{ $schedule->subject->name }}</div>
                        <div class="slot-lecturer"><i class="bi bi-person me-1"></i>{{ $schedule->dosen->name }}</div>
                        <div class="slot-meta">
                            <span><i class="bi bi-geo-alt me-1"></i>{{ $schedule->room }}</span>
                        </div>
                        @if($schedule->is_overridden)
                        <span class="slot-chip {{ $cancelled ? 'cancelled' : 'changed' }}">
                            <i class="bi bi-{{ $cancelled ? 'x-circle' : 'exclamation-triangle' }}-fill"></i>
                            {{ $cancelled ? 'Dibatalkan' : 'Jadwal Berubah' }}
                        </span>
                        @if($schedule->override_note)
                        <div style="font-size:0.72rem;color:var(--text-2);font-style:italic;margin-top:4px;">"{{ $schedule->override_note }}"</div>
                        @endif
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="mhs-empty" style="padding:24px 0;">
                <i class="bi bi-calendar-x"></i>
                <p>Tidak ada kelas hari ini.</p>
            </div>
            @endif
        </div>

        {{-- 2. JADWAL MINGGUAN --}}
        <div class="mhs-card" style="margin-bottom:18px;">
            <div class="sec-header">
                <h6 class="sec-title">
                    <span class="sec-icon" style="background:rgba(0,89,187,0.08);color:var(--secondary);">
                        <i class="bi bi-calendar-week"></i>
                    </span>
                    Jadwal Mingguan
                </h6>
                <span class="mhs-badge muted">Minggu Ini</span>
            </div>
            <div style="overflow-x:auto;">
                <table class="mhs-table">
                    <thead>
                        <tr>
                            <th>Hari</th>
                            <th>Mata Kuliah</th>
                            <th>Waktu</th>
                            <th>Ruang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $hasClasses = false; @endphp
                        @foreach($weeklySchedules as $dayData)
                        @if($dayData['schedules']->isNotEmpty())
                        @php $hasClasses = true; $isToday = $dayData['date']->isToday(); @endphp
                        @foreach($dayData['schedules'] as $idx => $schedule)
                        @php
                            $sc = $schedule->is_overridden && $schedule->override_status === 'cancelled';
                            $sw = $schedule->is_overridden && $schedule->override_status !== 'cancelled';
                        @endphp
                        <tr class="{{ $isToday ? 'week-today' : '' }}">
                            @if($idx === 0)
                            <td rowspan="{{ count($dayData['schedules']) }}" style="vertical-align:top;padding-top:14px;">
                                <span style="font-weight:700;font-size:0.78rem;color:{{ $isToday ? 'var(--secondary)' : 'var(--text-2)' }};">{{ $dayData['day_name'] }}</span>
                                @if($isToday)<br><span class="mhs-badge primary" style="margin-top:4px;font-size:0.52rem;">Hari ini</span>@endif
                            </td>
                            @endif
                            <td>
                                <span style="font-weight:600;font-size:0.84rem;display:block;margin-bottom:2px;{{ $sc ? 'text-decoration:line-through;color:var(--danger);' : '' }}">{{ $schedule->subject->name }}</span>
                                <span style="font-size:0.72rem;color:var(--text-3);"><i class="bi bi-person me-1"></i>{{ $schedule->dosen->name }}</span>
                                @if($sc)<span class="mhs-badge danger" style="margin-top:4px;">Batal</span>
                                @elseif($sw)<span class="mhs-badge warning" style="margin-top:4px;">Berubah</span>
                                @endif
                            </td>
                            <td style="font-size:0.78rem;color:var(--text-2);white-space:nowrap;{{ $sc ? 'text-decoration:line-through;color:var(--danger);' : '' }}">
                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}–{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                            </td>
                            <td style="font-size:0.78rem;color:var(--text-2);">{{ $schedule->room }}</td>
                        </tr>
                        @endforeach
                        @endif
                        @endforeach
                        @if(!$hasClasses)
                        <tr><td colspan="4" class="mhs-empty" style="padding:20px;">Belum ada jadwal minggu ini.</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        {{-- 3. KESEMAPTAAN + PRESTASI (side by side) --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;margin-bottom:18px;">

            {{-- Kesemaptaan --}}
            <div class="mhs-card">
                <div class="sec-header">
                    <h6 class="sec-title">
                        <span class="sec-icon" style="background:var(--danger-light);color:var(--danger);">
                            <i class="bi bi-heart-pulse"></i>
                        </span>
                        Kesemaptaan
                    </h6>
                </div>
                <div class="mhs-card-body">
                    @if($fitnessTests->isNotEmpty())
                    @php $grouped = $fitnessTests->groupBy('semester'); @endphp
                    <div class="tab-row" id="ft-tabs">
                        @foreach($grouped as $sem => $tests)
                        <button class="tab-pill {{ $loop->first ? 'active' : '' }}"
                            onclick="switchTab('ft','{{ $sem ?? 'lama' }}',this)" type="button">
                            {{ $sem ? 'Smt '.$sem : 'Lama' }}
                        </button>
                        @endforeach
                    </div>
                    @foreach($grouped as $sem => $tests)
                    <div id="ft-pane-{{ $sem ?? 'lama' }}" class="ft-pane" style="{{ $loop->first ? '' : 'display:none;' }}">
                        @foreach($tests as $ft)
                        <div class="fit-entry">
                            <div class="fit-score-row">
                                <div>
                                    <div class="fit-score-big">{{ $ft->total_score ?? $ft->score }}</div>
                                    <div style="font-size:0.7rem;color:var(--outline);">Total Nilai</div>
                                </div>
                                <div style="text-align:right;">
                                    <span class="mhs-badge {{ str_contains($ft->status,'lulus') || $ft->status === 'passed' ? 'success' : 'danger' }}">
                                        {{ strtoupper(str_replace('_',' ',$ft->status)) }}
                                    </span>
                                    <div style="font-size:0.65rem;color:var(--outline);margin-top:4px;">
                                        <i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($ft->test_date)->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                            @if($ft->total_score !== null)
                            <div class="fit-grid">
                                @foreach([
                                    ['Lari',     $ft->raw_lari.'m',                                $ft->nilai_lari],
                                    [($ft->nilai_pull_up!==null?'Pull Up':'Chinning'), $ft->raw_pull_up??$ft->raw_chinning??'-', $ft->nilai_pull_up??$ft->nilai_chinning??0],
                                    ['Sit Up',   $ft->raw_sit_up??'-',                             $ft->nilai_sit_up??0],
                                    ['Push Up',  $ft->raw_push_up??'-',                            $ft->nilai_push_up??0],
                                    ['Shuttle',  ($ft->raw_shuttle_run??'-').'s',                  $ft->nilai_shuttle_run??0],
                                    ['Renang',   ($ft->raw_renang??'-').'s',                       $ft->nilai_renang??0],
                                ] as [$lbl,$raw,$score])
                                <div class="fit-metric">
                                    <span class="fit-metric-lbl">{{ $lbl }}</span>
                                    <span class="fit-metric-val">{{ $raw }}</span>
                                    <span class="fit-metric-score {{ $score >= 60 ? 'ok' : 'fail' }}"> → {{ $score }}</span>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div style="display:flex;gap:6px;flex-wrap:wrap;">
                                <span class="mhs-badge muted">A: {{ $ft->score_a ?? '-' }}</span>
                                <span class="mhs-badge muted">B: {{ $ft->score_b ?? '-' }}</span>
                                <span class="mhs-badge muted">C: {{ $ft->score_c ?? '-' }}</span>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                    @else
                    <div class="mhs-empty" style="padding:20px 0;">
                        <i class="bi bi-clipboard2-x"></i>
                        <p>Belum ada data uji fisik.</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Prestasi --}}
            <div class="mhs-card">
                <div class="sec-header">
                    <h6 class="sec-title">
                        <span class="sec-icon" style="background:rgba(255,200,0,0.1);color:#b8860b;">
                            <i class="bi bi-trophy"></i>
                        </span>
                        Prestasi
                    </h6>
                </div>
                <div class="mhs-card-body">
                    @if($achievements->isNotEmpty())
                    @foreach($achievements as $ach)
                    <a href="javascript:void(0)" class="ach-item" onclick="showAchievement({{ $ach->id }})">
                        <div class="ach-icon">🏅</div>
                        <div style="flex:1;min-width:0;">
                            <h6>{{ $ach->title }}</h6>
                            <p>{{ \Illuminate\Support\Str::limit($ach->description, 55) }}</p>
                            <div style="display:flex;flex-wrap:wrap;gap:4px;">
                                @if($ach->level)<span class="mhs-badge purple"><i class="bi bi-bar-chart-steps me-1"></i>{{ $ach->level }}</span>@endif
                                <span class="mhs-badge muted"><i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($ach->date)->format('d M Y') }}</span>
                                @if($ach->attachment)<span class="mhs-badge success"><i class="bi bi-paperclip me-1"></i>Lampiran</span>@endif
                            </div>
                        </div>
                        <i class="bi bi-chevron-right" style="color:var(--outline);font-size:0.7rem;flex-shrink:0;"></i>
                    </a>
                    @endforeach
                    @else
                    <div class="mhs-empty" style="padding:20px 0;">
                        <i class="bi bi-award"></i>
                        <p>Belum ada catatan prestasi.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- 4. BIMBINGAN / WALI DOSEN --}}
        <div class="mhs-card">
            <div class="sec-header">
                <h6 class="sec-title">
                    <span class="sec-icon" style="background:var(--success-light);color:var(--success);">
                        <i class="bi bi-people"></i>
                    </span>
                    Bimbingan / Wali Dosen
                </h6>
                <button class="mhs-btn mhs-btn-success mhs-btn-sm"
                    data-bs-toggle="modal" data-bs-target="#modalRequestMeeting">
                    <i class="bi bi-plus-lg"></i> Ajukan
                </button>
            </div>
            @if($meetings->isNotEmpty())
            <div style="overflow-x:auto;">
                <table class="mhs-table">
                    <thead>
                        <tr>
                            <th style="padding-left:18px;">Tanggal</th>
                            <th>Dosen</th>
                            <th>Topik</th>
                            <th style="text-align:center;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($meetings as $mtg)
                        <tr>
                            <td style="padding-left:18px;font-size:0.78rem;">{{ \Carbon\Carbon::parse($mtg->requested_date)->format('d M Y') }}</td>
                            <td style="font-size:0.84rem;font-weight:600;">{{ $mtg->dosen->name }}</td>
                            <td style="font-size:0.78rem;color:var(--text-2);">{{ $mtg->topic }}</td>
                            <td style="text-align:center;">
                                @if($mtg->status === 'approved')
                                    <span class="mhs-badge success">Disetujui</span>
                                @elseif($mtg->status === 'rejected')
                                    <span class="mhs-badge danger">Ditolak</span>
                                @else
                                    <span class="mhs-badge muted">Menunggu</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="mtg-empty">
                <i class="bi bi-calendar-plus"></i>
                <p>Belum ada pengajuan bimbingan.</p>
            </div>
            @endif
        </div>

    </div>{{-- END KOLOM KIRI --}}

    {{-- ══════════ KOLOM KANAN ══════════ --}}
    <div>

        {{-- IPK RING --}}
        @php
            $ipkVal = null;
            try {
                $avg = \App\Models\Grade::where('user_id', auth()->id())
                    ->whereNotNull('grade_point')->avg('grade_point');
                if ($avg !== null) $ipkVal = round($avg, 2);
            } catch(\Exception $e) { $ipkVal = null; }
        @endphp

        @if($ipkVal !== null)
        <div class="mhs-card" style="margin-bottom:16px;">
            <div class="sec-header">
                <h6 class="sec-title">
                    <span class="sec-icon" style="background:rgba(0,89,187,0.08);color:var(--secondary);">
                        <i class="bi bi-mortarboard"></i>
                    </span>
                    Indeks Prestasi
                </h6>
            </div>
            <div class="mhs-card-body ipk-wrap">
                <div style="position:relative;width:110px;height:110px;margin:0 auto 8px;">
                    <svg class="ipk-ring-svg" width="110" height="110" viewBox="0 0 110 110">
                        <circle class="ipk-ring-bg" cx="55" cy="55" r="46"/>
                        <circle class="ipk-ring-fg" cx="55" cy="55" r="46"
                            stroke-dasharray="{{ 2 * 3.14159 * 46 }}"
                            stroke-dashoffset="{{ 2 * 3.14159 * 46 * (1 - min($ipkVal/4, 1)) }}"/>
                    </svg>
                    <div class="ipk-center">
                        <span class="ipk-val">{{ number_format($ipkVal, 2) }}</span>
                        <span class="ipk-lbl">IPK</span>
                    </div>
                </div>
                <div class="ipk-verdict">
                    @if($ipkVal >= 3.5) Dengan Pujian
                    @elseif($ipkVal >= 3.0) Sangat Memuaskan
                    @elseif($ipkVal >= 2.75) Memuaskan
                    @else Perlu Ditingkatkan
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- PELANGGARAN --}}
        @if($violations->isNotEmpty())
        <div class="violation-alert">
            <div class="violation-alert-head">
                <i class="bi bi-exclamation-octagon-fill"></i>
                Peringatan Pelanggaran
            </div>
            <div class="violation-body">
                @foreach($violations as $v)
                <div class="violation-item">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:3px;">
                        <div class="v-title">{{ $v->title }}</div>
                        <span style="font-weight:800;font-size:0.88rem;color:var(--danger);">{{ $v->point }} Poin</span>
                    </div>
                    <div class="v-desc">{{ $v->description }}</div>
                    <div class="v-meta"><i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($v->date)->format('d M Y') }}</div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- UJIAN MENDATANG --}}
        <div class="mhs-card" style="margin-bottom:16px;">
            <div class="sec-header">
                <h6 class="sec-title">
                    <span class="sec-icon" style="background:rgba(0,89,187,0.08);color:var(--secondary);">
                        <i class="bi bi-journal-check"></i>
                    </span>
                    Ujian Mendatang
                </h6>
            </div>
            <div class="mhs-card-body" style="padding:12px 18px;">
                @if($exams->isNotEmpty())
                @foreach($exams as $exam)
                <div class="exam-item">
                    <div class="exam-date-box">
                        <div class="eday">{{ \Carbon\Carbon::parse($exam->date)->format('d') }}</div>
                        <div class="emon">{{ \Carbon\Carbon::parse($exam->date)->format('M') }}</div>
                    </div>
                    <div class="exam-body">
                        <span class="mhs-badge cyan" style="margin-bottom:3px;">{{ strtoupper($exam->type) }}</span>
                        <h6>{{ $exam->subject->name }}</h6>
                        <div class="exam-meta">
                            <span><i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($exam->start_time)->format('H:i') }}</span>
                            <span><i class="bi bi-geo-alt me-1"></i>{{ $exam->room }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="mhs-empty" style="padding:14px 0;">
                    <i class="bi bi-calendar-x"></i>
                    <p>Belum ada jadwal ujian.</p>
                </div>
                @endif
            </div>
        </div>

        {{-- PENGUMUMAN --}}
        <div class="mhs-card" style="margin-bottom:16px;">
            <div class="sec-header">
                <h6 class="sec-title">
                    <span class="sec-icon" style="background:var(--success-light);color:var(--success);">
                        <i class="bi bi-megaphone"></i>
                    </span>
                    Pengumuman Prodi
                </h6>
            </div>
            <div class="mhs-card-body" style="padding:12px 18px;">
                @if(isset($announcements) && $announcements->isNotEmpty())
                @foreach($announcements as $ann)
                <a href="javascript:void(0)" class="ann-item"
                   onclick="showAnnouncement('{{ addslashes($ann->title) }}','{{ addslashes($ann->message) }}','{{ $ann->created_at->format('d M Y, H:i') }}')">
                    <h6>{{ $ann->title }}</h6>
                    <p>{{ \Illuminate\Support\Str::limit($ann->message, 70) }}</p>
                    <span class="ann-time"><i class="bi bi-clock me-1"></i>{{ $ann->created_at->diffForHumans() }}</span>
                </a>
                @endforeach
                @else
                <div class="mhs-empty" style="padding:14px 0;">
                    <i class="bi bi-bell-slash"></i>
                    <p>Belum ada pengumuman.</p>
                </div>
                @endif
            </div>
        </div>

        {{-- KOTAK SARAN --}}
        <div class="mhs-card">
            <div class="sec-header">
                <h6 class="sec-title">
                    <span class="sec-icon" style="background:rgba(0,89,187,0.08);color:var(--secondary);">
                        <i class="bi bi-chat-square-text"></i>
                    </span>
                    Kotak Saran Akademik
                </h6>
            </div>
            <div class="saran-body">
                <form action="{{ route('mahasiswa.dashboard.suggestion.store') }}" method="POST">
                    @csrf
                    <div class="mhs-form-group">
                        <label class="mhs-label">Kategori <span style="color:var(--danger);">*</span></label>
                        <select name="category" class="mhs-input" required>
                            <option value="">Pilih kategori...</option>
                            <option value="fasilitas">Fasilitas Kampus</option>
                            <option value="akademik">Layanan Akademik</option>
                            <option value="dosen">Kinerja Dosen</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="mhs-form-group">
                        <label class="mhs-label">Isi Saran <span style="color:var(--danger);">*</span></label>
                        <textarea name="content" class="mhs-input" rows="3"
                            placeholder="Tulis kritik & saran membangun di sini..." required></textarea>
                    </div>
                    <button type="submit" class="mhs-btn mhs-btn-primary mhs-btn-full">
                        <i class="bi bi-send"></i> Kirim Saran
                    </button>
                </form>
            </div>
        </div>

    </div>{{-- END KOLOM KANAN --}}
</div>

{{-- ============================================================ --}}
{{-- MODALS                                                        --}}
{{-- ============================================================ --}}

{{-- Modal Bimbingan --}}
<div class="modal fade mhs-modal" id="modalRequestMeeting" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('mahasiswa.dashboard.meeting.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-calendar-plus me-2" style="color:var(--success);"></i>Ajukan Jadwal Bimbingan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mhs-form-group">
                        <label class="mhs-label">Pilih Dosen / Wali Dosen <span style="color:var(--danger);">*</span></label>
                        <select name="dosen_id" class="mhs-input" required>
                            <option value="">Pilih Dosen...</option>
                            @foreach($dosens as $dsn)
                            <option value="{{ $dsn->id }}">{{ $dsn->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mhs-form-group">
                        <label class="mhs-label">Tanggal Pengajuan <span style="color:var(--danger);">*</span></label>
                        <input type="date" name="requested_date" class="mhs-input"
                            min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" required>
                        <div class="mhs-hint">Tanggal aktual dapat diubah oleh dosen saat persetujuan.</div>
                    </div>
                    <div class="mhs-form-group">
                        <label class="mhs-label">Topik Bimbingan <span style="color:var(--danger);">*</span></label>
                        <input type="text" name="topic" class="mhs-input"
                            placeholder="Contoh: Konsultasi KRS / Tugas Akhir" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="mhs-btn mhs-btn-ghost" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="mhs-btn mhs-btn-success">
                        <i class="bi bi-send"></i> Ajukan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Pengumuman --}}
<div class="modal fade mhs-modal" id="announcementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="announcementModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mhs-hint" style="margin-bottom:12px;" id="announcementModalDate"></p>
                <div style="background:var(--surface-container-low);border:1px solid var(--outline-variant);border-radius:var(--radius-md);padding:16px;white-space:pre-wrap;line-height:1.7;font-size:0.88rem;" id="announcementModalBody"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="mhs-btn mhs-btn-ghost" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Prestasi --}}
<div class="modal fade mhs-modal" id="achievementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="achModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div style="display:flex;gap:8px;margin-bottom:14px;">
                    <span class="mhs-badge purple"><i class="bi bi-bar-chart-steps me-1"></i><span id="achModalLevel"></span></span>
                    <span class="mhs-badge muted"><i class="bi bi-calendar3 me-1"></i><span id="achModalDate"></span></span>
                </div>
                <div style="background:var(--surface-container-low);border:1px solid var(--outline-variant);border-radius:var(--radius-md);padding:16px;margin-bottom:14px;white-space:pre-wrap;line-height:1.7;font-size:0.88rem;" id="achModalDesc"></div>
                <div id="achModalAttachment"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="mhs-btn mhs-btn-ghost" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showAnnouncement(title, message, date) {
    document.getElementById('announcementModalTitle').textContent = title;
    document.getElementById('announcementModalBody').textContent  = message;
    document.getElementById('announcementModalDate').innerHTML    = '<i class="bi bi-calendar3 me-1"></i>' + date;
    new bootstrap.Modal(document.getElementById('announcementModal')).show();
}

@php
$achievementsJson = $achievements->map(fn($a) => [
    'id'              => $a->id,
    'title'           => $a->title,
    'description'     => $a->description,
    'level'           => $a->level,
    'date'            => \Carbon\Carbon::parse($a->date)->format('d M Y'),
    'attachment'      => $a->attachment ? Storage::url($a->attachment) : null,
    'attachment_name' => $a->attachment ? basename($a->attachment) : null,
]);
@endphp
var achievementsData = @json($achievementsJson);

function showAchievement(id) {
    var ach = achievementsData.find(a => a.id === id);
    if (!ach) return;
    document.getElementById('achModalTitle').textContent = ach.title;
    document.getElementById('achModalLevel').textContent = ach.level || '-';
    document.getElementById('achModalDate').textContent  = ach.date;
    document.getElementById('achModalDesc').textContent  = ach.description || 'Tidak ada deskripsi.';
    var att = document.getElementById('achModalAttachment');
    att.innerHTML = ach.attachment
        ? '<a href="'+ach.attachment+'" target="_blank" download class="mhs-btn mhs-btn-success"><i class="bi bi-download"></i> Download Lampiran ('+ach.attachment_name+')</a>'
        : '<span style="font-size:0.8rem;color:var(--outline);"><i class="bi bi-x-circle me-1"></i>Tidak ada lampiran.</span>';
    new bootstrap.Modal(document.getElementById('achievementModal')).show();
}

function switchTab(prefix, id, btn) {
    document.querySelectorAll('.ft-pane').forEach(el => el.style.display = 'none');
    document.querySelectorAll('#ft-tabs .tab-pill').forEach(b => b.classList.remove('active'));
    var pane = document.getElementById(prefix + '-pane-' + id);
    if (pane) pane.style.display = '';
    btn.classList.add('active');
}
</script>
@endpush

@endsection