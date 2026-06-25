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
    <!-- Google Fonts — Sentinels of Silicon -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <style>
    /* ================================================================
       SENTINELS OF SILICON — Design Tokens
    ================================================================ */
    :root {
        /* Color Palette */
        --primary:              #000613;
        --primary-container:    #001f3f;
        --on-primary:           #ffffff;
        --secondary:            #0059bb;
        --secondary-container:  #0070ea;
        --on-secondary:         #ffffff;
        --tertiary:             #00070a;
        --tertiary-container:   #002328;
        --background:           #f8f9fa;
        --surface:              #f8f9fa;
        --surface-bright:       #f8f9fa;
        --surface-container-lowest: #ffffff;
        --surface-container-low: #f3f4f5;
        --surface-container:    #edeeef;
        --surface-container-high: #e7e8e9;
        --surface-container-highest: #e1e3e4;
        --on-surface:           #191c1d;
        --on-surface-variant:   #43474e;
        --outline:              #74777f;
        --outline-variant:      #c4c6cf;
        --surface-tint:         #476083;
        --error:                #ba1a1a;
        --on-error:             #ffffff;
        --success:              #00a550;

        /* Sidebar */
        --sidebar-width:        260px;
        --sidebar-bg:           var(--primary-container);
        --sidebar-border:       rgba(255,255,255,0.08);
        --sidebar-hover:        rgba(255,255,255,0.07);
        --sidebar-active:       rgba(0,112,234,0.25);
        --sidebar-active-border:#0070ea;
        --sidebar-text:         rgba(255,255,255,0.55);
        --sidebar-text-h:       rgba(255,255,255,0.85);
        --sidebar-text-a:       #ffffff;

        /* Body */
        --body-bg:              var(--background);
        --topbar-bg:            rgba(255,255,255,0.85);

        /* Components */
        --card-bg:              var(--surface-container-lowest);
        --card-border:          var(--outline-variant);
        --card-shadow:          0 1px 4px rgba(0,31,63,0.06), 0 2px 8px rgba(0,31,63,0.04);
        --card-shadow-hover:    0 8px 24px rgba(0,31,63,0.1);

        /* State colors */
        --danger:               #ba1a1a;
        --danger-light:         rgba(186,26,26,0.08);
        --warning:              #8a5f00;
        --warning-light:        rgba(138,95,0,0.1);
        --info:                 var(--secondary);
        --info-light:           rgba(0,89,187,0.08);
        --purple:               #6750a4;
        --purple-light:         rgba(103,80,164,0.1);
        --cyan:                 #006876;
        --cyan-light:           rgba(0,104,118,0.08);

        /* Text */
        --text-1:               var(--on-surface);
        --text-2:               var(--on-surface-variant);
        --text-3:               var(--outline);

        /* Border */
        --border:               var(--outline-variant);

        /* Typography */
        --font:                 'Inter', system-ui, sans-serif;
        --font-display:         'Montserrat', system-ui, sans-serif;
        --font-label:           'JetBrains Mono', monospace;

        /* Radii */
        --radius-sm:            4px;
        --radius-md:            8px;
        --radius-lg:            12px;
        --radius-xl:            16px;

        --transition:           0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ================================================================
       RESET & BASE
    ================================================================ */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }

    body {
        background-color: var(--body-bg);
        background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg stroke='%230059bb' stroke-width='0.5' stroke-opacity='0.03'%3E%3Cpath d='M40 40c0-8.8 7.2-16 16-16s16 7.2 16 16-7.2 16-16 16-16-7.2-16-16zM0 0h80v80H0V0zm1 1v78h78V1H1zm39 39c0-5.5 4.5-10 10-10s10 4.5 10 10-4.5 10-10 10-10-4.5-10-10z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        color: var(--on-surface);
        font-family: var(--font);
        overflow-x: hidden;
        min-height: 100vh;
    }

    /* Scrollbar */
    ::-webkit-scrollbar { width: 5px; height: 5px; }
    ::-webkit-scrollbar-track { background: var(--surface-container-low); }
    ::-webkit-scrollbar-thumb { background: rgba(0,89,187,0.25); border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: var(--secondary); }

    /* Material Symbols */
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        vertical-align: middle;
    }

    /* ================================================================
       SIDEBAR
    ================================================================ */
    .mhs-sidebar {
        width: var(--sidebar-width);
        height: 100vh;
        background: var(--primary-container);
        position: fixed;
        top: 0; left: 0;
        z-index: 1040;
        display: flex;
        flex-direction: column;
        border-right: 1px solid rgba(255,255,255,0.06);
        transition: transform var(--transition);
    }

    /* Circuit pattern overlay on sidebar — removed for clean look */
    /* .mhs-sidebar::before { ... } */

    /* Brand */
    .mhs-brand {
        padding: 20px 18px;
        border-bottom: 1px solid rgba(255,255,255,0.06);
        flex-shrink: 0;
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
        z-index: 1;
    }

    .mhs-brand-logo {
        width: 44px; height: 44px;
        border-radius: var(--radius-md);
        object-fit: cover;
        border: 1.5px solid rgba(0,112,234,0.4);
        box-shadow: 0 0 12px rgba(0,112,234,0.2);
        flex-shrink: 0;
    }

    .mhs-brand-text { line-height: 1.2; }
    .mhs-brand-text .t1 {
        font-family: var(--font-display);
        font-size: 0.78rem;
        font-weight: 700;
        color: #fff;
        letter-spacing: 0.5px;
        display: block;
    }
    .mhs-brand-text .t2 {
        font-family: var(--font-label);
        font-size: 0.58rem;
        font-weight: 500;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: rgba(175,200,240,0.9);
        display: block;
    }
    .mhs-brand-text .t3 {
        font-size: 0.48rem;
        color: rgba(255,255,255,0.4);
        letter-spacing: 0.05em;
        display: block;
        margin-top: 2px;
    }

    /* User mini */
    .mhs-user-mini {
        padding: 12px 18px;
        border-bottom: 1px solid rgba(255,255,255,0.06);
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
        position: relative;
        z-index: 1;
    }

    .mhs-avatar {
        width: 34px; height: 34px;
        border-radius: var(--radius-sm);
        background: var(--secondary);
        display: flex; align-items: center; justify-content: center;
        font-family: var(--font-display);
        font-size: 0.85rem;
        color: #fff;
        font-weight: 700;
        flex-shrink: 0;
        overflow: hidden;
    }

    .mhs-avatar img { width: 100%; height: 100%; object-fit: cover; }

    .mhs-user-info .uname {
        font-family: var(--font);
        font-size: 0.78rem;
        font-weight: 600;
        color: rgba(255,255,255,0.9);
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 160px;
    }

    .mhs-user-info .urole {
        font-family: var(--font-label);
        font-size: 0.58rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: rgba(175,200,240,0.8);
    }

    /* Nav */
    .mhs-nav {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 8px 0 16px;
        position: relative;
        z-index: 1;
    }

    .mhs-nav::-webkit-scrollbar { width: 4px; }
    .mhs-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); }

    .mhs-nav-section-label {
        font-family: var(--font-label);
        font-size: 0.58rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        color: rgba(255,255,255,0.3);
        padding: 16px 18px 6px;
    }

    .mhs-nav-link {
        display: flex;
        align-items: center;
        padding: 8px 12px;
        margin: 1px 10px;
        color: var(--sidebar-text);
        text-decoration: none;
        font-family: var(--font);
        font-size: 0.84rem;
        font-weight: 500;
        border-radius: 8px;
        border-left: none;
        transition: all 0.18s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        position: relative;
    }

    .mhs-nav-link:hover {
        background: var(--sidebar-hover);
        color: var(--sidebar-text-h);
    }

    .mhs-nav-link.active {
        background: var(--sidebar-active);
        color: var(--sidebar-text-a);
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(0,112,234,0.2);
    }

    .mhs-nav-link.active::before {
        content: '';
        position: absolute;
        left: 0; top: 20%; bottom: 20%;
        width: 3px;
        background: var(--sidebar-active-border);
        border-radius: 0 3px 3px 0;
    }

    .mhs-nav-icon {
        width: 30px; height: 30px; min-width: 30px;
        margin-right: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem;
        border-radius: 7px;
        background: transparent;
        opacity: 0.6;
        transition: all 0.18s;
        flex-shrink: 0;
    }

    .mhs-nav-link:hover .mhs-nav-icon { opacity: 1; }

    .mhs-nav-link.active .mhs-nav-icon {
        opacity: 1;
        background: rgba(0,112,234,0.2);
        color: rgba(175,200,240,1);
    }

    .mhs-nav-section-label {
        font-family: var(--font-label);
        font-size: 0.55rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        color: rgba(255,255,255,0.25);
        padding: 14px 22px 5px;
    }

    .mhs-nav-badge {
        margin-left: auto;
        background: var(--error);
        color: #fff;
        font-family: var(--font-label);
        font-size: 0.6rem;
        font-weight: 500;
        padding: 2px 6px;
        border-radius: 10px;
        min-width: 18px;
        text-align: center;
    }

    /* Sidebar footer — only logout */
    .mhs-sidebar-footer {
        border-top: 1px solid rgba(255,255,255,0.06);
        padding: 10px 10px 12px;
        flex-shrink: 0;
        position: relative;
        z-index: 1;
    }

    .mhs-logout-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 12px;
        color: rgba(255,255,255,0.35);
        font-family: var(--font);
        font-size: 0.84rem;
        font-weight: 500;
        cursor: pointer;
        border-radius: 8px;
        border: 1px solid transparent;
        background: transparent;
        width: 100%;
        text-align: left;
        transition: all 0.18s;
    }

    .mhs-logout-btn:hover {
        background: rgba(186,26,26,0.12);
        border-color: rgba(186,26,26,0.2);
        color: #ff8a80;
    }

    /* ── CLOCK WIDGET — floating, separate from sidebar ─────────── */
    .clock-widget {
        position: fixed;
        bottom: 20px;
        right: 20px;
        left: auto;
        z-index: 950;
        background: var(--primary-container);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 14px;
        padding: 12px 20px 12px 16px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 8px 28px rgba(0,6,19,0.35), 0 0 0 1px rgba(255,255,255,0.04) inset;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        min-width: 200px;
        animation: clock-in 0.5s cubic-bezier(0.22,1,0.36,1) both;
    }

    @keyframes clock-in {
        from { opacity: 0; transform: translateY(12px) scale(0.96); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    .clock-widget-icon {
        width: 36px; height: 36px;
        flex-shrink: 0;
        background: rgba(0,112,234,0.18);
        border: 1px solid rgba(0,112,234,0.3);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        color: rgba(175,200,240,0.9);
        font-size: 1rem;
    }

    .clock-widget-body { line-height: 1; }

    .clock-widget-time {
        font-family: var(--font-display);
        font-size: 1.3rem;
        font-weight: 800;
        color: #fff;
        letter-spacing: 0.04em;
        display: block;
        margin-bottom: 3px;
    }

    .clock-widget-date {
        font-family: var(--font-label);
        font-size: 0.58rem;
        color: rgba(255,255,255,0.35);
        letter-spacing: 0.07em;
        text-transform: uppercase;
        display: block;
    }

    @media (max-width: 991.98px) {
        .clock-widget { right: 16px; left: auto; bottom: 16px; }
    }

    /* ── GLASSMORPHISM HOVER — cards and interactive elements ──── */
    .mhs-card {
        transition: box-shadow var(--transition), border-color var(--transition),
                    background var(--transition), transform var(--transition);
        will-change: transform;
    }

    .mhs-card:hover {
        background: rgba(255,255,255,0.92) !important;
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-color: rgba(0,89,187,0.18) !important;
        box-shadow: 0 8px 32px rgba(0,31,63,0.10),
                    0 0 0 1px rgba(0,89,187,0.08) inset !important;
        transform: translateY(-2px);
    }

    .shortcut-btn:hover {
        background: rgba(255,255,255,0.88) !important;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-color: rgba(0,89,187,0.2) !important;
        box-shadow: 0 4px 18px rgba(0,89,187,0.12) !important;
        transform: translateY(-3px);
    }

    /* ── TOPBAR SEARCH ────────────────────────────────────────── */
    .topbar-search-wrap {
        position: relative;
        flex: 1;
        max-width: 420px;
        margin: 0 16px;
    }

    .topbar-search-input {
        width: 100%;
        height: 38px;
        padding: 0 14px 0 38px;
        background: var(--surface-container-low);
        border: 1.5px solid var(--outline-variant);
        border-radius: 10px;
        font-family: var(--font);
        font-size: 0.83rem;
        color: var(--on-surface);
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    }

    .topbar-search-input::placeholder { color: var(--outline); }

    .topbar-search-input:focus {
        background: #fff;
        border-color: var(--secondary);
        box-shadow: 0 0 0 3px rgba(0,89,187,0.1);
    }

    .topbar-search-icon {
        position: absolute;
        left: 11px; top: 50%;
        transform: translateY(-50%);
        color: var(--outline);
        font-size: 0.9rem;
        pointer-events: none;
        transition: color 0.2s;
    }

    .topbar-search-wrap:focus-within .topbar-search-icon {
        color: var(--secondary);
    }

    .topbar-search-kbd {
        position: absolute;
        right: 10px; top: 50%;
        transform: translateY(-50%);
        font-family: var(--font-label);
        font-size: 0.55rem;
        color: var(--outline);
        background: var(--surface-container);
        border: 1px solid var(--outline-variant);
        border-radius: 4px;
        padding: 2px 5px;
        letter-spacing: 0.05em;
        pointer-events: none;
        transition: opacity 0.2s;
    }

    .topbar-search-wrap:focus-within .topbar-search-kbd { opacity: 0; }

    /* Dropdown */
    .search-dropdown {
        position: absolute;
        top: calc(100% + 6px);
        left: 0; right: 0;
        background: #fff;
        border: 1.5px solid var(--outline-variant);
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(0,31,63,0.12);
        overflow: hidden;
        z-index: 9999;
        display: none;
        max-height: 320px;
        overflow-y: auto;
        animation: dropdown-in 0.18s cubic-bezier(0.22,1,0.36,1) both;
    }

    @keyframes dropdown-in {
        from { opacity: 0; transform: translateY(-6px) scale(0.98); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    .search-dropdown.show { display: block; }

    .search-result-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        text-decoration: none;
        color: var(--on-surface);
        font-family: var(--font);
        font-size: 0.84rem;
        border-bottom: 1px solid var(--surface-container-low);
        transition: background 0.12s;
        cursor: pointer;
    }

    .search-result-item:last-child { border-bottom: none; }

    .search-result-item:hover,
    .search-result-item.focused {
        background: rgba(0,89,187,0.06);
        color: var(--secondary);
    }

    .search-result-icon {
        width: 30px; height: 30px; flex-shrink: 0;
        background: rgba(0,89,187,0.08);
        border-radius: 7px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.85rem;
        color: var(--secondary);
    }

    .search-result-text { flex: 1; min-width: 0; }
    .search-result-name { font-weight: 600; display: block; }
    .search-result-section {
        font-family: var(--font-label);
        font-size: 0.62rem;
        color: var(--outline);
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .search-highlight { color: var(--secondary); font-weight: 700; }

    .search-empty {
        padding: 20px 16px;
        text-align: center;
        font-family: var(--font);
        font-size: 0.82rem;
        color: var(--outline);
    }

    @media (max-width: 767px) {
        .topbar-search-wrap { display: none; }
    }

    /* ================================================================
       MAIN CONTENT
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
        background: rgba(255,255,255,0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-bottom: 1px solid var(--outline-variant);
        box-shadow: 0 1px 4px rgba(0,31,63,0.06);
        padding: 0 28px;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .mhs-breadcrumb {
        display: flex;
        align-items: center;
        gap: 6px;
        font-family: var(--font);
        font-size: 0.8rem;
        color: var(--on-surface-variant);
    }

    .mhs-breadcrumb a {
        color: var(--on-surface-variant);
        text-decoration: none;
        transition: color 0.15s;
    }

    .mhs-breadcrumb a:hover { color: var(--secondary); }

    .mhs-breadcrumb .sep { opacity: 0.4; font-size: 0.6rem; }

    .mhs-breadcrumb .current {
        color: var(--on-surface);
        font-weight: 600;
    }

    .mhs-topbar-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Notif bell */
    .notif-btn {
        width: 36px; height: 36px;
        border-radius: var(--radius-sm);
        background: transparent;
        border: 1px solid var(--outline-variant);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        color: var(--on-surface-variant);
        font-size: 0.95rem;
        position: relative;
        transition: all 0.15s;
    }

    .notif-btn:hover {
        border-color: var(--secondary);
        color: var(--secondary);
        background: rgba(0,89,187,0.06);
    }

    .notif-dot {
        position: absolute;
        top: 7px; right: 7px;
        width: 6px; height: 6px;
        border-radius: 50%;
        background: var(--error);
        border: 1.5px solid white;
    }

    /* Topbar user */
    .topbar-user {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 6px 12px;
        background: var(--surface-container-low);
        border: 1px solid var(--outline-variant);
        border-radius: var(--radius-sm);
        cursor: default;
    }

    .topbar-avatar {
        width: 32px; height: 32px;
        border-radius: var(--radius-sm);
        background: var(--primary-container);
        display: flex; align-items: center; justify-content: center;
        font-family: var(--font-display);
        font-size: 0.78rem;
        color: #fff;
        font-weight: 700;
        flex-shrink: 0;
        overflow: hidden;
    }

    .topbar-avatar img { width: 100%; height: 100%; object-fit: cover; }

    .topbar-user-name {
        font-family: var(--font);
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--on-surface);
        white-space: nowrap;
    }

    .topbar-user-role {
        font-family: var(--font-label);
        font-size: 0.6rem;
        font-weight: 500;
        color: var(--secondary);
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    /* Mobile toggle */
    .mhs-sidebar-toggle {
        display: none;
        width: 36px; height: 36px;
        border-radius: var(--radius-sm);
        background: var(--surface-container-low);
        border: 1px solid var(--outline-variant);
        color: var(--on-surface);
        font-size: 1rem;
        cursor: pointer;
        align-items: center; justify-content: center;
        transition: all 0.15s;
    }

    .mhs-sidebar-toggle:hover {
        border-color: var(--secondary);
        color: var(--secondary);
    }

    /* Overlay */
    .mhs-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.4);
        z-index: 1035;
        backdrop-filter: blur(2px);
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
        border-radius: var(--radius-sm);
        font-family: var(--font);
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 20px;
        border: 1px solid;
        animation: fadeInDown 0.3s ease;
    }

    .mhs-alert.success {
        background: rgba(0,165,80,0.08);
        border-color: rgba(0,165,80,0.25);
        color: var(--success);
    }

    .mhs-alert.danger {
        background: var(--danger-light);
        border-color: rgba(186,26,26,0.25);
        color: var(--danger);
    }

    .mhs-alert.warning {
        background: var(--warning-light);
        border-color: rgba(138,95,0,0.25);
        color: var(--warning);
    }

    /* ================================================================
       SHARED UTILITY COMPONENTS
    ================================================================ */

    /* Cards */
    .mhs-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--card-shadow);
        transition: box-shadow var(--transition), border-color var(--transition);
    }

    .mhs-card:hover {
        box-shadow: var(--card-shadow-hover);
    }

    .mhs-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        border-bottom: 1px solid var(--outline-variant);
        background: var(--surface-container-low);
    }

    .mhs-card-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: var(--font-display);
        font-size: 0.875rem;
        font-weight: 700;
        color: var(--primary-container);
        margin: 0;
    }

    .mhs-card-icon {
        width: 28px; height: 28px;
        border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.875rem;
        flex-shrink: 0;
    }

    .mhs-card-body { padding: 20px; }

    /* Badges */
    .mhs-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        border-radius: 100px;
        font-family: var(--font-label);
        font-size: 0.65rem;
        font-weight: 500;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .mhs-badge.primary  { background: rgba(0,89,187,0.1); color: var(--secondary); border: 1px solid rgba(0,89,187,0.2); }
    .mhs-badge.cyan     { background: rgba(0,104,118,0.1); color: var(--cyan); border: 1px solid rgba(0,104,118,0.2); }
    .mhs-badge.success  { background: rgba(0,165,80,0.1); color: var(--success); border: 1px solid rgba(0,165,80,0.2); }
    .mhs-badge.danger   { background: var(--danger-light); color: var(--danger); border: 1px solid rgba(186,26,26,0.2); }
    .mhs-badge.warning  { background: var(--warning-light); color: var(--warning); border: 1px solid rgba(138,95,0,0.2); }
    .mhs-badge.muted    { background: var(--surface-container); color: var(--on-surface-variant); border: 1px solid var(--outline-variant); }
    .mhs-badge.purple   { background: var(--purple-light); color: var(--purple); border: 1px solid rgba(103,80,164,0.2); }

    /* Tables */
    .mhs-table {
        width: 100%;
        border-collapse: collapse;
        font-family: var(--font);
        font-size: 0.84rem;
    }

    .mhs-table thead tr {
        background: var(--surface-container-low);
    }

    .mhs-table th {
        padding: 10px 14px;
        text-align: left;
        font-family: var(--font-label);
        font-size: 0.62rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--on-surface-variant);
        border-bottom: 1px solid var(--outline-variant);
        white-space: nowrap;
    }

    .mhs-table td {
        padding: 12px 14px;
        border-bottom: 1px solid var(--surface-container-high);
        color: var(--on-surface);
        vertical-align: middle;
    }

    .mhs-table tbody tr:last-child td { border-bottom: none; }

    .mhs-table tbody tr:hover {
        background: var(--surface-container-low);
    }

    /* Form controls */
    .mhs-input {
        width: 100%;
        padding: 10px 13px;
        background: var(--surface-container-lowest);
        border: 1px solid var(--outline-variant);
        border-radius: var(--radius-sm);
        font-family: var(--font);
        font-size: 0.875rem;
        color: var(--on-surface);
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
    }

    .mhs-input::placeholder { color: var(--outline); }

    .mhs-input:focus {
        border-color: var(--secondary);
        box-shadow: 0 0 0 3px rgba(0,89,187,0.15);
        background: #fff;
    }

    select.mhs-input {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%2343474e' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 12px;
        padding-right: 32px;
    }

    textarea.mhs-input { resize: vertical; min-height: 90px; }

    .mhs-label {
        display: block;
        font-family: var(--font-label);
        font-size: 0.68rem;
        font-weight: 500;
        color: var(--on-surface-variant);
        text-transform: uppercase;
        letter-spacing: 0.08em;
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
        border-radius: var(--radius-sm);
        font-family: var(--font);
        font-size: 0.84rem;
        font-weight: 600;
        cursor: pointer;
        border: 1px solid transparent;
        transition: all var(--transition);
        text-decoration: none;
        white-space: nowrap;
    }

    .mhs-btn-primary {
        background: var(--primary-container);
        color: var(--on-primary);
        border-color: transparent;
        box-shadow: 0 2px 8px rgba(0,31,63,0.2);
    }

    .mhs-btn-primary:hover {
        background: var(--primary);
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(0,31,63,0.25);
        color: var(--on-primary);
    }

    .mhs-btn-ghost {
        background: transparent;
        color: var(--on-surface-variant);
        border-color: var(--outline-variant);
    }

    .mhs-btn-ghost:hover {
        border-color: var(--secondary);
        color: var(--secondary);
        background: rgba(0,89,187,0.06);
    }

    .mhs-btn-success {
        background: rgba(0,165,80,0.1);
        color: var(--success);
        border-color: rgba(0,165,80,0.25);
    }

    .mhs-btn-success:hover {
        background: var(--success);
        color: #fff;
        border-color: var(--success);
    }

    .mhs-btn-danger {
        background: var(--danger-light);
        color: var(--danger);
        border-color: rgba(186,26,26,0.25);
    }

    .mhs-btn-danger:hover {
        background: var(--danger);
        color: #fff;
    }

    .mhs-btn-sm { padding: 6px 14px; font-size: 0.78rem; }
    .mhs-btn-full { width: 100%; justify-content: center; }

    /* Section label */
    .mhs-section-label {
        font-family: var(--font-label);
        font-size: 0.62rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: var(--on-surface-variant);
        margin-bottom: 10px;
    }

    /* Empty state */
    .mhs-empty {
        text-align: center;
        padding: 32px 20px;
        color: var(--outline);
    }

    .mhs-empty i { font-size: 2rem; display: block; margin-bottom: 10px; }
    .mhs-empty p { font-family: var(--font); font-size: 0.875rem; margin: 0; }

    /* Modals */
    .mhs-modal .modal-content {
        background: var(--surface-container-lowest);
        border: 1px solid var(--outline-variant);
        border-radius: var(--radius-lg);
        box-shadow: 0 25px 60px rgba(0,31,63,0.15);
        color: var(--on-surface);
    }

    .mhs-modal .modal-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--outline-variant);
        background: var(--surface-container-low);
        border-radius: var(--radius-lg) var(--radius-lg) 0 0;
    }

    .mhs-modal .modal-title {
        font-family: var(--font-display);
        font-size: 1rem;
        font-weight: 700;
        color: var(--primary-container);
    }

    .mhs-modal .modal-body { padding: 20px 24px; }
    .mhs-modal .modal-footer {
        padding: 14px 24px;
        border-top: 1px solid var(--outline-variant);
        background: var(--surface-container-low);
        border-radius: 0 0 var(--radius-lg) var(--radius-lg);
        gap: 10px;
    }

    /* Hint text */
    .mhs-hint {
        font-family: var(--font-label);
        font-size: 0.68rem;
        color: var(--outline);
        margin-top: 4px;
    }

    /* Glass card utility */
    .glass-card {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255,255,255,0.5);
        box-shadow: 0 4px 16px rgba(0, 31, 63, 0.06);
    }

    /* ================================================================
       BOOTSTRAP OVERRIDE — Light Theme
    ================================================================ */
    .table-dark {
        --bs-table-bg: var(--surface-container-lowest) !important;
        --bs-table-striped-bg: var(--surface-container-low) !important;
        --bs-table-hover-bg: var(--surface-container-low) !important;
        --bs-table-border-color: var(--outline-variant) !important;
        --bs-table-color: var(--on-surface) !important;
        color: var(--on-surface) !important;
        background-color: var(--surface-container-lowest) !important;
    }

    .table-dark thead th, .table-dark th {
        background-color: var(--surface-container-low) !important;
        color: var(--on-surface-variant) !important;
        border-color: var(--outline-variant) !important;
        font-family: var(--font-label) !important;
        font-size: 0.62rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .table-dark tbody tr {
        background-color: var(--surface-container-lowest) !important;
        color: var(--on-surface) !important;
    }

    .table-dark tbody tr:hover {
        background-color: var(--surface-container-low) !important;
    }

    .bg-dark:not(.mhs-sidebar):not(.mhs-sidebar *) {
        background-color: var(--surface-container-lowest) !important;
        color: var(--on-surface) !important;
    }

    .modal-content.bg-dark {
        background-color: var(--surface-container-lowest) !important;
        color: var(--on-surface) !important;
        border: 1px solid var(--outline-variant) !important;
    }

    .modal-content.bg-dark .modal-header {
        background: var(--surface-container-low) !important;
        border-bottom: 1px solid var(--outline-variant) !important;
    }

    .form-control-dark, .form-select-dark,
    .form-control.bg-dark, .form-select.bg-dark {
        background-color: var(--surface-container-low) !important;
        border: 1px solid var(--outline-variant) !important;
        color: var(--on-surface) !important;
    }

    .form-control-dark:focus, .form-select-dark:focus,
    .form-control.bg-dark:focus, .form-select.bg-dark:focus {
        background-color: #fff !important;
        border-color: var(--secondary) !important;
        color: var(--on-surface) !important;
        box-shadow: 0 0 0 3px rgba(0,89,187,0.15) !important;
    }

    .main-content .text-white:not(.btn):not(.badge):not(.alert *):not(.mhs-sidebar *) {
        color: var(--on-surface) !important;
    }

    .input-group-text.bg-dark, .input-group-text.bg-transparent {
        background-color: var(--surface-container-low) !important;
        border-color: var(--outline-variant) !important;
        color: var(--on-surface-variant) !important;
    }

    .filter-card {
        background: var(--surface-container-lowest) !important;
        border: 1px solid var(--outline-variant) !important;
        border-radius: var(--radius-lg);
    }

    .stat-card {
        background: var(--surface-container-lowest) !important;
        border: 1px solid var(--outline-variant) !important;
        border-radius: var(--radius-lg);
        box-shadow: var(--card-shadow);
    }

    .bg-darker {
        background-color: var(--surface-container-low) !important;
        color: var(--on-surface) !important;
    }

    .btn-outline-info {
        color: var(--secondary) !important;
        border-color: var(--secondary) !important;
    }

    .btn-outline-info:hover {
        background-color: var(--secondary) !important;
        color: #fff !important;
    }

    .font-monospace.bg-dark, .badge.bg-dark {
        background-color: var(--surface-container) !important;
        color: var(--on-surface-variant) !important;
    }

    .mhs-page h1, .mhs-page h2, .mhs-page h3 {
        font-family: var(--font-display);
        color: var(--primary-container);
    }

    .card.bg-dark {
        background-color: var(--surface-container-lowest) !important;
        border: 1px solid var(--outline-variant) !important;
    }

    .card.bg-dark * { color: var(--on-surface) !important; }

    .cohort-card {
        background: var(--surface-container-lowest);
        border: 1.5px solid var(--outline-variant);
        border-radius: var(--radius-lg);
        transition: all 0.15s;
    }

    .cohort-card:hover {
        border-color: var(--secondary);
        box-shadow: 0 4px 12px rgba(0,89,187,0.12);
    }

    /* Form control options */
    .form-control-dark option, .form-select-dark option,
    .form-select.bg-dark option {
        background-color: #fff;
        color: var(--on-surface);
    }

    /* ================================================================
       ANIMATIONS
    ================================================================ */
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-10px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .mhs-page > * { animation: fadeInUp 0.3s ease both; }

    /* ================================================================
       RESPONSIVE
    ================================================================ */
    @media (max-width: 991.98px) {
        .mhs-sidebar {
            transform: translateX(-100%);
        }

        .mhs-sidebar.show {
            transform: translateX(0);
            box-shadow: 8px 0 40px rgba(0,31,63,0.2);
        }

        .mhs-main { margin-left: 0; }
        .mhs-page { padding: 16px; }
        .mhs-topbar { padding: 0 16px; }

        .mhs-sidebar-toggle { display: flex; }
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

            <div class="mhs-nav-section-label">Komunikasi &amp; Aktivitas</div>

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
                Profil &amp; Akun
            </a>

        </nav>

        <!-- Footer: Logout inside sidebar -->
        <div class="mhs-sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="mhs-logout-btn">
                    <span class="mhs-nav-icon"><i class="bi bi-box-arrow-left"></i></span>
                    Keluar
                </button>
            </form>
        </div>

    </aside>

    <!-- ================================================================
         CLOCK WIDGET — separate floating element, outside sidebar
    ================================================================ -->
    <div class="clock-widget" id="clockWidget">
        <div class="clock-widget-icon">
            <i class="bi bi-clock"></i>
        </div>
        <div class="clock-widget-body">
            <span class="clock-widget-time" id="sidebarClock">00:00:00</span>
            <span class="clock-widget-date" id="sidebarDate"></span>
        </div>
    </div>

    <!-- ================================================================
         MAIN
    ================================================================ -->
    <div class="mhs-main">

        <!-- Top Bar -->
        <header class="mhs-topbar">

            <div class="d-flex align-items-center gap-3">
                <button class="mhs-sidebar-toggle" id="mhsToggle" aria-label="Toggle sidebar">
                    <i class="bi bi-list"></i>
                </button>

                <nav class="mhs-breadcrumb">
                    <a href="{{ route('mahasiswa.dashboard') }}">Portal</a>
                    <span class="sep"><i class="bi bi-chevron-right" style="font-size:0.6rem;"></i></span>
                    <span class="current">@yield('title', 'Dashboard')</span>
                </nav>
            </div>

            <!-- ── SEARCH BAR CENTER ── -->
            <div class="topbar-search-wrap" id="searchWrap">
                <i class="bi bi-search topbar-search-icon"></i>
                <input type="text" id="topbarSearch"
                    class="topbar-search-input"
                    placeholder="Cari menu, fitur, atau halaman..."
                    autocomplete="off"
                    aria-label="Cari menu">
                <span class="topbar-search-kbd">Ctrl K</span>
                <div class="search-dropdown" id="searchDropdown"></div>
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

        // ── Live Sidebar Clock ──────────────────────────────────────
        const clockEl = document.getElementById('sidebarClock');
        const dateEl  = document.getElementById('sidebarDate');
        const days    = ['MIN','SEN','SEL','RAB','KAM','JUM','SAB'];
        const months  = ['JAN','FEB','MAR','APR','MEI','JUN','JUL','AGS','SEP','OKT','NOV','DES'];

        function tickClock() {
            const now = new Date();
            const hh  = String(now.getHours()).padStart(2, '0');
            const mm  = String(now.getMinutes()).padStart(2, '0');
            const ss  = String(now.getSeconds()).padStart(2, '0');
            if (clockEl) clockEl.textContent = `${hh}:${mm}:${ss}`;
            if (dateEl)  dateEl.textContent  =
                `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
        }
        tickClock();
        setInterval(tickClock, 1000);

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
                const f = document.createElement('form');
                f.method = 'POST';
                f.action = "{{ route('logout') }}";
                f.innerHTML = '@csrf';
                document.body.appendChild(f);
                f.submit();
            }
        @endif

        // ── Topbar Search Engine ────────────────────────────────────
        const MENU_ITEMS = [
            { name: 'Dashboard',            section: 'Utama',               icon: 'bi-grid-1x2',          url: '{{ route("mahasiswa.dashboard") }}' },
            { name: 'Riwayat Absensi',      section: 'Akademik',            icon: 'bi-calendar-check',    url: '{{ route("mahasiswa.attendances.index") }}' },
            { name: 'Absensi',              section: 'Akademik',            icon: 'bi-calendar-check',    url: '{{ route("mahasiswa.attendances.index") }}' },
            { name: 'Transkrip Nilai',      section: 'Akademik',            icon: 'bi-bar-chart-line',    url: '{{ route("mahasiswa.nilai.index") }}' },
            { name: 'Nilai',                section: 'Akademik',            icon: 'bi-bar-chart-line',    url: '{{ route("mahasiswa.nilai.index") }}' },
            { name: 'Bahan Ajar',           section: 'Akademik',            icon: 'bi-journal-text',      url: '{{ route("mahasiswa.materials.index") }}' },
            { name: 'Materi',               section: 'Akademik',            icon: 'bi-journal-text',      url: '{{ route("mahasiswa.materials.index") }}' },
            { name: 'Surat',                section: 'Akademik',            icon: 'bi-envelope-paper',    url: '{{ route("mahasiswa.submissions.index") }}' },
            { name: 'Pengajuan Surat',      section: 'Akademik',            icon: 'bi-envelope-paper',    url: '{{ route("mahasiswa.submissions.index") }}' },
            { name: 'Berkas',               section: 'Akademik',            icon: 'bi-folder2-open',      url: '{{ route("mahasiswa.berkas.index") }}' },
            { name: 'Dokumen',              section: 'Akademik',            icon: 'bi-folder2-open',      url: '{{ route("mahasiswa.berkas.index") }}' },
            { name: 'Chat',                 section: 'Komunikasi',          icon: 'bi-chat-dots',         url: '{{ route("mahasiswa.chats.index") }}' },
            { name: 'Pesan',                section: 'Komunikasi',          icon: 'bi-chat-dots',         url: '{{ route("mahasiswa.chats.index") }}' },
            { name: 'Daftar UKM',           section: 'Aktivitas',           icon: 'bi-people',            url: '{{ route("mahasiswa.ukms.index") }}' },
            { name: 'UKM',                  section: 'Aktivitas',           icon: 'bi-people',            url: '{{ route("mahasiswa.ukms.index") }}' },
            { name: 'Riwayat Pelanggaran',  section: 'Aktivitas',           icon: 'bi-exclamation-octagon', url: '{{ route("mahasiswa.violations.index") }}' },
            { name: 'Pelanggaran',          section: 'Aktivitas',           icon: 'bi-exclamation-octagon', url: '{{ route("mahasiswa.violations.index") }}' },
            { name: 'Profil & Akun',        section: 'Pengaturan',          icon: 'bi-person-gear',       url: '{{ route("mahasiswa.profile.index") }}' },
            { name: 'Profil',               section: 'Pengaturan',          icon: 'bi-person-gear',       url: '{{ route("mahasiswa.profile.index") }}' },
            { name: 'Akun',                 section: 'Pengaturan',          icon: 'bi-person-gear',       url: '{{ route("mahasiswa.profile.index") }}' },
        ];

        const searchInput    = document.getElementById('topbarSearch');
        const searchDropdown = document.getElementById('searchDropdown');
        let focusIndex = -1;
        let visibleItems = [];

        // Google-style keyword matching: semua kata query harus muncul di nama/section
        function keywordMatch(item, query) {
            const tokens = query.trim().toLowerCase().split(/\s+/).filter(Boolean);
            const haystack = (item.name + ' ' + item.section).toLowerCase();
            return tokens.every(tok => haystack.includes(tok));
        }

        // Highlight query tokens di dalam text
        function highlight(text, query) {
            const tokens = query.trim().split(/\s+/).filter(Boolean);
            let result = text;
            tokens.forEach(tok => {
                const re = new RegExp('(' + tok.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi');
                result = result.replace(re, '<span class="search-highlight">$1</span>');
            });
            return result;
        }

        function renderResults(query) {
            const q = query.trim();
            if (!q) { closeDropdown(); return; }

            // Deduplicate by url, score by position of first keyword match
            const seen = new Set();
            visibleItems = MENU_ITEMS.filter(item => {
                if (seen.has(item.url)) return false;
                if (!keywordMatch(item, q)) return false;
                seen.add(item.url);
                return true;
            }).slice(0, 8);

            if (!visibleItems.length) {
                searchDropdown.innerHTML = `<div class="search-empty"><i class="bi bi-search me-2"></i>Tidak ditemukan hasil untuk "<strong>${q}</strong>"</div>`;
            } else {
                searchDropdown.innerHTML = visibleItems.map((item, i) => `
                    <a href="${item.url}" class="search-result-item" data-idx="${i}">
                        <div class="search-result-icon"><i class="bi ${item.icon}"></i></div>
                        <div class="search-result-text">
                            <span class="search-result-name">${highlight(item.name, q)}</span>
                            <span class="search-result-section">${item.section}</span>
                        </div>
                        <i class="bi bi-arrow-return-left" style="color:var(--outline);font-size:0.75rem;opacity:0.5;"></i>
                    </a>`).join('');
            }

            focusIndex = -1;
            searchDropdown.classList.add('show');
        }

        function closeDropdown() {
            searchDropdown.classList.remove('show');
            focusIndex = -1;
        }

        function moveFocus(dir) {
            const items = searchDropdown.querySelectorAll('.search-result-item');
            if (!items.length) return;
            items.forEach(el => el.classList.remove('focused'));
            focusIndex = (focusIndex + dir + items.length) % items.length;
            items[focusIndex]?.classList.add('focused');
            items[focusIndex]?.scrollIntoView({ block: 'nearest' });
        }

        if (searchInput) {
            searchInput.addEventListener('input', e => renderResults(e.target.value));
            searchInput.addEventListener('focus', () => { if (searchInput.value.trim()) renderResults(searchInput.value); });

            searchInput.addEventListener('keydown', e => {
                if (e.key === 'ArrowDown')  { e.preventDefault(); moveFocus(1); }
                if (e.key === 'ArrowUp')    { e.preventDefault(); moveFocus(-1); }
                if (e.key === 'Enter') {
                    const focused = searchDropdown.querySelector('.search-result-item.focused');
                    if (focused) { window.location.href = focused.href; }
                    else if (visibleItems[0]) { window.location.href = visibleItems[0].url; }
                }
                if (e.key === 'Escape') { closeDropdown(); searchInput.blur(); }
            });
        }

        // Close on outside click
        document.addEventListener('click', e => {
            if (!e.target.closest('#searchWrap')) closeDropdown();
        });

        // Ctrl+K shortcut
        document.addEventListener('keydown', e => {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                searchInput?.focus();
                searchInput?.select();
            }
        });
    });
    </script>

    @include('components.session-alert')
    @stack('scripts')

</body>
</html>
