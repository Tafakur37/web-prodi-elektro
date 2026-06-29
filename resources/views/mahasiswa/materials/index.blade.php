@extends('layouts.mahasiswa')

@section('title', 'Bahan Ajar')

@php
    $totalSubjects = $materialsBySubject->count();
    $totalMaterials = $materialsBySubject->flatten(1)->count();
    $latestMaterial = $materialsBySubject->flatten(1)->sortByDesc('created_at')->first();
    $fileTypes = $materialsBySubject->flatten(1)->pluck('file_type')->filter()->map(fn($type) => strtolower($type))->unique()->sort()->values();
@endphp

@push('styles')
<style>
    .materials-page {
        display: grid;
        gap: 18px;
    }

    .materials-hero {
        position: relative;
        overflow: hidden;
        border-radius: var(--radius-xl);
        padding: 24px;
        color: #fff;
        background:
            linear-gradient(135deg, rgba(0, 31, 63, 0.96), rgba(0, 89, 187, 0.88) 56%, rgba(0, 165, 80, 0.76)),
            radial-gradient(circle at 84% 18%, rgba(255, 255, 255, 0.20), transparent 32%);
        border: 1px solid rgba(255, 255, 255, 0.18);
        box-shadow: 0 16px 42px rgba(0, 31, 63, 0.22);
    }

    .materials-hero::after {
        content: '';
        position: absolute;
        right: -74px;
        bottom: -118px;
        width: 270px;
        height: 270px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
    }

    .materials-hero-inner {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 18px;
        align-items: center;
    }

    .materials-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 9px;
        font-family: var(--font-label);
        font-size: 0.62rem;
        font-weight: 800;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.64);
    }

    .materials-title {
        margin: 0;
        font-family: var(--font-display);
        font-size: 1.35rem;
        font-weight: 900;
        letter-spacing: 0;
    }

    .materials-subtitle {
        max-width: 660px;
        margin: 7px 0 0;
        font-size: 0.84rem;
        line-height: 1.6;
        color: rgba(255, 255, 255, 0.68);
    }

    .materials-hero-icon {
        width: 76px;
        height: 76px;
        display: grid;
        place-items: center;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        font-size: 2rem;
    }

    .materials-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }

    .materials-stat {
        min-height: 94px;
        padding: 15px 16px;
        border-radius: var(--radius-lg);
        background: rgba(255, 255, 255, 0.42);
        border: 1px solid rgba(255, 255, 255, 0.62);
        backdrop-filter: blur(28px) saturate(175%);
        -webkit-backdrop-filter: blur(28px) saturate(175%);
        box-shadow: 0 8px 26px rgba(0, 31, 63, 0.08), inset 0 1px 0 rgba(255, 255, 255, 0.68);
    }

    [data-theme="dark"] .materials-stat {
        background: rgba(14, 20, 38, 0.48);
        border-color: rgba(104, 163, 255, 0.18);
    }

    .materials-stat-label {
        display: flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 9px;
        font-family: var(--font-label);
        font-size: 0.62rem;
        font-weight: 800;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--text-3);
    }

    .materials-stat-value {
        font-family: var(--font-display);
        font-size: 1.55rem;
        font-weight: 900;
        color: var(--on-surface);
        line-height: 1;
    }

    .materials-stat-meta {
        margin-top: 6px;
        font-size: 0.74rem;
        color: var(--text-2);
    }

    .materials-toolbar {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 220px;
        gap: 12px;
        padding: 14px;
        border-radius: var(--radius-xl);
        background: rgba(255, 255, 255, 0.42);
        border: 1px solid rgba(255, 255, 255, 0.62);
        backdrop-filter: blur(28px) saturate(175%);
        -webkit-backdrop-filter: blur(28px) saturate(175%);
    }

    [data-theme="dark"] .materials-toolbar {
        background: rgba(14, 20, 38, 0.48);
        border-color: rgba(104, 163, 255, 0.18);
    }

    .materials-search {
        position: relative;
    }

    .materials-search i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-3);
    }

    .materials-search .mhs-input {
        padding-left: 36px;
    }

    .subject-stack {
        display: grid;
        gap: 12px;
    }

    .subject-card {
        overflow: hidden;
        border-radius: var(--radius-xl);
        background: rgba(255, 255, 255, 0.42);
        border: 1px solid rgba(255, 255, 255, 0.62);
        backdrop-filter: blur(30px) saturate(175%);
        -webkit-backdrop-filter: blur(30px) saturate(175%);
        box-shadow: 0 10px 32px rgba(0, 31, 63, 0.08), inset 0 1px 0 rgba(255, 255, 255, 0.68);
    }

    [data-theme="dark"] .subject-card {
        background: rgba(14, 20, 38, 0.48);
        border-color: rgba(104, 163, 255, 0.18);
    }

    .subject-header {
        width: 100%;
        border: 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        padding: 16px 18px;
        background: rgba(255, 255, 255, 0.18);
        color: inherit;
        text-align: left;
    }

    .subject-header:hover {
        background: var(--info-light);
    }

    .subject-title-wrap {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 0;
    }

    .subject-icon {
        width: 38px;
        height: 38px;
        display: grid;
        place-items: center;
        flex: 0 0 auto;
        border-radius: 12px;
        background: var(--primary-light);
        color: var(--primary);
    }

    .subject-title {
        display: block;
        font-family: var(--font-display);
        font-size: 0.94rem;
        font-weight: 900;
        color: var(--on-surface);
    }

    .subject-meta {
        display: block;
        margin-top: 3px;
        font-size: 0.73rem;
        color: var(--text-3);
    }

    .subject-actions {
        display: flex;
        align-items: center;
        gap: 9px;
        flex: 0 0 auto;
    }

    .subject-chevron {
        color: var(--text-3);
        transition: transform 0.25s ease;
    }

    .subject-header.open .subject-chevron {
        transform: rotate(90deg);
    }

    .subject-body {
        display: none;
        padding: 0 14px 14px;
    }

    .subject-body.open {
        display: block;
    }

    .material-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 12px;
        padding-top: 14px;
    }

    .material-card {
        display: grid;
        grid-template-rows: auto 1fr auto;
        gap: 12px;
        min-height: 190px;
        padding: 14px;
        border-radius: var(--radius-lg);
        background: rgba(255, 255, 255, 0.38);
        border: 1px solid rgba(255, 255, 255, 0.56);
        transition: transform 0.18s ease, border-color 0.18s ease, background 0.18s ease;
    }

    .material-card:hover {
        transform: translateY(-2px);
        border-color: rgba(0, 89, 187, 0.26);
        background: rgba(255, 255, 255, 0.54);
    }

    [data-theme="dark"] .material-card {
        background: rgba(255, 255, 255, 0.04);
        border-color: rgba(104, 163, 255, 0.13);
    }

    .material-top {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        align-items: flex-start;
    }

    .file-icon {
        width: 42px;
        height: 42px;
        display: grid;
        place-items: center;
        border-radius: 13px;
        background: var(--cyan-light);
        color: var(--cyan);
        font-size: 1.25rem;
    }

    .material-title {
        margin: 0 0 6px;
        font-family: var(--font-display);
        font-size: 0.94rem;
        font-weight: 900;
        color: var(--on-surface);
        line-height: 1.35;
    }

    .material-desc {
        margin: 0;
        color: var(--text-2);
        font-size: 0.76rem;
        line-height: 1.55;
    }

    .material-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        color: var(--text-3);
        font-size: 0.7rem;
    }

    .material-buttons {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 8px;
        align-items: center;
    }

    .materials-empty {
        min-height: 280px;
        display: grid;
        place-items: center;
        padding: 36px 20px;
        text-align: center;
        border-radius: var(--radius-xl);
        background: rgba(255, 255, 255, 0.42);
        border: 1px solid rgba(255, 255, 255, 0.62);
        backdrop-filter: blur(26px) saturate(170%);
        -webkit-backdrop-filter: blur(26px) saturate(170%);
    }

    .materials-empty-icon {
        width: 62px;
        height: 62px;
        display: grid;
        place-items: center;
        margin: 0 auto 14px;
        border-radius: 18px;
        background: var(--cyan-light);
        color: var(--cyan);
        font-size: 1.6rem;
    }

    .materials-empty h6 {
        margin: 0 0 6px;
        font-family: var(--font-display);
        font-weight: 900;
        color: var(--on-surface);
    }

    .materials-empty p {
        margin: 0;
        color: var(--text-2);
        font-size: 0.82rem;
    }

    @media (max-width: 820px) {
        .materials-hero-inner,
        .materials-toolbar,
        .materials-stats {
            grid-template-columns: 1fr;
        }

        .materials-hero-icon {
            display: none;
        }
    }
