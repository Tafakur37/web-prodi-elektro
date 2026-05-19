@extends('layouts.app')

@push('styles')
<style>
/* ====== DESIGN TOKENS ====== */
:root {
    --primary:       #0d9488; /* Teal for Staff signature */
    --primary-light: #F0FDFA;
    --primary-mid:   #99F6E4;
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

/* Base style reset inside dashboard content */
.dashboard-container {
    background: var(--bg);
    color: var(--text-primary);
}

/* ====== ANIMATIONS ====== */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.animated-fade {
    animation: fadeInUp 0.4s ease-out forwards;
    opacity: 0;
}
.delay-1 { animation-delay: 0.1s; }
.delay-2 { animation-delay: 0.2s; }
.delay-3 { animation-delay: 0.3s; }

/* ====== CARDS ====== */
.card-modern {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.card-modern:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.card-header-modern {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid var(--border);
    background: var(--surface);
}
.card-header-modern h5, .card-header-modern h6 {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.card-header-modern .header-icon {
    width: 28px; height: 28px;
    border-radius: var(--radius-sm);
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; flex-shrink: 0;
}
.card-body-modern { padding: 20px; }

/* ====== WELCOME BANNER ====== */
.welcome-banner {
    background: linear-gradient(135deg, #0d9488 0%, #14b8a6 50%, #5eead4 100%);
    border-radius: var(--radius-xl);
    padding: 24px 28px;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 20px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(20,184,166,0.25);
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
.welcome-banner h2 { font-size: 18px; font-weight: 700; margin: 0 0 4px; color: #ffffff !important; }
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

/* ====== TABS ====== */
.tab-pills-modern {
    display: flex;
    flex-wrap: nowrap !important;
    gap: 6px;
    overflow-x: auto;
    padding: 10px 20px;
    border-bottom: 1px solid var(--border);
}
.tab-pill-btn {
    padding: 6px 14px;
    border-radius: 20px;
    border: 1px solid var(--border);
    background: var(--bg);
    color: var(--text-secondary);
    font-size: 12px; font-weight: 600;
    cursor: pointer; transition: all .15s;
}
.tab-pill-btn.active, .tab-pill-btn:hover {
    background: var(--primary) !important;
    border-color: var(--primary) !important;
    color: #fff !important;
}

/* ====== STAT CARDS ====== */
.stat-card-modern {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-xl);
    padding: 20px;
    display: flex;
    align-items: center;
    box-shadow: var(--shadow-sm);
    transition: transform 0.2s, box-shadow 0.2s;
}
.stat-card-modern:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
}
.stat-icon {
    width: 48px; height: 48px;
    border-radius: var(--radius-md);
    display: flex; align-items: center; justify-content: center;
    font-size: 24px; flex-shrink: 0;
}

/* ====== SCHEDULE ITEMS ====== */
.schedule-item {
    border-left: 4px solid var(--primary);
    background: var(--bg);
    border: 1px solid var(--border);
    border-left: 4px solid var(--primary);
    border-radius: var(--radius-lg);
    padding: 16px;
    margin-bottom: 12px;
    transition: transform 0.2s, box-shadow 0.2s;
}
.schedule-item:hover {
    transform: translateX(4px);
    box-shadow: var(--shadow-sm);
}

/* ====== TABLES ====== */
.table-modern { width: 100%; border-collapse: collapse; font-size: 13px; }
.table-modern thead tr { background: var(--bg); }
.table-modern th { padding: 10px 14px; text-align: left; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-muted); border-bottom: 1px solid var(--border); }
.table-modern td { padding: 11px 14px; border-bottom: 1px solid var(--border); color: var(--text-primary); vertical-align: middle; }
.table-modern tbody tr:last-child td { border-bottom: none; }
.table-modern tbody tr:hover { background: var(--bg); }

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

.list-group-custom .list-group-item {
    border: none;
    border-bottom: 1px solid var(--border);
    padding: 16px 20px;
    transition: background 0.15s;
}
.list-group-custom .list-group-item:hover {
    background: var(--primary-light);
}
.list-group-custom .list-group-item:last-child {
    border-bottom: none;
}
</style>
@endpush

@section('content')
<div class="container-fluid p-0 dashboard-container">
    
    <!-- Welcome Section Banner -->
    <div class="welcome-banner mb-4 animated-fade">
        <div class="welcome-icon"><i class="bi bi-shield-lock-fill text-white"></i></div>
        <div>
            <h2>Dashboard Staff Prodi</h2>
            <p>Selamat datang, <strong>{{ $staff->name }}</strong> — Kelola data program studi elektro, pantau jadwal kuliah harian, pengumuman, dan notifikasi.</p>
        </div>
        <div class="date-chip">
            <i class="bi bi-calendar3 me-2"></i> {{ $dayIndo }}, {{ \Carbon\Carbon::today()->translatedFormat('d F Y') }}
        </div>
    </div>

    <!-- STATISTIK -->
    <div class="row g-4 mb-4 animated-fade delay-1">
        <div class="col-md-4">
            <div class="stat-card-modern h-100">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-person-video3"></i>
                </div>
                <div class="ms-3">
                    <h6 class="text-muted mb-1 fw-semibold" style="font-size: 12px;">Total Dosen</h6>
                    <h2 class="mb-0 fw-bold text-dark">{{ $dosenCount }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card-modern h-100">
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-people"></i>
                </div>
                <div class="ms-3">
                    <h6 class="text-muted mb-1 fw-semibold" style="font-size: 12px;">Total Mahasiswa</h6>
                    <h2 class="mb-0 fw-bold text-dark">{{ $mahasiswaCount }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card-modern h-100">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-diagram-3"></i>
                </div>
                <div class="ms-3">
                    <h6 class="text-muted mb-1 fw-semibold" style="font-size: 12px;">Jumlah Cohort Aktif</h6>
                    <h2 class="mb-0 fw-bold text-dark">{{ $cohortCount }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- JADWAL KULIAH HARI INI -->
        <div class="col-lg-8 animated-fade delay-2">
            <div class="card-modern h-100">
                <div class="card-header-modern">
                    <h6>
                        <span class="header-icon" style="background:var(--info-light);color:var(--info);">
                            <i class="bi bi-clock-history"></i>
                        </span>
                        Jadwal Kuliah Hari Ini
                    </h6>
                    <span class="badge-pill info">Hari Ini</span>
                </div>
                <div class="card-body-modern">
                    @forelse($todaySchedules as $cohort => $schedules)
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary mb-3" style="font-size: 13px;"><i class="bi bi-collection me-2"></i> Angkatan / Cohort: {{ $cohort ?? 'Lainnya' }}</h6>
                            <div class="list-group list-group-flush">
                                @foreach($schedules as $schedule)
                                    <div class="schedule-item">
                                        <div class="d-flex w-100 justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="me-3 text-center border-end pe-3" style="min-width: 70px;">
                                                    <div class="fw-bold text-dark" style="font-size: 14px;">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</div>
                                                    <div class="small text-muted" style="font-size: 11px;">{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</div>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1 fw-bold text-dark" style="font-size: 13px;">{{ $schedule->subject->name ?? 'Mata Kuliah' }}</h6>
                                                    <p class="mb-0 small text-muted" style="font-size: 12px;">
                                                        <i class="bi bi-person me-1"></i> {{ $schedule->dosen->name ?? 'Belum ada dosen' }} | 
                                                        <i class="bi bi-geo-alt me-1"></i> Ruang {{ $schedule->room ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486831.png" alt="No Schedule" style="width: 80px; opacity: 0.3;" class="mb-3">
                            <h6 class="text-muted fw-bold">Tidak ada jadwal kuliah hari ini</h6>
                            <p class="text-muted small" style="font-size: 12px;">Semua kelas per cohort sedang kosong.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- PENGUMUMAN & NOTIFIKASI -->
        <div class="col-lg-4 animated-fade delay-2">
            <div class="row g-4">
                <!-- Pengumuman -->
                <div class="col-12">
                    <div class="card-modern">
                        <div class="card-header-modern">
                            <h6>
                                <span class="header-icon" style="background:var(--warning-light);color:var(--warning);">
                                    <i class="bi bi-megaphone"></i>
                                </span>
                                Pengumuman Prodi
                            </h6>
                        </div>
                        <div class="card-body-modern p-0">
                            <ul class="list-group list-group-flush list-group-custom">
                                @forelse($announcements as $announcement)
                                    <li class="list-group-item border-0 py-3 px-4 hover-bg-light">
                                        <div class="d-flex w-100 justify-content-between mb-1">
                                            <h6 class="mb-0 fw-bold text-dark" style="font-size: 13px;">{{ $announcement->title }}</h6>
                                            <small class="text-muted" style="font-size: 10px;">{{ $announcement->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-1 small text-muted text-truncate" style="font-size: 12px;">{{ Str::limit($announcement->message, 80) }}</p>
                                        <span class="badge-pill muted" style="font-size: 9px;">Target: {{ ucfirst($announcement->target_role) }}</span>
                                    </li>
                                @empty
                                    <li class="list-group-item border-0 py-4 text-center text-muted">
                                        Belum ada pengumuman disiarkan.
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="card-footer bg-white border-top-0 text-center pb-3">
                            <a href="{{ route('staff.announcements.index') }}" class="text-decoration-none small fw-bold text-primary">Kelola Pengumuman <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Notifikasi -->
                <div class="col-12">
                    <div class="card-modern">
                        <div class="card-header-modern">
                            <h6>
                                <span class="header-icon" style="background:var(--danger-light);color:var(--danger);">
                                    <i class="bi bi-bell"></i>
                                </span>
                                Notifikasi Sistem
                            </h6>
                        </div>
                        <div class="card-body-modern p-0">
                            <ul class="list-group list-group-flush list-group-custom">
                                @forelse($notifications as $notif)
                                    <li class="list-group-item border-0 py-3 px-4 {{ $notif->read_at === null ? 'bg-light' : '' }}">
                                        <div class="d-flex w-100 justify-content-between mb-1">
                                            <h6 class="mb-0 fw-bold {{ $notif->read_at === null ? 'text-primary' : 'text-dark' }}" style="font-size: 13px;">{{ $notif->data['title'] ?? 'Notifikasi' }}</h6>
                                            <small class="text-muted" style="font-size: 10px;">{{ $notif->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-0 small text-muted" style="font-size: 12px;">{{ $notif->data['message'] ?? 'Tidak ada pesan' }}</p>
                                    </li>
                                @empty
                                    <li class="list-group-item border-0 py-4 text-center text-muted">
                                        Tidak ada notifikasi baru.
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- JADWAL MINGGUAN PER COHORT -->
        <div class="row mt-4">
            <div class="col-12 animated-fade delay-3">
                <div class="card-modern">
                    <div class="card-header-modern">
                        <h6>
                            <span class="header-icon" style="background:var(--primary-light);color:var(--primary);">
                                <i class="bi bi-calendar-week"></i>
                            </span>
                            Jadwal Mingguan Per Cohort
                        </h6>
                    </div>
                    <div class="card-body-modern">
                        <div class="tab-pills-modern mb-4 px-0 border-bottom-0 nav" role="tablist">
                            @foreach($weeklySchedules as $cohort => $schedules)
                                <button class="tab-pill-btn {{ $loop->first ? 'active' : '' }}" 
                                        id="pills-cohort-{{ $cohort }}-tab" 
                                        data-bs-toggle="pill" 
                                        data-bs-target="#pills-cohort-{{ $cohort }}" 
                                        type="button" role="tab" 
                                        aria-controls="pills-cohort-{{ $cohort }}" 
                                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                    {{ $cohort }}
                                </button>
                            @endforeach
                        </div>

                        <div class="tab-content" id="pills-tabContent-weekly">
                            @forelse($weeklySchedules as $cohort => $schedules)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                                     id="pills-cohort-{{ $cohort }}" 
                                     role="tabpanel" 
                                     aria-labelledby="pills-cohort-{{ $cohort }}-tab">
                                     
                                    <div class="table-responsive" style="border-radius: var(--radius-lg); border: 1px solid var(--border); overflow: hidden;">
                                        <table class="table-modern">
                                            <thead>
                                                <tr>
                                                    <th class="ps-3">Hari</th>
                                                    <th>Waktu</th>
                                                    <th>Mata Kuliah</th>
                                                    <th>Dosen Pengampu</th>
                                                    <th>Ruang</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $schedulesByDay = collect($schedules)->groupBy('day');
                                                @endphp
                                                @forelse($schedulesByDay as $day => $daySchedules)
                                                    @foreach($daySchedules as $index => $schedule)
                                                        <tr>
                                                            @if($index == 0)
                                                                <td rowspan="{{ count($daySchedules) }}" class="ps-3 fw-bold text-primary align-middle border-end bg-light">{{ $day }}</td>
                                                            @endif
                                                            <td>
                                                                <span class="badge-pill muted border"><i class="bi bi-clock me-1"></i> {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</span>
                                                            </td>
                                                            <td class="fw-bold text-dark">{{ $schedule->subject->name ?? 'Mata Kuliah Tidak Ditemukan' }}</td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar-circle bg-primary text-white d-flex justify-content-center align-items-center rounded-circle me-2" style="width: 30px; height: 30px; font-weight: bold; font-size: 12px;">
                                                                        {{ substr($schedule->dosen->name ?? '?', 0, 1) }}
                                                                    </div>
                                                                    <span class="text-dark">{{ $schedule->dosen->name ?? 'Belum ada dosen' }}</span>
                                                                </div>
                                                            </td>
                                                            <td><span class="badge-pill info"><i class="bi bi-geo-alt me-1"></i> {{ $schedule->room ?? '-' }}</span></td>
                                                        </tr>
                                                    @endforeach
                                                @empty
                                                    <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada jadwal untuk cohort ini.</td></tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5 text-muted">Belum ada data jadwal sama sekali.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- KOTAK SARAN MAHASISWA -->
    <div class="row mt-4">
        <div class="col-12 animated-fade delay-3">
            @include('components.suggestion-card')
        </div>
    </div>

</div>
@endsection