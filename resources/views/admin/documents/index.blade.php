@extends('layouts.app')

@section('title', 'Surat & Berkas')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-0 text-white">Surat & Berkas</h1>
            <p class="text-secondary">Manajemen pengajuan dokumen mahasiswa dan pengiriman berkas struktural.</p>
        </div>
        <div class="bg-dark p-2 px-3 rounded border border-secondary text-white">
            <i class="bi bi-file-earmark-text me-2 accent-color"></i> Total: {{ $incomingDocuments->count() + $myDocuments->count() }} Dokumen
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show bg-dark text-success border-success" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="stat-card">
        <ul class="nav nav-tabs border-secondary mb-4" id="documentTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active text-white border-0 bg-transparent" id="incoming-tab" data-bs-toggle="tab" data-bs-target="#incoming" type="button" role="tab">
                    <i class="bi bi-inbox me-2"></i> Masuk dari Mahasiswa
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-white border-0 bg-transparent" id="outgoing-tab" data-bs-toggle="tab" data-bs-target="#outgoing" type="button" role="tab">
                    <i class="bi bi-send me-2"></i> Kirim Berkas (Admin)
                </button>
            </li>
        </ul>

        <div class="tab-content" id="documentTabContent">
            <div class="tab-pane fade show active" id="incoming" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr class="text-secondary">
                                <th>Pengirim</th>
                                <th>Judul Dokumen</th>
                                <th>Kategori</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($incomingDocuments as $doc)
                            <tr>
                                <td>
                                    {{ $doc->user->name }}<br>
                                    <small class="text-secondary">{{ $doc->user->nim ?? 'Admin' }}</small>
                                </td>
                                <td>{{ $doc->title }}</td>
                                <td><span class="badge bg-info">{{ strtoupper($doc->category) }}</span></td>
                                <td>{{ $doc->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.documents.download', $doc->id) }}" class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-download"></i>
                                    </a>
                                    <form action="{{ route('admin.documents.destroy', $doc->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus dokumen ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-secondary py-4">Belum ada dokumen masuk.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="outgoing" role="tabpanel">
                <div class="row">
                    <div class="col-md-5">
                        <div class="p-4 rounded bg-dark border border-secondary">
                            <h5 class="mb-4 text-info"><i class="bi bi-upload me-2"></i> Upload Berkas Baru</h5>
                            <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Judul Surat/Berkas</label>
                                    <input type="text" name="title" class="form-control bg-dark text-white border-secondary" required placeholder="Contoh: Surat Pengantar KKN">
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Kategori</label>
                                        <select name="category" class="form-select bg-dark text-white border-secondary">
                                            <option value="surat">Surat</option>
                                            <option value="berkas">Berkas</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tujuan</label>
                                        <select name="receiver_role" class="form-select bg-dark text-white border-secondary">
                                            <option value="dosen">Dosen</option>
                                            <option value="staff">Staff</option>
                                            <option value="sesprodi">Sesprodi</option>
                                            <option value="kaprodi">Kaprodi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Pilih File (PDF/Doc/Zip)</label>
                                    <input type="file" name="file" class="form-control bg-dark text-white border-secondary" required>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Keterangan Tambahan</label>
                                    <textarea name="description" class="form-control bg-dark text-white border-secondary" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-info w-100 fw-bold text-dark">
                                    <i class="bi bi-send-fill me-2"></i> Kirim Dokumen
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="col-md-7">
                        <h5 class="mb-3 text-secondary">Riwayat Pengiriman Anda</h5>
                        <div class="table-responsive">
                            <table class="table table-dark table-hover border-secondary">
                                <thead>
                                    <tr class="text-secondary small">
                                        <th>Judul</th>
                                        <th>Tujuan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($myDocuments as $myDoc)
                                    <tr>
                                        <td>{{ $myDoc->title }}</td>
                                        <td><span class="badge bg-secondary">{{ strtoupper($myDoc->receiver_role) }}</span></td>
                                        <td><span class="text-warning small">{{ ucfirst($myDoc->status) }}</span></td>
                                        <td>
                                            <a href="{{ route('admin.documents.download', $myDoc->id) }}" class="text-info me-2"><i class="bi bi-download"></i></a>
                                            <form action="{{ route('admin.documents.destroy', $myDoc->id) }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button class="border-0 bg-transparent text-danger p-0" onclick="return confirm('Hapus?')"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .nav-tabs .nav-link.active {
        border-bottom: 2px solid #00d2ff !get-studentsimportant;
        color: #00d2ff !important;
    }
    .form-control:focus, .form-select:focus {
        background-color: #222;
        border-color: #00d2ff;
        color: white;
        box-shadow: none;
    }
</style>
@endsection
