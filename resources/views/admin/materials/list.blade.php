@extends('layouts.app')

@section('title', 'Daftar Bahan Ajar')

@section('content')
<div class="container-fluid text-white pb-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2" style="font-size: 0.85rem;">
                    <li class="breadcrumb-item"><a href="{{ route('admin.materials.index') }}" class="text-secondary text-decoration-none hover-primary">Bahan Ajar</a></li>
                    <li class="breadcrumb-item active text-info" aria-current="page">Cohort {{ $selectedCohort }}</li>
                </ol>
            </nav>
            <h2 class="fw-bold mb-0" style="letter-spacing: -1px;">Daftar Materi <span class="text-primary">— Angkatan {{ $selectedCohort }}</span></h2>
        </div>

        <a href="{{ route('admin.materials.create', ['cohort' => $selectedCohort]) }}" class="btn btn-primary px-4 py-2 fw-bold shadow-sm rounded-3">
            <i class="bi bi-plus-lg me-2"></i> Tambah Materi
        </a>
    </div>

    <div class="card border-0 shadow-lg" style="background: #15191d; border-radius: 12px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0 align-middle">
                <thead style="background: #1c2227;">
                    <tr>
                        <th class="ps-4 py-3 text-secondary fw-semibold small text-uppercase" style="letter-spacing: 1px;">Materi & Deskripsi</th>
                        <th class="text-center text-secondary fw-semibold small text-uppercase" style="letter-spacing: 1px;">Tipe</th>
                        <th class="text-secondary fw-semibold small text-uppercase" style="letter-spacing: 1px;">Diterbitkan Oleh</th>
                        <th class="text-secondary fw-semibold small text-uppercase" style="letter-spacing: 1px;">Waktu Unggah</th>
                        <th class="text-end pe-4 text-secondary fw-semibold small text-uppercase" style="letter-spacing: 1px;">Aksi</th>
                    </tr>
                </thead>
                <tbody style="border-top: none;">
                    @forelse($materials as $material)
                        <tr class="border-bottom border-secondary border-opacity-10">
                            <td class="ps-4 py-4">
                                <div class="fw-bold text-white fs-5 mb-1">{{ $material->title }}</div>
                                <div class="text-secondary small fw-light" style="max-width: 300px; line-height: 1.4;">
                                    {{ $material->description ?? 'Tidak ada deskripsi tambahan untuk materi ini.' }}
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-3 py-2" style="font-size: 0.7rem;">
                                    <i class="bi bi-file-earmark-text me-1"></i> {{ strtoupper($material->file_type) }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-3 me-3 d-flex align-items-center justify-content-center shadow-sm" 
                                         style="width: 38px; height: 38px; background: linear-gradient(45deg, #0d6efd, #0dcaf0); font-weight: 800;">
                                        {{ strtoupper(substr($material->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-white fw-semibold small">{{ $material->user->name }}</div>
                                        <div class="text-secondary" style="font-size: 0.75rem;">Administrator</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-white small fw-medium">{{ $material->created_at->translatedFormat('d M Y') }}</div>
                                <div class="text-info opacity-75" style="font-size: 0.7rem;">
                                    <i class="bi bi-clock-history me-1"></i> {{ $material->created_at->diffForHumans() }}
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ asset('storage/' . $material->file_path) }}" 
                                       download="{{ $material->title }}" 
                                       class="btn btn-icon btn-outline-success" 
                                       title="Download Materi">
                                        <i class="bi bi-cloud-arrow-down-fill"></i>
                                    </a>

                                    <form action="{{ route('admin.materials.destroy', $material->id) }}" method="POST" class="d-inline">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-icon btn-outline-danger" 
                                                onclick="return confirm('Hapus materi ini selamanya?')"
                                                title="Hapus">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 border-0">
                                <div class="py-5">
                                    <i class="bi bi-folder2-open display-1 text-secondary opacity-25"></i>
                                    <h5 class="mt-3 text-secondary">Belum ada materi yang tersedia</h5>
                                    <p class="text-muted small">Klik tombol "Tambah Materi" untuk memulai.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .hover-primary:hover { color: #0d6efd !important; }
    .stat-card { transition: all 0.3s ease; }
    
    /* Styling khusus tombol aksi agar bulat sempurna */
    .btn-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        border: 1px solid rgba(255,255,255,0.05);
        background: rgba(255,255,255,0.02);
    }
    
    .btn-icon:hover {
        transform: translateY(-2px);
    }
    
    .btn-outline-success:hover { background-color: #198754; color: white; border-color: #198754; }
    .btn-outline-danger:hover { background-color: #dc3545; color: white; border-color: #dc3545; }

    /* Animasi baris tabel */
    tbody tr { transition: background 0.2s; }
    tbody tr:hover { background: rgba(255, 255, 255, 0.02) !important; }

    /* Breadcrumb custom separator */
    .breadcrumb-item + .breadcrumb-item::before {
        content: "—";
        color: #495057;
    }
</style>
@endsection
