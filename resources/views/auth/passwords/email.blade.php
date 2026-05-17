<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password – SIMelek</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }

        body {
            min-height: 100vh;
            background:
                linear-gradient(135deg, rgba(2, 6, 23, 0.94), rgba(3, 20, 90, 0.88)),
                url('/images/bg-beranda.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-container {
            width: 100%;
            max-width: 440px;
            padding: 20px;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255,255,255,0.10);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-radius: 28px;
            padding: 44px 40px;
            box-shadow:
                0 10px 35px rgba(0,0,0,0.35),
                0 0 20px rgba(0,102,255,0.08);
        }

        .brand-title {
            font-size: 48px;
            font-weight: 800;
            background: linear-gradient(90deg, #2d7fff, #5ba8ff, #b8d9ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .icon-circle {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, rgba(45,127,255,0.2), rgba(91,168,255,0.1));
            border: 1px solid rgba(45,127,255,0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 26px;
            color: #5ba8ff;
        }

        .form-label {
            color: rgba(255,255,255,0.75);
            font-weight: 500;
            font-size: 0.875rem;
            margin-bottom: 6px;
        }

        .form-control {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 12px;
            padding: 14px 16px;
            color: white;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control::placeholder { color: rgba(255,255,255,0.40); }

        .form-control:focus {
            background: rgba(255,255,255,0.10);
            border-color: #4f9dff;
            box-shadow: 0 0 0 4px rgba(79,157,255,0.15);
            color: white;
            outline: none;
        }

        .form-control.is-invalid {
            border-color: #ff6b6b;
            box-shadow: 0 0 0 3px rgba(255,107,107,0.15);
        }

        .invalid-feedback { color: #ff8585; font-size: 0.82rem; margin-top: 4px; }

        .btn-send {
            background: linear-gradient(90deg, #1565ff, #298cff);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 600;
            font-size: 16px;
            color: white;
            width: 100%;
            box-shadow: 0 8px 20px rgba(21,101,255,0.28);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .btn-send:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(21,101,255,0.40);
            background: linear-gradient(90deg, #0d5eff, #4da2ff);
        }

        .btn-send:active { transform: translateY(0); }

        .btn-send .spinner-border {
            display: none;
            width: 18px;
            height: 18px;
            border-width: 2px;
        }

        .divider {
            border-color: rgba(255,255,255,0.10);
            margin: 24px 0;
        }

        .back-link {
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 0.875rem;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .back-link:hover { color: #5ba8ff; }

        .alert-success-custom {
            background: rgba(34, 197, 94, 0.12);
            border: 1px solid rgba(34, 197, 94, 0.25);
            border-radius: 12px;
            color: #86efac;
            padding: 14px 16px;
            font-size: 0.875rem;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .hint-text {
            color: rgba(255,255,255,0.45);
            font-size: 0.80rem;
            margin-top: 6px;
            line-height: 1.5;
        }
    </style>
</head>

<body>
    <div class="auth-container">
        <div class="auth-card">

            {{-- Logo / Brand --}}
            <div class="text-center mb-4">
                <div class="brand-title">SIMelek</div>
                <div class="icon-circle">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <h5 class="text-white fw-bold mb-1">Lupa Password?</h5>
                <p class="hint-text">Masukkan email akun Anda. Kami akan mengirimkan link untuk membuat password baru.</p>
            </div>

            {{-- Success Alert --}}
            @if (session('status'))
                <div class="alert-success-custom mb-4">
                    <i class="bi bi-check-circle-fill flex-shrink-0" style="font-size: 18px; margin-top: 1px;"></i>
                    <div>
                        <strong>Email terkirim!</strong><br>
                        {{ session('status') }} Silakan cek inbox atau folder spam Anda.
                    </div>
                </div>
            @endif

            {{-- Form --}}
            <form id="forgotForm" action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="email" class="form-label">
                        <i class="bi bi-envelope me-1"></i> Alamat Email
                    </label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="nama@email.com"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                    @error('email')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                    <div class="hint-text">
                        <i class="bi bi-info-circle me-1"></i>
                        Gunakan email yang terdaftar di sistem SIMelek.
                    </div>
                </div>

                <button type="submit" id="submitBtn" class="btn-send">
                    <span id="btnText">
                        <i class="bi bi-send me-2"></i>Kirim Link Reset Password
                    </span>
                    <span id="btnLoading" style="display:none;">
                        <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                        Mengirim...
                    </span>
                </button>
            </form>

            <hr class="divider">

            <div class="text-center">
                <a href="{{ route('login') }}" class="back-link">
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke halaman Login
                </a>
            </div>

        </div>
    </div>

    <script>
        document.getElementById('forgotForm').addEventListener('submit', function () {
            document.getElementById('btnText').style.display = 'none';
            document.getElementById('btnLoading').style.display = 'inline-flex';
            document.getElementById('submitBtn').disabled = true;
        });
    </script>
</body>
</html>