@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0 text-dark border-start border-4 border-primary ps-3">Manajemen Bahan Ajar</h3>
        <a href="{{ route('dosen.materials.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="bi bi-cloud-arrow-up me-2"></i> Unggah Materi
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-uppercase small text-muted">
                        <tr>
                            <th class="py-3 px-4">Materi</th>
                            <th class="py-3">Mata Kuliah</th>
                            <th class="py-3">Angkatan</th>
                            <th class="py-3">Tipe File</th>
                            <th class="py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($materials as $material)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="fw-bold text-dark mb-1">{{ $material->title }}</div>
                                <div class="text-muted small">{{ Str::limit($material->description, 50) }}</div>
                                <div class="text-secondary small mt-1"><i class="bi bi-clock me-1"></i> {{ $material->created_at->diffForHumans() }}</div>
                            </td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                    {{ $material->subject ? $material->subject->name : 'Materi Umum' }}
                                </span>
                            </td>
                            <td>Cohort {{ $material->cohort }}</td>
                            <td>
                                <span class="badge bg-secondary px-3 py-2 rounded-pill text-uppercase">{{ $material->file_type }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('mahasiswa.materials.download', $material->id) }}" class="btn btn-sm btn-outline-info rounded-circle" data-bs-toggle="tooltip" title="Download">
                                    <i class="bi bi-download"></i>
                                </a>
                                <form action="{{ route('dosen.materials.destroy', $material->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" data-bs-toggle="tooltip" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-folder-x fs-1 d-block mb-3 opacity-25"></i>
                                Belum ada bahan ajar yang diunggah.
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
