@extends('layouts.mahasiswa')

@section('title', 'Transkrip Nilai')

@section('content')

<div class="mhs-card" style="margin-bottom:20px;">
    <div class="mhs-card-header">
        <h6 class="mhs-card-title">
            <span class="mhs-card-icon" style="background:var(--cyan-light);color:var(--cyan);">
                <i class="bi bi-bar-chart-line"></i>
            </span>
            Transkrip Nilai
        </h6>
    </div>
    <div class="mhs-card-body">
        <div style="max-width:300px;">
            <label class="mhs-label">Pilih Semester</label>
            <select id="semester-select" class="mhs-input">
                <option value="">-- Pilih Semester --</option>
                @foreach($semesters as $s)
                    <option value="{{ $s }}">Semester {{ $s }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div id="table-container">
    <div class="mhs-card">
        <div class="mhs-empty" style="padding:48px 20px;">
            <i class="bi bi-search"></i>
            <p>Pilih semester untuk melihat transkrip nilai Anda.</p>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const select    = document.getElementById('semester-select');
    const container = document.getElementById('table-container');

    select.addEventListener('change', function() {
        const semester = this.value;
        if (!semester) {
            container.innerHTML = `<div class="mhs-card"><div class="mhs-empty" style="padding:48px 20px;"><i class="bi bi-search"></i><p>Pilih semester untuk melihat transkrip nilai Anda.</p></div></div>`;
            return;
        }

        container.innerHTML = `<div class="mhs-card"><div class="mhs-card-body" style="text-align:center;padding:40px;"><div class="spinner-border" style="color:var(--cyan);"></div><p style="margin-top:12px;color:var(--text-2);">Memuat data nilai...</p></div></div>`;

        fetch(`{{ route('mahasiswa.nilai.data') }}?semester=${semester}`)
            .then(res => res.text())
            .then(html => { container.innerHTML = html; })
            .catch(() => {
                container.innerHTML = `<div class="mhs-card"><div class="mhs-empty" style="padding:40px;color:var(--danger);"><i class="bi bi-exclamation-triangle"></i><p>Gagal memuat data. Periksa koneksi internet Anda.</p></div></div>`;
            });
    });
});
</script>
@endpush

@endsection
