@extends('layouts.app')

@push('styles')
<style>
    .chat-container { height: calc(100vh - 250px); overflow-y: auto; padding: 20px; }
    .chat-bubble { max-width: 75%; padding: 12px 18px; border-radius: 20px; margin-bottom: 15px; position: relative; }
    .chat-sent { background-color: #0d6efd; color: white; margin-left: auto; border-bottom-right-radius: 5px; }
    .chat-received { background-color: #f8f9fa; color: #333; border: 1px solid #e9ecef; margin-right: auto; border-bottom-left-radius: 5px; }
    .chat-time { font-size: 0.7rem; margin-top: 5px; opacity: 0.8; }
    .chat-sent .chat-time { text-align: right; }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <!-- Chat Header -->
        <div class="card-header bg-white border-bottom p-3 d-flex align-items-center">
            <a href="{{ route('staff.chats.index') }}" class="btn btn-sm btn-light rounded-circle me-3">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div class="avatar-circle bg-primary text-white d-flex justify-content-center align-items-center rounded-circle me-3" style="width: 45px; height: 45px; font-weight: bold;">
                {{ substr($student->name, 0, 1) }}
            </div>
            <div>
                <h5 class="mb-0 fw-bold">{{ $student->name }}</h5>
                <small class="text-muted">{{ $student->nim }} | Mahasiswa Cohort {{ $student->cohort }}</small>
            </div>
        </div>

        <!-- Chat Area -->
        <div class="chat-container bg-light" id="chatContainer">
            @forelse($chats as $chat)
                <div class="d-flex flex-column w-100">
                    <div class="chat-bubble {{ $chat->sender_id === auth()->id() ? 'chat-sent' : 'chat-received' }}">
                        {{ $chat->message }}
                        <div class="chat-time">
                            {{ $chat->created_at->format('H:i') }}
                            @if($chat->sender_id === auth()->id())
                                <i class="bi {{ $chat->is_read ? 'bi-check2-all text-info' : 'bi-check2' }} ms-1"></i>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-chat-dots fs-1 mb-3 d-block opacity-25"></i>
                    Belum ada pesan. Mulai percakapan sekarang!
                </div>
            @endforelse
        </div>

        <!-- Chat Input -->
        <div class="card-footer bg-white border-top p-3">
            <form action="{{ route('staff.chats.store', $student->id) }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" name="message" class="form-control form-control-lg bg-light border-0" placeholder="Ketik pesan..." required autofocus autocomplete="off">
                    <button class="btn btn-primary px-4 rounded-end" type="submit">
                        <i class="bi bi-send-fill"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Scroll to bottom of chat
    const chatContainer = document.getElementById('chatContainer');
    chatContainer.scrollTop = chatContainer.scrollHeight;
</script>
@endpush
