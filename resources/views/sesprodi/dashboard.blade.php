@extends('layouts.app')

@section('title', 'Dashboard Sesprodi')

@section('content')
    <div class="alert alert-warning border-0 rounded-3">
        <i class="bi bi-briefcase-fill me-2"></i> Selamat datang, Sekretaris Program Studi!
    </div>

    @include('components.suggestion-card')
@endsection
