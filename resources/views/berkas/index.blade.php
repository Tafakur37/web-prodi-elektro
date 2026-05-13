@extends('layouts.app')

@section('title', 'File Explorer')
@section('page-title', 'Penyimpanan Berkas Pribadi')

@section('content')
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-white border-bottom border-light p-4 d-flex justify-content-between align-items-center">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route($role . '.berkas.index') }}" class="text-decoration-none">
                            <i class="bi bi-house-door-fill text-primary"></i> Root
                        </a>
                    </li>
                    @foreach($breadcrumbs as $bc)
                    <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}" {{ $loop->last ? 'aria-current="page"' : '' }}>
                        @if(!$loop->last)
                            <a href="{{ route($role . '.berkas.index', $bc->id) }}" class="text-decoration-none">{{ $bc->name }}</a>
                        @else
                            {{ $bc->name }}
                        @endif
                    </li>
                    @endforeach
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-sm btn-outline-primary fw-bold rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalCreateFolder">
                <i class="bi bi-folder-plus me-1"></i> Buat Folder
            </button>
            <button class="btn btn-sm btn-primary fw-bold rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalUploadFile">
                <i class="bi bi-cloud-upload me-1"></i> Upload File
            </button>
        </div>
    </div>
    
    <div class="card-body p-4">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if($folders->isEmpty() && $files->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-folder2-open display-1 text-muted mb-3 d-block opacity-50"></i>
            <h5 class="text-secondary mb-1">Folder ini kosong</h5>
            <p class="small text-muted mb-0">Mulai dengan membuat folder atau mengunggah file baru.</p>
        </div>
        @else
        <div class="row g-3">
            {{-- Render Folders --}}
            @foreach($folders as $folder)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 border-light shadow-sm rounded-4 folder-card" style="cursor: pointer;">
                    <div class="card-body p-3 d-flex flex-column align-items-center position-relative">
                        <a href="{{ route($role . '.berkas.index', $folder->id) }}" class="stretched-link text-decoration-none text-dark d-flex flex-column align-items-center w-100">
                            <i class="bi bi-folder-fill text-warning" style="font-size: 3rem;"></i>
                            <span class="fw-bold mt-2 text-center text-truncate w-100 px-2" title="{{ $folder->name }}">{{ $folder->name }}</span>
                        </a>
                        <div class="position-absolute top-0 end-0 mt-2 me-2" style="z-index: 2;">
                            <form action="{{ route($role . '.berkas.folder.destroy', $folder->id) }}" method="POST" onsubmit="return confirm('Hapus folder ini beserta seluruh isinya?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-link text-danger p-0" title="Hapus Folder"><i class="bi bi-trash-fill"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- Render Files --}}
            @foreach($files as $file)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 border-light shadow-sm rounded-4 file-card">
                    <div class="card-body p-3 d-flex flex-column align-items-center position-relative">
                        @php
                            $icon = 'bi-file-earmark-text';
                            $color = 'text-primary';
                            if(in_array(strtolower($file->extension), ['pdf'])) { $icon = 'bi-file-earmark-pdf-fill'; $color = 'text-danger'; }
                            if(in_array(strtolower($file->extension), ['doc', 'docx'])) { $icon = 'bi-file-earmark-word-fill'; $color = 'text-primary'; }
                            if(in_array(strtolower($file->extension), ['xls', 'xlsx'])) { $icon = 'bi-file-earmark-excel-fill'; $color = 'text-success'; }
                            if(in_array(strtolower($file->extension), ['jpg', 'jpeg', 'png', 'gif'])) { $icon = 'bi-file-earmark-image-fill'; $color = 'text-info'; }
                            if(in_array(strtolower($file->extension), ['zip', 'rar'])) { $icon = 'bi-file-earmark-zip-fill'; $color = 'text-warning'; }
                        @endphp
                        
                        <a href="{{ route($role . '.berkas.file.download', $file->id) }}" class="stretched-link text-decoration-none text-dark d-flex flex-column align-items-center w-100">
                            <i class="bi {{ $icon }} {{ $color }}" style="font-size: 3rem;"></i>
                            <span class="fw-bold mt-2 text-center text-truncate w-100 px-2" title="{{ $file->name }}" style="font-size: 0.85rem;">{{ $file->name }}</span>
                            <small class="text-muted mt-1" style="font-size: 0.7rem;">{{ number_format($file->size / 1024, 2) }} KB</small>
                        </a>
                        
                        <div class="position-absolute top-0 end-0 mt-2 me-2" style="z-index: 2;">
                            <form action="{{ route($role . '.berkas.file.destroy', $file->id) }}" method="POST" onsubmit="return confirm('Hapus file ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-link text-danger p-0" title="Hapus File"><i class="bi bi-trash-fill"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

{{-- MODAL BUAT FOLDER --}}
<div class="modal fade" id="modalCreateFolder" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <form action="{{ route($role . '.berkas.folder.store') }}" method="POST">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $currentFolder ? $currentFolder->id : '' }}">
                <div class="modal-header border-bottom border-light p-4">
                    <h6 class="modal-title fw-bold"><i class="bi bi-folder-plus text-primary me-2"></i>Buat Folder Baru</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 bg-light">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Nama Folder</label>
                        <input type="text" name="name" class="form-control rounded-3" placeholder="Contoh: Tugas Akhir, Laporan, dll" required>
                    </div>
                </div>
                <div class="modal-footer border-top border-light p-3">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Buat Folder</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL UPLOAD FILE --}}
<div class="modal fade" id="modalUploadFile" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <form action="{{ route($role . '.berkas.file.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="folder_id" value="{{ $currentFolder ? $currentFolder->id : '' }}">
                <div class="modal-header border-bottom border-light p-4">
                    <h6 class="modal-title fw-bold"><i class="bi bi-cloud-upload text-primary me-2"></i>Upload File Baru</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 bg-light">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Pilih File (Max: 10MB)</label>
                        <input type="file" name="file" class="form-control rounded-3" required>
                    </div>
                    @if($currentFolder)
                    <div class="alert alert-info py-2 px-3 small rounded-3 mb-0 border-0">
                        <i class="bi bi-info-circle-fill me-1"></i> File akan diunggah ke folder: <strong>{{ $currentFolder->name }}</strong>
                    </div>
                    @else
                    <div class="alert alert-info py-2 px-3 small rounded-3 mb-0 border-0">
                        <i class="bi bi-info-circle-fill me-1"></i> File akan diunggah ke <strong>Root</strong>
                    </div>
                    @endif
                </div>
                <div class="modal-footer border-top border-light p-3">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold">Upload File</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.folder-card:hover, .file-card:hover {
    transform: translateY(-3px);
    transition: all 0.2s ease;
    border-color: #0d6efd !important;
}
.folder-card { transition: all 0.2s ease; }
.file-card { transition: all 0.2s ease; }
</style>
@endsection
