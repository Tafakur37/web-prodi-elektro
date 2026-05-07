<div class="table-responsive border rounded-3 mb-4">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light text-uppercase small text-muted">
            <tr>
                <th class="py-3 px-3 text-start">Mata Kuliah</th>
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
                <td class="px-3 py-3">
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

@if($subjects->count() > 0)
    @if($isSemesterComplete)
    <div class="row g-3">
        <div class="col-md-6">
            <div class="card border-0 bg-primary bg-opacity-10 rounded-4 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 50px; height: 50px;">
                        <i class="bi bi-graph-up fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-bold text-uppercase">Indeks Prestasi Semester (IPS)</div>
                        <div class="fs-3 fw-bold text-primary">{{ number_format($ips, 2) }}</div>
                        <div class="small text-muted">Semester {{ $semester }} &bull; Total {{ $totalSksSemester }} SKS</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 bg-info bg-opacity-10 rounded-4 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 50px; height: 50px;">
                        <i class="bi bi-award fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-bold text-uppercase">Indeks Prestasi Kumulatif (IPK)</div>
                        <div class="fs-3 fw-bold text-info">{{ number_format($ipk, 2) }}</div>
                        <div class="small text-muted">Total {{ $totalSksKumulatif }} SKS Kumulatif</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-warning border-0 shadow-sm rounded-4 mb-0">
        <i class="bi bi-info-circle-fill me-2"></i> IPS dan IPK belum dapat dihitung karena masih ada mata kuliah yang nilainya belum lengkap pada semester ini atau sebelumnya.
    </div>
    @endif
@endif
