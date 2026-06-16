@extends('layouts.mahasiswa')

@section('title', 'Surat & Berkas')

@section('content')

<div class="mhs-card">
    <div class="mhs-card-header">
        <h6 class="mhs-card-title">
            <span class="mhs-card-icon" style="background:var(--warning-light);color:var(--warning);">
                <i class="bi bi-envelope-paper"></i>
            </span>
            Surat & Berkas
        </h6>
        <a href="{{ route('mahasiswa.submissions.create') }}" class="mhs-btn mhs-btn-primary mhs-btn-sm">
            <i class="bi bi-plus-lg"></i> Buat Pengajuan
        </a>
    </div>
    <div style="overflow-x:auto;">
        <table class="mhs-table">
            <thead>
                <tr>
                    <th style="padding-left:20px;">Pengajuan</th>
                    <th>Tipe</th>
                    <th>Status</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($submissions as $submission)
                <tr>
                    <td style="padding-left:20px;">
                        <div style="font-weight:700;color:var(--text-1);margin-bottom:3px;">{{ $submission->title }}</div>
                        <div style="font-size:0.72rem;color:var(--text-3);"><i class="bi bi-calendar me-1"></i>{{ $submission->created_at->format('d M Y') }}</div>
                    </td>
                    <td>
                        <span class="mhs-badge muted">{{ $submission->type }}</span>
                    </td>
                    <td>
                        @if($submission->status === 'approved')
                            <span class="mhs-badge success"><i class="bi bi-check-circle me-1"></i>Disetujui</span>
                        @elseif($submission->status === 'rejected')
                            <span class="mhs-badge danger"><i class="bi bi-x-circle me-1"></i>Ditolak</span>
                        @elseif($submission->status === 'revision')
                            <span class="mhs-badge warning"><i class="bi bi-pencil me-1"></i>Revisi</span>
                        @else
                            <span class="mhs-badge muted"><i class="bi bi-hourglass-split me-1"></i>Menunggu</span>
                        @endif
                    </td>
                    <td style="text-align:center;">
                        <div style="display:flex;gap:6px;justify-content:center;">
                            <a href="{{ route('mahasiswa.submissions.show', $submission->id) }}"
                               class="mhs-btn mhs-btn-ghost mhs-btn-sm" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if(in_array($submission->status, ['pending', 'revision']))
                            <a href="{{ route('mahasiswa.submissions.edit', $submission->id) }}"
                               class="mhs-btn mhs-btn-ghost mhs-btn-sm" title="Edit" style="border-color:rgba(0,102,255,0.3);color:var(--primary);">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @endif
                            @if($submission->status !== 'approved')
                            <form action="{{ route('mahasiswa.submissions.destroy', $submission->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengajuan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="mhs-btn mhs-btn-danger mhs-btn-sm" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">
                        <div class="mhs-empty" style="padding:40px;">
                            <i class="bi bi-folder-x"></i>
                            <p>Belum ada pengajuan berkas.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
