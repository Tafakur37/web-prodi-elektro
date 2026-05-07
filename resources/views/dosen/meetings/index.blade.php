@extends('layouts.app')

@section('title', 'Bimbingan / Wali')

@section('content')
<div class="container-fluid p-0">

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold mb-1 text-dark">
                    <i class="bi bi-people-fill text-primary me-2"></i> Kelola Request Bimbingan
                </h5>
                <p class="text-muted small mb-0">Terima, tolak, atau buat jadwal bimbingan baru untuk mahasiswa.</p>
            </div>
            <a href="{{ route('dosen.meetings.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">
                <i class="bi bi-plus-lg me-2"></i> Buat Jadwal
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3">Mahasiswa</th>
                            <th class="py-3">Tanggal Request</th>
                            <th class="py-3">Topik Bimbingan</th>
                            <th class="py-3 text-center">Status</th>
                            <th class="py-3 text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($meetings as $meeting)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $meeting->student->name ?? 'Mahasiswa tidak ditemukan' }}</div>
                                <small class="text-muted">{{ $meeting->student->nim ?? '-' }}</small>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($meeting->requested_date)->translatedFormat('d F Y') }}</td>
                            <td>{{ $meeting->topic }}</td>
                            <td class="text-center">
                                @if($meeting->status == 'pending')
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 rounded-pill">Pending</span>
                                @elseif($meeting->status == 'approved')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">Disetujui</span>
                                @elseif($meeting->status == 'rejected')
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">Ditolak</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border px-3 py-2 rounded-pill">{{ ucfirst($meeting->status) }}</span>
                                @endif
                            </td>
                            <td class="text-center pe-4">
                                @if($meeting->status == 'pending')
                                <div class="d-flex justify-content-center gap-1">
                                    <form action="{{ route('dosen.meetings.update', $meeting->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn btn-sm btn-outline-success rounded-circle" title="Terima">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('dosen.meetings.update', $meeting->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Tolak">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                </div>
                                @else
                                    <span class="text-muted small fst-italic">Selesai</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                                <p class="fw-bold text-dark mb-1">Tidak ada data bimbingan.</p>
                                <p class="small">Belum ada mahasiswa yang merequest bimbingan kepada Anda.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection