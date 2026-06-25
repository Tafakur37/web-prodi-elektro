<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password – SIMelek | Teknik Elektro UNHAN RI</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-container:  #001f3f;
            --secondary:          #0059bb;
            --secondary-container:#0070ea;
            --background:         #f8f9fa;
            --surface:            #ffffff;
            --surface-low:        #f3f4f5;
            --outline-variant:    #c4c6cf;
            --on-surface:         #191c1d;
            --on-surface-variant: #43474e;
            --card-shadow: 0 1px 4px rgba(0,31,63,0.06), 0 2px 12px rgba(0,31,63,0.05);
            --font-display: 'Montserrat', sans-serif;
            --font-body:    'Inter', sans-serif;
            --font-label:   'JetBrains Mono', monospace;
            --ease-spring:  cubic-bezier(0.22, 1, 0.36, 1);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            font-family: var(--font-body);
            background: var(--background);
            background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Cg stroke='%230059bb' stroke-width='0.5' stroke-opacity='0.04'%3E%3Cpath d='M40 40c0-8.8 7.2-16 16-16s16 7.2 16 16-7.2 16-16 16-16-7.2-16-16zM0 0h80v80H0V0zm1 1v78h78V1H1zm39 39c0-5.5 4.5-10 10-10s10 4.5 10 10-4.5 10-10 10-10-4.5-10-10z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            display: flex; align-items: center; justify-content: center;
            overflow-x: hidden;
        }

        body::before {
            content: ''; position: fixed;
            top: -200px; left: 50%; transform: translateX(-50%);
            width: 800px; height: 600px; border-radius: 50%;
            background: radial-gradient(circle, rgba(0,89,187,0.06) 0%, transparent 65%);
            pointer-events: none; z-index: 0;
        }

        .auth-wrap {
            position: relative; z-index: 1;
            width: 100%; max-width: 440px; padding: 24px;
            animation: page-in 0.6s var(--ease-spring) both;
        }

        @keyframes page-in {
            from { opacity: 0; transform: translateY(28px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .auth-brand {
            display: flex; align-items: center; gap: 12px;
            justify-content: center; margin-bottom: 28px;
        }
        .auth-brand img {
            width: 40px; height: 40px; border-radius: 50%;
            border: 2px solid rgba(0,89,187,0.2);
            box-shadow: 0 2px 8px rgba(0,31,63,0.1); object-fit: cover;
        }
        .auth-brand .b-name {
            font-family: var(--font-display); font-size: 0.85rem;
            font-weight: 700; color: var(--primary-container); line-height: 1.15;
        }
        .auth-brand .b-sub {
            font-family: var(--font-label); font-size: 0.58rem;
            color: var(--secondary); letter-spacing: 0.1em; text-transform: uppercase;
        }

        .auth-card {
            background: var(--surface);
            border: 1px solid rgba(0,31,63,0.08);
            border-radius: 16px; padding: 40px 36px;
            box-shadow: var(--card-shadow);
        }

        .auth-card > * { animation: child-in 0.5s var(--ease-spring) both; }
        .auth-card > *:nth-child(1) { animation-delay: 0.06s; }
        .auth-card > *:nth-child(2) { animation-delay: 0.11s; }
        .auth-card > *:nth-child(3) { animation-delay: 0.16s; }
        .auth-card > *:nth-child(4) { animation-delay: 0.21s; }
        .auth-card > *:nth-child(5) { animation-delay: 0.26s; }
        .auth-card > *:nth-child(6) { animation-delay: 0.31s; }
        .auth-card > *:nth-child(7) { animation-delay: 0.36s; }

        @keyframes child-in {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Icon box */
        .icon-box {
            width: 56px; height: 56px; border-radius: 12px;
            background: rgba(0,89,187,0.08);
            border: 1px solid rgba(0,89,187,0.15);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 20px; color: var(--secondary);
        }

        .auth-eyebrow {
            font-family: var(--font-label); font-size: 0.65rem;
            letter-spacing: 0.18em; text-transform: uppercase;
            color: var(--secondary); display: flex; align-items: center; gap: 10px;
            margin-bottom: 10px;
        }
        .auth-eyebrow::before {
            content: ''; width: 18px; height: 1px;
            background: var(--secondary); opacity: 0.4;
        }

        .auth-title {
            font-family: var(--font-display); font-size: 1.6rem;
            font-weight: 800; letter-spacing: -0.02em;
            color: var(--primary-container); margin-bottom: 6px;
        }

        .auth-subtitle {
            font-family: var(--font-body); font-size: 0.85rem;
            color: var(--on-surface-variant); line-height: 1.65; margin-bottom: 28px;
        }

        .form-group { margin-bottom: 18px; }

        .form-label-custom {
            display: block; font-family: var(--font-label); font-size: 0.65rem;
            letter-spacing: 0.1em; text-transform: uppercase;
            color: var(--on-surface-variant); margin-bottom: 7px;
        }

        .input-wrap { position: relative; }

        .input-icon {
            position: absolute; left: 13px; top: 50%;
            transform: translateY(-50%);
            color: var(--outline-variant); font-size: 1.05rem;
            pointer-events: none; transition: color 0.2s;
        }

        .form-input {
            width: 100%; padding: 12px 14px 12px 42px;
            font-family: var(--font-body); font-size: 0.875rem;
            color: var(--on-surface); background: var(--surface-low);
            border: 1.5px solid var(--outline-variant); border-radius: 8px;
            outline: none; transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .form-input::placeholder { color: #b0b4bb; }
        .form-input:focus {
            background: #fff; border-color: var(--secondary);
            box-shadow: 0 0 0 3px rgba(0,89,187,0.1);
        }
        .input-wrap:focus-within .input-icon { color: var(--secondary); }
        .form-input.is-invalid { border-color: #c0392b; box-shadow: 0 0 0 3px rgba(192,57,43,0.08); }

        .invalid-msg {
            font-family: var(--font-label); font-size: 0.65rem;
            color: #c0392b; margin-top: 5px;
            display: flex; align-items: center; gap: 4px;
        }

        .alert-ok {
            background: #f0fdf4; border: 1px solid #bbf7d0;
            border-left: 3px solid #22c55e;
            border-radius: 8px; padding: 14px 16px; margin-bottom: 20px;
            display: flex; align-items: flex-start; gap: 10px;
        }
        .alert-ok .ao-icon { color: #16a34a; flex-shrink: 0; font-size: 1.1rem; margin-top: 1px; }
        .alert-ok p { font-family: var(--font-body); font-size: 0.82rem; color: #15803d; line-height: 1.55; }

        .alert-err {
            background: #fef2f2; border: 1px solid #fecaca;
            border-left: 3px solid #ef4444;
            border-radius: 8px; padding: 12px 14px; margin-bottom: 20px;
        }
        .alert-err p { font-family: var(--font-body); font-size: 0.82rem; color: #b91c1c; }

        .btn-auth {
            width: 100%; padding: 13px;
            background: var(--primary-container); color: #fff;
            font-family: var(--font-display); font-size: 0.875rem; font-weight: 700;
            border: none; border-radius: 8px; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 16px rgba(0,31,63,0.18);
            position: relative; overflow: hidden; margin-top: 6px;
        }
        .btn-auth::after {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.07) 0%, transparent 55%);
            pointer-events: none;
        }
        .btn-auth:hover { background: #000613; transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,31,63,0.25); }
        .btn-auth:active { transform: translateY(0); }
        .btn-arrow { transition: transform 0.2s; margin-left: auto; }
        .btn-auth:hover .btn-arrow { transform: translateX(4px); }

        .auth-divider {
            display: flex; align-items: center; gap: 12px; margin: 22px 0;
        }
        .auth-divider::before, .auth-divider::after {
            content: ''; flex: 1; height: 1px; background: var(--outline-variant); opacity: 0.5;
        }
        .auth-divider span {
            font-family: var(--font-label); font-size: 0.6rem;
            letter-spacing: 0.1em; text-transform: uppercase;
            color: var(--on-surface-variant); opacity: 0.6;
        }

        .auth-footer { text-align: center; }
        .auth-footer p { font-family: var(--font-body); font-size: 0.83rem; color: var(--on-surface-variant); }
        .auth-link { font-weight: 700; color: var(--secondary); text-decoration: none; transition: opacity 0.2s; }
        .auth-link:hover { opacity: 0.75; }

        .back-link {
            display: inline-flex; align-items: center; gap: 6px;
            font-family: var(--font-body); font-size: 0.78rem;
            color: var(--on-surface-variant); text-decoration: none;
            margin-top: 22px; transition: color 0.2s; opacity: 0.7;
        }
        .back-link:hover { color: var(--secondary); opacity: 1; }

        @keyframes spin { to { transform: rotate(360deg); } }

        @media (max-width: 520px) {
            .auth-card { padding: 28px 20px; }
            .auth-wrap { padding: 16px; }
        }
    </style>
</head>
<body>

    <div class="auth-wrap">

        <div class="auth-brand">
            <img src="/images/logo-elektro.png" alt="Logo Elektro">
            <div>
                <div class="b-name">ELECTRICAL ENGINEERING</div>
                <div class="b-sub">Teknik Elektro · UNHAN RI</div>
            </div>
        </div>

        <div class="auth-card">

            <div class="icon-box">
                <span class="material-symbols-outlined" style="font-size:1.5rem;">lock_reset</span>
            </div>

            <div class="auth-eyebrow">Pemulihan Akun</div>
            <h1 class="auth-title">Lupa Password?</h1>
            <p class="auth-subtitle">
                Masukkan alamat email yang terdaftar. Kami akan mengirimkan tautan untuk mereset password Anda.
            </p>

            @if (session('status'))
                <div class="alert-ok">
                    <span class="material-symbols-outlined ao-icon">check_circle</span>
                    <p>{{ session('status') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-err"><p>{{ $errors->first() }}</p></div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" id="resetForm">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label-custom">Alamat Email</label>
                    <div class="input-wrap">
                        <span class="material-symbols-outlined input-icon">mail</span>
                        <input type="email" name="email" id="email"
                            class="form-input @error('email') is-invalid @enderror"
                            placeholder="nama@email.com"
                            value="{{ old('email') }}" required autofocus>
                    </div>
                    @error('email')
                        <div class="invalid-msg">
                            <span class="material-symbols-outlined" style="font-size:0.8rem;">error</span>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn-auth" id="submitBtn">
                    <span class="material-symbols-outlined" style="font-size:1rem;">send</span>
                    Kirim Tautan Reset
                    <span class="material-symbols-outlined btn-arrow" style="font-size:0.95rem;">arrow_forward</span>
                </button>
            </form>

            <div class="auth-divider"><span>atau</span></div>

            <div class="auth-footer">
                <p>Ingat password? <a href="{{ route('login') }}" class="auth-link">Masuk sekarang</a></p>
            </div>

            <div style="text-align:center;">
                <a href="{{ url('/') }}" class="back-link">
                    <span class="material-symbols-outlined" style="font-size:0.9rem;">arrow_back</span>
                    Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>

    <script>
        document.getElementById('resetForm').addEventListener('submit', function () {
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerHTML = `<span class="material-symbols-outlined" style="font-size:1rem;animation:spin 0.8s linear infinite;">progress_activity</span> Mengirim...`;
        });
    </script>

</body>
</html>