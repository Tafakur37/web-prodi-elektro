@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid p-0">
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-primary text-white p-4">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-person-circle me-2"></i>Profil Saya</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-3 text-center mb-4">
                            <div class="bg-light rounded-circle p-4 mx-auto mb-3" style="width: 120px; height: 120px;">
                                <i class="bi bi-person-circle fs-1 text-secondary"></i>
                            </div>
                            <h6 class="fw-bold">{{ auth()->user()->name }}</h6>
                            <span class="badge bg-primary">Dosen</span>
                        </div>
                        <div class="col-md-9">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">NIP</label>
                                    <p class="h6 fw-bold">{{ auth()->user()->nim ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">Email</label>
                                    <p class="h6">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-success text-white p-3">
                    <h6 class="mb-0 fw-bold">Mata Kuliah Diampu</h6>
                </div>
                <div class="card-body">
                    @php
                    $subjects = \App\Models\Subject::whereHas('lecturers', function($q) {
                    $q->where('user_id', auth()->id());
                    })->get();
                    @endphp
                    @if($subjects->count() > 0)
                    <ul class="list-unstyled">
                        @foreach($subjects as $sub)
                        <li class="p-2 border-bottom small">
                            {{ $sub->name }} <span class="badge bg-light text-dark">{{ $sub->sks }} SKS</span>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <div class="text-center text-muted py-3">
                        <small>Belum ada</small>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection