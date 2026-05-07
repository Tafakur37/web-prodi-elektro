<!-- KOTAK SARAN MAHASISWA -->
<div class="card border-0 shadow-sm rounded-4 mt-4">
    <div class="card-header bg-white border-0 p-4 pb-2 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-bold mb-1 text-dark"><i class="bi bi-envelope-paper text-primary me-2"></i>Kotak Saran Mahasiswa</h5>
            <p class="text-muted mb-0 small">Saran dan masukan dari mahasiswa <span class="text-secondary">(otomatis hilang setelah 30 hari)</span></p>
        </div>
        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">{{ $suggestions->count() }} Saran</span>
    </div>
    <div class="card-body p-4 pt-2">
        @forelse($suggestions as $saran)
            <div class="border rounded-3 p-3 mb-3 bg-light">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-3 fw-bold" style="width: 40px; height: 40px; min-width: 40px;">
                            {{ substr($saran->user->name ?? '?', 0, 1) }}
                        </div>
                        <div>
                            <div class="fw-bold text-dark">{{ $saran->user->name ?? 'Anonim' }}</div>
                            <div class="small text-muted">{{ $saran->user->nim ?? '' }} &bull; Cohort {{ $saran->user->cohort ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-2">
                        <div class="text-end">
                            @php
                                $catBadge = match($saran->category) {
                                    'fasilitas' => 'bg-info text-dark',
                                    'akademik' => 'bg-primary',
                                    'dosen' => 'bg-warning text-dark',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $catBadge }} rounded-pill mb-1">{{ ucfirst($saran->category) }}</span>
                            <div class="small text-muted" style="font-size: 0.7rem;">{{ $saran->created_at->diffForHumans() }}</div>
                        </div>
                        <form action="{{ route('suggestions.dismiss', $saran->id) }}" method="POST" onsubmit="return confirm('Hapus saran ini dari daftar Anda? (Akun lain tetap bisa melihatnya)')">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger border-0" title="Hapus dari daftar saya">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <p class="mb-0 text-dark" style="white-space: pre-wrap;">{{ $saran->content }}</p>
            </div>
        @empty
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                Belum ada saran dari mahasiswa.
            </div>
        @endforelse
    </div>
</div>
