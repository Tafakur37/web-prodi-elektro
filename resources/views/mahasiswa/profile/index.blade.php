@extends('layouts.mahasiswa')

@section('title', 'Profil & Akun')

@push('styles')
<style>
.profile-layout {
    display: grid;
    grid-template-columns: 270px 1fr;
    gap: 18px;
    align-items: start;
}
@media (max-width: 900px) { .profile-layout { grid-template-columns: 1fr; } }

.profile-avatar-wrap {
    width: 88px; height: 88px;
    border-radius: 50%; overflow: hidden;
    margin: 0 auto 14px;
    background: linear-gradient(135deg, var(--secondary), #0070ea);
    display: flex; align-items: center; justify-content: center;
    font-size: 2.4rem; color: #fff; font-weight: 800;
    font-family: var(--font-display);
    box-shadow: 0 6px 20px rgba(0,89,187,0.3);
    border: 3px solid var(--card-glass-border);
    position: relative;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.profile-avatar-wrap:hover { transform: scale(1.04); box-shadow: 0 10px 30px rgba(0,89,187,0.4); }

.profile-info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid var(--outline-variant);
    font-size: 0.83rem;
}
.profile-info-item:last-child { border-bottom: none; }
.profile-info-label { color: var(--text-3); font-size: 0.75rem; font-weight: 600; }
.profile-info-value { color: var(--text-1); font-weight: 600; text-align: right; }

.pw-toggle {
    cursor: pointer;
    user-select: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 6px;
    background: var(--info-light);
    color: var(--secondary);
    font-size: 0.76rem;
    font-weight: 600;
    border: 1px solid rgba(0,89,187,0.18);
    transition: all 0.18s;
}
.pw-toggle:hover { background: var(--secondary); color: #fff; }

#pw-section {
    overflow: hidden;
    max-height: 0;
    transition: max-height 0.4s cubic-bezier(0.4,0,0.2,1), opacity 0.3s ease;
    opacity: 0;
}
#pw-section.open { max-height: 300px; opacity: 1; }
</style>
@endpush

@section('content')

<div class="profile-layout">

    {{-- Profile Card --}}
    <div class="mhs-card">
        <div class="mhs-card-body" style="text-align:center;padding:24px 18px;">
            <div class="profile-avatar-wrap">
                @if($user->profile_photo)
                    <img src="{{ asset('storage/profiles/' . $user->profile_photo) }}" alt="Foto" style="width:100%;height:100%;object-fit:cover;">
                @else
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                @endif
            </div>

            <h5 style="font-family:var(--font-display);font-weight:700;color:var(--text-1);margin:0 0 3px;font-size:0.97rem;">{{ $user->name }}</h5>
            <p style="font-size:0.77rem;color:var(--text-2);margin:0 0 12px;">{{ $user->email }}</p>

            <div style="display:flex;justify-content:center;gap:6px;margin-bottom:16px;flex-wrap:wrap;">
                <span class="mhs-badge primary">{{ $user->role }}</span>
                @if($user->nim)
                <span class="mhs-badge muted">{{ $user->nim }}</span>
                @endif
                @if($user->cohort)
                <span class="mhs-badge cyan">Angkatan {{ $user->cohort }}</span>
                @endif
            </div>

            <div style="padding-top:14px;border-top:1px solid var(--outline-variant);text-align:left;">
                <div class="profile-info-item">
                    <span class="profile-info-label">Jenis Kelamin</span>
                    <span class="profile-info-value">{{ $user->gender === 'L' ? 'Laki-laki' : ($user->gender === 'P' ? 'Perempuan' : '-') }}</span>
                </div>
                <div class="profile-info-item">
                    <span class="profile-info-label">Terdaftar</span>
                    <span class="profile-info-value">{{ $user->created_at->format('d M Y') }}</span>
                </div>
                @if($user->phone)
                <div class="profile-info-item">
                    <span class="profile-info-label">No. HP</span>
                    <span class="profile-info-value">{{ $user->phone }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Form Edit --}}
    <div class="mhs-card">
        <div class="mhs-card-header">
            <h6 class="mhs-card-title">
                <span class="mhs-card-icon" style="background:var(--info-light);color:var(--secondary);">
                    <i class="bi bi-person-gear"></i>
                </span>
                Pengaturan Akun
            </h6>
        </div>
        <div class="mhs-card-body">
            <form action="{{ route('mahasiswa.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;margin-bottom:20px;">
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
                        <label class="mhs-label">Foto Profil Baru</label>
                        <input type="file" name="profile_photo" class="mhs-input" accept="image/*" style="padding:5px 9px;">
                        <div class="mhs-hint">JPG/PNG · Maks 2MB</div>
                        @if($user->profile_photo)
                        <div style="margin-top:7px;display:flex;align-items:center;gap:7px;">
                            <input type="checkbox" name="remove_photo" value="1" id="removePhoto" class="form-check-input">
                            <label for="removePhoto" style="font-size:0.74rem;color:var(--danger);cursor:pointer;margin:0;">Hapus foto saat ini</label>
                        </div>
                        @endif
                    </div>
                </div>

                <div style="height:1px;background:var(--outline-variant);margin-bottom:16px;"></div>

                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
                    <div>
                        <h6 style="font-family:var(--font-display);font-weight:700;font-size:0.87rem;color:var(--text-1);margin:0 0 2px;">
                            <i class="bi bi-shield-lock me-2" style="color:var(--warning);"></i>Ganti Password
                        </h6>
                        <p style="font-size:0.73rem;color:var(--text-3);margin:0;">Biarkan kosong jika tidak ingin mengubah.</p>
                    </div>
                    <button type="button" class="pw-toggle" onclick="document.getElementById('pw-section').classList.toggle('open')">
                        <i class="bi bi-chevron-down"></i> Ubah
                    </button>
                </div>

                <div id="pw-section">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:16px;padding:14px;background:var(--surface-container-low);border-radius:var(--radius-md);border:1px solid var(--outline-variant);">
                        <div class="mhs-form-group" style="margin-bottom:0;">
                            <label class="mhs-label">Password Baru</label>
                            <input type="password" name="password" class="mhs-input" placeholder="Min. 8 karakter">
                        </div>
                        <div class="mhs-form-group" style="margin-bottom:0;">
                            <label class="mhs-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="mhs-input" placeholder="Ulangi password">
                        </div>
                    </div>
                </div>

                <div style="display:flex;justify-content:flex-end;padding-top:14px;border-top:1px solid var(--outline-variant);">
                    <button type="submit" class="mhs-btn mhs-btn-primary">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection
