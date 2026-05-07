<ul class="nav nav-pills flex-column mb-auto">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('sesprodi.dashboard') ? 'active' : '' }}"
            href="{{ route('sesprodi.dashboard') }}">
            <i class="bi bi-speedometer2 me-3 fs-5"></i> Dashboard
        </a>
    </li>
</ul>