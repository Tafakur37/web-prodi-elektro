<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMelek</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
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

    .login-container {
        width: 100%;
        max-width: 430px;
        padding: 20px;
    }

    .login-card {
        background: rgba(255, 255, 255, 0.07);
        border: 1px solid rgba(255,255,255,0.10);
        backdrop-filter: blur(18px);
        border-radius: 28px;
        padding: 42px 38px;
        box-shadow:
            0 10px 35px rgba(0,0,0,0.35),
            0 0 20px rgba(0,102,255,0.08);
    }

    .btn-primary {
        border: none;
        border-radius: 12px;
        padding: 14px;
        font-weight: 600;
        font-size: 17px;
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
        background: linear-gradient(
            90deg,
            #0d5eff,
            #4da2ff
        );
    }

    .form-control {
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 12px;
        padding: 14px 16px;
        color: white;
        transition: all 0.3s ease;
    }

    .form-control::placeholder {
        color: rgba(255,255,255,0.45);
    }

    .form-control:focus {
        background: rgba(255,255,255,0.10);
        border-color: #4f9dff;
        box-shadow: 0 0 0 4px rgba(79,157,255,0.15);
        color: white;
    }

    .simelek-title {
        font-size: 52px;
        font-weight: 800;
        background: linear-gradient(
            90deg,
            #2d7fff,
            #5ba8ff,
            #b8d9ff
        );
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    a {
        transition: 0.3s ease;
    }

    a:hover {
        opacity: 0.8;
    }

    @media (max-width: 576px) {

    .login-card {
        padding: 35px 28px;
    }

    .simelek-title {
        font-size: 42px;
    }
}

    </style>
</head>

<body>

    <div class="container login-container">
        <div class="login-card">
            <div class="text-center mb-2">
                <h1 class="simelek-title">SIMelek
                </h1>
                <p class="text-light opacity-75">Masuk ke akun Anda
                </p>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nim" class="form-label text-light">Username / NIM</label>
                    <input type="text" name="nim" id="nim" class="form-control @error('nim') is-invalid @enderror"
                        placeholder="Masukkan NIM atau Username" value="{{ old('nim') }}" required autofocus>
                    @error('nim')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label text-light">Password</label>
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password"
                        required>
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-end mb-3">
                    <a href="{{ route('password.request') }}" class="small text-decoration-none">Lupa password?</a>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">Masuk</button>

                <div class="text-center">
                    <a href="{{ url('/') }}"
                        class="text-decoration-none small text-primary d-inline-flex align-items-center">
                        <i class="bi bi-arrow-left me-2"></i> Kembali ke Beranda
                    </a>
                </div>
            </form>

            <div class="text-center mt-4 pt-3 border-top">
                <p class="small text-light">Belum punya akun?
                    <a href="{{ route('register') }}" class="text-decoration-none fw-bold text-primary">Daftar
                        Sekarang</a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>


