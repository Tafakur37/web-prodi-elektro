@extends('layouts.app')

@section('title', 'Buat Jadwal Bimbingan')

@section('content')
<div class="container-fluid p-0">

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0 text-dark">
                <i class="bi bi-calendar-plus text-primary me-2"></i> Buat Jadwal Bimbingan
            </h5>
            <a href="{{ route('dosen.meetings.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="bi bi-arrow-left me-2"></i> Kembali
            </a>
        </div>

        <div class="card-body p-4 p-md-5">
            <form action="{{ route('dosen.meetings.store') }}" method="POST">
                @csrf

                <div class="row g-4">
                    <!-- Kolom Kiri: Filter Cohort & Tanggal -->
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">Pilih Cohort (Angkatan/Kelas) <span class="text-danger">*</span></label>
                            <select id="cohort-select" class="form-select" required>
                                <option value="">-- Pilih Cohort --</option>
                                @foreach($cohorts as $c)
                                    <option value="{{ $c }}">{{ $c }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">Tanggal Bimbingan <span class="text-danger">*</span></label>
                            <input type="date" name="requested_date" class="form-control" required min="{{ date('Y-m-d') }}">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">Topik / Keterangan Bimbingan <span class="text-danger">*</span></label>
                            <textarea name="topic" rows="3" class="form-control" placeholder="Misal: Bimbingan Skripsi Bab 1-3" required></textarea>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Daftar Mahasiswa Checkboxes -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">Pilih Mahasiswa <span class="text-danger">*</span></label>
                        <p class="text-muted small mb-3">Pilih satu atau lebih mahasiswa yang akan dijadwalkan bimbingan. (Pilih Cohort terlebih dahulu)</p>

                        <div id="students-container" class="border rounded-4 bg-light p-4" style="height: 260px; overflow-y: auto;">
                            <div class="text-center text-muted py-5 small">
                                Daftar mahasiswa akan muncul setelah Anda memilih Cohort.
                            </div>
                        </div>
                        @error('students')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr class="my-4">

                <div class="text-end">
                    <button type="submit" id="submit-btn" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm" disabled>
                        <i class="bi bi-send me-2"></i> Simpan Jadwal & Kirim Notifikasi
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cohortSelect = document.getElementById('cohort-select');
    const studentsContainer = document.getElementById('students-container');
    const submitBtn = document.getElementById('submit-btn');

    function checkSubmitStatus() {
        const checkedBoxes = document.querySelectorAll('.student-checkbox:checked');
        submitBtn.disabled = checkedBoxes.length === 0;
    }

    cohortSelect.addEventListener('change', function() {
        const cohort = this.value;
        if (!cohort) {
            studentsContainer.innerHTML = '<div class="text-center text-muted py-5 small">Daftar mahasiswa akan muncul setelah Anda memilih Cohort.</div>';
            checkSubmitStatus();
            return;
        }

        studentsContainer.innerHTML = '<div class="text-center text-muted py-5 small"><div class="spinner-border spinner-border-sm text-primary me-2"></div> Memuat data...</div>';

        fetch(`{{ route('dosen.meetings.getStudents') }}?cohort=${cohort}`)
            .then(response => response.json())
            .then(data => {
                if(data.students.length === 0) {
                    studentsContainer.innerHTML = '<div class="text-center text-muted py-5 small">Tidak ada mahasiswa di Cohort ini.</div>';
                    checkSubmitStatus();
                    return;
                }

                let html = '';
                data.students.forEach(student => {
                    html += `
                        <label class="d-flex align-items-center p-3 border rounded-3 bg-white mb-2 shadow-sm" style="cursor: pointer;">
                            <input type="checkbox" name="students[]" value="${student.id}" class="student-checkbox form-check-input me-3">
                            <div>
                                <span class="fw-bold text-dark d-block">${student.name}</span>
                                <span class="text-muted small">${student.nim || '-'}</span>
                            </div>
                        </label>
                    `;
                });
                studentsContainer.innerHTML = html;

                document.querySelectorAll('.student-checkbox').forEach(box => {
                    box.addEventListener('change', checkSubmitStatus);
                });

                checkSubmitStatus();
            })
            .catch(error => {
                console.error('Error fetching students:', error);
                studentsContainer.innerHTML = '<div class="text-center text-danger py-5 small">Gagal memuat data mahasiswa.</div>';
            });
    });
});
</script>
@endpush
