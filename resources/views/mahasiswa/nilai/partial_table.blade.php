{{-- Partial view untuk data nilai per semester (via AJAX) --}}
@php
    $completedSubjects = $subjects->filter(fn($subject) => $subject->grades->isNotEmpty())->count();
    $totalSubjects = $subjects->count();
    $completionPercent = $totalSubjects > 0 ? round(($completedSubjects / $totalSubjects) * 100) : 0;
@endphp

<style>
    .transcript-results {
        display: grid;
        gap: 16px;
    }

    .grade-summary-grid {
        display: grid;
        grid-template-columns: 1.15fr 1fr 1fr;
        gap: 14px;
    }

    .grade-summary-card {
        position: relative;
        overflow: hidden;
        min-height: 132px;
        padding: 18px;
        border-radius: var(--radius-xl);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.18);
        box-shadow: 0 14px 34px rgba(0, 31, 63, 0.14);
    }

    .grade-summary-card::after {
        content: '';
        position: absolute;
        right: -42px;
        bottom: -58px;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.10);
        pointer-events: none;
    }

    .summary-ips {
        background: linear-gradient(135deg, #002b5f, #0059bb 58%, #0070ea);
    }

    .summary-ipk {
        background: linear-gradient(135deg, #005b72, #0086a8 58%, #00a0c7);
    }

    .summary-progress {
        background: rgba(255, 255, 255, 0.42);
        color: var(--on-surface);
        border-color: rgba(255, 255, 255, 0.62);
        backdrop-filter: blur(28px) saturate(175%);
        -webkit-backdrop-filter: blur(28px) saturate(175%);
    }

    [data-theme="dark"] .summary-progress {
        background: rgba(14, 20, 38, 0.48);
        border-color: rgba(104, 163, 255, 0.18);
    }

    .summary-label {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 11px;
        font-family: var(--font-label);
        font-size: 0.62rem;
        font-weight: 800;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        opacity: 0.72;
    }

    .summary-value {
        position: relative;
        z-index: 1;
        font-family: var(--font-display);
        font-size: 2.35rem;
        font-weight: 900;
        line-height: 1;
    }

    .summary-meta {
        position: relative;
        z-index: 1;
        margin-top: 8px;
        font-size: 0.75rem;
        opacity: 0.72;
    }

    .progress-ring {
        --percent: 0;
        width: 76px;
        height: 76px;
        display: grid;
        place-items: center;
        border-radius: 50%;
        margin-top: 2px;
        background:
            radial-gradient(circle closest-side, rgba(255, 255, 255, 0.82) 72%, transparent 73% 100%),
            conic-gradient(var(--secondary) calc(var(--percent) * 1%), rgba(0, 89, 187, 0.12) 0);
        font-family: var(--font-display);
        font-weight: 900;
        color: var(--secondary);
    }

    [data-theme="dark"] .progress-ring {
        background:
            radial-gradient(circle closest-side, rgba(14, 20, 38, 0.92) 72%, transparent 73% 100%),
            conic-gradient(var(--cyan) calc(var(--percent) * 1%), rgba(104, 163, 255, 0.14) 0);
        color: var(--cyan);
    }

    .transcript-alert {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        padding: 15px 16px;
        border-radius: var(--radius-lg);
        background: rgba(255, 246, 214, 0.72);
        border: 1px solid rgba(138, 95, 0, 0.20);
        color: var(--warning);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
    }

    .transcript-alert i {
        font-size: 1.08rem;
        margin-top: 1px;
    }

    .transcript-alert strong {
        display: block;
        margin-bottom: 3px;
        color: var(--on-surface);
        font-size: 0.84rem;
    }

    .transcript-alert span {
        display: block;
        color: var(--text-2);
        font-size: 0.78rem;
        line-height: 1.55;
    }

    .study-card {
        overflow: hidden;
        border-radius: var(--radius-xl);
        background: rgba(255, 255, 255, 0.42);
        border: 1px solid rgba(255, 255, 255, 0.62);
        backdrop-filter: blur(30px) saturate(175%);
        -webkit-backdrop-filter: blur(30px) saturate(175%);
        box-shadow: 0 10px 32px rgba(0, 31, 63, 0.08), inset 0 1px 0 rgba(255, 255, 255, 0.68);
    }

    [data-theme="dark"] .study-card {
        background: rgba(14, 20, 38, 0.48);
        border-color: rgba(104, 163, 255, 0.18);
    }

    .study-card-head {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        align-items: center;
        padding: 16px 18px;
        border-bottom: 1px solid var(--card-glass-border);
        background: rgba(255, 255, 255, 0.18);
    }

    .study-title {
        display: flex;
        align-items: center;
        gap: 9px;
        margin: 0;
        font-family: var(--font-display);
        font-size: 0.96rem;
        font-weight: 900;
        color: var(--on-surface);
    }

    .study-title span {
        width: 30px;
        height: 30px;
        display: grid;
        place-items: center;
        border-radius: 9px;
        background: var(--info-light);
        color: var(--secondary);
    }

    .transcript-table-wrap {
        overflow-x: auto;
    }

    .transcript-table {
        min-width: 820px;
    }

    .transcript-table th {
        padding-top: 12px;
        padding-bottom: 12px;
    }

    .transcript-table td {
        padding-top: 14px;
        padding-bottom: 14px;
    }

    .subject-cell {
        min-width: 260px;
    }

    .subject-name {
        display: block;
        margin-bottom: 4px;
        font-weight: 850;
        color: var(--on-surface);
    }

    .subject-meta {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        color: var(--text-3);
        font-size: 0.72rem;
    }

    .score-chip {
        display: inline-flex;
        min-width: 46px;
        justify-content: center;
        padding: 5px 10px;
        border-radius: 999px;
        background: rgba(0, 89, 187, 0.07);
        color: var(--text-1);
        font-size: 0.78rem;
        font-weight: 800;
    }

    .score-chip.muted {
        background: var(--surface-container);
        color: var(--text-3);
    }

    .score-chip.success {
        background: var(--success-light);
        color: var(--success);
    }

    .final-score {
        font-family: var(--font-display);
        font-size: 1rem;
        font-weight: 900;
        color: var(--on-surface);
    }

    .grade-badge {
        min-width: 46px;
        justify-content: center;
        font-size: 0.86rem !important;
        padding: 6px 12px !important;
    }

    .gp-text {
        margin-top: 4px;
        font-size: 0.68rem;
        color: var(--text-3);
    }

    .empty-row {
        padding: 46px 20px;
        text-align: center;
        color: var(--text-2);
    }

    @media (max-width: 900px) {
        .grade-summary-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="transcript-results">
    @if($isSemesterComplete)
    <div class="grade-summary-grid">
        <div class="grade-summary-card summary-ips">
            <div class="summary-label"><i class="bi bi-graph-up-arrow"></i> IPS Semester</div>
            <div class="summary-value">{{ number_format($ips, 2) }}</div>
            <div class="summary-meta">Semester {{ $semester }} | {{ $totalSksSemester }} SKS semester ini</div>
        </div>

        <div class="grade-summary-card summary-ipk">
            <div class="summary-label"><i class="bi bi-stars"></i> IPK Kumulatif</div>
            <div class="summary-value">{{ number_format($ipk, 2) }}</div>
            <div class="summary-meta">{{ $totalSksKumulatif }} SKS kumulatif tercatat</div>
        </div>

        <div class="grade-summary-card summary-progress">
            <div class="summary-label"><i class="bi bi-check2-circle"></i> Kelengkapan</div>
            <div style="display:flex;align-items:center;justify-content:space-between;gap:14px;">
                <div>
                    <div class="summary-value" style="font-size:1.75rem;color:var(--on-surface);">{{ $completedSubjects }}/{{ $totalSubjects }}</div>
                    <div class="summary-meta" style="color:var(--text-2);opacity:1;">Mata kuliah memiliki nilai</div>
                </div>
                <div class="progress-ring" style="--percent: {{ $completionPercent }};">{{ $completionPercent }}%</div>
            </div>
        </div>
    </div>
    @else
    <div class="transcript-alert">
        <i class="bi bi-info-circle-fill"></i>
        <div>
            <strong>Perhitungan IPS/IPK belum tersedia</strong>
            <span>Masih ada mata kuliah pada semester ini atau semester sebelumnya yang nilainya belum lengkap.</span>
        </div>
    </div>
    @endif

    <div class="study-card">
        <div class="study-card-head">
            <h6 class="study-title">
                <span><i class="bi bi-journal-check"></i></span>
                Hasil Studi Semester {{ $semester }}
            </h6>
            <span class="mhs-badge muted">{{ $completedSubjects }} dari {{ $totalSubjects }} lengkap</span>
        </div>

        <div class="transcript-table-wrap">
            <table class="mhs-table transcript-table">
                <thead>
                    <tr>
                        <th style="padding-left:20px;">Mata Kuliah</th>
                        <th style="text-align:center;">Kehadiran</th>
                        <th style="text-align:center;">Tugas</th>
                        <th style="text-align:center;">UTS</th>
                        <th style="text-align:center;">UAS</th>
                        <th style="text-align:center;">Akhir</th>
                        <th style="text-align:center;">Grade</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subjects as $subject)
                    @php $g = $subject->grades->first(); @endphp
                    <tr>
                        <td class="subject-cell" style="padding-left:20px;">
                            <span class="subject-name">{{ $subject->name }}</span>
                            <span class="subject-meta">
                                <span><i class="bi bi-hash"></i> {{ $subject->code ?? 'MK' }}</span>
                                <span><i class="bi bi-layers"></i> {{ $subject->sks ?? '-' }} SKS</span>
                            </span>
                        </td>

                        @if($g)
                        <td style="text-align:center;"><span class="score-chip">{{ $g->attendance ?? 0 }}/14</span></td>
                        <td style="text-align:center;"><span class="score-chip">{{ $g->tugas ?? 0 }}</span></td>
                        <td style="text-align:center;">
                            @php $utsValue = $g->remedial_uts !== null ? max($g->uts, $g->remedial_uts) : ($g->uts ?? 0); @endphp
                            <span class="score-chip {{ $g->remedial_uts !== null && $g->remedial_uts > $g->uts ? 'success' : '' }}">{{ $utsValue }}</span>
                            @if($g->remedial_uts !== null)
                            <div class="gp-text">Asli {{ $g->uts }}</div>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            @php $uasValue = $g->remedial_uas !== null ? max($g->uas, $g->remedial_uas) : ($g->uas ?? 0); @endphp
                            <span class="score-chip {{ $g->remedial_uas !== null && $g->remedial_uas > $g->uas ? 'success' : '' }}">{{ $uasValue }}</span>
                            @if($g->remedial_uas !== null)
                            <div class="gp-text">Asli {{ $g->uas }}</div>
                            @endif
                        </td>
                        <td style="text-align:center;"><span class="final-score">{{ $g->final_score ?? '-' }}</span></td>
                        <td style="text-align:center;">
                            @php
                                $gc = match($g->grade) {
                                    'A' => 'success',
                                    'B' => 'cyan',
                                    'C' => 'warning',
                                    'D' => 'danger',
                                    default => 'muted'
                                };
                            @endphp
                            <span class="mhs-badge {{ $gc }} grade-badge">{{ $g->grade ?? '-' }}</span>
                            <div class="gp-text">{{ number_format($g->grade_point ?? 0, 1) }} GP</div>
                        </td>
                        @else
                        <td style="text-align:center;"><span class="score-chip muted">-</span></td>
                        <td style="text-align:center;"><span class="score-chip muted">-</span></td>
                        <td style="text-align:center;"><span class="score-chip muted">-</span></td>
                        <td style="text-align:center;"><span class="score-chip muted">-</span></td>
                        <td style="text-align:center;"><span class="final-score" style="color:var(--text-3);">-</span></td>
                        <td style="text-align:center;"><span class="mhs-badge muted" style="opacity:.68;">Belum ada</span></td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-row">
                                <i class="bi bi-inbox" style="font-size:1.8rem;display:block;margin-bottom:8px;color:var(--outline);"></i>
                                Belum ada mata kuliah yang terdaftar untuk semester ini.
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
