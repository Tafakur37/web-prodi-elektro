<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - SIMelek</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #1a1f2e;
            --sidebar-hover: rgba(255, 255, 255, 0.06);
            --sidebar-active-bg: rgba(99, 132, 255, 0.15);
            --sidebar-active-border: #6366f1;
            --sidebar-text: #94a3b8;
            --sidebar-text-hover: #e2e8f0;
            --sidebar-text-active: #ffffff;
            --sidebar-heading: #475569;
            --body-bg: #f1f5f9;
            --card-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 1px 2px rgba(0,0,0,0.06);
            --card-shadow-hover: 0 10px 15px -3px rgba(0,0,0,0.08), 0 4px 6px rgba(0,0,0,0.04);
            --accent-color: #6366f1;
            --accent-light: #818cf8;
        }

        * {
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.1) transparent;
        }
        *::-webkit-scrollbar { width: 5px; }
        *::-webkit-scrollbar-track { background: transparent; }
        *::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }

        body {
            background-color: var(--body-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* ======================== SIDEBAR ======================== */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-right: 1px solid rgba(255,255,255,0.04);
        }

        .sidebar-brand {
            padding: 24px 20px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            flex-shrink: 0;
        }

        .sidebar-brand h4 {
            font-weight: 800;
            letter-spacing: 3px;
            font-size: 1.4rem;
            margin-bottom: 4px;
            background: linear-gradient(135deg, #818cf8, #6366f1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .sidebar-brand small {
            font-size: 0.65rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--sidebar-text);
            font-weight: 600;
        }

        .sidebar-menu {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 12px 0;
        }

        .sidebar .nav-link {
            color: var(--sidebar-text);
            padding: 10px 20px;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
            display: flex;
            align-items: center;
            text-decoration: none;
            border-radius: 0;
            font-size: 0.875rem;
            font-weight: 500;
            margin: 1px 0;
        }

        .sidebar .nav-link i {
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
            margin-right: 12px;
            opacity: 0.7;
            transition: opacity 0.2s;
        }

        .sidebar .nav-link:hover {
            background: var(--sidebar-hover);
            color: var(--sidebar-text-hover);
            border-left-color: rgba(99, 102, 241, 0.3);
        }

        .sidebar .nav-link:hover i {
            opacity: 1;
        }

        .sidebar .nav-link.active {
            background: var(--sidebar-active-bg);
            color: var(--sidebar-text-active);
            border-left-color: var(--sidebar-active-border);
            font-weight: 600;
        }

        .sidebar .nav-link.active i {
            opacity: 1;
            color: var(--accent-light);
        }

        .sidebar .sidebar-heading {
            font-size: 0.68rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--sidebar-heading);
            padding: 18px 20px 6px;
            font-weight: 700;
        }

        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid rgba(255,255,255,0.06);
            flex-shrink: 0;
        }

        .sidebar-footer .btn {
            color: var(--sidebar-text);
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .sidebar-footer .btn:hover {
            color: #f87171;
            background: rgba(248, 113, 113, 0.1);
        }

        /* ======================== MAIN CONTENT ======================== */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 24px 30px;
            min-height: 100vh;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ======================== TOP HEADER ======================== */
        .top-header {
            background: white;
            padding: 14px 24px;
            border-radius: 14px;
            box-shadow: var(--card-shadow);
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-header .breadcrumb {
            margin-bottom: 0;
            font-size: 0.875rem;
        }

        .top-header .breadcrumb a {
            color: var(--accent-color);
            text-decoration: none;
        }

        .user-badge {
            font-size: 0.7rem;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #6366f1, #818cf8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
        }

        /* ======================== CARDS ======================== */
        .card-custom {
            border: none;
            border-radius: 14px;
            box-shadow: var(--card-shadow);
            transition: box-shadow 0.2s ease;
        }

        .card-custom:hover {
            box-shadow: var(--card-shadow-hover);
        }

        /* Admin-specific card style */
        .admin-card {
            background: #fff;
            border: none;
            border-radius: 14px;
            box-shadow: var(--card-shadow);
            transition: box-shadow 0.2s ease;
        }

        .admin-card:hover {
            box-shadow: var(--card-shadow-hover);
        }

        .accent-color {
            color: var(--accent-color) !important;
        }

        /* ======================== ALERTS ======================== */
        .alert-float {
            border: none;
            border-radius: 14px;
            box-shadow: var(--card-shadow);
        }

        /* ======================== ANIMATIONS ======================== */
        .fade-in {
            animation: fadeInUp 0.3s ease-out;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ======================== MOBILE TOGGLE ======================== */
        .sidebar-toggle {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1050;
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: var(--accent-color);
            color: white;
            border: none;
            box-shadow: 0 4px 12px rgba(99,102,241,0.4);
            font-size: 1.2rem;
            transition: transform 0.2s;
        }

        .sidebar-toggle:hover {
            transform: scale(1.05);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1035;
            backdrop-filter: blur(2px);
        }

        /* ======================== RESPONSIVE ======================== */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 16px;
            }

            .sidebar-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .sidebar-overlay.show {
                display: block;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Mobile Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="mainSidebar">
        <div class="sidebar-brand">
            <h4 class="mb-0">ELEKTRO</h4>
            <small>{{ strtoupper(auth()->user()->role ?? '') }} PORTAL</small>
        </div>

        <!-- Dynamic Sidebar Menu -->
        <div class="sidebar-menu">
            @if(auth()->check())
                @php
                    $sidebarRole = auth()->user()->role;
                    // Map role names to sidebar partial names
                    $sidebarMap = [
                        'admin-super' => 'admin-super',
                        'admin' => 'admin-super',
                        'staff' => 'staff',
                        'dosen' => 'dosen',
                        'mahasiswa' => 'mahasiswa',
                        'kaprodi' => 'kaprodi',
                        'sesprodi' => 'sesprodi',
                    ];
                    $sidebarView = $sidebarMap[$sidebarRole] ?? $sidebarRole;
                @endphp
                @if(view()->exists('components.sidebar.' . $sidebarView))
                    @include('components.sidebar.' . $sidebarView)
                @else
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <p class="text-center text-muted mt-3">Menu belum tersedia</p>
                        </li>
                    </ul>
                @endif
            @endif
        </div>

        <!-- Sidebar Footer -->
        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn w-100 text-start d-flex align-items-center border-0 shadow-none px-0">
                    <i class="bi bi-box-arrow-left me-3 fs-5"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Mobile Toggle -->
    <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
        <i class="bi bi-list"></i>
    </button>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Header -->
        <header class="top-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Portal</a></li>
                    <li class="breadcrumb-item active text-capitalize" aria-current="page">@yield('title')</li>
                </ol>
            </nav>
            <div class="d-flex align-items-center">
                <div class="text-end me-3 d-none d-sm-block">
                    <span class="d-block fw-bold text-dark lh-1 mb-1" style="font-size: 0.9rem;">{{ auth()->user()->name }}</span>
                    <span class="user-badge bg-primary-subtle text-primary border border-primary-subtle text-capitalize">
                        {{ auth()->user()->role }}
                    </span>
                </div>
                <div class="user-avatar">
                    <i class="bi bi-person-fill"></i>
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show alert-float mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show alert-float mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div>{{ session('error') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <main class="fade-in">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Sidebar Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('mainSidebar');
            const toggle = document.getElementById('sidebarToggle');
            const overlay = document.getElementById('sidebarOverlay');

            if (toggle) {
                toggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    overlay.classList.toggle('show');
                });
            }

            if (overlay) {
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                });
            }
        });
    </script>

    @stack('scripts')

    @include('components.session-alert')
</body>
</html>
