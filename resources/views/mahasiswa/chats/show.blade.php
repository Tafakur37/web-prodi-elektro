@extends('layouts.app')

@section('title', 'Chat dengan ' . $dosen->name)

@section('content')
<div class="container-fluid px-0">
    <div class="row g-4">
        <!-- Kolom Kiri: Daftar Dosen -->
        <div class="col-lg-4 d-none d-lg-block">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom border-light pt-4 pb-3 px-4">
                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-chat-dots text-primary me-2"></i> Daftar Dosen</h6>
                </div>
                <div class="card-body p-0 overflow-auto" style="max-height: 70vh;">
                    <div class="list-group list-group-flush border-0">
                        @foreach($dosens as $d)
                        <a href="{{ route('mahasiswa.chats.show', $d->id) }}" class="list-group-item list-group-item-action px-4 py-3 border-light d-flex align-items-center {{ $d->id == $dosen->id ? 'bg-primary bg-opacity-10 border-start border-4 border-primary' : '' }}">
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
        
        <!-- Kolom Kanan: Ruang Chat -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100 d-flex flex-column">
                <div class="card-header bg-white border-bottom border-light p-3 d-flex align-items-center">
                    <a href="{{ route('mahasiswa.chats.index') }}" class="btn btn-sm btn-light me-3 d-lg-none"><i class="bi bi-arrow-left"></i></a>
                    @if($dosen->profile_photo)
                        <img src="{{ asset('storage/profiles/' . $dosen->profile_photo) }}" class="rounded-circle me-3 border" width="45" height="45" style="object-fit: cover;">
                    @else
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="bi bi-person-fill fs-5"></i>
                        </div>
                    @endif
                    <div>
                        <h6 class="mb-0 fw-bold">{{ $dosen->name }}</h6>
                        <small class="text-success"><i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i> Dosen</small>
                    </div>
                </div>
                
                <div class="card-body p-4 overflow-auto" style="height: 50vh; background-color: #f8f9fa;">
                    @if($chats->isEmpty())
                        <div class="text-center py-5 text-muted small">Mulai percakapan dengan mengirimkan pesan.</div>
                    @else
                        @foreach($chats as $chat)
                            @if($chat->sender_id === auth()->id())
                                <!-- Pesan Saya (Kanan) -->
                                <div class="d-flex justify-content-end mb-3">
                                    <div class="bg-primary text-white p-3 rounded-4 shadow-sm" style="max-width: 75%; border-bottom-right-radius: 4px !important;">
                                        <p class="mb-1">{{ $chat->message }}</p>
                                        <div class="text-end small opacity-75" style="font-size: 0.7rem;">
                                            {{ $chat->created_at->format('H:i') }}
                                            @if($chat->is_read) <i class="bi bi-check-all ms-1"></i> @else <i class="bi bi-check ms-1"></i> @endif
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Pesan Dosen (Kiri) -->
                                <div class="d-flex justify-content-start mb-3">
                                    <div class="bg-white p-3 rounded-4 shadow-sm border border-light" style="max-width: 75%; border-bottom-left-radius: 4px !important;">
                                        <p class="mb-1 text-dark">{{ $chat->message }}</p>
                                        <div class="text-start small text-muted" style="font-size: 0.7rem;">{{ $chat->created_at->format('H:i') }}</div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
                
                <div class="card-footer bg-white border-top border-light p-3">
                    <form action="{{ route('mahasiswa.chats.store', $dosen->id) }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="message" class="form-control border-secondary border-opacity-25 rounded-pill rounded-end ps-4" placeholder="Ketik pesan..." required autofocus>
                            <button class="btn btn-primary rounded-pill rounded-start px-4 fw-bold" type="submit"><i class="bi bi-send-fill me-1"></i> Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Scroll chat ke bawah
    document.addEventListener("DOMContentLoaded", function() {
        const chatBody = document.querySelector('.card-body.overflow-auto');
        chatBody.scrollTop = chatBody.scrollHeight;
    });
</script>
@endsection
