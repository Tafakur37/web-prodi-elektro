<?php

/** @var \Illuminate\View\ComponentAttributeBag $attributes */ ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrasi - SIM Elektro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background:
                linear-gradient(
                    135deg,
                    rgba(2, 6, 23, 0.94),
                    rgba(3, 20, 90, 0.88)
                ),
                url('/images/bg-beranda.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }

/* =========================
   CARD
========================= */

        .card {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.10) !important;
            backdrop-filter: blur(18px);
            border-radius: 28px !important;
            box-shadow:
                0 10px 35px rgba(0,0,0,0.35),
                0 0 20px rgba(0,102,255,0.08);
        }

/* =========================
   TITLE
========================= */

        .register-title {
            font-size: 42px;
            font-weight: 800;
            background: linear-gradient(
                90deg,
                #2d7fff,
                #5ba8ff,
                #b8d9ff
            );

            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

/* =========================
   TEXT
========================= */

        .form-label,
        .text-muted,
        .form-text,
        .small {
            color: rgba(255,255,255,0.75) !important;
        }

/* =========================
   INPUT
========================= */

        .form-control,
        .form-select {
            background: rgba(255,255,255,0.08) !important;
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 12px;
            padding: 14px 16px;
            color: white !important;
        }

        .form-control:focus,
        .form-select:focus {
            background: rgba(255,255,255,0.10);
            border-color: #4f9dff;
            box-shadow: 0 0 0 4px rgba(79,157,255,0.15);
            color: white;
        }

/* =========================
   AUTOFILL FIX
========================= */

input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus,
textarea:-webkit-autofill,
select:-webkit-autofill {
    -webkit-text-fill-color: white !important;
    -webkit-box-shadow: 0 0 0px 1000px rgba(255,255,255,0.08) inset !important;
    transition: background-color 5000s ease-in-out 0s;
}

        .form-control::placeholder {
            color: rgba(255,255,255,0.45);
        }

        .form-select option {
            background: #0b1638;
            color: white;
        }

        .form-select {
            appearance: none;
            background-image:
                linear-gradient(45deg, transparent 50%, white 50%),
                linear-gradient(135deg, white 50%, transparent 50%);
            background-position:
                calc(100% - 20px) calc(1.2em),
                calc(100% - 15px) calc(1.2em);
            background-size: 5px 5px;
            background-repeat: no-repeat;
        }

/* =========================
   INPUT GROUP
========================= */

        .input-group-text {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            color: white;
        }

/* =========================
   BUTTON
========================= */

        .btn-primary {
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 600;
            background: linear-gradient(
                90deg,
                #1565ff,
                #298cff
            );

            box-shadow:
                0 8px 20px rgba(21,101,255,0.28);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow:
                0 12px 24px rgba(21,101,255,0.35);
        }

/* =========================
   LINKS
========================= */

        a {
            text-decoration: none;
            transition: 0.3s ease;
        }

        a:hover {
            opacity: 0.8;
        }

    </style>

</head>

<body>
    <div class="container">
        <div class="row justify-content-center w-100">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <i class="fas fa-user-plus fa-3x text-primary mb-3 opacity-75"></i>
                            <h3 class="register-title">Daftar Akun Baru</h3>
                            <p class="text-light opacity-75">Buat akun mahasiswa Teknik Elektro</p>
                        </div>

                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">NIM (12 Digit)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    <input type="text" name="nim"
                                        class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim') }}"
                                        maxlength="12" pattern="[3][0-9]{11}" required placeholder="320250402023">
                                </div>
                                @error('nim') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="form-text">Format: 3 + Tahun + 0402 + Nomor urut (contoh: 320250402023)
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Email</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                    required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Password</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" required>
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                                <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <p class="text-muted small">Sudah punya akun? <a href="{{ route('login') }}"
                                    class="text-primary fw-bold">Login di sini</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>