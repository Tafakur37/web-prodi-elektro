<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Password Baru – SIMelek</title>
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
            max-width: 460px;
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

        .form-control[readonly] {
            background: rgba(255,255,255,0.04);
            color: rgba(255,255,255,0.5);
            cursor: not-allowed;
        }

        .form-control.is-invalid {
            border-color: #ff6b6b;
            box-shadow: 0 0 0 3px rgba(255,107,107,0.15);
        }

        .invalid-feedback { color: #ff8585; font-size: 0.82rem; margin-top: 4px; }

        .input-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: rgba(255,255,255,0.45);
            font-size: 17px;
            cursor: pointer;
            padding: 0;
            transition: color 0.2s;
            z-index: 2;
        }

        .toggle-password:hover { color: #5ba8ff; }

        .strength-bar-wrapper {
            margin-top: 8px;
            display: none;
        }

        .strength-bar {
            height: 4px;
            border-radius: 4px;
            background: rgba(255,255,255,0.1);
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.4s ease, background 0.4s ease;
            width: 0%;
        }

        .strength-label {
            font-size: 0.75rem;
            margin-top: 4px;
            color: rgba(255,255,255,0.45);
        }

        .btn-submit {
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
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(21,101,255,0.40);
            background: linear-gradient(90deg, #0d5eff, #4da2ff);
        }

        .btn-submit:disabled {
            opacity: 0.7;
            transform: none;
            cursor: not-allowed;
        }

        .hint-text {
            color: rgba(255,255,255,0.45);
            font-size: 0.80rem;
            margin-top: 6px;
            line-height: 1.5;
        }

        .requirement-list {
            margin-top: 8px;
            padding: 0;
            list-style: none;
        }

        .requirement-list li {
            font-size: 0.78rem;
            color: rgba(255,255,255,0.40);
            display: flex;
            align-items: center;
            gap: 6px;
            transition: color 0.3s;
        }

        .requirement-list li.met { color: #86efac; }
        .requirement-list li .req-icon { font-size: 11px; }

        .divider {
            border-color: rgba(255,255,255,0.10);
            margin: 24px 0;
        }
    </style>
</head>

<body>
    <div class="auth-container">
        <div class="auth-card">

            {{-- Brand --}}
            <div class="text-center mb-4">
                <div class="brand-title">SIMelek</div>
                <div class="icon-circle">
                    <i class="bi bi-key-fill"></i>
                </div>
                <h5 class="text-white fw-bold mb-1">Buat Password Baru</h5>
                <p class="hint-text">Password minimal 8 karakter. Gunakan kombinasi huruf, angka, dan simbol untuk keamanan maksimal.</p>
            </div>

            {{-- Form --}}
            <form id="resetForm" action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                {{-- Email (readonly) --}}
                <div class="mb-3">
                    <label class="form-label">
                        <i class="bi bi-envelope me-1"></i> Email
                    </label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ $email ?? old('email') }}"
                        readonly
                    >
                </div>

                {{-- Password Baru --}}
                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="bi bi-lock me-1"></i> Password Baru
                    </label>
                    <div class="input-wrapper">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control pe-5 @error('password') is-invalid @enderror"
                            placeholder="Min. 8 karakter"
                            required
                            autofocus
                            oninput="checkStrength(this.value)"
                        >
                        <button type="button" class="toggle-password" onclick="togglePw('password', this)">
                            <i class="bi bi-eye-slash" id="eyePassword"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block">
                            <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
                        </div>
                    @enderror

                    {{-- Strength bar --}}
                    <div class="strength-bar-wrapper" id="strengthWrapper">
                        <div class="strength-bar">
                            <div class="strength-fill" id="strengthFill"></div>
                        </div>
                        <div class="strength-label" id="strengthLabel"></div>
                    </div>

                    {{-- Requirements --}}
                    <ul class="requirement-list mt-2" id="reqList">
                        <li id="req-len"><i class="bi bi-circle req-icon"></i> Minimal 8 karakter</li>
                        <li id="req-upper"><i class="bi bi-circle req-icon"></i> Mengandung huruf kapital (A–Z)</li>
                        <li id="req-number"><i class="bi bi-circle req-icon"></i> Mengandung angka (0–9)</li>
                        <li id="req-special"><i class="bi bi-circle req-icon"></i> Mengandung simbol (!@#$...)</li>
                    </ul>
                </div>

                {{-- Konfirmasi Password --}}
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">
                        <i class="bi bi-lock-fill me-1"></i> Konfirmasi Password
                    </label>
                    <div class="input-wrapper">
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="form-control pe-5"
                            placeholder="Ulangi password baru"
                            required
                            oninput="checkMatch()"
                        >
                        <button type="button" class="toggle-password" onclick="togglePw('password_confirmation', this)">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                    <div class="hint-text" id="matchHint"></div>
                </div>

                <button type="submit" id="submitBtn" class="btn-submit">
                    <span id="btnText"><i class="bi bi-check2-circle me-2"></i>Simpan Password Baru</span>
                    <span id="btnLoading" style="display:none;">
                        <span class="spinner-border spinner-border-sm me-2" role="status"></span>Menyimpan...
                    </span>
                </button>
            </form>

            <hr class="divider">

            <div class="text-center">
                <a href="{{ route('login') }}" style="color: rgba(255,255,255,0.5); text-decoration:none; font-size:0.875rem; transition:0.2s;" onmouseover="this.style.color='#5ba8ff'" onmouseout="this.style.color='rgba(255,255,255,0.5)'">
                    <i class="bi bi-arrow-left me-1"></i>Kembali ke Login
                </a>
            </div>

        </div>
    </div>

    <script>
        // Toggle show/hide password
        function togglePw(fieldId, btn) {
            const field = document.getElementById(fieldId);
            const icon = btn.querySelector('i');
            if (field.type === 'password') {
                field.type = 'text';
                icon.className = 'bi bi-eye';
            } else {
                field.type = 'password';
                icon.className = 'bi bi-eye-slash';
            }
        }

        // Password strength checker
        function checkStrength(val) {
            const wrapper = document.getElementById('strengthWrapper');
            const fill = document.getElementById('strengthFill');
            const label = document.getElementById('strengthLabel');

            // Requirements
            const rules = {
                'req-len':     val.length >= 8,
                'req-upper':   /[A-Z]/.test(val),
                'req-number':  /[0-9]/.test(val),
                'req-special': /[^A-Za-z0-9]/.test(val),
            };

            let met = Object.values(rules).filter(Boolean).length;

            Object.entries(rules).forEach(([id, pass]) => {
                const li = document.getElementById(id);
                const icon = li.querySelector('.req-icon');
                li.classList.toggle('met', pass);
                icon.className = pass ? 'bi bi-check-circle-fill req-icon' : 'bi bi-circle req-icon';
            });

            wrapper.style.display = val.length > 0 ? 'block' : 'none';

            const configs = [
                { w: '25%', bg: '#ef4444', text: '⚠ Sangat Lemah' },
                { w: '50%', bg: '#f97316', text: '🔶 Lemah' },
                { w: '75%', bg: '#eab308', text: '🔷 Cukup Kuat' },
                { w: '100%', bg: '#22c55e', text: '✅ Kuat' },
            ];

            const cfg = configs[met - 1] || { w: '0%', bg: 'transparent', text: '' };
            fill.style.width = cfg.w;
            fill.style.background = cfg.bg;
            label.textContent = cfg.text;

            checkMatch();
        }

        // Check password match
        function checkMatch() {
            const pw = document.getElementById('password').value;
            const conf = document.getElementById('password_confirmation').value;
            const hint = document.getElementById('matchHint');
            if (!conf) { hint.textContent = ''; return; }
            if (pw === conf) {
                hint.innerHTML = '<i class="bi bi-check-circle-fill me-1" style="color:#86efac"></i><span style="color:#86efac">Password cocok</span>';
            } else {
                hint.innerHTML = '<i class="bi bi-x-circle-fill me-1" style="color:#ff8585"></i><span style="color:#ff8585">Password tidak cocok</span>';
            }
        }

        // Show loading on submit
        document.getElementById('resetForm').addEventListener('submit', function () {
            document.getElementById('btnText').style.display = 'none';
            document.getElementById('btnLoading').style.display = 'inline-flex';
            document.getElementById('submitBtn').disabled = true;
        });
    </script>
</body>
</html>