@extends('layouts.mahasiswa')

@section('title', 'Transkrip Nilai')

@push('styles')
<style>
    .transcript-page {
        display: grid;
        gap: 18px;
    }

    .transcript-hero {
        position: relative;
        overflow: hidden;
        border-radius: var(--radius-xl);
        padding: 24px;
        color: #fff;
        background:
            linear-gradient(135deg, rgba(0, 31, 63, 0.96), rgba(0, 89, 187, 0.88) 58%, rgba(0, 153, 221, 0.82)),
            radial-gradient(circle at 85% 15%, rgba(255, 255, 255, 0.18), transparent 32%);
        border: 1px solid rgba(255, 255, 255, 0.18);
        box-shadow: 0 16px 42px rgba(0, 31, 63, 0.22);
    }

    .transcript-hero::after {
        content: '';
        position: absolute;
        inset: auto -80px -110px auto;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
        pointer-events: none;
    }

    .transcript-hero-inner {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 18px;
        align-items: center;
    }

    .transcript-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 9px;
        font-family: var(--font-label);
        font-size: 0.62rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.62);
    }

    .transcript-title {
        margin: 0;
        font-family: var(--font-display);
        font-size: 1.35rem;
        font-weight: 800;
        letter-spacing: 0;
    }

    .transcript-subtitle {
        max-width: 620px;
        margin: 7px 0 0;
        font-size: 0.84rem;
        line-height: 1.6;
        color: rgba(255, 255, 255, 0.66);
    }

    .transcript-hero-mark {
        width: 76px;
        height: 76px;
        display: grid;
        place-items: center;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.18);
        font-size: 2rem;
    }

    .transcript-toolbar {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 220px;
        gap: 14px;
        align-items: stretch;
        padding: 16px;
        border-radius: var(--radius-xl);
        background: rgba(255, 255, 255, 0.42);
        border: 1px solid rgba(255, 255, 255, 0.62);
        backdrop-filter: blur(28px) saturate(175%);
        -webkit-backdrop-filter: blur(28px) saturate(175%);
        box-shadow: 0 8px 26px rgba(0, 31, 63, 0.08), inset 0 1px 0 rgba(255, 255, 255, 0.68);
    }

    [data-theme="dark"] .transcript-toolbar {
        background: rgba(14, 20, 38, 0.48);
        border-color: rgba(104, 163, 255, 0.18);
    }

    .semester-panel {
        min-width: 0;
    }

    .semester-label {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 11px;
        font-family: var(--font-display);
        font-size: 0.88rem;
        font-weight: 800;
        color: var(--on-surface);
    }

    .semester-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .semester-pill {
        min-width: 44px;
        height: 38px;
        padding: 0 14px;
        border: 1px solid var(--card-glass-border);
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.34);
        color: var(--text-2);
        font-family: var(--font-label);
        font-size: 0.72rem;
        font-weight: 800;
        transition: transform 0.18s ease, border-color 0.18s ease, background 0.18s ease, color 0.18s ease;
    }

    .semester-pill:hover,
    .semester-pill.active {
        transform: translateY(-1px);
        border-color: rgba(0, 89, 187, 0.32);
        background: var(--secondary);
        color: #fff;
    }

    .semester-select-wrap {
        align-self: end;
    }

    .transcript-state {
        border-radius: var(--radius-xl);
        background: rgba(255, 255, 255, 0.42);
        border: 1px solid rgba(255, 255, 255, 0.62);
        backdrop-filter: blur(26px) saturate(170%);
        -webkit-backdrop-filter: blur(26px) saturate(170%);
        overflow: hidden;
    }

    .transcript-empty,
    .transcript-loading {
        min-height: 260px;
        display: grid;
        place-items: center;
        padding: 34px 20px;
        text-align: center;
    }

    .state-icon {
        width: 58px;
        height: 58px;
        display: grid;
        place-items: center;
        margin: 0 auto 14px;
        border-radius: 18px;
        background: var(--cyan-light);
        color: var(--cyan);
        font-size: 1.5rem;
    }

    .transcript-empty h6,
    .transcript-loading h6 {
        margin: 0 0 5px;
        font-family: var(--font-display);
        font-size: 0.98rem;
        font-weight: 800;
        color: var(--on-surface);
    }

    .transcript-empty p,
    .transcript-loading p {
        margin: 0;
        color: var(--text-2);
        font-size: 0.82rem;
    }

    @media (max-width: 820px) {
        .transcript-hero-inner,
        .transcript-toolbar {
            grid-template-columns: 1fr;
        }

        .transcript-hero-mark {
            display: none;
        }

        .semester-select-wrap {
            align-self: stretch;
        }
    }
