<!DOCTYPE html>
<html class="scroll-smooth" lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Program Studi Teknik Elektro Universitas Pertahanan RI - Mencetak lulusan unggul di bidang teknologi dan rekayasa pertahanan.">
    <title>Beranda – Teknik Elektro | Indonesia Defense University</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* ============================================================
           SENTINELS OF SILICON — Design System Variables
        ============================================================ */
        :root {
            /* Stitch Color Palette */
            --primary:           #000613;
            --primary-container: #001f3f;
            --on-primary:        #ffffff;
            --secondary:         #0059bb;
            --secondary-container: #0070ea;
            --tertiary:          #00070a;
            --tertiary-container: #002328;
            --background:        #f8f9fa;
            --surface:           #f8f9fa;
            --surface-container-low: #f3f4f5;
            --surface-container: #edeeef;
            --surface-container-high: #e7e8e9;
            --on-surface:        #191c1d;
            --on-surface-variant: #43474e;
            --outline:           #74777f;
            --outline-variant:   #c4c6cf;

            /* Fonts */
            --font-display:  'Montserrat', sans-serif;
            --font-body:     'Inter', sans-serif;
            --font-label:    'JetBrains Mono', monospace;

            /* Transitions */
            --transition: 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font-body);
            background-color: var(--background);
            color: var(--on-surface);
            overflow-x: hidden;
        }

        /* Circuit pattern background */
        body {
            background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg stroke='%230059bb' stroke-width='0.5' stroke-opacity='0.04'%3E%3Cpath d='M40 40c0-8.8 7.2-16 16-16s16 7.2 16 16-7.2 16-16 16-16-7.2-16-16zM0 0h80v80H0V0zm1 1v78h78V1H1zm39 39c0-5.5 4.5-10 10-10s10 4.5 10 10-4.5 10-10 10-10-4.5-10-10z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: var(--surface-container-low); }
        ::-webkit-scrollbar-thumb { background: var(--secondary); border-radius: 10px; }

        /* ============================================================
           GLASSMORPHISM UTILITY
        ============================================================ */
        .glass-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 20px 40px rgba(0, 31, 63, 0.08);
        }

        .glass-card-dark {
            background: rgba(0, 6, 19, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Material Symbols */
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }

        /* ============================================================
           NAVBAR
        ============================================================ */
        .custom-navbar {
            position: fixed;
            top: 0; left: 0;
            width: 100%;
            z-index: 9999;
            background: transparent;
            backdrop-filter: blur(0px);
            -webkit-backdrop-filter: blur(0px);
            border-bottom: 1px solid transparent;
            box-shadow: none;
            transition: background 0.45s cubic-bezier(0.4,0,0.2,1),
                        backdrop-filter 0.45s cubic-bezier(0.4,0,0.2,1),
                        -webkit-backdrop-filter 0.45s cubic-bezier(0.4,0,0.2,1),
                        border-color 0.45s cubic-bezier(0.4,0,0.2,1),
                        box-shadow 0.45s cubic-bezier(0.4,0,0.2,1);
        }

        .custom-navbar.scrolled {
            background: rgba(255, 255, 255, 0.72);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.45);
            box-shadow: 0 4px 32px rgba(0, 31, 63, 0.10), 0 1.5px 0 rgba(255,255,255,0.6) inset;
        }

        .navbar-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 64px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 32px;
        }

        .brand-logo {
            width: 44px; height: 44px;
            border-radius: 50%;
            border: 2px solid rgba(0, 89, 187, 0.2);
            box-shadow: 0 4px 12px rgba(0, 31, 63, 0.1);
            object-fit: cover;
            transition: var(--transition);
        }

        .brand-logo:hover {
            border-color: var(--secondary);
            transform: scale(1.05);
        }

        .brand-name {
            font-family: var(--font-display);
            font-size: 1rem;
            font-weight: 700;
            color: var(--primary-container);
            letter-spacing: -0.01em;
        }

        .brand-sub {
            font-family: var(--font-label);
            font-size: 0.65rem;
            font-weight: 500;
            color: var(--secondary);
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .nav-links { display: flex; align-items: center; gap: 32px; }

        .nav-link-custom {
            font-family: var(--font-body);
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--on-surface-variant);
            text-decoration: none;
            transition: color var(--transition), text-shadow var(--transition);
        }

        /* When navbar is transparent (top of page), darken text slightly */
        .custom-navbar:not(.scrolled) .nav-link-custom {
            color: var(--primary-container);
        }

        .custom-navbar:not(.scrolled) .brand-name {
            color: var(--primary-container);
        }

        .nav-link-custom:hover { color: var(--secondary); }

        .btn-nav-login {
            padding: 8px 20px;
            border: 1.5px solid rgba(0, 31, 63, 0.2);
            border-radius: 4px;
            color: var(--primary-container);
            font-family: var(--font-body);
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            background: transparent;
            transition: var(--transition);
        }

        .btn-nav-login:hover {
            background: rgba(0, 31, 63, 0.06);
            border-color: var(--primary-container);
            color: var(--primary-container);
        }

        .btn-nav-register {
            padding: 8px 20px;
            border-radius: 4px;
            color: var(--on-primary);
            font-family: var(--font-body);
            font-size: 0.875rem;
            font-weight: 700;
            text-decoration: none;
            background: var(--primary-container);
            border: none;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(0, 31, 63, 0.2);
        }

        .btn-nav-register:hover {
            background: var(--primary);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(0, 31, 63, 0.25);
            color: var(--on-primary);
        }

        .user-badge-nav {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            background: rgba(0, 89, 187, 0.08);
            border: 1px solid rgba(0, 89, 187, 0.2);
            border-radius: 4px;
            font-family: var(--font-label);
            font-size: 0.8rem;
            color: var(--secondary);
        }

        .btn-logout-nav {
            padding: 6px 16px;
            border-radius: 4px;
            font-family: var(--font-body);
            font-size: 0.8rem;
            font-weight: 600;
            background: rgba(186, 26, 26, 0.08);
            border: 1.5px solid rgba(186, 26, 26, 0.25);
            color: #ba1a1a;
            transition: var(--transition);
            cursor: pointer;
        }

        .btn-logout-nav:hover {
            background: rgba(186, 26, 26, 0.15);
            border-color: #ba1a1a;
        }

        /* Mobile toggle */
        .navbar-toggler-custom {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            color: var(--on-surface);
        }

        /* ============================================================
           HERO SECTION
        ============================================================ */
        .hero-section {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            overflow: hidden;
            padding-top: 80px;
        }

        .hero-section .hero-bg-orb {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }

        .hero-section .orb-1 {
            width: 600px; height: 600px;
            top: -100px; right: -100px;
            background: radial-gradient(circle, rgba(0, 89, 187, 0.07) 0%, transparent 70%);
            filter: blur(60px);
        }

        .hero-section .orb-2 {
            width: 400px; height: 400px;
            bottom: 0; left: -80px;
            background: radial-gradient(circle, rgba(0, 35, 40, 0.08) 0%, transparent 70%);
            filter: blur(50px);
        }

        .hero-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 80px 64px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 64px;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        /* Hero badge */
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            background: rgba(0, 89, 187, 0.08);
            border: 1px solid rgba(0, 89, 187, 0.2);
            border-radius: 100px;
            font-family: var(--font-label);
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--secondary);
            letter-spacing: 0.05em;
            margin-bottom: 24px;
        }

        .hero-badge .badge-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--secondary);
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(0.7); }
        }

        .hero-title {
            font-family: var(--font-display);
            font-size: clamp(2.8rem, 5vw, 3.5rem);
            font-weight: 700;
            line-height: 1.1;
            letter-spacing: -0.02em;
            color: var(--primary-container);
            margin-bottom: 24px;
        }

        .hero-title .accent {
            color: var(--secondary);
        }

        .hero-subtitle {
            font-family: var(--font-body);
            font-size: 1.125rem;
            line-height: 1.75;
            color: var(--on-surface-variant);
            margin-bottom: 40px;
            max-width: 480px;
        }

        .hero-cta-group { display: flex; gap: 16px; flex-wrap: wrap; }

        .btn-hero-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 28px;
            background: var(--primary-container);
            color: var(--on-primary);
            font-family: var(--font-body);
            font-weight: 700;
            font-size: 0.9rem;
            border-radius: 4px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 16px rgba(0, 31, 63, 0.2);
        }

        .btn-hero-primary:hover {
            background: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(0, 31, 63, 0.25);
            color: var(--on-primary);
        }

        .btn-hero-primary .btn-icon {
            transition: transform 0.2s;
        }

        .btn-hero-primary:hover .btn-icon {
            transform: translateX(4px);
        }

        .btn-hero-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 28px;
            background: transparent;
            color: var(--primary-container);
            font-family: var(--font-body);
            font-weight: 700;
            font-size: 0.9rem;
            border-radius: 4px;
            text-decoration: none;
            border: 2px solid var(--primary-container);
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-hero-secondary:hover {
            background: rgba(0, 31, 63, 0.06);
            color: var(--primary-container);
            transform: translateY(-2px);
        }

        /* Hero visual */
        .hero-visual {
            position: relative;
        }

        .hero-visual-orb {
            width: 100%;
            aspect-ratio: 1;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .hero-visual-orb::before {
            content: '';
            position: absolute;
            inset: 20px;
            border: 1px solid rgba(0, 89, 187, 0.15);
            border-radius: 50%;
        }

        .hero-visual-orb::after {
            content: '';
            position: absolute;
            inset: 48px;
            border: 1px solid rgba(0, 89, 187, 0.08);
            border-radius: 50%;
        }

        .hero-icon-main {
            font-size: 5rem;
            color: rgba(0, 89, 187, 0.2);
        }

        .hero-float-card {
            position: absolute;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-radius: 8px;
            min-width: 180px;
            animation: float-card 4s ease-in-out infinite;
        }

        .hero-float-card:nth-child(2) { animation-delay: -2s; }

        @keyframes float-card {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }

        .hero-float-card .fc-icon {
            width: 40px; height: 40px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            font-size: 1.1rem;
        }

        .hero-float-card .fc-label {
            font-family: var(--font-label);
            font-size: 0.7rem;
            color: var(--on-surface-variant);
            margin-bottom: 2px;
        }

        .hero-float-card .fc-val {
            font-family: var(--font-display);
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--primary-container);
        }

        /* ============================================================
           STATS SECTION
        ============================================================ */
        .stats-section {
            background: var(--primary-container);
            padding: 72px 0;
            position: relative;
            overflow: hidden;
        }

        .stats-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg stroke='%23afc8f0' stroke-width='0.5' stroke-opacity='0.06'%3E%3Cpath d='M40 40c0-8.8 7.2-16 16-16s16 7.2 16 16-7.2 16-16 16-16-7.2-16-16zM0 0h80v80H0V0zm1 1v78h78V1H1zm39 39c0-5.5 4.5-10 10-10s10 4.5 10 10-4.5 10-10 10-10-4.5-10-10z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .stats-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 64px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 32px;
            position: relative;
            z-index: 1;
        }

        .stat-card-new {
            text-align: center;
            padding: 32px 20px;
            border-radius: 8px;
            border: 1px solid rgba(255,255,255,0.08);
            background: rgba(255,255,255,0.04);
            transition: var(--transition);
        }

        .stat-card-new:hover {
            background: rgba(255,255,255,0.08);
            border-color: rgba(0, 218, 243, 0.2);
            transform: translateY(-4px);
        }

        .stat-card-new .stat-icon {
            font-size: 1.5rem;
            color: rgba(0, 218, 243, 0.7);
            margin-bottom: 12px;
            display: block;
        }

        .stat-card-new .stat-number {
            font-family: var(--font-display);
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--secondary-container);
            line-height: 1;
            margin-bottom: 8px;
        }

        .stat-card-new .stat-desc {
            font-family: var(--font-label);
            font-size: 0.7rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.55);
        }

        /* ============================================================
           SECTION COMMON
        ============================================================ */
        .section-eyebrow {
            font-family: var(--font-label);
            font-size: 0.7rem;
            font-weight: 500;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--secondary);
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .section-eyebrow::before, .section-eyebrow::after {
            content: '';
            display: block;
            width: 24px; height: 1px;
            background: var(--secondary);
            opacity: 0.5;
        }

        .section-heading {
            font-family: var(--font-display);
            font-size: clamp(1.75rem, 3.5vw, 2.25rem);
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--primary-container);
            line-height: 1.2;
            margin-bottom: 16px;
        }

        .section-heading .highlight {
            color: var(--secondary);
        }

        .section-desc {
            font-family: var(--font-body);
            font-size: 1rem;
            line-height: 1.8;
            color: var(--on-surface-variant);
        }

        /* ============================================================
           ABOUT SECTION (Accordion)
        ============================================================ */
        .about-section {
            padding: 100px 0;
            background: var(--background);
        }

        .about-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 64px;
        }

        .accord-wrap { margin-top: 56px; }

        .accord-item {
            margin-bottom: 8px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid var(--outline-variant);
            background: var(--surface);
            transition: var(--transition-slow);
        }

        .accord-item:hover {
            border-color: rgba(0, 89, 187, 0.3);
            box-shadow: 0 4px 16px rgba(0, 31, 63, 0.06);
        }

        .accord-item.open {
            border-color: rgba(0, 89, 187, 0.4);
            background: rgba(0, 89, 187, 0.02);
            box-shadow: 0 8px 32px rgba(0, 31, 63, 0.08);
        }

        .accord-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 22px 28px;
            cursor: pointer;
            user-select: none;
            gap: 16px;
        }

        .accord-num {
            font-family: var(--font-label);
            font-size: 0.7rem;
            font-weight: 500;
            color: var(--secondary);
            letter-spacing: 0.1em;
            min-width: 28px;
        }

        .accord-title {
            font-family: var(--font-display);
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-container);
            flex: 1;
        }

        .accord-icon {
            width: 32px; height: 32px;
            border-radius: 50%;
            border: 1.5px solid var(--outline-variant);
            display: flex; align-items: center; justify-content: center;
            color: var(--on-surface-variant);
            font-size: 0.75rem;
            transition: var(--transition);
            flex-shrink: 0;
        }

        .accord-item.open .accord-icon {
            background: var(--secondary);
            border-color: var(--secondary);
            color: #fff;
            transform: rotate(45deg);
        }

        .accord-body {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .accord-body-inner {
            padding: 0 28px 24px 72px;
        }

        .accord-item.open .accord-body {
            max-height: 1200px;
        }

        .about-logo {
            width: 80px; height: 80px;
            object-fit: contain;
            border-radius: 8px;
            padding: 8px;
            background: var(--surface-container-low);
            border: 1px solid var(--outline-variant);
            float: left;
            margin: 0 24px 12px 0;
        }

        .accord-text {
            font-family: var(--font-body);
            font-size: 0.95rem;
            line-height: 1.85;
            color: var(--on-surface-variant);
        }

        /* Vision-Mission grid */
        .vm-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-top: 8px;
        }

        .vm-card {
            background: var(--surface-container-low);
            border: 1px solid var(--outline-variant);
            border-radius: 8px;
            padding: 20px;
        }

        .vm-card h5 {
            font-family: var(--font-label);
            font-size: 0.7rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--secondary);
            margin-bottom: 12px;
        }

        .vm-card p, .vm-card li {
            font-family: var(--font-body);
            font-size: 0.875rem;
            line-height: 1.8;
            color: var(--on-surface-variant);
        }

        .vm-card ul { list-style: none; padding: 0; }

        .vm-card ul li {
            display: flex;
            gap: 10px;
            margin-bottom: 8px;
        }

        .vm-card ul li::before {
            content: '▸';
            color: var(--secondary);
            flex-shrink: 0;
        }

        /* Career tags */
        .career-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 16px;
        }

        .career-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            background: rgba(0, 89, 187, 0.06);
            border: 1px solid rgba(0, 89, 187, 0.15);
            border-radius: 4px;
            font-family: var(--font-label);
            font-size: 0.75rem;
            color: var(--secondary);
            transition: var(--transition);
        }

        .career-tag:hover {
            background: rgba(0, 89, 187, 0.12);
            border-color: var(--secondary);
        }

        /* Accreditation badge */
        .accred-badge {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 14px 24px;
            background: rgba(0, 89, 187, 0.05);
            border: 1px solid rgba(0, 89, 187, 0.2);
            border-left: 4px solid var(--secondary);
            border-radius: 8px;
            margin-top: 16px;
        }

        .accred-badge .accred-star {
            font-size: 1.8rem;
        }

        .accred-badge .accred-info strong {
            display: block;
            font-family: var(--font-display);
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--secondary);
        }

        .accred-badge .accred-info small {
            font-family: var(--font-label);
            font-size: 0.7rem;
            color: var(--on-surface-variant);
        }

        /* ============================================================
           FEATURES SECTION
        ============================================================ */
        .features-section {
            padding: 100px 0;
            background: var(--surface-container-low);
            position: relative;
            overflow: hidden;
        }

        .features-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 64px;
        }

        .feat-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-top: 56px;
        }

        .feat-card-new {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 8px;
            padding: 32px 28px;
            transition: var(--transition-slow);
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0, 31, 63, 0.04);
        }

        .feat-card-new::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: var(--card-accent, linear-gradient(90deg, var(--secondary), #0070ea));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .feat-card-new:hover::before { transform: scaleX(1); }

        .feat-card-new:hover {
            transform: translateY(-6px);
            border-color: rgba(0, 89, 187, 0.2);
            box-shadow: 0 20px 40px rgba(0, 31, 63, 0.1);
        }

        .feat-icon-new {
            width: 52px; height: 52px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 20px;
        }

        .feat-card-new h4 {
            font-family: var(--font-display);
            font-size: 1rem;
            font-weight: 700;
            color: var(--primary-container);
            margin-bottom: 10px;
        }

        .feat-card-new p {
            font-family: var(--font-body);
            font-size: 0.875rem;
            line-height: 1.75;
            color: var(--on-surface-variant);
        }

        /* ============================================================
           RESEARCH/ACHIEVEMENTS SECTION
        ============================================================ */
        .research-section {
            padding: 100px 0;
            background: var(--primary-container);
            position: relative;
            overflow: hidden;
        }

        .research-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg stroke='%23afc8f0' stroke-width='0.5' stroke-opacity='0.05'%3E%3Cpath d='M40 40c0-8.8 7.2-16 16-16s16 7.2 16 16-7.2 16-16 16-16-7.2-16-16zM0 0h80v80H0V0zm1 1v78h78V1H1zm39 39c0-5.5 4.5-10 10-10s10 4.5 10 10-4.5 10-10 10-10-4.5-10-10z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.4;
        }

        .research-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 64px;
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 64px;
            align-items: center;
        }

        .research-stat-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-top: 32px;
        }

        .research-stat-item {
            padding: 20px;
            border-radius: 8px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
        }

        .research-stat-num {
            font-family: var(--font-display);
            font-size: 2rem;
            font-weight: 700;
            color: var(--secondary-container);
            line-height: 1;
            margin-bottom: 6px;
        }

        .research-stat-label {
            font-family: var(--font-label);
            font-size: 0.7rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.5);
        }

        .research-achieve-item {
            padding: 20px 24px;
            border-radius: 8px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 16px;
            transition: var(--transition);
        }

        .research-achieve-item:last-child { margin-bottom: 0; }

        .research-achieve-item:hover {
            background: rgba(255,255,255,0.08);
            border-color: rgba(0, 218, 243, 0.2);
        }

        .research-achieve-icon {
            width: 40px; height: 40px;
            border-radius: 8px;
            background: var(--secondary);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .research-achieve-icon span { font-size: 1rem; color: #fff; }

        .research-achieve-item h5 {
            font-family: var(--font-display);
            font-size: 0.9rem;
            font-weight: 700;
            color: rgba(255,255,255,0.9);
            margin-bottom: 4px;
        }

        .research-achieve-item p {
            font-family: var(--font-body);
            font-size: 0.8rem;
            color: rgba(255,255,255,0.55);
        }

        /* ============================================================
           FOOTER
        ============================================================ */
        .site-footer {
            background: var(--primary);
            color: rgba(255,255,255,0.7);
            padding: 64px 0 0;
            border-top: 1px solid rgba(255,255,255,0.06);
        }

        .footer-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 64px;
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1.5fr;
            gap: 40px;
        }

        .footer-brand-img {
            width: 40px; height: 40px;
            border-radius: 50%;
            border: 2px solid rgba(0, 89, 187, 0.3);
            margin-right: 12px;
        }

        .footer-brand-name {
            font-family: var(--font-display);
            font-size: 0.9rem;
            font-weight: 700;
            color: #fff;
        }

        .footer-brand-sub {
            font-family: var(--font-label);
            font-size: 0.6rem;
            color: rgba(255,255,255,0.4);
        }

        .footer-tagline {
            font-family: var(--font-body);
            font-size: 0.875rem;
            line-height: 1.75;
            color: rgba(255,255,255,0.4);
            margin-top: 16px;
        }

        .footer-heading {
            font-family: var(--font-label);
            font-size: 0.65rem;
            font-weight: 500;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--secondary-container);
            margin-bottom: 20px;
        }

        .footer-link {
            display: block;
            font-family: var(--font-body);
            font-size: 0.875rem;
            color: rgba(255,255,255,0.45);
            text-decoration: none;
            margin-bottom: 10px;
            transition: var(--transition);
        }

        .footer-link:hover {
            color: rgba(255,255,255,0.9);
            transform: translateX(3px);
        }

        .footer-divider {
            max-width: 1280px;
            margin: 48px auto 0;
            padding: 20px 64px;
            border-top: 1px solid rgba(255,255,255,0.06);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .footer-copy {
            font-family: var(--font-label);
            font-size: 0.75rem;
            color: rgba(255,255,255,0.3);
        }

        .footer-copy span { color: var(--secondary-container); }

        .footer-social { display: flex; gap: 10px; }

        .social-btn {
            width: 34px; height: 34px;
            border-radius: 4px;
            border: 1px solid rgba(255,255,255,0.1);
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.4);
            font-size: 0.8rem;
            text-decoration: none;
            transition: var(--transition);
        }

        .social-btn:hover {
            border-color: var(--secondary);
            color: var(--secondary-container);
            background: rgba(0, 89, 187, 0.1);
        }

        /* ============================================================
           ANIMATIONS & REVEAL  — Premium scroll transitions
        ============================================================ */

        /* Base reveal — fade up with slight scale */
        .reveal {
            opacity: 0;
            transform: translateY(40px) scale(0.98);
            transition: opacity 0.7s cubic-bezier(0.22, 1, 0.36, 1),
                        transform 0.7s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        /* Reveal from left */
        .reveal-left {
            opacity: 0;
            transform: translateX(-48px) scale(0.97);
            transition: opacity 0.75s cubic-bezier(0.22, 1, 0.36, 1),
                        transform 0.75s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .reveal-left.visible  { opacity: 1; transform: translateX(0) scale(1); }

        /* Reveal from right */
        .reveal-right {
            opacity: 0;
            transform: translateX(48px) scale(0.97);
            transition: opacity 0.75s cubic-bezier(0.22, 1, 0.36, 1),
                        transform 0.75s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .reveal-right.visible { opacity: 1; transform: translateX(0) scale(1); }

        /* Reveal zoom — for cards */
        .reveal-zoom {
            opacity: 0;
            transform: scale(0.92) translateY(24px);
            transition: opacity 0.65s cubic-bezier(0.22, 1, 0.36, 1),
                        transform 0.65s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .reveal-zoom.visible { opacity: 1; transform: scale(1) translateY(0); }

        .delay-1 { transition-delay: 0.08s  !important; }
        .delay-2 { transition-delay: 0.18s  !important; }
        .delay-3 { transition-delay: 0.28s  !important; }
        .delay-4 { transition-delay: 0.38s  !important; }
        .delay-5 { transition-delay: 0.48s  !important; }
        .delay-6 { transition-delay: 0.58s  !important; }



        /* ============================================================
           SCROLL INDICATOR
        ============================================================ */
        .scroll-indicator {
            position: absolute;
            bottom: 32px; left: 50%;
            transform: translateX(-50%);
            z-index: 3;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            animation: bounce-indicator 2.5s infinite;
        }

        .scroll-indicator span {
            font-family: var(--font-label);
            font-size: 0.6rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--on-surface-variant);
        }

        .scroll-arrow {
            width: 30px; height: 30px;
            border: 1.5px solid var(--outline-variant);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: var(--on-surface-variant);
            font-size: 0.75rem;
        }

        @keyframes bounce-indicator {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50% { transform: translateX(-50%) translateY(8px); }
        }

        /* ============================================================
           RESPONSIVE
        ============================================================ */
        @media (max-width: 1100px) {
            .hero-inner, .research-inner { grid-template-columns: 1fr; gap: 40px; }
            .stats-inner { grid-template-columns: repeat(2, 1fr); }
            .feat-grid { grid-template-columns: repeat(2, 1fr); }
            .footer-inner { grid-template-columns: 1fr 1fr; }
            .navbar-inner { padding: 0 32px; }
            .about-inner, .features-inner, .footer-divider { padding: 0 32px; }
        }

        @media (max-width: 768px) {
            .hero-inner { padding: 60px 24px; }
            .stats-inner { grid-template-columns: 1fr 1fr; padding: 0 24px; }
            .feat-grid { grid-template-columns: 1fr; }
            .vm-grid { grid-template-columns: 1fr; }
            .footer-inner { grid-template-columns: 1fr; padding: 0 24px; }
            .footer-divider { padding: 20px 24px; }
            .about-inner, .features-inner { padding: 0 24px; }
            .navbar-inner { padding: 0 20px; }
            .nav-links { display: none; }
            .navbar-toggler-custom { display: block; }
        }

        @media (max-width: 576px) {
            .stats-inner { grid-template-columns: 1fr 1fr; }
            .hero-cta-group { flex-direction: column; }
        }
    </style>
</head>

<body>

    <!-- ================================================================
         NAVBAR
    ================================================================ -->
    <nav class="custom-navbar" id="mainNavbar">
        <div class="navbar-inner">

            <a href="#" class="d-flex align-items-center gap-3 text-decoration-none">
                <img src="/images/logo-elektro.png" alt="Logo Elektro" class="brand-logo">
                <div class="d-flex flex-column">
                    <span class="brand-name">ELECTRICAL ENGINEERING</span>
                    <span class="brand-sub">Teknik Elektro · UNHAN RI</span>
                </div>
            </a>

            <div class="nav-links">
                <a href="#about" class="nav-link-custom">Tentang</a>
                <a href="#features" class="nav-link-custom">Keunggulan</a>
                <a href="#research" class="nav-link-custom">Prestasi</a>
            </div>


        </div>
    </nav>

    <!-- ================================================================
         HERO SECTION
    ================================================================ -->
    <section class="hero-section" id="home">
        <div class="hero-bg-orb orb-1"></div>
        <div class="hero-bg-orb orb-2"></div>

        <div class="hero-inner">
            <!-- Left: Text -->
            <div>
                <div class="hero-badge">
                    <span class="badge-dot"></span>
                    Program Studi Teknik Elektro
                </div>

                <h1 class="hero-title">
                    Teknik Elektro<br>
                    <span class="accent">UNHAN RI</span>
                </h1>

                <p class="hero-subtitle">
                    Membentuk kader intelektual pertahanan yang menguasai teknologi energi,
                    sistem kontrol, dan telekomunikasi demi kedaulatan digital bangsa.
                </p>

                <div class="hero-cta-group">
                    <a href="{{ route('login') }}" class="btn-hero-primary">
                        <span class="material-symbols-outlined" style="font-size:1.1rem;">login</span>
                        Login Portal
                    </a>
                    <a href="{{ route('register') }}" class="btn-hero-secondary">
                        <span class="material-symbols-outlined" style="font-size:1.1rem;">person_add</span>
                        Daftar / Registrasi
                    </a>
                </div>
            </div>

            <!-- Right: Visual -->
            <div class="hero-visual">
                <div class="glass-card" style="border-radius:16px;padding:32px;position:relative;overflow:hidden;">
                    <div style="position:absolute;top:-60px;right:-60px;width:220px;height:220px;border-radius:50%;background:rgba(0,89,187,0.05);pointer-events:none;"></div>

                    <p style="font-family:var(--font-label);font-size:0.65rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--on-surface-variant);margin-bottom:20px;">Quick Overview</p>

                    <div style="display:flex;flex-direction:column;gap:12px;">
                        <div style="display:flex;align-items:center;gap:14px;padding:14px;border-radius:8px;background:var(--surface-container-low);border:1px solid var(--outline-variant);transition:var(--transition);" onmouseover="this.style.borderColor='rgba(0,89,187,0.3)'" onmouseout="this.style.borderColor='var(--outline-variant)'">
                            <div style="width:40px;height:40px;border-radius:8px;background:rgba(0,89,187,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <span class="material-symbols-outlined" style="color:var(--secondary);font-size:1.2rem;">school</span>
                            </div>
                            <div>
                                <div style="font-family:var(--font-label);font-size:0.65rem;color:var(--on-surface-variant);text-transform:uppercase;letter-spacing:0.08em;">Program Studi</div>
                                <div style="font-family:var(--font-display);font-size:0.9rem;font-weight:700;color:var(--primary-container);">Teknik Elektro S1</div>
                            </div>
                        </div>

                        <div style="display:flex;align-items:center;gap:14px;padding:14px;border-radius:8px;background:var(--surface-container-low);border:1px solid var(--outline-variant);transition:var(--transition);" onmouseover="this.style.borderColor='rgba(0,89,187,0.3)'" onmouseout="this.style.borderColor='var(--outline-variant)'">
                            <div style="width:40px;height:40px;border-radius:8px;background:rgba(0,89,187,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <span class="material-symbols-outlined" style="color:var(--secondary);font-size:1.2rem;">verified_user</span>
                            </div>
                            <div>
                                <div style="font-family:var(--font-label);font-size:0.65rem;color:var(--on-surface-variant);text-transform:uppercase;letter-spacing:0.08em;">Akreditasi</div>
                                <div style="font-family:var(--font-display);font-size:0.9rem;font-weight:700;color:var(--primary-container);">Terakreditasi Baik</div>
                            </div>
                        </div>

                        <div style="display:flex;align-items:center;gap:14px;padding:14px;border-radius:8px;background:var(--surface-container-low);border:1px solid var(--outline-variant);transition:var(--transition);" onmouseover="this.style.borderColor='rgba(0,89,187,0.3)'" onmouseout="this.style.borderColor='var(--outline-variant)'">
                            <div style="width:40px;height:40px;border-radius:8px;background:rgba(0,35,40,0.12);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <span class="material-symbols-outlined" style="color:var(--tertiary-container);font-size:1.2rem;">shield</span>
                            </div>
                            <div>
                                <div style="font-family:var(--font-label);font-size:0.65rem;color:var(--on-surface-variant);text-transform:uppercase;letter-spacing:0.08em;">Fokus Utama</div>
                                <div style="font-family:var(--font-display);font-size:0.9rem;font-weight:700;color:var(--primary-container);">Teknologi Pertahanan</div>
                            </div>
                        </div>

                        <div style="display:flex;align-items:center;gap:14px;padding:14px;border-radius:8px;background:var(--surface-container-low);border:1px solid var(--outline-variant);transition:var(--transition);" onmouseover="this.style.borderColor='rgba(0,89,187,0.3)'" onmouseout="this.style.borderColor='var(--outline-variant)'">
                            <div style="width:40px;height:40px;border-radius:8px;background:rgba(0,89,187,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <span class="material-symbols-outlined" style="color:var(--secondary);font-size:1.2rem;">account_balance</span>
                            </div>
                            <div>
                                <div style="font-family:var(--font-label);font-size:0.65rem;color:var(--on-surface-variant);text-transform:uppercase;letter-spacing:0.08em;">Universitas</div>
                                <div style="font-family:var(--font-display);font-size:0.9rem;font-weight:700;color:var(--primary-container);">Unhan RI</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>


    <!-- ================================================================
         ABOUT SECTION
    ================================================================ -->
    <section class="about-section" id="about">
        <div class="about-inner">
            <div class="text-center reveal" style="max-width:600px;margin:0 auto;">
                <div class="section-eyebrow" style="justify-content:center;">Tentang Kami</div>
                <h2 class="section-heading">
                    Mengenal Lebih Dekat<br>
                    <span class="highlight">Teknik Elektro Unhan</span>
                </h2>
                <p class="section-desc">
                    Temukan visi, misi, dan keunggulan Program Studi Teknik Elektro
                    Universitas Pertahanan Republik Indonesia.
                </p>
            </div>

            <!-- Accordion -->
            <div class="accord-wrap reveal">

                <!-- 01: Unhan RI -->
                <div class="accord-item" data-accord>
                    <div class="accord-header" data-accord-trigger>
                        <span class="accord-num">01</span>
                        <span class="accord-title">Universitas Pertahanan RI</span>
                        <span class="accord-icon"><i class="fa-solid fa-plus" style="font-size:0.75rem;"></i></span>
                    </div>
                    <div class="accord-body">
                        <div class="accord-body-inner">
                            <img src="/images/logo-unhan.jpg" alt="Logo Unhan" class="about-logo">
                            <p class="accord-text">
                                Indonesia Defense University atau Universitas Pertahanan Republik Indonesia
                                (Unhan RI) merupakan perguruan tinggi di bawah Kementerian Pertahanan Republik
                                Indonesia yang berfokus pada pengembangan ilmu pengetahuan, teknologi, dan
                                karakter bela negara untuk mencetak generasi unggul, disiplin, serta berjiwa
                                nasionalisme tinggi guna mendukung kemajuan bangsa dan pertahanan negara.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- 02: Teknik Elektro -->
                <div class="accord-item" data-accord>
                    <div class="accord-header" data-accord-trigger>
                        <span class="accord-num">02</span>
                        <span class="accord-title">Program Studi Teknik Elektro</span>
                        <span class="accord-icon"><i class="fa-solid fa-plus" style="font-size:0.75rem;"></i></span>
                    </div>
                    <div class="accord-body">
                        <div class="accord-body-inner">
                            <img src="/images/logo-elektro.png" alt="Logo Elektro" class="about-logo">
                            <p class="accord-text">
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

                <!-- 03: Visi & Misi -->
                <div class="accord-item" data-accord>
                    <div class="accord-header" data-accord-trigger>
                        <span class="accord-num">03</span>
                        <span class="accord-title">Visi &amp; Misi</span>
                        <span class="accord-icon"><i class="fa-solid fa-plus" style="font-size:0.75rem;"></i></span>
                    </div>
                    <div class="accord-body">
                        <div class="accord-body-inner">
                            <div class="vm-grid">
                                <div class="vm-card">
                                    <h5><i class="fa-solid fa-eye me-2"></i>Visi</h5>
                                    <p>
                                        Menjadi salah satu Program Studi Teknik Elektro yang menguasai perkembangan
                                        keilmuan teknik di bidang teknologi rekayasa elektro militer berstandar
                                        internasional berbasis riset dan teknologi rekayasa militer untuk pertahanan
                                        dan keamanan nasional dengan melestarikan nilai-nilai kebangsaan.
                                    </p>
                                </div>
                                <div class="vm-card">
                                    <h5><i class="fa-solid fa-bullseye me-2"></i>Misi</h5>
                                    <ul>
                                        <li>Mendidik calon intelektual bela negara di bidang teknologi dan rekayasa profesional.</li>
                                        <li>Mengembangkan ilmu teknologi rekayasa pertahanan sebagai disipliner keilmuan.</li>
                                        <li>Menyelenggarakan pembelajaran, penelitian, dan pengabdian berbasis teknologi pertahanan.</li>
                                        <li>Menyelenggarakan manajemen partisipatif berbasis mutu efisien dan akuntabel.</li>
                                        <li>Melaksanakan kerja sama nasional dan internasional guna pengembangan keilmuan.</li>
                                        <li>Mengembangkan sarana prasarana pendidikan berbasis mutu modern dan inovatif.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 04: Karir Lulusan -->
                <div class="accord-item" data-accord>
                    <div class="accord-header" data-accord-trigger>
                        <span class="accord-num">04</span>
                        <span class="accord-title">Karir Lulusan</span>
                        <span class="accord-icon"><i class="fa-solid fa-plus" style="font-size:0.75rem;"></i></span>
                    </div>
                    <div class="accord-body">
                        <div class="accord-body-inner">
                            <p class="accord-text">
                                Lulusan Program Studi Teknik Elektro Universitas Pertahanan RI dipersiapkan tidak hanya
                                sebagai tenaga profesional di bidang teknologi dan rekayasa, tetapi juga siap menjadi
                                Perwira TNI yang memiliki kompetensi di bidang sistem kelistrikan, elektronika,
                                telekomunikasi, kontrol, dan teknologi pertahanan modern.
                            </p>
                            <div class="career-tags">
                                <span class="career-tag"><i class="fa-solid fa-satellite-dish"></i> Sistem Komunikasi Pertahanan</span>
                                <span class="career-tag"><i class="fa-solid fa-microchip"></i> Elektronika Militer</span>
                                <span class="career-tag"><i class="fa-solid fa-radar"></i> Teknologi Radar</span>
                                <span class="career-tag"><i class="fa-solid fa-robot"></i> Otomasi &amp; Kontrol</span>
                                <span class="career-tag"><i class="fa-solid fa-bolt"></i> Sistem Kelistrikan</span>
                                <span class="career-tag"><i class="fa-solid fa-shield-halved"></i> Perwira TNI</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 05: Akreditasi -->
                <div class="accord-item" data-accord>
                    <div class="accord-header" data-accord-trigger>
                        <span class="accord-num">05</span>
                        <span class="accord-title">Akreditasi</span>
                        <span class="accord-icon"><i class="fa-solid fa-plus" style="font-size:0.75rem;"></i></span>
                    </div>
                    <div class="accord-body">
                        <div class="accord-body-inner">
                            <p class="accord-text">
                                Program Studi Teknik Elektro Universitas Pertahanan RI telah terakreditasi
                                <strong style="color:var(--secondary);">"Baik"</strong> sebagai bentuk pengakuan terhadap mutu
                                pendidikan, kualitas pembelajaran, serta pengembangan kompetensi mahasiswa di bidang
                                teknik elektro dan teknologi pertahanan.
                            </p>
                            <div class="accred-badge">
                                <span class="accred-star">⭐</span>
                                <div class="accred-info">
                                    <strong>Akreditasi: BAIK</strong>
                                    <small>BAN-PT – Kementerian Pendidikan RI</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- /accord-wrap -->
        </div>
    </section>


    <!-- ================================================================
         FEATURES / KEUNGGULAN SECTION
    ================================================================ -->
    <section class="features-section" id="features">
        <div class="features-inner">
            <div class="text-center reveal" style="max-width:600px;margin:0 auto;">
                <div class="section-eyebrow" style="justify-content:center;">Keunggulan</div>
                <h2 class="section-heading">
                    Mengapa Memilih<br>
                    <span class="highlight">Teknik Elektro Unhan?</span>
                </h2>
            </div>

            <div class="feat-grid">

                <div class="feat-card-new reveal delay-1" style="--card-accent:linear-gradient(90deg,#0059bb,#0070ea);">
                    <div class="feat-icon-new" style="background:rgba(0,89,187,0.1);">
                        <span class="material-symbols-outlined" style="color:var(--secondary);font-size:1.3rem;">science</span>
                    </div>
                    <h4>Berbasis Riset &amp; Teknologi</h4>
                    <p>Pembelajaran didukung riset aktif dan teknologi terkini untuk mendukung pengembangan sistem pertahanan nasional.</p>
                </div>

                <div class="feat-card-new reveal delay-2" style="--card-accent:linear-gradient(90deg,#002328,#0059bb);">
                    <div class="feat-icon-new" style="background:rgba(0,35,40,0.1);">
                        <span class="material-symbols-outlined" style="color:var(--tertiary-container);font-size:1.3rem;">military_tech</span>
                    </div>
                    <h4>Karakter Bela Negara</h4>
                    <p>Pembinaan karakter militer, kepemimpinan, dan semangat nasionalisme yang kokoh bagi setiap mahasiswa.</p>
                </div>

                <div class="feat-card-new reveal delay-3" style="--card-accent:linear-gradient(90deg,#0070ea,#00daf3);">
                    <div class="feat-icon-new" style="background:rgba(0,112,234,0.1);">
                        <span class="material-symbols-outlined" style="color:var(--secondary-container);font-size:1.3rem;">public</span>
                    </div>
                    <h4>Kerja Sama Internasional</h4>
                    <p>Jaringan kolaborasi dengan institusi dan perguruan tinggi dalam serta luar negeri di bidang teknologi pertahanan.</p>
                </div>

                <div class="feat-card-new reveal delay-1" style="--card-accent:linear-gradient(90deg,#0059bb,#002328);">
                    <div class="feat-icon-new" style="background:rgba(0,89,187,0.1);">
                        <span class="material-symbols-outlined" style="color:var(--secondary);font-size:1.3rem;">developer_board</span>
                    </div>
                    <h4>Kurikulum Komprehensif</h4>
                    <p>Mencakup sistem kelistrikan, elektronika, kontrol, telekomunikasi, pemrograman, dan rekayasa pertahanan.</p>
                </div>

                <div class="feat-card-new reveal delay-2" style="--card-accent:linear-gradient(90deg,#002328,#0059bb);">
                    <div class="feat-icon-new" style="background:rgba(0,35,40,0.1);">
                        <span class="material-symbols-outlined" style="color:var(--tertiary-container);font-size:1.3rem;">account_balance</span>
                    </div>
                    <h4>Fasilitas Modern</h4>
                    <p>Laboratorium dan fasilitas pendidikan tinggi yang modern, inovatif, dan mendukung pengembangan kompetensi mahasiswa.</p>
                </div>

                <div class="feat-card-new reveal delay-3" style="--card-accent:linear-gradient(90deg,#0070ea,#0059bb);">
                    <div class="feat-icon-new" style="background:rgba(0,112,234,0.1);">
                        <span class="material-symbols-outlined" style="color:var(--secondary-container);font-size:1.3rem;">groups</span>
                    </div>
                    <h4>Dosen Berpengalaman</h4>
                    <p>Diampu oleh pengajar berpengalaman dari kalangan akademisi dan praktisi militer di bidang teknik elektro.</p>
                </div>

            </div>
        </div>
    </section>


    <!-- ================================================================
         FOOTER
    ================================================================ -->
    <footer class="site-footer">
        <div class="footer-inner">

            <div>
                <div class="d-flex align-items-center mb-3">
                    <img src="/images/logo-elektro.png" alt="Logo" class="footer-brand-img">
                    <div>
                        <div class="footer-brand-name">Teknik Elektro</div>
                        <div class="footer-brand-sub">Indonesia Defense University</div>
                    </div>
                </div>
                <p class="footer-tagline">
                    Mencetak lulusan unggul, inovatif, dan berkarakter bela negara melalui
                    pendidikan teknik elektro berbasis teknologi pertahanan.
                </p>
            </div>

            <div>
                <div class="footer-heading">Navigasi</div>
                <a href="#home" class="footer-link">Beranda</a>
                <a href="#about" class="footer-link">Tentang Kami</a>
                <a href="#features" class="footer-link">Keunggulan</a>
                <a href="{{ route('login') }}" class="footer-link">SIMelek Login</a>
            </div>

            <div>
                <div class="footer-heading">Program</div>
                <a href="#" class="footer-link">Kurikulum</a>
                <a href="#" class="footer-link">Visi &amp; Misi</a>
                <a href="#" class="footer-link">Karir Lulusan</a>
                <a href="#" class="footer-link">Akreditasi</a>
            </div>

            <div>
                <div class="footer-heading">Kontak</div>
                <p class="footer-link" style="cursor:default;">
                    <span class="material-symbols-outlined" style="font-size:0.9rem;color:var(--secondary-container);vertical-align:middle;margin-right:6px;">location_on</span>
                    Kawasan IPSC, Sentul, Bogor
                </p>
                <p class="footer-link" style="cursor:default;">
                    <span class="material-symbols-outlined" style="font-size:0.9rem;color:var(--secondary-container);vertical-align:middle;margin-right:6px;">mail</span>
                    elektro@idu.ac.id
                </p>
                <p class="footer-link" style="cursor:default;">
                    <span class="material-symbols-outlined" style="font-size:0.9rem;color:var(--secondary-container);vertical-align:middle;margin-right:6px;">phone</span>
                    +62 21 XXXX XXXX
                </p>
            </div>

        </div>

        <div class="footer-divider">
            <div class="footer-copy">
                &copy; 2026 <span>SIMelek</span> — Web Prodi Teknik Elektro Unhan RI. All Rights Reserved.
            </div>
            <div class="footer-social">
                <a href="#" class="social-btn"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-btn"><i class="fab fa-youtube"></i></a>
                <a href="#" class="social-btn"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </footer>

    <!-- ================================================================
         SCRIPTS
    ================================================================ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    // ---------------------------------------------------------------
    // 1. NAVBAR SCROLL
    // ---------------------------------------------------------------
    const navbar = document.getElementById('mainNavbar');
    window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 60);
    });

    // ---------------------------------------------------------------
    // 2. SCROLL REVEAL — animate only when scrolling DOWN
    // ---------------------------------------------------------------
    const revealEls = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-zoom');

    let lastScrollY = window.scrollY;

    const revealObs = new IntersectionObserver((entries) => {
        const scrollingDown = window.scrollY >= lastScrollY;

        entries.forEach(e => {
            if (e.isIntersecting) {
                if (scrollingDown) {
                    // Stagger sibling cards
                    const siblings = e.target.parentElement
                        ? [...e.target.parentElement.children].filter(c =>
                              c.classList.contains('reveal') ||
                              c.classList.contains('reveal-zoom'))
                        : [];
                    const idx = siblings.indexOf(e.target);
                    e.target.style.transitionDelay = idx > 0 ? (idx * 0.09) + 's' : '0s';
                    e.target.classList.add('visible');
                } else {
                    // Scrolling up: show instantly, no animation
                    e.target.style.transition = 'none';
                    e.target.style.transitionDelay = '0s';
                    e.target.classList.add('visible');
                    // Re-enable transition after a tick so future down-scroll animates
                    requestAnimationFrame(() => {
                        requestAnimationFrame(() => {
                            e.target.style.transition = '';
                        });
                    });
                }
            } else {
                // Element left viewport — reset so down-scroll re-triggers animation
                e.target.style.transition = 'none';
                e.target.style.transitionDelay = '0s';
                e.target.classList.remove('visible');
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        e.target.style.transition = '';
                    });
                });
            }
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

    window.addEventListener('scroll', () => { lastScrollY = window.scrollY; }, { passive: true });

    revealEls.forEach(el => revealObs.observe(el));

    // ---------------------------------------------------------------
    // 3. COUNTER ANIMATION
    // ---------------------------------------------------------------
    function animateCounter(el) {
        const target = +el.dataset.target;
        const dur = 1600;
        const step = 16;
        const inc = target / (dur / step);
        let cur = 0;
        const timer = setInterval(() => {
            cur += inc;
            if (cur >= target) { cur = target; clearInterval(timer); }
            el.textContent = Math.floor(cur);
        }, step);
    }

    const counterObs = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.querySelectorAll('.counter').forEach(animateCounter);
                counterObs.unobserve(e.target);
            }
        });
    }, { threshold: 0.3 });

    document.querySelectorAll('.stats-section').forEach(s => counterObs.observe(s));

    // ---------------------------------------------------------------
    // 4. ACCORDION
    // ---------------------------------------------------------------
    document.querySelectorAll('[data-accord-trigger]').forEach(trigger => {
        trigger.addEventListener('click', () => {
            const item = trigger.closest('[data-accord]');
            const isOpen = item.classList.contains('open');

            document.querySelectorAll('[data-accord]').forEach(i => i.classList.remove('open'));

            if (!isOpen) item.classList.add('open');
        });
    });

    // Open first accordion by default
    const firstAccord = document.querySelector('[data-accord]');
    if (firstAccord) firstAccord.classList.add('open');

    // ---------------------------------------------------------------
    // 5. SMOOTH SCROLL
    // ---------------------------------------------------------------
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const target = document.querySelector(a.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
    </script>

</body>
</html>