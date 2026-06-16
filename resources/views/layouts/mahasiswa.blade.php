<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') – SIMelek Mahasiswa</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
    /* ================================================================
       DESIGN TOKENS
    ================================================================ */
    :root {
        --app-bg:          #080f1e;
        --sidebar-bg:      #050c1a;
        --sidebar-width:   264px;
        --sidebar-border:  rgba(255,255,255,0.06);
        --sidebar-hover:   rgba(255,255,255,0.05);
        --sidebar-active:  rgba(0,102,255,0.14);
        --sidebar-active-border: #0066ff;
        --sidebar-text:    rgba(255,255,255,0.5);
        --sidebar-text-h:  rgba(255,255,255,0.85);
        --sidebar-text-a:  #ffffff;

        --topbar-bg:       rgba(8,15,30,0.85);
        --card-bg:         rgba(255,255,255,0.04);
        --card-border:     rgba(255,255,255,0.08);
        --card-border-h:   rgba(0,102,255,0.3);

        --primary:         #0066ff;
        --primary-light:   rgba(0,102,255,0.12);
        --cyan:            #00c6ff;
        --cyan-light:      rgba(0,198,255,0.12);
        --success:         #00d264;
        --success-light:   rgba(0,210,100,0.12);
        --danger:          #ff4757;
        --danger-light:    rgba(255,71,87,0.12);
        --warning:         #ffa502;
        --warning-light:   rgba(255,165,2,0.12);
        --info:            #00c6ff;
        --info-light:      rgba(0,198,255,0.12);
        --purple:          #7b61ff;
        --purple-light:    rgba(123,97,255,0.12);

        --text-1:          #f1f5f9;
        --text-2:          rgba(255,255,255,0.55);
        --text-3:          rgba(255,255,255,0.35);
        --border:          rgba(255,255,255,0.08);

        --font:            'Inter', system-ui, sans-serif;
        --font-display:    'Space Grotesk', system-ui, sans-serif;

        --radius-sm:       6px;
        --radius-md:       10px;
        --radius-lg:       14px;
        --radius-xl:       18px;
        --radius-2xl:      24px;

        --shadow-sm:       0 1px 3px rgba(0,0,0,0.3);
        --shadow-md:       0 4px 16px rgba(0,0,0,0.4);
        --shadow-glow:     0 0 20px rgba(0,102,255,0.2);

        --transition:      0.25s cubic-bezier(0.4,0,0.2,1);
    }

    /* ================================================================
       RESET & BASE
    ================================================================ */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }

    body {
        background: var(--app-bg);
        color: var(--text-1);
        font-family: var(--font);
        overflow-x: hidden;
        min-height: 100vh;
    }

    /* Scrollbar */
    ::-webkit-scrollbar { width: 5px; height: 5px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.12); border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: rgba(0,102,255,0.5); }

    /* ================================================================
       SIDEBAR
    ================================================================ */
    .mhs-sidebar {
        width: var(--sidebar-width);
        height: 100vh;
        background: var(--sidebar-bg);
        position: fixed;
        top: 0; left: 0;
        z-index: 1040;
        display: flex;
        flex-direction: column;
        border-right: 1px solid var(--sidebar-border);
        transition: transform var(--transition);
    }

    /* Brand */
    .mhs-brand {
        padding: 20px 18px 16px;
        border-bottom: 1px solid var(--sidebar-border);
        flex-shrink: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .mhs-brand-logo {
        width: 46px; height: 46px;
        border-radius: 12px;
        object-fit: cover;
        border: 1.5px solid rgba(0,198,255,0.3);
        box-shadow: 0 0 12px rgba(0,198,255,0.2);
        flex-shrink: 0;
    }

    .mhs-brand-text { line-height: 1.2; }
    .mhs-brand-text .t1 {
        font-family: var(--font-display);
        font-size: 0.82rem;
        font-weight: 700;
        color: #fff;
        letter-spacing: 0.5px;
    }
    .mhs-brand-text .t2 {
        font-size: 0.6rem;
        font-weight: 600;
        background: linear-gradient(90deg, var(--cyan), var(--primary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }
    .mhs-brand-text .t3 {
        font-size: 0.48rem;
        color: var(--text-3);
        letter-spacing: 0.5px;
        margin-top: 2px;
        display: block;
    }

    /* User profile mini */
    .mhs-user-mini {
        padding: 12px 18px;
        border-bottom: 1px solid var(--sidebar-border);
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    .mhs-avatar {
        width: 34px; height: 34px;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--primary), var(--cyan));
        display: flex; align-items: center; justify-content: center;
        font-size: 0.85rem;
        color: #fff;
        font-weight: 700;
        flex-shrink: 0;
        overflow: hidden;
    }

    .mhs-avatar img { width: 100%; height: 100%; object-fit: cover; }

    .mhs-user-info .uname {
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--text-1);
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 170px;
    }

    .mhs-user-info .urole {
        font-size: 0.58rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--cyan);
    }

    /* Nav */
    .mhs-nav {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 10px 0 16px;
    }

    .mhs-nav-section-label {
        font-size: 0.6rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: var(--text-3);
        padding: 16px 18px 6px;
    }

    .mhs-nav-link {
        display: flex;
        align-items: center;
        gap: 0;
        padding: 9px 18px;
        color: var(--sidebar-text);
        text-decoration: none;
        font-size: 0.84rem;
        font-weight: 500;
        border-left: 3px solid transparent;
        transition: all 0.2s ease;
        cursor: pointer;
        position: relative;
    }

    .mhs-nav-link:hover {
        background: var(--sidebar-hover);
        color: var(--sidebar-text-h);
        border-left-color: rgba(0,102,255,0.3);
    }

    .mhs-nav-link.active {
        background: var(--sidebar-active);
        color: var(--sidebar-text-a);
        border-left-color: var(--sidebar-active-border);
        font-weight: 600;
    }

    .mhs-nav-icon {
        width: 22px; min-width: 22px;
        margin-right: 11px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem;
        opacity: 0.7;
        transition: opacity 0.2s;
    }

    .mhs-nav-link:hover .mhs-nav-icon,
    .mhs-nav-link.active .mhs-nav-icon { opacity: 1; }

    .mhs-nav-link.active .mhs-nav-icon { color: var(--cyan); }

    .mhs-nav-badge {
        margin-left: auto;
        background: var(--danger);
        color: #fff;
        font-size: 0.6rem;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 10px;
        min-width: 18px;
        text-align: center;
    }

    /* Sidebar footer */
    .mhs-sidebar-footer {
        padding: 14px 18px;
        border-top: 1px solid var(--sidebar-border);
        flex-shrink: 0;
    }

    .mhs-logout-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 12px;
        color: rgba(255,255,255,0.45);
        font-size: 0.84rem;
        font-weight: 500;
        cursor: pointer;
        border-radius: var(--radius-md);
        border: 1px solid transparent;
        background: transparent;
        width: 100%;
        text-align: left;
        transition: all 0.2s;
    }

    .mhs-logout-btn:hover {
        background: rgba(255,71,87,0.1);
        border-color: rgba(255,71,87,0.25);
        color: var(--danger);
    }

    /* ================================================================
       MAIN CONTENT AREA
    ================================================================ */
    .mhs-main {
        margin-left: var(--sidebar-width);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        transition: margin-left var(--transition);
    }

    /* ================================================================
       TOP BAR
    ================================================================ */
    .mhs-topbar {
        position: sticky;
        top: 0;
        z-index: 900;
        background: rgba(8,15,30,0.92);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-bottom: 1px solid var(--border);
        padding: 0 28px;
        height: 62px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .mhs-breadcrumb {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.8rem;
        color: var(--text-2);
    }

    .mhs-breadcrumb a {
        color: var(--text-2);
        text-decoration: none;
        transition: color 0.2s;
    }

    .mhs-breadcrumb a:hover { color: var(--cyan); }

    .mhs-breadcrumb .sep { opacity: 0.4; }

    .mhs-breadcrumb .current {
        color: var(--text-1);
        font-weight: 600;
    }

    .mhs-topbar-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Notif bell */
    .notif-btn {
        width: 38px; height: 38px;
        border-radius: var(--radius-md);
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        color: var(--text-2);
        font-size: 1rem;
        position: relative;
        transition: all 0.2s;
    }

    .notif-btn:hover {
        border-color: var(--cyan);
        color: var(--cyan);
        background: var(--cyan-light);
    }

    .notif-dot {
        position: absolute;
        top: 7px; right: 7px;
        width: 7px; height: 7px;
        border-radius: 50%;
        background: var(--danger);
        border: 1.5px solid var(--app-bg);
        animation: pulse-dot 2s infinite;
    }

    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50%       { opacity: 0.5; transform: scale(0.7); }
    }

    /* Topbar user */
    .topbar-user {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 6px 12px;
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: var(--radius-lg);
        cursor: default;
    }

    .topbar-avatar {
        width: 32px; height: 32px;
        border-radius: 9px;
        background: linear-gradient(135deg, var(--primary), var(--cyan));
        display: flex; align-items: center; justify-content: center;
        font-size: 0.8rem;
        color: #fff;
        font-weight: 700;
        flex-shrink: 0;
        overflow: hidden;
    }

    .topbar-avatar img { width: 100%; height: 100%; object-fit: cover; }

    .topbar-user-name {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-1);
        white-space: nowrap;
    }

    .topbar-user-role {
        font-size: 0.6rem;
        color: var(--cyan);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }

    /* Mobile toggle */
    .mhs-sidebar-toggle {
        display: none;
        width: 38px; height: 38px;
        border-radius: var(--radius-md);
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        color: var(--text-1);
        font-size: 1rem;
        cursor: pointer;
        align-items: center; justify-content: center;
        transition: all 0.2s;
    }

    .mhs-sidebar-toggle:hover {
        background: var(--primary-light);
        border-color: var(--primary);
        color: var(--primary);
    }

    /* Overlay */
    .mhs-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.6);
        z-index: 1035;
        backdrop-filter: blur(3px);
    }

    /* ================================================================
       PAGE CONTENT
    ================================================================ */
    .mhs-page {
        flex: 1;
        padding: 24px 28px 40px;
    }

    /* Flash messages */
    .mhs-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        border-radius: var(--radius-lg);
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 20px;
        border: 1px solid;
        animation: fadeInDown 0.4s ease;
    }

    .mhs-alert.success {
        background: var(--success-light);
        border-color: rgba(0,210,100,0.3);
        color: var(--success);
    }

    .mhs-alert.danger {
        background: var(--danger-light);
        border-color: rgba(255,71,87,0.3);
        color: var(--danger);
    }

    .mhs-alert.warning {
        background: var(--warning-light);
        border-color: rgba(255,165,2,0.3);
        color: var(--warning);
    }

    /* ================================================================
       SHARED UTILITY COMPONENTS
    ================================================================ */

    /* Cards */
    .mhs-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: var(--radius-xl);
        overflow: hidden;
        transition: border-color var(--transition), box-shadow var(--transition);
    }

    .mhs-card:hover {
        border-color: var(--card-border-h);
    }

    .mhs-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        border-bottom: 1px solid var(--border);
    }

    .mhs-card-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: var(--font-display);
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--text-1);
        margin: 0;
    }

    .mhs-card-icon {
        width: 30px; height: 30px;
        border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .mhs-card-body { padding: 20px; }

    /* Badges */
    .mhs-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .mhs-badge.primary  { background: var(--primary-light);  color: var(--primary); border: 1px solid rgba(0,102,255,0.2); }
    .mhs-badge.cyan     { background: var(--cyan-light);     color: var(--cyan);    border: 1px solid rgba(0,198,255,0.2); }
    .mhs-badge.success  { background: var(--success-light);  color: var(--success); border: 1px solid rgba(0,210,100,0.2); }
    .mhs-badge.danger   { background: var(--danger-light);   color: var(--danger);  border: 1px solid rgba(255,71,87,0.2); }
    .mhs-badge.warning  { background: var(--warning-light);  color: var(--warning); border: 1px solid rgba(255,165,2,0.2); }
    .mhs-badge.muted    { background: rgba(255,255,255,0.06); color: var(--text-2); border: 1px solid var(--border); }
    .mhs-badge.purple   { background: var(--purple-light);   color: var(--purple);  border: 1px solid rgba(123,97,255,0.2); }

    /* Tables */
    .mhs-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.84rem;
    }

    .mhs-table thead tr {
        background: rgba(255,255,255,0.03);
    }

    .mhs-table th {
        padding: 10px 14px;
        text-align: left;
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text-3);
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }

    .mhs-table td {
        padding: 12px 14px;
        border-bottom: 1px solid rgba(255,255,255,0.04);
        color: var(--text-1);
        vertical-align: middle;
    }

    .mhs-table tbody tr:last-child td { border-bottom: none; }

    .mhs-table tbody tr:hover {
        background: rgba(255,255,255,0.025);
    }

    /* Form controls */
    .mhs-input {
        width: 100%;
        padding: 10px 13px;
        background: rgba(255,255,255,0.05);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        font-size: 0.85rem;
        color: var(--text-1);
        font-family: var(--font);
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
    }

    .mhs-input::placeholder { color: var(--text-3); }

    .mhs-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(0,102,255,0.15);
        background: rgba(255,255,255,0.07);
    }

    select.mhs-input {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23ffffff50' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        padding-right: 32px;
    }

    select.mhs-input option { background: #0d1a2e; color: var(--text-1); }

    textarea.mhs-input { resize: vertical; min-height: 90px; }

    .mhs-label {
        display: block;
        font-size: 0.72rem;
        font-weight: 600;
        color: var(--text-2);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 6px;
    }

    .mhs-form-group { margin-bottom: 16px; }
    .mhs-form-group:last-child { margin-bottom: 0; }

    /* Buttons */
    .mhs-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 20px;
        border-radius: var(--radius-md);
        font-size: 0.84rem;
        font-weight: 600;
        font-family: var(--font);
        cursor: pointer;
        border: 1px solid transparent;
        transition: all var(--transition);
        text-decoration: none;
        white-space: nowrap;
    }

    .mhs-btn-primary {
        background: linear-gradient(135deg, var(--primary), #0080ff);
        color: #fff;
        border-color: transparent;
        box-shadow: 0 4px 14px rgba(0,102,255,0.3);
    }

    .mhs-btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(0,102,255,0.45);
        color: #fff;
    }

    .mhs-btn-ghost {
        background: var(--card-bg);
        color: var(--text-2);
        border-color: var(--border);
    }

    .mhs-btn-ghost:hover {
        border-color: var(--primary);
        color: var(--primary);
        background: var(--primary-light);
    }

    .mhs-btn-success {
        background: var(--success-light);
        color: var(--success);
        border-color: rgba(0,210,100,0.3);
    }

    .mhs-btn-success:hover {
        background: var(--success);
        color: #fff;
        border-color: var(--success);
    }

    .mhs-btn-danger {
        background: var(--danger-light);
        color: var(--danger);
        border-color: rgba(255,71,87,0.3);
    }

    .mhs-btn-danger:hover {
        background: var(--danger);
        color: #fff;
    }

    .mhs-btn-sm { padding: 6px 14px; font-size: 0.78rem; }
    .mhs-btn-full { width: 100%; justify-content: center; }

    /* Section eyebrow */
    .mhs-section-label {
        font-size: 0.65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: var(--text-3);
        margin-bottom: 10px;
    }

    /* Empty state */
    .mhs-empty {
        text-align: center;
        padding: 32px 20px;
        color: var(--text-3);
    }

    .mhs-empty i { font-size: 2rem; display: block; margin-bottom: 10px; }
    .mhs-empty p { font-size: 0.84rem; margin: 0; }

    /* Modals */
    .mhs-modal .modal-content {
        background: #0d1a2e;
        border: 1px solid var(--border);
        border-radius: var(--radius-2xl);
        box-shadow: 0 25px 60px rgba(0,0,0,0.7);
        color: var(--text-1);
    }

    .mhs-modal .modal-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border);
        background: rgba(255,255,255,0.02);
    }

    .mhs-modal .modal-title {
        font-family: var(--font-display);
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-1);
    }

    .mhs-modal .modal-body { padding: 20px 24px; }
    .mhs-modal .modal-footer {
        padding: 14px 24px;
        border-top: 1px solid var(--border);
        background: rgba(255,255,255,0.02);
        gap: 10px;
    }

    .mhs-modal .btn-close {
        filter: invert(1) opacity(0.6);
    }

    .mhs-modal .btn-close:hover {
        filter: invert(1) opacity(1);
    }

    /* Hint text */
    .mhs-hint { font-size: 0.72rem; color: var(--text-3); margin-top: 5px; }

    /* ================================================================
       ANIMATIONS
    ================================================================ */
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-12px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .mhs-page > * { animation: fadeInUp 0.35s ease both; }

    /* ================================================================
       RESPONSIVE
    ================================================================ */
    @media (max-width: 991.98px) {
        .mhs-sidebar {
            transform: translateX(-100%);
        }

        .mhs-sidebar.show {
            transform: translateX(0);
            box-shadow: 8px 0 40px rgba(0,0,0,0.6);
        }

        .mhs-main { margin-left: 0; }

        .mhs-page { padding: 16px; }

        .mhs-topbar { padding: 0 16px; }

        .mhs-sidebar-toggle {
            display: flex;
        }

        .mhs-overlay.show { display: block; }

        .topbar-user .topbar-user-name,
        .topbar-user .topbar-user-role { display: none; }
    }
    </style>

    @stack('styles')
