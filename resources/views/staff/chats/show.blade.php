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
                    <div class="d-flex w-100 chat-item align-items-center mb-2" data-id="{{ $chat->id }}">
                        @if($chat->sender_id === auth()->id())
                            <!-- Sent: Menu di kiri, Bubble di kanan -->
                            <div class="dropdown me-2 ms-auto">
                                <button class="btn btn-sm btn-link text-muted px-1" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="opacity:0.3;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.3">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 small">
                                    <li><a class="dropdown-item text-danger" href="#" onclick="deleteChat({{ $chat->id }}, 'for_me', event)"><i class="bi bi-trash me-2"></i>Hapus untuk saya</a></li>
                                    <li><a class="dropdown-item text-danger fw-bold" href="#" onclick="deleteChat({{ $chat->id }}, 'for_everyone', event)"><i class="bi bi-trash-fill me-2"></i>Hapus untuk semua orang</a></li>
                                </ul>
                            </div>
                            <div class="chat-bubble chat-sent m-0">
                                @if($chat->file_path)
                                    <div class="mb-2">
                                        <a href="{{ asset('storage/chats/' . $chat->file_path) }}" target="_blank" class="text-white text-decoration-underline small"><i class="bi bi-paperclip"></i> Lihat Lampiran</a>
                                    </div>
                                @endif
                                @if($chat->message)
                                    <div class="msg-text">{{ $chat->message }}</div>
                                @endif
                                <div class="chat-time">
                                    {{ $chat->created_at->format('H:i') }}
                                    @if($chat->sender_id === auth()->id())
                                        <i class="bi {{ $chat->is_read ? 'bi-check2-all text-info' : 'bi-check2' }} ms-1"></i>
                                    @endif
                                </div>
                            </div>
                        @else
                            <!-- Received: Bubble di kiri, Menu di kanan -->
                            <div class="chat-bubble chat-received m-0">
                                @if($chat->file_path)
                                    <div class="mb-2">
                                        <a href="{{ asset('storage/chats/' . $chat->file_path) }}" target="_blank" class="text-primary text-decoration-underline small"><i class="bi bi-paperclip"></i> Lihat Lampiran</a>
                                    </div>
                                @endif
                                @if($chat->message)
                                    <div class="msg-text">{{ $chat->message }}</div>
                                @endif
                                <div class="chat-time">
                                    {{ $chat->created_at->format('H:i') }}
                                    @if($chat->sender_id === auth()->id())
                                        <i class="bi {{ $chat->is_read ? 'bi-check2-all text-info' : 'bi-check2' }} ms-1"></i>
                                    @endif
                                </div>
                            </div>
                            <div class="dropdown ms-2 me-auto">
                                <button class="btn btn-sm btn-link text-muted px-1" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="opacity:0.3;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.3">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu shadow-sm border-0 small">
                                    <li><a class="dropdown-item text-danger" href="#" onclick="deleteChat({{ $chat->id }}, 'for_me', event)"><i class="bi bi-trash me-2"></i>Hapus dari perangkat saya</a></li>
                                </ul>
                            </div>
                        @endif
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
                    <button type="button" class="btn btn-light border border-start-0 border-end-0 px-3" id="emoji-btn" title="Emoji">
                        <i class="bi bi-emoji-smile fs-5"></i>
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

