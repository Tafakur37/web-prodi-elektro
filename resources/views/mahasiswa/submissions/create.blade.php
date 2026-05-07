@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0 text-dark border-start border-4 border-primary ps-3">Buat Pengajuan Baru</h3>
        <a href="{{ route('mahasiswa.submissions.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('mahasiswa.submissions.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Jenis Pengajuan</label>
                            <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="">-- Pilih Jenis Pengajuan --</option>
                                <option value="Surat Keterangan Mahasiswa Aktif" {{ old('type') == 'Surat Keterangan Mahasiswa Aktif' ? 'selected' : '' }}>Surat Keterangan Mahasiswa Aktif</option>
                                <option value="Surat Izin Penelitian" {{ old('type') == 'Surat Izin Penelitian' ? 'selected' : '' }}>Surat Izin Penelitian</option>
                                <option value="Pengajuan Cuti Akademik" {{ old('type') == 'Pengajuan Cuti Akademik' ? 'selected' : '' }}>Pengajuan Cuti Akademik</option>
                                <option value="Pengajuan Bebas Kompre/Skripsi" {{ old('type') == 'Pengajuan Bebas Kompre/Skripsi' ? 'selected' : '' }}>Pengajuan Bebas Kompre/Skripsi</option>
                                <option value="Lainnya" {{ old('type') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Judul Pengajuan</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Misal: Pengajuan Surat Izin Penelitian untuk PT Maju Jaya" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Keterangan / Tujuan</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Jelaskan secara singkat keperluan Anda...">{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-bold">File Lampiran (Opsional)</label>
                            <input type="file" name="file" class="form-control @error('file') is-invalid @enderror">
                            <div class="form-text">Lampirkan file pendukung jika diperlukan. Maksimal 5MB (PDF/JPG/PNG/DOCX).</div>
                            @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                                <i class="bi bi-send me-2"></i> Kirim Pengajuan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card border-0 shadow-sm rounded-4 bg-light">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-info-circle text-primary me-2"></i> Informasi</h5>
                    <p class="text-muted small mb-3">
                        Pengajuan yang Anda kirim akan ditinjau oleh Staff Prodi. Proses peninjauan biasanya memakan waktu 1-3 hari kerja.
                    </p>
                    <p class="text-muted small mb-0">
                        Anda dapat memantau status pengajuan Anda melalui halaman daftar Surat & Berkas.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
