@extends('layouts.app')

@section('title', 'Academic Dashboard')

@section('content')

<style>
/* ====== DESIGN TOKENS ====== */
:root {
    --primary:       #2563EB;
    --primary-light: #EFF6FF;
    --primary-mid:   #BFDBFE;
    --success:       #16A34A;
    --success-light: #F0FDF4;
    --danger:        #DC2626;
    --danger-light:  #FEF2F2;
    --warning:       #D97706;
    --warning-light: #FFFBEB;
    --info:          #0891B2;
    --info-light:    #ECFEFF;
    --surface:       #FFFFFF;
    --bg:            #F8FAFC;
    --border:        #E2E8F0;
    --text-primary:  #0F172A;
    --text-secondary:#64748B;
    --text-muted:    #94A3B8;
    --radius-sm:     6px;
    --radius-md:     10px;
    --radius-lg:     14px;
    --radius-xl:     18px;
    --shadow-sm:     0 1px 3px rgba(0,0,0,0.07), 0 1px 2px rgba(0,0,0,0.04);
    --shadow-md:     0 4px 12px rgba(0,0,0,0.08), 0 2px 4px rgba(0,0,0,0.04);
}

/* ====== RESET / BASE ====== */
body { background: var(--bg); color: var(--text-primary); font-family: 'Segoe UI', system-ui, sans-serif; }

/* ====== LAYOUT ====== */
.dash-grid { display: grid; grid-template-columns: 1fr 340px; gap: 20px; align-items: start; }
@media(max-width:991px){ .dash-grid { grid-template-columns: 1fr; } }

/* ====== CARDS ====== */
.card-modern {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    margin-bottom: 20px;
}
.card-modern:last-child { margin-bottom: 0; }

.card-header-modern {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid var(--border);
    background: var(--surface);
}
.card-header-modern h6 {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.card-header-modern h6 .header-icon {
    width: 28px; height: 28px;
    border-radius: var(--radius-sm);
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; flex-shrink: 0;
}
.card-body-modern { padding: 20px; }

/* ====== WELCOME BANNER ====== */
.welcome-banner {
    background: linear-gradient(135deg, #1D4ED8 0%, #2563EB 50%, #3B82F6 100%);
    border-radius: var(--radius-xl);
    padding: 24px 28px;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 20px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(37,99,235,0.3);
}
.welcome-banner::before {
    content: '';
    position: absolute; inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Ccircle cx='30' cy='30' r='30'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    pointer-events: none;
}
.welcome-icon {
    width: 56px; height: 56px;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.25);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 24px; flex-shrink: 0;
}
.welcome-banner h5 { font-size: 17px; font-weight: 700; margin: 0 0 4px; }
.welcome-banner p  { font-size: 13px; margin: 0; opacity: 0.85; }
.welcome-banner .date-chip {
    margin-left: auto;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.25);
    border-radius: 20px;
    padding: 6px 14px;
    font-size: 12px;
    white-space: nowrap;
    flex-shrink: 0;
}

