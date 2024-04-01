<nav class="navbar navbar-expand-lg fixed-top shadow">
    <div class="container-fluid" id="navbar-main">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a href="{{ route('admin.dashboard') }}" class="navbar-brand">Kendedes Cafe</a>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <button class="nav-link btn btn-primary offcanvas-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" aria-controls="offcanvas">menu</button>
                </li>
            </ul>
            
            <ul class="navbar-nav">
                <li class="nav-item">
                    <div class="nav-link dropdown">
                        <button class="dropdown-toggle btn btn-secondary" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->nama_user }}
                        </button>
                        <ul class="dropdown-menu">
                            @if (Auth::user()->level->nama_level == 'Admin')
                            <li><a href="{{ route('admin.dashboard') }}" class="dropdown-item">Dashboard</a></li>
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
            </ul>
        </div>
    </div>
</nav>

<div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvas" aria-labelledby="offcanvas">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvas-label">Admin Dashboard</h5>
        <button class="btn-close" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column">
        <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary mb-2">Pelanggan</a>
        <a href="{{ route('meja.index') }}" class="btn btn-secondary mb-2">Meja</a>
        <a href="{{ route('masakan.index') }}" class="btn btn-secondary mb-2">Masakan</a>
        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary mb-2">Transaksi</a>
        <a href="{{ route('laporan') }}" class="btn btn-secondary mb-2">Laporan</a>
    </div>
</div>