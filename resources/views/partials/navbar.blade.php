{{-- Header with top bar & navbar using Bootsnav --}}
<header class="site-header">

    {{-- Top Information Bar --}}
    @if (request()->routeIs('home'))
        <div class="top-bar">
            <div class="top-bar-container">
                <div class="top-info">
                    <span><i class="fas fa-phone"></i> (021) 5982204</span>
                    <span><i class="fas fa-envelope"></i> ppi@ppicurug.ac.id</span>
                    <span><i class="far fa-clock"></i> Sen - Jum 08:00 - 17:00</span>
                    <span><i class="fas fa-id-badge"></i> NPP. 3603202C0000001</span>
                </div>
                <div class="top-actions">
                    <a href="https://instagram.com/avialib_ppicurug" target="_blank" rel="noopener" aria-label="Instagram" class="top-social">
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
    @endif

    {{-- Bootsnav Navbar --}}
    <nav class="navbar bootsnav navbar-default navbar-fixed" role="navigation" data-in="fadeIn" data-out="fadeOut">
        <div class="navbar-header">
            {{-- Navbar Logo --}}
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.svg') }}" alt="Logo Perpustakaan" class="navbar-logo-img">
            </a>
        </div>

        {{-- Navbar Menu --}}
        <div id="navbar" class="navbar-collapse collapse" data-dropdown-in="fadeIn" data-dropdown-animation-speed="1000">
            <ul class="nav navbar-nav navbar-right">
                <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}">HOME</a>
                </li>
                
               <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        PROFILE <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('profile.sejarah') }}">Sejarah</a></li>
                        <li><a href="{{ route('profile.struktur-organisasi') }}">Struktur Organisasi</a></li>
                        <li><a href="{{ route('profile.visi-misi') }}">Visi Misi</a></li>
                        <li><a href="{{ route('profile.tata-tertib') }}">Tata Tertib</a></li>
                        <li><a href="{{ route('profile.akreditasi') }}">Akreditasi</a></li>
                        <li><a href="{{ route('profile.npp') }}">Nomor Pokok Perpustakaan</a></li>
                        <li><a href="{{ route('contact.index') }}">Kontak</a></li>
                    </ul>
                </li>

                {{-- Layanan Kami Dropdown (Megamenu) --}}
                <li class="dropdown megamenu-fw">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        LAYANAN KAMI <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu megamenu-content" role="menu">
                        <li>
                            <div class="row">
                                <div class="col-md-3 col-menu">
                                    <h4 class="title">E-Resource</h4>
                                    <div class="content">
                                        <ul class="menu-col">
                                            <li><a href="https://repository.ppicurug.ac.id/">E-Repository</a></li>
                                            <li><a href="https://perpusnas.go.id/">Perpusnas</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-3 col-menu">
                                    <h4 class="title">Sarana Informasi</h4>
                                    <div class="content">
                                        <ul class="menu-col">
                                            <li><a href="/agenda">Agenda Kegiatan</a></li>
                                            <li><a href="/berita">Berita</a></li>
                                            <li><a href="/galeri0">Galeri</a></li>
                                            <li><a href="/pengumuman">Pengumuman</a></li>
                                            
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-3 col-menu">
                                    <h4 class="title">Layanan</h4>
                                    <div class="content">
                                        <ul class="menu-col">
                                            <li><a href="https://play.google.com/store/apps/details?id=com.eperpus.saas.ppic&pcampaignid=web_share">Avialib</a></li>
                                            <li><a href="https://ppicurug.turnitin.com/home/sign-in?redirect_to=https:%2F%2Fppicurug.turnitin.com%2F">Turnitin</a></li>
                                            <li><a href="https://journal.ppicurug.ac.id/index.php/jurnal-ilmiah-aviasi">Jurnal Langit Biru</a></li>
                                            <li><a href="https://docs.google.com/forms/d/e/1FAIpQLSfUNYZrOHjb1lIDvNJcz7gm3jBi7kXnpBGcu0c7KOqSthTHRw/viewform">Silang Pinjam</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>

                <li class="{{ request()->routeIs('contact.index') ? 'active' : '' }}">
                    <a href="{{ route('contact.index') }}">HUBUNGI KAMI</a>
                </li>

                @auth
                    @if(Auth::user()->hasRole(['super-admin', 'admin', 'librarian']))
                    <li class="{{ request()->routeIs('statistik.*') ? 'active' : '' }}">
                        <a href="{{ route('statistik.index') }}" title="Statistik & Analitik Big Data Perpustakaan">
                            <i class="fas fa-chart-bar" style="margin-right:4px"></i>STATISTIK
                        </a>
                    </li>
                    @endif
                @endauth

                <li>
                    <a href="https://digilib.ppicurug.ac.id" target="_blank" rel="noopener noreferrer">
                        OPAC
                    </a>
                </li>

                {{-- Kerjasama Dropdown --}}
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        KERJASAMA <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="https://library.poltekbangplg.ac.id/">Poltekbang Palembang</a></li>
                        <li><a href="https://digilib.poltekbangsby.ac.id/">Poltekbang Surabaya</a></li>
                        <li><a href="https://icpa-banyuwangi.ac.id/perpustakaan">Api Banyuwangi</a></li>
                        <li><a href="https://poltekbangmakassar.ac.id/">Poltekbang Makasar</a></li>
                        <li><a href="https://perpustakaan.poltekbangjayapura.my.id/">Poltekbang Jayapura</a></li>
                        <li><a href="https://linktr.ee/perpustakaan.poltekbangmedan">Poltekbang Medan</a></li>
                        <li><a href="https://perpus.bp3curug.id/">Bp3 Curug</a></li>
                    </ul>
                </li>

                {{-- Authentication Dropdown --}}
                @auth
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user-circle"></i> {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            @if(Auth::user()->hasRole(['super-admin', 'admin']))
                                <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard Admin</a></li>
                            @endif
                            <li>
                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                            </li>
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
