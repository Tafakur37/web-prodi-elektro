@extends('layouts.mahasiswa')

@section('title', 'Chat dengan ' . $partner->name)

@push('styles')
<style>
.chat-layout {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 0;
    height: calc(100vh - 130px);
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: var(--radius-xl);
    overflow: hidden;
}

/* Contact List */
.chat-sidebar {
    display: flex;
    flex-direction: column;
    border-right: 1px solid var(--border);
    overflow: hidden;
}

.chat-sidebar-header {
    padding: 16px 16px 12px;
    border-bottom: 1px solid var(--border);
    background: rgba(255,255,255,0.02);
}

.chat-sidebar-title {
    font-family: var(--font-display);
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--text-1);
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.chat-search-wrap {
    position: relative;
}

.chat-search-input {
    width: 100%;
    padding: 8px 12px 8px 34px;
    background: rgba(255,255,255,0.05);
    border: 1px solid var(--border);
    border-radius: 20px;
    font-size: 0.82rem;
    color: var(--text-1);
    font-family: var(--font);
    outline: none;
    transition: border-color 0.2s;
}

.chat-search-input::placeholder { color: var(--text-3); }
.chat-search-input:focus { border-color: var(--primary); }

.chat-search-icon {
    position: absolute;
    left: 11px; top: 50%;
    transform: translateY(-50%);
    color: var(--text-3);
    font-size: 0.8rem;
    pointer-events: none;
}

.search-dropdown {
    position: absolute;
    left: 0; right: 0;
    top: calc(100% + 6px);
    background: #0d1a2e;
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    z-index: 1050;
    max-height: 220px;
    overflow-y: auto;
    display: none;
}

.search-dropdown.show { display: block; }

.search-result-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 14px;
    cursor: pointer;
    text-decoration: none;
    color: var(--text-1);
    transition: background 0.15s;
    border-bottom: 1px solid var(--border);
}
.search-result-item:last-child { border-bottom: none; }
.search-result-item:hover { background: rgba(0,102,255,0.08); }

.search-result-avatar {
    width: 30px; height: 30px;
    border-radius: 9px;
    background: var(--primary-light);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.8rem; color: var(--primary);
    font-weight: 700;
    flex-shrink: 0; overflow: hidden;
}

.search-result-avatar img { width: 100%; height: 100%; object-fit: cover; }

/* Contacts */
.chat-contacts { flex: 1; overflow-y: auto; }

.chat-contact-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    cursor: pointer;
    text-decoration: none;
    color: var(--text-1);
    transition: background 0.15s;
    border-bottom: 1px solid rgba(255,255,255,0.04);
}

.chat-contact-item:hover { background: rgba(255,255,255,0.04); }
.chat-contact-item.active { background: rgba(0,102,255,0.1); border-left: 3px solid var(--primary); }

.chat-contact-avatar {
    width: 42px; height: 42px;
    border-radius: 14px;
    background: linear-gradient(135deg, var(--primary), var(--cyan));
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem; color: #fff; font-weight: 700;
    flex-shrink: 0; overflow: hidden;
}

.chat-contact-avatar img { width: 100%; height: 100%; object-fit: cover; }

