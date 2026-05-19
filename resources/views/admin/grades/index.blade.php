@extends('layouts.app')

@section('title', 'Input Nilai')

@push('styles')
<style>
    /* Custom Live Search Styles */
    .live-search-container {
        position: relative;
    }
    #search-suggestions {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        z-index: 1050;
        max-height: 200px;
        overflow-y: auto;
        background: #2c2c2c;
        border: 1px solid #444;
        border-radius: 0 0 8px 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.3);
    }
    .suggestion-item {
        padding: 12px 15px;
        cursor: pointer;
        color: #fff;
        border-bottom: 1px solid #333;
        transition: background 0.2s;
    }
    .suggestion-item:last-child {
        border-bottom: none;
    }
    .suggestion-item:hover, .suggestion-item.active {
        background: #00d2ff;
        color: #000;
    }
    .highlight-match {
        font-weight: 800;
        color: #ffc107;
    }
    .suggestion-item:hover .highlight-match {
        color: #000;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-white fw-bold mb-0">Input Nilai Mahasiswa</h3>
        <button class="btn btn-info px-4 fw-bold shadow" data-bs-toggle="modal" data-bs-target="#wizardModal">
            <i class="bi bi-magic me-2"></i> Mulai Input Nilai
        </button>
    </div>

    <!-- Container for Table -->
    <div class="card shadow border-0" style="background-color: var(--card-bg, #1a1a1a); border-radius: 15px;">
        <div class="card-body p-4" id="main-content-area">
            <form action="{{ route('admin.nilai.store') }}" method="POST" id="form-nilai">
                @csrf
                <input type="hidden" name="subject_id" id="hidden-subject-id">
                <input type="hidden" name="cohort" id="hidden-cohort">
                
                <div id="container-mahasiswa">
                    <div class="text-center py-5 text-secondary">
                        <i class="bi bi-table fs-1 d-block mb-3 opacity-50"></i>
                        <h5>Belum ada data yang dipilih.</h5>
                        <p>Silakan klik "Mulai Input Nilai" untuk memilih Semester, Mata Kuliah, dan Angkatan.</p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- WIZARD MODAL -->
<div class="modal fade" id="wizardModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-info fw-bold"><i class="bi bi-funnel me-2"></i> Pengaturan Data Nilai</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                
                <!-- Progress Indicators -->
                <div class="d-flex justify-content-between mb-4 position-relative">
                    <div class="progress position-absolute" style="height: 2px; top: 15px; width: 100%; z-index: 0; background: #444;">
                        <div class="progress-bar bg-info" id="wizard-progress" style="width: 0%;"></div>
                    </div>
                    <div class="step-indicator text-center position-relative z-1" id="ind-1">
                        <span class="badge rounded-pill bg-info fs-6 border border-dark">1</span>
                    </div>
                    <div class="step-indicator text-center position-relative z-1" id="ind-2">
                        <span class="badge rounded-pill bg-secondary fs-6 border border-dark">2</span>
                    </div>
                    <div class="step-indicator text-center position-relative z-1" id="ind-3">
                        <span class="badge rounded-pill bg-secondary fs-6 border border-dark">3</span>
                    </div>
                </div>

                <!-- STEP 1: SEMESTER -->
                <div id="step-1" class="wizard-step">
                    <h6 class="text-center mb-3">Pilih Semester</h6>
                    <div class="d-grid gap-2">
                        @foreach($semesters as $s)
                            <button type="button" class="btn btn-outline-info btn-semester" data-val="{{ $s }}">Semester {{ $s }}</button>
                        @endforeach
                    </div>
                </div>

                <!-- STEP 2: MATA KULIAH (LIVE SEARCH) -->
                <div id="step-2" class="wizard-step" style="display: none;">
                    <h6 class="text-center mb-3">Cari Mata Kuliah</h6>
                    <div class="live-search-container">
                        <div class="input-group">
                            <span class="input-group-text bg-dark border-secondary text-info"><i class="bi bi-search"></i></span>
                            <input type="text" id="live-search-input" class="form-control bg-dark text-white border-secondary" placeholder="Ketik minimal 2 huruf..." autocomplete="off">
                        </div>
                        <ul id="search-suggestions" class="list-unstyled mb-0 d-none"></ul>
                    </div>
                    <div class="text-center mt-4">
                        <button type="button" class="btn btn-sm btn-outline-secondary btn-back" data-target="1">Kembali</button>
                    </div>
                </div>

                <!-- STEP 3: COHORT -->
                <div id="step-3" class="wizard-step" style="display: none;">
                    <h6 class="text-center mb-3">Pilih Angkatan (Cohort)</h6>
                    <div class="d-grid gap-2">
                        @foreach($cohorts as $c)
                            <button type="button" class="btn btn-outline-info btn-cohort" data-val="{{ $c->cohort }}">Cohort {{ $c->cohort }}</button>
                        @endforeach
                    </div>
                    <div class="text-center mt-4">
                        <button type="button" class="btn btn-sm btn-outline-secondary btn-back" data-target="2">Kembali</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentSemester = '';
    let currentSubjectId = '';
    let currentCohort = '';
    
    const modalEl = document.getElementById('wizardModal');
    const wizardModal = new bootstrap.Modal(modalEl);

    // --- Navigation Logic ---
    function switchStep(step) {
        document.querySelectorAll('.wizard-step').forEach(el => el.style.display = 'none');
        document.getElementById('step-' + step).style.display = 'block';

        // Update progress bar
        let progress = step === 1 ? 0 : (step === 2 ? 50 : 100);
        document.getElementById('wizard-progress').style.width = progress + '%';

        // Update indicators
        for (let i = 1; i <= 3; i++) {
            let badge = document.querySelector(`#ind-${i} .badge`);
            if (i <= step) {
                badge.classList.replace('bg-secondary', 'bg-info');
            } else {
                badge.classList.replace('bg-info', 'bg-secondary');
            }
        }
    }

    // Back buttons
    document.querySelectorAll('.btn-back').forEach(btn => {
        btn.addEventListener('click', function() {
            switchStep(parseInt(this.dataset.target));
        });
    });

    // Step 1 -> Step 2
    document.querySelectorAll('.btn-semester').forEach(btn => {
        btn.addEventListener('click', function() {
            currentSemester = this.dataset.val;
            document.getElementById('live-search-input').value = '';
            document.getElementById('search-suggestions').classList.add('d-none');
            switchStep(2);
            setTimeout(() => document.getElementById('live-search-input').focus(), 100);
        });
    });

    // --- LIVE SEARCH (AUTO SUGGEST) LOGIC ---
    const searchInput = document.getElementById('live-search-input');
    const suggestionsBox = document.getElementById('search-suggestions');
    let debounceTimer;

    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const keyword = this.value.trim();

        if (keyword.length < 2) {
            suggestionsBox.classList.add('d-none');
            return;
        }

        debounceTimer = setTimeout(() => {
            fetch(`{{ route('admin.getSubjects') }}?semester=${currentSemester}&search=${encodeURIComponent(keyword)}`)
                .then(res => res.json())
                .then(data => {
                    suggestionsBox.innerHTML = '';
                    if (data.length === 0) {
                        suggestionsBox.innerHTML = '<li class="suggestion-item text-center text-muted">Tidak ada hasil ditemukan.</li>';
                    } else {
                        data.forEach(item => {
                            // Highlight matches (case-insensitive)
                            const regex = new RegExp(`(${keyword})`, 'gi');
                            const highlightedText = item.text.replace(regex, '<span class="highlight-match">$1</span>');
                            
                            const li = document.createElement('li');
                            li.className = 'suggestion-item';
                            li.innerHTML = highlightedText;
                            li.addEventListener('click', function() {
                                currentSubjectId = item.id;
                                document.getElementById('hidden-subject-id').value = currentSubjectId;
                                switchStep(3);
                            });
                            suggestionsBox.appendChild(li);
                        });
                    }
                    suggestionsBox.classList.remove('d-none');
                })
                .catch(err => console.error("Search error:", err));
        }, 300); // 300ms debounce
    });

    // Hide suggestions when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
            suggestionsBox.classList.add('d-none');
        }
    });

    // Step 3 -> Load Table
    document.querySelectorAll('.btn-cohort').forEach(btn => {
        btn.addEventListener('click', function() {
            currentCohort = this.dataset.val;
            document.getElementById('hidden-cohort').value = currentCohort;
            wizardModal.hide(); // Close modal
            
            // Trigger AJAX load
            loadTable();
        });
    });

    // --- AJAX TABLE LOADING ---
    function handleRemedial(studentId, type, score, kkm) {
        const remedId = `remed-${type}-${studentId}`;
        const remedInput = document.getElementById(remedId);
        const originalInput = document.getElementById(`${type}-${studentId}`);

        if (!remedInput || !originalInput) return;

        if (score !== '' && parseFloat(score) < kkm) {
            remedInput.disabled = false;
            remedInput.style.opacity = '1';
            remedInput.classList.remove('bg-light');
            remedInput.classList.add('bg-warning-subtle', 'border-warning');
            remedInput.placeholder = 'Input Remidi';

            originalInput.classList.add('bg-danger', 'text-white');
            originalInput.classList.remove('bg-light', 'text-dark');
        } else {
            remedInput.disabled = true;
            remedInput.style.opacity = '0.35';
            remedInput.value = '';
            remedInput.classList.remove('bg-warning-subtle', 'border-warning');
            remedInput.classList.add('bg-light');
            remedInput.placeholder = 'Terkunci';

            originalInput.classList.remove('bg-danger', 'text-white');
        }
    }
    window.handleRemedial = handleRemedial; // Expose to global scope for inline oninput

    function initRemedial() {
        document.querySelectorAll('.input-uts').forEach(input => {
            handleRemedial(input.dataset.student, 'uts', input.value, parseFloat(input.dataset.kkm) || 0);
        });
        document.querySelectorAll('.input-uas').forEach(input => {
            handleRemedial(input.dataset.student, 'uas', input.value, parseFloat(input.dataset.kkm) || 0);
        });
    }

    function loadTable() {
        const container = document.getElementById('container-mahasiswa');
        container.innerHTML = '<div class="text-center text-info py-5"><div class="spinner-border mb-3"></div><br>Memuat data mahasiswa...</div>';
        
        fetch(`{{ route('admin.getStudents') }}?cohort=${currentCohort}&subject_id=${currentSubjectId}`)
            .then(res => {
                if(!res.ok) throw new Error("Gagal mengambil data");
                return res.text();
            })
            .then(html => {
                container.innerHTML = html;
                initRemedial();
            })
            .catch(err => {
                container.innerHTML = `<div class="text-center text-danger py-5"><i class="bi bi-exclamation-triangle fs-1"></i><br>Terjadi kesalahan sistem: ${err.message}</div>`;
            });
    }

    // --- AJAX SAVING GRADES (moved from old code) ---
    document.addEventListener('click', function(e) {
        if(e.target && e.target.id === 'btn-submit-nilai' || e.target.closest('#btn-submit-nilai')) {
            e.preventDefault();
            const btn = e.target.closest('#btn-submit-nilai');
            const form = document.getElementById('form-nilai');
            
            btn.disabled = true;
            btn.innerHTML = '<i class="spinner-border spinner-border-sm me-2"></i>Menyimpan...';

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    alert('Berhasil: ' + data.message);
                    loadTable(); // Reload to show calculated grades
                } else {
                    alert('Gagal: ' + data.message);
                }
            })
            .catch(err => alert("Terjadi kesalahan koneksi!"))
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-cloud-upload me-2"></i>Simpan Perubahan';
            });
        }
    });

    // Reset wizard when modal is closed
    modalEl.addEventListener('hidden.bs.modal', function () {
        switchStep(1);
    });
});
</script>
@endpush
@endsection
