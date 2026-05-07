@extends('layouts.app')

@push('styles')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <style>
        .table-attendance th, .table-attendance td {
            vertical-align: middle;
        }
        .attendance-radio {
            display: none;
        }
        .attendance-label {
            cursor: pointer;
            padding: 8px 15px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            margin: 0 5px;
            transition: all 0.2s;
            font-size: 0.85rem;
            font-weight: 600;
        }
        .attendance-radio[value="hadir"]:checked + .attendance-label {
            background-color: #198754;
            color: white;
            border-color: #198754;
        }
        .attendance-radio[value="sakit"]:checked + .attendance-label {
            background-color: #ffc107;
            color: #000;
            border-color: #ffc107;
        }
        .attendance-radio[value="izin"]:checked + .attendance-label {
            background-color: #0dcaf0;
            color: #000;
            border-color: #0dcaf0;
        }
        .attendance-radio[value="alpa"]:checked + .attendance-label {
            background-color: #dc3545;
            color: white;
            border-color: #dc3545;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0 text-dark">Input Absensi Mahasiswa</h3>
            <p class="text-muted mb-0">Kelola kehadiran mahasiswa untuk mata kuliah Anda</p>
        </div>
    </div>

    <!-- FILTER SECTION -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <form action="{{ route('dosen.attendances.index') }}" method="GET" id="filter-form">
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
                    <h5 class="fw-bold mb-1 text-dark">Daftar Mahasiswa - {{ $selectedSubject->name }}</h5>
                    <div class="text-muted small">
                        <span class="me-3"><i class="bi bi-people me-1"></i> Angkatan {{ $cohort }}</span>
                        <span><i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</span>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-4">
                <form action="{{ route('dosen.attendances.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="subject_id" value="{{ $subject_id }}">
                    <input type="hidden" name="date" value="{{ $date }}">

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
                                        $status = $att ? $att->status : 'hadir';
                                        $notes = $att ? $att->notes : '';
                                    @endphp
                                    <tr>
                                        <td class="ps-4 fw-medium">{{ $student->nim }}</td>
                                        <td class="fw-bold text-dark">{{ $student->name }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <input type="radio" name="attendances[{{ $student->id }}][status]" value="hadir" id="hadir_{{ $student->id }}" class="attendance-radio" {{ $status == 'hadir' ? 'checked' : '' }}>
                                                <label for="hadir_{{ $student->id }}" class="attendance-label">Hadir</label>
                                                
                                                <input type="radio" name="attendances[{{ $student->id }}][status]" value="sakit" id="sakit_{{ $student->id }}" class="attendance-radio" {{ $status == 'sakit' ? 'checked' : '' }}>
                                                <label for="sakit_{{ $student->id }}" class="attendance-label">Sakit</label>
                                                
                                                <input type="radio" name="attendances[{{ $student->id }}][status]" value="izin" id="izin_{{ $student->id }}" class="attendance-radio" {{ $status == 'izin' ? 'checked' : '' }}>
                                                <label for="izin_{{ $student->id }}" class="attendance-label">Izin</label>
                                                
                                                <input type="radio" name="attendances[{{ $student->id }}][status]" value="alpa" id="alpa_{{ $student->id }}" class="attendance-radio" {{ $status == 'alpa' ? 'checked' : '' }}>
                                                <label for="alpa_{{ $student->id }}" class="attendance-label">Alpa</label>
                                            </div>
                                        </td>
                                        <td class="pe-4">
                                            <input type="text" name="attendances[{{ $student->id }}][notes]" value="{{ $notes }}" class="form-control form-control-sm" placeholder="Keterangan opsional">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <div class="bg-light rounded-circle d-inline-flex p-3 mb-3">
                                                <i class="bi bi-people text-secondary fs-3"></i>
                                            </div>
                                            <h6>Tidak ada mahasiswa untuk mata kuliah ini.</h6>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($students->count() > 0)
                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-success fw-bold px-4 rounded-pill shadow-sm">
                                <i class="bi bi-cloud-upload me-2"></i> Simpan Absensi
                            </button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <div class="bg-white rounded-circle shadow-sm d-inline-flex p-4 mb-3 border">
                <i class="bi bi-calendar-check text-primary fs-1"></i>
            </div>
            <h5 class="fw-bold text-dark">Silakan Pilih Filter</h5>
            <p class="text-muted">Pilih Cohort, Mata Kuliah, dan Tanggal pada form di atas untuk menampilkan daftar mahasiswa.</p>
        </div>
    @endif
</div>

@push('scripts')
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });

            const $semester = $('#select-semester');
            const $matkul = $('#select-matkul');
            
            // Store original options
            const originalOptions = $matkul.find('option').clone();

            function filterMatkul() {
                const selectedSemester = $semester.val();
                const currentVal = $matkul.val();
                
                $matkul.empty();
                
                if (selectedSemester) {
                    // Filter by semester
                    originalOptions.each(function() {
                        if (!$(this).val() || $(this).data('semester') == selectedSemester) {
                            $matkul.append($(this).clone());
                        }
                    });
                } else {
                    // Show all
                    $matkul.append(originalOptions.clone());
                }
                
                // Try to keep previous selection if it's still available
                if ($matkul.find(`option[value="${currentVal}"]`).length > 0) {
                    $matkul.val(currentVal);
                } else {
                    $matkul.val('');
                }
                
                $matkul.trigger('change');
            }

            // On semester change, filter matkul
            $semester.on('change', function() {
                filterMatkul();
            });
            
            // Initial filter
            if ($semester.val()) {
                filterMatkul();
            }
        });
    </script>
@endpush
@endsection