/* ====== ALERT TOAST ====== */
.alert-toast {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 16px;
    border-radius: var(--radius-lg);
    font-size: 13px; font-weight: 500;
    margin-bottom: 16px;
    border: 1px solid;
}
.alert-toast.success { background: var(--success-light); border-color: #BBF7D0; color: var(--success); }
.alert-toast.danger  { background: var(--danger-light);  border-color: #FECACA; color: var(--danger); }
.alert-toast .btn-close { margin-left: auto; }

/* ====== SECTION LABEL ====== */
.section-label {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: var(--text-muted);
    margin-bottom: 12px;
    margin-top: 4px;
}

/* ====== TODAY SCHEDULE CARDS ====== */
.today-schedule-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px,1fr)); gap: 12px; margin-bottom: 24px; }
.schedule-card {
    border-radius: var(--radius-lg);
    padding: 14px 16px;
    border-left: 4px solid;
    background: var(--surface);
    border: 1px solid var(--border);
    border-left: 4px solid var(--primary);
    position: relative;
    transition: box-shadow .15s;
}
.schedule-card:hover { box-shadow: var(--shadow-md); }
.schedule-card.cancelled { border-left-color: var(--danger); background: var(--danger-light); border-color: #FECACA; }
.schedule-card.changed   { border-left-color: var(--warning); background: var(--warning-light); border-color: #FDE68A; }
.schedule-card .subj-name {
    font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 4px;
}
.schedule-card.cancelled .subj-name { text-decoration: line-through; color: var(--danger); }
.schedule-card .lecturer { font-size: 12px; color: var(--text-secondary); margin-bottom: 10px; }
.schedule-card .meta-row {
    display: flex; justify-content: space-between;
    font-size: 11px; color: var(--text-muted);
    padding-top: 10px; border-top: 1px solid var(--border);
}
.schedule-card .override-badge {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 10px; font-weight: 700; margin-top: 8px;
    padding: 3px 8px; border-radius: 20px;
}
.override-badge.cancelled { background: var(--danger); color: #fff; }
.override-badge.changed   { background: var(--warning); color: #fff; }
.schedule-card .override-note { font-size: 11px; color: var(--text-secondary); font-style: italic; margin-top: 4px; }

/* ====== WEEKLY TABLE ====== */
.table-modern { width: 100%; border-collapse: collapse; font-size: 13px; }
.table-modern thead tr { background: var(--bg); }
.table-modern th { padding: 10px 14px; text-align: left; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-muted); border-bottom: 1px solid var(--border); }
.table-modern td { padding: 11px 14px; border-bottom: 1px solid var(--border); color: var(--text-primary); vertical-align: middle; }
.table-modern tbody tr:last-child td { border-bottom: none; }
.table-modern tbody tr.today-row { background: var(--primary-light); }
.table-modern tbody tr:hover { background: var(--bg); }
.table-modern .day-cell { font-weight: 700; color: var(--primary); font-size: 12px; }
.table-modern .today-row .day-cell { color: var(--primary); }
.table-modern .subject-name { font-weight: 600; display: block; margin-bottom: 2px; }
.table-modern .subject-name.cancelled { text-decoration: line-through; color: var(--danger); }
.table-modern .lecturer-small { font-size: 11px; color: var(--text-muted); }

/* ====== BADGE ====== */
.badge-pill {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 3px 9px; border-radius: 20px;
    font-size: 10px; font-weight: 700;
}
.badge-pill.primary  { background: var(--primary-light); color: var(--primary); }
.badge-pill.success  { background: var(--success-light); color: var(--success); }
.badge-pill.danger   { background: var(--danger-light);  color: var(--danger); }
.badge-pill.warning  { background: var(--warning-light); color: var(--warning); }
.badge-pill.info     { background: var(--info-light);    color: var(--info); }
.badge-pill.muted    { background: #F1F5F9; color: var(--text-secondary); }
.badge-pill.cancel   { background: var(--danger); color: #fff; }
.badge-pill.change   { background: var(--warning); color: #fff; }

/* ====== FITNESS CARD ====== */
.fitness-entry {
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 14px 16px;
    margin-bottom: 10px;
    background: var(--bg);
}
.fitness-entry:last-child { margin-bottom: 0; }
.fitness-big-score { font-size: 32px; font-weight: 700; color: var(--danger); line-height: 1; }
.fitness-metrics { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-top: 12px; }
.fitness-metric {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    padding: 8px 10px;
    font-size: 12px;
}
.fitness-metric .label { color: var(--text-muted); display: block; margin-bottom: 2px; font-size: 11px; }
.fitness-metric .raw   { font-weight: 600; color: var(--text-primary); }
.fitness-metric .score { font-weight: 700; font-size: 13px; }
.fitness-metric .score.ok   { color: var(--success); }
.fitness-metric .score.fail { color: var(--danger); }

/* ====== ACHIEVEMENT ITEM ====== */
.ach-item {
    display: flex; align-items: flex-start; gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid var(--border);
    cursor: pointer;
    text-decoration: none;
    color: inherit;
    transition: background .12s;
    border-radius: var(--radius-sm);
}
.ach-item:last-child { border-bottom: none; padding-bottom: 0; }
.ach-item:hover { background: var(--bg); }
.ach-icon {
    width: 38px; height: 38px; flex-shrink: 0;
    background: #FFFBEB;
    border: 1px solid #FDE68A;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
}
.ach-item h6 { font-size: 13px; font-weight: 600; margin: 0 0 3px; color: var(--text-primary); }
.ach-item p  { font-size: 12px; color: var(--text-secondary); margin: 0 0 6px; }

/* ====== MEETING TABLE ====== */
.meeting-row td:first-child { font-weight: 600; font-size: 12px; }

/* ====== RIGHT COLUMN CARDS ====== */
.info-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    margin-bottom: 20px;
}
.info-card:last-child { margin-bottom: 0; }

/* ====== VIOLATION CARD ====== */
.violation-card {
    border: 1px solid var(--border);
    border-radius: var(--radius-xl);
    background: var(--surface);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    margin-bottom: 20px;
}
.violation-header {
    background: var(--danger-light);
    padding: 14px 18px;
    border-bottom: 1px solid #FECACA;
    display: flex; align-items: center; gap: 8px;
}
.violation-header h6 { font-size: 13px; font-weight: 700; color: var(--danger); margin: 0; }
.violation-body { padding: 14px 18px; }
.violation-item {
    background: #FFF5F5;
    border: 1px solid #FECACA;
    border-radius: var(--radius-lg);
    padding: 12px 14px;
    margin-bottom: 10px;
}
.violation-item:last-child { margin-bottom: 0; }
.violation-item .v-title { font-size: 13px; font-weight: 600; color: var(--danger); margin-bottom: 4px; }
.violation-item .v-desc  { font-size: 12px; color: var(--text-primary); margin-bottom: 6px; }
.violation-item .v-meta  { font-size: 11px; color: var(--text-muted); }
.violation-point { font-weight: 700; font-size: 15px; color: var(--danger); }

/* ====== EXAM LIST ====== */
.exam-item {
    display: flex; align-items: center; gap: 14px;
    padding: 12px 0;
    border-bottom: 1px solid var(--border);
}
.exam-item:last-child { border-bottom: none; }
.exam-date-box {
    width: 44px; flex-shrink: 0;
    background: var(--info-light);
    border: 1px solid #A5F3FC;
    border-radius: var(--radius-md);
    text-align: center;
    padding: 6px 4px;
}
.exam-date-box .day   { font-size: 18px; font-weight: 700; color: var(--info); line-height: 1; }
.exam-date-box .month { font-size: 10px; font-weight: 600; color: var(--info); opacity: .8; text-transform: uppercase; }
.exam-info h6 { font-size: 13px; font-weight: 600; margin: 0 0 3px; }
.exam-meta    { font-size: 11px; color: var(--text-muted); display: flex; gap: 12px; }

/* ====== ANNOUNCEMENT ====== */
.announcement-item {
    display: block;
    text-decoration: none;
    color: inherit;
    padding: 12px 0;
    border-bottom: 1px solid var(--border);
    cursor: pointer;
    transition: opacity .12s;
}
.announcement-item:last-child { border-bottom: none; }
.announcement-item:hover { opacity: .8; }
.announcement-item h6 { font-size: 13px; font-weight: 600; margin: 0 0 3px; color: var(--text-primary); }
.announcement-item p  { font-size: 12px; color: var(--text-secondary); margin: 0 0 4px; line-height: 1.5; }
.announcement-item .time { font-size: 11px; color: var(--text-muted); }

/* ====== SUGGESTION BOX ====== */
.suggestion-box { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-xl); box-shadow: var(--shadow-sm); overflow: hidden; margin-bottom: 20px; }
.suggestion-header { padding: 14px 18px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 8px; }
.suggestion-header h6 { font-size: 13px; font-weight: 600; margin: 0; color: var(--text-primary); }
.suggestion-body { padding: 16px 18px; }
.form-control-modern {
    width: 100%;
    padding: 9px 12px;
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    font-size: 13px;
    background: var(--surface);
    color: var(--text-primary);
    transition: border-color .15s, box-shadow .15s;
    outline: none;
    font-family: inherit;
}
.form-control-modern:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(37,99,235,0.12); }
.form-control-modern::placeholder { color: var(--text-muted); }
select.form-control-modern { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%2394A3B8' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; padding-right: 32px; }
textarea.form-control-modern { resize: vertical; min-height: 80px; }
.btn-primary-modern {
    width: 100%;
    padding: 10px;
    background: var(--primary);
    color: #fff;
    border: none;
    border-radius: var(--radius-md);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: background .15s, transform .1s;
    font-family: inherit;
}
.btn-primary-modern:hover { background: #1D4ED8; }
.btn-primary-modern:active { transform: scale(.98); }

/* ====== EMPTY STATE ====== */
.empty-state {
    text-align: center; padding: 28px 16px;
    color: var(--text-muted);
}
.empty-state i { font-size: 28px; display: block; margin-bottom: 8px; }
.empty-state p { font-size: 13px; margin: 0; }

/* ====== TABS (pills) ====== */
.tab-pills { display: flex; gap: 6px; margin-bottom: 14px; flex-wrap: wrap; }
.tab-pill-btn {
    padding: 5px 14px;
    border-radius: 20px;
    border: 1px solid var(--border);
    background: var(--bg);
    color: var(--text-secondary);
    font-size: 12px; font-weight: 600;
    cursor: pointer; transition: all .15s;
}
.tab-pill-btn.active, .tab-pill-btn:hover { background: var(--primary); border-color: var(--primary); color: #fff; }

/* ====== MODAL ====== */
.modal-content { border: none; border-radius: var(--radius-xl); box-shadow: 0 20px 60px rgba(0,0,0,0.15); }
.modal-header-modern { padding: 20px 24px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
.modal-header-modern h5 { font-size: 16px; font-weight: 700; margin: 0; color: var(--text-primary); }
.modal-body-modern { padding: 20px 24px; }
.modal-footer-modern { padding: 14px 24px; border-top: 1px solid var(--border); display: flex; gap: 10px; justify-content: flex-end; }
.form-label-modern { font-size: 12px; font-weight: 600; color: var(--text-secondary); display: block; margin-bottom: 5px; }
.form-group-modern { margin-bottom: 16px; }
.btn-modal-cancel { padding: 9px 20px; border-radius: var(--radius-md); border: 1px solid var(--border); background: var(--bg); font-size: 13px; font-weight: 600; cursor: pointer; color: var(--text-primary); }
.btn-modal-submit { padding: 9px 20px; border-radius: var(--radius-md); border: none; background: var(--primary); color: #fff; font-size: 13px; font-weight: 600; cursor: pointer; }
.btn-modal-submit.success { background: var(--success); }
.hint-text { font-size: 11px; color: var(--text-muted); margin-top: 4px; }

/* ====== REQUEST BUTTON ====== */
.btn-sm-modern {
    padding: 5px 12px;
    border-radius: var(--radius-md);
    border: 1px solid;
    font-size: 12px; font-weight: 600;
    cursor: pointer; display: inline-flex; align-items: center; gap: 5px;
    transition: all .15s;
}
.btn-sm-modern.success { background: var(--success-light); border-color: #86EFAC; color: var(--success); }
.btn-sm-modern.success:hover { background: var(--success); color: #fff; }

/* ====== DIVIDER ====== */
.h-divider { border: none; border-top: 1px solid var(--border); margin: 16px 0; }
</style>

<div class="container-fluid px-0">

    {{-- ALERT MESSAGES --}}
    @if(session('success'))
    <div class="alert-toast success">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('success') }}
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
    @endif
    @if($errors->any())
    <div class="alert-toast danger">
        <i class="bi bi-exclamation-triangle-fill"></i>
        Terdapat kesalahan pada input Anda.
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- WELCOME BANNER --}}
    <div class="welcome-banner">
        <div class="welcome-icon"><i class="bi bi-mortarboard-fill text-white"></i></div>
        <div>
            <h5>Portal Akademik Mahasiswa</h5>
            <p>Selamat datang, <strong>{{ auth()->user()->name }}</strong> — pantau jadwal, akademik, dan aktivitas kamu di sini.</p>
        </div>
        <div class="date-chip">
            <i class="bi bi-calendar3 me-1"></i>
            {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
        </div>
    </div>

    @php
    $todayData = collect($weeklySchedules)->first(fn($d) => $d['date']->isToday());
    @endphp

    {{-- MAIN GRID --}}
    <div class="dash-grid">

        {{-- ========== KOLOM KIRI ========== --}}
        <div>

            {{-- 1. JADWAL PERKULIAHAN --}}
            <div class="card-modern">
                <div class="card-header-modern">
                    <h6>
                        <span class="header-icon" style="background:#EFF6FF;color:#2563EB;">
                            <i class="bi bi-calendar-week"></i>
                        </span>
                        Jadwal Perkuliahan
                    </h6>
                    <span class="badge-pill primary">Minggu Ini</span>
                </div>
                <div class="card-body-modern">

                    {{-- Jadwal Hari Ini --}}
                    <div class="section-label">Hari Ini — {{ \Carbon\Carbon::now()->format('d M Y') }}</div>

                    @if($todayData && $todayData['schedules']->isNotEmpty())
                    <div class="today-schedule-grid">
                        @foreach($todayData['schedules'] as $schedule)
                        @php
                        $cancelled = $schedule->is_overridden && $schedule->override_status === 'cancelled';
                        $changed   = $schedule->is_overridden && $schedule->override_status !== 'cancelled';
                        $cardClass = $cancelled ? 'cancelled' : ($changed ? 'changed' : '');
                        @endphp
                        <div class="schedule-card {{ $cardClass }}">
                            <div class="subj-name">{{ $schedule->subject->name }}</div>
                            <div class="lecturer">
                                <i class="bi bi-person-circle me-1"></i>{{ $schedule->dosen->name }}
                            </div>
                            <div class="meta-row">
                                <span><i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}–{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</span>
                                <span><i class="bi bi-geo-alt me-1"></i>{{ $schedule->room }}</span>
                            </div>
                            @if($schedule->is_overridden)
                            <span class="override-badge {{ $cancelled ? 'cancelled' : 'changed' }}">
                                <i class="bi bi-{{ $cancelled ? 'x-circle' : 'exclamation-triangle' }}-fill"></i>
                                {{ $cancelled ? 'DIBATALKAN' : 'JADWAL BERUBAH' }}
                            </span>
                            @if($schedule->override_note)
                            <div class="override-note">"{{ $schedule->override_note }}"</div>
                            @endif
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div style="background:var(--bg);border:1px solid var(--border);border-radius:var(--radius-lg);padding:16px;text-align:center;margin-bottom:20px;">
                        <i class="bi bi-emoji-smile" style="font-size:20px;color:var(--text-muted);display:block;margin-bottom:6px;"></i>
                        <p style="font-size:13px;color:var(--text-muted);margin:0;">Tidak ada kelas hari ini. Selamat istirahat!</p>
                    </div>
                    @endif

                    {{-- Jadwal Mingguan --}}
                    <div class="section-label">Jadwal Mingguan Lengkap</div>
                    <div style="overflow-x:auto;border-radius:var(--radius-lg);border:1px solid var(--border);">
                        <table class="table-modern">
                            <thead>
                                <tr>
                                    <th style="width:13%">Hari</th>
                                    <th>Mata Kuliah</th>
                                    <th style="width:16%">Waktu</th>
                                    <th style="width:14%">Ruang</th>
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
                                <tr class="{{ $isToday ? 'today-row' : '' }}">
                                    @if($index === 0)
                                    <td class="day-cell" rowspan="{{ count($dayData['schedules']) }}" style="vertical-align:top;padding-top:14px;">
                                        {{ $dayData['day_name'] }}
                                        @if($isToday)<br><span class="badge-pill primary" style="margin-top:4px;font-size:9px;">Hari ini</span>@endif
                                    </td>
                                    @endif
                                    <td>
                                        <span class="subject-name {{ $sc ? 'cancelled' : '' }}">{{ $schedule->subject->name }}</span>
                                        <span class="lecturer-small"><i class="bi bi-person me-1"></i>{{ $schedule->dosen->name }}</span>
                                        @if($sc) <span class="badge-pill danger" style="margin-top:4px;">Batal</span>
                                        @elseif($sw) <span class="badge-pill warning" style="margin-top:4px;">Berubah</span>
                                        @endif
                                    </td>
                                    <td style="font-size:12px;color:var(--text-secondary);{{ $sc ? 'text-decoration:line-through;color:var(--danger);' : '' }}">
                                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}–{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                    </td>
                                    <td style="font-size:12px;color:var(--text-secondary);">{{ $schedule->room }}</td>
                                </tr>
                                @endforeach
                                @endif
                                @endforeach
                                @if(!$hasClasses)
                                <tr><td colspan="4" class="empty-state">Belum ada jadwal minggu ini.</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- 2 & 3: KESEMAPTAAN + PRESTASI side by side --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">

                {{-- 2. KESEMAPTAAN JASMANI --}}
                <div class="card-modern" style="margin-bottom:0;">
                    <div class="card-header-modern">
                        <h6>
                            <span class="header-icon" style="background:#FEF2F2;color:#DC2626;">
                                <i class="bi bi-heart-pulse"></i>
                            </span>
                            Kesemaptaan Jasmani
                        </h6>
                    </div>
                    <div class="card-body-modern">
                        @if($fitnessTests->isNotEmpty())
                        @php $groupedFt = $fitnessTests->groupBy('semester'); @endphp
                        <div class="tab-pills" id="ft-tabs">
                            @foreach($groupedFt as $sem => $tests)
                            <button class="tab-pill-btn {{ $loop->first ? 'active' : '' }}"
                                onclick="switchTab('ft','{{ $sem ?? 'lama' }}', this)"
                                type="button">{{ $sem ? 'Smt '.$sem : 'Lama' }}</button>
                            @endforeach
                        </div>
                        @foreach($groupedFt as $sem => $tests)
                        <div id="ft-pane-{{ $sem ?? 'lama' }}" class="ft-pane" style="{{ $loop->first ? '' : 'display:none;' }}">
                            @foreach($tests as $ft)
                            <div class="fitness-entry">
                                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                                    <span style="font-size:12px;color:var(--text-muted);"><i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($ft->test_date)->format('d M Y') }}</span>
                                    <span class="badge-pill {{ str_contains($ft->status,'lulus') || $ft->status === 'passed' ? 'success' : 'danger' }}">{{ strtoupper(str_replace('_',' ',$ft->status)) }}</span>
                                </div>
                                <div style="display:flex;align-items:baseline;gap:8px;margin-bottom:10px;">
                                    <span class="fitness-big-score">{{ $ft->total_score ?? $ft->score }}</span>
                                    <span style="font-size:12px;color:var(--text-muted);">Total Nilai</span>
                                </div>
                                @if($ft->total_score !== null)
                                <div class="fitness-metrics">
                                    @foreach([['Lari',$ft->raw_lari.'m',$ft->nilai_lari],[''.($ft->nilai_pull_up!==null?'Pull Up':'Chinning'),$ft->raw_pull_up??$ft->raw_chinning??'-',$ft->nilai_pull_up??$ft->nilai_chinning??0],['Sit Up',$ft->raw_sit_up??'-',$ft->nilai_sit_up??0],['Push Up',$ft->raw_push_up??'-',$ft->nilai_push_up??0],['Shuttle',$ft->raw_shuttle_run??'-'.'s',$ft->nilai_shuttle_run??0],['Renang',$ft->raw_renang??'-'.'s',$ft->nilai_renang??0]] as [$lbl,$raw,$score])
                                    <div class="fitness-metric">
                                        <span class="label">{{ $lbl }}</span>
                                        <span class="raw">{{ $raw }}</span>
                                        <span class="score {{ $score >= 60 ? 'ok' : 'fail' }}"> → {{ $score }}</span>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <div style="display:flex;gap:6px;flex-wrap:wrap;">
                                    <span class="badge-pill muted">A: {{ $ft->score_a ?? '-' }}</span>
                                    <span class="badge-pill muted">B: {{ $ft->score_b ?? '-' }}</span>
                                    <span class="badge-pill muted">C: {{ $ft->score_c ?? '-' }}</span>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                        @else
                        <div class="empty-state">
                            <i class="bi bi-clipboard2-x"></i>
                            <p>Belum ada data uji fisik.</p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- 3. PRESTASI --}}
                <div class="card-modern" style="margin-bottom:0;">
                    <div class="card-header-modern">
                        <h6>
                            <span class="header-icon" style="background:#FFFBEB;color:#D97706;">
                                <i class="bi bi-trophy"></i>
                            </span>
                            Prestasi
                        </h6>
                    </div>
                    <div class="card-body-modern">
                        @if($achievements->isNotEmpty())
                        @foreach($achievements as $ach)
                        <a href="javascript:void(0)" class="ach-item" onclick="showAchievement({{ $ach->id }})">
                            <div class="ach-icon">🏅</div>
                            <div style="flex:1;min-width:0;">
                                <h6>{{ $ach->title }}</h6>
                                <p>{{ \Illuminate\Support\Str::limit($ach->description, 55) }}</p>
                                <div style="display:flex;flex-wrap:wrap;gap:5px;">
                                    @if($ach->level)<span class="badge-pill info"><i class="bi bi-bar-chart-steps me-1"></i>{{ $ach->level }}</span>@endif
                                    <span class="badge-pill muted"><i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($ach->date)->format('d M Y') }}</span>
                                    @if($ach->attachment)<span class="badge-pill success"><i class="bi bi-paperclip me-1"></i>Lampiran</span>@endif
                                </div>
                            </div>
                            <i class="bi bi-chevron-right" style="color:var(--text-muted);font-size:12px;flex-shrink:0;"></i>
                        </a>
                        @endforeach
                        @else
                        <div class="empty-state">
                            <i class="bi bi-award"></i>
                            <p>Belum ada catatan prestasi.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- 4. BIMBINGAN / WALI DOSEN --}}
            <div class="card-modern">
                <div class="card-header-modern">
                    <h6>
                        <span class="header-icon" style="background:var(--success-light);color:var(--success);">
                            <i class="bi bi-people"></i>
                        </span>
                        Bimbingan / Wali Dosen
                    </h6>
                    <button class="btn-sm-modern success" data-bs-toggle="modal" data-bs-target="#modalRequestMeeting">
                        <i class="bi bi-plus-lg"></i> Request Bimbingan
                    </button>
                </div>
                <div style="overflow-x:auto;">
                    @if($meetings->isNotEmpty())
                    <table class="table-modern">
                        <thead>
                            <tr>
                                <th style="padding-left:20px;">Tanggal</th>
                                <th>Dosen</th>
                                <th>Topik</th>
                                <th style="text-align:center;">Status</th>
                            </tr>
                        </thead>
                        <tbody class="meeting-row">
                            @foreach($meetings as $mtg)
                            <tr>
                                <td style="padding-left:20px;font-size:12px;">{{ \Carbon\Carbon::parse($mtg->requested_date)->format('d M Y') }}</td>
                                <td style="font-size:13px;">{{ $mtg->dosen->name }}</td>
                                <td style="font-size:12px;color:var(--text-secondary);">{{ $mtg->topic }}</td>
                                <td style="text-align:center;">
                                    @if($mtg->status === 'approved')
                                    <span class="badge-pill success">Disetujui</span>
                                    @elseif($mtg->status === 'rejected')
                                    <span class="badge-pill danger">Ditolak</span>
                                    @else
                                    <span class="badge-pill muted">Menunggu</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="empty-state">
                        <i class="bi bi-calendar-plus"></i>
                        <p>Belum ada pengajuan bimbingan.</p>
                    </div>
                    @endif
                </div>
            </div>

        </div>{{-- END KOLOM KIRI --}}

        {{-- ========== KOLOM KANAN ========== --}}
        <div>

            {{-- 5. PELANGGARAN --}}
            @if($violations->isNotEmpty())
            <div class="violation-card">
                <div class="violation-header">
                    <i class="bi bi-exclamation-octagon-fill" style="color:var(--danger);font-size:16px;"></i>
                    <h6>Peringatan Pelanggaran</h6>
                </div>
                <div class="violation-body">
                    @foreach($violations as $v)
                    <div class="violation-item">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:5px;">
                            <span class="v-title">{{ $v->title }}</span>
                            <span class="violation-point">{{ $v->point }} Poin</span>
                        </div>
                        <div class="v-desc">{{ $v->description }}</div>
                        <div class="v-meta"><i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($v->date)->format('d M Y') }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- 6. UJIAN MENDATANG --}}
            <div class="info-card">
                <div class="card-header-modern">
                    <h6>
                        <span class="header-icon" style="background:var(--info-light);color:var(--info);">
                            <i class="bi bi-journal-check"></i>
                        </span>
                        Ujian Mendatang
                    </h6>
                </div>
                <div class="card-body-modern">
                    @if($exams->isNotEmpty())
                    @foreach($exams as $exam)
                    <div class="exam-item">
                        <div class="exam-date-box">
                            <div class="day">{{ \Carbon\Carbon::parse($exam->date)->format('d') }}</div>
                            <div class="month">{{ \Carbon\Carbon::parse($exam->date)->format('M') }}</div>
                        </div>
                        <div class="exam-info">
                            <span class="badge-pill info" style="margin-bottom:4px;">{{ strtoupper($exam->type) }}</span>
                            <h6>{{ $exam->subject->name }}</h6>
                            <div class="exam-meta">
                                <span><i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($exam->start_time)->format('H:i') }}</span>
                                <span><i class="bi bi-geo-alt me-1"></i>{{ $exam->room }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="empty-state" style="padding:20px 0;">
                        <i class="bi bi-calendar-x"></i>
                        <p>Belum ada jadwal ujian dalam waktu dekat.</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- 7. PENGUMUMAN PRODI --}}
            <div class="info-card">
                <div class="card-header-modern">
                    <h6>
                        <span class="header-icon" style="background:var(--success-light);color:var(--success);">
                            <i class="bi bi-megaphone"></i>
                        </span>
                        Pengumuman Prodi
                    </h6>
                </div>
                <div class="card-body-modern">
                    @if(isset($announcements) && $announcements->isNotEmpty())
                    @foreach($announcements as $announcement)
                    <a href="javascript:void(0)" class="announcement-item"
                        onclick="showAnnouncement('{{ addslashes($announcement->title) }}', '{{ addslashes($announcement->message) }}', '{{ $announcement->created_at->format('d M Y, H:i') }}')">
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                            <i class="bi bi-megaphone-fill" style="font-size:12px;color:var(--success);"></i>
                            <h6>{{ $announcement->title }}</h6>
                        </div>
                        <p>{{ \Illuminate\Support\Str::limit($announcement->message, 75) }}</p>
                        <span class="time"><i class="bi bi-clock me-1"></i>{{ $announcement->created_at->diffForHumans() }}</span>
                    </a>
                    @endforeach
                    @else
                    <div class="empty-state" style="padding:20px 0;">
                        <i class="bi bi-bell-slash"></i>
                        <p>Belum ada pengumuman terbaru.</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- 8. KOTAK SARAN --}}
            <div class="suggestion-box">
                <div class="suggestion-header">
                    <span class="header-icon" style="background:#EFF6FF;color:#2563EB;width:28px;height:28px;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;">
                        <i class="bi bi-envelope-paper"></i>
                    </span>
                    <h6>Kotak Saran Akademik</h6>
                </div>
                <div class="suggestion-body">
                    <form action="{{ route('mahasiswa.dashboard.suggestion.store') }}" method="POST">
                        @csrf
                        <div class="form-group-modern">
                            <label class="form-label-modern">Kategori Saran <span style="color:var(--danger);">*</span></label>
                            <select name="category" class="form-control-modern" required>
                                <option value="">Pilih kategori...</option>
                                <option value="fasilitas">Fasilitas Kampus</option>
                                <option value="akademik">Layanan Akademik</option>
                                <option value="dosen">Kinerja Dosen</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="form-group-modern">
                            <label class="form-label-modern">Isi Saran <span style="color:var(--danger);">*</span></label>
                            <textarea name="content" class="form-control-modern" rows="3"
                                placeholder="Tulis kritik & saran membangun Anda di sini..." required></textarea>
                        </div>
                        <button type="submit" class="btn-primary-modern">
                            <i class="bi bi-send me-1"></i> Kirim Saran
                        </button>
                    </form>
                </div>
            </div>

        </div>{{-- END KOLOM KANAN --}}
    </div>
