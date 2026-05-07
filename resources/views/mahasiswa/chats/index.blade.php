@extends('layouts.app')

@section('title', 'Chat Dosen')

@section('content')
<div class="container-fluid px-0">
    <div class="row g-4">
        <!-- Kolom Kiri: Daftar Dosen -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom border-light pt-4 pb-3 px-4">
                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-chat-dots text-primary me-2"></i> Daftar Dosen</h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush border-0">
                        @foreach($dosens as $d)
                        <a href="{{ route('mahasiswa.chats.show', $d->id) }}" class="list-group-item list-group-item-action px-4 py-3 border-light d-flex align-items-center">
                            @if($d->profile_photo)
                                <img src="{{ asset('storage/profiles/' . $d->profile_photo) }}" class="rounded-circle me-3 border" width="45" height="45" style="object-fit: cover;">
                            @else
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                    <i class="bi bi-person-fill fs-5"></i>
                                </div>
                            @endif
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $d->name }}</h6>
                                <small class="text-secondary">Dosen Pengampu</small>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Kolom Kanan: Chat Kosong -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100 d-flex align-items-center justify-content-center bg-light">
                <div class="text-center py-5">
                    <i class="bi bi-chat-square-text text-muted" style="font-size: 4rem;"></i>
                    <h5 class="mt-3 text-secondary">Pilih dosen untuk memulai chat</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
