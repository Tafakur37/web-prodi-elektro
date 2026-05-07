@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <div class="card card-custom p-4 mb-4 bg-white border-start border-4 border-primary shadow-sm">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1"><i class="bi bi-journal-text me-2 text-primary"></i>Manajemen Jadwal Ujian</h4>
                <p class="text-muted mb-0">Kelola jadwal UTS, UAS, dan Kuis per angkatan.</p>
            </div>
            <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal"
                data-bs-target="#modalTambahUjian">
                <i class="bi bi-plus-lg me-1"></i> Tambah Ujian
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <form action="{{ route('staff.exams.index') }}" method="GET" class="d-flex align-items-end gap-3">
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
                            <th class="ps-4 py-3">Tanggal</th>
                            <th>Tipe Ujian</th>
                            <th>Mata Kuliah</th>
                            <th>Waktu & Ruang</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($exams as $item)
                        <tr>
                            <td class="ps-4 fw-bold text-primary">{{ \Carbon\Carbon::parse($item->date)->translatedFormat('l, d M Y') }}</td>
                            <td>
                                <span class="badge {{ $item->type == 'uas' ? 'bg-danger' : ($item->type == 'uts' ? 'bg-warning text-dark' : 'bg-info text-dark') }} text-uppercase">
                                    {{ $item->type }}
                                </span>
                            </td>
                            <td>
                                <span class="d-block fw-bold">{{ $item->subject->name }}</span>
                                <small class="text-muted">Angkatan: {{ $item->cohort }}</small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border mb-1">
                                    <i class="bi bi-clock me-1"></i> {{ \Carbon\Carbon::parse($item->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->end_time)->format('H:i') }}
                                </span>
                                <br>
                                <span class="badge bg-info text-white"><i class="bi bi-geo-alt me-1"></i>
                                    {{ $item->room }}</span>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('staff.exams.destroy', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus jadwal ujian ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i
                                            class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada data jadwal ujian.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahUjian" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('staff.exams.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Jadwal Ujian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Tipe Ujian</label>
                        <select name="type" class="form-select" required>
                            <option value="kuis">Kuis</option>
                            <option value="uts">UTS</option>
                            <option value="uas">UAS</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Mata Kuliah</label>
                        <select name="subject_id" class="form-select" required>
                            @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Tanggal</label>
                            <input type="date" name="date" class="form-control" required>
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
                        <input type="text" name="room" class="form-control" placeholder="Contoh: Ruang Ujian 1"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan Jadwal Ujian</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
