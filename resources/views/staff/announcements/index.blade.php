@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <div class="row">
        <!-- Input Pengumuman -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-2">
                    <h5 class="fw-bold mb-0"><i class="bi bi-megaphone-fill text-warning me-2"></i> Siarkan Pengumuman</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('staff.announcements.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Judul Pengumuman</label>
                            <input type="text" name="title" class="form-control" placeholder="Contoh: Libur Semester Ganjil" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Isi Pengumuman</label>
                            <textarea name="message" class="form-control" rows="5" placeholder="Tuliskan isi pengumuman..." required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted">Target Penerima</label>
                            <div class="d-flex gap-3 mt-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="target_role" id="targetAll" value="all" checked>
                                    <label class="form-check-label" for="targetAll">Semua</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="target_role" id="targetDosen" value="dosen">
                                    <label class="form-check-label" for="targetDosen">Dosen</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="target_role" id="targetMhs" value="mahasiswa">
                                    <label class="form-check-label" for="targetMhs">Mahasiswa</label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-warning w-100 fw-bold py-2"><i class="bi bi-send-fill me-1"></i> Siarkan Sekarang</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Riwayat Pengumuman -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-2">
                    <h5 class="fw-bold mb-0"><i class="bi bi-clock-history text-primary me-2"></i> Riwayat Pengumuman</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($announcements as $ann)
                            <div class="list-group-item p-4 border-0 border-bottom">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="fw-bold text-dark mb-1">{{ $ann->title }}</h6>
                                        <div class="d-flex align-items-center small text-muted">
                                            <i class="bi bi-calendar-event me-1"></i> {{ $ann->created_at->translatedFormat('d M Y, H:i') }}
                                            <span class="mx-2">•</span>
                                            <span class="badge {{ $ann->target_role == 'all' ? 'bg-primary' : ($ann->target_role == 'dosen' ? 'bg-info text-dark' : 'bg-success') }}">
                                                Target: {{ ucfirst($ann->target_role) }}
                                            </span>
                                        </div>
                                    </div>
                                    <form action="{{ route('staff.announcements.destroy', $ann->id) }}" method="POST" onsubmit="return confirm('Hapus pengumuman ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger border-0"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                                <p class="text-secondary mb-0 text-wrap">{{ $ann->message }}</p>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-bell-slash fs-1 d-block mb-3 opacity-25"></i>
                                Belum ada pengumuman yang disiarkan.
                            </div>
                        @endforelse
                    </div>
                </div>
                @if($announcements->hasPages())
                    <div class="card-footer bg-white border-0 py-3">
                        {{ $announcements->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
