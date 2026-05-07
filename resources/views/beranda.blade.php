<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Teknik Elektro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1517420704952-d9f39e95b43e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            color: white;
            padding: 100px 0;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">ELEKTRO PRODI</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ms-auto">
        @auth
            <li class="nav-item">
                <span class="nav-link text-light">Halo, {{ Auth::user()->name }}</span>
            </li>
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm ms-2">Logout</button>
                </form>
            </li>
        @else
            <li class="nav-item">
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm px-4">Login</a>
            </li>
            <li class="nav-item ms-lg-2">
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm px-4">Register</a>
            </li>
        @endauth
    </ul>
</div>
        </div>
    </nav>

    <header class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold">Selamat Datang di Teknik Elektro</h1>
            <p class="lead">Membangun Masa Depan dengan Inovasi Teknologi dan Energi Terbarukan.</p>
            <hr class="my-4 border-light w-25 mx-auto">
            <p>Program studi yang berfokus pada sistem tenaga, kendali, dan telekomunikasi.</p>
        </div>
    </header>

    <div class="row">
    {{-- CEK: Jika ini halaman dashboard, tampilkan konten Welcome & Stat --}}
    @if(Request::is('dashboard'))
        <div class="col-md-8">
            <div class="card card-custom p-4 mb-4 bg-white">
                <h4>Selamat Datang, {{ explode(' ', $user->name)[0] }}!</h4>
                </div>
        </div>
        @endif

    {{-- TEMPAT UNTUK KONTEN BAHAN AJAR --}}
        @yield('main_content')
        </div>

    <section class="py-5 bg-light">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm p-3">
                        <h3>Visi</h3>
                        <p>Menjadi pusat unggulan pendidikan teknik elektro yang inovatif di tingkat nasional.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm p-3">
                        <h3>Akreditasi</h3>
                        <p>Program studi kami telah terakreditasi "Unggul" oleh BAN-PT dengan standar fasilitas internasional.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm p-3">
                        <h3>Karir</h3>
                        <p>Lulusan kami tersebar di berbagai sektor mulai dari PLN, perusahaan teknologi, hingga industri manufaktur.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white py-4 text-center">
        <div class="container">
            <p>&copy; 2026 Web Prodi Teknik Elektro. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>