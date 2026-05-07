@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0 text-dark border-start border-4 border-primary ps-3">Edit Pengajuan</h3>
        <a href="{{ route('mahasiswa.submissions.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i> Batal
        </a>
    </div>

    @if($submission->note)
    <div class="alert alert-warning border-0 rounded-4 shadow-sm mb-4">
        <h6 class="fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i> Catatan dari Staff Prodi:</h6>
        <p class="mb-0 ms-4">{{ $submission->note }}</p>
    </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4 p-md-5">
            <form action="{{ route('mahasiswa.submissions.update', $submission->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="form-label fw-bold">Jenis Pengajuan</label>
                    <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                        <option value="Surat Keterangan Mahasiswa Aktif" {{ old('type', $submission->type) == 'Surat Keterangan Mahasiswa Aktif' ? 'selected' : '' }}>Surat Keterangan Mahasiswa Aktif</option>
                        <option value="Surat Izin Penelitian" {{ old('type', $submission->type) == 'Surat Izin Penelitian' ? 'selected' : '' }}>Surat Izin Penelitian</option>
                        <option value="Pengajuan Cuti Akademik" {{ old('type', $submission->type) == 'Pengajuan Cuti Akademik' ? 'selected' : '' }}>Pengajuan Cuti Akademik</option>
                        <option value="Pengajuan Bebas Kompre/Skripsi" {{ old('type', $submission->type) == 'Pengajuan Bebas Kompre/Skripsi' ? 'selected' : '' }}>Pengajuan Bebas Kompre/Skripsi</option>
                        <option value="Lainnya" {{ old('type', $submission->type) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Judul Pengajuan</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $submission->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Keterangan / Tujuan</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $submission->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-5">
                    <label class="form-label fw-bold">File Lampiran</label>
                    @if($submission->file_path)
                        <div class="mb-2 p-3 bg-light rounded d-flex justify-content-between align-items-center">
                            <span class="text-truncate me-3"><i class="bi bi-file-earmark me-2 text-primary"></i>{{ $submission->file_name }}</span>
                            <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat</a>
                        </div>
                    @endif
                    <input type="file" name="file" class="form-control @error('file') is-invalid @enderror">
                    <div class="form-text">Biarkan kosong jika tidak ingin mengubah lampiran. Maksimal 5MB.</div>
                    @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                        <i class="bi bi-save me-2"></i> Perbarui Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
