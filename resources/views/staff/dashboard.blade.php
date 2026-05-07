@extends('layouts.app')

@push('styles')
<style>
    .stat-card {
        transition: transform 0.2s, box-shadow 0.2s;
        border-left: 4px solid;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }
    .stat-card-primary { border-left-color: #0d6efd; }
    .stat-card-success { border-left-color: #198754; }
    .stat-card-warning { border-left-color: #ffc107; }
    .schedule-item { border-left: 3px solid #0dcaf0; }
</style>
@endpush

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Dashboard Staff Prodi</h3>
            <p class="text-muted mb-0">Selamat datang, {{ $staff->name }}</p>
        </div>
        <div>
            <span class="badge bg-primary px-3 py-2 fs-6 rounded-pill">
                <i class="bi bi-calendar3 me-2"></i> {{ $dayIndo }}, {{ \Carbon\Carbon::today()->translatedFormat('d F Y') }}
            </span>
        </div>
    </div>

    <!-- STATISTIK -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card stat-card stat-card-primary h-100 border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-3 text-primary">
                        <i class="bi bi-person-video3 fs-1"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1 fw-semibold">Total Dosen</h6>
                        <h2 class="mb-0 fw-bold">{{ $dosenCount }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card stat-card-success h-100 border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 bg-success bg-opacity-10 p-3 rounded-3 text-success">
                        <i class="bi bi-people fs-1"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1 fw-semibold">Total Mahasiswa</h6>
                        <h2 class="mb-0 fw-bold">{{ $mahasiswaCount }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card stat-card-warning h-100 border-0 shadow-sm">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 bg-warning bg-opacity-10 p-3 rounded-3 text-warning">
                        <i class="bi bi-diagram-3 fs-1"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1 fw-semibold">Jumlah Cohort Aktif</h6>
                        <h2 class="mb-0 fw-bold">{{ $cohortCount }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- JADWAL KULIAH HARI INI -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-2 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0"><i class="bi bi-clock-history text-info me-2"></i> Jadwal Kuliah Hari Ini</h5>
                </div>
                <div class="card-body">
                    @forelse($todaySchedules as $cohort => $schedules)
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary mb-3"><i class="bi bi-collection me-2"></i> Angkatan / Cohort: {{ $cohort ?? 'Lainnya' }}</h6>
                            <div class="list-group list-group-flush">
                                @foreach($schedules as $schedule)
                                    <div class="list-group-item schedule-item bg-light border-0 mb-2 rounded-3">
                                        <div class="d-flex w-100 justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="me-3 text-center" style="min-width: 60px;">
                                                    <div class="fw-bold text-dark">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</div>
                                                    <div class="small text-muted">{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</div>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1 fw-bold">{{ $schedule->subject->name ?? 'Mata Kuliah' }}</h6>
                                                    <p class="mb-0 small text-muted">
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
                            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486831.png" alt="No Schedule" style="width: 100px; opacity: 0.5;" class="mb-3">
                            <h5 class="text-muted fw-bold">Tidak ada jadwal kuliah hari ini</h5>
                            <p class="text-muted small">Semua kelas per cohort sedang kosong.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- PENGUMUMAN & NOTIFIKASI -->
        <div class="col-lg-4">
            <div class="row g-4">
                <!-- Pengumuman -->
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom-0 pt-4 pb-2">
                            <h5 class="fw-bold mb-0"><i class="bi bi-megaphone text-warning me-2"></i> Pengumuman Prodi</h5>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @forelse($announcements as $announcement)
                                    <li class="list-group-item border-0 py-3 px-4 hover-bg-light">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1 fw-bold text-dark">{{ $announcement->title }}</h6>
                                            <small class="text-muted">{{ $announcement->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-1 small text-muted text-truncate">{{ Str::limit($announcement->message, 80) }}</p>
                                        <small class="badge bg-secondary-subtle text-secondary rounded-pill">Target: {{ ucfirst($announcement->target_role) }}</small>
                                    </li>
                                @empty
                                    <li class="list-group-item border-0 py-4 text-center text-muted">
                                        Belum ada pengumuman disiarkan.
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="card-footer bg-white border-top-0 text-center pb-3">
                            <a href="{{ route('staff.announcements.index') }}" class="text-decoration-none small fw-bold">Kelola Pengumuman <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Notifikasi -->
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom-0 pt-4 pb-2">
                            <h5 class="fw-bold mb-0"><i class="bi bi-bell text-danger me-2"></i> Notifikasi Sistem</h5>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @forelse($notifications as $notif)
                                    <li class="list-group-item border-0 py-3 px-4 {{ $notif->read_at === null ? 'bg-light' : '' }}">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1 fw-bold {{ $notif->read_at === null ? 'text-primary' : 'text-dark' }}">{{ $notif->data['title'] ?? 'Notifikasi' }}</h6>
                                            <small class="text-muted" style="font-size: 0.7rem;">{{ $notif->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-0 small text-muted">{{ $notif->data['message'] ?? 'Tidak ada pesan' }}</p>
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
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-2">
                        <h5 class="fw-bold mb-0"><i class="bi bi-calendar-week text-primary me-2"></i> Jadwal Mingguan Per Cohort</h5>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-pills mb-4" id="pills-tab-weekly" role="tablist">
                            @foreach($weeklySchedules as $cohort => $schedules)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $loop->first ? 'active' : '' }} rounded-pill me-2 px-4 fw-bold" 
                                            id="pills-cohort-{{ $cohort }}-tab" 
                                            data-bs-toggle="pill" 
                                            data-bs-target="#pills-cohort-{{ $cohort }}" 
                                            type="button" role="tab" 
                                            aria-controls="pills-cohort-{{ $cohort }}" 
                                            aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                        {{ $cohort }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>

                        <div class="tab-content" id="pills-tabContent-weekly">
                            @forelse($weeklySchedules as $cohort => $schedules)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                                     id="pills-cohort-{{ $cohort }}" 
                                     role="tabpanel" 
                                     aria-labelledby="pills-cohort-{{ $cohort }}-tab">
                                     
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead class="bg-light text-muted small text-uppercase fw-bold">
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
                                                                <span class="badge bg-light text-dark border"><i class="bi bi-clock me-1"></i> {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</span>
                                                            </td>
                                                            <td class="fw-bold">{{ $schedule->subject->name ?? 'Mata Kuliah Tidak Ditemukan' }}</td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="avatar-circle bg-primary text-white d-flex justify-content-center align-items-center rounded-circle me-2" style="width: 30px; height: 30px; font-weight: bold; font-size: 12px;">
                                                                        {{ substr($schedule->dosen->name ?? '?', 0, 1) }}
                                                                    </div>
                                                                    <span>{{ $schedule->dosen->name ?? 'Belum ada dosen' }}</span>
                                                                </div>
                                                            </td>
                                                            <td><span class="badge bg-info text-dark"><i class="bi bi-geo-alt me-1"></i> {{ $schedule->room ?? '-' }}</span></td>
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
        <div class="col-12">
            @include('components.suggestion-card')
        </div>
    </div>

</div>
@endsection