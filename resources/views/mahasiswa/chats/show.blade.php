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
                
                <div class="card-body p-4 overflow-auto" id="chat-body" style="height: 50vh; background-color: #f8f9fa;">
                    <div id="chat-messages">
                        @if($chats->isEmpty())
                            <div class="text-center py-5 text-muted small" id="empty-msg">Mulai percakapan dengan mengirimkan pesan.</div>
                        @else
                            @foreach($chats as $chat)
                                @if($chat->sender_id === auth()->id())
                                    <!-- Pesan Saya (Kanan) -->
                                    <div class="d-flex justify-content-end mb-3 chat-item" data-id="{{ $chat->id }}">
                                        <div class="bg-primary text-white p-3 rounded-4 shadow-sm" style="max-width: 75%; border-bottom-right-radius: 4px !important;">
                                            @if($chat->file_path)
                                                <div class="mb-2">
                                                    <a href="{{ asset('storage/chats/' . $chat->file_path) }}" target="_blank" class="text-white text-decoration-underline small"><i class="bi bi-paperclip"></i> Lihat Lampiran</a>
                                                </div>
                                            @endif
                                            @if($chat->message)
                                                <p class="mb-1">{{ $chat->message }}</p>
                                            @endif
                                            <div class="text-end small opacity-75" style="font-size: 0.7rem;">
                                                {{ $chat->created_at->format('H:i') }}
                                                @if($chat->is_read) <i class="bi bi-check-all ms-1"></i> @else <i class="bi bi-check ms-1"></i> @endif
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <!-- Pesan Dosen (Kiri) -->
                                    <div class="d-flex justify-content-start mb-3 chat-item" data-id="{{ $chat->id }}">
                                        <div class="bg-white p-3 rounded-4 shadow-sm border border-light" style="max-width: 75%; border-bottom-left-radius: 4px !important;">
                                            @if($chat->file_path)
                                                <div class="mb-2">
                                                    <a href="{{ asset('storage/chats/' . $chat->file_path) }}" target="_blank" class="text-primary text-decoration-underline small"><i class="bi bi-paperclip"></i> Lihat Lampiran</a>
                                                </div>
                                            @endif
                                            @if($chat->message)
                                                <p class="mb-1 text-dark">{{ $chat->message }}</p>
                                            @endif
                                            <div class="text-start small text-muted" style="font-size: 0.7rem;">{{ $chat->created_at->format('H:i') }}</div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
                
                <div class="card-footer bg-white border-top border-light p-3">
                    <form id="chat-form" action="{{ route('mahasiswa.chats.store', $dosen->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group">
                            <input type="file" name="file" id="chat-file" class="d-none" onchange="document.getElementById('file-name').textContent = this.files[0]?.name || ''">
                            <button type="button" class="btn btn-light border-secondary border-opacity-25 rounded-start px-3" onclick="document.getElementById('chat-file').click()" title="Lampirkan File">
                                <i class="bi bi-paperclip"></i>
                            </button>
                            <input type="text" name="message" id="chat-message" class="form-control border-secondary border-opacity-25 ps-3" placeholder="Ketik pesan..." autofocus>
                            <button class="btn btn-primary rounded-end px-4 fw-bold" type="submit" id="btn-send"><i class="bi bi-send-fill me-1"></i> Kirim</button>
                        </div>
                        <div id="file-name" class="small text-muted mt-1 px-2"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const chatBody = document.getElementById('chat-body');
    const chatMessages = document.getElementById('chat-messages');
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('chat-message');
    const fileInput = document.getElementById('chat-file');
    const fileNameDisplay = document.getElementById('file-name');
    const btnSend = document.getElementById('btn-send');
    const myId = {{ auth()->id() }};
    
    let lastChatCount = document.querySelectorAll('.chat-item').length;

    function scrollToBottom() {
        chatBody.scrollTop = chatBody.scrollHeight;
    }
    
    scrollToBottom();

    // Format waktu
    function formatTime(dateStr) {
        const d = new Date(dateStr);
        return d.getHours().toString().padStart(2, '0') + ':' + d.getMinutes().toString().padStart(2, '0');
    }

    // Render satu bubble chat
    function renderChat(chat) {
        const isMe = chat.sender_id === myId;
        const time = formatTime(chat.created_at);
        const fileUrl = chat.file_path ? `{{ asset('storage/chats') }}/${chat.file_path}` : '';
        
        let fileHtml = '';
        if (chat.file_path) {
            const colorClass = isMe ? 'text-white' : 'text-primary';
            fileHtml = `<div class="mb-2"><a href="${fileUrl}" target="_blank" class="${colorClass} text-decoration-underline small"><i class="bi bi-paperclip"></i> Lihat Lampiran</a></div>`;
        }
        
        let msgHtml = '';
        if (chat.message) {
            msgHtml = `<p class="mb-1 ${isMe ? '' : 'text-dark'}">${chat.message}</p>`;
        }
        
        const statusHtml = isMe ? (chat.is_read ? '<i class="bi bi-check-all ms-1"></i>' : '<i class="bi bi-check ms-1"></i>') : '';
        
        if (isMe) {
            return `
            <div class="d-flex justify-content-end mb-3 chat-item" data-id="${chat.id}">
                <div class="bg-primary text-white p-3 rounded-4 shadow-sm" style="max-width: 75%; border-bottom-right-radius: 4px !important;">
                    ${fileHtml}
                    ${msgHtml}
                    <div class="text-end small opacity-75" style="font-size: 0.7rem;">${time} ${statusHtml}</div>
                </div>
            </div>`;
        } else {
            return `
            <div class="d-flex justify-content-start mb-3 chat-item" data-id="${chat.id}">
                <div class="bg-white p-3 rounded-4 shadow-sm border border-light" style="max-width: 75%; border-bottom-left-radius: 4px !important;">
                    ${fileHtml}
                    ${msgHtml}
                    <div class="text-start small text-muted" style="font-size: 0.7rem;">${time}</div>
                </div>
            </div>`;
        }
    }

    // Submit form via AJAX
    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        if (!messageInput.value.trim() && !fileInput.files.length) return;
        
        const formData = new FormData(this);
        btnSend.disabled = true;
        btnSend.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const emptyMsg = document.getElementById('empty-msg');
                if (emptyMsg) emptyMsg.remove();
                
                chatMessages.insertAdjacentHTML('beforeend', renderChat(data.chat));
                scrollToBottom();
                
                messageInput.value = '';
                fileInput.value = '';
                fileNameDisplay.textContent = '';
                lastChatCount++;
            }
        })
        .finally(() => {
            btnSend.disabled = false;
            btnSend.innerHTML = '<i class="bi bi-send-fill me-1"></i> Kirim';
        });
    });

    // Polling setiap 3 detik
    setInterval(() => {
        fetch("{{ route('mahasiswa.chats.show', $dosen->id) }}", {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.chats && data.chats.length > lastChatCount) {
                const emptyMsg = document.getElementById('empty-msg');
                if (emptyMsg) emptyMsg.remove();
                
                // Cari pesan baru
                const newChats = data.chats.slice(lastChatCount);
                newChats.forEach(chat => {
                    chatMessages.insertAdjacentHTML('beforeend', renderChat(chat));
                });
                
                lastChatCount = data.chats.length;
                scrollToBottom();
            }
        })
        .catch(err => console.error(err));
    }, 3000);
});
</script>
@endsection
