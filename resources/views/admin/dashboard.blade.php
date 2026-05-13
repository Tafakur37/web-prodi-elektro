@extends('layouts.app')
@section('title', 'Admin Dashboard')

@push('styles')
<style>
    /* ================================================================
       ADMIN SUPER DASHBOARD — Premium Modular Design
    ================================================================ */

    .dashboard-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .dashboard-greeting h1 {
        font-size: 1.6rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .dashboard-greeting p {
        color: #64748b;
        font-size: 0.88rem;
        margin: 0;
    }

    .dashboard-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 18px;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }

    .btn-action-primary {
        background: linear-gradient(135deg, #6366f1, #818cf8);
        color: white;
        box-shadow: 0 4px 12px rgba(99,102,241,0.3);
    }

    .btn-action-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(99,102,241,0.4);
        color: white;
    }

    .btn-action-secondary {
        background: white;
        color: #6366f1;
        border: 1.5px solid #e0e7ff;
    }

    .btn-action-secondary:hover {
        background: #f0f1ff;
        border-color: #6366f1;
        color: #6366f1;
    }

    /* ── Stat Cards ── */
    .stat-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 1px 2px rgba(0,0,0,0.04);
        transition: all 0.2s ease;
        border: 1px solid rgba(0,0,0,0.04);
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: currentColor;
        opacity: 0.2;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }

    .stat-card-body {
        display: flex;
        align-items: flex-start;
        gap: 14px;
    }

    .stat-card-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
    }

    .stat-card-content {
        flex: 1;
        min-width: 0;
    }

    .stat-value {
        font-size: 1.8rem;
        font-weight: 800;
        color: #1e293b;
        line-height: 1.1;
    }

    .stat-title {
        font-size: 0.78rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 4px;
    }

    .stat-subtitle {
        font-size: 0.75rem;
        color: #94a3b8;
        margin-top: 2px;
    }

    .stat-trend {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-top: 6px;
        padding: 2px 8px;
        border-radius: 20px;
    }

    .trend-up {
        background: #dcfce7;
        color: #16a34a;
    }

    .trend-down {
        background: #fee2e2;
        color: #dc2626;
    }

    .stat-card-link {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 0.76rem;
        font-weight: 600;
        text-decoration: none;
        margin-top: 14px;
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
        opacity: 0.75;
        transition: opacity 0.15s;
    }

    .stat-card-link:hover { opacity: 1; }

    /* ── Widget Cards ── */
    .widgets-grid {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .widget-col-4  { grid-column: span 4; }
    .widget-col-6  { grid-column: span 6; }
    .widget-col-8  { grid-column: span 8; }
    .widget-col-12 { grid-column: span 12; }

    @media (max-width: 1200px) {
        .widget-col-4  { grid-column: span 6; }
    }

    @media (max-width: 900px) {
        .widgets-grid { grid-template-columns: 1fr; }
        .widget-col-4,
        .widget-col-6,
        .widget-col-8,
        .widget-col-12 { grid-column: span 1; }
        .stat-cards-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 500px) {
        .stat-cards-grid { grid-template-columns: 1fr; }
    }

    .widget-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        border: 1px solid rgba(0,0,0,0.04);
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .widget-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px 14px;
        border-bottom: 1px solid #f1f5f9;
        flex-shrink: 0;
    }

    .widget-title {
        font-size: 0.88rem;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .widget-title i {
        color: #6366f1;
        font-size: 1rem;
    }

    .widget-header-link {
        font-size: 0.78rem;
        font-weight: 600;
        color: #6366f1;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 3px;
        opacity: 0.8;
        transition: opacity 0.15s;
    }

    .widget-header-link:hover { opacity: 1; color: #6366f1; }

    .widget-body {
        padding: 4px 0;
        flex: 1;
        overflow: hidden;
    }

    .widget-empty {
        text-align: center;
        padding: 32px 16px;
        color: #94a3b8;
    }

    .widget-empty i {
        font-size: 2rem;
        opacity: 0.4;
        display: block;
        margin-bottom: 8px;
    }

    .widget-empty p {
        font-size: 0.82rem;
        margin: 0;
    }

    /* ── Recent Items ── */
    .recent-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 20px;
        border-bottom: 1px solid #f8fafc;
        transition: background 0.15s;
    }

    .recent-item:last-child { border-bottom: none; }

    .recent-item.clickable { cursor: pointer; }

    .recent-item.clickable:hover { background: #f8fafc; }

    .recent-item-left {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .recent-avatar {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .recent-title {
        font-size: 0.84rem;
        font-weight: 600;
        color: #1e293b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px;
    }

    .recent-sub {
        font-size: 0.75rem;
        color: #94a3b8;
        margin-top: 1px;
    }

    .recent-item-right {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 4px;
        flex-shrink: 0;
        margin-left: 8px;
    }

    .recent-badge {
        font-size: 0.68rem;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 20px;
        white-space: nowrap;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .recent-time {
        font-size: 0.7rem;
        color: #cbd5e1;
    }

    /* ── Activity Feed ── */
    .activity-feed {
        padding: 8px 0;
    }

    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 8px 20px;
        position: relative;
    }

    .activity-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #6366f1;
        flex-shrink: 0;
        margin-top: 5px;
        position: relative;
    }

    .activity-dot::before {
        content: '';
        position: absolute;
        top: 8px;
        left: 3px;
        width: 1px;
        height: 28px;
        background: #e2e8f0;
    }

    .activity-item:last-child .activity-dot::before { display: none; }

    .activity-content {
        flex: 1;
        padding-bottom: 8px;
    }

    .activity-text {
        font-size: 0.81rem;
        color: #475569;
        line-height: 1.4;
    }

    .activity-text strong {
        color: #1e293b;
        font-weight: 600;
    }

    .activity-time {
        font-size: 0.72rem;
        color: #94a3b8;
        margin-top: 3px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* ── Cohort Chart ── */
    .cohort-list {
        padding: 8px 20px;
    }

    .cohort-row {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 6px 0;
    }

    .cohort-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #475569;
        width: 60px;
        flex-shrink: 0;
    }

    .cohort-bar-wrap {
        flex: 1;
        background: #f1f5f9;
        border-radius: 4px;
        height: 8px;
        overflow: hidden;
    }

    .cohort-bar {
        height: 100%;
        background: linear-gradient(90deg, #6366f1, #818cf8);
        border-radius: 4px;
        transition: width 0.6s ease;
    }

    .cohort-count {
        font-size: 0.78rem;
        font-weight: 700;
        color: #6366f1;
        width: 30px;
        text-align: right;
        flex-shrink: 0;
    }

    /* ── Quick Actions ── */
    .quick-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        padding: 16px;
    }

    .quick-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 16px 10px;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.2s;
        font-size: 0.78rem;
        font-weight: 600;
        text-align: center;
        border: 1.5px solid transparent;
    }

    .quick-btn i {
        font-size: 1.4rem;
    }

    .quick-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.1);
    }

    .quick-btn-1 { background: #ede9fe; color: #6d28d9; border-color: #ddd6fe; }
    .quick-btn-2 { background: #dbeafe; color: #1d4ed8; border-color: #bfdbfe; }
    .quick-btn-3 { background: #dcfce7; color: #15803d; border-color: #bbf7d0; }
    .quick-btn-4 { background: #fef3c7; color: #b45309; border-color: #fde68a; }
    .quick-btn-5 { background: #fee2e2; color: #b91c1c; border-color: #fecaca; }
    .quick-btn-6 { background: #f0f9ff; color: #0369a1; border-color: #bae6fd; }

    /* ── Announcement Cards ── */
    .announcement-list { padding: 8px 0; }

    .announcement-item {
        padding: 12px 20px;
        border-bottom: 1px solid #f8fafc;
    }

    .announcement-item:last-child { border-bottom: none; }

    .announcement-title {
        font-size: 0.84rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 3px;
    }

    .announcement-meta {
        font-size: 0.73rem;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* ── Welcome Banner ── */
    .welcome-banner {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #6366f1 100%);
        border-radius: 20px;
        padding: 28px 32px;
        color: white;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
    }

    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -40%;
        right: -5%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.06);
        border-radius: 50%;
    }

    .welcome-banner::after {
        content: '';
        position: absolute;
        bottom: -60%;
        right: 10%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%;
    }

    .welcome-banner h2 {
        font-size: 1.4rem;
        font-weight: 800;
        margin-bottom: 6px;
    }

    .welcome-banner p {
        font-size: 0.88rem;
        opacity: 0.85;
        margin: 0;
    }

    .welcome-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255,255,255,0.18);
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
        margin-bottom: 12px;
        backdrop-filter: blur(4px);
    }

    .welcome-stats {
        display: flex;
        gap: 24px;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    .welcome-stat {
        display: flex;
        flex-direction: column;
    }

    .welcome-stat-val {
        font-size: 1.6rem;
        font-weight: 800;
        line-height: 1;
    }

    .welcome-stat-label {
        font-size: 0.73rem;
        opacity: 0.75;
        margin-top: 3px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>
@endpush

@section('content')

{{-- Welcome Banner --}}
<div class="welcome-banner">
    <div class="welcome-badge">
        <i class="bi bi-shield-fill-check"></i>
        ADMIN SUPER DASHBOARD
    </div>
    <h2>Selamat datang, {{ auth()->user()->name }} 👋</h2>
    <p>Kelola seluruh sistem SIMelek dari sini. Semua fitur terpusat untuk kemudahan administrasi.</p>
    <div class="welcome-stats">
        <div class="welcome-stat">
            <span class="welcome-stat-val">{{ $totalMahasiswa }}</span>
            <span class="welcome-stat-label">Mahasiswa</span>
        </div>
        <div class="welcome-stat">
            <span class="welcome-stat-val">{{ $totalDosen }}</span>
            <span class="welcome-stat-label">Dosen</span>
        </div>
        <div class="welcome-stat">
            <span class="welcome-stat-val">{{ $totalStaff ?? 0 }}</span>
            <span class="welcome-stat-label">Staff</span>
        </div>
        <div class="welcome-stat">
            <span class="welcome-stat-val">{{ $activitiesToday }}</span>
            <span class="welcome-stat-label">Aktivitas Hari Ini</span>
        </div>
    </div>
</div>

{{-- ── STAT CARDS ──────────────────────────────────────────────────── --}}
<div class="stat-cards-grid">
    <x-dashboard.stat-card
        title="Total Mahasiswa"
        :value="$totalMahasiswa"
        icon="bi-mortarboard-fill"
        color="#6366f1"
        subtitle="Terdaftar aktif"
        :link="route('staff.students.index')"
    />
    <x-dashboard.stat-card
        title="Total Dosen"
        :value="$totalDosen"
        icon="bi-person-badge-fill"
        color="#0ea5e9"
        subtitle="Pengajar aktif"
    />
    <x-dashboard.stat-card
        title="Staff & Admin"
        :value="$totalStaff ?? 0"
        icon="bi-people-fill"
        color="#f59e0b"
        subtitle="Tenaga kependidikan"
        :link="route('admin.users.index')"
    />
    <x-dashboard.stat-card
        title="Absensi Hari Ini"
        :value="$absensiToday ?? 0"
        icon="bi-clipboard-check-fill"
        color="#10b981"
        subtitle="{{ now()->format('d M Y') }}"
    />
    <x-dashboard.stat-card
        title="Aktivitas Hari Ini"
        :value="$activitiesToday"
        icon="bi-activity"
        color="#8b5cf6"
        subtitle="Total log sistem"
        :link="route('admin.logs.index')"
    />
    <x-dashboard.stat-card
        title="Login Hari Ini"
        :value="$loginsToday"
        icon="bi-box-arrow-in-right"
        color="#ec4899"
        subtitle="Sesi aktif hari ini"
    />
</div>

{{-- ── ROW 1: Quick Actions + Announcements + Distribusi Cohort ─────── --}}
<div class="widgets-grid">

    {{-- Quick Actions --}}
    <div class="widget-col-4">
        <div class="widget-card">
            <div class="widget-header">
                <div class="widget-title">
                    <i class="bi bi-lightning-charge-fill"></i>
                    Aksi Cepat
                </div>
            </div>
            <div class="quick-actions">
                <a href="{{ route('admin.users.create') }}" class="quick-btn quick-btn-1">
                    <i class="bi bi-person-plus-fill"></i>
                    Tambah User
                </a>
                <a href="{{ route('admin.schedules.index') }}" class="quick-btn quick-btn-2">
                    <i class="bi bi-calendar-plus"></i>
                    Jadwal
                </a>
                <a href="{{ route('admin.documents.index') }}" class="quick-btn quick-btn-3">
                    <i class="bi bi-envelope-paper-fill"></i>
                    Surat
                </a>
                <a href="{{ route('admin.materials.index') }}" class="quick-btn quick-btn-4">
                    <i class="bi bi-journal-plus"></i>
                    Bahan Ajar
                </a>
                <a href="{{ route('staff.violations.index') }}" class="quick-btn quick-btn-5">
                    <i class="bi bi-exclamation-octagon-fill"></i>
                    Pelanggaran
                </a>
                <a href="{{ route('admin.logs.index') }}" class="quick-btn quick-btn-6">
                    <i class="bi bi-clock-history"></i>
                    Log Sistem
                </a>
            </div>
        </div>
    </div>

    {{-- Pengumuman Terbaru --}}
    <div class="widget-col-4">
        <div class="widget-card">
            <div class="widget-header">
                <div class="widget-title">
                    <i class="bi bi-megaphone-fill"></i>
                    Pengumuman Terbaru
                </div>
                <a href="{{ route('staff.announcements.index') }}" class="widget-header-link">
                    Kelola <i class="bi bi-chevron-right"></i>
                </a>
            </div>
            <div class="announcement-list">
                @forelse($recentAnnouncements ?? [] as $ann)
                    <div class="announcement-item">
                        <div class="announcement-title">{{ Str::limit($ann->title ?? 'Tanpa Judul', 50) }}</div>
                        <div class="announcement-meta">
                            <i class="bi bi-clock"></i>
                            {{ optional($ann->created_at)->diffForHumans() ?? '-' }}
                        </div>
                    </div>
                @empty
                    <div class="widget-empty">
                        <i class="bi bi-megaphone"></i>
                        <p>Belum ada pengumuman.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Distribusi Mahasiswa per Angkatan --}}
    <div class="widget-col-4">
        <div class="widget-card">
            <div class="widget-header">
                <div class="widget-title">
                    <i class="bi bi-bar-chart-fill"></i>
                    Mahasiswa per Angkatan
                </div>
            </div>
            <div class="cohort-list">
                @php
                    $maxCohort = ($mahasiswaPerCohort ?? collect())->max('total') ?: 1;
                @endphp
                @forelse($mahasiswaPerCohort ?? [] as $cohort)
                    <div class="cohort-row">
                        <span class="cohort-label">{{ $cohort->cohort ?? '-' }}</span>
                        <div class="cohort-bar-wrap">
                            <div class="cohort-bar" style="width: {{ round(($cohort->total / $maxCohort) * 100) }}%"></div>
                        </div>
                        <span class="cohort-count">{{ $cohort->total }}</span>
                    </div>
                @empty
                    <div class="widget-empty">
                        <i class="bi bi-people"></i>
                        <p>Data angkatan belum tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>

{{-- ── ROW 2: Surat Terbaru + Pelanggaran Terbaru ─────────────────── --}}
<div class="widgets-grid">

    {{-- Surat/Pengajuan Terbaru --}}
    <div class="widget-col-6">
        <x-dashboard.recent-list
            title="Surat & Pengajuan Terbaru"
            icon="bi-envelope-paper-fill"
            :link="route('admin.documents.index')"
            linkText="Kelola Surat"
            emptyMsg="Belum ada pengajuan surat."
            :items="($recentDocuments ?? collect())->map(fn($d) => [
                'title'      => $d->user->name ?? 'Unknown',
                'subtitle'   => Str::limit($d->title ?? $d->subject ?? 'Pengajuan Surat', 40),
                'icon'       => 'bi-envelope-fill',
                'color'      => '#6366f1',
                'badge'      => ucfirst($d->status ?? 'pending'),
                'badgeColor' => match($d->status ?? 'pending') {
                    'approved' => '#10b981',
                    'rejected' => '#ef4444',
                    default    => '#f59e0b',
                },
                'time'       => optional($d->created_at)->format('d M'),
            ])->toArray()"
        />
    </div>

    {{-- Pelanggaran Terbaru --}}
    <div class="widget-col-6">
        <x-dashboard.recent-list
            title="Pelanggaran Terbaru"
            icon="bi-exclamation-octagon-fill"
            :link="route('staff.violations.index')"
            linkText="Kelola Pelanggaran"
            emptyMsg="Tidak ada pelanggaran tercatat."
            :items="($recentViolations ?? collect())->map(fn($v) => [
                'title'      => $v->user->name ?? 'Unknown',
                'subtitle'   => Str::limit($v->description ?? $v->type ?? '-', 40),
                'icon'       => 'bi-exclamation-circle-fill',
                'color'      => '#ef4444',
                'badge'      => $v->points ? $v->points . ' poin' : '-',
                'badgeColor' => '#ef4444',
                'time'       => optional($v->created_at)->format('d M'),
            ])->toArray()"
        />
    </div>

</div>

{{-- ── ROW 3: Log Aktivitas Sistem ─────────────────────────────────── --}}
<div class="widgets-grid">
    <div class="widget-col-12">
        <x-dashboard.activity-feed
            :activities="$activities ?? collect()"
            :limit="8"
            :link="route('admin.logs.index')"
        />
    </div>
</div>

@endsection
