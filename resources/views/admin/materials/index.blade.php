@extends('layouts.app')

@section('title', 'Bahan Ajar')

@section('content')
<div class="container-fluid text-white">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Monitoring Bahan Ajar</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
            <a href="{{ route('admin.materials.create') }}" class="btn btn-primary">
                <i class="bi bi-upload me-2"></i> Upload Materi Baru
            </a>
    </div>

    <div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-dark border-secondary shadow-lg">
                <form action="{{ route('admin.materials.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header border-secondary">
                        <h5 class="modal-title fw-bold">Upload Materi Baru</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label text-secondary">Judul Materi <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="title" value="{{ old('title') }}"
                                    class="form-control bg-dark text-white border-secondary @error('title') is-invalid @enderror"
                                    required>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label text-secondary">Angkatan <span
                                        class="text-danger">*</span></label>
                                <select name="cohort"
                                    class="form-select bg-dark text-white border-secondary @error('cohort') is-invalid @enderror"
                                    required>
                                    <option value="">Pilih Cohort</option>
                                    @foreach($availableCohorts ?? [] as $cohort)
                                    <option value="{{ $cohort }}" {{ old('cohort') == $cohort ? 'selected' : '' }}>
                                        Cohort {{ $cohort }}</option>
                                    @endforeach
                                </select>
                                @error('cohort')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary">Deskripsi (Opsional)</label>
                            <textarea name="description" class="form-control bg-dark text-white border-secondary"
                                rows="2" placeholder="Ringkasan materi...">{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary">File Materi <span class="text-danger">*</span>
                                (PDF, DOC, PPT max 10MB)</label>
                            <input type="file" name="file"
                                class="form-control bg-dark text-white border-secondary @error('file') is-invalid @enderror"
                                accept=".pdf,.doc,.docx,.ppt,.pptx" required>
                            @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary">Target Akses</label>
                            <select name="target_role" class="form-select bg-dark text-white border-secondary">
                                <option value="mahasiswa" selected>Mahasiswa</option>
                                <option value="dosen">Dosen</option>
                                <option value="staff">Staff</option>
                            </select>
                            @error('target_role')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer border-secondary">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">Publikasikan Materi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <table class="table table-dark table-hover">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Pengirim</th>
                    <th>Deskripsi</th>
                    <th>Tipe</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($materials as $material)
                <tr>
                    <td><strong>{{ $material->title }}</strong></td>
                    <td><span class="badge bg-info">{{ $material->user->name }}</span></td>
                    <td>{{ Str::limit($material->description, 50) }}</td>
                    <td><span class="text-uppercase text-warning">{{ $material->file_type }}</span></td>
                    <td>{{ $material->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ asset('storage/' . $material->file_path) }}"
                            download="{{ $material->title }}.{{ $material->file_type }}"
                            class="btn btn-sm btn-outline-light">
                            <i class="bi bi-download me-1"></i> Download
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
