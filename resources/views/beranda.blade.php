<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Beranda - Teknik Elektro</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        /* =========================
           GLOBAL
        ========================= */
        body {
            margin: 0;
            padding: 0;
        }

        /* =========================
           NAVBAR
        ========================= */
        .custom-navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 999;
            transition: all 0.4s ease;
            background: transparent;
            padding: 18px 0;
        }

        /* Navbar saat discroll */
        .custom-navbar.scrolled {
            background: rgba(2, 13, 52, 0.96);
            backdrop-filter: blur(8px);
            box-shadow: 0 3px 10px rgba(0,0,0,0.3);
            padding: 10px 0;
        }

        .brand-text {
            line-height: 1;
        }

        .engineering-text {
            background: linear-gradient(90deg, #00c6ff, #0072ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .electrical-text {
            color: white;
        }

        .univ-text {
            font-size: 0.55rem;
            color: rgba(255,255,255,0.8);
        }

        /* =========================
           HERO SECTION
        ========================= */
        .hero-section {
            height: 100vh;

            background:
               linear-gradient(
                    90deg,
                    rgba(1, 3, 17, 0.85),
                    rgba(4, 24, 114, 0.45)
                ),
                url('/images/bg-beranda.jpg');

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;

            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            text-align: center;

            min-height: 100vh;
            justify-content: flex-start;
            padding-left: 10px;
        }

        .hero-content {
            text-align: left;
        }

        .hero-content h1 {
            font-size: 4rem;
            font-weight: 800;
        }

        .hero-content p {
            font-size: 1.2rem;
        }

        .hero-title {
            font-size: 80px;
            font-weight: 800;
            line-height: 1.3;
            color: white;
        }

        .gradient-text {
            background: linear-gradient(90deg, #00c6ff, #0072ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }

        .text-white {
            color: white;
        }

        /* =========================
           INFO CARD
        ========================= */
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

        /* =========================
           FEATURE SECTION
        ========================= */
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

</head>

<body>

    <!-- =========================
         NAVBAR
    ========================== -->
    <nav class="navbar navbar-expand-lg navbar-dark custom-navbar">

        <div class="container-fluid px-4">

            <a class="navbar-brand fw-bold d-flex align-items-center gap-3" href="#">

                <img src="/images/logo-elektro.png"
                    alt="Logo Elektro"
                    width="60"
                    height="60"
                    class="rounded-circle">

                <div class="brand-text d-flex flex-column">
                    <span class="electrical-text">ELECTRICAL</span>
                    <span class="engineering-text">ENGINEERING</span>
                    <small class="univ-text">INDONESIA DEFENSE UNIVERSITY</small>
                </div>
            </a>
            <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth

                        <li class="nav-item">
                            <span class="nav-link text-light">
                                Halo, {{ Auth::user()->name }}
                            </span>
                        </li>

                        <li class="nav-item">
                            <form action="{{ route('logout') }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf

                                <button type="submit"
                                        class="btn btn-danger btn-sm ms-2">

                                    Logout

                                </button>

                            </form>
                        </li>

                    @else

                        <li class="nav-item">
                            <a href="{{ route('login') }}"
                               class="btn btn-outline-light btn-sm px-4">

                                Login

                            </a>
                        </li>

                        <li class="nav-item ms-lg-2">
                            <a href="{{ route('register') }}"
                               class="btn btn-primary btn-sm px-4">

                                Register

                            </a>
                        </li>

                    @endauth

                </ul>

            </div>

        </div>

    </nav>

    <!-- =========================
         HERO SECTION
    ========================== -->
    <header class="hero-section">

        <div class="container hero-content">

            <h1 class="hero-title">

                <span class="text-white">Welcome to</span>
                <br>

                <span class="text-white">Electrical </span>

                <span class="gradient-text">Engineering</span>

            </h1>

            <p class="mt-4 fs-4 text-white">
                Indonesia Defense University
            </p>

        </div>

    </header>

    <!-- =========================
         DASHBOARD CONTENT
    ========================== -->
    <div class="row">

        {{-- CEK: Jika ini halaman dashboard, tampilkan konten Welcome & Stat --}}
        @if(Request::is('dashboard'))

            <div class="col-md-8">

                <div class="card card-custom p-4 mb-4 bg-white">

                    <h4>
                        Selamat Datang, {{ explode(' ', $user->name)[0] }}!
                    </h4>

                </div>

            </div>

        @endif

        {{-- TEMPAT UNTUK KONTEN BAHAN AJAR --}}
        @yield('main_content')

    </div>

    <!-- =========================
         FEATURE SECTION
    ========================== -->
            <!-- ITEM UNHAN RI -->
<div class="accordion-item-custom">

    <button class="accordion-btn-custom">
        Universitas Pertahanan RI
        <span>⌄</span>
    </button>

    <div class="accordion-content-custom">

        <div class="row align-items-center g-4 mt-3">

            <!-- Logo -->
            <div class="col-md-2 text-center"
                 style="padding-left: 80px";>
                <img src="/images/logo-unhan.jpg"
                     alt="Logo Unhan"
                     class="img-fluid"
                     style="max-width: 180px;">
            </div>

            <!-- Text -->
            <div class="col-md-10 ps-md-4">

                <p style="
                    font-size: 20px;
                    line-height: 1.9;
                    color: #666;
                    margin-bottom: 0;
                    padding-right:180px;
                ">
                    Indonesia Defense University atau Universitas Pertahanan Republik Indonesia 
                    (Unhan RI) merupakan perguruan tinggi di bawah Kementerian Pertahanan Republik 
                    Indonesia yang berfokus pada pengembangan ilmu pengetahuan, teknologi, dan 
                    karakter bela negara untuk mencetak generasi unggul, disiplin, serta berjiwa 
                    nasionalisme tinggi guna mendukung kemajuan bangsa dan pertahanan negara.
                </p>

            </div>

        </div>

    </div>

</div>
    
        <!-- ITEM 1 -->
        <div class="accordion-item-custom">

            <button class="accordion-btn-custom">
                Teknik Elektro
                <span>⌄</span>
            </button>

            <div class="accordion-content-custom">

    <div class="row align-items-center g-4 mt-3">

        <!-- Logo Elektro -->
        <div class="col-md-2 text-center"
             style="padding-left: 80px;">

            <img src="/images/logo-elektro.png"
                 alt="Logo Elektro"
                 class="img-fluid"
                 style="max-width: 170px;">

        </div>

        <!-- Teks -->
        <div class="col-md-10 ps-md-4">

            <p style="
                font-size: 20px;
                line-height: 1.9;
                color: #666;
                margin-bottom: 0;
                padding-right: 180px;
            ">
                Program Studi Teknik Elektro Universitas Pertahanan RI merupakan program studi 
                yang berfokus pada pengembangan ilmu dan teknologi di bidang sistem kelistrikan, 
                elektronika, kontrol, telekomunikasi, pemrograman, serta teknologi rekayasa 
                pertahanan. Program studi ini dirancang untuk mencetak lulusan yang unggul, inovatif, 
                dan berkarakter bela negara melalui pembelajaran berbasis riset, teknologi modern, 
                serta penerapan teknik elektro dalam mendukung sistem pertahanan dan keamanan nasional.
            </p>

        </div>

    </div>

</div>

        </div>

        <!-- ITEM 2 -->
        <div class="accordion-item-custom">

            <button class="accordion-btn-custom">
                Visi & Misi
                <span>⌄</span>
            </button>

            <div class="accordion-content-custom">
                <p>
                    
                    Visi <br>
                    Menjadi salah satu Program Studi Teknik ELektro yang menguasai perkembangan keilmuan 
                    teknik dibidang teknologi rekayasa elektro militer berstandar internasional berbasis 
                    riset dan teknologi rekayasa militer untuk pertahanan dan keamanan nasional dengan 
                    melestarikan nilai- nilai kebangsaan. <br>
                    <br>
                    Misi <br>
                    1. Mendidik calon intelektual bela negara dibidang teknologi dan rekayasa baik yang 
                    profesional dan memiliki nilai-nilai perjuangan dan kejuangan yang diperoleh secara 
                    empiris akademis melalui program pendidikan sarjana.<br>
                    2. Mengembangkan ilmu teknologi dan rekayasa dibidang pertahanan sebagai disipliner 
                    keilmuan guna meningkatkan kemampuan teknologi dan rekayasa untuk sistem pertahanan 
                    negara. <br>
                    3. Menyelenggarakan pembelajaran, penelitian, dan pengabdian kepada masyarakat 
                    serta melaksanakan publikasi, konsultasi, dan  advokasi berbasis ilmu teknologi dan 
                    rekayasa untuk pertahanan dan bela negara. <br>
                    4. Menyelenggarakan manajemen dengan pendekatan partisipatif dan kolegial didukung 
                    administrasi pendidikan tinggi berbasis mutu yang efisien dan akuntabel. <br>
                    5. Melaksanakan kerja sama dengan berbagai instansi dan perguruan tinggi dalam 
                    negeri maupun luar negeri guna peningkatan dan pengembangan keilmuan teknologi 
                    dan rekayasa untuk memperkuat pertahanan negara. <br>
                    6. Mengembangkan sarana prasarana serta administrasi pendidikan tinggi berbasis 
                    mutu yang modern, efisien, inovatif, dan akuntabel.

                </p>
            </div>

        </div>

        <!-- ITEM 3 -->
        <div class="accordion-item-custom">

            <button class="accordion-btn-custom">
                Karir Lulusan
                <span>⌄</span>
            </button>

            <div class="accordion-content-custom">
                <p>
                    Lulusan Program Studi Teknik Elektro Universitas Pertahanan RI dipersiapkan 
                    tidak hanya sebagai tenaga profesional di bidang teknologi dan rekayasa, tetapi 
                    juga siap menjadi Perwira TNI yang memiliki kompetensi di bidang sistem kelistrikan, 
                    elektronika, telekomunikasi, kontrol, dan teknologi pertahanan modern. Melalui 
                    perpaduan pendidikan akademik, penguasaan teknologi elektro, serta pembinaan karakter 
                    bela negara dan kepemimpinan militer, lulusan diharapkan mampu mendukung pengembangan 
                    alutsista, sistem komunikasi pertahanan, radar, otomasi, hingga teknologi strategis 
                    pertahanan nasional di era modern.
                </p>
            </div>

        </div>

        <!-- ITEM 4 -->
        <div class="accordion-item-custom">

            <button class="accordion-btn-custom">
                Akreditasi
                <span>⌄</span>
            </button>

            <div class="accordion-content-custom">
                <p>
                    Program Studi Teknik Elektro Universitas Pertahanan RI telah terakreditasi “Baik” 
                    sebagai bentuk pengakuan terhadap mutu pendidikan, kualitas pembelajaran, serta 
                    pengembangan kompetensi mahasiswa di bidang teknik elektro dan teknologi pertahanan. 
                    Akreditasi ini mencerminkan komitmen program studi dalam menyediakan pendidikan yang 
                    unggul, profesional, dan relevan dengan perkembangan teknologi serta kebutuhan pertahanan 
                    nasional.
                </p>
            </div>

        </div>

    </div>

</section>

<style>
    /* ABOUT ELEKTRO SECTION */
.about-elektro-section {
    padding: 100px 0;
}

.about-title {
    font-size: 60px;
    font-weight: 300;
    color: #222;
    margin-bottom: 60px;
}

/* ACCORDION */
.accordion-item-custom {
    border-bottom: 1px solid #999;
    margin-bottom: 25px;
    padding-bottom: 25px;
}

.accordion-btn-custom {
    width: 100%;
    background: none;
    border: none;

    display: flex;
    justify-content: space-between;
    align-items: center;

    font-size: 48px;
    font-weight: 300;
    color: #333;

    cursor: pointer;
    padding: 10px 80px 10px 80px;
}

.accordion-btn-custom span {
    font-size: 40px;
    transition: 0.3s ease;
}

.accordion-content-custom {
    max-height: 0;
    overflow: hidden;

    transition: max-height 0.5s ease;
}

.accordion-content-custom p {
    font-size: 20px;
    color: #666;

    line-height: 1.8;

    margin-top: 20px;
    margin-left: 80px;
    max-width: 1000px;
}

/* ACTIVE */
.accordion-item-custom.active .accordion-content-custom {
    max-height: 2000px;
}

.accordion-item-custom.active .accordion-btn-custom span {
    transform: rotate(180deg);
}
</style>

    <!-- =========================
         FOOTER
    ========================== -->
    <footer class="text-white py-4 text-center"
            style="background-color: #020d34;">

        <div class="container">

            <p>
                &copy; 2026 Web Prodi Teknik Elektro. All Rights Reserved.
            </p>

        </div>

    </footer>

    <!-- =========================
         JS
    ========================== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>

        window.addEventListener("scroll", function () {

            const navbar = document.querySelector(".custom-navbar");

            if (window.scrollY > 50) {
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }

        });

    </script>

<script>

    const accordionItems = document.querySelectorAll('.accordion-item-custom');

    accordionItems.forEach(item => {

        const button = item.querySelector('.accordion-btn-custom');

        button.addEventListener('click', () => {

            item.classList.toggle('active');

        });

    });

</script>

</body>

</html>