@extends('layouts.mahasiswa')

@section('title', 'Detail Materi')

@php
    $type = strtolower($material->file_type ?? '');
    $previewable = in_array($type, ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'webp']);
    $previewUrl = route('mahasiswa.materials.preview', $material->id);
    $downloadUrl = route('mahasiswa.materials.download', $material->id);
    $fileIcon = match($type) {
        'pdf' => 'bi-filetype-pdf',
        'doc', 'docx' => 'bi-filetype-doc',
        'ppt', 'pptx' => 'bi-filetype-ppt',
        default => 'bi-file-earmark-text'
    };
@endphp

@push('styles')
<style>
    .material-detail-page {
        display: grid;
        gap: 16px;
    }

    .detail-topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        padding: 14px;
        border-radius: var(--radius-xl);
        background: rgba(255, 255, 255, 0.42);
        border: 1px solid rgba(255, 255, 255, 0.62);
        backdrop-filter: blur(28px) saturate(175%);
        -webkit-backdrop-filter: blur(28px) saturate(175%);
        box-shadow: 0 8px 26px rgba(0, 31, 63, 0.08), inset 0 1px 0 rgba(255, 255, 255, 0.68);
    }

    [data-theme="dark"] .detail-topbar {
        background: rgba(14, 20, 38, 0.48);
        border-color: rgba(104, 163, 255, 0.18);
    }

    .detail-heading {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .detail-file-icon {
        width: 46px;
        height: 46px;
        display: grid;
        place-items: center;
        flex: 0 0 auto;
        border-radius: 14px;
        background: var(--cyan-light);
        color: var(--cyan);
        font-size: 1.35rem;
    }

    .detail-title {
        margin: 0;
        font-family: var(--font-display);
        font-size: 1rem;
        font-weight: 900;
        color: var(--on-surface);
    }

    .detail-subtitle {
        margin: 4px 0 0;
        color: var(--text-3);
        font-size: 0.75rem;
    }

    .detail-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .detail-layout {
        display: grid;
        grid-template-columns: 300px minmax(0, 1fr);
        gap: 16px;
        align-items: start;
    }

    .detail-panel,
    .preview-panel {
        overflow: hidden;
        border-radius: var(--radius-xl);
        background: rgba(255, 255, 255, 0.42);
        border: 1px solid rgba(255, 255, 255, 0.62);
        backdrop-filter: blur(30px) saturate(175%);
        -webkit-backdrop-filter: blur(30px) saturate(175%);
        box-shadow: 0 10px 32px rgba(0, 31, 63, 0.08), inset 0 1px 0 rgba(255, 255, 255, 0.68);
    }

    [data-theme="dark"] .detail-panel,
    [data-theme="dark"] .preview-panel {
        background: rgba(14, 20, 38, 0.48);
        border-color: rgba(104, 163, 255, 0.18);
    }

    .panel-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        padding: 15px 16px;
        border-bottom: 1px solid var(--card-glass-border);
        background: rgba(255, 255, 255, 0.18);
    }

    .panel-title {
        display: flex;
        align-items: center;
        gap: 9px;
        margin: 0;
        font-family: var(--font-display);
        font-size: 0.9rem;
        font-weight: 900;
        color: var(--on-surface);
    }

    .panel-body {
        padding: 16px;
    }

    .info-list {
        display: grid;
        gap: 14px;
    }

    .info-label {
        margin-bottom: 4px;
        font-family: var(--font-label);
        font-size: 0.62rem;
        font-weight: 800;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--text-3);
    }

    .info-value {
        color: var(--on-surface);
        font-size: 0.84rem;
        font-weight: 700;
        line-height: 1.5;
    }

    .info-description {
        margin: 0;
        color: var(--text-2);
        font-size: 0.8rem;
        line-height: 1.65;
    }

    .preview-shell {
        min-height: 680px;
        background:
            linear-gradient(135deg, rgba(0, 31, 63, 0.08), rgba(0, 89, 187, 0.05)),
            rgba(255, 255, 255, 0.18);
    }

    .preview-frame {
        width: 100%;
        min-height: 680px;
        border: 0;
        display: block;
        background: #fff;
    }

    .image-preview {
        min-height: 680px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
    }

    .image-preview img {
        max-width: 100%;
        max-height: 78vh;
        object-fit: contain;
        border-radius: var(--radius-lg);
        box-shadow: 0 14px 34px rgba(0, 31, 63, 0.18);
    }

    .no-preview {
        min-height: 680px;
        display: grid;
        place-items: center;
        padding: 32px 20px;
        text-align: center;
    }

    .no-preview-icon {
        width: 78px;
        height: 78px;
        display: grid;
        place-items: center;
        margin: 0 auto 16px;
        border-radius: 22px;
        background: var(--warning-light);
        color: var(--warning);
        font-size: 2rem;
    }

    .no-preview h5 {
        margin: 0 0 8px;
        font-family: var(--font-display);
        font-size: 1.02rem;
        font-weight: 900;
        color: var(--on-surface);
    }

    .no-preview p {
        max-width: 420px;
        margin: 0 auto 18px;
        color: var(--text-2);
        font-size: 0.84rem;
        line-height: 1.65;
    }

    @media (max-width: 1000px) {
        .detail-layout {
            grid-template-columns: 1fr;
        }

        .preview-shell,
        .preview-frame,
        .image-preview,
        .no-preview {
            min-height: 520px;
        }
    }
