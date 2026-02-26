{{-- Navbar Component for Laravel Blade --}}
<nav class="navbar">
    <div class="navbar-container">

        <div class="navbar-logo">
            <img src="{{ asset('images/logo.svg') }}" alt="Logo Perpustakaan">
        </div>

        <ul class="navbar-menu">
            <li><a href="{{ route('home') }}">HOME</a></li>
            <li><a href="{{ route('profile') }}">PROFILE</a></li>

            <li class="has-dropdown">
                <span class="dropdown-title">LAYANAN KAMI</span>
                <ul class="dropdown">
                    <li><a href="/agenda">Agenda Kegiatan</a></li>
                    <li><a href="/berita">Berita</a></li>
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
                    <span class="dropdown-title">{{ Auth::user()->name }}</span>
                    <ul class="dropdown">
                        @if(Auth::user()->hasRole(['super-admin', 'admin']))
                            <li><a href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
                        @endif
                        <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                    </ul>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <li><a href="{{ route('login') }}" style="background: #007bff; color: white; padding: 8px 16px; border-radius: 5px;">LOGIN</a></li>
            @endauth
        </ul>

    </div>
</nav>