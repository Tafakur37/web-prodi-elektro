<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') – SIMelek Mahasiswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <style>
    /* ================================================================
       THEME: LIGHT (default)
    ================================================================ */
    :root,
    [data-theme="light"] {
        --primary:              #000613;
        --primary-container:    #001f3f;
        --on-primary:           #ffffff;
        --secondary:            #0059bb;
        --secondary-container:  #0070ea;
        --on-secondary:         #ffffff;
        --background:           #f0f4fa;
        --surface:              #f0f4fa;
        --surface-container-lowest: #ffffff;
        --surface-container-low: #f3f4f5;
        --surface-container:    #edeeef;
        --surface-container-high: #e7e8e9;
        --surface-container-highest: #e1e3e4;
        --on-surface:           #191c1d;
        --on-surface-variant:   #43474e;
        --outline:              #74777f;
        --outline-variant:      #c4c6cf;
        --error:                #ba1a1a;
        --on-error:             #ffffff;
        --success:              #00a550;
        --success-light:        rgba(0,165,80,0.08);
        --danger:               #ba1a1a;
        --danger-light:         rgba(186,26,26,0.08);
        --warning:              #8a5f00;
        --warning-light:        rgba(138,95,0,0.1);
        --info:                 #0059bb;
        --info-light:           rgba(0,89,187,0.08);
        --purple:               #6750a4;
        --purple-light:         rgba(103,80,164,0.1);
        --cyan:                 #006876;
        --cyan-light:           rgba(0,104,118,0.08);
        --primary-light:        rgba(0,31,63,0.08);

        --sidebar-width:        256px;
        --sidebar-bg:           #001f3f;
        --sidebar-hover:        rgba(255,255,255,0.07);
        --sidebar-active:       rgba(0,112,234,0.25);
        --sidebar-active-border:#0070ea;
        --sidebar-text:         rgba(255,255,255,0.55);
        --sidebar-text-h:       rgba(255,255,255,0.85);
        --sidebar-text-a:       #ffffff;

        --body-bg:              #f0f4fa;
        --topbar-bg:            rgba(255,255,255,0.60);
        --card-bg:              #ffffff;
        --card-border:          #c4c6cf;
        --card-shadow:          0 1px 4px rgba(0,31,63,0.06), 0 2px 8px rgba(0,31,63,0.04);
        --card-glass-bg:        rgba(255,255,255,0.45);
        --card-glass-border:    rgba(255,255,255,0.60);

        --text-1:               #191c1d;
        --text-2:               #43474e;
        --text-3:               #74777f;
        --border:               #c4c6cf;

        --blob-1:               rgba(0,89,187,0.12);
        --blob-2:               rgba(0,112,234,0.09);
        --blob-3:               rgba(0,31,63,0.07);
        --topbar-border:        rgba(200,210,230,0.7);

        --font:                 'Plus Jakarta Sans', system-ui, sans-serif;
        --font-display:         'Plus Jakarta Sans', system-ui, sans-serif;
        --font-label:           'JetBrains Mono', monospace;
        --radius-sm:            6px;
        --radius-md:            10px;
        --radius-lg:            14px;
        --radius-xl:            18px;
        --transition:           0.22s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ================================================================
       THEME: DARK
    ================================================================ */
    [data-theme="dark"] {
        --primary:              #93beff;
        --primary-container:    #0d2954;
        --on-primary:           #002d6e;
        --secondary:            #68a3ff;
        --secondary-container:  #1a3a6b;
        --on-secondary:         #ffffff;
        --background:           #0d1117;
        --surface:              #0d1117;
        --surface-container-lowest: #161b22;
        --surface-container-low: #1c2333;
        --surface-container:    #21262d;
        --surface-container-high: #2d333b;
        --surface-container-highest: #373e47;
        --on-surface:           #e6edf3;
        --on-surface-variant:   #9198a1;
        --outline:              #6e7681;
        --outline-variant:      #30363d;
        --error:                #ff7b72;
        --on-error:             #ffffff;
        --success:              #3fb950;
        --success-light:        rgba(63,185,80,0.1);
        --danger:               #ff7b72;
        --danger-light:         rgba(255,123,114,0.1);
        --warning:              #e3b341;
        --warning-light:        rgba(227,179,65,0.1);
        --info:                 #68a3ff;
        --info-light:           rgba(104,163,255,0.1);
        --purple:               #bc8cff;
        --purple-light:         rgba(188,140,255,0.1);
        --cyan:                 #39c5cf;
        --cyan-light:           rgba(57,197,207,0.1);
        --primary-light:        rgba(104,163,255,0.12);

        --sidebar-width:        256px;
        --sidebar-bg:           #10162a;
        --sidebar-hover:        rgba(255,255,255,0.05);
        --sidebar-active:       rgba(104,163,255,0.18);
        --sidebar-active-border:#68a3ff;
        --sidebar-text:         rgba(255,255,255,0.42);
        --sidebar-text-h:       rgba(255,255,255,0.80);
        --sidebar-text-a:       #e6edf3;

        --body-bg:              #0d1117;
        --topbar-bg:            rgba(13,17,23,0.65);
        --card-bg:              #161b22;
        --card-border:          #30363d;
        --card-shadow:          0 1px 4px rgba(0,0,0,0.4), 0 2px 8px rgba(0,0,0,0.25);
        --card-glass-bg:        rgba(14,20,38,0.50);
        --card-glass-border:    rgba(104,163,255,0.14);

        --text-1:               #e6edf3;
        --text-2:               #9198a1;
        --text-3:               #6e7681;
        --border:               #30363d;

        --blob-1:               rgba(104,163,255,0.06);
        --blob-2:               rgba(68,163,255,0.04);
        --blob-3:               rgba(13,41,84,0.08);
        --topbar-border:        rgba(48,54,61,0.9);
    }

    /* ================================================================
       RESET & BASE
    ================================================================ */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }

    body {
        background-color: var(--body-bg);
        color: var(--on-surface);
        font-family: var(--font);
        overflow-x: hidden;
        min-height: 100vh;
        position: relative;
        transition: background-color 0.35s ease, color 0.35s ease;
    }

    /* Background ambient blobs */
    body::before {
        content: '';
        position: fixed;
        inset: 0;
        z-index: 0;
        pointer-events: none;
        background:
            radial-gradient(ellipse 80% 60% at 15% 10%, var(--blob-1) 0%, transparent 60%),
            radial-gradient(ellipse 60% 50% at 85% 20%, var(--blob-2) 0%, transparent 55%),
            radial-gradient(ellipse 70% 60% at 50% 85%, var(--blob-3) 0%, transparent 60%);
        transition: background 0.4s ease;
    }

    /* ── GRID DOT PATTERN — fixed background layer ─────────────── */
    body::after {
        content: '';
        position: fixed;
        inset: 0;
        z-index: 0;
        pointer-events: none;

        /* Light mode: subtle blue grid */
        background-image:
            linear-gradient(rgba(0,89,187,0.055) 1px, transparent 1px),
            linear-gradient(90deg, rgba(0,89,187,0.055) 1px, transparent 1px);
        background-size: 32px 32px;
        background-position: center center;
        transition: background 0.4s ease;

        /* Fade out toward edges so it doesn't look harsh */
        -webkit-mask-image: radial-gradient(ellipse 100% 100% at 50% 50%,
            rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.55) 40%, transparent 80%);
        mask-image: radial-gradient(ellipse 100% 100% at 50% 50%,
            rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.55) 40%, transparent 80%);
    }

    [data-theme="dark"] body::after {
        background-image:
            linear-gradient(rgba(104,163,255,0.07) 1px, transparent 1px),
            linear-gradient(90deg, rgba(104,163,255,0.07) 1px, transparent 1px);
        background-size: 32px 32px;
        -webkit-mask-image: radial-gradient(ellipse 100% 100% at 50% 50%,
            rgba(0,0,0,0.65) 0%, rgba(0,0,0,0.5) 40%, transparent 80%);
        mask-image: radial-gradient(ellipse 100% 100% at 50% 50%,
            rgba(0,0,0,0.65) 0%, rgba(0,0,0,0.5) 40%, transparent 80%);
    }

    .mhs-main { position: relative; z-index: 1; }

    ::-webkit-scrollbar { width: 5px; height: 5px; }
    ::-webkit-scrollbar-track { background: var(--surface-container-low); }
    ::-webkit-scrollbar-thumb { background: rgba(0,89,187,0.22); border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: var(--secondary); }

    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        vertical-align: middle;
    }

    /* ================================================================
       THEME TRANSITION — smooth for all properties
    ================================================================ */
    body, .mhs-sidebar, .mhs-topbar, .mhs-card, .mhs-page,
    .clock-widget, .mhs-input, .mhs-btn, .mhs-table,
    .mhs-modal .modal-content, .search-dropdown {
        transition: background-color 0.35s ease, border-color 0.35s ease,
                    color 0.35s ease, box-shadow 0.35s ease;
    }

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
        border-right: 1px solid rgba(255,255,255,0.05);
        transition: transform var(--transition), background-color 0.35s ease;
        will-change: transform;
    }

    /* Sidebar inner gradient accent */
    .mhs-sidebar::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, #0070ea, #005bb5, #0070ea);
        background-size: 200% 100%;
        animation: shimmer-bar 3s linear infinite;
    }

    @keyframes shimmer-bar {
        0%   { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    /* Brand */
    .mhs-brand {
        padding: 18px 16px 16px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        flex-shrink: 0;
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .mhs-brand-logo {
        width: 40px; height: 40px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        box-shadow: 0 0 0 2px rgba(255,255,255,0.12);
    }

    .mhs-brand-text { line-height: 1.25; overflow: hidden; }
    .mhs-brand-text .t1 {
        font-family: var(--font-display);
        font-size: 0.76rem;
        font-weight: 800;
        color: #fff;
        letter-spacing: 0.3px;
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .mhs-brand-text .t2 {
        font-family: var(--font-label);
        font-size: 0.56rem;
        font-weight: 500;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: rgba(175,200,240,0.85);
        display: block;
    }

    /* User mini */
    .mhs-user-mini {
        padding: 10px 14px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    .mhs-avatar {
        width: 32px; height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0059bb, #0070ea);
        display: flex; align-items: center; justify-content: center;
        font-family: var(--font-display);
        font-size: 0.82rem;
        color: #fff;
        font-weight: 700;
        flex-shrink: 0;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,112,234,0.35);
    }

    .mhs-avatar img { width: 100%; height: 100%; object-fit: cover; }

    .mhs-user-info .uname {
        font-size: 0.76rem;
        font-weight: 600;
        color: rgba(255,255,255,0.88);
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 155px;
    }

    .mhs-user-info .urole {
        font-family: var(--font-label);
        font-size: 0.56rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: rgba(104,163,255,0.85);
    }

    /* Nav */
    .mhs-nav {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 6px 0 12px;
    }

    .mhs-nav::-webkit-scrollbar { width: 3px; }
    .mhs-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.08); }

    .mhs-nav-section-label {
        font-family: var(--font-label);
        font-size: 0.54rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.16em;
        color: rgba(255,255,255,0.22);
        padding: 14px 18px 5px;
    }

    .mhs-nav-link {
        display: flex;
        align-items: center;
        padding: 7px 10px;
        margin: 1px 8px;
        color: var(--sidebar-text);
        text-decoration: none;
        font-size: 0.83rem;
        font-weight: 500;
        border-radius: 9px;
        transition: all 0.17s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    /* Ripple on nav click */
    .mhs-nav-link::before {
        content: '';
        position: absolute;
        inset: 0;
        background: transparent;
        border-radius: 9px;
        transition: background 0.17s;
    }

    .mhs-nav-link:hover { color: var(--sidebar-text-h); background: var(--sidebar-hover); }
    .mhs-nav-link:hover::before { background: rgba(255,255,255,0.04); }

    .mhs-nav-link.active {
        background: var(--sidebar-active);
        color: var(--sidebar-text-a);
        font-weight: 600;
    }

    .mhs-nav-link.active::after {
        content: '';
        position: absolute;
        left: 0; top: 20%; bottom: 20%;
        width: 3px;
        background: var(--sidebar-active-border);
        border-radius: 0 3px 3px 0;
    }

    .mhs-nav-icon {
        width: 28px; height: 28px; min-width: 28px;
        margin-right: 9px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.96rem;
        border-radius: 7px;
        background: transparent;
        opacity: 0.55;
        transition: all 0.17s;
        flex-shrink: 0;
    }

    .mhs-nav-link:hover .mhs-nav-icon { opacity: 0.9; }
    .mhs-nav-link.active .mhs-nav-icon { opacity: 1; background: rgba(0,112,234,0.22); }

    .mhs-nav-badge {
        margin-left: auto;
        background: var(--error);
        color: #fff;
        font-family: var(--font-label);
        font-size: 0.58rem;
        font-weight: 600;
        padding: 2px 6px;
        border-radius: 10px;
        min-width: 18px;
        text-align: center;
        animation: pulse-badge 2s infinite;
    }

    @keyframes pulse-badge {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    /* Sidebar footer */
    .mhs-sidebar-footer {
        border-top: 1px solid rgba(255,255,255,0.05);
        padding: 8px 8px 10px;
        flex-shrink: 0;
    }

    .mhs-logout-btn {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 8px 10px;
        color: rgba(255,255,255,0.32);
        font-size: 0.82rem;
        font-weight: 500;
        cursor: pointer;
        border-radius: 8px;
        border: 1px solid transparent;
        background: transparent;
        width: 100%;
        text-align: left;
        transition: all 0.17s;
    }

    .mhs-logout-btn:hover {
        background: rgba(186,26,26,0.12);
        border-color: rgba(186,26,26,0.2);
        color: #ff8a80;
    }

    /* ================================================================
       CLOCK WIDGET
    ================================================================ */
    .clock-widget {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 950;
        background: var(--sidebar-bg);
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 14px;
        padding: 10px 18px 10px 14px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 8px 28px rgba(0,0,0,0.25), 0 0 0 1px rgba(255,255,255,0.03) inset;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        min-width: 180px;
        animation: clock-in 0.55s cubic-bezier(0.22,1,0.36,1) both;
        cursor: default;
        user-select: none;
    }

    @keyframes clock-in {
        from { opacity: 0; transform: translateY(16px) scale(0.94); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    .clock-widget-icon {
        width: 34px; height: 34px;
        flex-shrink: 0;
        background: rgba(0,112,234,0.2);
        border: 1px solid rgba(0,112,234,0.3);
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        color: rgba(175,200,240,0.9);
        font-size: 0.95rem;
    }

    .clock-widget-body { line-height: 1; }

    .clock-widget-time {
        font-family: var(--font-display);
        font-size: 1.2rem;
        font-weight: 800;
        color: #fff;
        letter-spacing: 0.04em;
        display: block;
        margin-bottom: 3px;
        font-variant-numeric: tabular-nums;
    }

    .clock-widget-date {
        font-family: var(--font-label);
        font-size: 0.56rem;
        color: rgba(255,255,255,0.32);
        letter-spacing: 0.07em;
        text-transform: uppercase;
        display: block;
    }

    /* ================================================================
       TOPBAR SEARCH
    ================================================================ */
    .topbar-search-wrap {
        position: relative;
        flex: 1;
        max-width: 400px;
        margin: 0 14px;
    }

    .topbar-search-input {
        width: 100%;
        height: 37px;
        padding: 0 13px 0 36px;
        background: var(--surface-container-low);
        border: 1.5px solid var(--outline-variant);
        border-radius: 10px;
        font-family: var(--font);
        font-size: 0.82rem;
        color: var(--on-surface);
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    }

    .topbar-search-input::placeholder { color: var(--outline); }

    .topbar-search-input:focus {
        background: var(--surface-container-lowest);
        border-color: var(--secondary);
        box-shadow: 0 0 0 3px rgba(0,89,187,0.12);
    }

    [data-theme="dark"] .topbar-search-input:focus {
        box-shadow: 0 0 0 3px rgba(104,163,255,0.15);
    }

    .topbar-search-icon {
        position: absolute;
        left: 11px; top: 50%;
        transform: translateY(-50%);
        color: var(--outline);
        font-size: 0.88rem;
        pointer-events: none;
        transition: color 0.2s;
    }

    .topbar-search-wrap:focus-within .topbar-search-icon { color: var(--secondary); }

    .search-dropdown {
        position: absolute;
        top: calc(100% + 6px);
        left: 0; right: 0;
        background: var(--surface-container-lowest);
        border: 1.5px solid var(--outline-variant);
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.14);
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
        gap: 11px;
        padding: 10px 13px;
        text-decoration: none;
        color: var(--on-surface);
        font-size: 0.83rem;
        border-bottom: 1px solid var(--surface-container-low);
        transition: background 0.12s;
        cursor: pointer;
    }

    .search-result-item:last-child { border-bottom: none; }
    .search-result-item:hover, .search-result-item.focused {
        background: var(--info-light);
        color: var(--secondary);
    }

    .search-result-icon {
        width: 29px; height: 29px; flex-shrink: 0;
        background: var(--info-light);
        border-radius: 7px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.84rem;
        color: var(--secondary);
    }

    .search-result-text { flex: 1; min-width: 0; }
    .search-result-name { font-weight: 600; display: block; }
    .search-result-section {
        font-family: var(--font-label);
        font-size: 0.6rem;
        color: var(--outline);
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .search-highlight { color: var(--secondary); font-weight: 700; }

    .search-empty {
        padding: 20px 16px;
        text-align: center;
        font-size: 0.82rem;
        color: var(--outline);
    }

    @media (max-width: 767px) { .topbar-search-wrap { display: none; } }

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
        background: var(--topbar-bg);
        backdrop-filter: blur(20px) saturate(160%);
        -webkit-backdrop-filter: blur(20px) saturate(160%);
        border-bottom: 1px solid var(--topbar-border);
        box-shadow: 0 1px 12px rgba(0,0,0,0.06);
        padding: 0 24px;
        height: 62px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        transition: background-color 0.35s ease, border-color 0.35s ease;
    }

    .mhs-breadcrumb {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.79rem;
        color: var(--on-surface-variant);
    }

    .mhs-breadcrumb a {
        color: var(--on-surface-variant);
        text-decoration: none;
        transition: color 0.15s;
    }

    .mhs-breadcrumb a:hover { color: var(--secondary); }
    .mhs-breadcrumb .sep { opacity: 0.35; font-size: 0.58rem; }
    .mhs-breadcrumb .current { color: var(--on-surface); font-weight: 600; }

    .mhs-topbar-actions { display: flex; align-items: center; gap: 6px; }

    /* Notification bell */
    .notif-btn {
        width: 36px; height: 36px;
        border-radius: 50%;
        background: transparent;
        border: none;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        color: var(--on-surface-variant);
        font-size: 1rem;
        position: relative;
        transition: all 0.17s;
    }

    .notif-btn:hover { color: var(--secondary); background: var(--info-light); }

    .notif-dot {
        position: absolute;
        top: 6px; right: 6px;
        width: 7px; height: 7px;
        border-radius: 50%;
        background: var(--error);
        border: 1.5px solid var(--topbar-bg);
        animation: notif-pulse 2s infinite;
    }

    @keyframes notif-pulse {
        0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(186,26,26,0.4); }
        50% { transform: scale(1.1); box-shadow: 0 0 0 4px rgba(186,26,26,0); }
    }

    /* Dark mode toggle button */
    .theme-toggle-btn {
        width: 36px; height: 36px;
        border-radius: 50%;
        background: transparent;
        border: none;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        color: var(--on-surface-variant);
        font-size: 1rem;
        transition: all 0.17s;
        position: relative;
        overflow: hidden;
    }

    .theme-toggle-btn:hover { color: var(--secondary); background: var(--info-light); }

    .theme-toggle-btn .icon-sun,
    .theme-toggle-btn .icon-moon {
        position: absolute;
        transition: transform 0.38s cubic-bezier(0.34,1.56,0.64,1), opacity 0.3s ease;
    }

    [data-theme="light"] .theme-toggle-btn .icon-sun  { opacity: 1; transform: scale(1) rotate(0deg); }
    [data-theme="light"] .theme-toggle-btn .icon-moon { opacity: 0; transform: scale(0) rotate(90deg); }
    [data-theme="dark"]  .theme-toggle-btn .icon-sun  { opacity: 0; transform: scale(0) rotate(-90deg); }
    [data-theme="dark"]  .theme-toggle-btn .icon-moon { opacity: 1; transform: scale(1) rotate(0deg); }

    /* Topbar user pill */
    .topbar-user {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 4px 10px 4px 4px;
        background: transparent;
        border: none;
        border-radius: 100px;
        cursor: default;
        transition: background 0.17s;
    }

    .topbar-user:hover { background: var(--surface-container-low); }

    .topbar-avatar {
        width: 32px; height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0059bb, #0070ea);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.76rem;
        color: #fff;
        font-weight: 700;
        flex-shrink: 0;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,89,187,0.28);
    }

    .topbar-avatar img { width: 100%; height: 100%; object-fit: cover; }

    .topbar-user-name {
        font-size: 0.79rem;
        font-weight: 600;
        color: var(--on-surface);
        white-space: nowrap;
    }

    .topbar-user-role {
        font-family: var(--font-label);
        font-size: 0.58rem;
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

    .mhs-sidebar-toggle:hover { border-color: var(--secondary); color: var(--secondary); }

    /* Overlay */
    .mhs-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.45);
        z-index: 1035;
        backdrop-filter: blur(3px);
    }

    /* ================================================================
       PAGE CONTENT
    ================================================================ */
    .mhs-page {
        flex: 1;
        padding: 22px 26px 40px;
    }

    /* Page entrance animation - stagger children */
    .mhs-page > *:not(script) {
        animation: fadeInUp 0.35s cubic-bezier(0.22,1,0.36,1) both;
    }

    .mhs-page > *:nth-child(1) { animation-delay: 0.04s; }
    .mhs-page > *:nth-child(2) { animation-delay: 0.08s; }
    .mhs-page > *:nth-child(3) { animation-delay: 0.12s; }
    .mhs-page > *:nth-child(4) { animation-delay: 0.16s; }
    .mhs-page > *:nth-child(5) { animation-delay: 0.20s; }
    .mhs-page > *:nth-child(n+6) { animation-delay: 0.22s; }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-10px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* Flash messages */
    .mhs-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 11px 15px;
        border-radius: var(--radius-sm);
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 18px;
        border: 1px solid;
        animation: fadeInDown 0.3s ease;
    }

    .mhs-alert.success { background: var(--success-light); border-color: rgba(0,165,80,0.25); color: var(--success); }
    .mhs-alert.danger  { background: var(--danger-light);  border-color: rgba(186,26,26,0.25); color: var(--danger); }
    .mhs-alert.warning { background: var(--warning-light); border-color: rgba(138,95,0,0.25);  color: var(--warning); }

    /* ================================================================
       SHARED COMPONENTS — CARDS
    ================================================================ */
    .mhs-card {
        background: var(--card-glass-bg);
        backdrop-filter: blur(28px) saturate(180%);
        -webkit-backdrop-filter: blur(28px) saturate(180%);
        border: 1px solid var(--card-glass-border);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow:
            0 4px 20px rgba(0,0,0,0.07),
            0 1px 6px rgba(0,0,0,0.04),
            inset 0 1px 0 rgba(255,255,255,0.5);
        transition: box-shadow 0.25s ease, transform 0.25s ease,
                    background 0.35s ease, backdrop-filter 0.35s ease;
        position: relative;
    }

    [data-theme="dark"] .mhs-card {
        box-shadow: 0 4px 20px rgba(0,0,0,0.35), 0 1px 6px rgba(0,0,0,0.20),
            inset 0 1px 0 rgba(255,255,255,0.05);
    }

    .mhs-card:hover {
        background: var(--card-glass-bg);
        backdrop-filter: blur(36px) saturate(200%);
        -webkit-backdrop-filter: blur(36px) saturate(200%);
        box-shadow: 0 12px 36px rgba(0,0,0,0.11), 0 3px 10px rgba(0,0,0,0.07),
            inset 0 1px 0 rgba(255,255,255,0.65);
        transform: translateY(-2px);
    }

    [data-theme="dark"] .mhs-card:hover {
        box-shadow: 0 12px 36px rgba(0,0,0,0.45), 0 3px 10px rgba(0,0,0,0.25);
    }

    .mhs-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 18px;
        border-bottom: 1px solid var(--card-glass-border);
        background: rgba(255,255,255,0.22);
    }

    [data-theme="dark"] .mhs-card-header { background: rgba(255,255,255,0.03); }

    .mhs-card-title {
        display: flex;
        align-items: center;
        gap: 9px;
        font-family: var(--font-display);
        font-size: 0.86rem;
        font-weight: 700;
        color: var(--text-1);
        margin: 0;
    }

    .mhs-card-icon {
        width: 27px; height: 27px;
        border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.84rem;
        flex-shrink: 0;
    }

    .mhs-card-body { padding: 18px; }

    /* Glass card utility */
    .glass-card {
        background: var(--card-glass-bg);
        backdrop-filter: blur(40px) saturate(180%);
        -webkit-backdrop-filter: blur(40px) saturate(180%);
        border: 1px solid var(--card-glass-border);
        box-shadow: 0 6px 24px rgba(0,0,0,0.07), inset 0 1px 0 rgba(255,255,255,0.55);
    }

    /* Stat, cohort, filter cards */
    .stat-card, .cohort-card, .filter-card {
        background: var(--card-glass-bg) !important;
        backdrop-filter: blur(40px) saturate(180%) !important;
        -webkit-backdrop-filter: blur(40px) saturate(180%) !important;
        border: 1px solid var(--card-glass-border) !important;
        border-radius: var(--radius-lg);
        box-shadow: 0 6px 24px rgba(0,0,0,0.07), inset 0 1px 0 rgba(255,255,255,0.55);
        transition: all 0.25s ease;
    }

    .cohort-card:hover {
        box-shadow: 0 14px 40px rgba(0,89,187,0.13) !important;
        transform: translateY(-2px);
    }

    /* ================================================================
       BADGES
    ================================================================ */
    .mhs-badge {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        padding: 3px 9px;
        border-radius: 100px;
        font-family: var(--font-label);
        font-size: 0.63rem;
        font-weight: 500;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .mhs-badge.primary  { background: var(--info-light); color: var(--secondary); border: 1px solid rgba(0,89,187,0.2); }
    .mhs-badge.cyan     { background: var(--cyan-light); color: var(--cyan); border: 1px solid rgba(0,104,118,0.2); }
    .mhs-badge.success  { background: var(--success-light); color: var(--success); border: 1px solid rgba(0,165,80,0.2); }
    .mhs-badge.danger   { background: var(--danger-light); color: var(--danger); border: 1px solid rgba(186,26,26,0.2); }
    .mhs-badge.warning  { background: var(--warning-light); color: var(--warning); border: 1px solid rgba(138,95,0,0.2); }
    .mhs-badge.muted    { background: var(--surface-container); color: var(--on-surface-variant); border: 1px solid var(--outline-variant); }
    .mhs-badge.purple   { background: var(--purple-light); color: var(--purple); border: 1px solid rgba(103,80,164,0.2); }

    /* ================================================================
       TABLES
    ================================================================ */
    .mhs-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.84rem;
    }

    .mhs-table thead tr { background: rgba(255,255,255,0.25); }
    [data-theme="dark"] .mhs-table thead tr { background: rgba(255,255,255,0.03); }

    .mhs-table th {
        padding: 9px 13px;
        text-align: left;
        font-family: var(--font-label);
        font-size: 0.6rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--on-surface-variant);
        border-bottom: 1px solid var(--card-glass-border);
        white-space: nowrap;
    }

    .mhs-table td {
        padding: 11px 13px;
        border-bottom: 1px solid rgba(0,0,0,0.04);
        color: var(--on-surface);
        vertical-align: middle;
    }

    [data-theme="dark"] .mhs-table td { border-bottom: 1px solid var(--surface-container-high); }

    .mhs-table tbody tr:last-child td { border-bottom: none; }

    .mhs-table tbody tr {
        transition: background 0.15s ease;
    }

    .mhs-table tbody tr:hover { background: var(--info-light); }

    /* ================================================================
       FORM CONTROLS
    ================================================================ */
    .mhs-input {
        width: 100%;
        padding: 9px 12px;
        background: var(--surface-container-lowest);
        border: 1px solid var(--outline-variant);
        border-radius: var(--radius-sm);
        font-family: var(--font);
        font-size: 0.875rem;
        color: var(--on-surface);
        transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        outline: none;
    }

    .mhs-input::placeholder { color: var(--outline); }

    .mhs-input:focus {
        border-color: var(--secondary);
        box-shadow: 0 0 0 3px rgba(0,89,187,0.12);
        background: var(--surface-container-lowest);
    }

    select.mhs-input {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%2343474e' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 11px;
        padding-right: 30px;
    }

    textarea.mhs-input { resize: vertical; min-height: 88px; }

    .mhs-label {
        display: block;
        font-family: var(--font-label);
        font-size: 0.66rem;
        font-weight: 500;
        color: var(--on-surface-variant);
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 5px;
    }

    .mhs-form-group { margin-bottom: 15px; }
    .mhs-form-group:last-child { margin-bottom: 0; }
    .mhs-hint { font-family: var(--font-label); font-size: 0.66rem; color: var(--outline); margin-top: 4px; }

    /* ================================================================
       BUTTONS — with ripple & hover effects
    ================================================================ */
    .mhs-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 18px;
        border-radius: var(--radius-sm);
        font-family: var(--font);
        font-size: 0.83rem;
        font-weight: 600;
        cursor: pointer;
        border: 1px solid transparent;
        transition: all 0.2s cubic-bezier(0.4,0,0.2,1);
        text-decoration: none;
        white-space: nowrap;
        position: relative;
        overflow: hidden;
    }

    /* Ripple effect on buttons */
    .mhs-btn::after {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(255,255,255,0);
        transition: background 0.3s ease;
        pointer-events: none;
    }

    .mhs-btn:active::after { background: rgba(255,255,255,0.15); }

    .mhs-btn-primary {
        background: var(--primary-container);
        color: #fff;
        border-color: transparent;
        box-shadow: 0 2px 8px rgba(0,31,63,0.22);
    }

    .mhs-btn-primary:hover {
        background: var(--primary);
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(0,31,63,0.28);
        color: #fff;
    }

    [data-theme="dark"] .mhs-btn-primary {
        background: var(--secondary-container);
        box-shadow: 0 2px 8px rgba(0,0,0,0.35);
    }

    .mhs-btn-ghost {
        background: transparent;
        color: var(--on-surface-variant);
        border-color: var(--outline-variant);
    }

    .mhs-btn-ghost:hover {
        border-color: var(--secondary);
        color: var(--secondary);
        background: var(--info-light);
    }

    .mhs-btn-success {
        background: var(--success-light);
        color: var(--success);
        border-color: rgba(0,165,80,0.25);
    }

    .mhs-btn-success:hover { background: var(--success); color: #fff; border-color: var(--success); }

    .mhs-btn-danger {
        background: var(--danger-light);
        color: var(--danger);
        border-color: rgba(186,26,26,0.25);
    }

    .mhs-btn-danger:hover { background: var(--danger); color: #fff; }

    .mhs-btn-sm { padding: 5px 13px; font-size: 0.77rem; }
    .mhs-btn-full { width: 100%; justify-content: center; }

    /* Section label */
    .mhs-section-label {
        font-family: var(--font-label);
        font-size: 0.6rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: var(--on-surface-variant);
        margin-bottom: 10px;
    }

    /* Empty state */
    .mhs-empty {
        text-align: center;
        padding: 30px 20px;
        color: var(--outline);
    }

    .mhs-empty i {
        font-size: 2rem;
        display: block;
        margin-bottom: 10px;
        opacity: 0.5;
    }

    .mhs-empty p { font-size: 0.87rem; margin: 0; }

    /* ================================================================
       MODALS
    ================================================================ */
    .mhs-modal .modal-content {
        background: var(--surface-container-lowest);
        border: 1px solid var(--outline-variant);
        border-radius: var(--radius-lg);
        box-shadow: 0 25px 60px rgba(0,0,0,0.18);
        color: var(--on-surface);
    }

    .mhs-modal .modal-header {
        padding: 18px 22px;
        border-bottom: 1px solid var(--outline-variant);
        background: var(--surface-container-low);
        border-radius: var(--radius-lg) var(--radius-lg) 0 0;
    }

    .mhs-modal .modal-title {
        font-family: var(--font-display);
        font-size: 0.98rem;
        font-weight: 700;
        color: var(--text-1);
    }

    .mhs-modal .modal-body { padding: 18px 22px; }
    .mhs-modal .modal-footer {
        padding: 13px 22px;
        border-top: 1px solid var(--outline-variant);
        background: var(--surface-container-low);
        border-radius: 0 0 var(--radius-lg) var(--radius-lg);
        gap: 8px;
    }

    /* ================================================================
       BOOTSTRAP OVERRIDES — respect dark theme
    ================================================================ */
    .mhs-page h1, .mhs-page h2, .mhs-page h3 {
        font-family: var(--font-display);
        color: var(--text-1);
    }

    .card.bg-dark {
        background-color: var(--surface-container-lowest) !important;
        border: 1px solid var(--outline-variant) !important;
    }

    .card.bg-dark * { color: var(--on-surface) !important; }

    .table-dark {
        --bs-table-bg: var(--surface-container-lowest) !important;
        --bs-table-color: var(--on-surface) !important;
        color: var(--on-surface) !important;
        background-color: var(--surface-container-lowest) !important;
    }

    .table-dark thead th, .table-dark th {
        background-color: var(--surface-container-low) !important;
        color: var(--on-surface-variant) !important;
        border-color: var(--outline-variant) !important;
    }

    .form-control-dark, .form-select-dark,
    .form-control.bg-dark, .form-select.bg-dark {
        background-color: var(--surface-container-low) !important;
        border: 1px solid var(--outline-variant) !important;
        color: var(--on-surface) !important;
    }

    .form-control-dark:focus, .form-select.bg-dark:focus {
        background-color: var(--surface-container-lowest) !important;
        border-color: var(--secondary) !important;
        color: var(--on-surface) !important;
        box-shadow: 0 0 0 3px rgba(0,89,187,0.12) !important;
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

    .input-group-text.bg-dark, .input-group-text.bg-transparent {
        background-color: var(--surface-container-low) !important;
        border-color: var(--outline-variant) !important;
        color: var(--on-surface-variant) !important;
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

    .main-content .text-white:not(.btn):not(.badge):not(.mhs-sidebar *) {
        color: var(--on-surface) !important;
    }

    /* Mat accordion dark */
    .mat-accordion-item {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
    }

    .mat-accordion-header.open { background: var(--info-light); }

    /* Form select dark option */
    .form-select.bg-dark option { background-color: var(--surface-container-low); color: var(--on-surface); }
    select.mhs-input option { background-color: var(--surface-container-lowest); color: var(--on-surface); }

    /* ================================================================
       GLASSMORPHISM PANEL
    ================================================================ */
    .glass-panel {
        background: var(--card-glass-bg) !important;
        backdrop-filter: blur(20px) saturate(160%) !important;
        -webkit-backdrop-filter: blur(20px) saturate(160%) !important;
        border: 1px solid var(--card-glass-border) !important;
        box-shadow:
            0 8px 32px rgba(0,0,0,0.08),
            inset 0 1px 0 rgba(255,255,255,0.55) !important;
    }

    [data-theme="dark"] .glass-panel {
        box-shadow: 0 8px 32px rgba(0,0,0,0.28),
            inset 0 1px 0 rgba(255,255,255,0.04) !important;
    }

    /* ================================================================
       GRID PATTERN (aksen kotak-kotak di background card)
    ================================================================ */
    .grid-pattern {
        position: relative;
        overflow: hidden;
    }

    .grid-pattern::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(var(--grid-line-color, rgba(0,89,187,0.04)) 1px, transparent 1px),
            linear-gradient(90deg, var(--grid-line-color, rgba(0,89,187,0.04)) 1px, transparent 1px);
        background-size: 28px 28px;
        pointer-events: none;
        z-index: 0;
    }

    [data-theme="dark"] .grid-pattern::before {
        background-image:
            linear-gradient(rgba(104,163,255,0.05) 1px, transparent 1px),
            linear-gradient(90deg, rgba(104,163,255,0.05) 1px, transparent 1px);
    }

    .grid-pattern > * { position: relative; z-index: 1; }

    /* ================================================================
       CUSTOM MODAL ENGINE (global — used by all pages)
    ================================================================ */
    .dash-modal-overlay {
        position: fixed;
        inset: 0;
        z-index: 1055;
        background: rgba(0,0,0,0.55);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.25s ease, visibility 0.25s ease;
    }

    .dash-modal-overlay.open {
        opacity: 1;
        visibility: visible;
    }

    .dash-modal-box {
        background: var(--surface-container-lowest);
        border: 1px solid var(--outline-variant);
        border-radius: var(--radius-xl);
        box-shadow:
            0 32px 80px rgba(0,0,0,0.22),
            0 8px 24px rgba(0,0,0,0.12),
            inset 0 1px 0 rgba(255,255,255,0.06);
        width: 100%;
        max-width: 520px;
        max-height: 90vh;
        overflow-y: auto;
        transform: scale(0.94) translateY(16px);
        transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1);
        color: var(--on-surface);
    }

    .dash-modal-overlay.open .dash-modal-box {
        transform: scale(1) translateY(0);
    }

    .dash-modal-box.modal-lg { max-width: 680px; }

    .dash-modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 22px;
        border-bottom: 1px solid var(--outline-variant);
        background: var(--surface-container-low);
        border-radius: var(--radius-xl) var(--radius-xl) 0 0;
        position: sticky;
        top: 0;
        z-index: 1;
    }

    .dash-modal-title {
        font-family: var(--font-display);
        font-size: 0.97rem;
        font-weight: 700;
        color: var(--text-1);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .dash-modal-close {
        width: 30px; height: 30px;
        border-radius: 50%;
        border: none;
        background: transparent;
        color: var(--outline);
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem;
        transition: all 0.15s;
        flex-shrink: 0;
    }

    .dash-modal-close:hover { background: var(--danger-light); color: var(--danger); }
    .dash-modal-body { padding: 20px 22px; }

    .dash-modal-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
        padding: 14px 22px;
        border-top: 1px solid var(--outline-variant);
        background: var(--surface-container-low);
        border-radius: 0 0 var(--radius-xl) var(--radius-xl);
    }

    /* ================================================================
       SKELETON LOADER
    ================================================================ */
    .skeleton {
        background: linear-gradient(90deg,
            var(--surface-container-high) 25%,
            var(--surface-container) 50%,
            var(--surface-container-high) 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
        border-radius: 6px;
    }

    @keyframes shimmer {
        0%   { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    /* ================================================================
       PAGE LOADER — thin progress bar at top
    ================================================================ */
    #page-loader {
        position: fixed;
        top: 0; left: 0;
        height: 3px;
        width: 0%;
        background: linear-gradient(90deg, var(--secondary), #0070ea, var(--secondary));
        background-size: 200% 100%;
        z-index: 9999;
        border-radius: 0 3px 3px 0;
        transition: width 0.3s ease;
        animation: loader-shimmer 1.2s linear infinite;
        pointer-events: none;
    }

    @keyframes loader-shimmer {
        0%   { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    /* ================================================================
       FLOATING ACTION HINT — Ctrl+K
    ================================================================ */
    .kbd-hint {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        padding: 2px 6px;
        border-radius: 4px;
        background: var(--surface-container);
        border: 1px solid var(--outline-variant);
        font-family: var(--font-label);
        font-size: 0.6rem;
        color: var(--outline);
    }

    /* ================================================================
       RESPONSIVE
    ================================================================ */
    @media (max-width: 991.98px) {
        .mhs-sidebar { transform: translateX(-100%); }
        .mhs-sidebar.show { transform: translateX(0); box-shadow: 8px 0 40px rgba(0,0,0,0.22); }
        .mhs-main { margin-left: 0; }
        .mhs-page { padding: 14px; }
        .mhs-topbar { padding: 0 14px; }
        .mhs-sidebar-toggle { display: flex; }
        .mhs-overlay.show { display: block; }
        .topbar-user .topbar-user-name, .topbar-user .topbar-user-role { display: none; }
        .clock-widget { right: 12px; bottom: 12px; }
    }

    @media (max-width: 575px) {
        .clock-widget { display: none; }
    }

    /* ================================================================
       SHORTCUT CARDS HOVER
    ================================================================ */
    .shortcut-btn:hover {
        background: var(--surface-container-lowest) !important;
        backdrop-filter: blur(12px);
        box-shadow: 0 4px 18px rgba(0,89,187,0.12) !important;
        transform: translateY(-3px);
    }

    </style>

    @stack('styles')
</head>

<body>
    <!-- Page progress loader -->
    <div id="page-loader"></div>

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
                <span class="t2">SIMelek · IDU</span>
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
                Pelanggaran
            </a>

            <div class="mhs-nav-section-label">Akun</div>

            <a href="{{ route('mahasiswa.profile.index') }}"
               class="mhs-nav-link {{ request()->routeIs('mahasiswa.profile.*') ? 'active' : '' }}">
                <span class="mhs-nav-icon"><i class="bi bi-person-gear"></i></span>
                Profil &amp; Akun
            </a>

        </nav>

        <!-- Footer: Logout -->
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

    <!-- Clock Widget -->
    <div class="clock-widget" id="clockWidget">
        <div class="clock-widget-icon">
            <i class="bi bi-clock"></i>
        </div>
        <div class="clock-widget-body">
            <span class="clock-widget-time" id="sidebarClock">00:00:00</span>
            <span class="clock-widget-date" id="sidebarDate"></span>
        </div>
    </div>

    <!-- MAIN -->
    <div class="mhs-main">

        <!-- Top Bar -->
        <header class="mhs-topbar">

            <div class="d-flex align-items-center gap-3">
                <button class="mhs-sidebar-toggle" id="mhsToggle" aria-label="Toggle sidebar">
                    <i class="bi bi-list"></i>
                </button>

                <nav class="mhs-breadcrumb">
                    <a href="{{ route('mahasiswa.dashboard') }}">Portal</a>
                    <span class="sep"><i class="bi bi-chevron-right" style="font-size:0.58rem;"></i></span>
                    <span class="current">@yield('title', 'Dashboard')</span>
                </nav>
            </div>

            <!-- Search Bar -->
            <div class="topbar-search-wrap" id="searchWrap">
                <i class="bi bi-search topbar-search-icon"></i>
                <input type="text" id="topbarSearch"
                    class="topbar-search-input"
                    placeholder="Cari menu atau halaman… (Ctrl+K)"
                    autocomplete="off"
                    aria-label="Cari menu">
                <div class="search-dropdown" id="searchDropdown"></div>
            </div>

            <div class="mhs-topbar-actions">

                <!-- Dark Mode Toggle -->
                <button class="theme-toggle-btn" id="themeToggle" title="Toggle mode gelap/terang" aria-label="Toggle tema">
                    <i class="bi bi-sun-fill icon-sun"></i>
                    <i class="bi bi-moon-stars-fill icon-moon"></i>
                </button>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    // ── Apply saved theme BEFORE paint to avoid flash ──────────────
    (function() {
        var saved = localStorage.getItem('sim-theme') || 'light';
        document.documentElement.setAttribute('data-theme', saved);
    })();

    document.addEventListener('DOMContentLoaded', function () {

        // ── Page loader animation ───────────────────────────────────
        var loader = document.getElementById('page-loader');
        if (loader) {
            loader.style.width = '70%';
            setTimeout(function() {
                loader.style.width = '100%';
                setTimeout(function() { loader.style.opacity = '0'; }, 200);
            }, 300);
        }

        // ── Dark / Light Mode Toggle ────────────────────────────────
        var html   = document.documentElement;
        var toggle = document.getElementById('themeToggle');
        var currentTheme = localStorage.getItem('sim-theme') || 'light';
        html.setAttribute('data-theme', currentTheme);

        if (toggle) {
            toggle.addEventListener('click', function () {
                var next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
                html.setAttribute('data-theme', next);
                localStorage.setItem('sim-theme', next);

                // Animate body gently on switch
                document.body.style.transition = 'background-color 0.4s ease, color 0.4s ease';
            });
        }

        // ── Mobile sidebar ──────────────────────────────────────────
        var sidebar  = document.getElementById('mhsSidebar');
        var mhsToggle   = document.getElementById('mhsToggle');
        var overlay  = document.getElementById('mhsOverlay');

        if (mhsToggle) {
            mhsToggle.addEventListener('click', function() {
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

        // ── Live Clock ──────────────────────────────────────────────
        var clockEl = document.getElementById('sidebarClock');
        var dateEl  = document.getElementById('sidebarDate');
        var days    = ['MIN','SEN','SEL','RAB','KAM','JUM','SAB'];
        var months  = ['JAN','FEB','MAR','APR','MEI','JUN','JUL','AGS','SEP','OKT','NOV','DES'];
        var prevSec = -1;

        function tickClock() {
            var now = new Date();
            var hh  = String(now.getHours()).padStart(2, '0');
            var mm  = String(now.getMinutes()).padStart(2, '0');
            var ss  = String(now.getSeconds()).padStart(2, '0');
            if (now.getSeconds() !== prevSec) {
                if (clockEl) clockEl.textContent = hh + ':' + mm + ':' + ss;
                if (dateEl)  dateEl.textContent  = days[now.getDay()] + ', ' + now.getDate() + ' ' + months[now.getMonth()] + ' ' + now.getFullYear();
                prevSec = now.getSeconds();
            }
        }
        tickClock();
        setInterval(tickClock, 500);

        // ── Unread chat count ───────────────────────────────────────
        function updateUnreadChats() {
            fetch("{{ route('global.chats.unread-count') }}")
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    var badge = document.getElementById('sidebar-unread-chat-count');
                    if (badge) {
                        if (data.count > 0) {
                            badge.textContent = data.count;
                            badge.classList.remove('d-none');
                        } else {
                            badge.classList.add('d-none');
                        }
                    }
                    var dot = document.getElementById('notifDot');
                    if (dot) dot.classList.toggle('d-none', data.count === 0);
                })
                .catch(function() {});
        }
        setInterval(updateUnreadChats, 10000);
        updateUnreadChats();

        // ── Nav link ripple effect ──────────────────────────────────
        document.querySelectorAll('.mhs-nav-link').forEach(function(link) {
            link.addEventListener('click', function(e) {
                var ripple = document.createElement('span');
                ripple.style.cssText = 'position:absolute;border-radius:50%;background:rgba(255,255,255,0.18);pointer-events:none;transform:scale(0);animation:ripple-nav 0.5s ease;width:120px;height:120px;top:50%;left:50%;margin:-60px 0 0 -60px;';
                this.appendChild(ripple);
                setTimeout(function() { ripple.remove(); }, 500);
            });
        });

        // Insert keyframe for ripple
        if (!document.getElementById('ripple-style')) {
            var st = document.createElement('style');
            st.id = 'ripple-style';
            st.textContent = '@keyframes ripple-nav { to { transform: scale(2.5); opacity: 0; } }';
            document.head.appendChild(st);
        }

        // ── Strict tab session ──────────────────────────────────────
        @if(session('just_logged_in'))
            sessionStorage.setItem('sim_tab_active', '1');
        @else
            if (!sessionStorage.getItem('sim_tab_active')) {
                var f = document.createElement('form');
                f.method = 'POST';
                f.action = "{{ route('logout') }}";
                f.innerHTML = '@csrf';
                document.body.appendChild(f);
                f.submit();
            }
        @endif

        // ── Topbar Search Engine ────────────────────────────────────
        var MENU_ITEMS = [
            { name: 'Dashboard',            section: 'Utama',       icon: 'bi-grid-1x2',           url: '{{ route("mahasiswa.dashboard") }}' },
            { name: 'Riwayat Absensi',      section: 'Akademik',    icon: 'bi-calendar-check',     url: '{{ route("mahasiswa.attendances.index") }}' },
            { name: 'Absensi',              section: 'Akademik',    icon: 'bi-calendar-check',     url: '{{ route("mahasiswa.attendances.index") }}' },
            { name: 'Transkrip Nilai',      section: 'Akademik',    icon: 'bi-bar-chart-line',     url: '{{ route("mahasiswa.nilai.index") }}' },
            { name: 'Nilai',                section: 'Akademik',    icon: 'bi-bar-chart-line',     url: '{{ route("mahasiswa.nilai.index") }}' },
            { name: 'Bahan Ajar',           section: 'Akademik',    icon: 'bi-journal-text',       url: '{{ route("mahasiswa.materials.index") }}' },
            { name: 'Materi',               section: 'Akademik',    icon: 'bi-journal-text',       url: '{{ route("mahasiswa.materials.index") }}' },
            { name: 'Surat',                section: 'Akademik',    icon: 'bi-envelope-paper',     url: '{{ route("mahasiswa.submissions.index") }}' },
            { name: 'Pengajuan Surat',      section: 'Akademik',    icon: 'bi-envelope-paper',     url: '{{ route("mahasiswa.submissions.index") }}' },
            { name: 'Berkas',               section: 'Akademik',    icon: 'bi-folder2-open',       url: '{{ route("mahasiswa.berkas.index") }}' },
            { name: 'Dokumen',              section: 'Akademik',    icon: 'bi-folder2-open',       url: '{{ route("mahasiswa.berkas.index") }}' },
            { name: 'Chat',                 section: 'Komunikasi',  icon: 'bi-chat-dots',          url: '{{ route("mahasiswa.chats.index") }}' },
            { name: 'Pesan',                section: 'Komunikasi',  icon: 'bi-chat-dots',          url: '{{ route("mahasiswa.chats.index") }}' },
            { name: 'Daftar UKM',           section: 'Aktivitas',   icon: 'bi-people',             url: '{{ route("mahasiswa.ukms.index") }}' },
            { name: 'UKM',                  section: 'Aktivitas',   icon: 'bi-people',             url: '{{ route("mahasiswa.ukms.index") }}' },
            { name: 'Riwayat Pelanggaran',  section: 'Aktivitas',   icon: 'bi-exclamation-octagon',url: '{{ route("mahasiswa.violations.index") }}' },
            { name: 'Pelanggaran',          section: 'Aktivitas',   icon: 'bi-exclamation-octagon',url: '{{ route("mahasiswa.violations.index") }}' },
            { name: 'Profil & Akun',        section: 'Pengaturan',  icon: 'bi-person-gear',        url: '{{ route("mahasiswa.profile.index") }}' },
            { name: 'Profil',               section: 'Pengaturan',  icon: 'bi-person-gear',        url: '{{ route("mahasiswa.profile.index") }}' },
        ];

        var searchInput    = document.getElementById('topbarSearch');
        var searchDropdown = document.getElementById('searchDropdown');
        var focusIndex = -1;
        var visibleItems = [];

        function keywordMatch(item, query) {
            var tokens = query.trim().toLowerCase().split(/\s+/).filter(Boolean);
            var haystack = (item.name + ' ' + item.section).toLowerCase();
            return tokens.every(function(tok) { return haystack.includes(tok); });
        }

        function highlight(text, query) {
            var tokens = query.trim().split(/\s+/).filter(Boolean);
            var result = text;
            tokens.forEach(function(tok) {
                var re = new RegExp('(' + tok.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi');
                result = result.replace(re, '<span class="search-highlight">$1</span>');
            });
            return result;
        }

        function renderResults(query) {
            var q = query.trim();
            if (!q) { closeDropdown(); return; }
            var seen = new Set();
            visibleItems = MENU_ITEMS.filter(function(item) {
                if (seen.has(item.url)) return false;
                if (!keywordMatch(item, q)) return false;
                seen.add(item.url);
                return true;
            }).slice(0, 8);

            if (!visibleItems.length) {
                searchDropdown.innerHTML = '<div class="search-empty"><i class="bi bi-search me-2"></i>Tidak ada hasil untuk "<strong>' + q + '</strong>"</div>';
            } else {
                searchDropdown.innerHTML = visibleItems.map(function(item, i) {
                    return '<a href="' + item.url + '" class="search-result-item" data-idx="' + i + '">' +
                        '<div class="search-result-icon"><i class="bi ' + item.icon + '"></i></div>' +
                        '<div class="search-result-text">' +
                            '<span class="search-result-name">' + highlight(item.name, q) + '</span>' +
                            '<span class="search-result-section">' + item.section + '</span>' +
                        '</div>' +
                        '<i class="bi bi-arrow-return-left" style="color:var(--outline);font-size:0.73rem;opacity:0.45;"></i>' +
                    '</a>';
                }).join('');
            }
            focusIndex = -1;
            searchDropdown.classList.add('show');
        }

        function closeDropdown() { searchDropdown.classList.remove('show'); focusIndex = -1; }

        function moveFocus(dir) {
            var items = searchDropdown.querySelectorAll('.search-result-item');
            if (!items.length) return;
            items.forEach(function(el) { el.classList.remove('focused'); });
            focusIndex = (focusIndex + dir + items.length) % items.length;
            if (items[focusIndex]) {
                items[focusIndex].classList.add('focused');
                items[focusIndex].scrollIntoView({ block: 'nearest' });
            }
        }

        if (searchInput) {
            searchInput.addEventListener('input', function(e) { renderResults(e.target.value); });
            searchInput.addEventListener('focus', function() { if (searchInput.value.trim()) renderResults(searchInput.value); });
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowDown')  { e.preventDefault(); moveFocus(1); }
                if (e.key === 'ArrowUp')    { e.preventDefault(); moveFocus(-1); }
                if (e.key === 'Enter') {
                    var focused = searchDropdown.querySelector('.search-result-item.focused');
                    if (focused) { window.location.href = focused.href; }
                    else if (visibleItems[0]) { window.location.href = visibleItems[0].url; }
                }
                if (e.key === 'Escape') { closeDropdown(); searchInput.blur(); }
            });
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('#searchWrap')) closeDropdown();
        });

        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                if (searchInput) { searchInput.focus(); searchInput.select(); }
            }
        });

        // ── Animate mhs-cards on intersection ──────────────────────
        if (typeof IntersectionObserver !== 'undefined') {
            var io = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.style.animation = 'fadeInUp 0.4s cubic-bezier(0.22,1,0.36,1) both';
                        io.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.05 });

            document.querySelectorAll('.mhs-card').forEach(function(card) { io.observe(card); });
        }

    }); // end DOMContentLoaded

    // ── Global Custom Modal Engine ──────────────────────────────
    // Available on every page — use openDashModal('id') / closeDashModal('id')
    function openDashModal(id) {
        var overlay = document.getElementById(id);
        if (!overlay) return;
        overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
        // Close when clicking the backdrop (outside the box)
        overlay._outsideHandler = function(e) {
            if (e.target === overlay) closeDashModal(id);
        };
        overlay.addEventListener('click', overlay._outsideHandler);
    }

    function closeDashModal(id) {
        var overlay = document.getElementById(id);
        if (!overlay) return;
        overlay.classList.remove('open');
        document.body.style.overflow = '';
        if (overlay._outsideHandler) {
            overlay.removeEventListener('click', overlay._outsideHandler);
            overlay._outsideHandler = null;
        }
    }

    // Close any open custom modal with Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.dash-modal-overlay.open').forEach(function(m) {
                m.classList.remove('open');
            });
            document.body.style.overflow = '';
        }
    });
    </script>

    @include('components.session-alert')
    @stack('scripts')

</body>
</html>
