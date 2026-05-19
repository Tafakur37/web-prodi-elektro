@extends('layouts.app')

@push('styles')
<style>
/* ====== DESIGN TOKENS ====== */
:root {
    --primary:       #0284C7; /* Sky/Blue for Dosen signature */
    --primary-light: #F0F9FF;
    --primary-mid:   #BAE6FD;
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
    background: linear-gradient(135deg, #0284C7 0%, #0ea5e9 50%, #38bdf8 100%);
    border-radius: var(--radius-xl);
    padding: 24px 28px;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 20px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(14,165,233,0.25);
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

.announcement-card {
    border-left: 4px solid var(--warning);
    border: 1px solid var(--border);
    border-left: 4px solid var(--warning);
    transition: all 0.2s;
}
.announcement-card:hover {
    transform: translateX(4px);
    background: var(--warning-light) !important;
}

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

/* Weekly grid summary */
.weekly-summary-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 8px;
}
.weekly-summary-item {
    text-align: center;
    padding: 10px;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
}
</style>
@endpush

@section('content')
<div class="container-fluid p-0 dashboard-container">

    <!-- Welcome Section -->
    <div class="welcome-banner mb-4 animated-fade">
        <div class="welcome-icon"><i class="bi bi-person-badge-fill text-white"></i></div>
        <div>
            <h2>Selamat Datang, {{ $dosen->name }}</h2>
            <p>NIP: {{ $dosen->nip ?? '-' }} | Dosen Teknik Elektro — Kelola jadwal mengajar, bimbingan, dan ujian Anda.</p>
        </div>
        <div class="date-chip">
            <i class="bi bi-calendar3 me-1"></i>
            {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Jadwal Mengajar -->
        <div class="col-lg-8 animated-fade delay-1">
            <div class="card-modern h-100">
                <div class="card-header-modern">
                    <h6>
                        <span class="header-icon" style="background:var(--primary-light);color:var(--primary);">
                            <i class="bi bi-calendar-week"></i>
                        </span>
                        Jadwal Mengajar
                    </h6>
                    <span class="badge-pill primary">Hari Ini &amp; Mingguan</span>
                </div>

                <!-- TABS -->
                <div class="tab-pills-modern nav" role="tablist">
                    @php
                    $daysMap = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    $todayIndo =
                    ['Sunday'=>'Minggu','Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu'][\Carbon\Carbon::today()->format('l')];
                    // Default tab is today, or Monday if today is Sunday
                    $activeTab = in_array($todayIndo, $daysMap) ? $todayIndo : 'Senin';
                    @endphp
                    @foreach($daysMap as $day)
                    <button
                        class="tab-pill-btn {{ $activeTab == $day ? 'active' : '' }}"
                        id="tab-{{ strtolower($day) }}" data-bs-toggle="tab"
                        data-bs-target="#pane-{{ strtolower($day) }}" type="button" role="tab">
                        {{ $day }}
                        @if(isset($weeklySchedules[$day]) && count($weeklySchedules[$day]) > 0)
                        <span class="badge bg-white text-primary rounded-pill ms-1"
                            style="font-size: 0.65rem;">{{ count($weeklySchedules[$day]) }}</span>
                        @endif
                    </button>
                    @endforeach
                </div>

                <div class="card-body-modern">
                    <div class="tab-content" id="scheduleTabContent">
                        @foreach($daysMap as $day)
                        <div class="tab-pane fade {{ $activeTab == $day ? 'show active' : '' }}"
                            id="pane-{{ strtolower($day) }}" role="tabpanel">
                            @if(isset($weeklySchedules[$day]) && count($weeklySchedules[$day]) > 0)
                            @foreach($weeklySchedules[$day] as $schedule)
                            <div class="schedule-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="text-center pe-3 me-3 border-end" style="min-width: 80px;">
                                        <h5 class="fw-bold mb-0 text-dark">
                                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</h5>
                                        <small
                                            class="text-muted">{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</small>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1 text-dark">{{ $schedule->subject->name ?? 'Mata Kuliah' }}</h6>
                                        <div class="text-muted small">
                                            <span class="me-3"><i class="bi bi-calendar me-1"></i> {{ $day }}</span>
                                            <span class="me-3"><i class="bi bi-geo-alt me-1"></i> Ruang
                                                {{ $schedule->room ?? '-' }}</span>
                                            <span><i class="bi bi-people me-1"></i> Angkatan
                                                {{ $schedule->cohort ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    @if($day == $todayIndo)
                                    <a href="{{ route('dosen.attendances.index', ['subject_id' => $schedule->subject_id, 'cohort' => $schedule->cohort, 'date' => date('Y-m-d')]) }}"
                                        class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold">
                                        Absen Kelas
                                    </a>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="text-center py-5">
                                <div class="bg-light rounded-circle d-inline-flex p-3 mb-3">
                                    <i class="bi bi-cup-hot text-secondary fs-1"></i>
                                </div>
                                <h6 class="text-secondary">Tidak ada jadwal pada hari {{ $day }}.</h6>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Request Bimbingan -->
        <div class="col-lg-4 animated-fade delay-2">
            <div class="card-modern h-100">
                <div class="card-header-modern">
                    <h6>
                        <span class="header-icon" style="background:var(--success-light);color:var(--success);">
                            <i class="bi bi-people-fill"></i>
                        </span>
                        Request Bimbingan
                    </h6>
                    @if(count($bimbingan ?? []) > 0)
                    <span class="badge-pill success">{{ count($bimbingan) }} Baru</span>
                    @endif
                </div>
                <ul class="list-group list-group-flush list-group-custom">
                    @forelse($bimbingan ?? [] as $bimb)
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1 fw-bold text-dark">{{ $bimb->student->name ?? 'Mahasiswa' }}</h6>
                                <p class="mb-1 small text-muted"><i class="bi bi-calendar3 me-1"></i>
                                    {{ \Carbon\Carbon::parse($bimb->requested_date)->format('d M Y') }}</p>
                                <span
                                    class="badge-pill muted border mt-1">{{ $bimb->topic ?? 'Bimbingan Akademik' }}</span>
                            </div>
                            <a href="{{ route('dosen.meetings.index') }}"
                                class="btn btn-sm btn-light border text-primary fw-bold rounded-pill">Lihat</a>
                        </div>
                    </li>
                    @empty
                    <li class="list-group-item text-center py-4 text-muted border-0">
                        Tidak ada request bimbingan baru.
                    </li>
                    @endforelse
                </ul>
                @if(count($bimbingan ?? []) > 0)
                <div class="card-footer bg-white text-center border-0 pb-3">
                    <a href="{{ route('dosen.meetings.index') }}" class="text-decoration-none small fw-bold text-primary">Lihat Semua
                        Request <i class="bi bi-arrow-right"></i></a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Jadwal Ujian -->
        <div class="col-lg-6 animated-fade delay-2">
            <div class="card-modern h-100">
                <div class="card-header-modern">
                    <h6>
                        <span class="header-icon" style="background:var(--danger-light);color:var(--danger);">
                            <i class="bi bi-file-earmark-text"></i>
                        </span>
                        Jadwal Ujian Mendatang
                    </h6>
                </div>
                <div class="card-body-modern">
                    <div class="row g-3">
                        @forelse($exams ?? [] as $exam)
                        <div class="col-12">
                            <div class="d-flex p-3 border rounded-3 align-items-center bg-white shadow-sm">
                                <div class="bg-danger-subtle text-danger p-3 rounded-3 text-center me-3"
                                    style="min-width: 70px;">
                                    <div class="fs-4 fw-bold lh-1">{{ \Carbon\Carbon::parse($exam->date)->format('d') }}
                                    </div>
                                    <div class="small text-uppercase">
                                        {{ \Carbon\Carbon::parse($exam->date)->format('M') }}</div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1 text-dark">{{ $exam->subject->name ?? '-' }}</h6>
                                    <span
                                        class="badge-pill muted border mb-2">{{ $exam->type ?? 'Ujian' }}</span>
                                    <div class="small text-muted d-flex">
                                        <span class="me-3"><i class="bi bi-clock me-1"></i>
                                            {{ \Carbon\Carbon::parse($exam->start_time)->format('H:i') }} -
                                            {{ \Carbon\Carbon::parse($exam->end_time)->format('H:i') }}</span>
                                        <span><i class="bi bi-geo-alt me-1"></i> Ruang {{ $exam->room ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-4 text-muted">
                            Belum ada jadwal ujian terdekat.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengumuman & Ringkasan Mingguan -->
        <div class="col-lg-6 animated-fade delay-3">
            <div class="card-modern mb-4">
                <div class="card-header-modern">
                    <h6>
                        <span class="header-icon" style="background:var(--warning-light);color:var(--warning);">
                            <i class="bi bi-megaphone"></i>
                        </span>
                        Pengumuman Prodi
                    </h6>
                </div>
                <div class="card-body-modern">
                    @forelse($announcements ?? [] as $announcement)
                    <a href="javascript:void(0)"
                        class="announcement-card bg-light p-3 rounded-3 mb-2 d-block text-decoration-none"
                        onclick="showAnnouncement('{{ addslashes($announcement->title) }}', '{{ addslashes($announcement->message) }}', '{{ $announcement->created_at->format('d M Y, H:i') }}')">
                        <h6 class="fw-bold mb-1 text-dark">{{ $announcement->title }}</h6>
                        <p class="small text-muted mb-1 text-truncate">{{ $announcement->message }}</p>
                        <small class="text-secondary"
                            style="font-size: 0.7rem;">{{ $announcement->created_at->diffForHumans() }}</small>
                    </a>
                    @empty
                    <div class="text-center py-3 text-muted">
                        Tidak ada pengumuman.
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="card-modern">
                <div class="card-header-modern">
                    <h6>
                        <span class="header-icon" style="background:var(--info-light);color:var(--info);">
                            <i class="bi bi-bar-chart-steps"></i>
                        </span>
                        Ringkasan Kelas Mingguan
                    </h6>
                </div>
                <div class="card-body-modern">
                    <div class="weekly-summary-grid">
                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $hari)
                        <div class="weekly-summary-item">
                            <div class="small fw-bold text-muted mb-2">{{ substr($hari, 0, 3) }}</div>
                            <div class="badge {{ isset($weeklySchedules[$hari]) ? 'bg-primary' : 'bg-light text-secondary border' }} rounded-circle d-inline-flex align-items-center justify-content-center"
                                style="width: 32px; height: 32px; font-size: 11px;">
                                {{ isset($weeklySchedules[$hari]) ? count($weeklySchedules[$hari]) : '0' }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- MODAL PENGUMUMAN -->
<div class="modal fade" id="announcementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0 pb-0 p-4">
                <h5 class="modal-title fw-bold text-dark" id="announcementModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pb-2 pt-2">
                <small class="text-muted d-block mb-3" id="announcementModalDate"></small>
                <div class="bg-light rounded-3 p-4" id="announcementModalBody"
                    style="white-space: pre-wrap; line-height: 1.7;"></div>
            </div>
            <div class="modal-footer border-0 pt-0 p-4">
                <button type="button" class="btn btn-light rounded-pill px-4 fw-bold"
                    data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
function showAnnouncement(title, message, date) {
    document.getElementById('announcementModalTitle').textContent = title;
    document.getElementById('announcementModalBody').textContent = message;
    document.getElementById('announcementModalDate').innerHTML = '<i class="bi bi-calendar3 me-1"></i> ' + date;
    var modal = new bootstrap.Modal(document.getElementById('announcementModal'));
    modal.show();
}
</script>

@endsection