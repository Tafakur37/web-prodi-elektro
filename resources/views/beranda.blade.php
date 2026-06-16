<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Program Studi Teknik Elektro Universitas Pertahanan RI - Mencetak lulusan unggul di bidang teknologi dan rekayasa pertahanan.">
    <title>Beranda – Teknik Elektro | Indonesia Defense University</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* ============================================================
           CSS VARIABLES & RESET
        ============================================================ */
        :root {
            --primary:       #0a1628;
            --primary-mid:   #0d1f3c;
            --accent-blue:   #0066ff;
            --accent-cyan:   #00c6ff;
            --accent-glow:   rgba(0, 102, 255, 0.4);
            --glass-bg:      rgba(255, 255, 255, 0.04);
            --glass-border:  rgba(255, 255, 255, 0.10);
            --text-light:    rgba(255, 255, 255, 0.75);
            --font-main:     'Inter', sans-serif;
            --font-display:  'Space Grotesk', sans-serif;
            --transition:    0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font-main);
            background: var(--primary);
            color: #fff;
            overflow-x: hidden;
        }

        /* ============================================================
           SCROLLBAR
        ============================================================ */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--primary); }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, var(--accent-blue), var(--accent-cyan));
            border-radius: 3px;
        }

        /* ============================================================
           CURSOR GLOW (optional enhancement)
        ============================================================ */
        #cursor-glow {
            position: fixed;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(0,102,255,0.08) 0%, transparent 70%);
            pointer-events: none;
            transform: translate(-50%, -50%);
            z-index: 0;
            transition: opacity 0.3s;
        }

        /* ============================================================
           NAVBAR
        ============================================================ */
        .custom-navbar {
            position: fixed;
            top: 0; left: 0;
            width: 100%;
            z-index: 9999;
            padding: 20px 0;
            transition: all 0.5s ease;
            background: linear-gradient(180deg, rgba(5, 13, 31, 0.85) 0%, transparent 100%);
        }

        .custom-navbar.scrolled {
            background: rgba(10, 22, 40, 0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 1px 0 rgba(255,255,255,0.08), 0 8px 32px rgba(0,0,0,0.4);
            padding: 12px 0;
        }

        .navbar-brand { text-decoration: none; }

        .brand-logo {
            width: 52px; height: 52px;
            border-radius: 50%;
            border: 2px solid rgba(0,198,255,0.4);
            box-shadow: 0 0 16px rgba(0,198,255,0.3);
            object-fit: cover;
            transition: var(--transition);
        }

        .brand-logo:hover {
            box-shadow: 0 0 28px rgba(0,198,255,0.6);
            transform: rotate(5deg) scale(1.05);
        }

        .brand-text { line-height: 1.15; }

        .brand-main {
            font-family: var(--font-display);
            font-size: 1rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 1px;
        }

        .brand-sub {
            font-size: 0.65rem;
            font-weight: 400;
            background: linear-gradient(90deg, var(--accent-cyan), var(--accent-blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .brand-univ {
            font-size: 0.52rem;
            color: rgba(255,255,255,0.5);
            letter-spacing: 0.8px;
        }

        /* Nav links */
        .nav-item { margin-left: 6px; }

        .btn-nav-login {
            padding: 8px 22px;
            border: 1.5px solid rgba(255,255,255,0.3);
            border-radius: 50px;
            color: #fff;
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            transition: var(--transition);
            background: transparent;
        }

        .btn-nav-login:hover {
            border-color: var(--accent-cyan);
            color: var(--accent-cyan);
            background: rgba(0,198,255,0.08);
            box-shadow: 0 0 16px rgba(0,198,255,0.2);
        }

        .btn-nav-register {
            padding: 8px 22px;
            border-radius: 50px;
            color: #fff;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-cyan));
            border: none;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .btn-nav-register::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--accent-cyan), var(--accent-blue));
            opacity: 0;
            transition: opacity 0.3s;
        }

        .btn-nav-register:hover::before { opacity: 1; }
        .btn-nav-register span { position: relative; z-index: 1; }

        .btn-nav-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,102,255,0.5);
            color: #fff;
        }

        .user-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 50px;
            font-size: 0.85rem;
            color: rgba(255,255,255,0.85);
        }

        .user-badge i { color: var(--accent-cyan); }

        .btn-logout {
            padding: 7px 18px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            background: rgba(220,53,69,0.15);
            border: 1.5px solid rgba(220,53,69,0.4);
            color: #ff6b7a;
            transition: var(--transition);
        }

        .btn-logout:hover {
            background: rgba(220,53,69,0.3);
            border-color: #ff6b7a;
            transform: translateY(-2px);
        }

        /* ============================================================
           HERO SECTION — Pure CSS Modern Background
        ============================================================ */
        .hero-section {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            overflow: hidden;
            /* Multi-layer modern dark gradient */
            background:
                radial-gradient(ellipse 80% 60% at 70% 50%, rgba(0, 80, 200, 0.18) 0%, transparent 70%),
                radial-gradient(ellipse 50% 40% at 20% 80%, rgba(0, 180, 255, 0.10) 0%, transparent 65%),
                radial-gradient(ellipse 60% 50% at 85% 15%, rgba(90, 60, 220, 0.12) 0%, transparent 60%),
                linear-gradient(160deg, #050d1f 0%, #071428 40%, #070f22 100%);
        }

        /* Decorative grid overlay */
        .hero-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(0, 102, 255, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 102, 255, 0.04) 1px, transparent 1px);
            background-size: 48px 48px;
            mask-image: radial-gradient(ellipse 90% 70% at 60% 50%, black 30%, transparent 80%);
            z-index: 0;
        }

        /* Glowing orbs */
        .hero-section::after {
            content: '';
            position: absolute;
            top: -120px; right: -80px;
            width: 520px; height: 520px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(0, 100, 255, 0.14) 0%, transparent 70%);
            filter: blur(40px);
            z-index: 0;
            animation: orb-pulse 6s ease-in-out infinite;
        }

        @keyframes orb-pulse {
            0%, 100% { opacity: 0.7; transform: scale(1); }
            50%       { opacity: 1;   transform: scale(1.12); }
        }


        .hero-content-wrap {
            position: relative;
            z-index: 2;
            padding-top: 100px;
        }

        /* Badge pill */
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px;
            background: rgba(0,102,255,0.15);
            border: 1px solid rgba(0,102,255,0.4);
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--accent-cyan);
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 28px;
            animation: fadeInDown 0.8s ease forwards;
        }

        .hero-badge .dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--accent-cyan);
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(0.7); }
        }

        .hero-title {
            font-family: var(--font-display);
            font-size: clamp(2.8rem, 6vw, 5.5rem);
            font-weight: 700;
            line-height: 1.1;
            color: #fff;
            margin-bottom: 8px;
            animation: fadeInUp 0.9s 0.2s ease both;
        }

        .hero-title-accent {
            background: linear-gradient(90deg, var(--accent-cyan) 0%, var(--accent-blue) 50%, #7b61ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: inline-block;
        }

        .hero-subtitle {
            font-size: clamp(1rem, 2vw, 1.25rem);
            color: var(--text-light);
            font-weight: 400;
            margin-bottom: 40px;
            max-width: 520px;
            line-height: 1.7;
            animation: fadeInUp 0.9s 0.4s ease both;
        }

        .hero-cta-group {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            animation: fadeInUp 0.9s 0.6s ease both;
        }

        .btn-hero-primary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 32px;
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-cyan));
            color: #fff;
            font-weight: 600;
            font-size: 0.95rem;
            border-radius: 50px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .btn-hero-primary::after {
            content: '';
            position: absolute;
            top: 50%; left: 50%;
            width: 0; height: 0;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-hero-primary:hover::after { width: 300px; height: 300px; }

        .btn-hero-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 36px rgba(0,102,255,0.55);
            color: #fff;
        }

        .btn-hero-secondary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 32px;
            background: var(--glass-bg);
            color: #fff;
            font-weight: 500;
            font-size: 0.95rem;
            border-radius: 50px;
            text-decoration: none;
            border: 1.5px solid var(--glass-border);
            cursor: pointer;
            transition: var(--transition);
            backdrop-filter: blur(8px);
        }

        .btn-hero-secondary:hover {
            border-color: rgba(0,198,255,0.5);
            background: rgba(0,198,255,0.08);
            color: var(--accent-cyan);
            transform: translateY(-3px);
        }

        /* Hero visual card */
        .hero-visual {
            animation: fadeInRight 1s 0.3s ease both;
        }

        .hero-visual-card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.10);
            border-radius: 24px;
            padding: 32px;
            backdrop-filter: blur(12px);
            position: relative;
            overflow: hidden;
        }

        .hero-visual-card::before {
            content: '';
            position: absolute;
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: conic-gradient(from 0deg, transparent 0%, rgba(0,102,255,0.12) 25%, transparent 50%);
            animation: rotate-glow 6s linear infinite;
        }

        @keyframes rotate-glow {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }

        .hero-visual-inner {
            position: relative;
            z-index: 1;
        }

        .stat-row {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px;
            background: rgba(255,255,255,0.05);
            border-radius: 14px;
            margin-bottom: 12px;
            border: 1px solid rgba(255,255,255,0.07);
            transition: var(--transition);
        }

        .stat-row:hover {
            background: rgba(0,102,255,0.12);
            border-color: rgba(0,102,255,0.3);
            transform: translateX(6px);
        }

        .stat-row:last-child { margin-bottom: 0; }

        .stat-icon-box {
            width: 44px; height: 44px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .stat-icon-box.blue   { background: rgba(0,102,255,0.2); color: var(--accent-blue); }
        .stat-icon-box.cyan   { background: rgba(0,198,255,0.2); color: var(--accent-cyan); }
        .stat-icon-box.purple { background: rgba(123,97,255,0.2); color: #9b7fff; }
        .stat-icon-box.green  { background: rgba(0,210,100,0.2); color: #00d264; }

        .stat-label {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.5);
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .stat-val {
            font-family: var(--font-display);
            font-size: 1.1rem;
            font-weight: 700;
            color: #fff;
        }

        /* Scroll indicator */
        .scroll-indicator {
            position: absolute;
            bottom: 36px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 3;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            animation: bounce-subtle 2.5s infinite;
        }

        .scroll-indicator span {
            font-size: 0.7rem;
            color: rgba(255,255,255,0.4);
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .scroll-arrow {
            width: 32px; height: 32px;
            border: 1.5px solid rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.5);
            font-size: 0.8rem;
        }

        @keyframes bounce-subtle {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50%       { transform: translateX(-50%) translateY(8px); }
        }

        /* ============================================================
           STATS COUNTER SECTION
        ============================================================ */
        .stats-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #060d1e 0%, #0a1a3a 50%, #060d1e 100%);
            position: relative;
            overflow: hidden;
        }

        .stats-section::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(0,198,255,0.5), transparent);
        }

        .stats-section::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(0,102,255,0.5), transparent);
        }

        .stat-card {
            text-align: center;
            padding: 40px 24px;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent-blue), var(--accent-cyan));
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .stat-card:hover::before { transform: scaleX(1); }

        .stat-card:hover {
            transform: translateY(-8px);
            background: rgba(0,102,255,0.08);
            border-color: rgba(0,102,255,0.3);
            box-shadow: 0 20px 50px rgba(0,0,0,0.3), 0 0 30px rgba(0,102,255,0.15);
        }

        .stat-number {
            font-family: var(--font-display);
            font-size: 3rem;
            font-weight: 700;
            background: linear-gradient(90deg, var(--accent-cyan), var(--accent-blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
            margin-bottom: 8px;
        }

        .stat-unit {
            font-size: 1.5rem;
            margin-left: 2px;
        }

        .stat-desc {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.55);
            font-weight: 400;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stat-icon-top {
            font-size: 1.8rem;
            margin-bottom: 16px;
            display: block;
        }

        /* ============================================================
           SECTION HEADER
        ============================================================ */
        .section-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--accent-cyan);
            margin-bottom: 16px;
        }

        .section-eyebrow::before, .section-eyebrow::after {
            content: '';
            display: block;
            width: 24px; height: 1.5px;
            background: var(--accent-cyan);
            opacity: 0.6;
        }

        .section-heading {
            font-family: var(--font-display);
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
            margin-bottom: 16px;
        }

        .section-heading .highlight {
            background: linear-gradient(90deg, var(--accent-cyan), var(--accent-blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .section-desc {
            color: rgba(255,255,255,0.55);
            font-size: 1rem;
            line-height: 1.8;
            max-width: 560px;
        }

        /* ============================================================
           ABOUT SECTION (UNHAN & ELEKTRO)
        ============================================================ */
        .about-section {
            padding: 120px 0;
            background: var(--primary);
            position: relative;
        }

        .about-section .bg-glow {
            position: absolute;
            width: 500px; height: 500px;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.08;
            pointer-events: none;
        }

        .about-section .glow-1 {
            background: var(--accent-blue);
            top: -100px; right: -100px;
        }

        .about-section .glow-2 {
            background: var(--accent-cyan);
            bottom: -100px; left: -100px;
        }

        /* New modern accordion */
        .accord-wrap {
            margin-top: 64px;
        }

        .accord-item {
            margin-bottom: 12px;
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.07);
            background: rgba(255,255,255,0.025);
            transition: var(--transition);
        }

        .accord-item:hover {
            border-color: rgba(0,102,255,0.2);
        }

        .accord-item.open {
            border-color: rgba(0,102,255,0.35);
            background: rgba(0,102,255,0.06);
            box-shadow: 0 8px 32px rgba(0,0,0,0.2);
        }

        .accord-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px 32px;
            cursor: pointer;
            user-select: none;
            gap: 16px;
        }

        .accord-num {
            font-family: var(--font-display);
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--accent-cyan);
            letter-spacing: 2px;
            min-width: 32px;
        }

        .accord-title {
            font-family: var(--font-display);
            font-size: clamp(1.1rem, 2.5vw, 1.6rem);
            font-weight: 600;
            color: #fff;
            flex: 1;
        }

        .accord-icon {
            width: 36px; height: 36px;
            border-radius: 50%;
            border: 1.5px solid rgba(255,255,255,0.15);
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.5);
            font-size: 0.8rem;
            transition: var(--transition);
            flex-shrink: 0;
        }

        .accord-item.open .accord-icon {
            background: var(--accent-blue);
            border-color: var(--accent-blue);
            color: #fff;
            transform: rotate(45deg);
        }

        .accord-body {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.55s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .accord-body-inner {
            padding: 0 32px 28px 80px;
        }

        .accord-item.open .accord-body {
            max-height: 1200px;
        }

        .accord-body-inner .about-logo {
            width: 90px; height: 90px;
            object-fit: contain;
            border-radius: 16px;
            padding: 8px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            float: left;
            margin: 0 28px 16px 0;
        }

        .accord-text {
            font-size: 1rem;
            line-height: 1.85;
            color: rgba(255,255,255,0.65);
            max-width: 820px;
        }

        /* Visi & Misi special */
        .vm-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 8px; }

        .vm-card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 14px;
            padding: 20px 24px;
        }

        .vm-card h5 {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--accent-cyan);
            margin-bottom: 12px;
        }

        .vm-card p, .vm-card li {
            font-size: 0.9rem;
            line-height: 1.8;
            color: rgba(255,255,255,0.6);
        }

        .vm-card ul { list-style: none; padding: 0; }
        .vm-card ul li {
            display: flex;
            gap: 10px;
            margin-bottom: 8px;
        }

        .vm-card ul li::before {
            content: '▸';
            color: var(--accent-cyan);
            flex-shrink: 0;
            margin-top: 2px;
        }

        @media (max-width: 768px) {
            .vm-grid { grid-template-columns: 1fr; }
        }

        /* Career tags */
        .career-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 16px;
        }

        .career-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            background: rgba(0,102,255,0.1);
            border: 1px solid rgba(0,102,255,0.25);
            border-radius: 50px;
            font-size: 0.8rem;
            color: var(--accent-cyan);
            transition: var(--transition);
        }

        .career-tag:hover {
            background: rgba(0,102,255,0.2);
            border-color: var(--accent-cyan);
            transform: translateY(-2px);
        }

        /* Akreditasi badge */
        .accred-badge {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 16px 28px;
            background: linear-gradient(135deg, rgba(0,210,100,0.1), rgba(0,102,255,0.1));
            border: 1px solid rgba(0,210,100,0.3);
            border-radius: 16px;
            margin-top: 16px;
        }

        .accred-badge .accred-star {
            font-size: 2rem;
            color: #ffd700;
            text-shadow: 0 0 12px rgba(255,215,0,0.5);
        }

        .accred-badge .accred-info strong {
            display: block;
            font-size: 1rem;
            font-weight: 700;
            color: #00d264;
        }

        .accred-badge .accred-info small {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.5);
        }

        /* ============================================================
           FEATURE / KEUNGGULAN SECTION
        ============================================================ */
        .features-section {
            padding: 120px 0;
            background: linear-gradient(180deg, #060d1e 0%, #0a1628 100%);
            position: relative;
            overflow: hidden;
        }

        .features-section .grid-bg {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(0,102,255,0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0,102,255,0.05) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse at center, black 30%, transparent 80%);
        }

        .feat-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 24px;
            padding: 36px 28px;
            height: 100%;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            cursor: default;
        }

        .feat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: var(--card-accent, linear-gradient(90deg, var(--accent-blue), var(--accent-cyan)));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .feat-card:hover::before { transform: scaleX(1); }

        .feat-card:hover {
            transform: translateY(-10px);
            border-color: rgba(0,102,255,0.25);
            background: rgba(0,102,255,0.06);
            box-shadow: 0 24px 60px rgba(0,0,0,0.35), 0 0 40px rgba(0,102,255,0.1);
        }

        .feat-card .feat-icon {
            width: 56px; height: 56px;
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            margin-bottom: 20px;
        }

        .feat-card h4 {
            font-family: var(--font-display);
            font-size: 1.15rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 12px;
        }

        .feat-card p {
            font-size: 0.9rem;
            line-height: 1.8;
            color: rgba(255,255,255,0.5);
        }

        /* ============================================================
           FOOTER
        ============================================================ */
        .site-footer {
            background: #050c1a;
            border-top: 1px solid rgba(255,255,255,0.06);
            padding: 60px 0 0;
            position: relative;
            overflow: hidden;
        }

        .site-footer::before {
            content: '';
            position: absolute;
            top: 0; left: 50%;
            transform: translateX(-50%);
            width: 600px; height: 1px;
            background: linear-gradient(90deg, transparent, rgba(0,198,255,0.5), transparent);
        }

        .footer-brand img {
            width: 48px; height: 48px;
            border-radius: 50%;
            border: 2px solid rgba(0,198,255,0.3);
            margin-right: 14px;
        }

        .footer-brand-name {
            font-family: var(--font-display);
            font-size: 1rem;
            font-weight: 700;
            color: #fff;
        }

        .footer-brand-sub {
            font-size: 0.7rem;
            color: rgba(255,255,255,0.4);
        }

        .footer-tagline {
            font-size: 0.9rem;
            color: rgba(255,255,255,0.4);
            line-height: 1.7;
            margin-top: 16px;
            max-width: 280px;
        }

        .footer-heading {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--accent-cyan);
            margin-bottom: 20px;
        }

        .footer-link {
            display: block;
            font-size: 0.875rem;
            color: rgba(255,255,255,0.45);
            text-decoration: none;
            margin-bottom: 12px;
            transition: color 0.3s, transform 0.3s;
        }

        .footer-link:hover {
            color: #fff;
            transform: translateX(4px);
        }

        .footer-divider {
            margin-top: 48px;
            border-top: 1px solid rgba(255,255,255,0.06);
            padding: 20px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .footer-copy {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.3);
        }

        .footer-copy span { color: var(--accent-cyan); }

        .footer-social {
            display: flex;
            gap: 12px;
        }

        .social-btn {
            width: 36px; height: 36px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.1);
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.4);
            font-size: 0.8rem;
            text-decoration: none;
            transition: var(--transition);
        }

        .social-btn:hover {
            border-color: var(--accent-cyan);
            color: var(--accent-cyan);
            background: rgba(0,198,255,0.1);
            transform: translateY(-3px);
        }

        /* ============================================================
           ANIMATIONS
        ============================================================ */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(40px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-40px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        /* Reveal on scroll */
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .reveal-left {
            opacity: 0;
            transform: translateX(-40px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }

        .reveal-left.visible {
            opacity: 1;
            transform: translateX(0);
        }

        .reveal-right {
            opacity: 0;
            transform: translateX(40px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }

        .reveal-right.visible {
            opacity: 1;
            transform: translateX(0);
        }

        /* Delay helpers */
        .delay-1 { transition-delay: 0.1s !important; }
        .delay-2 { transition-delay: 0.2s !important; }
        .delay-3 { transition-delay: 0.3s !important; }
        .delay-4 { transition-delay: 0.4s !important; }
        .delay-5 { transition-delay: 0.5s !important; }

        /* ============================================================
           RESPONSIVE
        ============================================================ */
        @media (max-width: 991.98px) {
            .hero-visual { margin-top: 48px; }
            .accord-body-inner { padding-left: 32px; }
        }

        @media (max-width: 767.98px) {
            .accord-header { padding: 18px 20px; }
            .accord-body-inner { padding: 0 20px 20px; }
            .accord-body-inner .about-logo { float: none; margin: 0 0 16px 0; }
            .hero-cta-group { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>

<body>

    <!-- Cursor glow -->
    <div id="cursor-glow"></div>

    <!-- ================================================================
         NAVBAR
    ================================================================ -->
    <nav class="navbar navbar-expand-lg navbar-dark custom-navbar" id="mainNavbar">
        <div class="container-fluid px-4 px-lg-5">

            <a class="navbar-brand fw-bold d-flex align-items-center gap-3" href="#">
                <img src="/images/logo-elektro.png" alt="Logo Elektro" class="brand-logo">
                <div class="brand-text d-flex flex-column">
                    <span class="brand-main">ELECTRICAL <span style="color:rgba(255,255,255,0.4);">·</span> ENGINEERING</span>
                    <span class="brand-sub">Teknik Elektro</span>
                    <span class="brand-univ">Indonesia Defense University</span>
                </div>
            </a>

            <button class="navbar-toggler border-0" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    style="box-shadow:none;">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-1">

                    @auth
                        <li class="nav-item">
                            <span class="user-badge">
                                <i class="fa-solid fa-circle-user"></i>
                                {{ Auth::user()->name }}
                            </span>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-logout btn-sm">
                                    <i class="fa-solid fa-right-from-bracket me-1"></i>Logout
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="btn-nav-login">
                                <i class="fa-solid fa-right-to-bracket me-1"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="btn-nav-register">
                                <span><i class="fa-solid fa-user-plus me-1"></i>Register</span>
                            </a>
                        </li>
                    @endauth

                </ul>
            </div>

        </div>
    </nav>

    <!-- ================================================================
         HERO SECTION
    ================================================================ -->
    <header class="hero-section" id="home">

        <div class="container hero-content-wrap">
            <div class="row align-items-center g-5">

                <!-- Left: Text -->
                <div class="col-lg-7">
                    <div class="hero-badge">
                        <span class="dot"></span>
                        Program Studi Teknik Elektro
                    </div>

                    <h1 class="hero-title">
                        Welcome to<br>
                        <span class="hero-title-accent">Electrical Engineering</span>
                    </h1>

                    <p class="hero-subtitle">
                        Mencetak lulusan unggul, inovatif, dan berkarakter bela negara melalui
                        pendidikan teknik elektro berbasis riset dan teknologi pertahanan modern.
                    </p>

                    <div class="hero-cta-group">
                        <a href="#about" class="btn-hero-primary">
                            <i class="fa-solid fa-rocket"></i>
                            Jelajahi Program
                        </a>
                        <a href="{{ route('login') }}" class="btn-hero-secondary">
                            <i class="fa-solid fa-arrow-right-to-bracket"></i>
                            Masuk SIMelek
                        </a>
                    </div>
                </div>

                <!-- Right: Visual card -->
                <div class="col-lg-5 hero-visual">
                    <div class="hero-visual-card">
                        <div class="hero-visual-inner">
                            <p style="font-size:0.7rem;color:rgba(255,255,255,0.35);text-transform:uppercase;letter-spacing:2px;margin-bottom:16px;">
                                Quick Overview
                            </p>

                            <div class="stat-row">
                                <div class="stat-icon-box blue"><i class="fa-solid fa-graduation-cap"></i></div>
                                <div>
                                    <div class="stat-label">Program Studi</div>
                                    <div class="stat-val">Teknik Elektro S1</div>
                                </div>
                            </div>

                            <div class="stat-row">
                                <div class="stat-icon-box cyan"><i class="fa-solid fa-certificate"></i></div>
                                <div>
                                    <div class="stat-label">Akreditasi</div>
                                    <div class="stat-val">Terakreditasi Baik</div>
                                </div>
                            </div>

                            <div class="stat-row">
                                <div class="stat-icon-box purple"><i class="fa-solid fa-shield-halved"></i></div>
                                <div>
                                    <div class="stat-label">Fokus Utama</div>
                                    <div class="stat-val">Teknologi Pertahanan</div>
                                </div>
                            </div>

                            <div class="stat-row">
                                <div class="stat-icon-box green"><i class="fa-solid fa-building-columns"></i></div>
                                <div>
                                    <div class="stat-label">Universitas</div>
                                    <div class="stat-val">Unhan RI</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Scroll hint -->
        <div class="scroll-indicator">
            <span>Scroll</span>
            <div class="scroll-arrow"><i class="fa-solid fa-chevron-down"></i></div>
        </div>

    </header>

    <!-- ================================================================
         STATS COUNTER SECTION
    ================================================================ -->
    <section class="stats-section">
        <div class="container">
            <div class="row g-4 justify-content-center">

                <div class="col-6 col-md-3 reveal delay-1">
                    <div class="stat-card">
                        <span class="stat-icon-top" style="color:#00c6ff;">⚡</span>
                        <div class="stat-number">
                            <span class="counter" data-target="100">0</span><span class="stat-unit">%</span>
                        </div>
                        <div class="stat-desc">Akreditasi Baik</div>
                    </div>
                </div>

                <div class="col-6 col-md-3 reveal delay-2">
                    <div class="stat-card">
                        <span class="stat-icon-top" style="color:#7b61ff;">🎓</span>
                        <div class="stat-number">
                            <span class="counter" data-target="4">0</span><span class="stat-unit"> Thn</span>
                        </div>
                        <div class="stat-desc">Masa Studi</div>
                    </div>
                </div>

                <div class="col-6 col-md-3 reveal delay-3">
                    <div class="stat-card">
                        <span class="stat-icon-top" style="color:#00d264;">🛡️</span>
                        <div class="stat-number">
                            <span class="counter" data-target="6">0</span><span class="stat-unit">+</span>
                        </div>
                        <div class="stat-desc">Bidang Keahlian</div>
                    </div>
                </div>

                <div class="col-6 col-md-3 reveal delay-4">
                    <div class="stat-card">
                        <span class="stat-icon-top" style="color:#ffd700;">⭐</span>
                        <div class="stat-number">
                            <span class="counter" data-target="1">0</span><span class="stat-unit">st</span>
                        </div>
                        <div class="stat-desc">Defense University</div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ================================================================
         ABOUT / ACCORDION SECTION
    ================================================================ -->
    <section class="about-section" id="about">
        <div class="bg-glow glow-1"></div>
        <div class="bg-glow glow-2"></div>

        <div class="container position-relative">

            <!-- Section header -->
            <div class="row justify-content-center text-center mb-2 reveal">
                <div class="col-lg-7">
                    <div class="section-eyebrow">Tentang Kami</div>
                    <h2 class="section-heading">
                        Mengenal Lebih Dekat<br>
                        <span class="highlight">Teknik Elektro Unhan</span>
                    </h2>
                    <p class="section-desc mx-auto">
                        Temukan visi, misi, dan keunggulan Program Studi Teknik Elektro
                        Universitas Pertahanan Republik Indonesia.
                    </p>
                </div>
            </div>

            <!-- Modern Accordion -->
            <div class="accord-wrap reveal">

                <!-- 01: Unhan RI -->
                <div class="accord-item" data-accord>
                    <div class="accord-header" data-accord-trigger>
                        <span class="accord-num">01</span>
                        <span class="accord-title">Universitas Pertahanan RI</span>
                        <span class="accord-icon"><i class="fa-solid fa-plus"></i></span>
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
                        <span class="accord-icon"><i class="fa-solid fa-plus"></i></span>
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
                        <span class="accord-icon"><i class="fa-solid fa-plus"></i></span>
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
                        <span class="accord-icon"><i class="fa-solid fa-plus"></i></span>
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
                                <span class="career-tag"><i class="fa-solid fa-robot"></i> Otomasi & Kontrol</span>
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
                        <span class="accord-icon"><i class="fa-solid fa-plus"></i></span>
                    </div>
                    <div class="accord-body">
                        <div class="accord-body-inner">
                            <p class="accord-text">
                                Program Studi Teknik Elektro Universitas Pertahanan RI telah terakreditasi
                                <strong style="color:#fff;">"Baik"</strong> sebagai bentuk pengakuan terhadap mutu
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
    <section class="features-section">
        <div class="grid-bg"></div>
        <div class="container position-relative">

            <div class="row justify-content-center text-center mb-5 reveal">
                <div class="col-lg-7">
                    <div class="section-eyebrow">Keunggulan</div>
                    <h2 class="section-heading">
                        Mengapa Memilih<br>
                        <span class="highlight">Teknik Elektro Unhan?</span>
                    </h2>
                </div>
            </div>

            <div class="row g-4">

                <div class="col-sm-6 col-lg-4 reveal delay-1">
                    <div class="feat-card" style="--card-accent: linear-gradient(90deg, #0066ff, #00c6ff);">
                        <div class="feat-icon" style="background:rgba(0,102,255,0.15); color:#0066ff;">
                            <i class="fa-solid fa-flask"></i>
                        </div>
                        <h4>Berbasis Riset & Teknologi</h4>
                        <p>Pembelajaran didukung riset aktif dan teknologi terkini untuk mendukung pengembangan sistem pertahanan nasional.</p>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4 reveal delay-2">
                    <div class="feat-card" style="--card-accent: linear-gradient(90deg, #7b61ff, #0066ff);">
                        <div class="feat-icon" style="background:rgba(123,97,255,0.15); color:#7b61ff;">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <h4>Karakter Bela Negara</h4>
                        <p>Pembinaan karakter militer, kepemimpinan, dan semangat nasionalisme yang kokoh bagi setiap mahasiswa.</p>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4 reveal delay-3">
                    <div class="feat-card" style="--card-accent: linear-gradient(90deg, #00c6ff, #00d264);">
                        <div class="feat-icon" style="background:rgba(0,210,100,0.15); color:#00d264;">
                            <i class="fa-solid fa-earth-asia"></i>
                        </div>
                        <h4>Kerja Sama Internasional</h4>
                        <p>Jaringan kolaborasi dengan institusi dan perguruan tinggi dalam serta luar negeri di bidang teknologi pertahanan.</p>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4 reveal delay-1">
                    <div class="feat-card" style="--card-accent: linear-gradient(90deg, #ffd700, #ff8c00);">
                        <div class="feat-icon" style="background:rgba(255,215,0,0.12); color:#ffd700;">
                            <i class="fa-solid fa-microchip"></i>
                        </div>
                        <h4>Kurikulum Komprehensif</h4>
                        <p>Mencakup sistem kelistrikan, elektronika, kontrol, telekomunikasi, pemrograman, dan rekayasa pertahanan.</p>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4 reveal delay-2">
                    <div class="feat-card" style="--card-accent: linear-gradient(90deg, #ff6b7a, #ff4757);">
                        <div class="feat-icon" style="background:rgba(255,71,87,0.12); color:#ff6b7a;">
                            <i class="fa-solid fa-building-columns"></i>
                        </div>
                        <h4>Fasilitas Modern</h4>
                        <p>Laboratorium dan fasilitas pendidikan tinggi yang modern, inovatif, dan mendukung pengembangan kompetensi mahasiswa.</p>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-4 reveal delay-3">
                    <div class="feat-card" style="--card-accent: linear-gradient(90deg, #00c6ff, #7b61ff);">
                        <div class="feat-icon" style="background:rgba(0,198,255,0.15); color:#00c6ff;">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <h4>Dosen Berpengalaman</h4>
                        <p>Diampu oleh pengajar berpengalaman dari kalangan akademisi dan praktisi militer di bidang teknik elektro.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ================================================================
         FOOTER
    ================================================================ -->
    <footer class="site-footer">
        <div class="container">
            <div class="row g-5">

                <div class="col-lg-4">
                    <div class="footer-brand d-flex align-items-center mb-3">
                        <img src="/images/logo-elektro.png" alt="Logo">
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

                <div class="col-6 col-lg-2">
                    <div class="footer-heading">Navigasi</div>
                    <a href="#home" class="footer-link">Beranda</a>
                    <a href="#about" class="footer-link">Tentang Kami</a>
                    <a href="{{ route('login') }}" class="footer-link">SIMelek Login</a>
                </div>

                <div class="col-6 col-lg-3">
                    <div class="footer-heading">Program</div>
                    <a href="#" class="footer-link">Kurikulum</a>
                    <a href="#" class="footer-link">Visi &amp; Misi</a>
                    <a href="#" class="footer-link">Karir Lulusan</a>
                    <a href="#" class="footer-link">Akreditasi</a>
                </div>

                <div class="col-lg-3">
                    <div class="footer-heading">Kontak</div>
                    <p class="footer-link" style="cursor:default;">
                        <i class="fa-solid fa-location-dot me-2" style="color:var(--accent-cyan)"></i>
                        Kawasan IPSC, Sentul, Bogor
                    </p>
                    <p class="footer-link" style="cursor:default;">
                        <i class="fa-solid fa-envelope me-2" style="color:var(--accent-cyan)"></i>
                        elektro@idu.ac.id
                    </p>
                    <p class="footer-link" style="cursor:default;">
                        <i class="fa-solid fa-phone me-2" style="color:var(--accent-cyan)"></i>
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
        </div>
    </footer>

    <!-- ================================================================
         SCRIPTS
    ================================================================ -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    // ---------------------------------------------------------------
    // 1. CURSOR GLOW
    // ---------------------------------------------------------------
    const cursorGlow = document.getElementById('cursor-glow');
    document.addEventListener('mousemove', e => {
        cursorGlow.style.left = e.clientX + 'px';
        cursorGlow.style.top  = e.clientY + 'px';
    });

    // ---------------------------------------------------------------
    // 2. NAVBAR SCROLL
    // ---------------------------------------------------------------
    const navbar = document.getElementById('mainNavbar');
    window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 60);
    });


    // ---------------------------------------------------------------
    // 5. SCROLL REVEAL
    // ---------------------------------------------------------------
    const revealEls = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');
    const revealObs = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                revealObs.unobserve(e.target);
            }
        });
    }, { threshold: 0.12 });

    revealEls.forEach(el => revealObs.observe(el));

    // ---------------------------------------------------------------
    // 7. COUNTER ANIMATION
    // ---------------------------------------------------------------
    function animateCounter(el) {
        const target = +el.dataset.target;
        const dur    = 1800;
        const step   = 16;
        const inc    = target / (dur / step);
        let cur      = 0;
        const timer  = setInterval(() => {
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
    // 8. MODERN ACCORDION
    // ---------------------------------------------------------------
    document.querySelectorAll('[data-accord-trigger]').forEach(trigger => {
        trigger.addEventListener('click', () => {
            const item = trigger.closest('[data-accord]');
            const isOpen = item.classList.contains('open');

            // Close all
            document.querySelectorAll('[data-accord]').forEach(i => i.classList.remove('open'));

            // Toggle clicked
            if (!isOpen) item.classList.add('open');
        });
    });

    // Open first by default
    const firstAccord = document.querySelector('[data-accord]');
    if (firstAccord) firstAccord.classList.add('open');

    // ---------------------------------------------------------------
    // 9. SMOOTH SCROLL for anchor links
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