<nav class="navbar navbar-expand-lg navbar-dark shadow-sm px-3"
     style="background-color: #5C3D2E;">

    <div class="container-fluid">

        <!-- Brand / Logo (DIKLIK UNTUK KEMBALI/KE PROFIL TOKO) -->
        <a class="navbar-brand fw-bold" href="{{ route('profiltoko') }}">
            Mini Bites Bakery 🍰
        </a>

        <!-- Tombol Toggle untuk Tampilan Mobile -->
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu Navbar -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <!-- Beranda -->
                <li class="nav-item">
                    <a
                        class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">
                        Beranda
                    </a>
                </li>

                <!-- Menu Akun (Hanya Admin) -->
                @if(auth()->check() && auth()->user()->role_id == 1)
                    <li class="nav-item">
                        <a
                            class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}"
                            href="{{ route('admin.users') }}">
                            Akun
                        </a>
                    </li>
                @endif

                <!-- Produk -->
                <li class="nav-item">
                    <a
                        class="nav-link {{ Request::is('produk') ? 'active' : '' }}"
                        href="{{ route('produk.index') }}">
                        Produk
                    </a>
                </li>

                <!-- Penjualan -->
                <li class="nav-item">
                    <a
                        class="nav-link {{ Request::is('penjualan') ? 'active' : '' }}"
                        href="{{ route('penjualan.index') }}">
                        Penjualan
                    </a>
                </li>

                <!-- Tentang Saya -->
                <li class="nav-item">
                    <a
                        class="nav-link {{ Request::is('tentang') ? 'active' : '' }}"
                        href="{{ route('tentang') }}">
                        Tentang Saya
                    </a>
                </li>

            </ul>

            <!-- Tombol Logout -->
            <form action="{{ route('logout') }}" method="POST" class="d-flex my-2 my-lg-0">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm px-3 fw-medium">
                    Keluar
                </button>
            </form>

        </div>
    </div>
</nav>