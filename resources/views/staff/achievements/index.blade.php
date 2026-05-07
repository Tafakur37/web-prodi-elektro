@extends('layouts.app')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="card card-custom p-4 mb-4 bg-white border-start border-4 border-warning shadow-sm">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold mb-1"><i class="bi bi-trophy me-2 text-warning"></i>Manajemen Prestasi Mahasiswa</h4>
                <p class="text-muted mb-0">Input dan kelola data prestasi (akademik/non-akademik) mahasiswa.</p>
            </div>
            <button type="button" class="btn btn-warning shadow-sm fw-bold" data-bs-toggle="modal"
                data-bs-target="#modalTambahPrestasi">
                <i class="bi bi-plus-lg me-1"></i> Input Prestasi
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <form action="{{ route('staff.achievements.index') }}" method="GET" class="d-flex align-items-end gap-3">
                <div style="min-width: 250px;">
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

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small fw-bold">
                        <tr>
                            <th class="ps-4">Mahasiswa</th>
                            <th>Prestasi & Tingkat</th>
                            <th>Tanggal</th>
                            <th>Lampiran</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($achievements as $item)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $item->user->name }}</div>
                                <div class="small text-muted">{{ $item->user->nim }} | Cohort {{ $item->user->cohort }}</div>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $item->title }}</div>
                                <span class="badge bg-info text-dark">{{ $item->level }}</span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($item->date)->translatedFormat('d M Y') }}</td>
                            <td>
                                @if($item->attachment)
                                    <a href="{{ Storage::url($item->attachment) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill">
                                        <i class="bi bi-file-earmark-pdf me-1"></i> Lihat File
                                    </a>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td class="text-center pe-4">
                                <form action="{{ route('staff.achievements.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus prestasi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger shadow-sm"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-trophy fs-1 d-block mb-2 text-warning opacity-50"></i>
                                Belum ada data prestasi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($achievements->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $achievements->links() }}
        </div>
        @endif
    </div>
</div>

<div class="modal fade" id="modalTambahPrestasi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('staff.achievements.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-warning bg-opacity-25 pb-3">
                    <h5 class="modal-title fw-bold text-dark"><i class="bi bi-plus-circle me-2 text-warning"></i> Input Prestasi Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Pilih Mahasiswa <span class="text-danger">*</span></label>
                        <select name="user_id" class="form-select select2" required style="width: 100%;">
                            <option value="">Cari mahasiswa...</option>
                            @foreach($students as $s)
                                <option value="{{ $s->id }}">{{ $s->nim }} - {{ $s->name }} (Cohort {{ $s->cohort }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Nama Prestasi <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="Juara 1 Lomba Web Design..." required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">Tingkat / Level <span class="text-danger">*</span></label>
                            <input type="text" name="level" class="form-control" placeholder="Nasional, Internasional, dll" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Deskripsi Singkat</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Keterangan tambahan (opsional)"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Lampiran (PDF/JPG/PNG/DOC/PPT/XLS/ZIP, Max 10MB)</label>
                        <input type="file" name="attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.gif,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip">
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning px-4 fw-bold">Simpan Prestasi</button>
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
$(document).ready(function() {
    $('.select2').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#modalTambahPrestasi')
    });
});
</script>
@endpush
