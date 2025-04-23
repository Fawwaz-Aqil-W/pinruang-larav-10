<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">Si Pinjam</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" 
                       href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('rooms.*') ? 'active' : '' }}" 
                       href="{{ route('rooms.index') }}">Ruangan</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="peminjamanDropdown" 
                       data-bs-toggle="dropdown">Peminjaman</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('bookings.create') }}">Pinjam Ruangan</a></li>
                        <li><a class="dropdown-item" href="{{ route('bookings.status') }}">Status Peminjaman</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}" 
                       href="{{ route('profile') }}">Profile</a>
                </li>
            </ul>
        </div>
    </div>
</nav>