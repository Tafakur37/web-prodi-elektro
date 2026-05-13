@extends('layouts.app')
@section('title', 'Berkas (Drive)')

@push('styles')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
    /* Google Drive Style File Manager */
    .drive-wrapper {
        display: flex;
        height: calc(100vh - 80px); /* Adjust based on navbar height */
        background: #f8fafc;
        margin: -1.5rem; /* Negate app.blade.php container padding to go full width */
        font-family: 'Inter', sans-serif;
    }

    /* ── Drive Sidebar ───────────────────── */
    .drive-sidebar {
        width: 260px;
        background: #f8fafc;
        padding: 20px 16px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .drive-btn-new {
        background: #fff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0,0,0,.05);
        border-radius: 16px;
        padding: 12px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 600;
        color: #1e293b;
        cursor: pointer;
        transition: .2s;
        margin-bottom: 12px;
    }
    .drive-btn-new:hover {
        background: #f1f5f9;
        box-shadow: 0 4px 6px rgba(0,0,0,.05);
    }
    .drive-btn-new i {
        font-size: 1.5rem;
        color: #ef4444; /* Google Drive signature plus color */
    }

    .drive-nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 16px;
        border-radius: 24px;
        color: #475569;
        font-weight: 500;
        font-size: .875rem;
        cursor: pointer;
        transition: .2s;
        text-decoration: none;
    }
    .drive-nav-item:hover {
        background: #f1f5f9;
        color: #1e293b;
    }
    .drive-nav-item.active {
        background: #dbeafe;
        color: #1d4ed8;
    }
    .drive-nav-item i { font-size: 1.1rem; }

    /* ── Drive Main Content ──────────────── */
    .drive-main {
        flex: 1;
        background: #fff;
        border-radius: 24px 24px 0 0;
        margin-top: 10px;
        box-shadow: -4px 0 12px rgba(0,0,0,.02);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .drive-toolbar {
        padding: 16px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .breadcrumb-drive {
        font-size: 1.2rem;
        font-weight: 500;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .breadcrumb-drive a { color: #64748b; text-decoration: none; transition: .2s; }
    .breadcrumb-drive a:hover { color: #1e293b; }
    
    /* ── File Grid & List ────────────────── */
    .drive-content-scroll {
        padding: 24px;
        overflow-y: auto;
        flex: 1;
    }
    .section-title {
        font-size: .875rem;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 16px;
    }

    .drive-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 32px;
    }

    /* Card Item */
    .drive-item {
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        transition: .2s;
        position: relative;
    }
    .drive-item:hover {
        background: #f1f5f9;
        border-color: #e2e8f0;
    }
    .drive-item.selected {
        background: #eff6ff;
        border-color: #bfdbfe;
    }

    .drive-item-icon {
        font-size: 1.5rem;
        color: #94a3b8;
    }
    .icon-folder { color: #6366f1 !important; }
    .icon-pdf { color: #ef4444 !important; }
    .icon-image { color: #10b981 !important; }
    .icon-word { color: #2563eb !important; }

    .drive-item-info {
        flex: 1;
        overflow: hidden;
    }
    .drive-item-name {
        font-size: .875rem;
        font-weight: 600;
        color: #1e293b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .drive-item-meta {
        font-size: .75rem;
        color: #94a3b8;
        margin-top: 2px;
    }

    .drive-item-more {
        opacity: 0;
        transition: .2s;
        padding: 4px;
        border-radius: 50%;
        color: #64748b;
    }
    .drive-item:hover .drive-item-more { opacity: 1; }
    .drive-item-more:hover { background: #e2e8f0; color: #1e293b; }

    /* Dropzone area */
    .dropzone-overlay {
        position: absolute;
        inset: 0;
        background: rgba(239, 246, 255, 0.9);
        border: 2px dashed #3b82f6;
        border-radius: 24px 24px 0 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 50;
        color: #1d4ed8;
    }
    
    .context-menu {
        position: fixed;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        border: 1px solid #e2e8f0;
        padding: 8px 0;
        min-width: 200px;
        z-index: 1050;
    }
    .context-menu-item {
        padding: 8px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 0.875rem;
        color: #334155;
        cursor: pointer;
        transition: .15s;
    }
    .context-menu-item:hover {
        background: #f1f5f9;
        color: #0f172a;
    }
</style>
@endpush

@section('content')
@php
    $role = auth()->user()?->role ?? 'mahasiswa';
    $routePrefix = match($role) {
        'admin' => 'admin.',
        'staff' => 'staff.',
        'dosen' => 'dosen.',
        'sesprodi' => 'sesprodi.',
        'kaprodi' => 'kaprodi.',
        default => 'mahasiswa.',
    };
    $urlPrefix = '/' . match($role) {
        'admin' => 'admin',
        'staff' => 'staff',
        'dosen' => 'dosen',
        'sesprodi' => 'sesprodi',
        'kaprodi' => 'kaprodi',
        default => 'mahasiswa',
    };
@endphp
<div class="drive-wrapper" x-data="driveManager()">
    
    {{-- ── Sidebar ── --}}
    <div class="drive-sidebar">
        <div class="dropdown">
            <button class="drive-btn-new w-100" data-bs-toggle="dropdown">
                <i class="bi bi-plus-lg"></i> Baru
            </button>
            <ul class="dropdown-menu shadow-sm border-0" style="border-radius: 12px;">
                <li>
                    <a class="dropdown-item py-2" href="#" data-bs-toggle="modal" data-bs-target="#newFolderModal">
                        <i class="bi bi-folder-plus me-2 text-primary"></i> Folder Baru
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item py-2" href="#" @click="$refs.fileInput.click()">
                        <i class="bi bi-file-earmark-arrow-up me-2 text-success"></i> Upload File
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="d-none">
            <input type="file" x-ref="fileInput" multiple @change="handleFileInput($event)">
        </div>

        <a href="{{ route($routePrefix . 'berkas.index') }}" class="drive-nav-item {{ request()->routeIs('*.berkas.index') ? 'active' : '' }}">
            <i class="bi bi-hdd-fill"></i> Drive Saya
        </a>
        <a href="{{ route($routePrefix . 'berkas.shared') }}" class="drive-nav-item {{ request()->routeIs('*.berkas.shared') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> Dibagikan
        </a>
        <a href="{{ route($routePrefix . 'berkas.recent') }}" class="drive-nav-item {{ request()->routeIs('*.berkas.recent') ? 'active' : '' }}">
            <i class="bi bi-clock-fill"></i> Terbaru
        </a>
        <a href="{{ route($routePrefix . 'berkas.starred') }}" class="drive-nav-item {{ request()->routeIs('*.berkas.starred') ? 'active' : '' }}">
            <i class="bi bi-star-fill"></i> Berbintang
        </a>
        <a href="{{ route($routePrefix . 'berkas.trash') }}" class="drive-nav-item {{ request()->routeIs('*.berkas.trash') ? 'active' : '' }}">
            <i class="bi bi-trash-fill"></i> Sampah
        </a>
    </div>

    {{-- ── Main ── --}}
    <div class="drive-main position-relative" 
         @dragover.prevent="dragOver = true" 
         @dragleave.prevent="dragOver = false" 
         @drop.prevent="handleDrop($event)">
        
        <!-- Drag & Drop Overlay -->
        <div class="dropzone-overlay" x-show="dragOver" style="display: none;">
            <i class="bi bi-cloud-arrow-up-fill" style="font-size: 4rem;"></i>
            <h3 class="mt-3 fw-bold">Lepaskan file untuk mengunggah ke folder ini</h3>
        </div>

        <div class="drive-toolbar">
            <div class="breadcrumb-drive">
                @if($viewType == 'drive')
                    <a href="{{ route($routePrefix . 'berkas.index') }}">Drive Saya</a>
                    @if(isset($breadcrumbs) && count($breadcrumbs) > 0)
                        @foreach($breadcrumbs as $bc)
                            <i class="bi bi-chevron-right mx-1" style="font-size: .8rem; color: #94a3b8;"></i>
                            <a href="{{ route($routePrefix . 'berkas.index', $bc->id) }}" class="{{ $loop->last ? 'text-dark fw-bold' : '' }}">
                                {{ $bc->name }}
                            </a>
                        @endforeach
                    @endif
                @elseif($viewType == 'shared')
                    <span class="text-dark fw-bold"><i class="bi bi-people-fill me-2"></i>Dibagikan dengan saya</span>
                @elseif($viewType == 'recent')
                    <span class="text-dark fw-bold"><i class="bi bi-clock-fill me-2"></i>Terbaru</span>
                @elseif($viewType == 'starred')
                    <span class="text-dark fw-bold"><i class="bi bi-star-fill me-2"></i>Berbintang</span>
                @elseif($viewType == 'trash')
                    <span class="text-dark fw-bold"><i class="bi bi-trash-fill me-2"></i>Sampah</span>
                @endif
            </div>
            <div>
                <!-- Tools (View Toggle, etc) -->
                <button class="btn btn-sm btn-light border" style="border-radius: 8px;">
                    <i class="bi bi-info-circle"></i>
                </button>
            </div>
        </div>

        <div class="drive-content-scroll" @contextmenu.prevent="openContextMenu($event, 'bg', null)">
            
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 mb-4" style="background:#f0fdf4;color:#15803d;border-radius:12px;">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @if($errors->any())
            <div class="alert alert-danger border-0" style="border-radius:12px;">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
            @endif

            @if(isset($folders) && $folders->count() > 0)
                <div class="section-title">Folder</div>
                <div class="drive-grid">
                    @foreach($folders as $folder)
                    <div class="drive-item" 
                         @click="window.location.href='{{ route($routePrefix . 'berkas.index', $folder->id) }}'"
                         @contextmenu.prevent.stop="openContextMenu($event, 'folder', {{ $folder->id }}, '{{ $folder->name }}')">
                        <i class="bi bi-folder-fill drive-item-icon icon-folder"></i>
                        <div class="drive-item-info">
                            <div class="drive-item-name">{{ $folder->name }}</div>
                        </div>
                        <i class="bi bi-three-dots-vertical drive-item-more" @click.stop.prevent="openContextMenu($event, 'folder', {{ $folder->id }}, '{{ $folder->name }}')"></i>
                    </div>
                    @endforeach
                </div>
            @endif

            @if(isset($files) && $files->count() > 0)
                <div class="section-title">File</div>
                <div class="drive-grid">
                    @foreach($files as $file)
                    <div class="drive-item" 
                         @dblclick="openPreview({{ $file->id }}, {{ json_encode($file->name) }}, '{{ strtolower($file->extension) }}')"
                         @contextmenu.prevent.stop="openContextMenu($event, 'file', {{ $file->id }}, {{ json_encode($file->name) }}, '{{ strtolower($file->extension) }}')">
                        
                        @php
                            $ext = strtolower($file->extension);
                            $icon = 'bi-file-earmark';
                            $iconClass = '';
                            if(in_array($ext, ['pdf'])) { $icon = 'bi-file-earmark-pdf-fill'; $iconClass = 'icon-pdf'; }
                            elseif(in_array($ext, ['jpg','jpeg','png','gif','webp'])) { $icon = 'bi-file-earmark-image-fill'; $iconClass = 'icon-image'; }
                            elseif(in_array($ext, ['doc','docx'])) { $icon = 'bi-file-earmark-word-fill'; $iconClass = 'icon-word'; }
                        @endphp
                        
                        <i class="bi {{ $icon }} drive-item-icon {{ $iconClass }}"></i>
                        <div class="drive-item-info">
                            <div class="drive-item-name" title="{{ $file->name }}">{{ $file->name }}</div>
                            <div class="drive-item-meta">{{ round($file->size / 1024, 1) }} KB</div>
                        </div>
                        <i class="bi bi-three-dots-vertical drive-item-more" @click.stop.prevent="openContextMenu($event, 'file', {{ $file->id }}, {{ json_encode($file->name) }}, '{{ strtolower($file->extension) }}')"></i>
                    </div>
                    @endforeach
                </div>
            @endif

            @if(isset($folders) && $folders->count() == 0 && isset($files) && $files->count() == 0)
                <div class="text-center py-5" style="color: #94a3b8;">
                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486747.png" width="120" style="opacity: 0.3; margin-bottom: 16px;">
                    <h4>Folder ini kosong</h4>
                    <p>Seret file ke sini atau gunakan tombol "Baru".</p>
                </div>
            @endif

        </div>
    </div>

    <!-- Context Menu -->
    <div x-show="menuOpen" class="context-menu" :style="'left:' + menuX + 'px; top:' + menuY + 'px;'" @click.outside="menuOpen = false" style="display:none;">
        
        <template x-if="menuType === 'file'">
            <div>
                @if($viewType !== 'trash')
                <div class="context-menu-item" @click="openPreview(activeId, activeName, activeExt)">
                    <i class="bi bi-eye text-primary"></i> Pratinjau
                </div>
                <a :href="'{{ $urlPrefix }}/berkas/file/' + activeId + '/download'" class="context-menu-item text-decoration-none">
                    <i class="bi bi-download text-success"></i> Download
                </a>
                <form :action="'{{ $urlPrefix }}/berkas/star/toggle'" method="POST" class="m-0" id="starFileForm">
                    @csrf
                    <input type="hidden" name="id" :value="activeId">
                    <input type="hidden" name="type" value="file">
                    <div class="context-menu-item" @click="document.getElementById('starFileForm').submit()">
                        <i class="bi bi-star"></i> Bintang
                    </div>
                </form>
                <div class="context-menu-item" @click="renameItem()">
                    <i class="bi bi-pencil"></i> Ganti Nama
                </div>
                <hr class="my-1">
                <form :action="'{{ $urlPrefix }}/berkas/file/' + activeId" method="POST" class="m-0" id="deleteFileForm">
                    @csrf @method('DELETE')
                    <div class="context-menu-item text-danger" @click="document.getElementById('deleteFileForm').submit()">
                        <i class="bi bi-trash"></i> Hapus
                    </div>
                </form>
                @else
                <form :action="'{{ $urlPrefix }}/berkas/file/' + activeId + '/restore'" method="POST" class="m-0" id="restoreFileForm">
                    @csrf
                    <div class="context-menu-item text-success" @click="document.getElementById('restoreFileForm').submit()">
                        <i class="bi bi-arrow-counterclockwise"></i> Pulihkan
                    </div>
                </form>
                <hr class="my-1">
                <form :action="'{{ $urlPrefix }}/berkas/file/' + activeId + '/force'" method="POST" class="m-0" id="forceDeleteFileForm">
                    @csrf @method('DELETE')
                    <div class="context-menu-item text-danger" @click="if(confirm('Hapus permanen file ini?')) document.getElementById('forceDeleteFileForm').submit()">
                        <i class="bi bi-trash-fill"></i> Hapus Permanen
                    </div>
                </form>
                @endif
            </div>
        </template>

        <template x-if="menuType === 'folder'">
            <div>
                @if($viewType !== 'trash')
                <div class="context-menu-item" @click="window.location.href='{{ $urlPrefix }}/berkas/' + activeId">
                    <i class="bi bi-folder-symlink text-primary"></i> Buka Folder
                </div>
                <form :action="'{{ $urlPrefix }}/berkas/star/toggle'" method="POST" class="m-0" id="starFolderForm">
                    @csrf
                    <input type="hidden" name="id" :value="activeId">
                    <input type="hidden" name="type" value="folder">
                    <div class="context-menu-item" @click="document.getElementById('starFolderForm').submit()">
                        <i class="bi bi-star"></i> Bintang
                    </div>
                </form>
                <div class="context-menu-item" @click="renameItem()">
                    <i class="bi bi-pencil"></i> Ganti Nama
                </div>
                <hr class="my-1">
                <form :action="'{{ $urlPrefix }}/berkas/folder/' + activeId" method="POST" class="m-0" id="deleteFolderForm">
                    @csrf @method('DELETE')
                    <div class="context-menu-item text-danger" @click="if(confirm('Hapus folder ini?')) document.getElementById('deleteFolderForm').submit()">
                        <i class="bi bi-trash"></i> Hapus
                    </div>
                </form>
                @else
                <form :action="'{{ $urlPrefix }}/berkas/folder/' + activeId + '/restore'" method="POST" class="m-0" id="restoreFolderForm">
                    @csrf
                    <div class="context-menu-item text-success" @click="document.getElementById('restoreFolderForm').submit()">
                        <i class="bi bi-arrow-counterclockwise"></i> Pulihkan
                    </div>
                </form>
                <hr class="my-1">
                <form :action="'{{ $urlPrefix }}/berkas/folder/' + activeId + '/force'" method="POST" class="m-0" id="forceDeleteFolderForm">
                    @csrf @method('DELETE')
                    <div class="context-menu-item text-danger" @click="if(confirm('Hapus permanen folder ini?')) document.getElementById('forceDeleteFolderForm').submit()">
                        <i class="bi bi-trash-fill"></i> Hapus Permanen
                    </div>
                </form>
                @endif
            </div>
        </template>
        
        <template x-if="menuType === 'bg' && '{{ $viewType }}' === 'drive'">
            <div>
                <div class="context-menu-item" data-bs-toggle="modal" data-bs-target="#newFolderModal" @click="menuOpen = false">
                    <i class="bi bi-folder-plus text-primary"></i> Folder Baru
                </div>
                <div class="context-menu-item" @click="$refs.fileInput.click(); menuOpen = false">
                    <i class="bi bi-file-earmark-arrow-up text-success"></i> Upload File
                </div>
            </div>
        </template>
    </div>

    <!-- Rename Modal -->
    <div class="modal fade" id="renameModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:16px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Ganti Nama</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form :action="renameUrl" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-body">
                        <input type="text" name="name" class="form-control" x-model="renameValue" required style="border-radius:10px; background:#f8fafc;">
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius:10px;">Batal</button>
                        <button type="submit" class="btn btn-primary" style="border-radius:10px;">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- New Folder Modal -->
<div class="modal fade" id="newFolderModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Folder Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route($routePrefix . 'berkas.folder.store') }}" method="POST">
                @csrf
                <input type="hidden" name="parent_id" value="{{ $currentFolder->id ?? '' }}">
                <div class="modal-body">
                    <input type="text" name="name" class="form-control" placeholder="Folder tanpa nama" required style="border-radius:10px; background:#f8fafc;">
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius:10px;">Batal</button>
                    <button type="submit" class="btn btn-primary" style="border-radius:10px;">Buat</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-fullscreen m-0">
        <div class="modal-content border-0" style="background-color: #0f172a; border-radius: 0;">
            <!-- Header (Fixed Top) -->
            <div class="d-flex justify-content-between align-items-center p-3" style="background-color: rgba(15, 23, 42, 0.95); border-bottom: 1px solid #1e293b; position: absolute; top: 0; left: 0; right: 0; z-index: 1060;">
                <div class="d-flex align-items-center gap-3">
                    <!-- Tombol Kembali -->
                    <button type="button" class="btn btn-outline-light border-0" data-bs-dismiss="modal" @click="closePreview()" style="border-radius: 50%; width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.1);">
                        <i class="bi bi-arrow-left" style="font-size: 1.2rem;"></i>
                    </button>
                    <h5 class="mb-0 fw-bold text-white text-truncate" style="max-width: 300px;" x-text="previewName"></h5>
                </div>
                <div>
                    <a :href="'{{ $urlPrefix }}/berkas/file/' + previewId + '/download'" class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="bi bi-download me-2"></i> Download
                    </a>
                </div>
            </div>
            
            <!-- Body -->
            <div class="modal-body p-0 d-flex justify-content-center align-items-center position-relative" style="height: 100vh; overflow: hidden; padding-top: 70px !important;">
                
                <template x-if="isPreviewLoading && canPreview">
                    <div class="position-absolute w-100 h-100 d-flex flex-column justify-content-center align-items-center" style="z-index: 10;">
                        <div class="spinner-border text-light mb-3" role="status" style="width: 3rem; height: 3rem;"></div>
                        <p class="fs-5 text-white">Memuat Pratinjau...</p>
                    </div>
                </template>
                
                <template x-if="canPreview && previewTypeClass === 'image'">
                    <img :src="previewUrl" class="img-fluid shadow-lg" style="max-height: 85vh; max-width: 90vw; object-fit: contain; z-index: 5;" x-on:load="isPreviewLoading = false" x-on:error="isPreviewLoading = false; canPreview = false">
                </template>
                
                <template x-if="canPreview && previewTypeClass === 'video'">
                    <video :src="previewUrl" controls class="shadow-lg" style="max-height: 85vh; max-width: 90vw; background: #000; z-index: 5;" x-on:loadeddata="isPreviewLoading = false"></video>
                </template>
                
                <template x-if="canPreview && previewTypeClass === 'pdf'">
                    <iframe :src="previewUrl" class="w-100 h-100 border-0" x-on:load="isPreviewLoading = false" style="background: white; z-index: 5;"></iframe>
                </template>
                
                <template x-if="!canPreview">
                    <div class="text-center text-muted d-flex flex-column justify-content-center align-items-center h-100 w-100" style="z-index: 5;">
                        <i class="bi bi-file-earmark-x" style="font-size: 6rem; color: #475569;"></i>
                        <h4 class="mt-4 fw-bold text-white">Pratinjau Tidak Tersedia</h4>
                        <p style="color: #94a3b8; max-width: 400px; margin: 0 auto;">File dengan ekstensi <strong x-text="'.' + previewExt" class="text-white"></strong> tidak dapat dipratinjau secara langsung. Silakan download untuk melihat isinya.</p>
                    </div>
                </template>
                
            </div>
        </div>
    </div>
</div>

<!-- Upload Progress Toast -->
<div x-show="isUploading" class="position-fixed bottom-0 end-0 p-4" style="z-index: 1060; width: 400px; display: none;" x-transition>
    <div class="bg-white border rounded-4 shadow-lg p-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="fw-bold mb-0 text-dark">Mengupload File...</h6>
            <span class="badge bg-primary rounded-pill" x-text="uploadProgress + '%'"></span>
        </div>
        <div class="progress" style="height: 8px; border-radius: 4px;">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" :style="'width: ' + uploadProgress + '%'"></div>
        </div>
        <div class="mt-2 text-muted" style="font-size: 12px;">Mohon jangan tutup halaman ini.</div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('driveManager', () => ({
            dragOver: false,
            menuOpen: false,
            menuX: 0,
            menuY: 0,
            menuType: '', // 'file', 'folder', 'bg'
            activeId: null,
            activeName: '',
            activeExt: '',
            renameValue: '',
            
            previewId: null,
            previewName: '',
            previewExt: '',
            previewUrl: '',
            previewTypeClass: '',
            isPreviewLoading: false,
            canPreview: false,
            
            uploadProgress: 0,
            isUploading: false,
            
            handleDrop(e) {
                this.dragOver = false;
                this.uploadFiles(e.dataTransfer.files);
            },
            handleFileInput(e) {
                this.uploadFiles(e.target.files);
            },
            
            async uploadFiles(files) {
                if(files.length === 0) return;
                
                // Validate 10MB limit
                const maxSize = 10 * 1024 * 1024; // 10 MB
                for(let i=0; i<files.length; i++) {
                    if(files[i].size > maxSize) {
                        alert('File "' + files[i].name + '" melebihi batas maksimal 10 MB!');
                        return;
                    }
                }
                
                this.isUploading = true;
                this.uploadProgress = 0;
                
                let formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('folder_id', '{{ $currentFolder->id ?? "" }}');
                
                for(let i=0; i<files.length; i++) {
                    formData.append('files[]', files[i]);
                }
                
                try {
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', '{{ route($routePrefix . "berkas.file.upload") }}', true);
                    
                    xhr.upload.onprogress = (e) => {
                        if (e.lengthComputable) {
                            this.uploadProgress = Math.round((e.loaded / e.total) * 100);
                        }
                    };
                    
                    xhr.onload = () => {
                        if (xhr.status >= 200 && xhr.status < 300) {
                            this.uploadProgress = 100;
                            setTimeout(() => window.location.reload(), 500);
                        } else {
                            this.isUploading = false;
                            alert('Gagal mengupload file.');
                        }
                    };
                    
                    xhr.onerror = () => {
                        this.isUploading = false;
                        alert('Terjadi kesalahan jaringan saat upload.');
                    };
                    
                    xhr.send(formData);
                } catch(err) {
                    this.isUploading = false;
                    alert('Error: ' + err.message);
                }
            },
            
            openContextMenu(e, type, id = null, name = '', ext = '') {
                this.menuType = type;
                this.activeId = id;
                this.activeName = name;
                this.activeExt = ext;
                
                // Keep menu within viewport bounds
                let x = e.clientX;
                let y = e.clientY;
                if (x + 200 > window.innerWidth) x -= 200;
                if (y + 150 > window.innerHeight) y -= 150;
                
                this.menuX = x;
                this.menuY = y;
                this.menuOpen = true;
            },
            
            renameItem() {
                this.menuOpen = false;
                this.renameValue = this.activeName;
                const modal = new bootstrap.Modal(document.getElementById('renameModal'));
                modal.show();
            },
            
            get renameUrl() {
                if (this.menuType === 'folder') return '{{ $urlPrefix }}/berkas/folder/' + this.activeId;
                if (this.menuType === 'file') return '{{ $urlPrefix }}/berkas/file/' + this.activeId;
                return '#';
            },
            
            openPreview(id, name, ext) {
                this.menuOpen = false;
                this.previewId = id;
                this.previewName = name;
                this.previewExt = ext;
                
                const imageExts = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
                const videoExts = ['mp4', 'webm', 'ogg'];
                const pdfExts = ['pdf', 'txt'];
                
                this.isPreviewLoading = true;
                this.previewUrl = '{{ $urlPrefix }}/berkas/file/' + id + '/preview';

                if (imageExts.includes(ext)) {
                    this.previewTypeClass = 'image';
                    this.canPreview = true;
                } else if (videoExts.includes(ext)) {
                    this.previewTypeClass = 'video';
                    this.canPreview = true;
                } else if (pdfExts.includes(ext)) {
                    this.previewTypeClass = 'pdf';
                    this.canPreview = true;
                } else {
                    this.previewUrl = '';
                    this.canPreview = false;
                    this.isPreviewLoading = false;
                }
                
                const modal = new bootstrap.Modal(document.getElementById('previewModal'));
                modal.show();
            },
            
            closePreview() {
                this.previewUrl = '';
                this.canPreview = false;
                this.isPreviewLoading = false;
                // Force iframe unload
                const iframe = document.querySelector('#previewModal iframe');
                if (iframe) iframe.src = 'about:blank';
            }
        }));
    });
</script>
@endpush
@endsection
