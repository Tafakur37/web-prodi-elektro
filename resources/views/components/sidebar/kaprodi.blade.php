<ul class="nav nav-pills flex-column mb-auto">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('kaprodi.dashboard') ? 'active' : '' }}" href="{{ route('kaprodi.dashboard') }}">
            <i class="bi bi-speedometer2 me-3 fs-5"></i> Dashboard
        </a>
    </li>
</ul>
