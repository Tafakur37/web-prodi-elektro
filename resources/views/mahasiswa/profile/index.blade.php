@extends('layouts.mahasiswa')

@section('title', 'Profil & Akun')

@section('content')

<div style="display:grid;grid-template-columns:280px 1fr;gap:20px;align-items:start;">

    {{-- Profile Card --}}
    <div class="mhs-card">
        <div class="mhs-card-body" style="text-align:center;padding:28px 20px;">
            {{-- Avatar --}}
            <div style="width:90px;height:90px;border-radius:24px;overflow:hidden;margin:0 auto 16px;background:linear-gradient(135deg,var(--primary),var(--cyan));display:flex;align-items:center;justify-content:center;font-size:2.5rem;color:#fff;font-weight:800;font-family:var(--font-display);border:3px solid rgba(0,198,255,0.3);box-shadow:0 0 20px rgba(0,102,255,0.25);">
                @if($user->profile_photo)
                    <img src="{{ asset('storage/profiles/' . $user->profile_photo) }}" alt="Foto" style="width:100%;height:100%;object-fit:cover;">
                @else
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                @endif
            </div>

            <h5 style="font-family:var(--font-display);font-weight:700;color:var(--text-1);margin:0 0 4px;font-size:1rem;">{{ $user->name }}</h5>
            <p style="font-size:0.78rem;color:var(--text-2);margin:0 0 14px;">{{ $user->email }}</p>

            <div style="display:flex;justify-content:center;gap:8px;margin-bottom:16px;flex-wrap:wrap;">
                <span class="mhs-badge primary" style="text-transform:uppercase;">{{ $user->role }}</span>
                @if($user->nim)
                <span class="mhs-badge muted">{{ $user->nim }}</span>
                @endif
            </div>

            <div style="padding-top:14px;border-top:1px solid var(--border);text-align:left;">
                <div style="font-size:0.68rem;font-weight:700;color:var(--text-3);text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">Terdaftar Sejak</div>
                <div style="font-size:0.84rem;font-weight:600;color:var(--text-1);">{{ $user->created_at->format('d M Y') }}</div>
            </div>
        </div>
    </div>

    {{-- Form Edit --}}
    <div class="mhs-card">
        <div class="mhs-card-header">
            <h6 class="mhs-card-title">
                <span class="mhs-card-icon" style="background:var(--primary-light);color:var(--primary);">
                    <i class="bi bi-person-gear"></i>
                </span>
                Pengaturan Akun
            </h6>
        </div>
        <div class="mhs-card-body">
            <form action="{{ route('mahasiswa.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-bottom:24px;">
                    <div class="mhs-form-group">
                        <label class="mhs-label">Nama Lengkap <span style="color:var(--danger);">*</span></label>
                        <input type="text" name="name" class="mhs-input" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="mhs-form-group">
                        <label class="mhs-label">Jenis Kelamin</label>
                        <select name="gender" class="mhs-input">
                            <option value="">Pilih</option>
                            <option value="L" {{ old('gender', $user->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender', $user->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="mhs-form-group">
                        <label class="mhs-label">Foto Profil Baru (Opsional)</label>
                        <input type="file" name="profile_photo" class="mhs-input" accept="image/*" style="padding:6px 10px;">
                        <div class="mhs-hint">Format: JPG/PNG, Maks: 2MB.</div>
                        @if($user->profile_photo)
                        <div style="margin-top:8px;display:flex;align-items:center;gap:8px;">
                            <input type="checkbox" name="remove_photo" value="1" id="removePhoto" class="form-check-input">
                            <label for="removePhoto" style="font-size:0.75rem;color:var(--danger);cursor:pointer;">Hapus foto profil saat ini</label>
                        </div>
                        @endif
                    </div>
                </div>

                <div style="height:1px;background:var(--border);margin-bottom:20px;"></div>

                <h6 style="font-family:var(--font-display);font-weight:700;font-size:0.88rem;color:var(--text-1);margin-bottom:6px;">
                    <i class="bi bi-shield-lock me-2" style="color:var(--warning);"></i>Ganti Password (Opsional)
                </h6>
                <p style="font-size:0.75rem;color:var(--text-3);margin-bottom:16px;">Biarkan kosong jika Anda tidak ingin mengubah kata sandi.</p>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">
                    <div class="mhs-form-group">
                        <label class="mhs-label">Password Baru</label>
                        <input type="password" name="password" class="mhs-input" placeholder="Minimal 8 karakter">
                    </div>
                    <div class="mhs-form-group">
                        <label class="mhs-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="mhs-input" placeholder="Ulangi password baru">
                    </div>
                </div>

                <div style="display:flex;justify-content:flex-end;padding-top:16px;border-top:1px solid var(--border);">
                    <button type="submit" class="mhs-btn mhs-btn-primary">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection
