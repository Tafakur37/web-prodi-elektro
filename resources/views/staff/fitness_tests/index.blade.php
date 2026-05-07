@extends('layouts.app')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <style>
        .score-badge { font-size: 0.75rem; padding: 4px 10px; border-radius: 20px; font-weight: 600; }
        .score-high { background: #d4edda; color: #155724; }
        .score-mid { background: #fff3cd; color: #856404; }
        .score-low { background: #f8d7da; color: #721c24; }
        .gender-male { color: #0d6efd; }
        .gender-female { color: #e91e8c; }
        .raw-input { max-width: 90px; }
    </style>
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="card card-custom p-4 mb-4 bg-white border-start border-4 border-danger shadow-sm">
        <h4 class="fw-bold mb-1"><i class="bi bi-heart-pulse me-2 text-danger"></i>Manajemen Kesemaptaan (Garjas)</h4>
        <p class="text-muted mb-0">Input data mentah, sistem menghitung nilai otomatis dengan linear interpolation.</p>
    </div>

    <!-- FILTER -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <form action="{{ route('staff.fitness-tests.index') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted">1. Pilih Semester</label>
                        <select name="semester" class="form-select select2" required data-placeholder="Pilih Semester">
                            <option value=""></option>
                            @foreach($semesters as $s)
                                <option value="{{ $s }}" {{ request('semester') == $s ? 'selected' : '' }}>Semester {{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted">2. Pilih Cohort</label>
                        <select name="cohort" class="form-select select2" required data-placeholder="Angkatan">
                            <option value=""></option>
                            @foreach($availableCohorts as $c)
                                <option value="{{ $c }}" {{ request('cohort') == $c ? 'selected' : '' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-danger w-100 fw-bold">
                            <i class="bi bi-search me-1"></i> Tampilkan Mahasiswa
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- STUDENT LIST -->
    @if($semester && $cohort && $students->isNotEmpty())
        @php
            $sudahInput = $students->filter(fn($s) => $s->fitnessTests->isNotEmpty())->count();
            $belumInput = $students->count() - $sudahInput;
        @endphp
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 p-4 pb-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-1">Semester {{ $semester }} | Cohort {{ $cohort }}</h5>
                        <div class="small text-muted">
                            <span class="badge bg-success me-1">{{ $sudahInput }} Sudah</span>
                            <span class="badge bg-secondary">{{ $belumInput }} Belum</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small fw-bold">
                            <tr>
                                <th class="ps-4" width="5%">No</th>
                                <th>Mahasiswa</th>
                                <th class="text-center">JK</th>
                                <th class="text-center">Lari</th>
                                <th class="text-center">B1</th>
                                <th class="text-center">Sit Up</th>
                                <th class="text-center">Push Up</th>
                                <th class="text-center">Shuttle</th>
                                <th class="text-center">Renang</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Status</th>
                                <th class="text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $index => $student)
                                @php $ft = $student->fitnessTests->first(); @endphp
                                <tr class="{{ $ft ? '' : 'table-warning table-opacity-50' }}">
                                    <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $student->name }}</div>
                                        <div class="small text-muted">{{ $student->nim }}</div>
                                    </td>
                                    <td class="text-center">
                                        @if($student->gender === 'L')
                                            <span class="badge bg-primary bg-opacity-10 text-primary">L</span>
                                        @elseif($student->gender === 'P')
                                            <span class="badge bg-pink bg-opacity-10 text-danger">P</span>
                                        @else
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary">?</span>
                                        @endif
                                    </td>
                                    @if($ft && $ft->total_score !== null)
                                        <td class="text-center"><span class="score-badge {{ $ft->nilai_lari >= 60 ? 'score-high' : ($ft->nilai_lari >= 30 ? 'score-mid' : 'score-low') }}">{{ $ft->nilai_lari }}</span></td>
                                        <td class="text-center"><span class="score-badge {{ ($ft->nilai_pull_up ?? $ft->nilai_chinning ?? 0) >= 60 ? 'score-high' : 'score-low' }}">{{ $ft->nilai_pull_up ?? $ft->nilai_chinning ?? '-' }}</span></td>
                                        <td class="text-center"><span class="score-badge {{ $ft->nilai_sit_up >= 60 ? 'score-high' : 'score-low' }}">{{ $ft->nilai_sit_up }}</span></td>
                                        <td class="text-center"><span class="score-badge {{ $ft->nilai_push_up >= 60 ? 'score-high' : 'score-low' }}">{{ $ft->nilai_push_up }}</span></td>
                                        <td class="text-center"><span class="score-badge {{ $ft->nilai_shuttle_run >= 60 ? 'score-high' : 'score-low' }}">{{ $ft->nilai_shuttle_run }}</span></td>
                                        <td class="text-center"><span class="score-badge {{ $ft->nilai_renang >= 60 ? 'score-high' : 'score-low' }}">{{ $ft->nilai_renang }}</span></td>
                                        <td class="text-center"><span class="fw-bold text-danger fs-5">{{ $ft->total_score }}</span></td>
                                        <td class="text-center"><span class="badge {{ $ft->status_badge }} rounded-pill px-3">{{ $ft->status }}</span></td>
                                    @elseif($ft)
                                        <td class="text-center">{{ $ft->score_a ?? '-' }}</td>
                                        <td class="text-center">{{ $ft->score_b ?? '-' }}</td>
                                        <td colspan="4" class="text-center text-muted small">Data lama</td>
                                        <td class="text-center fw-bold">{{ $ft->score }}</td>
                                        <td class="text-center"><span class="badge {{ $ft->status_badge }} rounded-pill">{{ $ft->status }}</span></td>
                                    @else
                                        <td colspan="8" class="text-center text-muted small fst-italic">Belum diinput</td>
                                    @endif
                                    <td class="text-center pe-4">
                                        <button class="btn btn-sm {{ $ft ? 'btn-outline-primary' : 'btn-danger fw-bold rounded-pill px-3' }}" onclick="openModal({{ $student->id }}, '{{ addslashes($student->name) }}', '{{ $student->gender ?? 'L' }}', {{ json_encode($ft) }})">
                                            <i class="bi bi-{{ $ft ? 'pencil' : 'plus-lg me-1' }}"></i>{{ $ft ? '' : ' Input' }}
                                        </button>
                                        @if($ft)
                                        <form action="{{ route('staff.fitness-tests.destroy', $ft->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?');">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @elseif($semester && $cohort)
        <div class="alert alert-warning border-0 rounded-4 shadow-sm p-4 text-center">
            <i class="bi bi-people fs-3 d-block mb-2"></i>Tidak ada mahasiswa ditemukan.
        </div>
    @endif
</div>

<!-- MODAL INPUT GARJAS -->
<div class="modal fade" id="modalGarjas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <form action="{{ route('staff.fitness-tests.store') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" id="g_user_id">
                <input type="hidden" name="semester" value="{{ $semester }}">
                <div class="modal-header bg-danger bg-opacity-10 border-0 p-4">
                    <h5 class="modal-title fw-bold" id="g_title"><i class="bi bi-heart-pulse me-2 text-danger"></i>Input Garjas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Gender & Date -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">Tanggal Tes <span class="text-danger">*</span></label>
                            <input type="date" name="test_date" id="g_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">Gender</label>
                            <div id="g_gender_display" class="form-control bg-light fw-bold"></div>
                        </div>
                    </div>

                    <!-- GARJAS A: LARI -->
                    <div class="card bg-light border-0 rounded-3 p-3 mb-3">
                        <h6 class="fw-bold mb-3"><span class="badge bg-danger me-2">A</span> Lari 12 Menit</h6>
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label small">Jarak tempuh (meter)</label>
                                <input type="number" name="raw_lari" id="g_lari" class="form-control" min="0" max="5000" step="1" placeholder="cth: 2500">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-muted">Nilai Konversi</label>
                                <div id="preview_lari" class="form-control bg-white text-center fw-bold">-</div>
                            </div>
                        </div>
                    </div>

                    <!-- GARJAS B -->
                    <div class="card bg-light border-0 rounded-3 p-3 mb-3">
                        <h6 class="fw-bold mb-3"><span class="badge bg-primary me-2">B</span> Kekuatan & Ketangkasan</h6>
                        <div class="row g-3">
                            <!-- B1: Pull Up / Chinning -->
                            <div class="col-md-3">
                                <label class="form-label small" id="label_b1">Pull Up (reps)</label>
                                <input type="number" id="g_b1" class="form-control" min="0" max="100" step="1">
                                <input type="hidden" name="raw_pull_up" id="g_pull_up">
                                <input type="hidden" name="raw_chinning" id="g_chinning">
                                <div id="preview_b1" class="small text-center mt-1 fw-bold">-</div>
                            </div>
                            <!-- B2: Sit Up -->
                            <div class="col-md-3">
                                <label class="form-label small">Sit Up (reps)</label>
                                <input type="number" name="raw_sit_up" id="g_sit_up" class="form-control" min="0" max="100" step="1">
                                <div id="preview_sit_up" class="small text-center mt-1 fw-bold">-</div>
                            </div>
                            <!-- B3: Push Up -->
                            <div class="col-md-3">
                                <label class="form-label small">Push Up (reps)</label>
                                <input type="number" name="raw_push_up" id="g_push_up" class="form-control" min="0" max="100" step="1">
                                <div id="preview_push_up" class="small text-center mt-1 fw-bold">-</div>
                            </div>
                            <!-- B4: Shuttle Run -->
                            <div class="col-md-3">
                                <label class="form-label small">Shuttle Run (detik)</label>
                                <input type="number" name="raw_shuttle_run" id="g_shuttle" class="form-control" min="0" max="60" step="0.1">
                                <div id="preview_shuttle" class="small text-center mt-1 fw-bold">-</div>
                            </div>
                        </div>
                    </div>

                    <!-- GARJAS C: RENANG -->
                    <div class="card bg-light border-0 rounded-3 p-3 mb-3">
                        <h6 class="fw-bold mb-3"><span class="badge bg-info text-dark me-2">C</span> Renang</h6>
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label small">Waktu tempuh (detik)</label>
                                <input type="number" name="raw_renang" id="g_renang" class="form-control" min="0" max="600" step="0.1" placeholder="cth: 75">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-muted">Nilai Konversi</label>
                                <div id="preview_renang" class="form-control bg-white text-center fw-bold">-</div>
                            </div>
                        </div>
                    </div>

                    <!-- TOTAL PREVIEW -->
                    <div class="card border-2 border-danger rounded-3 p-3 text-center">
                        <div class="fw-bold text-muted small mb-1">ESTIMASI TOTAL NILAI</div>
                        <h2 class="fw-bold text-danger mb-0" id="preview_total">-</h2>
                        <div id="preview_status" class="small fw-bold mt-1">-</div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">
                        <i class="bi bi-check-circle me-1"></i>Simpan Garjas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() { $('.select2').select2({ theme: 'bootstrap-5', width: '100%' }); });

// ═══════ PARAMS (mirror dari GarjasCalculatorService) ═══════
const PARAMS = {
    lari:    { L: {max:3240,min:1664}, P: {max:2435,min:1326} },
    pull_up: { L: {max:15,min:1} },
    chinning:{ P: {max:60,min:11} },
    sit_up:  { L: {max:39,thr:7}, P: {max:40,thr:8} },
    push_up: { L: {max:37,thr:5}, P: {max:27,min:1} },
    shuttle: { L: {best:16.9,worst:26.8}, P: {best:17.2,worst:27.1} },
    renang:  { best:60, worst:300 }
};

let currentGender = 'L';

function clamp(v) { return Math.round(Math.max(0, Math.min(100, v)) * 100) / 100; }
function lin(input, min, max) { return (max===min) ? 100 : ((input-min)/(max-min))*99+1; }
function invLin(input, best, worst) { return (worst===best) ? 100 : ((worst-input)/(worst-best))*99+1; }

function calcLari(m, g) {
    if(!m||m<=0) return 0; let p=PARAMS.lari[g];
    if(m>=p.max) return 100; return clamp(lin(m,p.min,p.max));
}
function calcB1(v, g) {
    if(!v||v<=0) return 0;
    if(g==='P') { let p=PARAMS.chinning.P; if(v>=p.max) return 100; return clamp(lin(v,p.min,p.max)); }
    let p=PARAMS.pull_up.L; if(v>=p.max) return 100; return clamp(lin(v,p.min,p.max));
}
function calcSitUp(r, g) {
    if(!r||r<=0) return 0; let p=PARAMS.sit_up[g];
    if(r>=p.max) return 100; if(r<p.thr) return 1; if(r==p.thr) return 2;
    return clamp(((r-p.thr)/(p.max-p.thr))*98+2);
}
function calcPushUp(r, g) {
    if(!r||r<=0) return 0;
    if(g==='P') { let p=PARAMS.push_up.P; if(r>=p.max) return 100; return clamp(((r-p.min)/(p.max-p.min))*90+10); }
    let p=PARAMS.push_up.L; if(r>=p.max) return 100; if(r<p.thr) return 1; if(r==p.thr) return 2;
    return clamp(((r-p.thr)/(p.max-p.thr))*98+2);
}
function calcShuttle(s, g) {
    if(!s||s<=0) return 0; let p=PARAMS.shuttle[g];
    if(s<=p.best) return 100; if(s>=p.worst) return 1; return clamp(invLin(s,p.best,p.worst));
}
function calcRenang(s) {
    if(!s||s<=0) return 0; if(s<=PARAMS.renang.best) return 100;
    return clamp(invLin(s,PARAMS.renang.best,PARAMS.renang.worst));
}

function formatScore(v) { return v > 0 ? v.toFixed(1) : '-'; }
function scoreColor(v) { return v>=60 ? 'text-success' : (v>=30 ? 'text-warning' : 'text-danger'); }

function updatePreviews() {
    let g = currentGender;
    let lari = calcLari(parseFloat($('#g_lari').val()), g);
    let b1 = calcB1(parseInt($('#g_b1').val()), g);
    let sit = calcSitUp(parseInt($('#g_sit_up').val()), g);
    let push = calcPushUp(parseInt($('#g_push_up').val()), g);
    let shuttle = calcShuttle(parseFloat($('#g_shuttle').val()), g);
    let renang = calcRenang(parseFloat($('#g_renang').val()));

    $('#preview_lari').text(formatScore(lari)).removeClass('text-success text-warning text-danger').addClass(scoreColor(lari));
    $('#preview_b1').text(formatScore(b1)).removeClass('text-success text-warning text-danger').addClass(scoreColor(b1));
    $('#preview_sit_up').text(formatScore(sit)).removeClass('text-success text-warning text-danger').addClass(scoreColor(sit));
    $('#preview_push_up').text(formatScore(push)).removeClass('text-success text-warning text-danger').addClass(scoreColor(push));
    $('#preview_shuttle').text(formatScore(shuttle)).removeClass('text-success text-warning text-danger').addClass(scoreColor(shuttle));
    $('#preview_renang').text(formatScore(renang)).removeClass('text-success text-warning text-danger').addClass(scoreColor(renang));

    let scores = [lari, b1, sit, push, shuttle, renang].filter(v => v > 0);
    let total = scores.length > 0 ? scores.reduce((a,b)=>a+b,0)/scores.length : 0;
    total = Math.round(total*100)/100;

    $('#preview_total').text(total > 0 ? total.toFixed(2) : '-');
    $('#preview_status').text(total >= 60 ? '✅ LULUS' : (total > 0 ? '❌ TIDAK LULUS' : '-'))
        .removeClass('text-success text-danger').addClass(total >= 60 ? 'text-success' : 'text-danger');

    // Sync hidden fields for B1
    if (g === 'P') { $('#g_chinning').val($('#g_b1').val()); $('#g_pull_up').val(''); }
    else { $('#g_pull_up').val($('#g_b1').val()); $('#g_chinning').val(''); }
}

function setGenderUI(g) {
    currentGender = g;
    if (g === 'P') {
        $('#label_b1').text('Chinning (detik)');
        $('#g_gender_display').html('<i class="bi bi-gender-female me-1"></i> Perempuan').removeClass('text-primary').addClass('text-danger');
    } else {
        $('#label_b1').text('Pull Up (reps)');
        $('#g_gender_display').html('<i class="bi bi-gender-male me-1"></i> Laki-laki').removeClass('text-danger').addClass('text-primary');
    }
    updatePreviews();
}

function openModal(userId, name, gender, ftData) {
    $('#g_user_id').val(userId);
    $('#g_title').html('<i class="bi bi-heart-pulse me-2 text-danger"></i>' + (ftData ? 'Edit' : 'Input') + ' Garjas — ' + name);

    // Reset
    $('#g_date').val(ftData?.test_date?.split('T')[0] || new Date().toISOString().split('T')[0]);
    $('#g_lari').val(ftData?.raw_lari || '');
    $('#g_b1').val(gender === 'P' ? (ftData?.raw_chinning || '') : (ftData?.raw_pull_up || ''));
    $('#g_sit_up').val(ftData?.raw_sit_up || '');
    $('#g_push_up').val(ftData?.raw_push_up || '');
    $('#g_shuttle').val(ftData?.raw_shuttle_run || '');
    $('#g_renang').val(ftData?.raw_renang || '');

    setGenderUI(gender || 'L');

    new bootstrap.Modal(document.getElementById('modalGarjas')).show();
}

// Live preview on input
$('#g_lari, #g_b1, #g_sit_up, #g_push_up, #g_shuttle, #g_renang').on('input', updatePreviews);
</script>
@endpush
