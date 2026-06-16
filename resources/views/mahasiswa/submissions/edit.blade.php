@extends('layouts.mahasiswa')

@section('title', 'Edit Pengajuan')

@section('content')

<div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
    <a href="{{ route('mahasiswa.submissions.index') }}" class="mhs-btn mhs-btn-ghost mhs-btn-sm">
        <i class="bi bi-arrow-left"></i> Batal
    </a>
    <h5 style="font-family:var(--font-display);font-weight:700;color:var(--text-1);margin:0;font-size:1rem;">Edit Pengajuan</h5>
</div>

@if($submission->note)
<div class="mhs-alert warning" style="margin-bottom:20px;">
    <i class="bi bi-exclamation-triangle-fill"></i>
    <div>
        <strong>Catatan dari Staff Prodi:</strong>
        <div style="margin-top:4px;">{{ $submission->note }}</div>
    </div>
</div>
@endif

<div class="mhs-card">
    <div class="mhs-card-header">
        <h6 class="mhs-card-title">
            <span class="mhs-card-icon" style="background:var(--warning-light);color:var(--warning);">
                <i class="bi bi-pencil"></i>
            </span>
            Form Edit Pengajuan
        </h6>
    </div>
    <div class="mhs-card-body">
        <form action="{{ route('mahasiswa.submissions.update', $submission->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mhs-form-group">
                <label class="mhs-label">Jenis Pengajuan <span style="color:var(--danger);">*</span></label>
                <select name="type" class="mhs-input" required>
                    <option value="Surat Keterangan Mahasiswa Aktif" {{ old('type', $submission->type) == 'Surat Keterangan Mahasiswa Aktif' ? 'selected' : '' }}>Surat Keterangan Mahasiswa Aktif</option>
                    <option value="Surat Izin Penelitian" {{ old('type', $submission->type) == 'Surat Izin Penelitian' ? 'selected' : '' }}>Surat Izin Penelitian</option>
                    <option value="Pengajuan Cuti Akademik" {{ old('type', $submission->type) == 'Pengajuan Cuti Akademik' ? 'selected' : '' }}>Pengajuan Cuti Akademik</option>
                    <option value="Pengajuan Bebas Kompre/Skripsi" {{ old('type', $submission->type) == 'Pengajuan Bebas Kompre/Skripsi' ? 'selected' : '' }}>Pengajuan Bebas Kompre/Skripsi</option>
                    <option value="Lainnya" {{ old('type', $submission->type) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('type')<div class="mhs-hint" style="color:var(--danger);">{{ $message }}</div>@enderror
            </div>

            <div class="mhs-form-group">
                <label class="mhs-label">Judul Pengajuan <span style="color:var(--danger);">*</span></label>
                <input type="text" name="title" class="mhs-input" value="{{ old('title', $submission->title) }}" required>
                @error('title')<div class="mhs-hint" style="color:var(--danger);">{{ $message }}</div>@enderror
            </div>

            <div class="mhs-form-group">
                <label class="mhs-label">Keterangan / Tujuan</label>
                <textarea name="description" class="mhs-input" rows="4">{{ old('description', $submission->description) }}</textarea>
                @error('description')<div class="mhs-hint" style="color:var(--danger);">{{ $message }}</div>@enderror
            </div>

            <div class="mhs-form-group">
                <label class="mhs-label">File Lampiran</label>
                @if($submission->file_path)
                <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 14px;background:rgba(0,102,255,0.06);border:1px solid rgba(0,102,255,0.2);border-radius:var(--radius-md);margin-bottom:10px;">
                    <span style="font-size:0.82rem;color:var(--text-1);"><i class="bi bi-file-earmark me-2" style="color:var(--primary);"></i>{{ $submission->file_name }}</span>
                    <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="mhs-btn mhs-btn-ghost mhs-btn-sm">Lihat</a>
                </div>
                @endif
                <input type="file" name="file" class="mhs-input" style="padding:6px 10px;">
                <div class="mhs-hint">Biarkan kosong jika tidak ingin mengubah lampiran. Maksimal 5MB.</div>
                @error('file')<div class="mhs-hint" style="color:var(--danger);">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="mhs-btn mhs-btn-primary mhs-btn-full" style="margin-top:8px;">
                <i class="bi bi-save"></i> Perbarui Pengajuan
            </button>
        </form>
    </div>
</div>

@endsection
