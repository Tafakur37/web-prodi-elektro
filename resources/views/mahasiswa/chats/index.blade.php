@extends('layouts.mahasiswa')

@section('title', 'Chat')

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

/* Contact Items */
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

.chat-contact-avatar {
    width: 42px; height: 42px;
    border-radius: 14px;
    background: linear-gradient(135deg, var(--primary), var(--cyan));
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem; color: #fff; font-weight: 700;
    flex-shrink: 0; overflow: hidden;
    position: relative;
}

.chat-contact-avatar img { width: 100%; height: 100%; object-fit: cover; }

.chat-contact-info { flex: 1; min-width: 0; }
.chat-contact-name  { font-size: 0.84rem; font-weight: 700; margin-bottom: 2px; color: var(--text-1); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.chat-contact-last  { font-size: 0.72rem; color: var(--text-3); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

.chat-contact-meta { text-align: right; flex-shrink: 0; }
.chat-contact-time  { font-size: 0.65rem; color: var(--text-3); margin-bottom: 4px; }
.chat-unread-badge  { background: var(--danger); color: #fff; font-size: 0.6rem; font-weight: 700; padding: 2px 6px; border-radius: 10px; }

/* Chat empty (right) */
.chat-empty-right {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    flex: 1;
    background: rgba(0,0,0,0.1);
    color: var(--text-3);
}

.chat-empty-right i { font-size: 3.5rem; margin-bottom: 14px; }
.chat-empty-right p { font-size: 0.88rem; margin: 0; }
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
                <div id="search-results-dropdown" class="search-dropdown">
                    <!-- Search results injected -->
                </div>
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
            <a href="{{ route('mahasiswa.chats.show', $contact->id) }}" class="chat-contact-item">
                <div class="chat-contact-avatar">
                    @if($contact->profile_photo)
                        <img src="{{ asset('storage/profiles/' . $contact->profile_photo) }}" alt="{{ $contact->name }}">
                    @else
                        {{ strtoupper(substr($contact->name, 0, 1)) }}
                    @endif
                </div>
                <div class="chat-contact-info">
                    <div style="display:flex;align-items:center;gap:6px;margin-bottom:2px;">
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
                Belum ada percakapan.<br>Cari pengguna untuk memulai chat.
            </div>
            @endforelse
        </div>
    </div>

    {{-- CHAT EMPTY STATE --}}
    <div class="chat-empty-right">
        <i class="bi bi-chat-square-dots"></i>
        <p>Pilih kontak untuk memulai percakapan</p>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('user-search-input');
    const searchDropdown = document.getElementById('search-results-dropdown');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            if (query.length < 2) {
                searchDropdown.innerHTML = '';
                searchDropdown.classList.remove('show');
                return;
            }

            fetch(`/api/chats/search-users?query=${encodeURIComponent(query)}`)
                .then(r => r.json())
                .then(users => {
                    searchDropdown.innerHTML = '';
                    if (users.length === 0) {
                        searchDropdown.innerHTML = '<div style="padding:12px 14px;font-size:0.8rem;color:var(--text-3);text-align:center;">Tidak ada pengguna ditemukan</div>';
                    } else {
                        users.forEach(user => {
                            const avatarHtml = user.profile_photo
                                ? `<img src="/storage/profiles/${user.profile_photo}" alt="${user.name}">`
                                : `<span>${user.name[0].toUpperCase()}</span>`;

                            const roleCls = {mahasiswa:'success',dosen:'primary',staff:'warning',admin:'danger'}[user.role] || 'muted';

                            searchDropdown.innerHTML += `
                                <a href="/mahasiswa/chats/${user.id}" class="search-result-item">
                                    <div class="search-result-avatar">${avatarHtml}</div>
                                    <div style="flex:1;min-width:0;">
                                        <div style="font-weight:700;font-size:0.82rem;">${user.name}</div>
                                        <div style="font-size:0.7rem;color:var(--text-3);">${user.nim || ''}</div>
                                    </div>
                                    <span class="mhs-badge ${roleCls}" style="font-size:0.6rem;">${user.role}</span>
                                </a>
                            `;
                        });
                    }
                    searchDropdown.classList.add('show');
                })
                .catch(() => {});
        });

        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchDropdown.contains(e.target)) {
                searchDropdown.classList.remove('show');
            }
        });
    }
});
</script>
@endpush

@endsection
