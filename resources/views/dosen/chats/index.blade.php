@extends('layouts.app')

@section('title', 'Chat')

@section('content')
<div class="container-fluid px-0">
    <div class="row g-4">
        <!-- Kolom Kiri: Daftar Chat & Pencarian -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom border-light pt-4 pb-3 px-4">
                    <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-chat-dots text-primary me-2"></i> Obrolan</h6>
                    
                    <!-- Search input -->
                    <div class="position-relative">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" id="user-search-input" class="form-control bg-light border-start-0 ps-0" placeholder="Cari pengguna..." autocomplete="off">
                        </div>
                        <div id="search-results-dropdown" class="list-group position-absolute w-100 shadow-lg d-none" style="z-index: 1050; max-height: 250px; overflow-y: auto;">
                            <!-- Search results -->
                        </div>
                    </div>
                </div>
                <div class="card-body p-0" style="max-height: calc(100vh - 280px); overflow-y: auto;">
                    <div class="list-group list-group-flush border-0" id="contacts-list">
                        @forelse($recentContacts as $contact)
                            @php
                                $roleBadge = 'bg-secondary';
                                if ($contact->role === 'mahasiswa') $roleBadge = 'bg-success';
                                elseif ($contact->role === 'dosen') $roleBadge = 'bg-primary';
                                elseif ($contact->role === 'staff') $roleBadge = 'bg-warning text-dark';
                                elseif ($contact->role === 'admin') $roleBadge = 'bg-danger';
                            @endphp
                            <a href="{{ route('dosen.chats.show', $contact->id) }}" class="list-group-item list-group-item-action px-4 py-3 border-light d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center overflow-hidden me-2">
                                    @if($contact->profile_photo)
                                        <img src="{{ asset('storage/profiles/' . $contact->profile_photo) }}" class="rounded-circle me-3 border flex-shrink-0" width="45" height="45" style="object-fit: cover;">
                                    @else
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle me-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 45px; height: 45px;">
                                            <i class="bi bi-person-fill fs-5"></i>
                                        </div>
                                    @endif
                                    <div class="text-truncate">
                                        <div class="d-flex align-items-center mb-1">
                                            <h6 class="mb-0 fw-bold text-dark text-truncate me-2">{{ $contact->name }}</h6>
                                            <span class="badge {{ $roleBadge }} text-capitalize flex-shrink-0" style="font-size: 0.65rem;">{{ $contact->role }}</span>
                                        </div>
                                        <small class="text-muted text-truncate d-block">{{ $contact->latest_message }}</small>
                                    </div>
                                </div>
                                <div class="text-end flex-shrink-0 d-flex flex-column align-items-end justify-content-center">
                                    <small class="text-muted mb-1" style="font-size: 0.7rem;">{{ $contact->latest_message_time }}</small>
                                    <span class="badge bg-danger rounded-pill {{ $contact->unread_count > 0 ? '' : 'd-none' }}" style="font-size: 0.7rem;">{{ $contact->unread_count }}</span>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-5 text-muted small">Belum ada percakapan. Cari pengguna untuk memulai chat.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Kolom Kanan: Chat Kosong -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100 d-flex align-items-center justify-content-center bg-light" style="min-height: 400px;">
                <div class="text-center py-5">
                    <i class="bi bi-chat-square-text text-muted" style="font-size: 4rem;"></i>
                    <h5 class="mt-3 text-secondary">Pilih kontak untuk memulai chat</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById('user-search-input');
        const searchResults = document.getElementById('search-results-dropdown');

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();
                if (query.length < 2) {
                    searchResults.innerHTML = '';
                    searchResults.classList.add('d-none');
                    return;
                }

                fetch(`/api/chats/search-users?query=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(users => {
                        searchResults.innerHTML = '';
                        if (users.length === 0) {
                            searchResults.innerHTML = '<div class="list-group-item text-muted text-center py-2 small">Tidak ada pengguna ditemukan</div>';
                        } else {
                            users.forEach(user => {
                                let badgeColor = 'bg-secondary';
                                if (user.role === 'mahasiswa') badgeColor = 'bg-success';
                                else if (user.role === 'dosen') badgeColor = 'bg-primary';
                                else if (user.role === 'staff') badgeColor = 'bg-warning text-dark';
                                else if (user.role === 'admin') badgeColor = 'bg-danger';

                                let avatarHtml = '';
                                if (user.profile_photo) {
                                    avatarHtml = `<img src="/storage/profiles/${user.profile_photo}" class="rounded-circle me-2" width="30" height="30" style="object-fit: cover;">`;
                                } else {
                                    avatarHtml = `<div class="bg-primary bg-opacity-10 text-primary rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; font-size: 0.8rem;"><i class="bi bi-person-fill"></i></div>`;
                                }

                                const chatUrl = `/dosen/chats/${user.id}`;

                                searchResults.innerHTML += `
                                    <a href="${chatUrl}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between py-2 px-3">
                                        <div class="d-flex align-items-center overflow-hidden">
                                            ${avatarHtml}
                                            <div class="text-truncate">
                                                <div class="fw-bold small text-dark text-truncate">${user.name}</div>
                                                <div class="text-muted text-truncate" style="font-size: 0.75rem;">${user.nim || ''}</div>
                                            </div>
                                        </div>
                                        <span class="badge ${badgeColor} text-capitalize ms-2" style="font-size: 0.65rem;">${user.role}</span>
                                    </a>
                                `;
                            });
                        }
                        searchResults.classList.remove('d-none');
                    });
            });

            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                    searchResults.classList.add('d-none');
                }
            });
        }
    });
</script>
@endpush