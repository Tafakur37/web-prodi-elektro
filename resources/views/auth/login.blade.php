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
        background-color: #f8f9fa;
        font-family: 'Inter', sans-serif;
    }

    .login-container {
        max-width: 400px;
        margin-top: 100px;
    }

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    }

    .btn-primary {
        border-radius: 8px;
        padding: 12px;
        font-weight: 600;
        background-color: #0d6efd;
    }

    .form-control {
        border-radius: 8px;
        padding: 10px;
    }
    </style>
</head>

<body>

    <div class="container login-container">
        <div class="card p-4">
            <div class="text-center mb-4">
                <h3 class="fw-bold text-primary">SIMelek</h3>
                <p class="text-muted">Masuk ke akun Anda</p>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nim" class="form-label">Username / NIM</label>
                    <input type="text" name="nim" id="nim" class="form-control @error('nim') is-invalid @enderror"
                        placeholder="Masukkan NIM atau Username" value="{{ old('nim') }}" required autofocus>
                    @error('nim')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
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
                        class="text-decoration-none small text-secondary d-inline-flex align-items-center">
                        <i class="bi bi-arrow-left me-2"></i> Kembali ke Beranda
                    </a>
                </div>
            </form>

            <div class="text-center mt-4 pt-3 border-top">
                <p class="small text-muted">Belum punya akun?
                    <a href="{{ route('register') }}" class="text-decoration-none fw-bold text-primary">Daftar
                        Sekarang</a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>