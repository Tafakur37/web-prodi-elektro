@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0 text-dark border-start border-4 border-primary ps-3">Unggah Bahan Ajar Baru</h3>
        <a href="{{ route('dosen.materials.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('dosen.materials.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Mata Kuliah</label>
                            <select name="subject_id" class="form-select @error('subject_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Mata Kuliah --</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }} (Sem {{ $subject->semester }})
                                    </option>
                                @endforeach
                            </select>
                            @error('subject_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Angkatan (Cohort)</label>
                            <select name="cohort" class="form-select @error('cohort') is-invalid @enderror" required>
                                <option value="">-- Pilih Angkatan --</option>
                                @foreach($cohorts as $cohort)
                                    <option value="{{ $cohort }}" {{ old('cohort') == $cohort ? 'selected' : '' }}>
                                        Cohort {{ $cohort }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cohort')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Judul Materi</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Misal: Modul 1 - Pengantar Algoritma" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Deskripsi / Konten Teks</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Berikan deskripsi singkat tentang materi ini...">{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-bold">File Lampiran</label>
                            <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" required>
                            <div class="form-text">Maksimal 20MB. Format yang didukung: PDF, DOCX, PPTX, XLSX, ZIP.</div>
                            @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                                <i class="bi bi-cloud-arrow-up me-2"></i> Simpan & Publikasikan
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
                        Materi yang diunggah akan langsung tersedia di dasbor mahasiswa sesuai dengan mata kuliah dan angkatan (cohort) yang Anda pilih.
                    </p>
                    <p class="text-muted small mb-0">
                        Pastikan ukuran file tidak melampaui batas server dan menggunakan format dokumen yang standar agar mudah diakses oleh mahasiswa.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
