@extends('layouts.app')

@section('title', 'Settings')

@push('styles')
<style>
    .settings-card {
        background: var(--card-bg, #1a1e23);
        border: 1px solid var(--card-border, #2c3238);
        border-radius: 12px;
    }
    
    .nav-tabs .nav-link {
        color: var(--text-muted-custom, #999);
        border: none;
        padding: 1rem 1.5rem;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .nav-tabs .nav-link.active {
        background: transparent;
        color: #00d2ff;
        border-bottom: 2px solid #00d2ff;
    }

    .form-control-custom, .form-select-custom {
        background-color: var(--input-bg, #2c3238);
        border: 1px solid var(--input-border, #3c4248);
        color: var(--body-color, #fff);
    }
    
    .form-control-custom:focus, .form-select-custom:focus {
        background-color: var(--input-focus-bg, #363c43);
        border-color: #00d2ff;
        color: var(--body-color, #fff);
        box-shadow: none;
    }

    .profile-img-preview {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #00d2ff;
    }
</style>
@endpush

@section('content')
<div class="mb-4">
    <h2 class="fw-bold mb-0 text-white"><i class="bi bi-gear me-2 accent-color"></i> Personal Settings</h2>
    <p class="text-secondary small">Kelola informasi profil, keamanan, dan preferensi akun Anda.</p>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="settings-card shadow-sm mb-5">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs px-3 pt-3 border-0" style="border-bottom: 1px solid var(--card-border) !important;" id="settingsTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">PROFILE</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab">SECURITY</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="preferences-tab" data-bs-toggle="tab" data-bs-target="#preferences" type="button" role="tab">PREFERENCES</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="activity-tab" data-bs-toggle="tab" data-bs-target="#activity" type="button" role="tab">ACTIVITY</button>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content p-4">
        <!-- PROFILE TAB -->
        <div class="tab-pane fade show active" id="profile" role="tabpanel" tabindex="0">
            <form action="{{ route('admin.settings.profile') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-3 text-center mb-4">
                        @if($user->profile_photo)
                            <img src="{{ asset('storage/profiles/' . $user->profile_photo) }}" alt="Profile" class="profile-img-preview mb-3 shadow">
                        @else
                            <div class="profile-img-preview mx-auto mb-3 d-flex align-items-center justify-content-center bg-secondary">
                                <i class="bi bi-person text-white fs-1"></i>
                            </div>
                        @endif
                        <div>
                            <label for="profile_photo" class="btn btn-sm btn-outline-info w-100">Ganti Foto</label>
                            <input type="file" id="profile_photo" name="profile_photo" class="d-none" accept="image/*">
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="mb-3">
                            <label class="form-label text-secondary small text-uppercase fw-bold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control form-control-custom @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary small text-uppercase fw-bold">Email Address</label>
                            <input type="email" name="email" class="form-control form-control-custom @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="btn btn-info px-4 text-dark fw-bold">Simpan Profil</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- SECURITY TAB -->
        <div class="tab-pane fade" id="security" role="tabpanel" tabindex="0">
            <form action="{{ route('admin.settings.password') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-secondary small text-uppercase fw-bold">Password Saat Ini</label>
                            <input type="password" name="old_password" class="form-control form-control-custom @error('old_password') is-invalid @enderror">
                            @error('old_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary small text-uppercase fw-bold">Password Baru</label>
                            <input type="password" name="password" class="form-control form-control-custom @error('password') is-invalid @enderror">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-secondary small text-uppercase fw-bold">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control form-control-custom">
                        </div>
                        <button type="submit" class="btn btn-warning px-4 text-dark fw-bold">Update Password</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- PREFERENCES TAB -->
        <div class="tab-pane fade" id="preferences" role="tabpanel" tabindex="0">
            <form action="{{ route('admin.settings.preferences') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="form-label text-secondary small text-uppercase fw-bold d-block mb-3">Pilih Tema Antarmuka</label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="theme" id="themeDark" value="dark" {{ $user->theme == 'dark' || !$user->theme ? 'checked' : '' }}>
                            <label class="form-check-label text-white" for="themeDark">
                                <i class="bi bi-moon-stars me-1"></i> Dark Mode (Default)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="theme" id="themeLight" value="light" {{ $user->theme == 'light' ? 'checked' : '' }}>
                            <label class="form-check-label text-white" for="themeLight">
                                <i class="bi bi-sun me-1"></i> Light Mode
                            </label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-info px-4 text-dark fw-bold">Simpan Preferensi</button>
            </form>
        </div>

        <!-- ACTIVITY TAB -->
        <div class="tab-pane fade" id="activity" role="tabpanel" tabindex="0">
            <h6 class="text-secondary small text-uppercase fw-bold mb-3">Aktivitas Login Terakhir Anda</h6>
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0" style="background-color: transparent;">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--card-border);">
                            <th class="text-secondary small">WAKTU</th>
                            <th class="text-secondary small">IP ADDRESS</th>
                            <th class="text-secondary small">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activities as $act)
                        <tr style="border-bottom: 1px solid var(--card-border);">
                            <td class="py-3 text-white">{{ $act->created_at->format('d M Y H:i') }}</td>
                            <td class="text-muted font-monospace">{{ $act->ip_address }}</td>
                            <td><span class="badge bg-success">Success</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">Belum ada riwayat login.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
