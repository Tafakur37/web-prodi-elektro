@extends('layouts.app')

@section('content')
    <div class="container-fluid p-0">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold text-dark mb-1">@yield('title')</h2>
                <p class="text-secondary mb-0">Selamat datang kembali di panel {{ auth()->user()->role }} SIMelek.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-custom p-4 bg-white">
                    @yield('dashboard-content')
                </div>
            </div>
        </div>
    </div>
@endsection
