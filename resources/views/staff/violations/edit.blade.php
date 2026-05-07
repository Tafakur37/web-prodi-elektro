@extends('layouts.app')

@section('title', 'Edit Pelanggaran')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 pb-0">
                <h2 class="h4 mb-0">
                    <i class="bi bi-pencil-square text-primary me-2"></i>
                    Edit Pelanggaran
                </h2>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('staff.violations.update', $violation) }}">
                    @csrf @method('PUT')

                    <input type="hidden" name="user_id" value="{{ $violation->user_id }}">

                    <div class="mb-4">
                        <label class="form-label fw-bold">Mahasiswa</label>
                        <input type="text" class="form-control bg-light" value="{{ $violation->student->name ?? '-' }}"
                            readonly>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
                                value="{{ old('date', $violation->date) }}" required>
                            @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Poin <span class="text-danger">*</span></label>
                            <input type="number" name="point" class="form-control @error('point') is-invalid @enderror"
                                value="{{ old('point', $violation->point) }}" min="1" max="100" required>
                            @error('point') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Judul Pelanggaran <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $violation->title) }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Deskripsi</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                            rows="4">{{ old('description', $violation->description) }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="aktif" {{ old('status', $violation->status) == 'aktif' ? 'selected' : '' }}>
                                Aktif</option>
                            <option value="selesai"
                                {{ old('status', $violation->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex gap-2 pt-3">
                        <a href="{{ route('staff.violations.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Update Pelanggaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection