<?php /** @var \Illuminate\View\ComponentAttributeBag $attributes */ ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun – SIMelek | Teknik Elektro UNHAN RI</title>

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
            display: flex; align-items: flex-start; justify-content: center;
            padding: 40px 0; overflow-x: hidden; position: relative;
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
            width: 100%; max-width: 500px; padding: 24px;
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
        .auth-card > *:nth-child(1) { animation-delay: 0.05s; }
        .auth-card > *:nth-child(2) { animation-delay: 0.10s; }
        .auth-card > *:nth-child(3) { animation-delay: 0.15s; }
        .auth-card > *:nth-child(4) { animation-delay: 0.19s; }
        .auth-card > *:nth-child(5) { animation-delay: 0.23s; }
        .auth-card > *:nth-child(6) { animation-delay: 0.27s; }
        .auth-card > *:nth-child(7) { animation-delay: 0.31s; }
        .auth-card > *:nth-child(8) { animation-delay: 0.35s; }

        @keyframes child-in {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .auth-eyebrow {
            font-family: var(--font-label); font-size: 0.65rem;
            letter-spacing: 0.18em; text-transform: uppercase;
            color: var(--secondary); display: flex; align-items: center; gap: 10px;
            margin-bottom: 10px;
        }
        .auth-eyebrow::before {
            content: ''; width: 18px; height: 1px; background: var(--secondary); opacity: 0.4;
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

        /* Section label inside form */
        .form-section-lbl {
            font-family: var(--font-label); font-size: 0.6rem;
            letter-spacing: 0.15em; text-transform: uppercase;
            color: var(--on-surface-variant); opacity: 0.55;
            display: flex; align-items: center; gap: 10px;
            margin-bottom: 14px; margin-top: 20px;
        }
        .form-section-lbl:first-child { margin-top: 0; }
        .form-section-lbl::after {
            content: ''; flex: 1; height: 1px; background: var(--outline-variant); opacity: 0.5;
        }

        .form-group { margin-bottom: 16px; }

        .form-row {
            display: grid; grid-template-columns: 1fr 1fr; gap: 14px;
        }

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

        /* Input with toggle button — add right padding */
        .has-toggle { padding-right: 42px; }

        /* Select */
        .form-select {
            width: 100%; padding: 12px 40px 12px 42px;
            font-family: var(--font-body); font-size: 0.875rem;
            color: var(--on-surface); background: var(--surface-low);
            border: 1.5px solid var(--outline-variant); border-radius: 8px;
            outline: none; appearance: none; cursor: pointer;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-select:focus {
            background: #fff; border-color: var(--secondary);
            box-shadow: 0 0 0 3px rgba(0,89,187,0.1);
        }
        .form-select option { background: #fff; color: var(--on-surface); }
        .select-arrow {
            position: absolute; right: 12px; top: 50%;
            transform: translateY(-50%);
            color: var(--outline-variant); pointer-events: none; font-size: 1rem;
        }

        /* Password toggle */
        .pw-toggle {
            position: absolute; right: 12px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: var(--outline-variant); transition: color 0.2s; padding: 0; line-height: 1;
        }
        .pw-toggle:hover { color: var(--secondary); }

        .invalid-msg {
            font-family: var(--font-label); font-size: 0.65rem;
            color: #c0392b; margin-top: 5px;
            display: flex; align-items: center; gap: 4px;
        }

        .alert-err {
            background: #fef2f2; border: 1px solid #fecaca;
            border-left: 3px solid #ef4444;
            border-radius: 8px; padding: 12px 14px; margin-bottom: 20px;
        }
        .alert-err ul { padding-left: 14px; }
        .alert-err li { font-family: var(--font-body); font-size: 0.82rem; color: #b91c1c; line-height: 1.7; }

        .alert-ok {
            background: #f0fdf4; border: 1px solid #bbf7d0;
            border-left: 3px solid #22c55e;
            border-radius: 8px; padding: 12px 14px; margin-bottom: 20px;
        }
        .alert-ok p { font-family: var(--font-body); font-size: 0.82rem; color: #15803d; }

        /* Password strength */
        .pw-strength-wrap { margin-top: 8px; }
        .pw-strength-bar {
            height: 3px; background: var(--outline-variant); opacity: 0.3;
            border-radius: 99px; overflow: hidden; margin-bottom: 5px;
        }
        .pw-strength-fill {
            height: 100%; width: 0; border-radius: 99px;
            transition: width 0.3s, background-color 0.3s;
        }
        .pw-strength-text {
            font-family: var(--font-label); font-size: 0.6rem;
            color: var(--on-surface-variant); opacity: 0.55; letter-spacing: 0.05em;
        }

        .btn-auth {
            width: 100%; padding: 13px;
            background: var(--primary-container); color: #fff;
            font-family: var(--font-display); font-size: 0.875rem; font-weight: 700;
            border: none; border-radius: 8px; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 16px rgba(0,31,63,0.18);
            position: relative; overflow: hidden; margin-top: 8px;
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
            display: flex; align-items: center; gap: 12px; margin: 20px 0;
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

        @media (max-width: 560px) {
            .auth-card { padding: 28px 20px; }
            .auth-wrap { padding: 16px; }
            .form-row  { grid-template-columns: 1fr; gap: 0; }
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

            <div class="auth-eyebrow">Buat Akun Baru</div>
            <h1 class="auth-title">Daftar ke SIMelek</h1>
            <p class="auth-subtitle">Isi data diri dengan lengkap dan benar untuk mendaftarkan akun mahasiswa.</p>

            @if (session('success'))
                <div class="alert-ok"><p>{{ session('success') }}</p></div>
            @endif

            @if ($errors->any())
                <div class="alert-err">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                <!-- Informasi Pribadi -->
                <div class="form-section-lbl">Informasi Pribadi</div>

                <div class="form-group">
                    <label for="name" class="form-label-custom">Nama Lengkap</label>
                    <div class="input-wrap">
                        <span class="material-symbols-outlined input-icon">person</span>
                        <input type="text" name="name" id="name"
                            class="form-input @error('name') is-invalid @enderror"
                            placeholder="Nama sesuai identitas resmi"
                            value="{{ old('name') }}" required>
                    </div>
                    @error('name')
                        <div class="invalid-msg">
                            <span class="material-symbols-outlined" style="font-size:0.8rem;">error</span>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="gender" class="form-label-custom">Jenis Kelamin</label>
                        <div class="input-wrap">
                            <span class="material-symbols-outlined input-icon">wc</span>
                            <select name="gender" id="gender"
                                class="form-select @error('gender') is-invalid @enderror" required>
                                <option value="">Pilih...</option>
                                <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            <span class="material-symbols-outlined select-arrow" style="font-size:0.95rem;">expand_more</span>
                        </div>
                        @error('gender')
                            <div class="invalid-msg">
                                <span class="material-symbols-outlined" style="font-size:0.8rem;">error</span>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nim" class="form-label-custom">NIM (12 Digit)</label>
                        <div class="input-wrap">
                            <span class="material-symbols-outlined input-icon">badge</span>
                            <input type="text" name="nim" id="nim"
                                class="form-input @error('nim') is-invalid @enderror"
                                placeholder="320250402023"
                                value="{{ old('nim') }}"
                                maxlength="12" pattern="[3][0-9]{11}" required>
                        </div>
                        @error('nim')
                            <div class="invalid-msg">
                                <span class="material-symbols-outlined" style="font-size:0.8rem;">error</span>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label-custom">Alamat Email</label>
                    <div class="input-wrap">
                        <span class="material-symbols-outlined input-icon">mail</span>
                        <input type="email" name="email" id="email"
                            class="form-input @error('email') is-invalid @enderror"
                            placeholder="nama@email.com"
                            value="{{ old('email') }}" required>
                    </div>
                    @error('email')
                        <div class="invalid-msg">
                            <span class="material-symbols-outlined" style="font-size:0.8rem;">error</span>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Keamanan -->
                <div class="form-section-lbl">Keamanan Akun</div>

                <div class="form-group">
                    <label for="password" class="form-label-custom">Password</label>
                    <div class="input-wrap">
                        <span class="material-symbols-outlined input-icon">lock</span>
                        <input type="password" name="password" id="password"
                            class="form-input has-toggle @error('password') is-invalid @enderror"
                            placeholder="Minimal 8 karakter" required
                            oninput="checkStrength(this.value)">
                        <button type="button" class="pw-toggle" id="pwToggle1">
                            <span class="material-symbols-outlined" id="pwIcon1" style="font-size:1rem;">visibility</span>
                        </button>
                    </div>
                    <div class="pw-strength-wrap">
                        <div class="pw-strength-bar">
                            <div class="pw-strength-fill" id="strengthFill"></div>
                        </div>
                        <div class="pw-strength-text" id="strengthText">Masukkan password</div>
                    </div>
                    @error('password')
                        <div class="invalid-msg">
                            <span class="material-symbols-outlined" style="font-size:0.8rem;">error</span>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label-custom">Konfirmasi Password</label>
                    <div class="input-wrap">
                        <span class="material-symbols-outlined input-icon">lock</span>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-input has-toggle"
                            placeholder="Ulangi password" required>
                        <button type="button" class="pw-toggle" id="pwToggle2">
                            <span class="material-symbols-outlined" id="pwIcon2" style="font-size:1rem;">visibility</span>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-auth" id="submitBtn">
                    <span class="material-symbols-outlined" style="font-size:1rem;">person_add</span>
                    Buat Akun Sekarang
                    <span class="material-symbols-outlined btn-arrow" style="font-size:0.95rem;">arrow_forward</span>
                </button>
            </form>

            <div class="auth-divider"><span>atau</span></div>

            <div class="auth-footer">
                <p>Sudah punya akun? <a href="{{ route('login') }}" class="auth-link">Masuk sekarang</a></p>
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
        // Toggle show/hide password
        function makePwToggle(btnId, inputId, iconId) {
            document.getElementById(btnId).addEventListener('click', () => {
                const inp  = document.getElementById(inputId);
                const icon = document.getElementById(iconId);
                const show = inp.type === 'password';
                inp.type         = show ? 'text' : 'password';
                icon.textContent = show ? 'visibility_off' : 'visibility';
            });
        }
        makePwToggle('pwToggle1', 'password', 'pwIcon1');
        makePwToggle('pwToggle2', 'password_confirmation', 'pwIcon2');

        // Password strength meter
        function checkStrength(val) {
            const fill = document.getElementById('strengthFill');
            const text = document.getElementById('strengthText');
            let score = 0;
            if (val.length >= 8)          score++;
            if (/[A-Z]/.test(val))        score++;
            if (/[0-9]/.test(val))        score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            const levels = [
                { pct: '0%',   color: 'transparent', label: 'Masukkan password' },
                { pct: '25%',  color: '#ef4444',      label: 'Lemah' },
                { pct: '55%',  color: '#f97316',      label: 'Cukup' },
                { pct: '80%',  color: '#eab308',      label: 'Baik' },
                { pct: '100%', color: '#22c55e',      label: 'Kuat ✓' },
            ];
            const lvl = val.length === 0 ? levels[0] : (levels[score] || levels[1]);
            fill.style.width           = lvl.pct;
            fill.style.backgroundColor = lvl.color;
            text.textContent           = lvl.label;
            text.style.color           = lvl.color === 'transparent' ? '' : lvl.color;
            text.style.opacity         = lvl.color === 'transparent' ? '' : '1';
        }

        // Submit loading state
        document.getElementById('registerForm').addEventListener('submit', function () {
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerHTML = `<span class="material-symbols-outlined" style="font-size:1rem;animation:spin 0.8s linear infinite;">progress_activity</span> Mendaftarkan akun...`;
        });
    </script>

</body>
</html>