</div>

{{-- MODAL REQUEST BIMBINGAN --}}
<div class="modal fade" id="modalRequestMeeting" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('mahasiswa.dashboard.meeting.store') }}" method="POST">
                @csrf
                <div class="modal-header-modern">
                    <h5><i class="bi bi-calendar-plus text-success me-2"></i>Ajukan Jadwal Bimbingan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body-modern">
                    <div class="form-group-modern">
                        <label class="form-label-modern">Pilih Dosen / Wali Dosen <span style="color:var(--danger);">*</span></label>
                        <select name="dosen_id" class="form-control-modern" required>
                            <option value="">Pilih Dosen...</option>
                            @foreach($dosens as $dsn)
                            <option value="{{ $dsn->id }}">{{ $dsn->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group-modern">
                        <label class="form-label-modern">Tanggal Pengajuan <span style="color:var(--danger);">*</span></label>
                        <input type="date" name="requested_date" class="form-control-modern"
                            min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" required>
                        <div class="hint-text">Tanggal aktual dapat diubah oleh dosen saat persetujuan.</div>
                    </div>
                    <div class="form-group-modern" style="margin-bottom:0;">
                        <label class="form-label-modern">Topik Bimbingan <span style="color:var(--danger);">*</span></label>
                        <input type="text" name="topic" class="form-control-modern"
                            placeholder="Contoh: Konsultasi KRS / Tugas Akhir" required>
                    </div>
                </div>
                <div class="modal-footer-modern">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-submit success">
                        <i class="bi bi-send me-1"></i> Ajukan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL PENGUMUMAN --}}
