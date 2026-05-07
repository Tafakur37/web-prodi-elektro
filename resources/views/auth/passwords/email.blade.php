<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Teknik Elektro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow border-0" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <h4 class="text-center fw-bold mb-4">Reset Password</h4>
                    
                    @if (session('status'))
                        <div class="alert alert-success py-2 small">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-secondary">Alamat Email</label>
                            <p class="text-muted" style="font-size: 0.8rem;">Kami akan mengirimkan link reset password ke email Anda.</p>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <span class="invalid-feedback small">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Kirim Link Reset</button>
                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}" class="text-decoration-none small">Kembali ke Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>