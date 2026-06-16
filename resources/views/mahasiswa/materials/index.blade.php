@extends('layouts.mahasiswa')

@section('title', 'Bahan Ajar')

@push('styles')
<style>
.mat-accordion-item {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: var(--radius-xl);
    overflow: hidden;
    margin-bottom: 12px;
}

.mat-accordion-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 20px;
    cursor: pointer;
    transition: background 0.2s;
    gap: 12px;
}

.mat-accordion-header:hover { background: rgba(255,255,255,0.04); }

.mat-accordion-header.open {
    background: rgba(0,102,255,0.08);
    border-bottom: 1px solid var(--border);
}

.mat-subj-name {
    font-family: var(--font-display);
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--text-1);
    display: flex;
    align-items: center;
    gap: 10px;
}

.mat-chevron {
    transition: transform 0.3s ease;
    color: var(--text-3);
    font-size: 0.75rem;
}

.mat-accordion-header.open .mat-chevron { transform: rotate(90deg); }

.mat-accordion-body {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.35s cubic-bezier(0.4,0,0.2,1);
}

.mat-accordion-body.open { max-height: 2000px; }
</style>
@endpush

@section('content')

<div style="margin-bottom:20px;">
    <h5 style="font-family:var(--font-display);font-weight:700;color:var(--text-1);margin:0 0 4px;">Bahan Ajar</h5>
    <p style="font-size:0.84rem;color:var(--text-2);margin:0;">Materi perkuliahan yang dibagikan oleh dosen untuk angkatan Anda.</p>
</div>

@if($materialsBySubject->isEmpty())
<div class="mhs-card">
    <div class="mhs-empty" style="padding:60px 20px;">
        <i class="bi bi-journal-x"></i>
        <p>Belum ada bahan ajar yang dibagikan untuk angkatan Anda.</p>
    </div>
</div>
@else

@foreach($materialsBySubject as $subjectName => $materials)
<div class="mat-accordion-item" id="matItem{{ $loop->index }}">
    <div class="mat-accordion-header {{ $loop->first ? 'open' : '' }}"
         onclick="toggleMat({{ $loop->index }})">
        <div class="mat-subj-name">
            <span class="mhs-card-icon" style="background:var(--primary-light);color:var(--primary);">
                <i class="bi bi-book"></i>
            </span>
            {{ $subjectName }}
        </div>
        <div style="display:flex;align-items:center;gap:10px;">
            <span class="mhs-badge primary">{{ $materials->count() }} File</span>
            <i class="bi bi-chevron-right mat-chevron"></i>
        </div>
    </div>
    <div class="mat-accordion-body {{ $loop->first ? 'open' : '' }}" id="matBody{{ $loop->index }}">
        <div style="overflow-x:auto;">
            <table class="mhs-table">
                <thead>
                    <tr>
                        <th style="padding-left:20px;">Judul Materi</th>
                        <th>Dosen</th>
                        <th>Tipe</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($materials as $material)
                    <tr>
                        <td style="padding-left:20px;">
                            <div style="font-weight:700;color:var(--text-1);margin-bottom:3px;">{{ $material->title }}</div>
                            @if($material->description)
                            <div style="font-size:0.72rem;color:var(--text-3);">{{ $material->description }}</div>
                            @endif
                            <div style="font-size:0.7rem;color:var(--text-3);margin-top:2px;"><i class="bi bi-calendar-event me-1"></i>{{ $material->created_at->format('d M Y') }}</div>
                        </td>
                        <td style="font-size:0.82rem;color:var(--text-2);">{{ $material->user->name ?? 'Tidak diketahui' }}</td>
                        <td>
                            <span class="mhs-badge muted" style="text-transform:uppercase;">{{ $material->file_type }}</span>
                        </td>
                        <td style="text-align:center;">
                            <div style="display:flex;gap:6px;justify-content:center;">
                                <a href="{{ route('mahasiswa.materials.show', $material->id) }}"
                                   class="mhs-btn mhs-btn-ghost mhs-btn-sm" title="Lihat Materi">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('mahasiswa.materials.download', $material->id) }}"
                                   class="mhs-btn mhs-btn-success mhs-btn-sm" title="Download">
                                    <i class="bi bi-download"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endforeach

@endif

@push('scripts')
<script>
function toggleMat(idx) {
    const header = document.querySelector('#matItem' + idx + ' .mat-accordion-header');
    const body   = document.getElementById('matBody' + idx);
    header.classList.toggle('open');
    body.classList.toggle('open');
}
</script>
@endpush

@endsection