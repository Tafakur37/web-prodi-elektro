@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('mahasiswa.submissions.index') }}" class="btn btn-outline-secondary rounded-pill px-4 mb-3 d-inline-block">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar
            </a>
            <h3 class="fw-bold mb-1 text-dark border-start border-4 border-primary ps-3">Detail Pengajuan</h3>
        </div>
        @if(in_array($submission->status, ['pending', 'revision']))
            <a href="{{ route('mahasiswa.submissions.edit', $submission->id) }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="bi bi-pencil me-2"></i> Edit Pengajuan
            </a>
        @endif
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 p-md-5">
                    <div class="mb-4 pb-4 border-bottom">
                        <h4 class="fw-bold mb-2">{{ $submission->title }}</h4>
                        <span class="badge bg-light text-dark border">{{ $submission->type }}</span>
                        <span class="text-muted small ms-2"><i class="bi bi-calendar me-1"></i> Diajukan pada {{ $submission->created_at->format('d M Y H:i') }}</span>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold text-secondary mb-3">Keterangan / Tujuan:</h6>
                        <p class="mb-0">{{ $submission->description ?: 'Tidak ada keterangan yang diberikan.' }}</p>
                    </div>

                    @if($submission->file_path)
                    <div class="bg-light p-4 rounded-4 mt-4">
                        <h6 class="fw-bold text-secondary mb-3"><i class="bi bi-paperclip me-2"></i> File Lampiran:</h6>
                        <div class="d-flex justify-content-between align-items-center bg-white p-3 rounded shadow-sm">
                            <span class="text-truncate me-3 fw-medium">{{ $submission->file_name }}</span>
                            <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                <i class="bi bi-download me-1"></i> Unduh
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Status Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 text-center">
                    <h6 class="fw-bold text-muted text-uppercase mb-3">Status Saat Ini</h6>
                    
                    @if($submission->status === 'approved')
                        <div class="text-success mb-2"><i class="bi bi-check-circle-fill" style="font-size: 3rem;"></i></div>
                        <h5 class="fw-bold text-success mb-0">Disetujui</h5>
                    @elseif($submission->status === 'rejected')
                        <div class="text-danger mb-2"><i class="bi bi-x-circle-fill" style="font-size: 3rem;"></i></div>
                        <h5 class="fw-bold text-danger mb-0">Ditolak</h5>
                    @elseif($submission->status === 'revision')
                        <div class="text-warning mb-2"><i class="bi bi-exclamation-circle-fill" style="font-size: 3rem;"></i></div>
                        <h5 class="fw-bold text-warning mb-0">Perlu Revisi</h5>
                    @else
                        <div class="text-secondary mb-2"><i class="bi bi-hourglass-split" style="font-size: 3rem;"></i></div>
                        <h5 class="fw-bold text-secondary mb-0">Menunggu Verifikasi</h5>
                    @endif
                    
                    <p class="text-muted small mt-2">Terakhir diperbarui: {{ $submission->updated_at->diffForHumans() }}</p>
                </div>
            </div>

            <!-- Notes Card -->
            @if($submission->note)
            <div class="card border-0 shadow-sm rounded-4 {{ $submission->status === 'revision' ? 'bg-warning-subtle' : 'bg-light' }}">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3"><i class="bi bi-chat-left-text text-primary me-2"></i> Catatan Staff:</h6>
                    <p class="mb-0">{{ $submission->note }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
