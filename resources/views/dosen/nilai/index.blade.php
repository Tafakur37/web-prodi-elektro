@extends('layouts.app')

@push('styles')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
    rel="stylesheet" />
<style>
.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: #fff;
    border-radius: 15px;
    border: 1px dashed #ced4da;
}
</style>
@endpush

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0 text-dark">Input Nilai Mahasiswa</h3>
            <p class="text-muted mb-0">Filter untuk mencari daftar mahasiswa yang akan diinput nilainya</p>
        </div>
    </div>

    <!-- FILTER BAR -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="row g-3 align-items-end">
                <!-- Semester Filter -->
                <div class="col-md-3">
                    <label class="form-label fw-bold small text-muted">1. Semester</label>
                    <select class="form-select select2" id="select-semester" data-placeholder="Pilih Semester">
                        <option value="">Semua</option>
                        @foreach($semesters as $s)
                        <option value="{{ $s }}">Semester {{ $s }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Mata Kuliah Filter -->
                <div class="col-md-5">
                    <label class="form-label fw-bold small text-muted">2. Pilih Mata Kuliah</label>
                    <select class="form-select select2" id="select-matkul"
                        data-placeholder="Ketik untuk mencari matkul...">
                        <option value=""></option>
                        @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" data-semester="{{ $subject->semester }}"
                            data-name="{{ $subject->name }}">
                            {{ $subject->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Cohort Filter -->
                <div class="col-md-3">
                    <label class="form-label fw-bold small text-muted">3. Pilih Angkatan</label>
                    <select class="form-select select2" id="select-cohort"
                        data-placeholder="Ketik untuk mencari angkatan...">
                        <option value=""></option>
                        @foreach($cohorts as $c)
                        <option value="{{ $c->cohort }}">{{ $c->cohort }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Load Button -->
                <div class="col-md-1">
                    <button type="button" class="btn btn-primary w-100 fw-bold" id="btn-load-students" disabled>
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN AREA: Students Table -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('dosen.nilai.store') }}" method="POST" id="form-nilai">
                @csrf
                <input type="hidden" name="subject_id" id="hidden-submit-subject-id">
                <input type="hidden" name="cohort" id="hidden-submit-cohort">

                <div class="d-flex justify-content-between align-items-center mb-4 d-none" id="table-header">
                    <div>
                        <h5 class="fw-bold mb-0" id="selected-subject-name">-</h5>
                        <span class="badge bg-primary-subtle text-primary border mt-1"
                            id="selected-cohort-badge">-</span>
                    </div>
                    <button type="submit" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm"
                        id="btn-submit-nilai">
                        <i class="bi bi-cloud-upload me-2"></i>Simpan Nilai
                    </button>
                </div>

                <div id="container-mahasiswa">
                    <div class="empty-state">
                        <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                            <i class="bi bi-table text-secondary fs-1"></i>
                        </div>
                        <h5 class="fw-bold text-dark">Siap Memasukkan Nilai</h5>
                        <p class="text-muted">Silakan pilih Mata Kuliah dan Angkatan pada filter di atas, kemudian klik
                            tombol pencarian.</p>
                    </div>
                </div>
            </form>
        </div>
    </div>
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

    // UI Elements
    const $semester = $('#select-semester');
    const $matkul = $('#select-matkul');
    const $cohort = $('#select-cohort');
    const $btnLoad = $('#btn-load-students');

    // Store original options
    const originalOptions = $matkul.find('option').clone();

    // CHECK FORM COMPLETENESS
    function checkForm() {
        if ($matkul.val() && $cohort.val()) {
            $btnLoad.prop('disabled', false);
        } else {
            $btnLoad.prop('disabled', true);
        }
    }

    // FILTER MATKUL BY SEMESTER
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

    // EVENTS
    $semester.on('change', function() {
        filterMatkul();
    });

    $matkul.on('change', checkForm);
    $cohort.on('change', checkForm);

    // Initial check
    if ($semester.val()) {
        filterMatkul();
    }
    checkForm();

    // --- LOAD STUDENTS ---
    $btnLoad.on('click', function() {
        const subjectId = $matkul.val();
        const cohort = $cohort.val();

        // Get name from option data attribute
        const subjectName = $matkul.find(':selected').data('name') || $matkul.find(':selected').text();
        const cohortName = $cohort.find(':selected').text();

        $('#hidden-submit-subject-id').val(subjectId);
        $('#hidden-submit-cohort').val(cohort);

        $('#selected-subject-name').text(subjectName);
        $('#selected-cohort-badge').text(cohortName);
        $('#table-header').removeClass('d-none');

        const container = document.getElementById('container-mahasiswa');
        container.innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary mb-3" role="status"></div>
                <h6 class="text-secondary">Memuat data mahasiswa...</h6>
            </div>
        `;

        fetch(`{{ route('dosen.getStudents') }}?cohort=${cohort}&subject_id=${subjectId}`)
            .then(res => {
                if (!res.ok) throw new Error("Gagal mengambil data");
                return res.text();
            })
            .then(html => {
                container.innerHTML = html;
            })
            .catch(err => {
                container.innerHTML = `
                    <div class="alert alert-danger border-0 rounded-3 shadow-sm text-center py-4">
                        <i class="bi bi-exclamation-triangle fs-1 d-block mb-2"></i>
                        Terjadi kesalahan sistem: ${err.message}
                    </div>
                `;
            });
    });

    // --- AJAX FORM SUBMIT ---
    document.getElementById('form-nilai').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = this;
        const btn = document.getElementById('btn-submit-nilai');
        const originalText = btn.innerHTML;

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';

        fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    const alertHtml = `
                    <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-3" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> ${data.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `;
                    document.getElementById('table-header').insertAdjacentHTML('afterend',
                        alertHtml);

                    // Reload table
                    $btnLoad.click();

                    setTimeout(() => {
                        const alertEl = document.querySelector('.alert-success');
                        if (alertEl) {
                            const bsAlert = new bootstrap.Alert(alertEl);
                            bsAlert.close();
                        }
                    }, 3000);
                } else {
                    alert('Gagal: ' + data.message);
                }
            })
            .catch(err => alert("Terjadi kesalahan koneksi!"))
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
    });
});
</script>
@endpush
@endsection