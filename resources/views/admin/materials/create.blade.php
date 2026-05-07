@extends('layouts.app')

@section('title', 'Tambah Bahan Ajar')

@section('content')
<div class="container-fluid text-white">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('admin.materials.index', ['cohort' => request('cohort')]) }}"
                    class="btn btn-outline-secondary me-3 border-0">
                    <i class="bi bi-arrow-left fs-4"></i>
                </a>
                <div>
                    <h2 class="fw-bold mb-0 text-white">Persiapan Unggah Dokumen</h2>
                    <p class="text-secondary mb-0">Menambahkan materi baru untuk <span class="text-primary">Cohort
                            {{ request('cohort') }}</span></p>
                </div>
            </div>

            <div class="card p-4 bg-dark border-secondary shadow-lg" style="border-radius: 15px;">
                <form action="{{ route('admin.materials.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-8 mb-4">
                            <label class="form-label text-secondary small text-uppercase fw-bold">Judul Materi /
                                Dokumen</label>
                            <input type="text" name="title" class="form-control bg-dark text-white border-secondary p-3"
                                placeholder="Contoh: Modul Rangkaian Listrik Pertemuan 1" required>
                        </div>

                        <div class="col-md-4 mb-4">
                            <label class="form-label text-secondary small text-uppercase fw-bold">Target Angkatan
                                (Cohort)</label>
                            <select name="cohort" class="form-select bg-dark text-white border-secondary p-3" required>
                                <option value="">Pilih Angkatan</option>
                                @foreach($availableCohorts as $cohort)
                                <option value="{{ $cohort }}"
                                    {{ old('cohort', request('cohort')) == $cohort ? 'selected' : '' }}>Angkatan
                                    {{ $cohort }}
                                </option>
                                @endforeach
                            </select>
                            @error('cohort')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-secondary small text-uppercase fw-bold">Target Peran
                            (Akses)</label>
                        <select name="target_role" class="form-select bg-dark text-white border-secondary p-3">
                            <option value="mahasiswa">Mahasiswa (Umum)</option>
                            <option value="dosen">Dosen</option>
                            <option value="staff">Staff Prodi</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-secondary small text-uppercase fw-bold">Deskripsi Materi</label>
                        <textarea name="description" class="form-control bg-dark text-white border-secondary p-3"
                            rows="4" placeholder="Berikan ringkasan singkat isi dokumen ini..." required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-secondary small text-uppercase fw-bold">Pilih Dokumen</label>
                        <div
                            class="border border-dashed border-secondary rounded p-5 text-center bg-black bg-opacity-25">
                            <i class="bi bi-cloud-arrow-up text-primary" style="font-size: 3rem;"></i>
                            <input type="file" name="file" class="form-control mt-3 bg-dark text-white border-secondary"
                                required>
                            <small class="text-secondary d-block mt-2">Format: PDF, DOCX, PPTX (Maks. 10MB)</small>
                        </div>
                    </div>

                    <div class="d-grid mt-5">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold p-3">
                            <i class="bi bi-send-check me-2"></i> Publikasikan Materi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .border-dashed {
        border-style: dashed !important;
        border-width: 2px !important;
    }

    .form-control:focus,
    .form-select:focus {
        background-color: #1a1d21;
        border-color: #00d2ff;
        color: white;
        box-shadow: 0 0 0 0.25rem rgba(0, 210, 255, 0.25);
    }
</style>
@endsection
