@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0 text-dark border-start border-4 border-primary ps-3">Materi Perkuliahan</h3>
    </div>

    @if($materialsBySubject->isEmpty())
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-5 text-center text-muted">
                <i class="bi bi-journal-x fs-1 d-block mb-3 opacity-25"></i>
                <h5>Belum Ada Materi</h5>
                <p>Belum ada bahan ajar yang dibagikan untuk angkatan Anda.</p>
            </div>
        </div>
    @else
        <div class="accordion shadow-sm rounded-4" id="materialsAccordion">
            @foreach($materialsBySubject as $subjectName => $materials)
                <div class="accordion-item border-0 mb-3 rounded-4 overflow-hidden">
                    <h2 class="accordion-header" id="heading-{{ Str::slug($subjectName) }}">
                        <button class="accordion-button fw-bold {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ Str::slug($subjectName) }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="collapse-{{ Str::slug($subjectName) }}">
                            <i class="bi bi-book me-2 text-primary"></i> {{ $subjectName }}
                            <span class="badge bg-primary rounded-pill ms-auto">{{ $materials->count() }} File</span>
                        </button>
                    </h2>
                    <div id="collapse-{{ Str::slug($subjectName) }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading-{{ Str::slug($subjectName) }}" data-bs-parent="#materialsAccordion">
                        <div class="accordion-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light text-uppercase small text-muted">
                                        <tr>
                                            <th class="py-3 px-4">Judul Materi</th>
                                            <th class="py-3">Dosen</th>
                                            <th class="py-3">Tipe</th>
                                            <th class="py-3 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($materials as $material)
                                        <tr>
                                            <td class="px-4 py-3">
                                                <div class="fw-bold text-dark mb-1">{{ $material->title }}</div>
                                                <div class="text-muted small">{{ $material->description }}</div>
                                                <div class="text-secondary small mt-1"><i class="bi bi-calendar-event me-1"></i> {{ $material->created_at->format('d M Y') }}</div>
                                            </td>
                                            <td>{{ $material->user->name ?? 'Tidak diketahui' }}</td>
                                            <td>
                                                <span class="badge bg-secondary px-3 py-2 rounded-pill text-uppercase">{{ $material->file_type }}</span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('mahasiswa.materials.show', $material->id) }}" class="btn btn-sm btn-outline-primary rounded-circle me-1" data-bs-toggle="tooltip" title="Lihat Materi">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('mahasiswa.materials.download', $material->id) }}" class="btn btn-sm btn-outline-secondary rounded-circle" data-bs-toggle="tooltip" title="Download File">
                                                    <i class="bi bi-download"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@push('scripts')
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
@endsection