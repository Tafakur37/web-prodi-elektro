<div class="table-responsive mt-4">
    <table class="table table-dark table-hover border-secondary">
        <thead>
            <tr class="text-center text-info">
                <th class="text-start">Mahasiswa</th>
                <th>Hadir</th>
                <th>Tugas</th>
                <th>UTS</th>
                <th>Remed UTS</th>
                <th>UAS</th>
                <th>Remed UAS</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                @php $existing = $student->grades->first(); @endphp
                <tr class="align-middle text-center">
                    <td class="text-start">
                        <span class="text-white fw-bold">{{ $student->name }}</span><br>
                        <small class="text-secondary">{{ $student->nim }}</small>
                    </td>
                    <td><input type="number" name="scores[{{ $student->id }}][attendance]" value="{{ $existing->attendance ?? '' }}" class="form-control bg-dark text-white border-secondary text-center mx-auto" style="width: 70px;" min="0" max="{{ $subject->meetings ?? 100 }}" step="0.1"></td>
                    <td><input type="number" name="scores[{{ $student->id }}][tugas]" value="{{ $existing->tugas ?? '' }}" class="form-control bg-dark text-white border-secondary text-center mx-auto" style="width: 70px;" min="0" max="100" step="0.1"></td>
                    <td><input type="number" name="scores[{{ $student->id }}][uts]" value="{{ $existing->uts ?? '' }}" class="form-control bg-dark text-white border-secondary text-center mx-auto input-uts" data-student="{{ $student->id }}" data-kkm="{{ $subject->kkm_uts }}" style="width: 70px;" min="0" max="100" step="0.1" oninput="handleRemedial('{{ $student->id }}', 'uts', this.value, {{ $subject->kkm_uts }})"></td>
                    <td><input type="number" id="remed-uts-{{ $student->id }}" name="scores[{{ $student->id }}][remedial_uts]" value="{{ $existing->remedial_uts ?? '' }}" class="form-control bg-info text-dark border-info text-center mx-auto" style="width: 70px;" min="0" max="100" step="0.1"></td>
                    <td><input type="number" name="scores[{{ $student->id }}][uas]" value="{{ $existing->uas ?? '' }}" class="form-control bg-dark text-white border-secondary text-center mx-auto input-uas" data-student="{{ $student->id }}" data-kkm="{{ $subject->kkm_uas }}" style="width: 70px;" min="0" max="100" step="0.1" oninput="handleRemedial('{{ $student->id }}', 'uas', this.value, {{ $subject->kkm_uas }})"></td>
                    <td><input type="number" id="remed-uas-{{ $student->id }}" name="scores[{{ $student->id }}][remedial_uas]" value="{{ $existing->remedial_uas ?? '' }}" class="form-control bg-info text-dark border-info text-center mx-auto" style="width: 70px;" min="0" max="100" step="0.1"></td>
                    <td>
                        <span class="badge {{ ($existing->grade ?? '') == 'A' ? 'bg-success' : (($existing->grade ?? '') == 'B' ? 'bg-primary' : (($existing->grade ?? '') == 'C' ? 'bg-warning text-dark' : 'bg-secondary')) }}">
                            {{ $existing->grade ?? '-' }}
                        </span>
                        @if($existing && $existing->final_score)
                            <div class="small text-muted mt-1">{{ $existing->final_score }}</div>
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

@if($students->count() > 0)
<div class="text-end mt-3">
    <button type="submit" id="btn-submit-nilai" class="btn btn-info px-5 fw-bold"><i class="bi bi-cloud-upload me-2"></i>Simpan Perubahan</button>
</div>
@endif

<script>
    function handleRemedial(studentId, type, score, kkm) {
        const remedId = `remed-${type}-${studentId}`;
        const remedInput = document.getElementById(remedId);
        const originalInput = document.querySelector(`input[name="scores[${studentId}][${type}]"]`);

        if (!remedInput) return;

        if (score !== '' && parseFloat(score) < kkm) {
            remedInput.readOnly = false;
            remedInput.style.opacity = '1';
            remedInput.classList.add('bg-info', 'border-info');
            remedInput.classList.remove('bg-dark', 'border-secondary');

            originalInput.classList.add('bg-danger', 'text-white');
            originalInput.classList.remove('bg-dark');
        } else {
            remedInput.readOnly = true;
            remedInput.style.opacity = '0.35';
            remedInput.value = '';
            remedInput.classList.remove('bg-info', 'border-info');
            remedInput.classList.add('bg-dark', 'border-secondary');

            originalInput.classList.remove('bg-danger', 'text-white');
            originalInput.classList.add('bg-dark');
        }
    }

    // Apply remedial lock/unlock state on load
    document.querySelectorAll('.input-uts').forEach(input => {
        handleRemedial(input.dataset.student, 'uts', input.value, parseFloat(input.dataset.kkm));
    });
    document.querySelectorAll('.input-uas').forEach(input => {
        handleRemedial(input.dataset.student, 'uas', input.value, parseFloat(input.dataset.kkm));
    });
</script>