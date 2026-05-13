<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Teknik Elektro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0, 15, 92, 0.6), rgba(2, 12, 57, 0.6)), url('/images/bg-beranda.png');
            background-size: cover;
            color: white;
            padding: 100px 0;
        }
    </style>
</head>
<body>

        <nav class="navbar navbar-expand-lg navbar-dark shadow-sm"
             style="background-color: #020d34;">
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

    <style>
    .info-card {
        background: linear-gradient(135deg, #001f3f, #003366);
        color: white;
        border-radius: 20px;
        padding: 30px 20px;
        transition: 0.3s ease;
        height: 100%;
    }

    .info-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
    }

    .info-icon {
        font-size: 50px;
        margin-bottom: 20px;
    }

    .info-title {
        font-weight: bold;
        margin-bottom: 15px;
    }
</style>

<style>
    .feature-section {
        background-color: #f8f9fc;
    }

    .feature-card {
        background: white;
        border: none;
        border-radius: 18px;
        padding: 35px 30px;
        height: 100%;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        border-top: 4px solid #001f3f;
    }

    .feature-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.12);
    }

    .feature-title {
        color: #001f3f;
        font-weight: 700;
        margin-bottom: 18px;
        font-size: 1.5rem;
    }

    .feature-text {
        color: #555;
        line-height: 1.8;
        font-size: 15px;
    }

    .section-title {
        color: #001f3f;
        font-weight: bold;
    }

    .section-subtitle {
        color: #6c757d;
    }
</style>

<section class="feature-section py-5">

    <div class="container">

        <div class="text-center mb-5">
            <h2 class="section-title">Teknik Elektro</h2>
            <p class="section-subtitle">
                Pendidikan berkualitas untuk membangun inovasi teknologi masa depan
            </p>
        </div>

        <div class="row g-4">

            <div class="col-md-4">
                <div class="feature-card">
                    <h3 class="feature-title">Visi</h3>

                    <p class="feature-text">
                        Menjadi pusat unggulan pendidikan teknik elektro
                        yang inovatif, adaptif terhadap perkembangan teknologi,
                        dan berdaya saing di tingkat nasional.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card">
                    <h3 class="feature-title">Akreditasi</h3>

                    <p class="feature-text">
                        Program studi telah terakreditasi unggul dengan dukungan
                        fasilitas modern, tenaga pengajar profesional,
                        dan kurikulum berbasis industri.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card">
                    <h3 class="feature-title">Karir</h3>

                    <p class="feature-text">
                        Lulusan memiliki peluang karir luas di bidang energi,
                        telekomunikasi, otomasi industri, teknologi digital,
                        dan berbagai sektor strategis lainnya.
                    </p>
                </div>
            </div>

        </div>

    </div>

</section>

    <footer class="text-white py-4 text-center"
            style="background-color: #020d34;">
        <div class="container">
            <p>&copy; 2026 Web Prodi Teknik Elektro. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>