@extends('layouts.mahasiswa')

@section('title', 'Chat')

@push('styles')
<style>
.chat-layout {
    display: grid;
    grid-template-columns: 290px 1fr;
    gap: 0;
    height: calc(100vh - 130px);
    background: var(--card-glass-bg);
    backdrop-filter: blur(30px) saturate(160%);
    -webkit-backdrop-filter: blur(30px) saturate(160%);
    border: 1px solid var(--card-glass-border);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: 0 6px 24px rgba(0,0,0,0.08);
}

/* Contact List */
.chat-sidebar {
    display: flex;
    flex-direction: column;
    border-right: 1px solid var(--border);
    overflow: hidden;
    background: var(--surface-container-low);
}

.chat-sidebar-header {
    padding: 14px 14px 11px;
    border-bottom: 1px solid var(--border);
}

.chat-sidebar-title {
    font-family: var(--font-display);
    font-size: 0.88rem;
    font-weight: 700;
    color: var(--text-1);
    margin-bottom: 9px;
    display: flex;
    align-items: center;
    gap: 7px;
}

.chat-search-wrap { position: relative; }

.chat-search-input {
    width: 100%;
    padding: 7px 11px 7px 32px;
    background: var(--surface-container);
    border: 1px solid var(--border);
    border-radius: 18px;
    font-size: 0.81rem;
    color: var(--on-surface);
    font-family: var(--font);
    outline: none;
    transition: border-color 0.2s;
}

.chat-search-input::placeholder { color: var(--text-3); }
.chat-search-input:focus { border-color: var(--secondary); background: var(--surface-container-lowest); }

.chat-search-icon {
    position: absolute;
    left: 10px; top: 50%;
    transform: translateY(-50%);
    color: var(--text-3);
    font-size: 0.78rem;
    pointer-events: none;
}

.search-dropdown {
    position: absolute;
    left: 0; right: 0;
    top: calc(100% + 5px);
    background: var(--surface-container-lowest);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    z-index: 1050;
    max-height: 220px;
    overflow-y: auto;
    display: none;
}

.search-dropdown.show { display: block; }

.search-result-item {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 9px 12px;
    cursor: pointer;
    text-decoration: none;
    color: var(--on-surface);
    transition: background 0.14s;
    border-bottom: 1px solid var(--border);
}

.search-result-item:last-child { border-bottom: none; }
.search-result-item:hover { background: var(--info-light); }

.search-result-avatar {
    width: 29px; height: 29px;
    border-radius: 8px;
    background: var(--info-light);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.78rem; color: var(--secondary);
    font-weight: 700;
    flex-shrink: 0; overflow: hidden;
}

.search-result-avatar img { width: 100%; height: 100%; object-fit: cover; }

/* Contact Items */
.chat-contacts { flex: 1; overflow-y: auto; }

.chat-contact-item {
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 11px 14px;
    cursor: pointer;
    text-decoration: none;
    color: var(--on-surface);
    transition: background 0.14s;
    border-bottom: 1px solid var(--surface-container-high);
}

.chat-contact-item:hover { background: var(--info-light); }

.chat-contact-avatar {
    width: 40px; height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--secondary), #0070ea);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.95rem; color: #fff; font-weight: 700;
    flex-shrink: 0; overflow: hidden;
}

.chat-contact-avatar img { width: 100%; height: 100%; object-fit: cover; }

.chat-contact-info { flex: 1; min-width: 0; }
.chat-contact-name  { font-size: 0.83rem; font-weight: 700; margin-bottom: 2px; color: var(--on-surface); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.chat-contact-last  { font-size: 0.71rem; color: var(--text-3); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

.chat-contact-meta { text-align: right; flex-shrink: 0; }
.chat-contact-time  { font-size: 0.63rem; color: var(--text-3); margin-bottom: 3px; }
.chat-unread-badge  { background: var(--danger); color: #fff; font-size: 0.58rem; font-weight: 700; padding: 2px 6px; border-radius: 10px; }

/* Chat empty (right) */
.chat-empty-right {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    flex: 1;
    background: var(--surface-container-lowest);
    color: var(--text-3);
}

.chat-empty-right i { font-size: 3.2rem; margin-bottom: 12px; opacity: 0.35; }
.chat-empty-right p { font-size: 0.87rem; margin: 0; }
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
