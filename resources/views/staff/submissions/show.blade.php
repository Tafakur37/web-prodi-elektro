@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('staff.submissions.index') }}" class="btn btn-outline-secondary rounded-pill px-4 mb-3 d-inline-block">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar
            </a>
            <h3 class="fw-bold mb-1 text-dark border-start border-4 border-primary ps-3">Tinjau Pengajuan</h3>
        </div>
    </div>

    <div class="row">
        <!-- Informasi Pengajuan -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 p-md-5">
                    <div class="mb-4 pb-4 border-bottom">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 50px; height: 50px;">
                                <i class="bi bi-person fs-4"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">{{ $submission->user->name }}</h5>
                                <span class="text-muted small">NIM: {{ $submission->user->nim }} &bull; Angkatan: {{ $submission->user->cohort }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h4 class="fw-bold mb-2">{{ $submission->title }}</h4>
                        <span class="badge bg-light text-dark border">{{ $submission->type }}</span>
                        <span class="text-muted small ms-2"><i class="bi bi-calendar me-1"></i> {{ $submission->created_at->format('d M Y H:i') }}</span>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold text-secondary mb-3">Keterangan / Tujuan:</h6>
                        <p class="mb-0 bg-light p-3 rounded">{{ $submission->description ?: 'Tidak ada keterangan tambahan.' }}</p>
                    </div>

                    @if($submission->file_path)
                    <div class="mt-4">
                        <h6 class="fw-bold text-secondary mb-3"><i class="bi bi-paperclip me-2"></i> File Lampiran:</h6>
                        <div class="d-flex justify-content-between align-items-center bg-white border p-3 rounded shadow-sm">
                            <span class="text-truncate me-3 fw-medium">{{ $submission->file_name }}</span>
                            <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="btn btn-primary btn-sm rounded-pill px-4">
                                <i class="bi bi-download me-1"></i> Unduh / Pratinjau
                            </a>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-secondary border-0 mt-4">
                        <i class="bi bi-info-circle me-2"></i> Mahasiswa tidak melampirkan file dokumen.
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Panel Keputusan -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                    <h5 class="fw-bold mb-0"><i class="bi bi-clipboard-check text-primary me-2"></i> Panel Keputusan</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('staff.submissions.updateStatus', $submission->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Ubah Status</label>
                            <select name="status" class="form-select border-2 @error('status') is-invalid @enderror">
                                <option value="pending" {{ $submission->status === 'pending' ? 'selected' : '' }}>Menunggu (Pending)</option>
                                <option value="approved" {{ $submission->status === 'approved' ? 'selected' : '' }}>Disetujui (Approved)</option>
                                <option value="rejected" {{ $submission->status === 'rejected' ? 'selected' : '' }}>Ditolak (Rejected)</option>
                                <option value="revision" {{ $submission->status === 'revision' ? 'selected' : '' }}>Minta Revisi (Revision)</option>
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Catatan untuk Mahasiswa</label>
                            <textarea name="note" class="form-control" rows="5" placeholder="Berikan alasan penolakan, instruksi revisi, atau catatan persetujuan...">{{ old('note', $submission->note) }}</textarea>
                            <div class="form-text">Catatan ini akan langsung dibaca oleh mahasiswa.</div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                                <i class="bi bi-check2-circle me-2"></i> Simpan Keputusan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
