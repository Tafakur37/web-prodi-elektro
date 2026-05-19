@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0 rounded-4 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-pencil-square me-2 text-primary"></i>Input Nilai Kolektif
            </h5>
            <div id="save-status" class="badge bg-success d-none animated fadeIn">
                <i class="bi bi-check-circle me-1"></i> Perubahan Tersimpan
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <label class="form-label small fw-bold text-uppercase text-muted">1. Pilih Semester</label>
                <select id="filter-semester" class="form-select border-0 bg-light shadow-none">
                    <option value="" selected disabled>Pilih Semester...</option>
                    @foreach($semesters as $s)
                    <option value="{{ $s }}">Semester {{ $s }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label small fw-bold text-uppercase text-muted">2. Pilih Mata Kuliah</label>
                <select id="filter-subject" class="form-select border-0 bg-light shadow-none" disabled>
                    <option value="">Pilih semester terlebih dahulu...</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label small fw-bold text-uppercase text-muted">3. Pilih Cohort</label>
                <select id="filter-cohort" class="form-select border-0 bg-light shadow-none" disabled>
                    <option value="" selected disabled>Pilih Cohort...</option>
                    @foreach($cohorts as $c)
                    <option value="{{ $c->cohort }}">Cohort {{ $c->cohort }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <hr class="opacity-25 my-4">

        <form id="form-input-nilai" action="{{ route('staff.nilai.store') }}" method="POST">
            @csrf
            <input type="hidden" name="subject_id" id="hidden-subject-id">
            <input type="hidden" name="cohort" id="hidden-cohort">

            <div id="table-container">
                <div class="text-center py-5 text-muted">
                    <div class="mb-3">
                        <i class="bi bi-funnel fs-1 opacity-25"></i>
                    </div>
                    <h5>Siap Menampilkan Data</h5>
                    <p class="small">Gunakan filter di atas untuk memunculkan daftar mahasiswa.</p>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const semSelect = document.getElementById('filter-semester');
        const subSelect = document.getElementById('filter-subject');
        const cohSelect = document.getElementById('filter-cohort');
        const container = document.getElementById('table-container');
        const statusBadge = document.getElementById('save-status');

        semSelect.addEventListener('change', function() {
            subSelect.disabled = false;
            fetch("{{ route('staff.getSubjects') }}?semester=" + this.value)
                .then(res => res.json())
                .then(data => {
                    subSelect.innerHTML =
                        '<option value="" selected disabled>Pilih Mata Kuliah...</option>';
                    data.forEach(item => {
                        subSelect.innerHTML +=
                            `<option value="${item.id}">${item.text}</option>`;
                    });
                });
        });

        subSelect.addEventListener('change', function() {
            cohSelect.disabled = false;
            document.getElementById('hidden-subject-id').value = this.value;
            if (cohSelect.value) loadStudents();
        });

        cohSelect.addEventListener('change', function() {
            document.getElementById('hidden-cohort').value = this.value;
            loadStudents();
        });

        function handleRemedial(studentId, type, score, kkm) {
            const remedId = `remed-${type}-${studentId}`;
            const remedInput = document.getElementById(remedId);
            const originalInput = document.getElementById(`${type}-${studentId}`);

            if (!remedInput || !originalInput) return;

            if (score !== '' && parseFloat(score) < kkm) {
                remedInput.disabled = false;
                remedInput.style.opacity = '1';
                remedInput.classList.remove('bg-light');
                remedInput.classList.add('bg-warning-subtle', 'border-warning');
                remedInput.placeholder = 'Input Remidi';

                originalInput.classList.add('bg-danger', 'text-white');
                originalInput.classList.remove('bg-light', 'text-dark');
            } else {
                remedInput.disabled = true;
                remedInput.style.opacity = '0.35';
                remedInput.value = '';
                remedInput.classList.remove('bg-warning-subtle', 'border-warning');
                remedInput.classList.add('bg-light');
                remedInput.placeholder = 'Terkunci';

                originalInput.classList.remove('bg-danger', 'text-white');
            }
        }
        window.handleRemedial = handleRemedial; // Expose to global scope for inline oninput

        function initRemedial() {
            document.querySelectorAll('.input-uts').forEach(input => {
                handleRemedial(input.dataset.student, 'uts', input.value, parseFloat(input.dataset.kkm) || 0);
            });
            document.querySelectorAll('.input-uas').forEach(input => {
                handleRemedial(input.dataset.student, 'uas', input.value, parseFloat(input.dataset.kkm) || 0);
            });
        }

        function loadStudents() {
            const subId = subSelect.value;
            const cohort = cohSelect.value;
            container.innerHTML =
                '<div class="text-center py-5"><div class="spinner-border text-primary"></div></div>';

            fetch("{{ route('staff.getStudents') }}?subject_id=" + subId + "&cohort=" + cohort)
                .then(res => res.text())
                .then(html => {
                    container.innerHTML = html;
                    initRemedial();
                });
        }

        const form = document.getElementById('form-input-nilai');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = document.getElementById('btn-submit-nilai');
            if (!btn) return;
            btn.disabled = true;
            btn.innerHTML = '<i class="spinner-border spinner-border-sm me-2"></i>Menyimpan...';

            fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        statusBadge.classList.remove('d-none');
                        setTimeout(() => statusBadge.classList.add('d-none'), 5000);
                        loadStudents(); // Reload data tersimpan
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Terjadi kesalahan koneksi.');
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bi bi-cloud-upload me-2"></i>Simpan Perubahan';
                });
        });
    });
</script>
@endsection