<!-- Toast Container -->
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1060">
    <div id="chatToast" class="toast align-items-center text-white bg-primary border-0 rounded-4 shadow" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body fw-bold" id="toastMessage">
                Pesan baru diterima
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@4.6.4/dist/index.min.js"></script>
<script>
    const myId = {{ auth()->id() }};
    const deleteUrlBase = "{{ url('staff/chats/message') }}";

    function deleteChat(id, type, event) {
        event.preventDefault();
        if(!confirm('Anda yakin ingin menghapus pesan ini?')) return;

        fetch(`${deleteUrlBase}/${id}?type=${type}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                const bubble = document.querySelector(`.chat-item[data-id="${id}"]`);
                if(bubble) {
                    if(type === 'for_me') {
                        bubble.remove(); // Hapus elemen
                    } else {
                        // Kalau hapus untuk semua orang
                        const p = bubble.querySelector('.msg-text');
                        if(p) p.innerHTML = '<i>🚫 Pesan ini telah dihapus</i>';
                        const a = bubble.querySelector('a[target="_blank"]');
                        if(a) a.parentElement.remove();
                    }
                }
            }
        });
    }

    function playPing() {
        try {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            const osc = ctx.createOscillator();
            const gainNode = ctx.createGain();
            osc.type = 'sine';
            osc.frequency.setValueAtTime(600, ctx.currentTime);
            osc.frequency.exponentialRampToValueAtTime(800, ctx.currentTime + 0.1);
            gainNode.gain.setValueAtTime(0.5, ctx.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.2);
            osc.connect(gainNode);
            gainNode.connect(ctx.destination);
            osc.start();
            osc.stop(ctx.currentTime + 0.2);
        } catch(e) { }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const chatContainer = document.getElementById('chatContainer');
        const chatMessages = document.getElementById('chat-messages');
        const chatForm = document.getElementById('chat-form');
        const messageInput = document.getElementById('chat-message');
        const fileInput = document.getElementById('chat-file');
        const fileNameDisplay = document.getElementById('file-name');
        const btnSend = document.getElementById('btn-send');
        
        let lastChatCount = document.querySelectorAll('.chat-item').length;
        let lastChatIds = Array.from(document.querySelectorAll('.chat-item')).map(el => parseInt(el.getAttribute('data-id')));

        // Inisialisasi Emoji Button
        try {
            if (typeof EmojiButton !== 'undefined') {
                const picker = new EmojiButton({
                    position: 'top',
                    theme: 'light'
                });
                const emojiBtn = document.getElementById('emoji-btn');
                if (emojiBtn) {
                    picker.on('emoji', selection => {
                        messageInput.value += selection.emoji;
                        messageInput.focus();
                    });
                    emojiBtn.addEventListener('click', () => {
                        picker.togglePicker(emojiBtn);
                    });
                }
            }
        } catch(err) {
            console.error("EmojiButton tidak dapat dimuat:", err);
        }

        function scrollToBottom() {
            if(chatContainer) chatContainer.scrollTop = chatContainer.scrollHeight;
        }
        scrollToBottom();

        function formatTime(dateStr) {
            const d = new Date(dateStr);
            return d.getHours().toString().padStart(2, '0') + ':' + d.getMinutes().toString().padStart(2, '0');
        }

        function renderChat(chat, isSending = false) {
            const isMe = chat.sender_id === myId;
            const time = formatTime(chat.created_at);
            const bubbleClass = isMe ? 'chat-sent' : 'chat-received';
            const fileUrl = chat.file_path ? `{{ asset('storage/chats') }}/${chat.file_path}` : '';
            
            let fileHtml = '';
            if (chat.file_path && !chat.is_deleted_for_everyone) {
                const colorClass = isMe ? 'text-white' : 'text-primary';
                fileHtml = `<div class="mb-2"><a href="${fileUrl}" target="_blank" class="${colorClass} text-decoration-underline small"><i class="bi bi-paperclip"></i> Lihat Lampiran</a></div>`;
            }
            
            let msgHtml = '';
            if (chat.message) {
                if(chat.is_deleted_for_everyone) {
                    msgHtml = `<div class="msg-text"><i>${chat.message}</i></div>`;
                } else {
                    msgHtml = `<div class="msg-text">${chat.message}</div>`;
                }
            }
            
            let statusHtml = '';
            if (isMe) {
                if(isSending) {
                    statusHtml = `<i class="bi bi-clock ms-1"></i>`;
                } else {
                    statusHtml = `<i class="bi ${chat.is_read ? 'bi-check2-all text-info' : 'bi-check2'} ms-1"></i>`;
                }
            }

            if (isMe) {
                return `
                <div class="d-flex w-100 chat-item align-items-center mb-2" data-id="${chat.id}">
                    <div class="dropdown me-2 ms-auto">
                        <button class="btn btn-sm btn-link text-muted px-1" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="opacity:0.3;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.3">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 small">
                            <li><a class="dropdown-item text-danger" href="#" onclick="deleteChat('${chat.id}', 'for_me', event)"><i class="bi bi-trash me-2"></i>Hapus untuk saya</a></li>
                            ${!chat.is_deleted_for_everyone && !isSending ? `<li><a class="dropdown-item text-danger fw-bold" href="#" onclick="deleteChat('${chat.id}', 'for_everyone', event)"><i class="bi bi-trash-fill me-2"></i>Hapus untuk semua orang</a></li>` : ''}
                        </ul>
                    </div>
                    <div class="chat-bubble ${bubbleClass} m-0">
                        ${fileHtml}
                        ${msgHtml}
                        <div class="chat-time">
                            ${time} ${statusHtml}
                        </div>
                    </div>
                </div>`;
            } else {
                return `
                <div class="d-flex w-100 chat-item align-items-center mb-2" data-id="${chat.id}">
                    <div class="chat-bubble ${bubbleClass} m-0">
                        ${fileHtml}
                        ${msgHtml}
                        <div class="chat-time">
                            ${time} ${statusHtml}
                        </div>
                    </div>
                    <div class="dropdown ms-2 me-auto">
                        <button class="btn btn-sm btn-link text-muted px-1" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="opacity:0.3;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.3">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu shadow-sm border-0 small">
                            <li><a class="dropdown-item text-danger" href="#" onclick="deleteChat('${chat.id}', 'for_me', event)"><i class="bi bi-trash me-2"></i>Hapus dari perangkat saya</a></li>
                        </ul>
                    </div>
                </div>`;
            }
        }

        if(chatForm) {
            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const msgText = messageInput.value.trim();
                if (!msgText && !fileInput.files.length) return;
                
                const formData = new FormData(this);
                btnSend.disabled = true;
                btnSend.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
                
                const tempId = 'temp-' + Date.now();
                const tempChat = {
                    id: tempId,
                    sender_id: myId,
                    message: msgText,
                    file_path: fileInput.files.length ? fileInput.files[0].name : null,
                    created_at: new Date().toISOString(),
                    is_read: false,
                    is_deleted_for_everyone: false
                };
                
                const emptyMsg = document.getElementById('empty-msg');
                if (emptyMsg) emptyMsg.remove();
                
                chatMessages.insertAdjacentHTML('beforeend', renderChat(tempChat, true));
                scrollToBottom();
                
                messageInput.value = '';
                fileInput.value = '';
                fileNameDisplay.textContent = '';
                
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
                        const tempEl = document.querySelector(`.chat-item[data-id="${tempId}"]`);
                        if (tempEl) {
                            tempEl.outerHTML = renderChat(data.chat);
                        } else {
                            chatMessages.insertAdjacentHTML('beforeend', renderChat(data.chat));
                        }
                        scrollToBottom();
                        lastChatIds.push(data.chat.id);
                        lastChatCount++;
                    }
                })
                .finally(() => {
                    btnSend.disabled = false;
                    btnSend.innerHTML = '<i class="bi bi-send-fill"></i>';
                });
            });

            function showToast(title) {
                document.getElementById('toastMessage').innerText = title;
                const toastEl = document.getElementById('chatToast');
                const toast = new bootstrap.Toast(toastEl, { delay: 4000 });
                toast.show();
                playPing();
            }

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
                    if (data.chats) {
                        let hasNewMessage = false;
                        let lastSenderNotMe = false;

                        let newHtml = '';
                        data.chats.forEach(chat => {
                            newHtml += renderChat(chat);
                            if (!lastChatIds.includes(chat.id)) {
                                hasNewMessage = true;
                                if (chat.sender_id !== myId) lastSenderNotMe = true;
                                lastChatIds.push(chat.id);
                            }
                        });

                        if (chatMessages.innerHTML.length !== newHtml.length || hasNewMessage) {
                            const isAtBottom = (chatContainer.scrollTop + chatContainer.clientHeight >= chatContainer.scrollHeight - 10);
                            const currentScrollTop = chatContainer.scrollTop;
                            
                            const emptyMsg = document.getElementById('empty-msg');
                            if (emptyMsg) emptyMsg.remove();
                            
                            const tempMessages = Array.from(chatMessages.querySelectorAll('.chat-item[data-id^="temp-"]'));
                            
                            chatMessages.innerHTML = newHtml;
                            
                            tempMessages.forEach(el => chatMessages.appendChild(el));

                            if (hasNewMessage || isAtBottom) {
                                scrollToBottom();
                            } else {
                                chatContainer.scrollTop = currentScrollTop;
                            }

                            if (hasNewMessage && lastSenderNotMe) {
                                showToast("Pesan baru dari Mahasiswa");
                            }
                        }
                        lastChatCount = data.chats.length;
                    }
                })
                .catch(err => console.error(err));
            }, 3000);
        }
    });
</script>
@endpush
