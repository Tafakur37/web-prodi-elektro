@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <div class="card card-custom p-4 mb-4 bg-white border-start border-4 border-primary shadow-sm">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1"><i class="bi bi-calendar3 me-2 text-primary"></i>Manajemen Jadwal</h4>
                <p class="text-muted mb-0">Kelola waktu perkuliahan per angkatan.</p>
            </div>
            <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal"
                data-bs-target="#modalTambahJadwal">
                <i class="bi bi-plus-lg me-1"></i> Tambah Jadwal
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <form action="{{ route('staff.schedules.index') }}" method="GET" class="d-flex align-items-end gap-3">
                <div style="min-width: 200px;">
                    <label class="form-label fw-bold small text-muted">Filter Angkatan (Cohort)</label>
                    <select name="cohort" class="form-select">
                        <option value="">Semua Angkatan</option>
                        @foreach($availableCohorts as $c)
                            <option value="{{ $c }}" {{ request('cohort') == $c ? 'selected' : '' }}>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-secondary fw-bold">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card card-custom shadow-sm bg-white">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light text-uppercase small fw-bold">
                        <tr>
                            <th class="ps-4 py-3">Hari</th>
                            <th>Mata Kuliah</th>
                            <th>Dosen</th>
                            <th>Waktu & Ruang</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $schedulesByDay = collect($schedules)->groupBy('day');
                        @endphp
                        @forelse($schedulesByDay as $day => $daySchedules)
                            @foreach($daySchedules as $index => $item)
                            <tr>
                                @if($index == 0)
                                    <td rowspan="{{ count($daySchedules) }}" class="ps-4 fw-bold text-primary align-middle border-end bg-light">{{ $day }}</td>
                                @endif
                            <td>
                                <span class="d-block fw-bold">{{ $item->subject->name }}</span>
                                <small class="text-muted">Angkatan: {{ $item->cohort }}</small>
                            </td>
                            <td>{{ $item->dosen->name }}</td>
                            <td>
                                <span class="badge bg-light text-dark border mb-1">
                                    <i class="bi bi-clock me-1"></i> {{ $item->start_time }} - {{ $item->end_time }}
                                </span>
                                <br>
                                <span class="badge bg-info text-white"><i class="bi bi-geo-alt me-1"></i>
                                    {{ $item->room }}</span>
                                
                                @if($item->overrides->count() > 0)
                                <div class="mt-2">
                                    <small class="fw-bold text-danger d-block mb-1">Perubahan Aktif:</small>
                                    @foreach($item->overrides as $override)
                                        <div class="border border-danger border-opacity-25 rounded p-2 mb-1 bg-danger bg-opacity-10" style="font-size: 0.75rem;">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="fw-bold text-danger">{{ $override->override_date->format('d M Y') }}</span>
                                                <form action="{{ route('staff.schedules.overrides.destroy', $override->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger p-0 ms-2" onclick="return confirm('Hapus perubahan ini? Jadwal akan kembali normal.')" title="Batal Override"><i class="bi bi-x-circle-fill"></i></button>
                                                </form>
                                            </div>
                                            @if($override->status === 'cancelled')
                                                <span class="badge bg-danger">KELAS DIBATALKAN</span>
                                            @else
                                                <span class="d-block"><i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($override->new_start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($override->new_end_time)->format('H:i') }}</span>
                                                <span class="d-block"><i class="bi bi-geo-alt"></i> {{ $override->new_room }}</span>
                                            @endif
                                            @if($override->note)
                                                <span class="d-block text-muted fst-italic mt-1">"{{ $override->note }}"</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalOverride{{ $item->id }}" title="Buat Override">
                                        <i class="bi bi-arrow-left-right"></i>
                                    </button>
                                    <form action="{{ route('staff.schedules.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus jadwal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i
                                                class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada data jadwal.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Overrides -->
@foreach($schedules as $item)
<div class="modal fade" id="modalOverride{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('staff.schedules.overrides.store', $item->id) }}" method="POST">
                @csrf
                <div class="modal-header bg-warning bg-opacity-25">
                    <h5 class="modal-title fw-bold"><i class="bi bi-arrow-left-right me-2 text-warning"></i> Override Jadwal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info border-0 p-3 mb-4 rounded-3" style="font-size: 0.85rem;">
                        Override digunakan untuk membatalkan jadwal atau memindahkan jam/ruangan <strong>hanya pada tanggal tertentu</strong>. Jadwal utama 1 semester tidak akan terhapus.
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Pilih Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="override_date" class="form-control" required>
                        <div class="form-text">Pilih tanggal spesifik perubahan ini berlaku. Pastikan harinya sesuai jadwal ({{ $item->day }}).</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Jenis Perubahan <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" onchange="toggleOverrideFields(this, '{{ $item->id }}')" required>
                            <option value="changed">Ganti Waktu / Ruangan</option>
                            <option value="cancelled">Batalkan Kelas (Diliburkan)</option>
                        </select>
                    </div>

                    <div id="fieldsChanged{{ $item->id }}">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Jam Mulai Baru</label>
                                <input type="time" name="new_start_time" class="form-control" value="{{ \Carbon\Carbon::parse($item->start_time)->format('H:i') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Jam Selesai Baru</label>
                                <input type="time" name="new_end_time" class="form-control" value="{{ \Carbon\Carbon::parse($item->end_time)->format('H:i') }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Ruangan Baru</label>
                            <input type="text" name="new_room" class="form-control" value="{{ $item->room }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Keterangan / Alasan Tambahan</label>
                        <textarea name="note" class="form-control" rows="2" placeholder="Cth: Dosen sedang tugas luar kota, kelas diganti via Zoom."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-warning fw-bold">Simpan Override</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<script>
function toggleOverrideFields(selectElement, id) {
    const fieldsDiv = document.getElementById('fieldsChanged' + id);
    const inputs = fieldsDiv.querySelectorAll('input');
    
    if (selectElement.value === 'cancelled') {
        fieldsDiv.style.display = 'none';
        inputs.forEach(input => input.removeAttribute('required'));
    } else {
        fieldsDiv.style.display = 'block';
        inputs.forEach(input => input.setAttribute('required', 'required'));
    }
}
</script>


<div class="modal fade" id="modalTambahJadwal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('staff.schedules.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Jadwal Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Mata Kuliah</label>
                        <select name="subject_id" class="form-control">
                            @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Dosen Pengampu</label>
                        <select name="user_id" class="form-select" required>
                            @foreach($dosens as $d) <option value="{{ $d->id }}">{{ $d->name }}</option> @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Hari</label>
                            <select name="day" class="form-select">
                                <option>Senin</option>
                                <option>Selasa</option>
                                <option>Rabu</option>
                                <option>Kamis</option>
                                <option>Jumat</option>
                                <option>Sabtu</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Angkatan (Cohort)</label>
                            <select name="cohort" class="form-select" required>
                                <option value="">Pilih Angkatan...</option>
                                @foreach($availableCohorts as $c)
                                    <option value="{{ $c }}">{{ $c }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Jam Mulai</label>
                            <input type="time" name="start_time" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Jam Selesai</label>
                            <input type="time" name="end_time" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Ruangan</label>
                        <input type="text" name="room" class="form-control" placeholder="Contoh: Lab Komputer 1"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection