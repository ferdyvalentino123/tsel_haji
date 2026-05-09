<nav class="top-navbar">
    <div>
        <button class="hamburger-btn js-sidebar-toggle">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <div class="dropdown">
        <a href="#" class="nav-user dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            @if(Auth::user()->photo)
                <img src="{{ asset('?' . Auth::user()->photo) }}" alt="Profile" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
            @else
                <i class="fas fa-user-circle fa-lg text-secondary"></i> 
            @endif
            <span class="d-none d-sm-inline-block">{{ auth()->user()->name }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
            @php
                $profileRoute = '#';
                if (Auth::user()->role === 'admin') {
                    $profileRoute = route('admin.users.edit', Auth::user()->id);
                } elseif (Auth::user()->role === 'pelanggan') {
                    $profileRoute = route('pelanggan.profil');
                } elseif (in_array(Auth::user()->role, ['sales', 'supervisor', 'kasir'])) {
                    $profileRoute = route('role_users.edit');
                }
            @endphp
            <li>
                <a class="dropdown-item py-2" href="{{ $profileRoute }}">
                    <i class="fas fa-user me-2 text-muted"></i> Profil
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}" class="m-0" id="logout-form">
                    @csrf
                    <button type="submit" class="dropdown-item py-2 text-danger">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>
