@extends('layouts.app')

@section('title', 'Manajemen Pelanggaran Mahasiswa')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">
        <i class="bi bi-exclamation-octagon text-danger me-2"></i>
        Pelanggaran Mahasiswa
    </h1>
    <a href="{{ route('staff.violations.create') }}" class="btn btn-primary btn-lg">
        <i class="bi bi-plus-circle me-2"></i>Tambah Pelanggaran
    </a>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-start border-danger border-4 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="bg-danger bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="bi bi-exclamation-octagon-fill text-danger fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">{{ $violations->total() }}</h5>
                        <small class="text-muted">Total Pelanggaran</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-start border-warning border-4 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="bi bi-clock-history text-warning fs-2"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">{{ $violations->where('status', 'aktif')->count() }}</h5>
                        <small class="text-muted">Aktif</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Violations Table -->
<div class="card shadow-sm">
    <div class="card-header bg-white border-0 pb-0">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-md-3">
                <select name="cohort" class="form-select">
                    <option value="">Semua Cohort</option>
                    @foreach($cohorts as $cohort)
                    <option value="{{ $cohort }}"
                        {{ (string) request('cohort') === (string) $cohort ? 'selected' : '' }}>
                        Cohort {{ $cohort }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md">
                <input type="text" name="search" class="form-control me-2"
                    placeholder="Cari nama mahasiswa atau pelanggaran..." value="{{ request('search') }}">
            </div>
            <div class="col-md-auto d-flex gap-2">
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
                @if(request('search') || request('cohort'))
                <a href="{{ route('staff.violations.index') }}" class="btn btn-outline-dark">Reset</a>
                @endif
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light sticky-top">
                    <tr>
                        <th>#</th>
                        <th>Mahasiswa</th>
                        <th>Pelanggaran</th>
                        <th>Poin</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Dilapor</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($violations as $violation)
                    <tr>
                        <td>{{ $loop->iteration + ($violations->currentPage()-1) * $violations->perPage() }}</td>
                        <td>
                            <div>
                                <strong>{{ $violation->student->name ?? '-' }}</strong>
                                <br><small class="text-muted">{{ $violation->student->nim ?? '-' }} |
                                    {{ $violation->student->cohort ?? '-' }}</small>
                            </div>
                        </td>
                        <td>
                            <strong class="text-danger">{{ $violation->title }}</strong>
                            @if($violation->description)
                            <br><small>{{ Str::limit($violation->description, 80) }}</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-danger fs-6">{{ $violation->point }} poin</span>
                        </td>
                        <td>{{ $violation->date->format('d/m/Y') }}</td>
                        <td>
                            @if($violation->status === 'aktif')
                            <span class="badge bg-warning text-dark">Aktif</span>
                            @else
                            <span class="badge bg-success">Selesai</span>
                            @endif
                        </td>
                        <td>
                            {{ $violation->reporter->name ?? '-' }}
                            <br><small class="text-muted">{{ $violation->created_at->diffForHumans() }}</small>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('staff.violations.edit', $violation) }}"
                                    class="btn btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('staff.violations.destroy', $violation) }}"
                                    class="d-inline" onsubmit="return confirm('Hapus pelanggaran ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger" type="submit">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="bi bi-exclamation-octagon display-4 text-muted mb-3 d-block"></i>
                            <h5 class="text-muted">Belum ada data pelanggaran</h5>
                            <a href="{{ route('staff.violations.create') }}" class="btn btn-primary">Tambah Pertama</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">
        {{ $violations->appends(request()->query())->links() }}
    </div>
</div>
@endsection