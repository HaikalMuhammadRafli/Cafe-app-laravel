<nav class="navbar navbar-expand-lg fixed-top shadow">
    <div class="container-fluid" id="navbar-main">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a href="{{ route('home') }}" class="navbar-brand">Kendedes Cafe</a>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('menu') }}" class="nav-link">Menu</a>
                </li>
            </ul>
            
            <ul class="navbar-nav">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary login-btn">Login</a>
                @else
                    <li class="nav-item">
                        <div class="nav-link dropdown">
                            <button class="dropdown-toggle btn btn-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->nama_user }}
                            </button>
                            <ul class="dropdown-menu">
                                @if (Auth::user()->level->nama_level == 'Admin')
                                <li><a href="{{ route('admin.dashboard') }}" class="dropdown-item">Dashboard</a></li>
                                <li class="dropdown-divider"></li>
                                @elseif (Auth::user()->level->nama_level == 'Kasir')
                                <li><a href="{{ route('kasir.dashboard') }}" class="dropdown-item">Dashboard</a></li>
                                <li class="dropdown-divider"></li>
                                @endif
                                <li><a href="{{ route('logout') }}" class="dropdown-item text-danger"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout</a></li>
                                <form action="{{ route('logout') }}" method="post" id="logout-form" class="d-none">
                                    @csrf
                                </form>
                            </ul>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>