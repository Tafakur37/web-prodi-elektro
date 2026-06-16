@extends('layouts.mahasiswa')

@section('title', 'Buat Pengajuan Baru')

@section('content')

<div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
    <a href="{{ route('mahasiswa.submissions.index') }}" class="mhs-btn mhs-btn-ghost mhs-btn-sm">
        <i class="bi bi-arrow-left"></i>
    </a>
    <div>
        <h5 style="font-family:var(--font-display);font-weight:700;color:var(--text-1);margin:0;font-size:1rem;">Buat Pengajuan Baru</h5>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start;">

    <div class="mhs-card">
        <div class="mhs-card-header">
            <h6 class="mhs-card-title">
                <span class="mhs-card-icon" style="background:var(--warning-light);color:var(--warning);">
                    <i class="bi bi-envelope-paper"></i>
                </span>
                Form Pengajuan
            </h6>
        </div>
        <div class="mhs-card-body">
            <form action="{{ route('mahasiswa.submissions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mhs-form-group">
                    <label class="mhs-label">Jenis Pengajuan <span style="color:var(--danger);">*</span></label>
                    <select name="type" class="mhs-input" required>
                        <option value="">-- Pilih Jenis Pengajuan --</option>
                        <option value="Surat Keterangan Mahasiswa Aktif" {{ old('type') == 'Surat Keterangan Mahasiswa Aktif' ? 'selected' : '' }}>Surat Keterangan Mahasiswa Aktif</option>
                        <option value="Surat Izin Penelitian" {{ old('type') == 'Surat Izin Penelitian' ? 'selected' : '' }}>Surat Izin Penelitian</option>
                        <option value="Pengajuan Cuti Akademik" {{ old('type') == 'Pengajuan Cuti Akademik' ? 'selected' : '' }}>Pengajuan Cuti Akademik</option>
                        <option value="Pengajuan Bebas Kompre/Skripsi" {{ old('type') == 'Pengajuan Bebas Kompre/Skripsi' ? 'selected' : '' }}>Pengajuan Bebas Kompre/Skripsi</option>
                        <option value="Lainnya" {{ old('type') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('type')<div class="mhs-hint" style="color:var(--danger);">{{ $message }}</div>@enderror
                </div>

                <div class="mhs-form-group">
                    <label class="mhs-label">Judul Pengajuan <span style="color:var(--danger);">*</span></label>
                    <input type="text" name="title" class="mhs-input" value="{{ old('title') }}"
                        placeholder="Misal: Pengajuan Surat Izin Penelitian untuk PT Maju Jaya" required>
                    @error('title')<div class="mhs-hint" style="color:var(--danger);">{{ $message }}</div>@enderror
                </div>

                <div class="mhs-form-group">
                    <label class="mhs-label">Keterangan / Tujuan</label>
                    <textarea name="description" class="mhs-input" rows="4"
                        placeholder="Jelaskan secara singkat keperluan Anda...">{{ old('description') }}</textarea>
                    @error('description')<div class="mhs-hint" style="color:var(--danger);">{{ $message }}</div>@enderror
                </div>

                <div class="mhs-form-group">
                    <label class="mhs-label">File Lampiran (Opsional)</label>
                    <input type="file" name="file" class="mhs-input" style="padding:6px 10px;">
                    <div class="mhs-hint">Lampirkan file pendukung jika diperlukan. Maksimal 5MB (PDF/JPG/PNG/DOCX).</div>
                    @error('file')<div class="mhs-hint" style="color:var(--danger);">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="mhs-btn mhs-btn-primary mhs-btn-full" style="margin-top:8px;">
                    <i class="bi bi-send"></i> Kirim Pengajuan
                </button>
            </form>
        </div>
    </div>

    <div class="mhs-card" style="background:rgba(0,102,255,0.06);border-color:rgba(0,102,255,0.15);">
        <div class="mhs-card-body">
            <h6 style="font-family:var(--font-display);font-weight:700;color:var(--primary);margin-bottom:12px;">
                <i class="bi bi-info-circle me-2"></i>Informasi
            </h6>
            <p style="font-size:0.8rem;color:var(--text-2);margin-bottom:12px;line-height:1.6;">
                Pengajuan yang Anda kirim akan ditinjau oleh Staff Prodi. Proses peninjauan biasanya memakan waktu 1–3 hari kerja.
            </p>
            <p style="font-size:0.8rem;color:var(--text-2);margin:0;line-height:1.6;">
                Anda dapat memantau status pengajuan melalui halaman daftar <strong>Surat & Berkas</strong>.
            </p>
        </div>
    </div>

</div>

@endsection
