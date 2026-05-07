@extends('dashboard.base')

@section('title', 'Dashboard Kaprodi')

@section('dashboard-content')
    <div class="alert alert-danger border-0 rounded-3">
        <i class="bi bi-award-fill me-2"></i> Selamat datang, Kepala Program Studi!
    </div>

    @include('components.suggestion-card')
@endsection
