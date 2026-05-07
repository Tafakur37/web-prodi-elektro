@extends('layouts.app')

@push('styles')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <style>
        .table-attendance th, .table-attendance td {
            vertical-align: middle;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0 text-dark">Pantau Absensi Mahasiswa</h3>
            <p class="text-muted mb-0">Lihat rekapitulasi kehadiran berdasarkan cohort, mata kuliah, dan hari</p>
        </div>
    </div>

    <!-- FILTER SECTION -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <form action="{{ route('staff.attendances.index') }}" method="GET" id="filter-form">
                <div class="row g-3 align-items-end">
                    
                    <div class="col-md-2">
                        <label class="form-label fw-bold small text-muted">1. Semester</label>
                        <select name="semester" id="select-semester" class="form-select select2" data-placeholder="Pilih Semester">
                            <option value="">Semua</option>
                            @foreach($semesters as $s)
                                <option value="{{ $s }}" {{ request('semester') == $s ? 'selected' : '' }}>
                                    Semester {{ $s }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted">2. Pilih Mata Kuliah</label>
                        <select name="subject_id" id="select-matkul" class="form-select select2" required data-placeholder="Ketik nama matkul...">
                            <option value=""></option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" data-semester="{{ $subject->semester }}" {{ $subject_id == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-bold small text-muted">3. Pilih Cohort</label>
                        <select name="cohort" class="form-select select2" required data-placeholder="Angkatan">
                            <option value=""></option>
                            @foreach($availableCohorts as $c)
                                <option value="{{ $c }}" {{ $cohort == $c ? 'selected' : '' }}>
                                    {{ $c }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <label class="form-label fw-bold small text-muted">4. Tanggal</label>
                        <input type="date" name="date" value="{{ $date }}" class="form-control" required>
                    </div>
                    
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100 fw-bold">
                            Tampilkan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- MAIN SECTION -->
    @if($selectedSubject && $cohort)
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 p-4 pb-0 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold mb-1 text-dark">Daftar Kehadiran Mahasiswa - {{ $selectedSubject->name }}</h5>
                    <div class="text-muted small">
                        <span class="me-3"><i class="bi bi-people me-1"></i> Angkatan {{ $cohort }}</span>
                        <span><i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-4">
                <div class="table-responsive border rounded-3">
                    <table class="table table-hover table-attendance mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th class="text-center">Status Kehadiran</th>
                                <th class="pe-4">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                                @php
                                    $att = $existingAttendances[$student->id] ?? null;
                                    $status = $att ? $att->status : 'belum_absen';
                                    $notes = $att ? $att->notes : '-';
                                    
                                    $badgeClass = match($status) {
                                        'hadir' => 'bg-success',
                                        'sakit' => 'bg-warning text-dark',
                                        'izin' => 'bg-info text-dark',
                                        'alpa' => 'bg-danger',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                                <tr>
                                    <td class="ps-4 fw-medium">{{ $student->nim }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td class="text-center">
                                        <span class="badge {{ $badgeClass }} px-3 py-2 rounded-pill">
                                            {{ strtoupper(str_replace('_', ' ', $status)) }}
                                        </span>
                                    </td>
                                    <td class="pe-4 text-muted small">{{ $notes }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        Tidak ada mahasiswa di cohort ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @elseif(request()->has('subject_id'))
        <div class="alert alert-info border-0 rounded-4 shadow-sm p-4 d-flex align-items-center">
            <i class="bi bi-info-circle-fill fs-3 me-3"></i>
            <div>
                Silakan pilih Mata Kuliah, Cohort, dan Tanggal untuk melihat data absensi.
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%'
    });

    const $semester = $('#select-semester');
    const $matkul = $('#select-matkul');
    const originalOptions = $matkul.find('option').clone();

    function filterMatkul() {
        const selectedSemester = $semester.val();
        const currentVal = $matkul.val();
        
        $matkul.empty();
        
        if (selectedSemester) {
            originalOptions.each(function() {
                if (!$(this).val() || $(this).data('semester') == selectedSemester) {
                    $matkul.append($(this).clone());
                }
            });
        } else {
            $matkul.append(originalOptions.clone());
        }
        
        if ($matkul.find(`option[value="${currentVal}"]`).length > 0) {
            $matkul.val(currentVal);
        } else {
            $matkul.val('');
        }
        $matkul.trigger('change.select2');
    }

    $semester.on('change', filterMatkul);
});
</script>
@endpush
