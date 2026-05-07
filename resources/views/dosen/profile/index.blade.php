@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid p-0">
    <h3 class="fw-bold mb-4 text-dark border-start border-4 border-primary ps-3">Profil Saya</h3>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4 p-md-5">
            <div class="d-flex align-items-center gap-4">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 96px; height: 96px; flex-shrink: 0;">
                    <i class="bi bi-person-fill fs-1"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-dark mb-1">{{ $dosen->name }}</h4>
                    <p class="text-muted mb-1"><i class="bi bi-credit-card me-2"></i>NIP: {{ $dosen->nip ?? '-' }}</p>
                    <p class="text-muted mb-0"><i class="bi bi-envelope me-2"></i>{{ $dosen->email }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
