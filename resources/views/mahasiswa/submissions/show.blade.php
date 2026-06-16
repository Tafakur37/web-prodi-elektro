@extends('layouts.mahasiswa')

@section('title', 'Detail Pengajuan')

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;gap:12px;">
    <div style="display:flex;align-items:center;gap:12px;">
        <a href="{{ route('mahasiswa.submissions.index') }}" class="mhs-btn mhs-btn-ghost mhs-btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <h5 style="font-family:var(--font-display);font-weight:700;color:var(--text-1);margin:0;font-size:1rem;">Detail Pengajuan</h5>
    </div>
    @if(in_array($submission->status, ['pending', 'revision']))
    <a href="{{ route('mahasiswa.submissions.edit', $submission->id) }}" class="mhs-btn mhs-btn-primary mhs-btn-sm">
        <i class="bi bi-pencil"></i> Edit Pengajuan
    </a>
    @endif
</div>

<div style="display:grid;grid-template-columns:1fr 280px;gap:20px;align-items:start;">

    {{-- Detail Card --}}
    <div class="mhs-card">
        <div class="mhs-card-body">
            <h4 style="font-family:var(--font-display);font-weight:700;color:var(--text-1);margin-bottom:8px;">{{ $submission->title }}</h4>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;padding-bottom:20px;border-bottom:1px solid var(--border);">
                <span class="mhs-badge muted">{{ $submission->type }}</span>
                <span style="font-size:0.75rem;color:var(--text-3);"><i class="bi bi-calendar me-1"></i>Diajukan pada {{ $submission->created_at->format('d M Y H:i') }}</span>
            </div>

            <div style="margin-bottom:20px;">
                <div class="mhs-section-label">Keterangan / Tujuan</div>
                <p style="font-size:0.88rem;color:var(--text-1);line-height:1.6;margin:0;">
                    {{ $submission->description ?: 'Tidak ada keterangan yang diberikan.' }}
                </p>
            </div>

            @if($submission->file_path)
            <div style="background:rgba(0,102,255,0.06);border:1px solid rgba(0,102,255,0.15);border-radius:var(--radius-lg);padding:16px;">
                <div class="mhs-section-label" style="margin-bottom:10px;">File Lampiran</div>
                <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;">
                    <span style="font-size:0.84rem;color:var(--text-1);font-weight:600;"><i class="bi bi-paperclip me-2" style="color:var(--primary);"></i>{{ $submission->file_name }}</span>
                    <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="mhs-btn mhs-btn-primary mhs-btn-sm">
                        <i class="bi bi-download"></i> Unduh
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Sidebar: Status + Notes --}}
    <div>
        <div class="mhs-card" style="margin-bottom:14px;">
            <div class="mhs-card-body" style="text-align:center;padding:24px 20px;">
                <div class="mhs-section-label" style="margin-bottom:14px;">Status Saat Ini</div>
                @if($submission->status === 'approved')
                    <i class="bi bi-check-circle-fill" style="font-size:2.8rem;color:var(--success);display:block;margin-bottom:10px;"></i>
                    <h5 style="font-weight:800;color:var(--success);margin:0;">Disetujui</h5>
                @elseif($submission->status === 'rejected')
                    <i class="bi bi-x-circle-fill" style="font-size:2.8rem;color:var(--danger);display:block;margin-bottom:10px;"></i>
                    <h5 style="font-weight:800;color:var(--danger);margin:0;">Ditolak</h5>
                @elseif($submission->status === 'revision')
                    <i class="bi bi-exclamation-circle-fill" style="font-size:2.8rem;color:var(--warning);display:block;margin-bottom:10px;"></i>
                    <h5 style="font-weight:800;color:var(--warning);margin:0;">Perlu Revisi</h5>
                @else
                    <i class="bi bi-hourglass-split" style="font-size:2.8rem;color:var(--text-3);display:block;margin-bottom:10px;"></i>
                    <h5 style="font-weight:800;color:var(--text-2);margin:0;">Menunggu</h5>
                @endif
                <p style="font-size:0.72rem;color:var(--text-3);margin-top:10px;margin-bottom:0;">Terakhir diperbarui: {{ $submission->updated_at->diffForHumans() }}</p>
            </div>
        </div>

        @if($submission->note)
        <div class="mhs-card" style="background:rgba(255,165,2,0.06);border-color:rgba(255,165,2,0.2);">
            <div class="mhs-card-body">
                <div style="font-family:var(--font-display);font-weight:700;font-size:0.88rem;color:var(--warning);margin-bottom:10px;">
                    <i class="bi bi-chat-left-text me-2"></i>Catatan Staff
                </div>
                <p style="font-size:0.84rem;color:var(--text-1);margin:0;line-height:1.6;">{{ $submission->note }}</p>
            </div>
        </div>
        @endif
    </div>

</div>

@endsection