.chat-contact-info { flex: 1; min-width: 0; }
.chat-contact-name  { font-size: 0.84rem; font-weight: 700; margin-bottom: 2px; color: var(--text-1); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.chat-contact-last  { font-size: 0.72rem; color: var(--text-3); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

.chat-contact-meta { text-align: right; flex-shrink: 0; }
.chat-contact-time  { font-size: 0.65rem; color: var(--text-3); margin-bottom: 4px; }
.chat-unread-badge  { background: var(--danger); color: #fff; font-size: 0.6rem; font-weight: 700; padding: 2px 6px; border-radius: 10px; }

/* Chat Panel */
.chat-panel {
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.chat-panel-header {
    padding: 12px 18px;
    border-bottom: 1px solid var(--border);
    background: rgba(255,255,255,0.02);
    display: flex;
    align-items: center;
    gap: 12px;
}

.chat-partner-avatar {
    width: 40px; height: 40px;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--primary), var(--cyan));
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem; color: #fff; font-weight: 700;
    flex-shrink: 0; overflow: hidden;
}

.chat-partner-avatar img { width: 100%; height: 100%; object-fit: cover; }

.chat-partner-name { font-size: 0.9rem; font-weight: 700; color: var(--text-1); }
.chat-partner-sub  { font-size: 0.72rem; color: var(--success); }

/* Messages area */
#chat-body {
    flex: 1;
    overflow-y: auto;
    padding: 20px 18px;
    background: rgba(0,0,0,0.12);
    display: flex;
    flex-direction: column;
}

#chat-messages { flex: 1; display: flex; flex-direction: column; justify-content: flex-end; }

/* Bubbles */
.chat-item { margin-bottom: 12px; display: flex; align-items: flex-end; gap: 6px; }
.chat-item.me  { justify-content: flex-end; }
.chat-item.them { justify-content: flex-start; }

.bubble-me {
    background: linear-gradient(135deg, var(--primary), #0080ff);
    color: #fff;
    padding: 10px 14px;
    border-radius: 16px 16px 4px 16px;
    max-width: 70%;
    font-size: 0.86rem;
    line-height: 1.5;
    box-shadow: 0 4px 12px rgba(0,102,255,0.25);
}

.bubble-them {
    background: rgba(255,255,255,0.07);
    border: 1px solid var(--border);
    color: var(--text-1);
    padding: 10px 14px;
    border-radius: 16px 16px 16px 4px;
    max-width: 70%;
    font-size: 0.86rem;
    line-height: 1.5;
}

.bubble-time {
    font-size: 0.65rem;
    opacity: 0.65;
    margin-top: 5px;
    display: flex;
    align-items: center;
    gap: 3px;
}

.bubble-me .bubble-time { justify-content: flex-end; }

.chat-deleted { font-style: italic; opacity: 0.6; }

/* Dropdown menu dark */
.dropdown-menu {
    background: #0d1a2e !important;
    border: 1px solid var(--border) !important;
    border-radius: var(--radius-lg) !important;
}

.dropdown-item { color: var(--text-2) !important; font-size: 0.82rem; }
.dropdown-item:hover { background: rgba(255,255,255,0.06) !important; color: var(--text-1) !important; }
.dropdown-item.text-danger { color: var(--danger) !important; }

/* Chat footer */
.chat-footer {
    padding: 12px 16px;
    border-top: 1px solid var(--border);
    background: rgba(255,255,255,0.02);
}

.chat-input-row {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.05);
    border: 1px solid var(--border);
    border-radius: 50px;
    padding: 6px 8px;
    transition: border-color 0.2s;
}

.chat-input-row:focus-within { border-color: var(--primary); }

.chat-action-btn {
    width: 34px; height: 34px;
    border-radius: 50%;
    background: transparent;
    border: none;
    color: var(--text-3);
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem; cursor: pointer;
    transition: all 0.15s;
    flex-shrink: 0;
}

.chat-action-btn:hover { color: var(--cyan); background: rgba(0,198,255,0.08); }

#chat-message {
    flex: 1;
    background: transparent;
    border: none;
    outline: none;
    color: var(--text-1);
    font-size: 0.86rem;
    font-family: var(--font);
    padding: 4px 8px;
}

#chat-message::placeholder { color: var(--text-3); }

.send-btn {
    width: 36px; height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), var(--cyan));
    border: none;
    color: #fff;
    font-size: 0.95rem;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(0,102,255,0.3);
}

.send-btn:hover { transform: scale(1.1); }
.send-btn:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

#file-name {
    font-size: 0.72rem;
    color: var(--cyan);
    margin-top: 5px;
    padding-left: 10px;
}

/* Toast dark */
#chatToast {
    background: rgba(13,26,46,0.95) !important;
    border: 1px solid var(--border) !important;
    backdrop-filter: blur(10px);
}
</style>
@endpush