</style>
@endpush

@section('content')

<div class="transcript-page">
    <section class="transcript-hero">
        <div class="transcript-hero-inner">
            <div>
                <div class="transcript-eyebrow">
                    <i class="bi bi-award"></i>
                    Akademik Mahasiswa
                </div>
                <h1 class="transcript-title">Transkrip Nilai</h1>
                <p class="transcript-subtitle">
                    Pantau capaian tiap semester, nilai akhir mata kuliah, IPS, dan IPK dalam satu tampilan yang lebih mudah dibaca.
                </p>
            </div>
            <div class="transcript-hero-mark">
                <i class="bi bi-bar-chart-line"></i>
            </div>
        </div>
    </section>

    <section class="transcript-toolbar">
        <div class="semester-panel">
            <div class="semester-label">
                <i class="bi bi-calendar2-week" style="color:var(--secondary);"></i>
                Pilih Semester
            </div>
            <div class="semester-pills" aria-label="Pilih semester">
                @foreach($semesters as $s)
                <button type="button" class="semester-pill" data-semester="{{ $s }}">S{{ $s }}</button>
                @endforeach
            </div>
        </div>

        <div class="semester-select-wrap">
            <label class="mhs-label" for="semester-select">Semester aktif</label>
            <select id="semester-select" class="mhs-input">
                <option value="">Pilih semester...</option>
                @foreach($semesters as $s)
                <option value="{{ $s }}">Semester {{ $s }}</option>
                @endforeach
            </select>
        </div>
    </section>

    <div id="table-container">
        <div class="transcript-state">
            <div class="transcript-empty">
                <div>
                    <div class="state-icon"><i class="bi bi-search"></i></div>
                    <h6>Pilih Semester</h6>
                    <p>Transkrip nilai akan muncul setelah Anda memilih semester.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('semester-select');
    const container = document.getElementById('table-container');
    const pills = Array.from(document.querySelectorAll('.semester-pill'));

    function emptyState() {
        container.innerHTML = `
            <div class="transcript-state">
                <div class="transcript-empty">
                    <div>
                        <div class="state-icon"><i class="bi bi-search"></i></div>
                        <h6>Pilih Semester</h6>
                        <p>Transkrip nilai akan muncul setelah Anda memilih semester.</p>
                    </div>
                </div>
            </div>`;
    }

    function loadingState(semester) {
        container.innerHTML = `
            <div class="transcript-state">
                <div class="transcript-loading">
                    <div>
                        <div class="spinner-border" style="color:var(--cyan);width:2.4rem;height:2.4rem;"></div>
                        <h6 style="margin-top:16px;">Memuat Semester ${semester}</h6>
                        <p>Sedang mengambil data nilai terbaru.</p>
                    </div>
                </div>
            </div>`;
    }

    function errorState() {
        container.innerHTML = `
            <div class="transcript-state">
                <div class="transcript-empty" style="color:var(--danger);">
                    <div>
                        <div class="state-icon" style="background:var(--danger-light);color:var(--danger);"><i class="bi bi-exclamation-triangle"></i></div>
                        <h6>Gagal Memuat Data</h6>
                        <p>Periksa koneksi atau coba pilih semester lagi.</p>
                    </div>
                </div>
            </div>`;
    }

    function syncPills(semester) {
        pills.forEach(function(pill) {
            pill.classList.toggle('active', pill.dataset.semester === semester);
        });
    }

    function loadSemester(semester) {
        select.value = semester || '';
        syncPills(semester || '');

        if (!semester) {
            emptyState();
            return;
        }

        loadingState(semester);

        fetch(`{{ route('mahasiswa.nilai.data') }}?semester=${encodeURIComponent(semester)}`)
            .then(function(res) { return res.text(); })
            .then(function(html) { container.innerHTML = html; })
            .catch(errorState);
    }

    select.addEventListener('change', function() {
        loadSemester(this.value);
    });

    pills.forEach(function(pill) {
        pill.addEventListener('click', function() {
            loadSemester(this.dataset.semester);
        });
    });
});
</script>
@endpush

@endsection