</style>
@endpush

@section('content')

<div class="material-detail-page">
    <section class="detail-topbar">
        <div class="detail-heading">
            <a href="{{ route('mahasiswa.materials.index') }}" class="mhs-btn mhs-btn-ghost mhs-btn-sm" title="Kembali">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div class="detail-file-icon"><i class="bi {{ $fileIcon }}"></i></div>
            <div>
                <h1 class="detail-title">{{ $material->title }}</h1>
                <p class="detail-subtitle">
                    {{ $material->subject ? $material->subject->name : 'Materi Umum' }} | Diunggah {{ $material->created_at->format('d M Y') }}
                </p>
            </div>
        </div>
        <div class="detail-actions">
            @if($previewable)
            <a href="{{ $previewUrl }}" target="_blank" rel="noopener" class="mhs-btn mhs-btn-ghost mhs-btn-sm">
                <i class="bi bi-box-arrow-up-right"></i> Buka
            </a>
            @endif
            <a href="{{ $downloadUrl }}" class="mhs-btn mhs-btn-primary mhs-btn-sm">
                <i class="bi bi-download"></i> Unduh File
            </a>
        </div>
    </section>

    <section class="detail-layout">
        <aside class="detail-panel">
            <div class="panel-head">
                <h2 class="panel-title"><i class="bi bi-info-circle" style="color:var(--success);"></i> Detail Materi</h2>
                <span class="mhs-badge muted" style="text-transform:uppercase;">{{ $type ?: 'file' }}</span>
            </div>
            <div class="panel-body">
                <div class="info-list">
                    <div>
                        <div class="info-label">Dosen Pengampu</div>
                        <div class="info-value">{{ $material->user->name ?? 'Tidak diketahui' }}</div>
                    </div>
                    <div>
                        <div class="info-label">Mata Kuliah</div>
                        <div class="info-value">{{ $material->subject ? $material->subject->name : 'Materi Umum' }}</div>
                    </div>
                    <div>
                        <div class="info-label">Nama File</div>
                        <div class="info-value">{{ $material->file_name ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="info-label">Deskripsi</div>
                        <p class="info-description">{{ $material->description ?: 'Tidak ada deskripsi yang ditambahkan.' }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <main class="preview-panel">
            <div class="panel-head">
                <h2 class="panel-title"><i class="bi bi-eye" style="color:var(--secondary);"></i> Pratinjau File</h2>
                <span class="mhs-badge {{ $previewable ? 'success' : 'warning' }}">{{ $previewable ? 'Preview aktif' : 'Download diperlukan' }}</span>
            </div>
            <div class="preview-shell">
                @if($type === 'pdf')
                <iframe src="{{ $previewUrl }}" class="preview-frame" title="Pratinjau {{ $material->title }}"></iframe>
                @elseif(in_array($type, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                <div class="image-preview">
                    <img src="{{ $previewUrl }}" alt="{{ $material->title }}">
                </div>
                @else
                <div class="no-preview">
                    <div>
                        <div class="no-preview-icon"><i class="bi {{ $fileIcon }}"></i></div>
                        <h5>Pratinjau Browser Tidak Tersedia</h5>
                        <p>
                            Format .{{ strtoupper($type ?: 'file') }} biasanya perlu dibuka melalui aplikasi dokumen atau presentasi.
                            Unduh file asli untuk melihat isi materi.
                        </p>
                        <a href="{{ $downloadUrl }}" class="mhs-btn mhs-btn-primary">
                            <i class="bi bi-download"></i> Unduh untuk Melihat
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </main>
    </section>
</div>

@endsection