@section('content')
<div class="chat-layout">

    {{-- CONTACT LIST --}}
    <div class="chat-sidebar">
        <div class="chat-sidebar-header">
            <div class="chat-sidebar-title">
                <i class="bi bi-chat-dots" style="color:var(--purple);"></i>
                Pesan
            </div>
            <div class="chat-search-wrap">
                <i class="bi bi-search chat-search-icon"></i>
                <input type="text" id="user-search-input" class="chat-search-input" placeholder="Cari pengguna..." autocomplete="off">
                <div id="search-results-dropdown" class="search-dropdown"></div>
            </div>
        </div>

        <div class="chat-contacts">
            @forelse($recentContacts as $contact)
            @php
                $roleCls = match($contact->role) {
                    'mahasiswa' => 'success',
                    'dosen'     => 'primary',
                    'staff'     => 'warning',
                    'admin'     => 'danger',
                    default     => 'muted',
                };
            @endphp
            <a href="{{ route('mahasiswa.chats.show', $contact->id) }}"
               class="chat-contact-item {{ $contact->id == $partner->id ? 'active' : '' }}">
                <div class="chat-contact-avatar">
                    @if($contact->profile_photo)
                        <img src="{{ asset('storage/profiles/' . $contact->profile_photo) }}" alt="{{ $contact->name }}">
                    @else
                        {{ strtoupper(substr($contact->name, 0, 1)) }}
                    @endif
                </div>
                <div class="chat-contact-info">
                    <div style="display:flex;align-items:center;gap:5px;margin-bottom:2px;">
                        <span class="chat-contact-name">{{ $contact->name }}</span>
                        <span class="mhs-badge {{ $roleCls }}" style="font-size:0.55rem;padding:2px 6px;">{{ $contact->role }}</span>
                    </div>
                    <div class="chat-contact-last">{{ $contact->latest_message }}</div>
                </div>
                <div class="chat-contact-meta">
                    <div class="chat-contact-time">{{ $contact->latest_message_time }}</div>
                    @if($contact->unread_count > 0)
                    <span class="chat-unread-badge">{{ $contact->unread_count }}</span>
                    @endif
                </div>
            </a>
            @empty
            <div style="text-align:center;padding:40px 16px;font-size:0.8rem;color:var(--text-3);">
                Belum ada percakapan.
            </div>
            @endforelse
        </div>
    </div>

    {{-- CHAT PANEL --}}
    <div class="chat-panel">
        {{-- Header --}}
        <div class="chat-panel-header">
            <a href="{{ route('mahasiswa.chats.index') }}" class="mhs-btn mhs-btn-ghost mhs-btn-sm d-lg-none" style="padding:6px 10px;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div class="chat-partner-avatar">
                @if($partner->profile_photo)
                    <img src="{{ asset('storage/profiles/' . $partner->profile_photo) }}" alt="{{ $partner->name }}">
                @else
                    {{ strtoupper(substr($partner->name, 0, 1)) }}
                @endif
            </div>
            <div>
                <div class="chat-partner-name">{{ $partner->name }}</div>
                <div class="chat-partner-sub">
                    <i class="bi bi-circle-fill" style="font-size:0.45rem;"></i>
                    {{ ucfirst($partner->role) }}
                    @if($partner->role === 'mahasiswa') ({{ $partner->nim ?? '-' }}) @endif
                </div>
            </div>
        </div>

        {{-- Messages --}}
        <div id="chat-body">
            <div id="chat-messages">
                @if($chats->isEmpty())
                    <div class="mhs-empty" id="empty-msg">
                        <i class="bi bi-chat-square-text"></i>
                        <p>Mulai percakapan dengan mengirimkan pesan.</p>
                    </div>
                @else
                    @foreach($chats as $chat)
                    @php $isMe = $chat->sender_id === auth()->id(); @endphp
                    <div class="chat-item {{ $isMe ? 'me' : 'them' }}" data-id="{{ $chat->id }}">

                        @if($isMe)
                        {{-- Dropdown kiri bubble (me) --}}
                        <div class="dropdown">
                            <button class="chat-action-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width:22px;height:22px;font-size:0.75rem;">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item text-danger" href="#" onclick="deleteChat({{ $chat->id }}, 'for_me', event)"><i class="bi bi-trash me-2"></i>Hapus untuk saya</a></li>
                                <li><a class="dropdown-item text-danger" href="#" onclick="deleteChat({{ $chat->id }}, 'for_everyone', event)"><i class="bi bi-trash-fill me-2"></i>Hapus untuk semua</a></li>
                            </ul>
                        </div>
                        <div class="bubble-me">
                            @if($chat->file_path)
                            <div style="margin-bottom:6px;">
                                <a href="{{ asset('storage/chats/' . $chat->file_path) }}" target="_blank" style="color:rgba(255,255,255,0.8);font-size:0.78rem;"><i class="bi bi-paperclip me-1"></i>Lihat Lampiran</a>
                            </div>
                            @endif
                            @if($chat->message)
                            <p style="margin:0;">{{ $chat->message }}</p>
                            @endif
                            <div class="bubble-time">
                                {{ $chat->created_at->format('H:i') }}
                                @if($chat->is_read)<i class="bi bi-check-all"></i>@else<i class="bi bi-check"></i>@endif
                            </div>
                        </div>

                        @else
                        {{-- Bubble them --}}
                        <div class="bubble-them">
                            @if($chat->file_path)
                            <div style="margin-bottom:6px;">
                                <a href="{{ asset('storage/chats/' . $chat->file_path) }}" target="_blank" style="color:var(--cyan);font-size:0.78rem;"><i class="bi bi-paperclip me-1"></i>Lihat Lampiran</a>
                            </div>
                            @endif
                            @if($chat->message)
                            <p style="margin:0;">{{ $chat->message }}</p>
                            @endif
                            <div class="bubble-time">{{ $chat->created_at->format('H:i') }}</div>
                        </div>
                        <div class="dropdown">
                            <button class="chat-action-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width:22px;height:22px;font-size:0.75rem;">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item text-danger" href="#" onclick="deleteChat({{ $chat->id }}, 'for_me', event)"><i class="bi bi-trash me-2"></i>Hapus dari perangkat saya</a></li>
                            </ul>
                        </div>
                        @endif

                    </div>
                    @endforeach
                @endif
            </div>
        </div>

        {{-- Footer / Input --}}
        <div class="chat-footer">
            <form id="chat-form" action="{{ route('mahasiswa.chats.store', $partner->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" id="chat-file" class="d-none" onchange="document.getElementById('file-name').textContent = this.files[0]?.name || ''">
                <div class="chat-input-row">
                    <button type="button" class="chat-action-btn" onclick="document.getElementById('chat-file').click()" title="Lampiran">
                        <i class="bi bi-paperclip"></i>
                    </button>
                    <button type="button" class="chat-action-btn" id="emoji-btn" title="Emoji">😊</button>
                    <input type="text" name="message" id="chat-message" placeholder="Ketik pesan..." autofocus autocomplete="off">
                    <button class="send-btn" type="submit" id="btn-send" title="Kirim">
                        <i class="bi bi-send-fill"></i>
                    </button>
                </div>
                <div id="file-name"></div>
            </form>
        </div>
    </div>