</style>
@endpush

@section('content')

<div class="materials-page">
    <section class="materials-hero">
        <div class="materials-hero-inner">
            <div>
                <div class="materials-eyebrow">
                    <i class="bi bi-journal-text"></i>
                    Akademik Mahasiswa
                </div>
                <h1 class="materials-title">Bahan Ajar</h1>
                <p class="materials-subtitle">
                    Temukan materi perkuliahan berdasarkan mata kuliah, pratinjau file yang didukung browser, lalu unduh dokumen asli saat diperlukan.
                </p>
            </div>
            <div class="materials-hero-icon">
                <i class="bi bi-folder2-open"></i>
            </div>
        </div>
    </section>

    <section class="materials-stats">
        <div class="materials-stat">
            <div class="materials-stat-label"><i class="bi bi-book"></i> Mata Kuliah</div>
            <div class="materials-stat-value">{{ $totalSubjects }}</div>
            <div class="materials-stat-meta">Kelompok materi tersedia</div>
        </div>
        <div class="materials-stat">
            <div class="materials-stat-label"><i class="bi bi-files"></i> Total File</div>
            <div class="materials-stat-value">{{ $totalMaterials }}</div>
            <div class="materials-stat-meta">Bahan ajar untuk angkatan Anda</div>
        </div>
        <div class="materials-stat">
            <div class="materials-stat-label"><i class="bi bi-clock-history"></i> Terbaru</div>
            <div class="materials-stat-value" style="font-size:1rem;line-height:1.35;">
                {{ $latestMaterial ? \Illuminate\Support\Str::limit($latestMaterial->title, 28) : '-' }}
            </div>
            <div class="materials-stat-meta">{{ $latestMaterial ? $latestMaterial->created_at->format('d M Y') : 'Belum ada materi' }}</div>
        </div>
    </section>

    @if($materialsBySubject->isEmpty())
    <div class="materials-empty">
        <div>
            <div class="materials-empty-icon"><i class="bi bi-journal-x"></i></div>
            <h6>Belum Ada Bahan Ajar</h6>
            <p>Materi yang dibagikan dosen untuk angkatan Anda akan tampil di sini.</p>
        </div>
    </div>
    @else
    <section class="materials-toolbar">
        <div class="materials-search">
            <i class="bi bi-search"></i>
            <input type="search" id="materialSearch" class="mhs-input" placeholder="Cari judul, dosen, atau mata kuliah...">
        </div>
        <select id="materialTypeFilter" class="mhs-input">
            <option value="">Semua tipe file</option>
            @foreach($fileTypes as $type)
            <option value="{{ $type }}">{{ strtoupper($type) }}</option>
            @endforeach
        </select>
    </section>

    <section class="subject-stack" id="materialsList">
        @foreach($materialsBySubject as $subjectName => $materials)
        <article class="subject-card" data-subject-card data-subject="{{ strtolower($subjectName) }}">
            <button type="button" class="subject-header {{ $loop->first ? 'open' : '' }}" data-subject-toggle>
                <span class="subject-title-wrap">
                    <span class="subject-icon"><i class="bi bi-book"></i></span>
                    <span>
                        <span class="subject-title">{{ $subjectName }}</span>
                        <span class="subject-meta">{{ $materials->count() }} file dibagikan</span>
                    </span>
                </span>
                <span class="subject-actions">
                    <span class="mhs-badge primary">{{ $materials->count() }} File</span>
                    <i class="bi bi-chevron-right subject-chevron"></i>
                </span>
            </button>

            <div class="subject-body {{ $loop->first ? 'open' : '' }}" data-subject-body>
                <div class="material-grid">
                    @foreach($materials as $material)
                    @php
                        $type = strtolower($material->file_type ?? '');
                        $icon = match($type) {
                            'pdf' => 'bi-filetype-pdf',
                            'doc', 'docx' => 'bi-filetype-doc',
                            'ppt', 'pptx' => 'bi-filetype-ppt',
                            default => 'bi-file-earmark-text'
                        };
                        $searchText = strtolower($subjectName . ' ' . $material->title . ' ' . ($material->description ?? '') . ' ' . ($material->user->name ?? '') . ' ' . $type);
                    @endphp
                    <article class="material-card" data-material-card data-type="{{ $type }}" data-search="{{ $searchText }}">
                        <div class="material-top">
                            <div class="file-icon"><i class="bi {{ $icon }}"></i></div>
                            <span class="mhs-badge muted" style="text-transform:uppercase;">{{ $type ?: 'file' }}</span>
                        </div>

                        <div>
                            <h2 class="material-title">{{ $material->title }}</h2>
                            <p class="material-desc">
                                {{ $material->description ? \Illuminate\Support\Str::limit($material->description, 100) : 'Tidak ada deskripsi tambahan.' }}
                            </p>
                        </div>

                        <div>
                            <div class="material-meta">
                                <span><i class="bi bi-person"></i> {{ $material->user->name ?? 'Tidak diketahui' }}</span>
                                <span><i class="bi bi-calendar-event"></i> {{ $material->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="material-buttons" style="margin-top:12px;">
                                <a href="{{ route('mahasiswa.materials.show', $material->id) }}" class="mhs-btn mhs-btn-primary mhs-btn-sm">
                                    <i class="bi bi-eye"></i> Review
                                </a>
                                <a href="{{ route('mahasiswa.materials.download', $material->id) }}" class="mhs-btn mhs-btn-success mhs-btn-sm" title="Unduh file asli">
                                    <i class="bi bi-download"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
        </article>
        @endforeach
    </section>

    <div class="materials-empty" id="materialsNoResult" style="display:none;">
        <div>
            <div class="materials-empty-icon"><i class="bi bi-search"></i></div>
            <h6>Materi Tidak Ditemukan</h6>
            <p>Coba gunakan kata kunci lain atau ubah filter tipe file.</p>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-subject-toggle]').forEach(function(toggle) {
        toggle.addEventListener('click', function() {
            const card = toggle.closest('[data-subject-card]');
            const body = card.querySelector('[data-subject-body]');
            toggle.classList.toggle('open');
            body.classList.toggle('open');
        });
    });

    const searchInput = document.getElementById('materialSearch');
    const typeFilter = document.getElementById('materialTypeFilter');
    const noResult = document.getElementById('materialsNoResult');

    function applyFilters() {
        if (!searchInput || !typeFilter) return;

        const keyword = searchInput.value.trim().toLowerCase();
        const type = typeFilter.value;
        let visibleSubjects = 0;

        document.querySelectorAll('[data-subject-card]').forEach(function(subjectCard) {
            let visibleCards = 0;

            subjectCard.querySelectorAll('[data-material-card]').forEach(function(materialCard) {
                const matchesKeyword = !keyword || materialCard.dataset.search.includes(keyword);
                const matchesType = !type || materialCard.dataset.type === type;
                const visible = matchesKeyword && matchesType;
                materialCard.style.display = visible ? '' : 'none';
                if (visible) visibleCards++;
            });

            const showSubject = visibleCards > 0;
            subjectCard.style.display = showSubject ? '' : 'none';
            if (showSubject) {
                visibleSubjects++;
                subjectCard.querySelector('[data-subject-toggle]').classList.add('open');
                subjectCard.querySelector('[data-subject-body]').classList.add('open');
            }
        });

        if (noResult) {
            noResult.style.display = visibleSubjects === 0 ? 'grid' : 'none';
        }
    }

    if (searchInput) searchInput.addEventListener('input', applyFilters);
    if (typeFilter) typeFilter.addEventListener('change', applyFilters);
});
</script>
@endpush

@endsection