<div class="modal fade" id="announcementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header-modern">
                <h5 id="announcementModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body-modern">
                <p class="hint-text" style="margin-bottom:12px;" id="announcementModalDate"></p>
                <div style="background:var(--bg);border:1px solid var(--border);border-radius:var(--radius-lg);padding:16px;white-space:pre-wrap;line-height:1.7;font-size:14px;" id="announcementModalBody"></div>
            </div>
            <div class="modal-footer-modern">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL DETAIL PRESTASI --}}
<div class="modal fade" id="achievementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header-modern">
                <h5 id="achModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body-modern">
                <div style="display:flex;gap:8px;margin-bottom:14px;">
                    <span class="badge-pill info"><i class="bi bi-bar-chart-steps me-1"></i><span id="achModalLevel"></span></span>
                    <span class="badge-pill muted"><i class="bi bi-calendar3 me-1"></i><span id="achModalDate"></span></span>
                </div>
                <div style="background:var(--bg);border:1px solid var(--border);border-radius:var(--radius-lg);padding:16px;margin-bottom:14px;white-space:pre-wrap;line-height:1.7;font-size:14px;" id="achModalDesc"></div>
                <div id="achModalAttachment"></div>
            </div>
            <div class="modal-footer-modern">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

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
        attachEl.innerHTML = '<a href="' + ach.attachment + '" target="_blank" download style="display:inline-flex;align-items:center;gap:8px;padding:9px 18px;background:var(--success);color:#fff;border-radius:8px;text-decoration:none;font-size:13px;font-weight:600;"><i class="bi bi-download"></i>Download Lampiran (' + ach.attachment_name + ')</a>';
    } else {
        attachEl.innerHTML = '<span style="font-size:13px;color:var(--text-muted);"><i class="bi bi-x-circle me-1"></i>Tidak ada lampiran.</span>';
    }
    new bootstrap.Modal(document.getElementById('achievementModal')).show();
}

function switchTab(prefix, id, btn) {
    document.querySelectorAll('.ft-pane').forEach(el => el.style.display = 'none');
    document.querySelectorAll('#ft-tabs .tab-pill-btn').forEach(b => b.classList.remove('active'));
    var pane = document.getElementById(prefix + '-pane-' + id);
    if (pane) pane.style.display = '';
    btn.classList.add('active');
}
</script>

@endsection