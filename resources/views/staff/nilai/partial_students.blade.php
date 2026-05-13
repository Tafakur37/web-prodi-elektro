<div class="table-responsive">
    <table class="table table-hover align-middle border">
        <thead class="table-dark">
            <tr>
                <th rowspan="2" class="align-middle">Nama Mahasiswa</th>
                <th rowspan="2" class="align-middle text-center" width="80">Tugas</th>
                <th colspan="2" class="text-center bg-primary">UTS</th>
                <th colspan="2" class="text-center bg-info text-dark">UAS</th>
                <th rowspan="2" class="align-middle text-center" width="80">Hadir</th>
                <th rowspan="2" class="align-middle text-center" width="80">Grade</th>
            </tr>
            <tr>
                <th class="text-center" width="100">Asli</th>
                <th class="text-center" width="100">Remidi</th>
                <th class="text-center" width="100">Asli</th>
                <th class="text-center" width="100">Remidi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $s)
            @php $grade = $s->grades->first(); @endphp
            <tr>
                <td class="text-start">
                    <div class="fw-bold text-uppercase" style="font-size: 0.85rem;">{{ $s->name }}</div>
                    <small class="text-muted">{{ $s->nim }}</small>
                </td>
                <td>
                    <input type="number" name="scores[{{ $s->id }}][tugas]"
                        class="form-control form-control-sm text-center" value="{{ $grade->tugas ?? '' }}" min="0"
                        max="100" step="0.1">
                </td>

                <td>
                    <input type="number" id="uts-{{ $s->id }}" name="scores[{{ $s->id }}][uts]"
                        class="form-control form-control-sm text-center input-uts" data-student="{{ $s->id }}"
                        data-kkm="{{ $subject->kkm_uts }}" placeholder="0" max="100" step="0.1" value="{{ $grade->uts ?? '' }}" oninput="handleRemedial('{{ $s->id }}', 'uts', this.value, {{ $subject->kkm_uts ?? 0 }})">
                </td>
                <td>
                    {{-- Remedial UTS: disabled if original score >= KKM --}}
                    <input type="number" id="remed-uts-{{ $s->id }}" name="scores[{{ $s->id }}][remedial_uts]"
                        class="form-control form-control-sm text-center border-warning bg-warning-subtle"
                        placeholder="Remed UTS" value="{{ $grade->remedial_uts ?? '' }}" max="100" step="0.1" disabled>
                </td>

                <td>
                    <input type="number" id="uas-{{ $s->id }}" name="scores[{{ $s->id }}][uas]"
                        class="form-control form-control-sm text-center input-uas" data-student="{{ $s->id }}"
                        data-kkm="{{ $subject->kkm_uas }}" placeholder="0" max="100" step="0.1" value="{{ $grade->uas ?? '' }}" oninput="handleRemedial('{{ $s->id }}', 'uas', this.value, {{ $subject->kkm_uas ?? 0 }})">
                </td>
                <td>
                    {{-- Remedial UAS: disabled if original score >= KKM --}}
                    <input type="number" id="remed-uas-{{ $s->id }}" name="scores[{{ $s->id }}][remedial_uas]"
                        class="form-control form-control-sm text-center border-warning bg-warning-subtle"
                        placeholder="Remed UAS" value="{{ $grade->remedial_uas ?? '' }}" max="100" step="0.1" disabled>
                </td>

                <td>
                    <input type="number" name="scores[{{ $s->id }}][attendance]"
                        class="form-control form-control-sm text-center" value="{{ $grade->attendance ?? $subject->meetings }}" min="0"
                        max="{{ $subject->meetings }}" step="0.1">
                </td>
                <td class="text-center">
                    <span
                        class="badge {{ $grade ? ($grade->grade == 'A' ? 'bg-success' : ($grade->grade == 'B' ? 'bg-primary' : ($grade->grade == 'C' ? 'bg-warning text-dark' : ($grade->grade == 'D' ? 'bg-secondary' : 'bg-danger')))) : 'bg-secondary' }} fs-6 px-3 py-2">
                        {{ $grade->grade ?? '-' }}
                    </span>
                    @if($grade && $grade->final_score)
                        <div class="small text-muted mt-1">{{ $grade->final_score }}</div>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center py-4 text-secondary">Tidak ada mahasiswa di angkatan ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4 d-flex justify-content-between align-items-center">
    <div class="text-muted small">
        <span class="badge bg-warning text-dark border border-warning">Remedial</span> otomatis terkunci jika nilai &ge; KKM |
        <span class="badge bg-danger text-white">Merah</span> = Nilai di bawah KKM
    </div>
    <button type="submit" id="btn-submit-nilai" class="btn btn-primary px-5 rounded-pill shadow">
        <i class="bi bi-cloud-upload me-2"></i>Simpan Perubahan
    </button>
</div>

<script>
    function handleRemedial(studentId, type, score, kkm) {
        const remedId = `remed-${type}-${studentId}`;
        const remedInput = document.getElementById(remedId);
        const originalInput = document.getElementById(`${type}-${studentId}`);

        if (!remedInput || !originalInput) return;

        if (score !== '' && parseFloat(score) < kkm) {
            // Score below KKM: ENABLE remedial field
            remedInput.disabled = false;
            remedInput.style.opacity = '1';
            remedInput.classList.remove('bg-light');
            remedInput.classList.add('bg-warning-subtle', 'border-warning');
            remedInput.placeholder = 'Input Remidi';

            originalInput.classList.add('bg-danger', 'text-white');
            originalInput.classList.remove('bg-light', 'text-dark');
        } else {
            // Score >= KKM or empty: LOCK remedial field completely
            remedInput.disabled = true;
            remedInput.style.opacity = '0.35';
            remedInput.value = '';
            remedInput.classList.remove('bg-warning-subtle', 'border-warning');
            remedInput.classList.add('bg-light');
            remedInput.placeholder = 'Terkunci';

            originalInput.classList.remove('bg-danger', 'text-white');
        }
    }

    // Apply remedial lock/unlock state on load for all existing values
    document.querySelectorAll('.input-uts').forEach(input => {
        handleRemedial(input.dataset.student, 'uts', input.value, parseFloat(input.dataset.kkm) || 0);
    });
    document.querySelectorAll('.input-uas').forEach(input => {
        handleRemedial(input.dataset.student, 'uas', input.value, parseFloat(input.dataset.kkm) || 0);
    });
</script>