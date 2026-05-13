@extends('layouts.app')

@section('title', 'Academic Dashboard')

@section('content')
<div class="container-fluid px-0">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> Terdapat kesalahan pada input Anda.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row g-4">
        <!-- WELCOME BANNER -->
        <div class="col-12">
            <div class="alert alert-primary border-0 rounded-4 shadow-sm mb-0 p-4">
                <div class="d-flex align-items-center">
                    <i class="bi bi-mortarboard-fill fs-2 me-4 text-primary bg-white rounded-circle p-3 shadow-sm"></i>
                    <div>
                        <h5 class="fw-bold mb-1 text-primary">Portal Akademik Mahasiswa</h5>
                        <p class="mb-0 text-secondary">Selamat datang, <strong>{{ auth()->user()->name }}</strong>.
                            Pantau jadwal, akademik, dan aktivitas Anda di sini.</p>
                    </div>
                </div>
            </div>
        </div>

        @php
        $todayData = collect($weeklySchedules)->first(function ($dayData) {
        return $dayData['date']->isToday();
        });
        @endphp

        <!-- KOLOM KIRI (70%): AKTIVITAS UTAMA -->
        <div class="col-lg-8">

            <!-- 1. JADWAL KULIAH -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div
                    class="card-header bg-white border-bottom border-light pt-4 pb-3 px-4 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-calendar-week text-primary me-2"></i> Jadwal
                        Perkuliahan</h6>
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">Minggu Ini</span>
                </div>
                <div class="card-body p-4">
                    <!-- Hari Ini -->
                    <h6 class="fw-bold text-secondary mb-3 small text-uppercase">Jadwal Hari Ini
                        ({{ \Carbon\Carbon::now()->format('d M') }})</h6>
                    @if($todayData && $todayData['schedules']->isNotEmpty())
                    <div class="row g-3 mb-4">
                        @foreach($todayData['schedules'] as $schedule)
                        <div class="col-md-6">
                            <div
                                class="border-start border-4 {{ $schedule->is_overridden ? ($schedule->override_status === 'cancelled' ? 'border-danger bg-danger bg-opacity-10' : 'border-warning bg-warning bg-opacity-10') : 'border-primary bg-light' }} p-3 rounded-end h-100">
                                <h6
                                    class="fw-bold mb-1 {{ $schedule->is_overridden && $schedule->override_status === 'cancelled' ? 'text-decoration-line-through text-danger' : 'text-dark' }}">
                                    {{ $schedule->subject->name }}
                                </h6>
                                <div
                                    class="small text-secondary mb-2 {{ $schedule->is_overridden && $schedule->override_status === 'cancelled' ? 'text-decoration-line-through text-danger opacity-50' : '' }}">
                                    <i class="bi bi-person me-2"></i> {{ $schedule->dosen->name }}
                                </div>
                                <div
                                    class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top border-secondary border-opacity-25 small {{ $schedule->is_overridden && $schedule->override_status === 'cancelled' ? 'text-decoration-line-through text-danger' : 'text-secondary' }}">
                                    <span><i class="bi bi-clock me-1"></i>
                                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</span>
                                    <span><i class="bi bi-geo-alt me-1"></i> {{ $schedule->room }}</span>
                                </div>
                                @if($schedule->is_overridden)
                                <div class="mt-2 text-danger small fw-bold">
                                    @if($schedule->override_status === 'cancelled')
                                    <i class="bi bi-x-circle-fill"></i> DIBATALKAN
                                    @else
                                    <i class="bi bi-exclamation-triangle-fill"></i> PERUBAHAN JADWAL
                                    @endif
                                    @if($schedule->override_note) <span
                                        class="d-block fw-normal fst-italic mt-1 text-muted">"{{ $schedule->override_note }}"</span>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div
                        class="alert alert-light border border-secondary border-opacity-25 rounded-3 mb-4 text-center py-3">
                        <i class="bi bi-emoji-smile text-muted me-2"></i> <span class="text-secondary small">Tidak ada
                            kelas hari ini.</span>
                    </div>
                    @endif

                    <!-- Mingguan -->
                    <h6 class="fw-bold text-secondary mb-3 small text-uppercase">Jadwal Mingguan Lengkap</h6>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle border">
                            <thead class="bg-light small text-secondary">
                                <tr>
                                    <th class="ps-3 py-3" width="15%">Hari</th>
                                    <th>Mata Kuliah</th>
                                    <th>Waktu</th>
                                    <th>Ruang</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                @php $hasClasses = false; @endphp
                                @foreach($weeklySchedules as $dayData)
                                @if($dayData['schedules']->isNotEmpty())
                                @php $hasClasses = true; @endphp
                                @foreach($dayData['schedules'] as $index => $schedule)
                                <tr class="{{ $dayData['date']->isToday() ? 'bg-primary bg-opacity-10' : '' }}">
                                    @if($index === 0)
                                    <td class="ps-3 fw-bold text-primary align-top"
                                        rowspan="{{ count($dayData['schedules']) }}">{{ $dayData['day_name'] }}</td>
                                    @endif
                                    <td>
                                        <span
                                            class="d-block fw-bold {{ $schedule->is_overridden && $schedule->override_status === 'cancelled' ? 'text-decoration-line-through text-danger' : 'text-dark' }}">{{ $schedule->subject->name }}</span>
                                        <span class="text-secondary"><i class="bi bi-person"></i>
                                            {{ $schedule->dosen->name }}</span>
                                        @if($schedule->is_overridden)
                                        <span
                                            class="badge {{ $schedule->override_status === 'cancelled' ? 'bg-danger' : 'bg-warning text-dark' }} ms-1 rounded-pill"
                                            style="font-size:0.6rem;">{{ $schedule->override_status === 'cancelled' ? 'BATAL' : 'BERUBAH' }}</span>
                                        @endif
                                    </td>
                                    <td
                                        class="{{ $schedule->is_overridden && $schedule->override_status === 'cancelled' ? 'text-decoration-line-through text-danger' : '' }}">
                                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                    </td>
                                    <td
                                        class="{{ $schedule->is_overridden && $schedule->override_status === 'cancelled' ? 'text-decoration-line-through text-danger' : '' }}">
                                        {{ $schedule->room }}
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                                @endforeach
                                @if(!$hasClasses)
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada jadwal minggu ini.
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <!-- 2. KESEMAPTAAN JASMANI -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-header bg-white border-bottom border-light pt-4 pb-3 px-4">
                            <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-heart-pulse text-danger me-2"></i>
                                Kesemaptaan Jasmani</h6>
                        </div>
                        <div class="card-body p-4">
                            @if($fitnessTests->isNotEmpty())
                            @php $groupedFt = $fitnessTests->groupBy('semester'); @endphp
                            <ul class="nav nav-pills nav-fill gap-2 mb-3" role="tablist">
                                @foreach($groupedFt as $sem => $tests)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link small fw-bold px-3 py-2 {{ $loop->first ? 'active' : '' }}"
                                        data-bs-toggle="pill" data-bs-target="#ft-sem-{{ $sem ?? 'lama' }}"
                                        type="button">
                                        {{ $sem ? 'Smt ' . $sem : 'Lama' }}
                                    </button>
                                </li>
                                @endforeach
                            </ul>
                            <div class="tab-content">
                                @foreach($groupedFt as $sem => $tests)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                    id="ft-sem-{{ $sem ?? 'lama' }}">
                                    @foreach($tests as $ft)
                                    <div class="border rounded-3 p-3 mb-2 bg-light">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="small fw-bold text-secondary"><i
                                                    class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($ft->test_date)->format('d M Y') }}</span>
                                            <span
                                                class="badge {{ $ft->status_badge }} rounded-pill">{{ strtoupper(str_replace('_', ' ', $ft->status)) }}</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <h3 class="fw-bold mb-0 me-2 text-danger">
                                                {{ $ft->total_score ?? $ft->score }}
                                            </h3>
                                            <span class="text-muted small">Total Nilai</span>
                                        </div>
                                        @if($ft->total_score !== null)
                                        <div class="row g-2 small">
                                            <div class="col-6"><span class="text-muted">Lari:</span>
                                                <strong>{{ $ft->raw_lari }}m</strong> → <span
                                                    class="fw-bold {{ $ft->nilai_lari >= 60 ? 'text-success' : 'text-danger' }}">{{ $ft->nilai_lari }}</span>
                                            </div>
                                            <div class="col-6"><span
                                                    class="text-muted">{{ $ft->nilai_pull_up !== null ? 'Pull Up' : 'Chinning' }}:</span>
                                                <strong>{{ $ft->raw_pull_up ?? $ft->raw_chinning ?? '-' }}</strong> →
                                                <span
                                                    class="fw-bold {{ ($ft->nilai_pull_up ?? $ft->nilai_chinning ?? 0) >= 60 ? 'text-success' : 'text-danger' }}">{{ $ft->nilai_pull_up ?? $ft->nilai_chinning ?? '-' }}</span>
                                            </div>
                                            <div class="col-6"><span class="text-muted">Sit Up:</span>
                                                <strong>{{ $ft->raw_sit_up ?? '-' }}</strong> → <span
                                                    class="fw-bold {{ ($ft->nilai_sit_up ?? 0) >= 60 ? 'text-success' : 'text-danger' }}">{{ $ft->nilai_sit_up ?? '-' }}</span>
                                            </div>
                                            <div class="col-6"><span class="text-muted">Push Up:</span>
                                                <strong>{{ $ft->raw_push_up ?? '-' }}</strong> → <span
                                                    class="fw-bold {{ ($ft->nilai_push_up ?? 0) >= 60 ? 'text-success' : 'text-danger' }}">{{ $ft->nilai_push_up ?? '-' }}</span>
                                            </div>
                                            <div class="col-6"><span class="text-muted">Shuttle:</span>
                                                <strong>{{ $ft->raw_shuttle_run ?? '-' }}s</strong> → <span
                                                    class="fw-bold {{ ($ft->nilai_shuttle_run ?? 0) >= 60 ? 'text-success' : 'text-danger' }}">{{ $ft->nilai_shuttle_run ?? '-' }}</span>
                                            </div>
                                            <div class="col-6"><span class="text-muted">Renang:</span>
                                                <strong>{{ $ft->raw_renang ?? '-' }}s</strong> → <span
                                                    class="fw-bold {{ ($ft->nilai_renang ?? 0) >= 60 ? 'text-success' : 'text-danger' }}">{{ $ft->nilai_renang ?? '-' }}</span>
                                            </div>
                                        </div>
                                        @else
                                        <div class="d-flex gap-2">
                                            <span class="badge bg-light border text-dark">A:
                                                {{ $ft->score_a ?? '-' }}</span>
                                            <span class="badge bg-light border text-dark">B:
                                                {{ $ft->score_b ?? '-' }}</span>
                                            <span class="badge bg-light border text-dark">C:
                                                {{ $ft->score_c ?? '-' }}</span>
                                        </div>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-3">
                                <i class="bi bi-clipboard2-x text-muted fs-3 mb-2 d-block"></i>
                                <p class="small text-muted mb-0">Belum ada data uji fisik.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- 3. PRESTASI -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-header bg-white border-bottom border-light pt-4 pb-3 px-4">
                            <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-trophy text-warning me-2"></i> Prestasi
                                Akademik/Non-Akademik</h6>
                        </div>
                        <div class="card-body p-4">
                            @if($achievements->isNotEmpty())
                            <div class="list-group list-group-flush">
                                @foreach($achievements as $ach)
                                <a href="javascript:void(0)"
                                    class="list-group-item list-group-item-action px-0 pt-0 pb-3 mb-3 border-light"
                                    onclick="showAchievement({{ $ach->id }})">
                                    <h6 class="fw-bold mb-1 text-dark">{{ $ach->title }}</h6>
                                    <p class="small text-secondary mb-2">
                                        {{ \Illuminate\Support\Str::limit($ach->description, 60) }}
                                    </p>
                                    <div class="d-flex flex-wrap gap-2 align-items-center mt-2">
                                        @if($ach->level)
                                        <span class="badge bg-info text-dark"><i
                                                class="bi bi-bar-chart-steps me-1"></i>{{ $ach->level }}</span>
                                        @endif
                                        <span class="badge bg-light text-dark border"><i
                                                class="bi bi-calendar3 me-1"></i>
                                            {{ \Carbon\Carbon::parse($ach->date)->format('d M Y') }}</span>
                                        @if($ach->attachment)
                                        <span class="badge bg-success bg-opacity-25 text-success"><i
                                                class="bi bi-paperclip"></i> Lampiran</span>
                                        @endif
                                    </div>
                                </a>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-3">
                                <i class="bi bi-award text-muted fs-3 mb-2 d-block"></i>
                                <p class="small text-muted mb-0">Belum ada catatan prestasi terdaftar.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. JADWAL WALI DOSEN -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div
                    class="card-header bg-white border-bottom border-light pt-4 pb-3 px-4 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-people text-success me-2"></i> Bimbingan / Wali
                        Dosen</h6>
                    <button class="btn btn-sm btn-success rounded-pill px-3 fw-bold" data-bs-toggle="modal"
                        data-bs-target="#modalRequestMeeting"><i class="bi bi-plus-lg me-1"></i> Request</button>
                </div>
                <div class="card-body p-0">
                    @if($meetings->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="bg-light small text-secondary">
                                <tr>
                                    <th class="ps-4 py-3">Tanggal Pengajuan</th>
                                    <th>Dosen Tujuan</th>
                                    <th>Topik Bimbingan</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                @foreach($meetings as $mtg)
                                <tr>
                                    <td class="ps-4 fw-bold">
                                        {{ \Carbon\Carbon::parse($mtg->requested_date)->format('d M Y') }}
                                    </td>
                                    <td>{{ $mtg->dosen->name }}</td>
                                    <td class="text-secondary">{{ $mtg->topic }}</td>
                                    <td class="text-center">
                                        @if($mtg->status === 'approved') <span
                                            class="badge bg-success bg-opacity-25 text-success rounded-pill px-3">Disetujui</span>
                                        @elseif($mtg->status === 'rejected') <span
                                            class="badge bg-danger bg-opacity-25 text-danger rounded-pill px-3">Ditolak</span>
                                        @else <span
                                            class="badge bg-secondary bg-opacity-25 text-secondary rounded-pill px-3">Menunggu</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <p class="small text-muted mb-0">Anda belum pernah mengajukan bimbingan.</p>
                    </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- KOLOM KANAN (30%): INFORMASI & INTERAKSI -->
        <div class="col-lg-4">

            <!-- 5. PELANGGARAN (ALERT STYLE) -->
            @if($violations->isNotEmpty())
            <div class="card border-danger border-2 shadow-sm rounded-4 mb-4 bg-danger bg-opacity-10">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-danger mb-3"><i class="bi bi-exclamation-octagon-fill me-2"></i> Peringatan
                        Pelanggaran</h6>
                    @foreach($violations as $v)
                    <div class="bg-white p-3 rounded-3 shadow-sm border border-danger border-opacity-25 mb-2">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-danger">{{ $v->title }}</span>
                            <span class="fw-bold text-danger">{{ $v->point }} Poin</span>
                        </div>
                        <p class="small text-dark mb-1">{{ $v->description }}</p>
                        <small class="text-muted" style="font-size:0.7rem;">Terjadi pada:
                            {{ \Carbon\Carbon::parse($v->date)->format('d M Y') }}</small>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- 6. JADWAL UJIAN -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-bottom border-light pt-4 pb-3 px-4">
                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-journal-check text-info me-2"></i> Ujian
                        Mendatang</h6>
                </div>
                <div class="card-body px-4 py-3">
                    @if($exams->isNotEmpty())
                    <div class="list-group list-group-flush border-0">
                        @foreach($exams as $exam)
                        <div class="list-group-item px-0 py-3 border-light">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span
                                    class="badge bg-info text-white rounded-pill text-uppercase">{{ $exam->type }}</span>
                                <span
                                    class="small fw-bold text-dark">{{ \Carbon\Carbon::parse($exam->date)->format('d M Y') }}</span>
                            </div>
                            <h6 class="mb-1 fw-bold">{{ $exam->subject->name }}</h6>
                            <div class="small text-secondary mt-2 d-flex justify-content-between">
                                <span><i class="bi bi-clock me-1"></i>
                                    {{ \Carbon\Carbon::parse($exam->start_time)->format('H:i') }}</span>
                                <span><i class="bi bi-geo-alt me-1"></i> {{ $exam->room }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="bi bi-calendar-x text-muted fs-3 mb-2 d-block"></i>
                        <p class="text-muted mb-0 small">Belum ada jadwal ujian dalam waktu dekat.</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- 7. PENGUMUMAN PRODI -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-bottom border-light pt-4 pb-3 px-4">
                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-megaphone text-success me-2"></i> Pengumuman
                        Prodi</h6>
                </div>
                <div class="card-body px-4 py-3">
                    @if(isset($announcements) && $announcements->isNotEmpty())
                    <div class="list-group list-group-flush border-0">
                        @foreach($announcements as $announcement)
                        <a href="javascript:void(0)"
                            class="list-group-item list-group-item-action px-0 py-3 border-light"
                            onclick="showAnnouncement('{{ addslashes($announcement->title) }}', '{{ addslashes($announcement->message) }}', '{{ $announcement->created_at->format('d M Y, H:i') }}')">
                            <h6 class="mb-1 fw-bold text-dark">{{ $announcement->title }}</h6>
                            <p class="mb-2 small text-secondary">
                                {{ \Illuminate\Support\Str::limit($announcement->message, 80) }}
                            </p>
                            <small class="text-muted" style="font-size: 0.7rem;"><i class="bi bi-clock"></i>
                                {{ $announcement->created_at->diffForHumans() }}</small>
                        </a>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-4">
                        <p class="text-muted mb-0 small">Belum ada pengumuman terbaru.</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- 8. KOTAK SARAN -->
            <div class="card border-0 shadow-sm rounded-4 bg-light">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-dark mb-3"><i class="bi bi-envelope-paper text-primary me-2"></i> Kotak
                        Saran Akademik</h6>
                    <form action="{{ route('mahasiswa.dashboard.suggestion.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <select name="category"
                                class="form-select form-select-sm rounded-3 border-secondary border-opacity-25"
                                required>
                                <option value="">Pilih Kategori...</option>
                                <option value="fasilitas">Fasilitas Kampus</option>
                                <option value="akademik">Layanan Akademik</option>
                                <option value="dosen">Kinerja Dosen</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <textarea name="content"
                                class="form-control form-control-sm rounded-3 border-secondary border-opacity-25"
                                rows="3" placeholder="Tulis kritik & saran membangun Anda di sini..."
                                required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100 rounded-pill fw-bold">Kirim
                            Saran</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- MODAL REQUEST MEETING -->
<div class="modal fade" id="modalRequestMeeting" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <form action="{{ route('mahasiswa.dashboard.meeting.store') }}" method="POST">
                @csrf
                <div class="modal-header border-bottom border-light p-4">
                    <h6 class="modal-title fw-bold text-dark"><i class="bi bi-calendar-plus text-success me-2"></i>
                        Ajukan Jadwal Bimbingan</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 bg-light">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Pilih Dosen / Wali Dosen <span
                                class="text-danger">*</span></label>
                        <select name="dosen_id" class="form-select rounded-3" required>
                            <option value="">Pilih Dosen...</option>
                            @foreach($dosens as $dsn)
                            <option value="{{ $dsn->id }}">{{ $dsn->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Tanggal Pengajuan <span
                                class="text-danger">*</span></label>
                        <input type="date" name="requested_date" class="form-control rounded-3"
                            min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" required>
                        <small class="text-muted" style="font-size:0.7rem;">Tanggal aktual dapat diubah oleh dosen saat
                            persetujuan.</small>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-bold text-secondary">Topik Bimbingan <span
                                class="text-danger">*</span></label>
                        <input type="text" name="topic" class="form-control rounded-3"
                            placeholder="Contoh: Konsultasi KRS / Tugas Akhir" required>
                    </div>
                </div>
                <div class="modal-footer border-top border-light p-3">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold">Ajukan</button>
                </div>
            </form>
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

    @php
    $achievementsJson = $achievements->map(function($a) {
        return [
            'id' => $a->id,
            'title' => $a->title,
            'description' => $a->description,
            'level' => $a->level,
            'date' => \Carbon\Carbon::parse($a->date)->format('d M Y'),
            'attachment' => $a->attachment ? Storage::url($a->attachment) : null,
            'attachment_name' => $a->attachment ? basename($a->attachment) : null,
        ];
    });
    @endphp

    var achievementsData = @json($achievementsJson);


    function showAchievement(id) {
        var ach = achievementsData.find(function(a) {
            return a.id === id;
        });
        if (!ach) return;

        document.getElementById('achModalTitle').textContent = ach.title;
        document.getElementById('achModalLevel').textContent = ach.level || '-';
        document.getElementById('achModalDate').textContent = ach.date;
        document.getElementById('achModalDesc').textContent = ach.description || 'Tidak ada deskripsi.';

        var attachEl = document.getElementById('achModalAttachment');
        if (ach.attachment) {
            attachEl.innerHTML = '<a href="' + ach.attachment +
                '" target="_blank" class="btn btn-success rounded-pill px-4 fw-bold" download>' +
                '<i class="bi bi-download me-2"></i>Download Lampiran (' + ach.attachment_name + ')' +
                '</a>';
        } else {
            attachEl.innerHTML =
                '<span class="text-muted small"><i class="bi bi-x-circle me-1"></i>Tidak ada lampiran.</span>';
        }

        var modal = new bootstrap.Modal(document.getElementById('achievementModal'));
        modal.show();
    }
</script>

<!-- MODAL DETAIL PRESTASI -->
<div class="modal fade" id="achievementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0 pb-0 p-4">
                <h5 class="modal-title fw-bold text-dark" id="achModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pb-2 pt-2">
                <div class="d-flex gap-3 mb-3">
                    <span class="badge bg-info text-dark px-3 py-2"><i class="bi bi-bar-chart-steps me-1"></i> <span
                            id="achModalLevel"></span></span>
                    <span class="badge bg-light text-dark border px-3 py-2"><i class="bi bi-calendar3 me-1"></i> <span
                            id="achModalDate"></span></span>
                </div>
                <div class="bg-light rounded-3 p-4 mb-3" id="achModalDesc"
                    style="white-space: pre-wrap; line-height: 1.7;"></div>
                <div id="achModalAttachment"></div>
            </div>
            <div class="modal-footer border-0 pt-0 p-4">
                <button type="button" class="btn btn-light rounded-pill px-4 fw-bold"
                    data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endsection