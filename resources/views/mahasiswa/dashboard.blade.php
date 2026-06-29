@extends('layouts.mahasiswa')
@section('title', 'Dashboard')

@push('styles')
<style>
    /* ================================================================
   DASHBOARD LAYOUT
================================================================ */
    .dash-layout {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 20px;
        align-items: start;
    }

    @media (max-width: 1100px) {
        .dash-layout {
            grid-template-columns: 1fr;
        }
    }

    /* ── HERO STRIP ─────────────────────────────────────────────── */
    .hero-strip {
        background: linear-gradient(135deg, #001f3f 0%, #0059bb 60%, #0070ea 100%);
        border-radius: var(--radius-xl);
        padding: 22px 26px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(0, 31, 63, 0.28);
        animation: hero-in 0.5s cubic-bezier(0.22, 1, 0.36, 1) both;
    }

    @keyframes hero-in {
        from {
            opacity: 0;
            transform: translateY(-10px) scale(0.99);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* Animated mesh background */
    .hero-strip::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 60% 80% at 80% 50%, rgba(0, 112, 234, 0.35) 0%, transparent 60%),
            radial-gradient(ellipse 40% 60% at 10% 20%, rgba(255, 255, 255, 0.06) 0%, transparent 50%);
        pointer-events: none;
    }

    .hero-strip::after {
        content: '';
        position: absolute;
        right: -30px;
        top: -50px;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.04);
        pointer-events: none;
    }

    .hero-avatar {
        width: 54px;
        height: 54px;
        flex-shrink: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        border: 2.5px solid rgba(255, 255, 255, 0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: var(--font-display);
        font-size: 1.4rem;
        font-weight: 800;
        color: #fff;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        position: relative;
        z-index: 1;
    }

    .hero-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .hero-text {
        flex: 1;
        position: relative;
        z-index: 1;
    }

    .hero-greeting {
        font-family: var(--font-label);
        font-size: 0.58rem;
        text-transform: uppercase;
        letter-spacing: 0.14em;
        color: rgba(255, 255, 255, 0.5);
        margin-bottom: 3px;
    }

    .hero-name {
        font-family: var(--font-display);
        font-size: 1.08rem;
        font-weight: 800;
        color: #fff;
        margin-bottom: 3px;
    }

    .hero-sub {
        font-size: 0.78rem;
        color: rgba(255, 255, 255, 0.52);
    }

    .hero-meta {
        position: relative;
        z-index: 1;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.14);
        border-radius: var(--radius-md);
        padding: 10px 14px;
        text-align: right;
        flex-shrink: 0;
        backdrop-filter: blur(8px);
    }

    .hero-meta .date-lbl {
        font-family: var(--font-label);
        font-size: 0.56rem;
        color: rgba(255, 255, 255, 0.42);
        text-transform: uppercase;
        letter-spacing: 0.1em;
        display: block;
        margin-bottom: 3px;
    }

    .hero-meta .date-val {
        font-family: var(--font-display);
        font-size: 0.78rem;
        font-weight: 700;
        color: rgba(255, 255, 255, 0.9);
    }

    /* ── QUICK NAV ──────────────────────────────────────────────── */
    .quick-nav {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 10px;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .quick-nav {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    .quick-nav-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 7px;
        padding: 13px 8px;
        background: var(--card-glass-bg);
        backdrop-filter: blur(30px) saturate(160%);
        -webkit-backdrop-filter: blur(30px) saturate(160%);
        border: 1px solid var(--card-glass-border);
        border-radius: var(--radius-lg);
        text-decoration: none;
        color: var(--text-2);
        font-size: 0.71rem;
        font-weight: 600;
        text-align: center;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.07), inset 0 1px 0 rgba(255, 255, 255, 0.5);
        transition: all 0.22s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
        overflow: hidden;
    }

    /* Stronger glass effect on all mahasiswa sections */
    .mhs-card.glass-panel {
        position: relative;
        isolation: isolate;
        background: rgba(255, 255, 255, 0.36) !important;
        border: 1px solid rgba(255, 255, 255, 0.58) !important;
        backdrop-filter: blur(34px) saturate(185%) !important;
        -webkit-backdrop-filter: blur(34px) saturate(185%) !important;
        box-shadow:
            0 10px 34px rgba(0, 31, 63, 0.10),
            inset 0 1px 0 rgba(255, 255, 255, 0.68) !important;
    }

    [data-theme="dark"] .mhs-card.glass-panel {
        background: rgba(14, 20, 38, 0.44) !important;
        border-color: rgba(104, 163, 255, 0.18) !important;
        box-shadow:
            0 10px 34px rgba(0, 0, 0, 0.34),
            inset 0 1px 0 rgba(255, 255, 255, 0.06) !important;
    }

    .mhs-card.glass-panel::before {
        content: '';
        position: absolute;
        inset: 0;
        z-index: 0;
        pointer-events: none;
        background: linear-gradient(135deg,
                rgba(255, 255, 255, 0.22) 0%,
                rgba(255, 255, 255, 0.06) 35%,
                rgba(0, 89, 187, 0.06) 70%,
                rgba(255, 255, 255, 0.10) 100%);
        backdrop-filter: blur(26px) saturate(170%);
        -webkit-backdrop-filter: blur(26px) saturate(170%);
        opacity: 0.95;
    }

    .mhs-card.glass-panel::after {
        content: '';
        position: absolute;
        inset: -60% -30% auto -30%;
        height: 180%;
        z-index: 0;
        pointer-events: none;
        background: radial-gradient(circle at 30% 40%, rgba(255, 255, 255, 0.35), transparent 55%);
        opacity: 0;
        transition: opacity 0.25s ease;
    }

    .mhs-card.glass-panel:hover::after {
        opacity: 1;
    }

    /* ensure inner content above pseudo layers */
    .mhs-card.glass-panel>* {
        position: relative;
        z-index: 1;
    }

    .quick-nav-item::before {
        content: '';
        position: absolute;
        inset: 0;
        background: var(--info-light);
        opacity: 0;
        transition: opacity 0.2s;
        border-radius: var(--radius-lg);
    }

    .quick-nav-item:hover {
        color: var(--secondary);
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 12px 30px rgba(0, 89, 187, 0.16), inset 0 1px 0 rgba(255, 255, 255, 0.7);
        border-color: rgba(0, 89, 187, 0.2);
    }

    .quick-nav-item:hover::before {
        opacity: 1;
    }

    .quick-nav-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        position: relative;
        z-index: 1;
        transition: transform 0.22s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .quick-nav-item:hover .quick-nav-icon {
        transform: scale(1.12);
    }

    .quick-nav-item span {
        position: relative;
        z-index: 1;
    }

    /* ── SECTION HEADER (reusable) ──────────────────────────────── */
    .sec-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 13px 16px;
        border-bottom: 1px solid var(--card-glass-border);
        background: rgba(255, 255, 255, 0.22);
        backdrop-filter: blur(18px) saturate(165%);
        -webkit-backdrop-filter: blur(18px) saturate(165%);
    }

    [data-theme="dark"] .sec-header {
        background: rgba(255, 255, 255, 0.04);
    }

    .sec-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: var(--font-display);
        font-size: 0.83rem;
        font-weight: 700;
        color: var(--text-1);
        margin: 0;
    }

    .sec-icon {
        width: 26px;
        height: 26px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.78rem;
        flex-shrink: 0;
    }

    /* ── JADWAL HARI INI — timeline style ───────────────────────── */
    .schedule-timeline {
        padding: 14px 16px;
    }

    .schedule-slot {
        display: flex;
        gap: 13px;
        padding: 11px 0;
        border-bottom: 1px solid var(--surface-container-high);
        animation: fadeInUp 0.35s cubic-bezier(0.22, 1, 0.36, 1) both;
    }

    .schedule-slot:last-child {
        padding-bottom: 0;
        border-bottom: none;
    }

    .schedule-slot:nth-child(1) {
        animation-delay: 0.05s;
    }

    .schedule-slot:nth-child(2) {
        animation-delay: 0.10s;
    }

    .schedule-slot:nth-child(3) {
        animation-delay: 0.15s;
    }

    .schedule-slot:nth-child(n+4) {
        animation-delay: 0.18s;
    }

    .slot-time {
        flex-shrink: 0;
        width: 52px;
        font-family: var(--font-label);
        font-size: 0.66rem;
        font-weight: 600;
        color: var(--secondary);
        text-align: center;
        line-height: 1.3;
    }

    .slot-time .time-end {
        color: var(--outline);
    }

    .slot-dot {
        flex-shrink: 0;
        width: 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding-top: 4px;
    }

    .slot-dot-circle {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--secondary);
        flex-shrink: 0;
        box-shadow: 0 0 0 2px rgba(0, 89, 187, 0.2);
    }

    .slot-dot-line {
        width: 1px;
        flex: 1;
        background: var(--outline-variant);
        margin-top: 3px;
    }

    .slot-body {
        flex: 1;
        min-width: 0;
    }

    .slot-subject {
        font-weight: 700;
        font-size: 0.87rem;
        color: var(--on-surface);
        margin-bottom: 2px;
    }

    .slot-subject.cancelled {
        text-decoration: line-through;
        color: var(--danger);
    }

    .slot-lecturer {
        font-size: 0.75rem;
        color: var(--text-2);
        margin-bottom: 5px;
    }

    .slot-meta {
        display: flex;
        gap: 12px;
        font-family: var(--font-label);
        font-size: 0.6rem;
        color: var(--outline);
    }

    .slot-chip {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        padding: 2px 8px;
        border-radius: 20px;
        font-family: var(--font-label);
        font-size: 0.58rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-top: 4px;
    }

    .slot-chip.cancelled {
        background: var(--danger-light);
        color: var(--danger);
    }

    .slot-chip.changed {
        background: var(--warning-light);
        color: var(--warning);
    }

    /* ── WEEKLY TABLE ───────────────────────────────────────────── */
    .week-today {
        background: var(--info-light) !important;
    }

    /* ── FITNESS TABS ───────────────────────────────────────────── */
    .tab-row {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
        margin-bottom: 12px;
    }

    .tab-pill {
        padding: 4px 12px;
        border-radius: 20px;
        border: 1px solid var(--outline-variant);
        background: transparent;
        color: var(--text-2);
        font-family: var(--font-label);
        font-size: 0.66rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.18s;
        letter-spacing: 0.04em;
    }

    .tab-pill.active,
    .tab-pill:hover {
        background: var(--secondary);
        border-color: var(--secondary);
        color: #fff;
    }

    /* ── FITNESS ENTRY ──────────────────────────────────────────── */
    .fit-entry {
        background: var(--surface-container-low);
        border: 1px solid var(--outline-variant);
        border-radius: var(--radius-md);
        padding: 13px;
        margin-bottom: 9px;
        transition: all 0.2s ease;
    }

    .fit-entry:last-child {
        margin-bottom: 0;
    }

    .fit-entry:hover {
        border-color: var(--secondary);
    }

    .fit-score-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 9px;
    }

    .fit-score-big {
        font-family: var(--font-display);
        font-size: 2rem;
        font-weight: 800;
        color: var(--danger);
        line-height: 1;
    }

    .fit-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 5px;
        margin-top: 9px;
    }

    .fit-metric {
        background: var(--surface-container);
        border: 1px solid var(--outline-variant);
        border-radius: 6px;
        padding: 6px 8px;
    }

    .fit-metric-lbl {
        font-family: var(--font-label);
        font-size: 0.58rem;
        color: var(--outline);
        display: block;
    }

    .fit-metric-val {
        font-weight: 700;
        font-size: 0.8rem;
        color: var(--on-surface);
    }

    .fit-metric-score {
        font-weight: 800;
        font-size: 0.76rem;
    }

    .fit-metric-score.ok {
        color: var(--success);
    }

    .fit-metric-score.fail {
        color: var(--danger);
    }

    /* ── ACHIEVEMENT ITEM ───────────────────────────────────────── */
    .ach-item {
        display: flex;
        align-items: flex-start;
        gap: 11px;
        padding: 10px 0;
        border-bottom: 1px solid var(--outline-variant);
        text-decoration: none;
        color: inherit;
        transition: all 0.15s;
        cursor: pointer;
        border-radius: 0;
    }

    .ach-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .ach-item:hover {
        opacity: 0.72;
        transform: translateX(3px);
    }

    .ach-icon {
        width: 34px;
        height: 34px;
        flex-shrink: 0;
        background: rgba(255, 200, 0, 0.1);
        border: 1px solid rgba(255, 200, 0, 0.2);
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }

    .ach-item h6 {
        font-size: 0.82rem;
        font-weight: 700;
        margin: 0 0 2px;
        color: var(--on-surface);
    }

    .ach-item p {
        font-size: 0.73rem;
        color: var(--text-2);
        margin: 0 0 4px;
        line-height: 1.45;
    }

    /* ── EXAM ITEM ──────────────────────────────────────────────── */
    .exam-item {
        display: flex;
        gap: 12px;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid var(--outline-variant);
        transition: transform 0.15s ease;
    }

    .exam-item:last-child {
        border-bottom: none;
    }

    .exam-item:hover {
        transform: translateX(3px);
    }

    .exam-date-box {
        width: 40px;
        flex-shrink: 0;
        text-align: center;
        background: var(--info-light);
        border: 1px solid rgba(0, 89, 187, 0.18);
        border-radius: var(--radius-md);
        padding: 5px 3px;
    }

    .exam-date-box .eday {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--secondary);
        line-height: 1;
    }

    .exam-date-box .emon {
        font-size: 0.56rem;
        font-weight: 700;
        color: var(--secondary);
        opacity: 0.7;
        text-transform: uppercase;
    }

    .exam-body h6 {
        font-size: 0.83rem;
        font-weight: 700;
        margin: 0 0 3px;
        color: var(--on-surface);
    }

    .exam-meta {
        font-size: 0.71rem;
        color: var(--text-3);
        display: flex;
        gap: 10px;
    }

    /* ── ANNOUNCEMENT ITEM ──────────────────────────────────────── */
    .ann-item {
        display: block;
        text-decoration: none;
        color: inherit;
        padding: 10px 0;
        border-bottom: 1px solid var(--outline-variant);
        transition: all 0.15s;
    }

    .ann-item:last-child {
        border-bottom: none;
    }

    .ann-item:hover {
        opacity: 0.75;
        transform: translateX(3px);
    }

    .ann-item h6 {
        font-size: 0.82rem;
        font-weight: 700;
        margin: 0 0 3px;
        color: var(--on-surface);
    }

    .ann-item p {
        font-size: 0.73rem;
        color: var(--text-2);
        margin: 0 0 4px;
        line-height: 1.5;
    }

    .ann-time {
        font-family: var(--font-label);
        font-size: 0.6rem;
        color: var(--outline);
    }

    /* ── VIOLATION ALERT ────────────────────────────────────────── */
    .violation-alert {
        background: var(--danger-light);
        border: 1px solid rgba(186, 26, 26, 0.2);
        border-radius: var(--radius-lg);
        overflow: hidden;
        margin-bottom: 14px;
        animation: shake 0.5s ease 0.3s both;
    }

    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        20% {
            transform: translateX(-3px);
        }

        40% {
            transform: translateX(3px);
        }

        60% {
            transform: translateX(-2px);
        }

        80% {
            transform: translateX(2px);
        }
    }

    .violation-alert-head {
        padding: 9px 14px;
        background: rgba(186, 26, 26, 0.1);
        border-bottom: 1px solid rgba(186, 26, 26, 0.15);
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--danger);
    }

    .violation-body {
        padding: 11px 14px;
    }

    .violation-item {
        padding: 9px 11px;
        margin-bottom: 7px;
        background: rgba(186, 26, 26, 0.05);
        border: 1px solid rgba(186, 26, 26, 0.12);
        border-radius: var(--radius-sm);
    }

    .violation-item:last-child {
        margin-bottom: 0;
    }

    .v-title {
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--danger);
        margin-bottom: 2px;
    }

    .v-desc {
        font-size: 0.76rem;
        color: var(--on-surface);
        margin-bottom: 3px;
    }

    .v-meta {
        font-family: var(--font-label);
        font-size: 0.6rem;
        color: var(--outline);
    }

    /* ── IPK RING ───────────────────────────────────────────────── */
    .ipk-wrap {
        text-align: center;
        padding: 6px 0 8px;
    }

    .ipk-ring-svg {
        transform: rotate(-90deg);
    }

    .ipk-ring-bg {
        fill: none;
        stroke: var(--surface-container-high);
        stroke-width: 7;
    }

    .ipk-ring-fg {
        fill: none;
        stroke: var(--secondary);
        stroke-width: 7;
        stroke-linecap: round;
        transition: stroke-dashoffset 1.8s cubic-bezier(0.4, 0, 0.2, 1);
        filter: drop-shadow(0 0 4px rgba(0, 89, 187, 0.4));
    }

    .ipk-center {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .ipk-val {
        font-family: var(--font-display);
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--on-surface);
        line-height: 1;
    }

    .ipk-lbl {
        font-family: var(--font-label);
        font-size: 0.56rem;
        color: var(--outline);
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-top: 2px;
    }

    .ipk-verdict {
        font-size: 0.77rem;
        color: var(--text-2);
        margin-top: 7px;
        font-weight: 500;
    }

    /* ── BIMBINGAN / MEETING ─────────────────────────────────────── */
    .mtg-empty {
        padding: 20px;
        text-align: center;
    }

    .mtg-empty i {
        font-size: 1.5rem;
        display: block;
        margin-bottom: 7px;
        color: var(--outline);
    }

    .mtg-empty p {
        font-size: 0.83rem;
        color: var(--outline);
        margin: 0;
    }

    /* ── KOTAK SARAN ────────────────────────────────────────────── */
    .saran-body {
        padding: 16px;
    }

    /* ── JADWAL MINGGUAN — no border between same-day subjects ────── */
    .mhs-table tbody tr.same-day-row td {
        border-top: none !important;
        padding-top: 2px;
    }

    .mhs-table tbody tr.same-day-has-next td {
        border-bottom: none !important;
    }

    .weekly-schedule-table tbody tr.day-start:not(.first-day) td {
        border-top: 1px solid rgba(0, 0, 0, 0.08) !important;
    }

    [data-theme="dark"] .weekly-schedule-table tbody tr.day-start:not(.first-day) td {
        border-top-color: var(--surface-container-high) !important;
    }

    .mhs-table .week-day-cell {
        border-right: none !important;
    }

    .weekly-schedule-table tbody tr:hover {
        background: transparent;
    }

    .weekly-schedule-table tbody tr:hover td:not(.week-day-cell) {
        background: var(--info-light);
    }

    /* ── ACHIEVEMENT LEVEL BAR (hover fill-up animation) ────────── */
    .ach-item {
        position: relative;
        overflow: hidden;
    }

    .ach-level-bar {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 2px;
        width: 0%;
        border-radius: 2px;
        transition: width 0.45s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .ach-item:hover .ach-level-bar {
        width: 100%;
    }

    .ach-level-bar.level-nasional {
        background: linear-gradient(90deg, #ffd700, #ffaa00);
    }

    .ach-level-bar.level-internasional {
        background: linear-gradient(90deg, #00b4d8, #0077b6);
    }

    .ach-level-bar.level-regional {
        background: linear-gradient(90deg, #7b2d8b, #c77dff);
    }

    .ach-level-bar.level-default {
        background: linear-gradient(90deg, var(--secondary), #0070ea);
    }
</style>
@endpush

@section('content')

{{-- ============================================================ --}}
{{-- HERO                                                          --}}
{{-- ============================================================ --}}
<div class="hero-strip" style="--grid-line-color:rgba(255,255,255,0.06);">
    <div class="hero-avatar">
        @if(auth()->user()->profile_photo)
        <img src="{{ asset('storage/profiles/' . auth()->user()->profile_photo) }}" alt="Avatar">
        @else
        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        @endif
    </div>
    <div class="hero-text">
        <div class="hero-greeting">Portal Akademik Mahasiswa</div>
        <div class="hero-name">{{ auth()->user()->name }}</div>
        <div class="hero-sub">Selamat datang — pantau jadwal, nilai, dan aktivitas akademik Anda</div>
    </div>
    <div class="hero-meta d-none d-md-block">
        <span class="date-lbl">Hari ini</span>
        <span class="date-val">{{ \Carbon\Carbon::now()->isoFormat('ddd, D MMM Y') }}</span>
    </div>
</div>

{{-- ============================================================ --}}
{{-- QUICK NAVIGATION                                              --}}
{{-- ============================================================ --}}
<div class="quick-nav">
    <a href="{{ route('mahasiswa.attendances.index') }}" class="quick-nav-item">
        <div class="quick-nav-icon" style="background:rgba(0,89,187,0.08);color:var(--secondary);">
            <i class="bi bi-calendar-check"></i>
        </div>
        Absensi
    </a>
    <a href="{{ route('mahasiswa.nilai.index') }}" class="quick-nav-item">
        <div class="quick-nav-icon" style="background:rgba(0,104,118,0.08);color:var(--cyan);">
            <i class="bi bi-bar-chart-line"></i>
        </div>
        Nilai
    </a>
    <a href="{{ route('mahasiswa.materials.index') }}" class="quick-nav-item">
        <div class="quick-nav-icon" style="background:rgba(0,165,80,0.08);color:var(--success);">
            <i class="bi bi-journal-text"></i>
        </div>
        Bahan Ajar
    </a>
    <a href="{{ route('mahasiswa.chats.index') }}" class="quick-nav-item">
        <div class="quick-nav-icon" style="background:rgba(103,80,164,0.08);color:var(--purple);">
            <i class="bi bi-chat-dots"></i>
        </div>
        Chat
    </a>
    <a href="{{ route('mahasiswa.submissions.index') }}" class="quick-nav-item">
        <div class="quick-nav-icon" style="background:rgba(138,95,0,0.08);color:var(--warning);">
            <i class="bi bi-envelope-paper"></i>
        </div>
        Surat
    </a>
</div>

{{-- ============================================================ --}}
{{-- MAIN GRID                                                     --}}
{{-- ============================================================ --}}
@php
$todayData = collect($weeklySchedules)->first(fn($d) => $d['date']->isToday());
@endphp

<div class="dash-layout">

    {{-- ══════════ KOLOM KIRI ══════════ --}}
    <div>

        {{-- 1. JADWAL HARI INI --}}
        <div class="mhs-card glass-panel" style="margin-bottom:18px;">
            <div class="sec-header">
                <h6 class="sec-title">
                    <span class="sec-icon" style="background:rgba(0,89,187,0.08);color:var(--secondary);">
                        <i class="bi bi-calendar3"></i>
                    </span>
                    Jadwal Hari Ini
                    <span class="mhs-badge primary"
                        style="font-size:0.58rem;">{{ \Carbon\Carbon::now()->format('d M') }}</span>
                </h6>
            </div>

            @if($todayData && $todayData['schedules']->isNotEmpty())
            <div class="schedule-timeline">
                @foreach($todayData['schedules'] as $schedule)
                @php
                $cancelled = $schedule->is_overridden && $schedule->override_status === 'cancelled';
                $changed = $schedule->is_overridden && $schedule->override_status !== 'cancelled';
                @endphp
                <div class="schedule-slot">
                    <div class="slot-time">
                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                        <div class="time-end">{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</div>
                    </div>
                    <div class="slot-dot">
                        <div class="slot-dot-circle"
                            style="{{ $cancelled ? 'background:var(--danger)' : ($changed ? 'background:var(--warning)' : '') }}">
                        </div>
                        @if(!$loop->last)<div class="slot-dot-line"></div>@endif
                    </div>
                    <div class="slot-body">
                        <div class="slot-subject {{ $cancelled ? 'cancelled' : '' }}">{{ $schedule->subject->name }}
                        </div>
                        <div class="slot-lecturer"><i class="bi bi-person me-1"></i>{{ $schedule->dosen->name }}</div>
                        <div class="slot-meta">
                            <span><i class="bi bi-geo-alt me-1"></i>{{ $schedule->room }}</span>
                        </div>
                        @if($schedule->is_overridden)
                        <span class="slot-chip {{ $cancelled ? 'cancelled' : 'changed' }}">
                            <i class="bi bi-{{ $cancelled ? 'x-circle' : 'exclamation-triangle' }}-fill"></i>
                            {{ $cancelled ? 'Dibatalkan' : 'Jadwal Berubah' }}
                        </span>
                        @if($schedule->override_note)
                        <div style="font-size:0.72rem;color:var(--text-2);font-style:italic;margin-top:4px;">
                            "{{ $schedule->override_note }}"</div>
                        @endif
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="mhs-empty" style="padding:24px 0;">
                <i class="bi bi-calendar-x"></i>
                <p>Tidak ada kelas hari ini.</p>
            </div>
            @endif
        </div>

        {{-- 2. JADWAL MINGGUAN --}}
        <div class="mhs-card glass-panel" style="margin-bottom:18px;">
            <div class="sec-header">
                <h6 class="sec-title">
                    <span class="sec-icon" style="background:rgba(0,89,187,0.08);color:var(--secondary);">
                        <i class="bi bi-calendar-week"></i>
                    </span>
                    Jadwal Mingguan
                </h6>
                <span class="mhs-badge muted">Minggu Ini</span>
            </div>
            <div style="overflow-x:auto;">
                <table class="mhs-table weekly-schedule-table">
                    <thead>
                        <tr>
                            <th>Hari</th>
                            <th>Mata Kuliah</th>
                            <th>Waktu</th>
                            <th>Ruang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $hasClasses = false; $visibleDayIndex = 0; @endphp
                        @foreach($weeklySchedules as $dayData)
                        @if($dayData['schedules']->isNotEmpty())
                        @php
                        $hasClasses = true;
                        $isToday = $dayData['date']->isToday();
                        $isFirstVisibleDay = $visibleDayIndex === 0;
                        $visibleDayIndex++;
                        @endphp
                        @foreach($dayData['schedules'] as $idx => $schedule)
                        @php
                        $sc = $schedule->is_overridden && $schedule->override_status === 'cancelled';
                        $sw = $schedule->is_overridden && $schedule->override_status !== 'cancelled';
                        $isSameDay = $idx > 0; // baris ke-2+ dari hari yang sama
                        $hasNextSameDay = $idx < count($dayData['schedules']) - 1;
                        @endphp
                        <tr
                            class="{{ $isToday ? 'week-today' : '' }} {{ $idx === 0 ? 'day-start' : '' }} {{ $isFirstVisibleDay ? 'first-day' : '' }} {{ $isSameDay ? 'same-day-row' : '' }} {{ $hasNextSameDay ? 'same-day-has-next' : '' }}">
                            @if($idx === 0)
                            <td rowspan="{{ count($dayData['schedules']) }}" class="week-day-cell"
                                style="vertical-align:top;padding-top:12px;">
                                <span
                                    style="font-weight:700;font-size:0.78rem;color:{{ $isToday ? 'var(--secondary)' : 'var(--text-2)' }};">{{ $dayData['day_name'] }}</span>
                                @if($isToday)<br><span class="mhs-badge primary"
                                    style="margin-top:4px;font-size:0.52rem;">Hari ini</span>@endif
                            </td>
                            @endif
                            <td style="{{ $isSameDay ? 'border-top:none;padding-top:2px;' : '' }}">
                                <span
                                    style="font-weight:600;font-size:0.84rem;display:block;margin-bottom:2px;{{ $sc ? 'text-decoration:line-through;color:var(--danger);' : '' }}">{{ $schedule->subject->name }}</span>
                                <span style="font-size:0.72rem;color:var(--text-3);"><i
                                        class="bi bi-person me-1"></i>{{ $schedule->dosen->name }}</span>
                                @if($sc)<span class="mhs-badge danger" style="margin-top:4px;">Batal</span>
                                @elseif($sw)<span class="mhs-badge warning" style="margin-top:4px;">Berubah</span>
                                @endif
                            </td>
                            <td
                                style="font-size:0.78rem;color:var(--text-2);white-space:nowrap;{{ $sc ? 'text-decoration:line-through;color:var(--danger);' : '' }}{{ $isSameDay ? 'border-top:none;padding-top:2px;' : '' }}">
                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}–{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                            </td>
                            <td
                                style="font-size:0.78rem;color:var(--text-2);{{ $isSameDay ? 'border-top:none;padding-top:2px;' : '' }}">
                                {{ $schedule->room }}
                            </td>
                        </tr>
                        @endforeach
                        @endif
                        @endforeach
                        @if(!$hasClasses)
                        <tr>
                            <td colspan="4" class="mhs-empty" style="padding:20px;">Belum ada jadwal minggu ini.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        {{-- 3. KESEMAPTAAN + PRESTASI (side by side) --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;margin-bottom:18px;">

            {{-- Kesemaptaan --}}
            <div class="mhs-card glass-panel">
                <div class="sec-header">
                    <h6 class="sec-title">
                        <span class="sec-icon" style="background:var(--danger-light);color:var(--danger);">
                            <i class="bi bi-heart-pulse"></i>
                        </span>
                        Kesemaptaan
                    </h6>
                </div>
                <div class="mhs-card-body">
                    @if($fitnessTests->isNotEmpty())
                    @php $grouped = $fitnessTests->groupBy('semester'); @endphp
                    <div class="tab-row" id="ft-tabs">
                        @foreach($grouped as $sem => $tests)
                        <button class="tab-pill {{ $loop->first ? 'active' : '' }}"
                            onclick="switchTab('ft','{{ $sem ?? 'lama' }}',this)" type="button">
                            {{ $sem ? 'Smt '.$sem : 'Lama' }}
                        </button>
                        @endforeach
                    </div>
                    @foreach($grouped as $sem => $tests)
                    <div id="ft-pane-{{ $sem ?? 'lama' }}" class="ft-pane"
                        style="{{ $loop->first ? '' : 'display:none;' }}">
                        @foreach($tests as $ft)
                        <div class="fit-entry">
                            <div class="fit-score-row">
                                <div>
                                    <div class="fit-score-big">{{ $ft->total_score ?? $ft->score }}</div>
                                    <div style="font-size:0.7rem;color:var(--outline);">Total Nilai</div>
                                </div>
                                <div style="text-align:right;">
                                    <span
                                        class="mhs-badge {{ str_contains($ft->status,'lulus') || $ft->status === 'passed' ? 'success' : 'danger' }}">
                                        {{ strtoupper(str_replace('_',' ',$ft->status)) }}
                                    </span>
                                    <div style="font-size:0.65rem;color:var(--outline);margin-top:4px;">
                                        <i
                                            class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($ft->test_date)->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                            @if($ft->total_score !== null)
                            <div class="fit-grid">
                                @foreach([
                                ['Lari', $ft->raw_lari.'m', $ft->nilai_lari],
                                [($ft->nilai_pull_up!==null?'Pull Up':'Chinning'),
                                $ft->raw_pull_up??$ft->raw_chinning??'-', $ft->nilai_pull_up??$ft->nilai_chinning??0],
                                ['Sit Up', $ft->raw_sit_up??'-', $ft->nilai_sit_up??0],
                                ['Push Up', $ft->raw_push_up??'-', $ft->nilai_push_up??0],
                                ['Shuttle', ($ft->raw_shuttle_run??'-').'s', $ft->nilai_shuttle_run??0],
                                ['Renang', ($ft->raw_renang??'-').'s', $ft->nilai_renang??0],
                                ] as [$lbl,$raw,$score])
                                <div class="fit-metric">
                                    <span class="fit-metric-lbl">{{ $lbl }}</span>
                                    <span class="fit-metric-val">{{ $raw }}</span>
                                    <span class="fit-metric-score {{ $score >= 60 ? 'ok' : 'fail' }}"> →
                                        {{ $score }}</span>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div style="display:flex;gap:6px;flex-wrap:wrap;">
                                <span class="mhs-badge muted">A: {{ $ft->score_a ?? '-' }}</span>
                                <span class="mhs-badge muted">B: {{ $ft->score_b ?? '-' }}</span>
                                <span class="mhs-badge muted">C: {{ $ft->score_c ?? '-' }}</span>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endforeach
                    @else
                    <div class="mhs-empty" style="padding:20px 0;">
                        <i class="bi bi-clipboard2-x"></i>
                        <p>Belum ada data uji fisik.</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Prestasi --}}
            <div class="mhs-card glass-panel">
                <div class="sec-header">
                    <h6 class="sec-title">
                        <span class="sec-icon" style="background:rgba(255,200,0,0.1);color:#b8860b;">
                            <i class="bi bi-trophy"></i>
                        </span>
                        Prestasi
                    </h6>
                </div>
                <div class="mhs-card-body">
                    @if($achievements->isNotEmpty())
                    @foreach($achievements as $ach)
                    @php
                    $lvl = strtolower($ach->level ?? '');
                    $barClass = str_contains($lvl,'nasional') ? 'level-nasional'
                    : (str_contains($lvl,'internasional') ? 'level-internasional'
                    : (str_contains($lvl,'regional') ? 'level-regional' : 'level-default'));
                    @endphp
                    <a href="javascript:void(0)" class="ach-item" onclick="showAchievementDash({{ $ach->id }})">
                        <div class="ach-icon">🏅</div>
                        <div style="flex:1;min-width:0;">
                            <h6>{{ $ach->title }}</h6>
                            <p>{{ \Illuminate\Support\Str::limit($ach->description, 55) }}</p>
                            <div style="display:flex;flex-wrap:wrap;gap:4px;">
                                @if($ach->level)<span class="mhs-badge purple"><i
                                        class="bi bi-bar-chart-steps me-1"></i>{{ $ach->level }}</span>@endif
                                <span class="mhs-badge muted"><i
                                        class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($ach->date)->format('d M Y') }}</span>
                                @if($ach->attachment)<span class="mhs-badge success"><i
                                        class="bi bi-paperclip me-1"></i>Lampiran</span>@endif
                            </div>
                        </div>
                        <i class="bi bi-chevron-right" style="color:var(--outline);font-size:0.7rem;flex-shrink:0;"></i>
                        <div class="ach-level-bar {{ $barClass }}"></div>
                    </a>
                    @endforeach
                    @else
                    <div class="mhs-empty" style="padding:20px 0;">
                        <i class="bi bi-award"></i>
                        <p>Belum ada catatan prestasi.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- 4. BIMBINGAN / WALI DOSEN --}}
        <div class="mhs-card glass-panel">
            <div class="sec-header">
                <h6 class="sec-title">
                    <span class="sec-icon" style="background:var(--success-light);color:var(--success);">
                        <i class="bi bi-people"></i>
                    </span>
                    Bimbingan / Wali Dosen
                </h6>
                <button class="mhs-btn mhs-btn-success mhs-btn-sm" onclick="openDashModal('dashModalMeeting')">
                    <i class="bi bi-plus-lg"></i> Ajukan
                </button>
            </div>
            @if($meetings->isNotEmpty())
            <div style="overflow-x:auto;">
                <table class="mhs-table">
                    <thead>
                        <tr>
                            <th style="padding-left:18px;">Tanggal</th>
                            <th>Dosen</th>
                            <th>Topik</th>
                            <th style="text-align:center;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($meetings as $mtg)
                        <tr>
                            <td style="padding-left:18px;font-size:0.78rem;">
                                {{ \Carbon\Carbon::parse($mtg->requested_date)->format('d M Y') }}
                            </td>
                            <td style="font-size:0.84rem;font-weight:600;">{{ $mtg->dosen->name }}</td>
                            <td style="font-size:0.78rem;color:var(--text-2);">{{ $mtg->topic }}</td>
                            <td style="text-align:center;">
                                @if($mtg->status === 'approved')
                                <span class="mhs-badge success">Disetujui</span>
                                @elseif($mtg->status === 'rejected')
                                <span class="mhs-badge danger">Ditolak</span>
                                @else
                                <span class="mhs-badge muted">Menunggu</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="mtg-empty">
                <i class="bi bi-calendar-plus"></i>
                <p>Belum ada pengajuan bimbingan.</p>
            </div>
            @endif
        </div>

    </div>{{-- END KOLOM KIRI --}}

    {{-- ══════════ KOLOM KANAN ══════════ --}}
    <div>

        {{-- IPK RING --}}
        @php
        $ipkVal = null;
        try {
        $avg = \App\Models\Grade::where('user_id', auth()->id())
        ->whereNotNull('grade_point')->avg('grade_point');
        if ($avg !== null) $ipkVal = round($avg, 2);
        } catch(\Exception $e) { $ipkVal = null; }
        @endphp

        @if($ipkVal !== null)
        <div class="mhs-card glass-panel" style="margin-bottom:16px;">
            <div class="sec-header">
                <h6 class="sec-title">
                    <span class="sec-icon" style="background:rgba(0,89,187,0.08);color:var(--secondary);">
                        <i class="bi bi-mortarboard"></i>
                    </span>
                    Indeks Prestasi
                </h6>
            </div>
            <div class="mhs-card-body ipk-wrap">
                <div style="position:relative;width:110px;height:110px;margin:0 auto 8px;">
                    <svg class="ipk-ring-svg" width="110" height="110" viewBox="0 0 110 110">
                        <circle class="ipk-ring-bg" cx="55" cy="55" r="46" />
                        <circle class="ipk-ring-fg" cx="55" cy="55" r="46" stroke-dasharray="{{ 2 * 3.14159 * 46 }}"
                            stroke-dashoffset="{{ 2 * 3.14159 * 46 * (1 - min($ipkVal/4, 1)) }}" />
                    </svg>
                    <div class="ipk-center">
                        <span class="ipk-val">{{ number_format($ipkVal, 2) }}</span>
                        <span class="ipk-lbl">IPK</span>
                    </div>
                </div>
                <div class="ipk-verdict">
                    @if($ipkVal >= 3.5) Dengan Pujian
                    @elseif($ipkVal >= 3.0) Sangat Memuaskan
                    @elseif($ipkVal >= 2.75) Memuaskan
                    @else Perlu Ditingkatkan
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- PELANGGARAN --}}
        @if($violations->isNotEmpty())
        <div class="violation-alert">
            <div class="violation-alert-head">
                <i class="bi bi-exclamation-octagon-fill"></i>
                Peringatan Pelanggaran
            </div>
            <div class="violation-body">
                @foreach($violations as $v)
                <div class="violation-item">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:3px;">
                        <div class="v-title">{{ $v->title }}</div>
                        <span style="font-weight:800;font-size:0.88rem;color:var(--danger);">{{ $v->point }} Poin</span>
                    </div>
                    <div class="v-desc">{{ $v->description }}</div>
                    <div class="v-meta"><i
                            class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($v->date)->format('d M Y') }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- UJIAN MENDATANG --}}
        <div class="mhs-card glass-panel" style="margin-bottom:16px;">
            <div class="sec-header">
                <h6 class="sec-title">
                    <span class="sec-icon" style="background:rgba(0,89,187,0.08);color:var(--secondary);">
                        <i class="bi bi-journal-check"></i>
                    </span>
                    Ujian Mendatang
                </h6>
            </div>
            <div class="mhs-card-body" style="padding:12px 18px;">
                @if($exams->isNotEmpty())
                @foreach($exams as $exam)
                <div class="exam-item">
                    <div class="exam-date-box">
                        <div class="eday">{{ \Carbon\Carbon::parse($exam->date)->format('d') }}</div>
                        <div class="emon">{{ \Carbon\Carbon::parse($exam->date)->format('M') }}</div>
                    </div>
                    <div class="exam-body">
                        <span class="mhs-badge cyan" style="margin-bottom:3px;">{{ strtoupper($exam->type) }}</span>
                        <h6>{{ $exam->subject->name }}</h6>
                        <div class="exam-meta">
                            <span><i
                                    class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($exam->start_time)->format('H:i') }}</span>
                            <span><i class="bi bi-geo-alt me-1"></i>{{ $exam->room }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="mhs-empty" style="padding:14px 0;">
                    <i class="bi bi-calendar-x"></i>
                    <p>Belum ada jadwal ujian.</p>
                </div>
                @endif
            </div>
        </div>

        {{-- PENGUMUMAN --}}
        <div class="mhs-card glass-panel" style="margin-bottom:16px;">
            <div class="sec-header">
                <h6 class="sec-title">
                    <span class="sec-icon" style="background:var(--success-light);color:var(--success);">
                        <i class="bi bi-megaphone"></i>
                    </span>
                    Pengumuman Prodi
                </h6>
            </div>
            <div class="mhs-card-body" style="padding:12px 18px;">
                @if(isset($announcements) && $announcements->isNotEmpty())
                @foreach($announcements as $ann)
                <a href="javascript:void(0)" class="ann-item"
                    onclick="showAnnouncement('{{ addslashes($ann->title) }}','{{ addslashes($ann->message) }}','{{ $ann->created_at->format('d M Y, H:i') }}')">
                    <h6>{{ $ann->title }}</h6>
                    <p>{{ \Illuminate\Support\Str::limit($ann->message, 70) }}</p>
                    <span class="ann-time"><i
                            class="bi bi-clock me-1"></i>{{ $ann->created_at->diffForHumans() }}</span>
                </a>
                @endforeach
                @else
                <div class="mhs-empty" style="padding:14px 0;">
                    <i class="bi bi-bell-slash"></i>
                    <p>Belum ada pengumuman.</p>
                </div>
                @endif
            </div>
        </div>

        {{-- KOTAK SARAN --}}
        <div class="mhs-card glass-panel">
            <div class="sec-header">
                <h6 class="sec-title">
                    <span class="sec-icon" style="background:rgba(0,89,187,0.08);color:var(--secondary);">
                        <i class="bi bi-chat-square-text"></i>
                    </span>
                    Kotak Saran Akademik
                </h6>
            </div>
            <div class="saran-body">
                <form action="{{ route('mahasiswa.dashboard.suggestion.store') }}" method="POST">
                    @csrf
                    <div class="mhs-form-group">
                        <label class="mhs-label">Kategori <span style="color:var(--danger);">*</span></label>
                        <select name="category" class="mhs-input" required>
                            <option value="">Pilih kategori...</option>
                            <option value="fasilitas">Fasilitas Kampus</option>
                            <option value="akademik">Layanan Akademik</option>
                            <option value="dosen">Kinerja Dosen</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="mhs-form-group">
                        <label class="mhs-label">Isi Saran <span style="color:var(--danger);">*</span></label>
                        <textarea name="content" class="mhs-input" rows="3"
                            placeholder="Tulis kritik & saran membangun di sini..." required></textarea>
                    </div>
                    <button type="submit" class="mhs-btn mhs-btn-primary mhs-btn-full">
                        <i class="bi bi-send"></i> Kirim Saran
                    </button>
                </form>
            </div>
        </div>

    </div>{{-- END KOLOM KANAN --}}
</div>

{{-- ============================================================ --}}
{{-- MODALS — Custom (bukan Bootstrap modal, untuk menghindari     --}}
{{-- bug backdrop yang mengunci halaman)                           --}}
{{-- ============================================================ --}}

{{-- Custom Modal Bimbingan --}}
<div class="dash-modal-overlay" id="dashModalMeeting" role="dialog" aria-modal="true">
    <div class="dash-modal-box">
        <form action="{{ route('mahasiswa.dashboard.meeting.store') }}" method="POST">
            @csrf
            <div class="dash-modal-header">
                <div class="dash-modal-title">
                    <i class="bi bi-calendar-plus" style="color:var(--success);"></i>
                    Ajukan Jadwal Bimbingan
                </div>
                <button type="button" class="dash-modal-close" onclick="closeDashModal('dashModalMeeting')"
                    aria-label="Tutup">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="dash-modal-body">
                <div class="mhs-form-group">
                    <label class="mhs-label">Pilih Dosen / Wali Dosen <span
                            style="color:var(--danger);">*</span></label>
                    <select name="dosen_id" class="mhs-input" required>
                        <option value="">Pilih Dosen...</option>
                        @foreach($dosens as $dsn)
                        <option value="{{ $dsn->id }}">{{ $dsn->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mhs-form-group">
                    <label class="mhs-label">Tanggal Pengajuan <span style="color:var(--danger);">*</span></label>
                    <input type="date" name="requested_date" class="mhs-input"
                        min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" required>
                    <div class="mhs-hint">Tanggal aktual dapat diubah oleh dosen saat persetujuan.</div>
                </div>
                <div class="mhs-form-group">
                    <label class="mhs-label">Topik Bimbingan <span style="color:var(--danger);">*</span></label>
                    <input type="text" name="topic" class="mhs-input" placeholder="Contoh: Konsultasi KRS / Tugas Akhir"
                        required>
                </div>
            </div>
            <div class="dash-modal-footer">
                <button type="button" class="mhs-btn mhs-btn-ghost"
                    onclick="closeDashModal('dashModalMeeting')">Batal</button>
                <button type="submit" class="mhs-btn mhs-btn-success">
                    <i class="bi bi-send"></i> Ajukan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Custom Modal Pengumuman --}}
<div class="dash-modal-overlay" id="dashModalAnnouncement" role="dialog" aria-modal="true">
    <div class="dash-modal-box modal-lg">
        <div class="dash-modal-header">
            <div class="dash-modal-title" id="dashAnnTitle">Pengumuman</div>
            <button type="button" class="dash-modal-close" onclick="closeDashModal('dashModalAnnouncement')"
                aria-label="Tutup">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="dash-modal-body">
            <p style="font-family:var(--font-label);font-size:0.66rem;color:var(--outline);margin-bottom:12px;"
                id="dashAnnDate"></p>
            <div style="background:var(--surface-container-low);border:1px solid var(--outline-variant);border-radius:var(--radius-md);padding:16px;white-space:pre-wrap;line-height:1.7;font-size:0.88rem;color:var(--on-surface);"
                id="dashAnnBody"></div>
        </div>
        <div class="dash-modal-footer">
            <button type="button" class="mhs-btn mhs-btn-ghost"
                onclick="closeDashModal('dashModalAnnouncement')">Tutup</button>
        </div>
    </div>
</div>

{{-- Custom Modal Prestasi --}}
<div class="dash-modal-overlay" id="dashModalAchievement" role="dialog" aria-modal="true">
    <div class="dash-modal-box modal-lg">
        <div class="dash-modal-header">
            <div class="dash-modal-title" id="dashAchTitle">Prestasi</div>
            <button type="button" class="dash-modal-close" onclick="closeDashModal('dashModalAchievement')"
                aria-label="Tutup">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="dash-modal-body">
            <div style="display:flex;gap:8px;margin-bottom:14px;flex-wrap:wrap;" id="dashAchBadges"></div>
            <div style="background:var(--surface-container-low);border:1px solid var(--outline-variant);border-radius:var(--radius-md);padding:16px;margin-bottom:14px;white-space:pre-wrap;line-height:1.7;font-size:0.88rem;color:var(--on-surface);"
                id="dashAchDesc"></div>
            <div id="dashAchAttachment"></div>
        </div>
        <div class="dash-modal-footer">
            <button type="button" class="mhs-btn mhs-btn-ghost"
                onclick="closeDashModal('dashModalAchievement')">Tutup</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // ── Show Announcement ───────────────────────────────────────────
    function showAnnouncement(title, message, date) {
        document.getElementById('dashAnnTitle').textContent = title;
        document.getElementById('dashAnnBody').textContent = message;
        document.getElementById('dashAnnDate').innerHTML = '<i class="bi bi-calendar3 me-1"></i>' + date;
        openDashModal('dashModalAnnouncement');
    }

    // ── Show Achievement ────────────────────────────────────────────
    @php
    $achievementsJson = $achievements->map(fn($a) => [
        'id' => $a->id,
        'title' => $a->title,
        'description' => $a->description,
        'level' => $a->level,
        'date' => \Carbon\Carbon::parse($a->date)->format('d M Y'),
        'attachment' => $a->attachment ? \Illuminate\Support\Facades\Storage::url($a->attachment) : null,
        'attachment_name' => $a->attachment ? basename($a->attachment) : null,
    ]);
    @endphp
    var achievementsData = @json($achievementsJson);

    function showAchievementDash(id) {
        var ach = achievementsData.find(function(a) {
            return a.id === id;
        });
        if (!ach) return;

        document.getElementById('dashAchTitle').textContent = ach.title;

        // Build badges
        var badges = '';
        if (ach.level) {
            badges += '<span class="mhs-badge purple"><i class="bi bi-bar-chart-steps me-1"></i>' + ach.level + '</span>';
        }
        badges += '<span class="mhs-badge muted"><i class="bi bi-calendar3 me-1"></i>' + ach.date + '</span>';
        document.getElementById('dashAchBadges').innerHTML = badges;

        document.getElementById('dashAchDesc').textContent = ach.description || 'Tidak ada deskripsi.';

        var att = document.getElementById('dashAchAttachment');
        att.innerHTML = ach.attachment ?
            '<a href="' + ach.attachment +
            '" target="_blank" download class="mhs-btn mhs-btn-success"><i class="bi bi-download me-1"></i>Download Lampiran (' +
            ach.attachment_name + ')</a>' :
            '<span style="font-size:0.8rem;color:var(--outline);"><i class="bi bi-x-circle me-1"></i>Tidak ada lampiran.</span>';

        openDashModal('dashModalAchievement');
    }

    // ── Fitness tab switcher ────────────────────────────────────────
    function switchTab(prefix, id, btn) {
        document.querySelectorAll('.ft-pane').forEach(function(el) {
            el.style.display = 'none';
        });
        document.querySelectorAll('#ft-tabs .tab-pill').forEach(function(b) {
            b.classList.remove('active');
        });
        var pane = document.getElementById(prefix + '-pane-' + id);
        if (pane) pane.style.display = '';
        btn.classList.add('active');
    }

    // ── IPK Ring — start from 0, animate to target on load ─────────
    document.addEventListener('DOMContentLoaded', function() {
        var ring = document.querySelector('.ipk-ring-fg');
        if (ring) {
            var target = parseFloat(ring.getAttribute('stroke-dashoffset'));
            var total = parseFloat(ring.getAttribute('stroke-dasharray'));
            ring.style.strokeDashoffset = total;
            setTimeout(function() {
                ring.style.strokeDashoffset = target;
            }, 450);
        }
    });
</script>
@endpush

@endsection
