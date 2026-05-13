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
        '*.chats.*', '*.announcements.*', '*.submissions.*',
        '*.documents.*', '*.berkas.*'
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
                <a class="sidebar-sublink {{ request()->routeIs('*.chats.*') ? 'active' : '' }}"
                   href="{{ route($chatRoute) }}">
                    <i class="bi bi-chat-dots"></i> Chat
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

        {{-- Surat --}}
        @if(PermissionHelper::can('documents', 'create') || PermissionHelper::can('documents', 'view_own') || $isAdmin)
            @php
                $suratRoute = match($role) {
                    'admin'    => $hasRoute('admin.documents.index')        ? 'admin.documents.index'        : null,
                    'staff'    => $hasRoute('staff.documents.index')        ? 'staff.documents.index'        : null,
                    'mahasiswa'=> $hasRoute('mahasiswa.submissions.index')  ? 'mahasiswa.submissions.index'  : null,
                    default    => null,
                };
            @endphp
            @if($suratRoute)
                <a class="sidebar-sublink {{ request()->routeIs('*.documents.*') || request()->routeIs('*.submissions.*') ? 'active' : '' }}"
                   href="{{ route($suratRoute) }}">
                    <i class="bi bi-envelope-paper"></i> Surat
                </a>
            @endif
        @endif

        {{-- Berkas (File Explorer) --}}
        @if(PermissionHelper::can('berkas', 'view_own') || PermissionHelper::can('berkas', 'view_all') || $isAdmin)
            @php $berkasRoute = "{$prefix}.berkas.index"; @endphp
            @if($hasRoute($berkasRoute))
                <a class="sidebar-sublink {{ request()->routeIs('*.berkas.*') ? 'active' : '' }}"
                   href="{{ route($berkasRoute) }}">
                    <i class="bi bi-folder2-open"></i> Berkas
                </a>
            @endif
        @endif

    </div>
</div>
@endsidebar_can
