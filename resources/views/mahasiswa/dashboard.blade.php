@extends('layouts.mahasiswa')

@section('title', 'Dashboard')

@push('styles')
<style>
/* ── DASHBOARD GRID ─────────────────────────────────────────────── */
.dash-grid {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 20px;
    align-items: start;
}
@media(max-width:1100px){ .dash-grid { grid-template-columns: 1fr; } }

/* ── WELCOME HERO ────────────────────────────────────────────────── */
.welcome-hero {
    background: linear-gradient(135deg, #0a1f4e 0%, #0044cc 50%, #0066ff 100%);
    border-radius: 20px;
    padding: 24px 28px;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 20px;
    position: relative;
    overflow: hidden;
    border: 1px solid rgba(0,102,255,0.3);
    box-shadow: 0 8px 32px rgba(0,102,255,0.25);
}

.welcome-hero::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 220px; height: 220px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
}

.welcome-hero::after {
    content: '';
    position: absolute;
    bottom: -80px; right: 60px;
    width: 180px; height: 180px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
}

.welcome-icon {
    width: 58px; height: 58px;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.25);
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.6rem;
    flex-shrink: 0;
    position: relative; z-index: 1;
}

.welcome-text { position: relative; z-index: 1; flex: 1; }
.welcome-text h5 { font-size: 1.05rem; font-weight: 800; margin: 0 0 4px; font-family: var(--font-display); }
.welcome-text p  { font-size: 0.85rem; margin: 0; opacity: 0.85; }

.welcome-date {
    position: relative; z-index: 1;
    margin-left: auto;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.25);
    border-radius: 50px;
    padding: 7px 16px;
    font-size: 0.78rem;
    white-space: nowrap;
    flex-shrink: 0;
}

/* ── QUICK ACTION SHORTCUTS ──────────────────────────────────────── */
.shortcuts-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 10px;
    margin-bottom: 20px;
}
@media(max-width:768px){ .shortcuts-grid { grid-template-columns: repeat(3,1fr); } }

.shortcut-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding: 14px 10px;
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: var(--radius-xl);
    text-decoration: none;
    color: var(--text-2);
    font-size: 0.72rem;
    font-weight: 600;
    text-align: center;
    transition: all 0.22s ease;
}

.shortcut-btn:hover {
    border-color: var(--primary);
    color: var(--cyan);
    background: var(--primary-light);
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,102,255,0.2);
}

.shortcut-icon {
    width: 40px; height: 40px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
}

/* ── TODAY SCHEDULE CARDS ─────────────────────────────────────────── */
.today-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 12px;
    margin-bottom: 20px;
}

.schedule-card-new {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    border-left: 3px solid var(--primary);
    border-radius: var(--radius-lg);
    padding: 14px 16px;
    transition: all 0.2s ease;
}

.schedule-card-new:hover {
    background: rgba(0,102,255,0.06);
    border-color: rgba(0,102,255,0.25);
    transform: translateY(-2px);
}

.schedule-card-new.cancelled {
    border-left-color: var(--danger);
    background: rgba(255,71,87,0.05);
    border-color: rgba(255,71,87,0.15);
}

.schedule-card-new.changed {
    border-left-color: var(--warning);
    background: rgba(255,165,2,0.05);
    border-color: rgba(255,165,2,0.15);
}

.scard-subject {
    font-size: 0.88rem; font-weight: 700;
    color: var(--text-1); margin-bottom: 4px;
}

.scard-subject.cancelled { text-decoration: line-through; color: var(--danger); }

.scard-lecturer {
    font-size: 0.75rem; color: var(--text-2); margin-bottom: 10px;
}

.scard-meta {
    display: flex; justify-content: space-between;
    font-size: 0.7rem; color: var(--text-3);
    padding-top: 8px; border-top: 1px solid var(--border);
}

.scard-override {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 0.65rem; font-weight: 700; margin-top: 8px;
    padding: 3px 8px; border-radius: 20px;
}

