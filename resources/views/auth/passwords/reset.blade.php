<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Password - Teknik Elektro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow border-0" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <h4 class="text-center fw-bold mb-4">Password Baru</h4>

                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $email ?? old('email') }}" required readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Password Baru</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required autofocus>
                            @error('password') <span class="invalid-feedback small">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-secondary">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Perbarui Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>