</head>

<body>

    <!-- Sidebar overlay (mobile) -->
    <div class="mhs-overlay" id="mhsOverlay"></div>

    <!-- ================================================================
         SIDEBAR
    ================================================================ -->
    <aside class="mhs-sidebar" id="mhsSidebar">

        <!-- Brand -->
        <div class="mhs-brand">
            <img src="{{ asset('images/logo-elektro.png') }}" alt="Logo" class="mhs-brand-logo">
            <div class="mhs-brand-text">
                <span class="t1">TEKNIK ELEKTRO</span>
                <span class="t2">SIMelek</span>
                <span class="t3">Indonesia Defense University</span>
            </div>
        </div>

        <!-- User mini -->
        <div class="mhs-user-mini">
            <div class="mhs-avatar">
                @if(auth()->user()->profile_photo)
                    <img src="{{ asset('storage/profiles/' . auth()->user()->profile_photo) }}" alt="Avatar">
                @else
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                @endif
            </div>
            <div class="mhs-user-info">
                <span class="uname">{{ auth()->user()->name }}</span>
                <span class="urole">Mahasiswa</span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="mhs-nav">

            <a href="{{ route('mahasiswa.dashboard') }}"
               class="mhs-nav-link {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}">
                <span class="mhs-nav-icon"><i class="bi bi-grid-1x2"></i></span>
                Dashboard
            </a>

            <div class="mhs-nav-section-label">Akademik</div>

            <a href="{{ route('mahasiswa.attendances.index') }}"
               class="mhs-nav-link {{ request()->routeIs('mahasiswa.attendances.*') ? 'active' : '' }}">
                <span class="mhs-nav-icon"><i class="bi bi-calendar-check"></i></span>
                Riwayat Absensi
            </a>

            <a href="{{ route('mahasiswa.nilai.index') }}"
               class="mhs-nav-link {{ request()->routeIs('mahasiswa.nilai.*') ? 'active' : '' }}">
                <span class="mhs-nav-icon"><i class="bi bi-bar-chart-line"></i></span>
                Transkrip Nilai
            </a>

            <a href="{{ route('mahasiswa.materials.index') }}"
               class="mhs-nav-link {{ request()->routeIs('mahasiswa.materials.*') ? 'active' : '' }}">
                <span class="mhs-nav-icon"><i class="bi bi-journal-text"></i></span>
                Bahan Ajar
            </a>

            <a href="{{ route('mahasiswa.submissions.index') }}"
               class="mhs-nav-link {{ request()->routeIs('mahasiswa.submissions.*') ? 'active' : '' }}">
                <span class="mhs-nav-icon"><i class="bi bi-envelope-paper"></i></span>
                Surat
            </a>

            <a href="{{ route('mahasiswa.berkas.index') }}"
               class="mhs-nav-link {{ request()->routeIs('mahasiswa.berkas.*') ? 'active' : '' }}">
                <span class="mhs-nav-icon"><i class="bi bi-folder2-open"></i></span>
                Berkas
            </a>

            <div class="mhs-nav-section-label">Komunikasi & Aktivitas</div>

            <a href="{{ route('mahasiswa.chats.index') }}"
               class="mhs-nav-link {{ request()->routeIs('mahasiswa.chats.*') ? 'active' : '' }}"
               style="position:relative;">
                <span class="mhs-nav-icon"><i class="bi bi-chat-dots"></i></span>
                Chat
                <span class="mhs-nav-badge d-none" id="sidebar-unread-chat-count"></span>
            </a>

            <a href="{{ route('mahasiswa.ukms.index') }}"
               class="mhs-nav-link {{ request()->routeIs('mahasiswa.ukms.*') ? 'active' : '' }}">
                <span class="mhs-nav-icon"><i class="bi bi-people"></i></span>
                Daftar UKM
            </a>

            <a href="{{ route('mahasiswa.violations.index') }}"
               class="mhs-nav-link {{ request()->routeIs('mahasiswa.violations.*') ? 'active' : '' }}">
                <span class="mhs-nav-icon"><i class="bi bi-exclamation-octagon"></i></span>
                Riwayat Pelanggaran
            </a>

            <div class="mhs-nav-section-label">Akun</div>

            <a href="{{ route('mahasiswa.profile.index') }}"
               class="mhs-nav-link {{ request()->routeIs('mahasiswa.profile.*') ? 'active' : '' }}">
                <span class="mhs-nav-icon"><i class="bi bi-person-gear"></i></span>
                Profil & Akun
            </a>

        </nav>

        <!-- Footer / Logout -->
        <div class="mhs-sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="mhs-logout-btn">
                    <i class="bi bi-box-arrow-left"></i>
                    Keluar
                </button>
            </form>
        </div>

    </aside>

    <!-- ================================================================
         MAIN
    ================================================================ -->
    <div class="mhs-main">

        <!-- Top Bar -->
        <header class="mhs-topbar">

            <div class="d-flex align-items-center gap-12">
                <button class="mhs-sidebar-toggle" id="mhsToggle" aria-label="Toggle sidebar">
                    <i class="bi bi-list"></i>
                </button>

                <nav class="mhs-breadcrumb">
                    <a href="{{ route('mahasiswa.dashboard') }}">Portal</a>
                    <span class="sep"><i class="bi bi-chevron-right" style="font-size:0.6rem;"></i></span>
                    <span class="current">@yield('title', 'Dashboard')</span>
                </nav>
            </div>

            <div class="mhs-topbar-actions">

                <!-- Notification bell -->
                <button class="notif-btn" id="notifBtn" title="Notifikasi">
                    <i class="bi bi-bell"></i>
                    <span class="notif-dot d-none" id="notifDot"></span>
                </button>

                <!-- User pill -->
                <div class="topbar-user">
                    <div class="topbar-avatar">
                        @if(auth()->user()->profile_photo)
                            <img src="{{ asset('storage/profiles/' . auth()->user()->profile_photo) }}" alt="Avatar">
                        @else
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <div class="topbar-user-name">{{ explode(' ', auth()->user()->name)[0] }}</div>
                        <div class="topbar-user-role">Mahasiswa</div>
                    </div>
                </div>

            </div>
        </header>

        <!-- Page Content -->
        <main class="mhs-page">

            {{-- Flash messages --}}
            @if(session('success'))
            <div class="mhs-alert success" role="alert">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
                <button type="button" onclick="this.parentElement.remove()" style="margin-left:auto;background:none;border:none;color:inherit;cursor:pointer;font-size:1rem;opacity:0.6;">&times;</button>
            </div>
            @endif

            @if(session('error'))
            <div class="mhs-alert danger" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ session('error') }}
                <button type="button" onclick="this.parentElement.remove()" style="margin-left:auto;background:none;border:none;color:inherit;cursor:pointer;font-size:1rem;opacity:0.6;">&times;</button>
            </div>
            @endif

            @if($errors->any())
            <div class="mhs-alert danger" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                Terdapat kesalahan pada input Anda.
                <button type="button" onclick="this.parentElement.remove()" style="margin-left:auto;background:none;border:none;color:inherit;cursor:pointer;font-size:1rem;opacity:0.6;">&times;</button>
            </div>
            @endif

            @yield('content')

        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // ── Mobile sidebar ──────────────────────────────────────────
        const sidebar  = document.getElementById('mhsSidebar');
        const toggle   = document.getElementById('mhsToggle');
        const overlay  = document.getElementById('mhsOverlay');

        if (toggle) {
            toggle.addEventListener('click', () => {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            });
        }

        if (overlay) {
            overlay.addEventListener('click', () => {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });
        }

        // ── Unread chat count ───────────────────────────────────────
        function updateUnreadChats() {
            fetch("{{ route('global.chats.unread-count') }}")
                .then(r => r.json())
                .then(data => {
                    const badge = document.getElementById('sidebar-unread-chat-count');
                    if (badge) {
                        if (data.count > 0) {
                            badge.textContent = data.count;
                            badge.classList.remove('d-none');
                        } else {
                            badge.classList.add('d-none');
                        }
                    }
                    // Also light up notif dot if unread
                    const dot = document.getElementById('notifDot');
                    if (dot) {
                        dot.classList.toggle('d-none', data.count === 0);
                    }
                })
                .catch(() => {});
        }
        setInterval(updateUnreadChats, 10000);
        updateUnreadChats();

        // ── Strict tab session ──────────────────────────────────────
        @if(session('just_logged_in'))
            sessionStorage.setItem('sim_tab_active', '1');
        @else
            if (!sessionStorage.getItem('sim_tab_active')) {
                // Auto-logout on new tab
                const f = document.createElement('form');
                f.method = 'POST';
                f.action = "{{ route('logout') }}";
                f.innerHTML = '@csrf';
                document.body.appendChild(f);
                f.submit();
            }
        @endif
    });
    </script>

    @include('components.session-alert')
    @stack('scripts')

</body>
</html>
