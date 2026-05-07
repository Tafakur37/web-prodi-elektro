@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0 text-dark border-start border-4 border-primary ps-3">Surat & Berkas</h3>
            <p class="text-muted mb-0 mt-1 ms-3">Manajemen pengajuan dokumen masuk dan pengiriman berkas.</p>
        </div>
        <div class="bg-primary bg-opacity-10 p-2 px-3 rounded-pill text-primary fw-bold">
            <i class="bi bi-file-earmark-text me-2"></i> Total: {{ $incomingDocuments->count() + $myDocuments->count() }} Dokumen
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-0">
            <ul class="nav nav-tabs nav-fill border-bottom-0 p-1 bg-light rounded-top-4" id="documentTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold text-dark py-3 border-0 rounded-4" id="incoming-tab" data-bs-toggle="tab" data-bs-target="#incoming" type="button" role="tab">
                        <i class="bi bi-inbox me-2 text-primary"></i> Dokumen Masuk
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold text-dark py-3 border-0 rounded-4" id="outgoing-tab" data-bs-toggle="tab" data-bs-target="#outgoing" type="button" role="tab">
                        <i class="bi bi-send me-2 text-primary"></i> Kirim Berkas
                    </button>
                </li>
            </ul>

            <div class="tab-content p-4" id="documentTabContent">
                <!-- DOKUMEN MASUK -->
                <div class="tab-pane fade show active" id="incoming" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-muted small text-uppercase fw-bold">
                                <tr>
                                    <th class="ps-3 py-3">Pengirim</th>
                                    <th>Judul Dokumen</th>
                                    <th>Kategori</th>
                                    <th>Tanggal</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($incomingDocuments as $doc)
                                <tr>
                                    <td class="ps-3">
                                        <div class="fw-bold text-dark">{{ $doc->user->name }}</div>
                                        <div class="small text-muted">{{ $doc->user->nim ?? 'N/A' }}</div>
                                    </td>
                                    <td class="fw-medium">{{ $doc->title }}</td>
                                    <td><span class="badge bg-info bg-opacity-10 text-info border border-info">{{ strtoupper($doc->category) }}</span></td>
                                    <td class="text-muted small">{{ $doc->created_at->format('d M Y H:i') }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('staff.documents.download', $doc->id) }}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Download">
                                                <i class="bi bi-download"></i>
                                            </a>
                                            <form action="{{ route('staff.documents.destroy', $doc->id) }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus dokumen ini?')" data-bs-toggle="tooltip" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-folder2-open fs-1 d-block mb-3 opacity-25"></i>
                                        Belum ada dokumen masuk.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- KIRIM BERKAS -->
                <div class="tab-pane fade" id="outgoing" role="tabpanel">
                    <div class="row g-4">
                        <div class="col-md-5">
                            <div class="card border border-light shadow-sm rounded-4 h-100">
                                <div class="card-body p-4">
                                    <h5 class="mb-4 fw-bold"><i class="bi bi-upload me-2 text-primary"></i> Upload Berkas Baru</h5>
                                    <form action="{{ route('staff.documents.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Judul Surat/Berkas <span class="text-danger">*</span></label>
                                            <input type="text" name="title" class="form-control" required placeholder="Contoh: Surat Pengantar">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label small fw-bold">Kategori <span class="text-danger">*</span></label>
                                                <select name="category" class="form-select">
                                                    <option value="surat">Surat</option>
                                                    <option value="berkas">Berkas</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label small fw-bold">Tujuan <span class="text-danger">*</span></label>
                                                <select name="receiver_role" class="form-select">
                                                    <option value="dosen">Dosen</option>
                                                    <option value="admin">Admin</option>
                                                    <option value="sesprodi">Sesprodi</option>
                                                    <option value="kaprodi">Kaprodi</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Pilih File (PDF/Doc/Zip) <span class="text-danger">*</span></label>
                                            <input type="file" name="file" class="form-control" required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label small fw-bold">Keterangan Tambahan</label>
                                            <textarea name="description" class="form-control" rows="3"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100 fw-bold rounded-pill">
                                            <i class="bi bi-send-fill me-2"></i> Kirim Dokumen
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-7">
                            <h5 class="mb-3 fw-bold ps-2 border-start border-3 border-info">Riwayat Pengiriman Anda</h5>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light text-muted small text-uppercase fw-bold">
                                        <tr>
                                            <th class="ps-3 py-3">Judul</th>
                                            <th>Tujuan</th>
                                            <th>Status</th>
                                            <th class="text-end pe-3">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($myDocuments as $myDoc)
                                        <tr>
                                            <td class="ps-3 fw-medium">{{ $myDoc->title }}</td>
                                            <td><span class="badge bg-secondary">{{ strtoupper($myDoc->receiver_role) }}</span></td>
                                            <td><span class="badge bg-warning text-dark">{{ ucfirst($myDoc->status) }}</span></td>
                                            <td class="text-end pe-3">
                                                <a href="{{ route('staff.documents.download', $myDoc->id) }}" class="btn btn-sm btn-light text-primary border me-1"><i class="bi bi-download"></i></a>
                                                <form action="{{ route('staff.documents.destroy', $myDoc->id) }}" method="POST" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-light text-danger border" onclick="return confirm('Hapus?')"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted small">Belum ada riwayat pengiriman dokumen.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .nav-tabs .nav-link.active {
        background-color: #fff !important;
        color: #0d6efd !important;
        box-shadow: 0 -3px 0 #0d6efd inset;
    }
    .nav-tabs .nav-link {
        color: #6c757d;
    }
</style>
@endsection