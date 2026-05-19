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
            <div id="chat-messages" class="w-100">
                @forelse($chats as $chat)
                    <div class="d-flex flex-column w-100 chat-item" data-id="{{ $chat->id }}">
                        <div class="chat-bubble {{ $chat->sender_id === auth()->id() ? 'chat-sent' : 'chat-received' }}">
                            @if($chat->file_path)
                                <div class="mb-2">
                                    <a href="{{ asset('storage/chats/' . $chat->file_path) }}" target="_blank" class="{{ $chat->sender_id === auth()->id() ? 'text-white' : 'text-primary' }} text-decoration-underline small"><i class="bi bi-paperclip"></i> Lihat Lampiran</a>
                                </div>
                            @endif
                            @if($chat->message)
                                <div>{{ $chat->message }}</div>
                            @endif
                            <div class="chat-time">
                                {{ $chat->created_at->format('H:i') }}
                                @if($chat->sender_id === auth()->id())
                                    <i class="bi {{ $chat->is_read ? 'bi-check2-all text-info' : 'bi-check2' }} ms-1"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted" id="empty-msg">
                        <i class="bi bi-chat-dots fs-1 mb-3 d-block opacity-25"></i>
                        Belum ada pesan. Mulai percakapan sekarang!
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Chat Input -->
        <div class="card-footer bg-white border-top p-3">
            <form id="chat-form" action="{{ route('staff.chats.store', $student->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="input-group">
                    <input type="file" name="file" id="chat-file" class="d-none" onchange="document.getElementById('file-name').textContent = this.files[0]?.name || ''">
                    <button type="button" class="btn btn-light border border-end-0 px-3" onclick="document.getElementById('chat-file').click()" title="Lampirkan File">
                        <i class="bi bi-paperclip fs-5"></i>
                    </button>
                    <input type="text" name="message" id="chat-message" class="form-control form-control-lg bg-light border-start-0" placeholder="Ketik pesan..." autofocus autocomplete="off">
                    <button class="btn btn-primary px-4 rounded-end" type="submit" id="btn-send">
                        <i class="bi bi-send-fill"></i>
                    </button>
                </div>
                <div id="file-name" class="small text-muted mt-1 px-2"></div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const chatContainer = document.getElementById('chatContainer');
        const chatMessages = document.getElementById('chat-messages');
        const chatForm = document.getElementById('chat-form');
        const messageInput = document.getElementById('chat-message');
        const fileInput = document.getElementById('chat-file');
        const fileNameDisplay = document.getElementById('file-name');
        const btnSend = document.getElementById('btn-send');
        const myId = {{ auth()->id() }};
        
        let lastChatCount = document.querySelectorAll('.chat-item').length;

        function scrollToBottom() {
            if(chatContainer) chatContainer.scrollTop = chatContainer.scrollHeight;
        }
        scrollToBottom();

        function formatTime(dateStr) {
            const d = new Date(dateStr);
            return d.getHours().toString().padStart(2, '0') + ':' + d.getMinutes().toString().padStart(2, '0');
        }

        function renderChat(chat) {
            const isMe = chat.sender_id === myId;
            const time = formatTime(chat.created_at);
            const bubbleClass = isMe ? 'chat-sent' : 'chat-received';
            const fileUrl = chat.file_path ? `{{ asset('storage/chats') }}/${chat.file_path}` : '';
            
            let fileHtml = '';
            if (chat.file_path) {
                const colorClass = isMe ? 'text-white' : 'text-primary';
                fileHtml = `<div class="mb-2"><a href="${fileUrl}" target="_blank" class="${colorClass} text-decoration-underline small"><i class="bi bi-paperclip"></i> Lihat Lampiran</a></div>`;
            }
            
            let msgHtml = '';
            if (chat.message) {
                msgHtml = `<div>${chat.message}</div>`;
            }
            
            let statusHtml = '';
            if (isMe) {
                statusHtml = `<i class="bi ${chat.is_read ? 'bi-check2-all text-info' : 'bi-check2'} ms-1"></i>`;
            }

            return `
            <div class="d-flex flex-column w-100 chat-item" data-id="${chat.id}">
                <div class="chat-bubble ${bubbleClass}">
                    ${fileHtml}
                    ${msgHtml}
                    <div class="chat-time">
                        ${time} ${statusHtml}
                    </div>
                </div>
            </div>`;
        }

        if(chatForm) {
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
                    btnSend.innerHTML = '<i class="bi bi-send-fill"></i>';
                });
            });

            // Polling setiap 3 detik
            setInterval(() => {
                fetch("{{ route('staff.chats.show', $student->id) }}", {
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
        }
    });
</script>
@endpush
