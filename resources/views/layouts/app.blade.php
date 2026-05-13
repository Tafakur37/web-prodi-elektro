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
            padding: 8px 0 16px;
        }

        /* ======================== UNIFIED NAV LINKS ======================== */
        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 1px;
        }

        .sidebar-section {
            margin: 1px 0;
        }

        /* Direct link (no children) */
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0;
            padding: 10px 20px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            border-left: 3px solid transparent;
            transition: all 0.18s ease;
        }

        .sidebar-link:hover {
            background: var(--sidebar-hover);
            color: var(--sidebar-text-hover);
            border-left-color: rgba(99, 102, 241, 0.3);
        }

        .sidebar-link.active {
            background: var(--sidebar-active-bg);
            color: var(--sidebar-text-active);
            border-left-color: var(--sidebar-active-border);
            font-weight: 600;
        }

        /* Group toggle button (collapsible parent) */
        .sidebar-group-toggle {
            width: 100%;
            display: flex;
            align-items: center;
            padding: 10px 20px;
            background: transparent;
            border: none;
            border-left: 3px solid transparent;
            color: var(--sidebar-text);
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            text-align: left;
            transition: all 0.18s ease;
            position: relative;
        }

        .sidebar-group-toggle:hover {
            background: var(--sidebar-hover);
            color: var(--sidebar-text-hover);
            border-left-color: rgba(99, 102, 241, 0.3);
        }

        .sidebar-group-toggle.open {
            background: rgba(99, 102, 241, 0.08);
            color: var(--sidebar-text-active);
            border-left-color: var(--sidebar-active-border);
        }

        .sidebar-icon {
            width: 24px;
            min-width: 24px;
            margin-right: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.05rem;
            opacity: 0.75;
            transition: opacity 0.18s;
        }

        .sidebar-group-toggle:hover .sidebar-icon,
        .sidebar-group-toggle.open .sidebar-icon,
        .sidebar-link:hover .sidebar-icon,
        .sidebar-link.active .sidebar-icon {
            opacity: 1;
        }

        .sidebar-group-toggle.open .sidebar-icon i {
            color: var(--accent-light);
        }

        .sidebar-label {
            flex: 1;
        }

        .sidebar-chevron {
            font-size: 0.7rem;
            transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0.5;
        }

        .sidebar-group-toggle.open .sidebar-chevron {
            transform: rotate(90deg);
            opacity: 0.9;
        }

        /* Submenu container */
        .sidebar-submenu {
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.3s cubic-bezier(0.4, 0, 0.2, 1),
                        opacity 0.25s ease;
            opacity: 0;
            background: rgba(0,0,0,0.12);
        }

        .sidebar-submenu.expanded {
            max-height: 600px;
            opacity: 1;
        }

        /* Sublinks inside submenu */
        .sidebar-sublink {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 20px 8px 48px;
            color: rgba(148, 163, 184, 0.85);
            text-decoration: none;
            font-size: 0.82rem;
            font-weight: 400;
            border-left: 3px solid transparent;
            transition: all 0.15s ease;
        }

        .sidebar-sublink i {
            font-size: 0.9rem;
            width: 16px;
            opacity: 0.7;
            flex-shrink: 0;
        }

        .sidebar-sublink:hover {
            background: var(--sidebar-hover);
            color: var(--sidebar-text-hover);
            border-left-color: rgba(99, 102, 241, 0.2);
        }

        .sidebar-sublink:hover i {
            opacity: 1;
        }

        .sidebar-sublink.active {
            color: #fff;
            background: var(--sidebar-active-bg);
            border-left-color: var(--sidebar-active-border);
            font-weight: 600;
        }

        .sidebar-sublink.active i {
            opacity: 1;
            color: var(--accent-light);
        }

        /* Legacy support untuk komponen sidebar lama */
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

        .sidebar .nav-link:hover i { opacity: 1; }

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

        /* ======================== ADMIN LIGHT THEME OVERRIDE ========================
           Override semua dark Bootstrap classes ke light untuk konsistensi.
           Berlaku di semua halaman yang extend layouts/app.blade.php.
        ============================================================================ */

        /* Override: table-dark → light table */
        .table-dark {
            --bs-table-bg: #ffffff !important;
            --bs-table-striped-bg: #f8fafc !important;
            --bs-table-hover-bg: #f1f5f9 !important;
            --bs-table-border-color: #e2e8f0 !important;
            --bs-table-color: #1e293b !important;
            color: #1e293b !important;
            background-color: #ffffff !important;
        }

        .table-dark thead th,
        .table-dark th {
            background-color: #f8fafc !important;
            color: #64748b !important;
            border-color: #e2e8f0 !important;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }

        .table-dark tbody tr {
            background-color: #ffffff !important;
            color: #1e293b !important;
            border-color: #f1f5f9 !important;
        }

        .table-dark tbody tr:hover {
            background-color: #f8fafc !important;
        }

        .table-dark td, .table-dark th {
            border-color: #f1f5f9 !important;
        }

        /* Override: bg-dark → white card */
        .bg-dark:not(.sidebar):not(.sidebar *):not([data-bs-theme="dark"]) {
            background-color: #ffffff !important;
            color: #1e293b !important;
        }

        /* Override: modal-content bg-dark */
        .modal-content.bg-dark {
            background-color: #ffffff !important;
            color: #1e293b !important;
            border: 1px solid #e2e8f0 !important;
        }

        .modal-content.bg-dark .modal-header {
            background: #f8fafc !important;
            border-bottom: 1px solid #e2e8f0 !important;
        }

        .modal-content.bg-dark .btn-close {
            filter: none !important;
        }

        /* Override: form-control-dark / form-select-dark */
        .form-control-dark,
        .form-select-dark,
        .form-control.bg-dark,
        .form-select.bg-dark {
            background-color: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
            color: #1e293b !important;
        }

        .form-control-dark:focus,
        .form-select-dark:focus,
        .form-control.bg-dark:focus,
        .form-select.bg-dark:focus {
            background-color: #ffffff !important;
            border-color: #6366f1 !important;
            color: #1e293b !important;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.15) !important;
        }

        /* Override: text-white inside content area */
        .main-content .text-white:not(.btn):not(.badge):not(.alert *):not(.sidebar *) {
            color: #1e293b !important;
        }

        /* Override: input-group-text bg-dark */
        .input-group-text.bg-dark,
        .input-group-text.bg-transparent {
            background-color: #f1f5f9 !important;
            border-color: #e2e8f0 !important;
            color: #64748b !important;
        }

        /* Override: filter/search card dark bg */
        .filter-card {
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 14px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        /* Override: stat-card dark bg */
        .stat-card {
            background: #ffffff !important;
        }

        /* Override: container-fluid text-white */
        .container-fluid.text-white {
            color: #1e293b !important;
        }

        /* Override: .bg-darker */
        .bg-darker {
            background-color: #f8fafc !important;
            color: #1e293b !important;
        }

        /* Override: btn-outline-info → accent color */
        .btn-outline-info {
            color: #6366f1 !important;
            border-color: #6366f1 !important;
        }

        .btn-outline-info:hover {
            background-color: #6366f1 !important;
            color: #ffffff !important;
        }

        /* Override: rounded-pill bg-dark (IP Address etc) */
        .font-monospace.bg-dark,
        .badge.bg-dark {
            background-color: #f1f5f9 !important;
            color: #475569 !important;
        }

        /* Admin page title */
        .main-content h1,
        .main-content h2,
        .main-content h3 {
            color: #1e293b;
        }

        /* select option colors */
        .form-control-dark option,
        .form-select-dark option,
        .form-select.bg-dark option {
            background-color: #ffffff;
            color: #1e293b;
        }

        /* Card universal light override untuk admin */
        .card.bg-dark {
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
        }

        .card.bg-dark * {
            color: #1e293b !important;
        }

        /* Cohort card select */
        .cohort-card {
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            transition: all 0.2s;
        }

        .cohort-card:hover {
            border-color: #6366f1;
            box-shadow: 0 4px 12px rgba(99,102,241,0.15);
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

        <!-- Unified Collapsible Sidebar Menu -->
        <div class="sidebar-menu">
            @if(auth()->check())
                @include('components.sidebar.unified')
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

    <!-- Sidebar Toggle + Collapsible Groups Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ── Mobile sidebar toggle ──────────────────────────────────────────
            const sidebar = document.getElementById('mainSidebar');
            const toggle  = document.getElementById('sidebarToggle');
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

            // ── Collapsible sidebar groups ─────────────────────────────────────
            const SESSION_KEY = 'simelek_sidebar_open';

            // Baca state yang tersimpan dari sessionStorage
            let openGroups = JSON.parse(sessionStorage.getItem(SESSION_KEY) || '[]');

            // Inisialisasi semua toggle buttons
            document.querySelectorAll('.sidebar-group-toggle').forEach(function(btn) {
                const targetId = btn.getAttribute('data-target');
                const submenu  = document.getElementById(targetId);

                if (!submenu) return;

                // Tentukan apakah grup ini harus terbuka:
                // - Sudah open karena active route (class 'open' dari Blade)
                // - Atau tersimpan di sessionStorage
                const isActiveOpen  = btn.classList.contains('open');
                const isStoredOpen  = openGroups.includes(targetId);
                const shouldBeOpen  = isActiveOpen || isStoredOpen;

                if (shouldBeOpen) {
                    submenu.classList.add('expanded');
                    btn.classList.add('open');
                    // Pastikan tersimpan
                    if (!openGroups.includes(targetId)) {
                        openGroups.push(targetId);
                    }
                }

                // Click handler: toggle expand/collapse
                btn.addEventListener('click', function() {
                    const isOpen = submenu.classList.contains('expanded');

                    if (isOpen) {
                        // Tutup
                        submenu.classList.remove('expanded');
                        btn.classList.remove('open');
                        openGroups = openGroups.filter(id => id !== targetId);
                    } else {
                        // Buka
                        submenu.classList.add('expanded');
                        btn.classList.add('open');
                        if (!openGroups.includes(targetId)) {
                            openGroups.push(targetId);
                        }
                    }

                    // Simpan state ke sessionStorage
                    sessionStorage.setItem(SESSION_KEY, JSON.stringify(openGroups));
                });
            });
        });
    </script>

    @stack('scripts')

    @include('components.session-alert')
    @auth
    <form id="strict-tab-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('just_logged_in'))
                // Inisialisasi sesi tab setelah login berhasil
                sessionStorage.setItem('sim_tab_active', '1');
            @else
                // Jika tab baru dibuka (sessionStorage kosong) namun server masih menganggap login, paksa logout.
                // Ini mencegah restore tab atau "Continue where you left off" pada browser.
                if (!sessionStorage.getItem('sim_tab_active')) {
                    document.getElementById('strict-tab-logout-form').submit();
                }
            @endif
        });
    </script>
    @endauth
</body>
</html>
