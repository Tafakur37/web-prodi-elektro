@extends('layouts.app')

@push('styles')
<style>
.dashboard-header {
    background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
    border-radius: 15px;
    color: white;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
}

.dashboard-header::after {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 300px;
    height: 300px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

.card-stats {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s ease;
    height: 100%;
}

.card-stats:hover {
    transform: translateY(-5px);
}

.card-title-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    font-size: 1.2rem;
    margin-bottom: 15px;
}

.schedule-item {
    border-left: 4px solid #3498db;
    padding-left: 15px;
    margin-bottom: 15px;
    background: #f8f9fa;
    padding: 15px;
    border-radius: 0 10px 10px 0;
}

.list-group-custom .list-group-item {
    border: none;
    border-bottom: 1px solid #f1f1f1;
    padding: 15px 20px;
    margin-bottom: 0;
    border-radius: 0;
}

.list-group-custom .list-group-item:last-child {
    border-bottom: none;
}

.announcement-card {
    border-left: 4px solid #f39c12;
}

.custom-schedule-tab.nav-link {
    color: #6c757d;
    border-bottom: 3px solid transparent !important;
    transition: all 0.2s;
}

.custom-schedule-tab.nav-link:hover {
    color: #0d6efd;
}

.custom-schedule-tab.nav-link.active {
    color: #0d6efd !important;
    border-bottom: 3px solid #0d6efd !important;
}
</style>
@endpush

@section('content')
<div class="container-fluid p-0">

    <!-- Welcome Section -->
    <div class="dashboard-header mb-4">
        <h2 class="fw-bold mb-2">Selamat Datang, {{ $dosen->name }}</h2>
        <p class="mb-0 text-white-50"><i class="bi bi-person-badge me-2"></i>NIP: {{ $dosen->nip ?? '-' }} | Dosen
            Teknik Elektro</p>
    </div>

    <div class="row g-4 mb-4">
        <!-- Jadwal Mengajar -->
        <div class="col-lg-8">
            <div class="card card-custom h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title fw-bold mb-0 text-dark">
                        <i class="bi bi-calendar-week text-primary me-2"></i> Jadwal Mengajar
                    </h5>
                </div>

                <!-- TABS -->
                <div class="px-3 border-bottom">
                    <ul class="nav nav-tabs border-0" id="scheduleTab" role="tablist">
                        @php
                        $daysMap = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                        $todayIndo =
                        ['Sunday'=>'Minggu','Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu'][\Carbon\Carbon::today()->format('l')];
                        // Default tab is today, or Monday if today is Sunday
                        $activeTab = in_array($todayIndo, $daysMap) ? $todayIndo : 'Senin';
                        @endphp
                        @foreach($daysMap as $day)
                        <li class="nav-item" role="presentation">
                            <button
                                class="nav-link custom-schedule-tab border-0 fw-bold {{ $activeTab == $day ? 'active' : '' }}"
                                id="tab-{{ strtolower($day) }}" data-bs-toggle="tab"
                                data-bs-target="#pane-{{ strtolower($day) }}" type="button" role="tab"
                                style="background: transparent;">
                                {{ $day }}
                                @if(isset($weeklySchedules[$day]) && count($weeklySchedules[$day]) > 0)
                                <span class="badge bg-primary rounded-pill ms-1"
                                    style="font-size: 0.6rem;">{{ count($weeklySchedules[$day]) }}</span>
                                @endif
                            </button>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="card-body pt-3">
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
                                        <h6 class="fw-bold mb-1">{{ $schedule->subject->name ?? 'Mata Kuliah' }}</h6>
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
        <div class="col-lg-4">
            <div class="card card-custom h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title fw-bold mb-0 text-dark">
                        <i class="bi bi-people-fill text-success me-2"></i> Request Bimbingan
                    </h5>
                    @if(count($bimbingan ?? []) > 0)
                    <span class="badge bg-success rounded-pill">{{ count($bimbingan) }} Baru</span>
                    @endif
                </div>
                <ul class="list-group list-group-flush list-group-custom">
                    @forelse($bimbingan ?? [] as $bimb)
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1 fw-bold">{{ $bimb->student->name ?? 'Mahasiswa' }}</h6>
                                <p class="mb-1 small text-muted"><i class="bi bi-calendar3 me-1"></i>
                                    {{ \Carbon\Carbon::parse($bimb->requested_date)->format('d M Y') }}</p>
                                <span
                                    class="badge bg-light text-dark border mt-1">{{ $bimb->topic ?? 'Bimbingan Akademik' }}</span>
                            </div>
                            <a href="{{ route('dosen.meetings.index') }}"
                                class="btn btn-sm btn-light border text-primary">Lihat</a>
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
                    <a href="{{ route('dosen.meetings.index') }}" class="text-decoration-none small fw-bold">Lihat Semua
                        Request <i class="bi bi-arrow-right"></i></a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Jadwal Ujian -->
        <div class="col-lg-6">
            <div class="card card-custom h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title fw-bold mb-0 text-dark">
                        <i class="bi bi-file-earmark-text text-danger me-2"></i> Jadwal Ujian Mendatang
                    </h5>
                </div>
                <div class="card-body pt-0">
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
                                    <h6 class="fw-bold mb-1">{{ $exam->subject->name ?? '-' }}</h6>
                                    <span
                                        class="badge bg-light text-dark border mb-2">{{ $exam->type ?? 'Ujian' }}</span>
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
        <div class="col-lg-6">
            <div class="card card-custom mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title fw-bold mb-0 text-dark">
                        <i class="bi bi-megaphone text-warning me-2"></i> Pengumuman Prodi
                    </h5>
                </div>
                <div class="card-body pt-0">
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

            <div class="card card-custom">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title fw-bold mb-0 text-dark">
                        <i class="bi bi-bar-chart-steps text-info me-2"></i> Ringkasan Kelas Mingguan
                    </h5>
                </div>
                <div class="card-body pt-0">
                    <div class="d-flex justify-content-between mb-2">
                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $hari)
                        <div class="text-center">
                            <div class="small fw-bold text-muted mb-1">{{ substr($hari, 0, 3) }}</div>
                            <div class="badge {{ isset($weeklySchedules[$hari]) ? 'bg-info' : 'bg-light text-secondary border' }} rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 35px; height: 35px;">
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