.scard-override.cancelled { background: var(--danger); color: #fff; }
.scard-override.changed   { background: var(--warning); color: #fff; }

/* ── FITNESS METRICS ─────────────────────────────────────────────── */
.fitness-entry-new {
    background: rgba(255,255,255,0.03);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 14px 16px;
    margin-bottom: 10px;
}

.fitness-entry-new:last-child { margin-bottom: 0; }

.fitness-score-big {
    font-size: 2.5rem; font-weight: 800;
    line-height: 1; color: var(--danger);
    font-family: var(--font-display);
}

.fitness-metrics-grid {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 8px; margin-top: 12px;
}

.fitness-metric-item {
    background: rgba(255,255,255,0.04);
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    padding: 8px 10px; font-size: 0.75rem;
}

.fm-label { color: var(--text-3); display: block; margin-bottom: 2px; font-size: 0.68rem; }
.fm-raw   { font-weight: 600; color: var(--text-1); }
.fm-score { font-weight: 800; font-size: 0.82rem; }
.fm-score.ok   { color: var(--success); }
.fm-score.fail { color: var(--danger); }

/* ── ACHIEVEMENT ITEM ────────────────────────────────────────────── */
.ach-item-new {
    display: flex; align-items: flex-start; gap: 12px;
    padding: 12px 0; border-bottom: 1px solid var(--border);
    cursor: pointer; text-decoration: none; color: inherit;
    transition: all 0.15s;
    border-radius: var(--radius-sm);
}

.ach-item-new:last-child { border-bottom: none; padding-bottom: 0; }
.ach-item-new:hover { background: rgba(255,255,255,0.03); }

.ach-icon-new {
    width: 36px; height: 36px; flex-shrink: 0;
    background: rgba(255,215,0,0.1);
    border: 1px solid rgba(255,215,0,0.2);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
}

.ach-item-new h6 { font-size: 0.82rem; font-weight: 700; margin: 0 0 3px; color: var(--text-1); }
.ach-item-new p  { font-size: 0.75rem; color: var(--text-2); margin: 0 0 5px; }

/* ── EXAM ITEM ───────────────────────────────────────────────────── */
.exam-item-new {
    display: flex; align-items: center; gap: 14px;
    padding: 12px 0; border-bottom: 1px solid var(--border);
}

.exam-item-new:last-child { border-bottom: none; }

.exam-date-new {
    width: 44px; flex-shrink: 0;
    background: var(--info-light);
    border: 1px solid rgba(0,198,255,0.2);
    border-radius: var(--radius-md);
    text-align: center; padding: 6px 4px;
}

.exam-date-new .eday   { font-size: 1.2rem; font-weight: 800; color: var(--cyan); line-height: 1; }
.exam-date-new .emonth { font-size: 0.6rem; font-weight: 700; color: var(--cyan); opacity: .7; text-transform: uppercase; }
.exam-info-new h6 { font-size: 0.84rem; font-weight: 700; margin: 0 0 3px; color: var(--text-1); }
.exam-meta-new { font-size: 0.72rem; color: var(--text-3); display: flex; gap: 12px; }

/* ── ANNOUNCEMENT ─────────────────────────────────────────────────── */
.announce-item {
    display: block; text-decoration: none; color: inherit;
    padding: 12px 0; border-bottom: 1px solid var(--border);
    transition: opacity .15s; cursor: pointer;
}

.announce-item:last-child { border-bottom: none; }
.announce-item:hover { opacity: .75; }
.announce-item h6 { font-size: 0.82rem; font-weight: 700; margin: 0 0 3px; color: var(--text-1); }
.announce-item p  { font-size: 0.75rem; color: var(--text-2); margin: 0 0 4px; line-height: 1.5; }
.announce-item .time { font-size: 0.7rem; color: var(--text-3); }

/* ── VIOLATION CARD ──────────────────────────────────────────────── */
.violation-card-new {
    background: rgba(255,71,87,0.06);
    border: 1px solid rgba(255,71,87,0.2);
    border-radius: var(--radius-xl);
    overflow: hidden;
    margin-bottom: 16px;
}

.violation-header-new {
    background: rgba(255,71,87,0.1);
    padding: 12px 18px;
    border-bottom: 1px solid rgba(255,71,87,0.15);
    display: flex; align-items: center; gap: 8px;
}

.violation-header-new span { font-size: 0.84rem; font-weight: 700; color: var(--danger); }
.violation-body-new { padding: 14px 18px; }

.violation-item-new {
    background: rgba(255,71,87,0.06);
    border: 1px solid rgba(255,71,87,0.15);
    border-radius: var(--radius-md);
    padding: 12px 14px; margin-bottom: 8px;
}

.violation-item-new:last-child { margin-bottom: 0; }
.vn-title { font-size: 0.84rem; font-weight: 700; color: var(--danger); margin-bottom: 4px; }
.vn-desc  { font-size: 0.78rem; color: var(--text-1); margin-bottom: 5px; }
.vn-meta  { font-size: 0.7rem; color: var(--text-3); }

/* ── IPK PROGRESS RING ────────────────────────────────────────────── */
.ipk-ring-wrap {
    display: flex; flex-direction: column; align-items: center; gap: 6px;
}

.ipk-ring-svg { transform: rotate(-90deg); }

.ipk-ring-bg { fill: none; stroke: rgba(255,255,255,0.08); stroke-width: 8; }
.ipk-ring-fg { fill: none; stroke: url(#ipkGrad); stroke-width: 8; stroke-linecap: round;
    transition: stroke-dashoffset 1.5s cubic-bezier(0.4,0,0.2,1); }

.ipk-ring-center {
    position: absolute; inset: 0;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
}

.ipk-val { font-size: 1.4rem; font-weight: 800; color: var(--text-1); font-family: var(--font-display); line-height: 1; }
.ipk-label { font-size: 0.6rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--text-3); margin-top: 3px; }

/* ── WEEK TABLE ──────────────────────────────────────────────────── */
.week-today-row { background: rgba(0,102,255,0.07) !important; }

/* ── TAB PILLS ────────────────────────────────────────────────────── */
.tab-pills-new { display: flex; gap: 6px; margin-bottom: 14px; flex-wrap: wrap; }
.tab-pill-new {
    padding: 4px 14px;
    border-radius: 20px;
    border: 1px solid var(--border);
    background: transparent;
    color: var(--text-2);
    font-size: 0.75rem; font-weight: 600;
    cursor: pointer; transition: all .15s;
}

.tab-pill-new.active, .tab-pill-new:hover {
    background: var(--primary); border-color: var(--primary); color: #fff;
}
</style>
@endpush

@section('content')

{{-- ================================================================ --}}
{{-- WELCOME HERO                                                      --}}
{{-- ================================================================ --}}
<div class="welcome-hero">
    <div class="welcome-icon">🎓</div>
    <div class="welcome-text">
        <h5>Portal Akademik Mahasiswa</h5>
        <p>Selamat datang, <strong>{{ auth()->user()->name }}</strong> — pantau jadwal, nilai, dan aktivitas kamu di sini.</p>
    </div>
    <div class="welcome-date">
        <i class="bi bi-calendar3 me-1"></i>
        {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
    </div>
</div>

{{-- ================================================================ --}}
{{-- QUICK ACTION SHORTCUTS                                            --}}
{{-- ================================================================ --}}
<div class="shortcuts-grid">
    <a href="{{ route('mahasiswa.attendances.index') }}" class="shortcut-btn">
        <div class="shortcut-icon" style="background:rgba(0,102,255,0.12);color:var(--primary);">
            <i class="bi bi-calendar-check"></i>
        </div>
        Absensi
    </a>
    <a href="{{ route('mahasiswa.nilai.index') }}" class="shortcut-btn">
        <div class="shortcut-icon" style="background:rgba(0,198,255,0.12);color:var(--cyan);">
            <i class="bi bi-bar-chart-line"></i>
        </div>
        Nilai
    </a>
    <a href="{{ route('mahasiswa.materials.index') }}" class="shortcut-btn">
        <div class="shortcut-icon" style="background:rgba(0,210,100,0.12);color:var(--success);">
            <i class="bi bi-journal-text"></i>
        </div>
        Bahan Ajar
    </a>
    <a href="{{ route('mahasiswa.chats.index') }}" class="shortcut-btn">
        <div class="shortcut-icon" style="background:rgba(123,97,255,0.12);color:var(--purple);">
            <i class="bi bi-chat-dots"></i>
        </div>
        Chat
    </a>
    <a href="{{ route('mahasiswa.submissions.index') }}" class="shortcut-btn">
        <div class="shortcut-icon" style="background:rgba(255,165,2,0.12);color:var(--warning);">
            <i class="bi bi-envelope-paper"></i>
        </div>
        Surat
    </a>
</div>

{{-- ================================================================ --}}
{{-- MAIN DASHBOARD GRID                                               --}}
{{-- ================================================================ --}}
@php
$todayData = collect($weeklySchedules)->first(fn($d) => $d['date']->isToday());
@endphp

<div class="dash-grid">

    {{-- ══════════ KOLOM KIRI ══════════ --}}
    <div>

        {{-- 1. JADWAL PERKULIAHAN --}}
        <div class="mhs-card" style="margin-bottom:20px;">
            <div class="mhs-card-header">
                <h6 class="mhs-card-title">
                    <span class="mhs-card-icon" style="background:var(--primary-light);color:var(--primary);">
                        <i class="bi bi-calendar-week"></i>
                    </span>
                    Jadwal Perkuliahan
                </h6>
                <span class="mhs-badge cyan">Minggu Ini</span>
            </div>
            <div class="mhs-card-body">

                {{-- Jadwal Hari Ini --}}
                <div class="mhs-section-label">Hari Ini — {{ \Carbon\Carbon::now()->format('d M Y') }}</div>

                @if($todayData && $todayData['schedules']->isNotEmpty())
                <div class="today-grid">
                    @foreach($todayData['schedules'] as $schedule)
                    @php
                    $cancelled = $schedule->is_overridden && $schedule->override_status === 'cancelled';
                    $changed   = $schedule->is_overridden && $schedule->override_status !== 'cancelled';
                    $cardClass = $cancelled ? 'cancelled' : ($changed ? 'changed' : '');
                    @endphp
                    <div class="schedule-card-new {{ $cardClass }}">
                        <div class="scard-subject {{ $cancelled ? 'cancelled' : '' }}">{{ $schedule->subject->name }}</div>
                        <div class="scard-lecturer">
                            <i class="bi bi-person-circle me-1"></i>{{ $schedule->dosen->name }}
                        </div>
                        <div class="scard-meta">
                            <span><i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}–{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</span>
                            <span><i class="bi bi-geo-alt me-1"></i>{{ $schedule->room }}</span>
                        </div>
                        @if($schedule->is_overridden)
                        <span class="scard-override {{ $cancelled ? 'cancelled' : 'changed' }}">
                            <i class="bi bi-{{ $cancelled ? 'x-circle' : 'exclamation-triangle' }}-fill"></i>
                            {{ $cancelled ? 'DIBATALKAN' : 'JADWAL BERUBAH' }}
                        </span>
                        @if($schedule->override_note)
                        <div style="font-size:0.72rem;color:var(--text-2);font-style:italic;margin-top:4px;">"{{ $schedule->override_note }}"</div>
                        @endif
                        @endif
                    </div>
                    @endforeach
                </div>
                @else
                <div style="background:rgba(255,255,255,0.03);border:1px solid var(--border);border-radius:var(--radius-lg);padding:16px;text-align:center;margin-bottom:20px;">
                    <i class="bi bi-emoji-smile" style="font-size:1.4rem;color:var(--text-3);display:block;margin-bottom:6px;"></i>
                    <p style="font-size:0.82rem;color:var(--text-3);margin:0;">Tidak ada kelas hari ini. Selamat istirahat! 😎</p>
                </div>
                @endif

                {{-- Jadwal Mingguan --}}
                <div class="mhs-section-label" style="margin-top:20px;">Jadwal Mingguan Lengkap</div>
                <div style="overflow-x:auto;border-radius:var(--radius-lg);border:1px solid var(--border);">
                    <table class="mhs-table">
                        <thead>
                            <tr>
                                <th style="width:13%">Hari</th>
                                <th>Mata Kuliah</th>
                                <th style="width:15%">Waktu</th>
                                <th style="width:12%">Ruang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $hasClasses = false; @endphp
                            @foreach($weeklySchedules as $dayData)
                            @if($dayData['schedules']->isNotEmpty())
                            @php $hasClasses = true; $isToday = $dayData['date']->isToday(); @endphp
                            @foreach($dayData['schedules'] as $index => $schedule)
                            @php
                            $sc = $schedule->is_overridden && $schedule->override_status === 'cancelled';
                            $sw = $schedule->is_overridden && $schedule->override_status !== 'cancelled';
                            @endphp
                            <tr class="{{ $isToday ? 'week-today-row' : '' }}">
                                @if($index === 0)
                                <td rowspan="{{ count($dayData['schedules']) }}" style="vertical-align:top;padding-top:14px;">
                                    <span style="font-weight:700;font-size:0.78rem;color:{{ $isToday ? 'var(--cyan)' : 'var(--text-2)' }};">{{ $dayData['day_name'] }}</span>
                                    @if($isToday)<br><span class="mhs-badge cyan" style="margin-top:4px;font-size:0.55rem;">Hari ini</span>@endif
                                </td>
                                @endif
                                <td>
                                    <span style="font-weight:600;font-size:0.84rem;display:block;margin-bottom:2px;{{ $sc ? 'text-decoration:line-through;color:var(--danger);' : '' }}">{{ $schedule->subject->name }}</span>
                                    <span style="font-size:0.72rem;color:var(--text-3);"><i class="bi bi-person me-1"></i>{{ $schedule->dosen->name }}</span>
                                    @if($sc) <span class="mhs-badge danger" style="margin-top:4px;">Batal</span>
                                    @elseif($sw) <span class="mhs-badge warning" style="margin-top:4px;">Berubah</span>
                                    @endif
                                </td>
                                <td style="font-size:0.78rem;color:var(--text-2);{{ $sc ? 'text-decoration:line-through;color:var(--danger);' : '' }}">
                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}–{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                </td>
                                <td style="font-size:0.78rem;color:var(--text-2);">{{ $schedule->room }}</td>
                            </tr>
                            @endforeach
                            @endif
                            @endforeach
                            @if(!$hasClasses)
                            <tr><td colspan="4" class="mhs-empty">Belum ada jadwal minggu ini.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- 2 & 3: KESEMAPTAAN + PRESTASI side by side --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">

            {{-- 2. KESEMAPTAAN JASMANI --}}
            <div class="mhs-card">
                <div class="mhs-card-header">
                    <h6 class="mhs-card-title">
                        <span class="mhs-card-icon" style="background:var(--danger-light);color:var(--danger);">
                            <i class="bi bi-heart-pulse"></i>
                        </span>
                        Kesemaptaan
                    </h6>
                </div>
                <div class="mhs-card-body">
                    @if($fitnessTests->isNotEmpty())
                    @php $groupedFt = $fitnessTests->groupBy('semester'); @endphp
                    <div class="tab-pills-new" id="ft-tabs">
                        @foreach($groupedFt as $sem => $tests)
                        <button class="tab-pill-new {{ $loop->first ? 'active' : '' }}"
                            onclick="switchTab('ft','{{ $sem ?? 'lama' }}', this)" type="button">
                            {{ $sem ? 'Smt '.$sem : 'Lama' }}
                        </button>
                        @endforeach
                    </div>
                    @foreach($groupedFt as $sem => $tests)
                    <div id="ft-pane-{{ $sem ?? 'lama' }}" class="ft-pane" style="{{ $loop->first ? '' : 'display:none;' }}">
                        @foreach($tests as $ft)
                        <div class="fitness-entry-new">
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                                <span style="font-size:0.72rem;color:var(--text-3);"><i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($ft->test_date)->format('d M Y') }}</span>
                                <span class="mhs-badge {{ str_contains($ft->status,'lulus') || $ft->status === 'passed' ? 'success' : 'danger' }}">{{ strtoupper(str_replace('_',' ',$ft->status)) }}</span>
                            </div>
                            <div style="display:flex;align-items:baseline;gap:8px;margin-bottom:10px;">
                                <span class="fitness-score-big">{{ $ft->total_score ?? $ft->score }}</span>
                                <span style="font-size:0.75rem;color:var(--text-3);">Total Nilai</span>
                            </div>
                            @if($ft->total_score !== null)
                            <div class="fitness-metrics-grid">
                                @foreach([['Lari',$ft->raw_lari.'m',$ft->nilai_lari],[''.($ft->nilai_pull_up!==null?'Pull Up':'Chinning'),$ft->raw_pull_up??$ft->raw_chinning??'-',$ft->nilai_pull_up??$ft->nilai_chinning??0],['Sit Up',$ft->raw_sit_up??'-',$ft->nilai_sit_up??0],['Push Up',$ft->raw_push_up??'-',$ft->nilai_push_up??0],['Shuttle',$ft->raw_shuttle_run??'-'.'s',$ft->nilai_shuttle_run??0],['Renang',$ft->raw_renang??'-'.'s',$ft->nilai_renang??0]] as [$lbl,$raw,$score])
                                <div class="fitness-metric-item">
                                    <span class="fm-label">{{ $lbl }}</span>
                                    <span class="fm-raw">{{ $raw }}</span>
                                    <span class="fm-score {{ $score >= 60 ? 'ok' : 'fail' }}"> → {{ $score }}</span>
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
                    <div class="mhs-empty">
                        <i class="bi bi-clipboard2-x"></i>
                        <p>Belum ada data uji fisik.</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- 3. PRESTASI --}}
            <div class="mhs-card">
                <div class="mhs-card-header">
                    <h6 class="mhs-card-title">
                        <span class="mhs-card-icon" style="background:rgba(255,215,0,0.1);color:#ffd700;">
                            <i class="bi bi-trophy"></i>
                        </span>
                        Prestasi
                    </h6>
                </div>
                <div class="mhs-card-body">
                    @if($achievements->isNotEmpty())
                    @foreach($achievements as $ach)
                    <a href="javascript:void(0)" class="ach-item-new" onclick="showAchievement({{ $ach->id }})">
                        <div class="ach-icon-new">🏅</div>
                        <div style="flex:1;min-width:0;">
                            <h6>{{ $ach->title }}</h6>
                            <p>{{ \Illuminate\Support\Str::limit($ach->description, 55) }}</p>
                            <div style="display:flex;flex-wrap:wrap;gap:5px;">
                                @if($ach->level)<span class="mhs-badge purple"><i class="bi bi-bar-chart-steps me-1"></i>{{ $ach->level }}</span>@endif
                                <span class="mhs-badge muted"><i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($ach->date)->format('d M Y') }}</span>
                                @if($ach->attachment)<span class="mhs-badge success"><i class="bi bi-paperclip me-1"></i>Lampiran</span>@endif
                            </div>
                        </div>
                        <i class="bi bi-chevron-right" style="color:var(--text-3);font-size:0.75rem;flex-shrink:0;"></i>
                    </a>
                    @endforeach
                    @else
                    <div class="mhs-empty">
                        <i class="bi bi-award"></i>
                        <p>Belum ada catatan prestasi.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- 4. BIMBINGAN / WALI DOSEN --}}
        <div class="mhs-card">
            <div class="mhs-card-header">
                <h6 class="mhs-card-title">
                    <span class="mhs-card-icon" style="background:var(--success-light);color:var(--success);">
                        <i class="bi bi-people"></i>
                    </span>
                    Bimbingan / Wali Dosen
                </h6>
                <button class="mhs-btn mhs-btn-success mhs-btn-sm"
                        data-bs-toggle="modal" data-bs-target="#modalRequestMeeting">
                    <i class="bi bi-plus-lg"></i> Request
                </button>
            </div>
            <div style="overflow-x:auto;">
                @if($meetings->isNotEmpty())
                <table class="mhs-table">
                    <thead>
                        <tr>
                            <th style="padding-left:20px;">Tanggal</th>
                            <th>Dosen</th>
                            <th>Topik</th>
                            <th style="text-align:center;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($meetings as $mtg)
                        <tr>
                            <td style="padding-left:20px;font-size:0.78rem;">{{ \Carbon\Carbon::parse($mtg->requested_date)->format('d M Y') }}</td>
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
                @else
                <div class="mhs-empty" style="padding:24px;">
                    <i class="bi bi-calendar-plus"></i>
                    <p>Belum ada pengajuan bimbingan.</p>
                </div>
                @endif
            </div>
        </div>

    </div>{{-- END KOLOM KIRI --}}

    {{-- ══════════ KOLOM KANAN ══════════ --}}
    <div>

        {{-- IPK RING (if nilai data available) --}}
        @php
            $ipkVal = null;
            try {
                $avg = \App\Models\Grade::where('user_id', auth()->id())
                    ->whereNotNull('grade_point')
                    ->avg('grade_point');
                if ($avg !== null) $ipkVal = round($avg, 2);
            } catch(\Exception $e) { $ipkVal = null; }
        @endphp
        @if($ipkVal !== null)
        <div class="mhs-card" style="margin-bottom:16px;">
            <div class="mhs-card-header">
                <h6 class="mhs-card-title">
                    <span class="mhs-card-icon" style="background:var(--cyan-light);color:var(--cyan);">
                        <i class="bi bi-mortarboard"></i>
                    </span>
                    Indeks Prestasi
                </h6>
            </div>
            <div class="mhs-card-body" style="text-align:center;">
                <div style="position:relative;width:120px;height:120px;margin:0 auto 12px;">
                    <svg class="ipk-ring-svg" width="120" height="120" viewBox="0 0 120 120">
                        <defs>
                            <linearGradient id="ipkGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="0%" style="stop-color:var(--cyan)"/>
                                <stop offset="100%" style="stop-color:var(--primary)"/>
                            </linearGradient>
                        </defs>
                        <circle class="ipk-ring-bg" cx="60" cy="60" r="50"/>
                        <circle class="ipk-ring-fg" id="ipkRingFg" cx="60" cy="60" r="50"
                            stroke-dasharray="{{ 2 * 3.14159 * 50 }}"
                            stroke-dashoffset="{{ 2 * 3.14159 * 50 * (1 - min($ipkVal/4, 1)) }}"/>
                    </svg>
                    <div class="ipk-ring-center">
                        <span class="ipk-val">{{ number_format($ipkVal, 2) }}</span>
                        <span class="ipk-label">IPK</span>
                    </div>
                </div>
                <div style="font-size:0.75rem;color:var(--text-2);">
                    @if($ipkVal >= 3.5) 🏆 Dengan Pujian
                    @elseif($ipkVal >= 3.0) ⭐ Sangat Memuaskan
                    @elseif($ipkVal >= 2.75) 👍 Memuaskan
                    @else 📚 Perlu Ditingkatkan
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- 5. PELANGGARAN --}}
        @if($violations->isNotEmpty())
        <div class="violation-card-new">
            <div class="violation-header-new">
                <i class="bi bi-exclamation-octagon-fill" style="color:var(--danger);font-size:1rem;"></i>
                <span>Peringatan Pelanggaran</span>
            </div>
            <div class="violation-body-new">
                @foreach($violations as $v)
                <div class="violation-item-new">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:4px;">
                        <span class="vn-title">{{ $v->title }}</span>
                        <span style="font-weight:800;font-size:0.9rem;color:var(--danger);">{{ $v->point }} Poin</span>
                    </div>
                    <div class="vn-desc">{{ $v->description }}</div>
                    <div class="vn-meta"><i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($v->date)->format('d M Y') }}</div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- 6. UJIAN MENDATANG --}}
        <div class="mhs-card" style="margin-bottom:16px;">
            <div class="mhs-card-header">
                <h6 class="mhs-card-title">
                    <span class="mhs-card-icon" style="background:var(--info-light);color:var(--info);">
                        <i class="bi bi-journal-check"></i>
                    </span>
                    Ujian Mendatang
                </h6>
            </div>
            <div class="mhs-card-body">
                @if($exams->isNotEmpty())
                @foreach($exams as $exam)
                <div class="exam-item-new">
                    <div class="exam-date-new">
                        <div class="eday">{{ \Carbon\Carbon::parse($exam->date)->format('d') }}</div>
                        <div class="emonth">{{ \Carbon\Carbon::parse($exam->date)->format('M') }}</div>
                    </div>
                    <div class="exam-info-new">
                        <span class="mhs-badge cyan" style="margin-bottom:4px;">{{ strtoupper($exam->type) }}</span>
                        <h6>{{ $exam->subject->name }}</h6>
                        <div class="exam-meta-new">
                            <span><i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($exam->start_time)->format('H:i') }}</span>
                            <span><i class="bi bi-geo-alt me-1"></i>{{ $exam->room }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="mhs-empty" style="padding:16px 0;">
                    <i class="bi bi-calendar-x"></i>
                    <p>Belum ada jadwal ujian dalam waktu dekat.</p>
                </div>
                @endif
            </div>
        </div>

        {{-- 7. PENGUMUMAN PRODI --}}
        <div class="mhs-card" style="margin-bottom:16px;">
            <div class="mhs-card-header">
                <h6 class="mhs-card-title">
                    <span class="mhs-card-icon" style="background:var(--success-light);color:var(--success);">
                        <i class="bi bi-megaphone"></i>
                    </span>
                    Pengumuman Prodi
                </h6>
            </div>
            <div class="mhs-card-body">
                @if(isset($announcements) && $announcements->isNotEmpty())
                @foreach($announcements as $announcement)
                <a href="javascript:void(0)" class="announce-item"
                   onclick="showAnnouncement('{{ addslashes($announcement->title) }}', '{{ addslashes($announcement->message) }}', '{{ $announcement->created_at->format('d M Y, H:i') }}')">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                        <i class="bi bi-megaphone-fill" style="font-size:0.72rem;color:var(--success);"></i>
                        <h6>{{ $announcement->title }}</h6>
                    </div>
                    <p>{{ \Illuminate\Support\Str::limit($announcement->message, 75) }}</p>
                    <span class="time"><i class="bi bi-clock me-1"></i>{{ $announcement->created_at->diffForHumans() }}</span>
                </a>
                @endforeach
                @else
                <div class="mhs-empty" style="padding:16px 0;">
                    <i class="bi bi-bell-slash"></i>
                    <p>Belum ada pengumuman terbaru.</p>
                </div>
                @endif
            </div>
        </div>

        {{-- 8. KOTAK SARAN --}}
        <div class="mhs-card">
            <div class="mhs-card-header">
                <h6 class="mhs-card-title">
                    <span class="mhs-card-icon" style="background:var(--primary-light);color:var(--primary);">
                        <i class="bi bi-envelope-paper"></i>
                    </span>
                    Kotak Saran Akademik
                </h6>
            </div>
            <div class="mhs-card-body">
                <form action="{{ route('mahasiswa.dashboard.suggestion.store') }}" method="POST">
                    @csrf
                    <div class="mhs-form-group">
                        <label class="mhs-label">Kategori Saran <span style="color:var(--danger);">*</span></label>
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
                            placeholder="Tulis kritik & saran membangun Anda di sini..." required></textarea>
                    </div>
                    <button type="submit" class="mhs-btn mhs-btn-primary mhs-btn-full">
                        <i class="bi bi-send"></i> Kirim Saran
                    </button>
                </form>
            </div>
        </div>

    </div>{{-- END KOLOM KANAN --}}
</div>

{{-- ================================================================ --}}
{{-- MODALS                                                             --}}
{{-- ================================================================ --}}

{{-- MODAL REQUEST BIMBINGAN --}}
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

{{-- MODAL PENGUMUMAN --}}
<div class="modal fade mhs-modal" id="announcementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="announcementModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mhs-hint" style="margin-bottom:12px;" id="announcementModalDate"></p>
                <div style="background:rgba(255,255,255,0.03);border:1px solid var(--border);border-radius:var(--radius-lg);padding:16px;white-space:pre-wrap;line-height:1.7;font-size:0.88rem;" id="announcementModalBody"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="mhs-btn mhs-btn-ghost" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL DETAIL PRESTASI --}}
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
                <div style="background:rgba(255,255,255,0.03);border:1px solid var(--border);border-radius:var(--radius-lg);padding:16px;margin-bottom:14px;white-space:pre-wrap;line-height:1.7;font-size:0.88rem;" id="achModalDesc"></div>
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
    document.getElementById('announcementModalBody').textContent = message;
    document.getElementById('announcementModalDate').innerHTML = '<i class="bi bi-calendar3 me-1"></i>' + date;
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
    document.getElementById('achModalTitle').textContent   = ach.title;
    document.getElementById('achModalLevel').textContent   = ach.level || '-';
    document.getElementById('achModalDate').textContent    = ach.date;
    document.getElementById('achModalDesc').textContent    = ach.description || 'Tidak ada deskripsi.';
    var attachEl = document.getElementById('achModalAttachment');
    if (ach.attachment) {
        attachEl.innerHTML = '<a href="' + ach.attachment + '" target="_blank" download class="mhs-btn mhs-btn-success"><i class="bi bi-download"></i>Download Lampiran (' + ach.attachment_name + ')</a>';
    } else {
        attachEl.innerHTML = '<span style="font-size:0.8rem;color:var(--text-3);"><i class="bi bi-x-circle me-1"></i>Tidak ada lampiran.</span>';
    }
    new bootstrap.Modal(document.getElementById('achievementModal')).show();
}

function switchTab(prefix, id, btn) {
    document.querySelectorAll('.ft-pane').forEach(el => el.style.display = 'none');
    document.querySelectorAll('#ft-tabs .tab-pill-new').forEach(b => b.classList.remove('active'));
    var pane = document.getElementById(prefix + '-pane-' + id);
    if (pane) pane.style.display = '';
    btn.classList.add('active');
}
</script>
@endpush

@endsection