@extends('layouts.app')

@section('title', 'Jadwal Kuliah')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-0 text-white">Jadwal Mengajar</h1>
            <p class="text-secondary">Kelola waktu perkuliahan, dosen, dan ruangan kelas.</p>
        </div>
        <button type="button" class="btn btn-info fw-bold text-dark" data-bs-toggle="modal"
            data-bs-target="#addScheduleModal">
            <i class="bi bi-calendar-plus me-2"></i> Tambah Jadwal
        </button>
    </div>

    @if(session('success'))
    <div class="alert alert-success bg-dark text-success border-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="stat-card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0">
                <thead class="bg-darker">
                    <tr class="text-secondary border-bottom border-secondary">
                        <th class="ps-4 py-3">Hari</th>
                        <th class="py-3">Waktu</th>
                        <th class="py-3">Mata Kuliah</th>
                        <th class="py-3">Dosen</th>
                        <th class="py-3">Ruangan</th>
                        <th class="py-3">Angkatan</th>
                        <th class="py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schedules as $schedule)
                    <tr class="align-middle">
                        <td class="ps-4 fw-bold text-info">{{ $schedule->day }}</td>
                        <td>
                            <span class="badge bg-secondary">
                                {{ date('H:i', strtotime($schedule->start_time)) }} -
                                {{ date('H:i', strtotime($schedule->end_time)) }}
                            </span>
                        </td>
                        <td>{{ $schedule->subject->name ?? 'N/A' }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-person-circle me-2 text-secondary"></i>
                                {{ $schedule->dosen->name ?? 'N/A' }}
                            </div>
                        </td>
                        <td><i class="bi bi-geo-alt me-1 text-danger"></i> {{ $schedule->room }}</td>
                        <td><span class="badge border border-secondary text-secondary">Angkatan
                                {{ $schedule->cohort }}</span></td>
                        <td class="text-center">
                            <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST"
                                class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger border-0"
                                    onclick="return confirm('Hapus jadwal ini?')">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-secondary">
                            <i class="bi bi-calendar-x d-block fs-2 mb-2"></i>
                            Belum ada jadwal yang dibuat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addScheduleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary text-white">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold text-info"><i class="bi bi-plus-circle me-2"></i> Buat Jadwal Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.schedules.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-secondary small">Hari</label>
                            <select name="day" class="form-select bg-dark text-white border-secondary" required>
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jumat">Jumat</option>
                                <option value="Sabtu">Sabtu</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary small">Angkatan</label>
                            <input type="number" name="cohort" class="form-control bg-dark text-white border-secondary"
                                placeholder="2023" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Pilih Dosen</label>
                        <select name="user_id" class="form-control" required>
                            <option value="">-- Pilih Dosen --</option>
                            @foreach($dosens as $dosen)
                            <option value="{{ $dosen->id }}">{{ $dosen->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small">Mata Kuliah</label>
                        <select name="subject_id" class="form-select bg-dark text-white border-secondary" required>
                            <option value="">Pilih Mata Kuliah...</option>
                            @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-secondary small">Jam Mulai</label>
                            <input type="time" name="start_time"
                                class="form-control bg-dark text-white border-secondary" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-secondary small">Jam Selesai</label>
                            <input type="time" name="end_time" class="form-control bg-dark text-white border-secondary"
                                required>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label text-secondary small">Ruangan Kelas</label>
                        <input type="text" name="room" class="form-control bg-dark text-white border-secondary"
                            placeholder="Contoh: R.301 atau Lab Dasar" required>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info text-dark fw-bold px-4">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.bg-darker {
    background-color: #111;
}

.form-control:focus,
.form-select:focus {
    background-color: #222;
    border-color: #00d2ff;
    color: white;
    box-shadow: none;
}

.table-hover tbody tr:hover {
    background-color: #252525 !important;
}
</style>
@endsection
