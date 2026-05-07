@extends('layouts.app')

@section('title', 'Tambah Pelanggaran')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 pb-0">
                <h2 class="h4 mb-0">
                    <i class="bi bi-plus-circle text-primary me-2"></i>
                    Tambah Pelanggaran Baru
                </h2>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('staff.violations.store') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Cohort <span class="text-danger">*</span></label>
                            <select name="cohort" id="cohortSelect" class="form-select" required>
                                <option value="">Pilih Cohort...</option>
                                @foreach($cohorts as $cohort)
                                <option value="{{ $cohort }}" {{ (string) old('cohort') === (string) $cohort ? 'selected' : '' }}>
                                    Cohort {{ $cohort }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
                                value="{{ old('date') }}" required>
                            @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Mahasiswa <span class="text-danger">*</span></label>
                        <select name="user_id" id="studentSelect" class="form-select @error('user_id') is-invalid @enderror" required disabled>
                            <option value="">Pilih cohort terlebih dahulu...</option>
                        </select>
                        @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Judul Pelanggaran <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title') }}" placeholder="Contoh: Terlambat Absen" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                            rows="4" placeholder="Detail pelanggaran...">{{ old('description') }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Poin <span class="text-danger">*</span></label>
                            <input type="number" name="point" class="form-control @error('point') is-invalid @enderror"
                                value="{{ old('point', 5) }}" min="1" max="100" required>
                            @error('point') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai
                                </option>
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 pt-3">
                        <a href="{{ route('staff.violations.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Simpan Pelanggaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const students = @json($students);
    const selectedUserId = @json((string) old('user_id'));
    const cohortSelect = document.getElementById('cohortSelect');
    const studentSelect = document.getElementById('studentSelect');

    function fillStudents() {
        const cohort = cohortSelect.value;
        studentSelect.innerHTML = '';

        if (!cohort) {
            studentSelect.disabled = true;
            studentSelect.append(new Option('Pilih cohort terlebih dahulu...', ''));
            return;
        }

        const filtered = students.filter(student => String(student.cohort) === String(cohort));
        studentSelect.disabled = false;
        studentSelect.append(new Option('Pilih Mahasiswa...', ''));

        filtered.forEach(student => {
            const label = `${student.name} (${student.nim ?? '-'})`;
            const option = new Option(label, student.id);
            if (String(student.id) === selectedUserId) {
                option.selected = true;
            }
            studentSelect.append(option);
        });

        if (filtered.length === 0) {
            studentSelect.disabled = true;
            studentSelect.innerHTML = '';
            studentSelect.append(new Option('Tidak ada mahasiswa di cohort ini', ''));
        }
    }

    if (!cohortSelect.value && selectedUserId) {
        const selectedStudent = students.find(student => String(student.id) === selectedUserId);
        if (selectedStudent) {
            cohortSelect.value = selectedStudent.cohort;
        }
    }

    cohortSelect.addEventListener('change', fillStudents);
    fillStudents();
});
</script>
@endpush
