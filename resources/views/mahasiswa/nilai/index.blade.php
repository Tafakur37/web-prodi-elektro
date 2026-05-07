@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-4">
        <label class="form-label text-muted fw-bold text-uppercase small">Pilih Semester</label>
        <select id="semester-select" class="form-select border-secondary shadow-sm" style="height: 50px;">
            <option value="">-- Pilih Semester --</option>
            @foreach($semesters as $s)
                <option value="{{ $s }}">Semester {{ $s }}</option>
            @endforeach
        </select>
    </div>
</div>

<div id="table-container" class="mt-4">
    <div class="text-center py-5 text-secondary border rounded-4 bg-light">
        <i class="bi bi-search fs-1 text-muted opacity-50 mb-3 d-block"></i>
        <h5>Pilih Semester</h5>
        <p class="small">Silakan pilih semester pada dropdown di atas untuk melihat nilai Anda.</p>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('semester-select');
    const container = document.getElementById('table-container');

    select.addEventListener('change', function() {
        const semester = this.value;
        if (!semester) {
            container.innerHTML = `
                <div class="text-center py-5 text-secondary border rounded-4 bg-light">
                    <i class="bi bi-search fs-1 text-muted opacity-50 mb-3 d-block"></i>
                    <h5>Pilih Semester</h5>
                    <p class="small">Silakan pilih semester pada dropdown di atas untuk melihat nilai Anda.</p>
                </div>
            `;
            return;
        }

        container.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary mb-3"></div><br>Memuat data nilai...</div>';

        fetch(`{{ route('mahasiswa.nilai.data') }}?semester=${semester}`)
            .then(res => res.text())
            .then(html => {
                container.innerHTML = html;
            })
            .catch(err => {
                container.innerHTML = '<div class="text-center py-5 text-danger"><i class="bi bi-exclamation-triangle fs-1 mb-3 d-block"></i>Gagal memuat data. Periksa koneksi internet Anda.</div>';
            });
    });
});
</script>
@endpush
@endsection
