{{-- PARTIAL: KOMUNIKASI --}}
@php
    use App\Helpers\PermissionHelper;
    $role    = auth()->user()?->role ?? 'guest';
    $isAdmin = $role === 'admin';
    $hasRoute = fn($name) => \Illuminate\Support\Facades\Route::has($name);
    $prefix  = match($role) {
        'admin'    => 'admin',
        'staff'    => 'staff',
        'dosen'    => 'dosen',
        'mahasiswa'=> 'mahasiswa',
        'sesprodi' => 'sesprodi',
        'kaprodi'  => 'kaprodi',
        default    => 'mahasiswa',
    };
@endphp

@sidebar_can('komunikasi')
<div class="sidebar-section">
    <button class="sidebar-group-toggle {{ request()->routeIs([
        '*.chats.*', '*.announcements.*'
    ]) ? 'open' : '' }}" data-target="group-komunikasi" aria-label="Toggle Komunikasi">
        <span class="sidebar-icon"><i class="bi bi-chat-square-dots"></i></span>
        <span class="sidebar-label">Komunikasi</span>
        <span class="sidebar-chevron"><i class="bi bi-chevron-right"></i></span>
    </button>
    <div class="sidebar-submenu" id="group-komunikasi">

        {{-- Chat --}}
        @if(PermissionHelper::can('chats', 'create') || $isAdmin)
            @php
                $chatRoute = match($role) {
                    'admin'    => $hasRoute('staff.chats.index')     ? 'staff.chats.index'     : null,
                    'staff'    => $hasRoute('staff.chats.index')     ? 'staff.chats.index'     : null,
                    'dosen'    => $hasRoute('dosen.chats.index')     ? 'dosen.chats.index'     : null,
                    'mahasiswa'=> $hasRoute('mahasiswa.chats.index') ? 'mahasiswa.chats.index' : null,
                    default    => null,
                };
            @endphp
            @if($chatRoute)
                @php
                    $unreadChatsCount = \App\Models\Chat::where('receiver_id', auth()->id())
                        ->where('is_read', false)
                        ->where('deleted_by_receiver', false)
                        ->count();
                @endphp
                <a class="sidebar-sublink {{ request()->routeIs('*.chats.*') ? 'active' : '' }}"
                   href="{{ route($chatRoute) }}">
                    <i class="bi bi-chat-dots"></i> Chat
                    <span class="badge bg-danger ms-auto rounded-pill {{ $unreadChatsCount > 0 ? '' : 'd-none' }}" id="sidebar-unread-chat-count">
                        {{ $unreadChatsCount }}
                    </span>
                </a>
            @endif
        @endif

        {{-- Pengumuman --}}
        @if(PermissionHelper::can('announcements', 'view_all') || $isAdmin)
            @if($hasRoute('staff.announcements.index'))
                <a class="sidebar-sublink {{ request()->routeIs('staff.announcements.*') ? 'active' : '' }}"
                   href="{{ route('staff.announcements.index') }}">
                    <i class="bi bi-megaphone"></i> Pengumuman
                </a>
            @endif
        @endif

    </div>
</div>
@endsidebar_can
