{{-- Header with top bar & navbar --}}
<header class="site-header">

    {{-- Top Information Bar --}}
    <div class="top-bar">
        <div class="top-bar-container">
            <div class="top-info">
                <span><i class="fas fa-phone"></i> (021) 5982204</span>
                <span><i class="fas fa-envelope"></i> ppi@ppicurug.ac.id</span>
                <span><i class="far fa-clock"></i> Sen - Jum 08:00 - 17:00</span>
                <span><i class="fas fa-id-badge"></i> NPP. 3173052D2014743</span>
            </div>
            <div class="top-actions">
                <a href="https://instagram.com" target="_blank" rel="noopener" aria-label="Instagram" class="top-social">
                    <i class="fab fa-instagram"></i>
                </a>
                @guest
                    <a href="{{ route('login') }}" class="btn-top-login"><i class="fas fa-sign-in-alt"></i> Login</a>
                @else
                    <span class="top-user"><i class="fas fa-user-circle"></i> {{ Auth::user()->name }}</span>
                @endguest
            </div>
        </div>
    </div>

    {{-- Navbar Component - Transparent to solid on scroll --}}
    <nav class="navbar" id="mainNavbar">
        <div class="navbar-container">

            <div class="navbar-logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo.svg') }}" alt="Logo Perpustakaan">
                </a>
            </div>

            {{-- Hamburger for mobile --}}
            <button class="navbar-toggle" id="navToggle" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <ul class="navbar-menu" id="navMenu">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">HOME</a></li>
                <li><a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">PROFILE</a></li>

                <li class="has-dropdown">
                    <span class="dropdown-title">LAYANAN KAMI <i class="fas fa-chevron-down"></i></span>
                    <ul class="dropdown">
                        <li><a href="/agenda">Agenda Kegiatan</a></li>
                        <li><a href="{{ route('news.index') }}">Berita</a></li>
                        <li><a href="/galeri">Galeri</a></li>
                        <li><a href="{{ route('services') }}">Layanan</a></li>
                        <li><a href="/pengumuman">Pengumuman</a></li>
                    </ul>
                </li>

                <li><a href="{{ route('contact') }}">HUBUNGI KAMI</a></li>
                <li>
                    <a href="https://digilib.ppicurug.ac.id"
                        target="_blank"
                        rel="noopener noreferrer">
                        OPAC
                    </a>
                </li>
                <li><a href="/eresource">E-RESOURCE</a></li>
                <li><a href="/kerjasama">KERJASAMA</a></li>

                {{-- Authentication Menu --}}
                @auth
                    <li class="has-dropdown">
                        <span class="dropdown-title"><i class="fas fa-user-circle"></i> {{ Auth::user()->name }}</span>
                        <ul class="dropdown">
                            @if(Auth::user()->hasRole(['super-admin', 'admin']))
                                <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard Admin</a></li>
                            @endif
                            <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                        </ul>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endauth
            </ul>

        </div>
    </nav>

</header>
