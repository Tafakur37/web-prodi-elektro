@extends('layouts.app')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0 text-dark">Pantau Rekapitulasi Nilai</h3>
            <p class="text-muted mb-0">Lihat rekapitulasi nilai per mahasiswa berdasarkan cohort</p>
        </div>
    </div>

    <!-- FILTER SECTION -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <form action="{{ route('staff.grades.recap') }}" method="GET" id="filter-form">
                <div class="row g-3 align-items-end">
                    
                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted">1. Pilih Semester</label>
                        <select name="semester" id="select-semester" class="form-select select2" required data-placeholder="Pilih Semester">
                            <option value=""></option>
                            @foreach($semesters as $s)
                                <option value="{{ $s }}" {{ request('semester') == $s ? 'selected' : '' }}>
                                    Semester {{ $s }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted">2. Pilih Cohort</label>
                        <select name="cohort" class="form-select select2" required data-placeholder="Angkatan">
                            <option value=""></option>
                            @foreach($availableCohorts as $c)
                                <option value="{{ $c }}" {{ request('cohort') == $c ? 'selected' : '' }}>
                                    {{ $c }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100 fw-bold">
                            Tampilkan Mahasiswa
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- MAIN SECTION -->
    @if(request()->has('semester') && request()->has('cohort'))
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 p-4 pb-0 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold mb-1 text-dark">Daftar Mahasiswa Cohort {{ request('cohort') }}</h5>
                    <div class="text-muted small">
                        <span class="me-3"><i class="bi bi-calendar me-1"></i> Semester {{ request('semester') }}</span>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-4">
                <div class="table-responsive border rounded-3">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th>Email</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                                <tr>
                                    <td class="ps-4 fw-medium">{{ $student->nim }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($student->profile_photo)
                                                <img src="{{ Storage::url($student->profile_photo) }}" class="rounded-circle me-3" width="40" height="40" style="object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-3 fw-bold" style="width: 40px; height: 40px;">
                                                    {{ substr($student->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold text-dark">{{ $student->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-muted">{{ $student->email }}</td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-primary rounded-pill px-3 fw-bold" onclick="showGrades({{ $student->id }}, '{{ addslashes($student->name) }}', {{ request('semester') }})">
                                            <i class="bi bi-eye me-1"></i> Pantau Nilai
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        Tidak ada data mahasiswa untuk Cohort ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @elseif(request()->has('semester') || request()->has('cohort'))
        <div class="alert alert-info border-0 rounded-4 shadow-sm p-4 d-flex align-items-center">
            <i class="bi bi-info-circle-fill fs-3 me-3"></i>
            <div>
                Silakan pilih Semester dan Cohort untuk melihat daftar mahasiswa.
            </div>
        </div>
    @endif
</div>

<!-- Modal Pantau Nilai -->
<div class="modal fade" id="gradesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="gradesModalTitle">Pantau Nilai Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div id="gradesModalContent">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="mt-3 text-muted">Memuat data nilai...</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
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
});

var recapDataUrl = "{{ route('staff.grades.recapData') }}";

function showGrades(studentId, studentName, semester) {
    $('#gradesModalTitle').text('Nilai ' + studentName + ' - Semester ' + semester);
    $('#gradesModalContent').html(
        '<div class="text-center py-5">' +
            '<div class="spinner-border text-primary" role="status">' +
                '<span class="visually-hidden">Loading...</span>' +
            '</div>' +
            '<div class="mt-3 text-muted">Memuat data nilai...</div>' +
        '</div>'
    );

    var gradesModal = new bootstrap.Modal(document.getElementById('gradesModal'));
    gradesModal.show();

    $.ajax({
        url: recapDataUrl,
        type: 'GET',
        data: {
            student_id: studentId,
            semester: semester,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            $('#gradesModalContent').html(response);
        },
        error: function(xhr) {
            $('#gradesModalContent').html(
                '<div class="alert alert-danger mb-0">' +
                    'Terjadi kesalahan saat memuat data nilai. (Status: ' + xhr.status + ')' +
                '</div>'
            );
        }
    });
}
</script>
@endpush
