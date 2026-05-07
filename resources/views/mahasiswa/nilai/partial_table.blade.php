@if($isSemesterComplete)
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card bg-primary text-white shadow-sm border-0 rounded-4">
            <div class="card-body p-4">
                <h6 class="text-white-50 mb-1 fw-bold text-uppercase" style="letter-spacing: 1px;">Indeks Prestasi Semester (IPS)</h6>
                <h2 class="fw-bold mb-0 display-5">{{ number_format($ips, 2) }}</h2>
                <small class="text-white-50">Semester {{ $semester }} &bull; Total {{ $totalSksSemester }} SKS</small>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-info text-dark shadow-sm border-0 rounded-4">
            <div class="card-body p-4">
                <h6 class="text-muted mb-1 fw-bold text-uppercase" style="letter-spacing: 1px;">Indeks Prestasi Kumulatif (IPK)</h6>
                <h2 class="fw-bold mb-0 display-5">{{ number_format($ipk, 2) }}</h2>
                <small class="text-muted">Total Keseluruhan {{ $totalSksKumulatif }} SKS Lulus</small>
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-warning border-0 shadow-sm rounded-4 mb-4">
    <i class="bi bi-info-circle-fill me-2"></i> IPS dan IPK belum dapat dihitung karena masih ada mata kuliah yang nilainya belum lengkap pada semester ini atau sebelumnya.
</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0 text-dark border-start border-4 border-primary ps-3">Hasil Studi Semester {{ $semester }}</h5>
</div>

<div class="table-responsive rounded-4 border">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light text-uppercase small text-muted">
            <tr>
                <th class="py-3 px-4">Mata Kuliah</th>
                <th class="py-3 text-center">Kehadiran</th>
                <th class="py-3 text-center">Tugas</th>
                <th class="py-3 text-center">UTS</th>
                <th class="py-3 text-center">UAS</th>
                <th class="py-3 text-center">Angka Akhir</th>
                <th class="py-3 text-center bg-primary-subtle text-primary">Grade Akhir</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subjects as $subject)
            @php
                $g = $subject->grades->first();
            @endphp
            <tr>
                <td class="px-4 py-3">
                    <span class="fw-bold d-block text-dark">{{ $subject->name }}</span>
                    <small class="text-muted">{{ $subject->code ?? 'MK' }} | {{ $subject->sks ?? '-' }} SKS</small>
                </td>
                
                @if($g)
                    <td class="text-center">{{ $g->attendance ?? 0 }}/14</td>
                    <td class="text-center">{{ $g->tugas ?? 0 }}</td>
                    <td class="text-center">
                        <span class="fw-bold {{ $g->remedial_uts !== null && $g->remedial_uts > $g->uts ? 'text-success' : '' }}">
                            {{ $g->remedial_uts !== null ? max($g->uts, $g->remedial_uts) : ($g->uts ?? 0) }}
                        </span>
                        @if($g->remedial_uts !== null)
                            <br><small class="text-muted" style="font-size: 0.7rem;">(Asli: {{ $g->uts }})</small>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="fw-bold {{ $g->remedial_uas !== null && $g->remedial_uas > $g->uas ? 'text-success' : '' }}">
                            {{ $g->remedial_uas !== null ? max($g->uas, $g->remedial_uas) : ($g->uas ?? 0) }}
                        </span>
                        @if($g->remedial_uas !== null)
                            <br><small class="text-muted" style="font-size: 0.7rem;">(Asli: {{ $g->uas }})</small>
                        @endif
                    </td>
                    <td class="text-center fw-bold">{{ $g->final_score ?? '-' }}</td>
                    <td class="text-center bg-light">
                        @php
                            $badgeClass = match($g->grade) {
                                'A' => 'bg-success',
                                'B' => 'bg-info text-dark',
                                'C' => 'bg-warning text-dark',
                                'D' => 'bg-danger',
                                default => 'bg-secondary'
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }} fs-6 px-3 py-2 rounded-pill shadow-sm">{{ $g->grade ?? '-' }}</span>
                        <div class="small text-muted mt-1">{{ number_format($g->grade_point ?? 0, 1) }} GP</div>
                    </td>
                @else
                    <td class="text-center text-muted">-</td>
                    <td class="text-center text-muted">-</td>
                    <td class="text-center text-muted">-</td>
                    <td class="text-center text-muted">-</td>
                    <td class="text-center text-muted">-</td>
                    <td class="text-center bg-light">
                        <span class="badge bg-secondary fs-6 px-3 py-2 rounded-pill shadow-sm opacity-50">KOSONG</span>
                    </td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-5 text-muted">
                    <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                    Belum ada mata kuliah yang terdaftar untuk semester ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