</div>

{{-- Toast --}}
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index:1060;">
    <div id="chatToast" class="toast align-items-center border-0 rounded-4 shadow" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body fw-bold" id="toastMessage" style="color:var(--text-1);">Pesan baru diterima</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close" style="filter:invert(1) opacity(.5)"></button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@4.6.4/dist/index.min.js"></script>
<script>
const myId = {{ auth()->id() }};
const deleteUrlBase = "{{ url('mahasiswa/chats/message') }}";

function deleteChat(id, type, event) {
    event.preventDefault();
    if (!confirm('Anda yakin ingin menghapus pesan ini?')) return;
    fetch(`${deleteUrlBase}/${id}?type=${type}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            const bubble = document.querySelector(`.chat-item[data-id="${id}"]`);
            if (bubble) {
                if (type === 'for_me') {
                    bubble.remove();
                } else {
                    const p = bubble.querySelector('p');
                    if (p) p.innerHTML = '<i>🚫 Pesan ini telah dihapus</i>';
                    const a = bubble.querySelector('a[target="_blank"]');
                    if (a) a.parentElement.remove();
                }
            }
        }
    });
}

function playPing() {
    try {
        const ctx = new (window.AudioContext || window.webkitAudioContext)();
        const osc = ctx.createOscillator();
        const g = ctx.createGain();
        osc.type = 'sine';
        osc.frequency.setValueAtTime(600, ctx.currentTime);
        osc.frequency.exponentialRampToValueAtTime(800, ctx.currentTime + 0.1);
        g.gain.setValueAtTime(0.5, ctx.currentTime);
        g.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.2);
        osc.connect(g);
        g.connect(ctx.destination);
        osc.start();
        osc.stop(ctx.currentTime + 0.2);
    } catch(e) {}
}

document.addEventListener('DOMContentLoaded', function() {
    const chatBody     = document.getElementById('chat-body');
    const chatMessages = document.getElementById('chat-messages');
    const chatForm     = document.getElementById('chat-form');
    const messageInput = document.getElementById('chat-message');
    const fileInput    = document.getElementById('chat-file');
    const fileNameEl   = document.getElementById('file-name');
    const btnSend      = document.getElementById('btn-send');

    let lastChatIds = Array.from(document.querySelectorAll('.chat-item')).map(el => parseInt(el.getAttribute('data-id')));

    // Emoji
    try {
        if (typeof EmojiButton !== 'undefined') {
            const picker = new EmojiButton({ position: 'top', theme: 'dark' });
            const emojiBtn = document.getElementById('emoji-btn');
            if (emojiBtn) {
                picker.on('emoji', s => { messageInput.value += s.emoji; messageInput.focus(); });
                emojiBtn.addEventListener('click', () => picker.togglePicker(emojiBtn));
            }
        }
    } catch(e) {}

    function scrollBottom() { chatBody.scrollTop = chatBody.scrollHeight; }
    scrollBottom();

    function fmtTime(dateStr) {
        const d = new Date(dateStr);
        return d.getHours().toString().padStart(2,'0') + ':' + d.getMinutes().toString().padStart(2,'0');
    }

    function renderChat(chat, isSending = false) {
        const isMe = chat.sender_id === myId;
        const time = fmtTime(chat.created_at);
        const fileUrl = chat.file_path ? `{{ asset('storage/chats') }}/${chat.file_path}` : '';

        const fileHtml = (chat.file_path && !chat.is_deleted_for_everyone)
            ? `<div style="margin-bottom:6px;"><a href="${fileUrl}" target="_blank" style="color:${isMe ? 'rgba(255,255,255,0.8)' : 'var(--cyan)'};font-size:0.78rem;"><i class="bi bi-paperclip me-1"></i>Lihat Lampiran</a></div>`
            : '';

        const msgHtml = chat.message
            ? `<p style="margin:0;">${chat.is_deleted_for_everyone ? `<i>${chat.message}</i>` : chat.message}</p>`
            : '';

        const statusHtml = isMe
            ? (isSending
                ? `<i class="bi bi-clock ms-1"></i>`
                : `<i class="bi ${chat.is_read ? 'bi-check-all' : 'bi-check'} ms-1"></i>`)
            : '';

        if (isMe) {
            return `<div class="chat-item me" data-id="${chat.id}">
                <div class="dropdown">
                    <button class="chat-action-btn" type="button" data-bs-toggle="dropdown" style="width:22px;height:22px;font-size:0.75rem;">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item text-danger" href="#" onclick="deleteChat('${chat.id}','for_me',event)"><i class="bi bi-trash me-2"></i>Hapus untuk saya</a></li>
                        ${!chat.is_deleted_for_everyone && !isSending ? `<li><a class="dropdown-item text-danger" href="#" onclick="deleteChat('${chat.id}','for_everyone',event)"><i class="bi bi-trash-fill me-2"></i>Hapus untuk semua</a></li>` : ''}
                    </ul>
                </div>
                <div class="bubble-me">${fileHtml}${msgHtml}<div class="bubble-time">${time} ${statusHtml}</div></div>
            </div>`;
        } else {
            return `<div class="chat-item them" data-id="${chat.id}">
                <div class="bubble-them">${fileHtml}${msgHtml}<div class="bubble-time">${time}</div></div>
                <div class="dropdown">
                    <button class="chat-action-btn" type="button" data-bs-toggle="dropdown" style="width:22px;height:22px;font-size:0.75rem;">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item text-danger" href="#" onclick="deleteChat('${chat.id}','for_me',event)"><i class="bi bi-trash me-2"></i>Hapus dari perangkat saya</a></li>
                    </ul>
                </div>
            </div>`;
        }
    }

    if (chatForm) {
        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const msg = messageInput.value.trim();
            if (!msg && !fileInput.files.length) return;

            const formData = new FormData(this);
            btnSend.disabled = true;
            btnSend.innerHTML = '<span class="spinner-border spinner-border-sm" style="width:14px;height:14px;"></span>';

            const tempId = 'temp-' + Date.now();
            const tempChat = { id: tempId, sender_id: myId, message: msg, file_path: fileInput.files.length ? fileInput.files[0].name : null, created_at: new Date().toISOString(), is_read: false, is_deleted_for_everyone: false };

            const emptyMsg = document.getElementById('empty-msg');
            if (emptyMsg) emptyMsg.remove();

            chatMessages.insertAdjacentHTML('beforeend', renderChat(tempChat, true));
            scrollBottom();
            messageInput.value = '';
            fileInput.value = '';
            fileNameEl.textContent = '';

            fetch(this.action, { method: 'POST', body: formData, headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        const tempEl = document.querySelector(`.chat-item[data-id="${tempId}"]`);
                        if (tempEl) tempEl.outerHTML = renderChat(data.chat);
                        else chatMessages.insertAdjacentHTML('beforeend', renderChat(data.chat));
                        scrollBottom();
                        lastChatIds.push(data.chat.id);
                    }
                })
                .finally(() => {
                    btnSend.disabled = false;
                    btnSend.innerHTML = '<i class="bi bi-send-fill"></i>';
                });
        });

        function showToast(title) {
            document.getElementById('toastMessage').innerText = title;
            const toast = new bootstrap.Toast(document.getElementById('chatToast'), { delay: 4000 });
            toast.show();
            playPing();
        }

        // Poll every 3s
        setInterval(() => {
            fetch("{{ route('mahasiswa.chats.show', $partner->id) }}", {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (!data.chats) return;
                let hasNew = false, lastFromPartner = false;
                let newHtml = '';
                data.chats.forEach(chat => {
                    newHtml += renderChat(chat);
                    if (!lastChatIds.includes(chat.id)) {
                        hasNew = true;
                        if (chat.sender_id !== myId) lastFromPartner = true;
                        lastChatIds.push(chat.id);
                    }
                });
                if (hasNew) {
                    const isAtBottom = (chatBody.scrollTop + chatBody.clientHeight >= chatBody.scrollHeight - 10);
                    const scrollPos = chatBody.scrollTop;
                    const emptyMsg = document.getElementById('empty-msg');
                    if (emptyMsg) emptyMsg.remove();
                    const temps = Array.from(chatMessages.querySelectorAll('.chat-item[data-id^="temp-"]'));
                    chatMessages.innerHTML = newHtml;
                    temps.forEach(el => chatMessages.appendChild(el));
                    if (isAtBottom) scrollBottom(); else chatBody.scrollTop = scrollPos;
                    if (lastFromPartner) showToast("Pesan baru dari {{ $partner->name }}");
                }
            })
            .catch(() => {});
        }, 3000);
    }

    // Search
    const searchInput = document.getElementById('user-search-input');
    const searchDropdown = document.getElementById('search-results-dropdown');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const q = this.value.trim();
            if (q.length < 2) { searchDropdown.innerHTML = ''; searchDropdown.classList.remove('show'); return; }
            fetch(`/api/chats/search-users?query=${encodeURIComponent(q)}`)
                .then(r => r.json())
                .then(users => {
                    searchDropdown.innerHTML = '';
                    if (!users.length) {
                        searchDropdown.innerHTML = '<div style="padding:12px 14px;font-size:0.8rem;color:var(--text-3);text-align:center;">Tidak ada pengguna ditemukan</div>';
                    } else {
                        users.forEach(user => {
                            const av = user.profile_photo ? `<img src="/storage/profiles/${user.profile_photo}" alt="${user.name}">` : `<span>${user.name[0].toUpperCase()}</span>`;
                            const rc = {mahasiswa:'success',dosen:'primary',staff:'warning',admin:'danger'}[user.role] || 'muted';
                            searchDropdown.innerHTML += `<a href="/mahasiswa/chats/${user.id}" class="search-result-item"><div class="search-result-avatar">${av}</div><div style="flex:1;min-width:0;"><div style="font-weight:700;font-size:0.82rem;">${user.name}</div><div style="font-size:0.7rem;color:var(--text-3);">${user.nim||''}</div></div><span class="mhs-badge ${rc}" style="font-size:0.6rem;">${user.role}</span></a>`;
                        });
                    }
                    searchDropdown.classList.add('show');
                });
        });
        document.addEventListener('click', e => {
            if (!searchInput.contains(e.target) && !searchDropdown.contains(e.target)) searchDropdown.classList.remove('show');
        });
    }
});
</script>
@endsection
