@extends('layouts.app')

@section('title', 'Manajemen Bahan Ajar')

@section('content')
<div class="container-fluid text-white">
    <div class="mb-4">
        <h3 class="fw-bold text-primary mb-1">Manajemen Bahan Ajar</h3>
        <p class="text-secondary small">Pilih angkatan untuk mengelola materi kuliah.</p>
    </div>

    <div class="row">
        @forelse($availableCohorts as $cohort)
            <div class="col-md-3 mb-4">
                <a href="{{ route('admin.materials.index', ['cohort' => $cohort]) }}" class="text-decoration-none">
                    <div class="card stat-card p-4 text-center h-100 transition-hover border-secondary">
                        <div class="display-5 fw-bold text-primary mb-2">{{ $cohort }}</div>
                        <h6 class="text-white fw-bold">Cohort {{ $cohort }}</h6>
                        <div class="mt-2 py-1 px-3 bg-dark rounded-pill d-inline-block border border-secondary">
                            <small class="text-secondary">
                                <i class="bi bi-people me-1"></i> 
                                {{ \App\Models\User::where('role', 'mahasiswa')->where('cohort', $cohort)->count() }} Mahasiswa
                            </small>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            {{-- Tampilan jika kosong --}}
        @endforelse
    </div>
</div>
@endsection
