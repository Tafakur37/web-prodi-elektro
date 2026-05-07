@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0 text-dark border-start border-4 border-primary ps-3">Verifikasi Surat & Berkas</h3>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-uppercase small text-muted">
                        <tr>
                            <th class="py-3 px-4">Pengajuan & Pengaju</th>
                            <th class="py-3">Tipe Dokumen</th>
                            <th class="py-3">Tanggal Masuk</th>
                            <th class="py-3">Status</th>
                            <th class="py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($submissions as $submission)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="fw-bold text-dark mb-1">{{ $submission->title }}</div>
                                <div class="text-secondary small"><i class="bi bi-person me-1"></i> {{ $submission->user->name }} ({{ $submission->user->nim }})</div>
                            </td>
                            <td><span class="badge bg-light text-dark border">{{ $submission->type }}</span></td>
                            <td>{{ $submission->created_at->format('d M Y H:i') }}</td>
                            <td>
                                @if($submission->status === 'approved')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill"><i class="bi bi-check-circle me-1"></i> Disetujui</span>
                                @elseif($submission->status === 'rejected')
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill"><i class="bi bi-x-circle me-1"></i> Ditolak</span>
                                @elseif($submission->status === 'revision')
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2 rounded-pill"><i class="bi bi-pencil me-1"></i> Revisi</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2 rounded-pill"><i class="bi bi-hourglass-split me-1"></i> Menunggu</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('staff.submissions.show', $submission->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3" data-bs-toggle="tooltip" title="Tinjau Berkas">
                                    <i class="bi bi-search me-1"></i> Tinjau
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                                Belum ada pengajuan berkas masuk.
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
