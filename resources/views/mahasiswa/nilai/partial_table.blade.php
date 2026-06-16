{{-- Partial view untuk data nilai per semester (via AJAX) --}}
@if($isSemesterComplete)
<div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:20px;">
    <div style="background:linear-gradient(135deg,var(--primary),#0080ff);border-radius:var(--radius-xl);padding:18px 20px;color:#fff;border:1px solid rgba(0,102,255,0.3);box-shadow:0 8px 24px rgba(0,102,255,0.2);">
        <div style="font-size:0.65rem;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;opacity:.75;margin-bottom:6px;">Indeks Prestasi Semester (IPS)</div>
        <div style="font-size:2.2rem;font-weight:800;font-family:var(--font-display);line-height:1;">{{ number_format($ips, 2) }}</div>
        <div style="font-size:0.72rem;opacity:.65;margin-top:4px;">Semester {{ $semester }} &bull; Total {{ $totalSksSemester }} SKS</div>
    </div>
    <div style="background:linear-gradient(135deg,#0099dd,var(--cyan));border-radius:var(--radius-xl);padding:18px 20px;color:#fff;border:1px solid rgba(0,198,255,0.3);box-shadow:0 8px 24px rgba(0,198,255,0.2);">
        <div style="font-size:0.65rem;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;opacity:.75;margin-bottom:6px;">Indeks Prestasi Kumulatif (IPK)</div>
        <div style="font-size:2.2rem;font-weight:800;font-family:var(--font-display);line-height:1;">{{ number_format($ipk, 2) }}</div>
        <div style="font-size:0.72rem;opacity:.65;margin-top:4px;">Total {{ $totalSksKumulatif }} SKS Lulus</div>
    </div>
</div>
@else
<div class="mhs-alert warning" style="margin-bottom:16px;">
    <i class="bi bi-info-circle-fill"></i>
    IPS dan IPK belum dapat dihitung karena masih ada mata kuliah yang nilainya belum lengkap pada semester ini atau sebelumnya.
</div>
@endif

<div style="font-family:var(--font-display);font-weight:700;font-size:0.9rem;color:var(--text-1);margin-bottom:12px;display:flex;align-items:center;gap:8px;">
    <span style="width:4px;height:18px;background:var(--primary);border-radius:2px;display:inline-block;"></span>
    Hasil Studi Semester {{ $semester }}
</div>

<div class="mhs-card">
    <div style="overflow-x:auto;">
        <table class="mhs-table">
            <thead>
                <tr>
                    <th style="padding-left:20px;">Mata Kuliah</th>
                    <th style="text-align:center;">Kehadiran</th>
                    <th style="text-align:center;">Tugas</th>
                    <th style="text-align:center;">UTS</th>
                    <th style="text-align:center;">UAS</th>
                    <th style="text-align:center;">Angka Akhir</th>
                    <th style="text-align:center;">Grade</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subjects as $subject)
                @php $g = $subject->grades->first(); @endphp
                <tr>
                    <td style="padding-left:20px;">
                        <span style="font-weight:700;display:block;color:var(--text-1);">{{ $subject->name }}</span>
                        <span style="font-size:0.72rem;color:var(--text-3);">{{ $subject->code ?? 'MK' }} &bull; {{ $subject->sks ?? '-' }} SKS</span>
                    </td>

                    @if($g)
                    <td style="text-align:center;font-size:0.84rem;">{{ $g->attendance ?? 0 }}/14</td>
                    <td style="text-align:center;font-weight:600;">{{ $g->tugas ?? 0 }}</td>
                    <td style="text-align:center;">
                        <span style="font-weight:600;{{ $g->remedial_uts !== null && $g->remedial_uts > $g->uts ? 'color:var(--success);' : '' }}">
                            {{ $g->remedial_uts !== null ? max($g->uts, $g->remedial_uts) : ($g->uts ?? 0) }}
                        </span>
                        @if($g->remedial_uts !== null)
                        <br><span style="font-size:0.68rem;color:var(--text-3);">(Asli: {{ $g->uts }})</span>
                        @endif
                    </td>
                    <td style="text-align:center;">
                        <span style="font-weight:600;{{ $g->remedial_uas !== null && $g->remedial_uas > $g->uas ? 'color:var(--success);' : '' }}">
                            {{ $g->remedial_uas !== null ? max($g->uas, $g->remedial_uas) : ($g->uas ?? 0) }}
                        </span>
                        @if($g->remedial_uas !== null)
                        <br><span style="font-size:0.68rem;color:var(--text-3);">(Asli: {{ $g->uas }})</span>
                        @endif
                    </td>
                    <td style="text-align:center;font-weight:700;font-size:0.95rem;">{{ $g->final_score ?? '-' }}</td>
                    <td style="text-align:center;">
                        @php
                        $gc = match($g->grade) {
                            'A' => 'success', 'B' => 'cyan',
                            'C' => 'warning', 'D' => 'danger',
                            default => 'muted'
                        };
                        @endphp
                        <span class="mhs-badge {{ $gc }}" style="font-size:0.8rem;padding:5px 12px;">{{ $g->grade ?? '-' }}</span>
                        <div style="font-size:0.68rem;color:var(--text-3);margin-top:3px;">{{ number_format($g->grade_point ?? 0, 1) }} GP</div>
                    </td>
                    @else
                    <td style="text-align:center;color:var(--text-3);">-</td>
                    <td style="text-align:center;color:var(--text-3);">-</td>
                    <td style="text-align:center;color:var(--text-3);">-</td>
                    <td style="text-align:center;color:var(--text-3);">-</td>
                    <td style="text-align:center;color:var(--text-3);">-</td>
                    <td style="text-align:center;"><span class="mhs-badge muted" style="opacity:.5;">KOSONG</span></td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="mhs-empty" style="padding:40px;">
                            <i class="bi bi-inbox"></i>
                            <p>Belum ada mata kuliah yang terdaftar untuk semester ini.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
