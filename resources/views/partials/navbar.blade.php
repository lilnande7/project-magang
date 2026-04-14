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
                    <!-- <span class="dropdown-title">LAYANAN KAMI <i class="fas fa-chevron-down"></i></span> step 1-->
                    <div class="menu-item">
                        <span>LAYANAN KAMI</span>
                        <i class="fas fa-chevron-right arrow"></i>
                    </div>

                    
                    <ul class="dropdown">
                        <li><a href="/agenda">Agenda Kegiatan</a></li>
                        <li><a href="{{ route('news.index') }}">Berita</a></li>
                        <li><a href="{{ route('gallery') }}">Galeri</a></li>
                        
                        <li class="has-sub-dropdown">
                            <!-- <span class="dropdown-subtitle" tabindex="0">Layanan</span> step2 -->
                            <div class="menu-item sub">
                                <span>Layanan</span>
                                <i class="fas fa-chevron-right arrow"></i>
                            </div>
                            <ul class="sub-dropdown">
                                <li><a href="https://play.google.com/store/apps/details?id=com.eperpus.saas.ppic&pcampaignid=web_share">Avialib</a></li>
                                <li><a href="https://ppicurug.turnitin.com/home/sign-in?redirect_to=https:%2F%2Fppicurug.turnitin.com%2F">Turnitin</a></li>
                                <li><a href="https://journal.ppicurug.ac.id/index.php/jurnal-ilmiah-aviasi">Jurnal Langit Biru</a></li>
                                <li><a href="https://perpusnas.go.id/">Perpusnas</a></li>
                                <li><a href="https://repository.ppicurug.ac.id/">E-Repository</a></li>
                                <li><a href="https://repository.ppicurug.ac.id/">E-Resources</a></li> 
                            </ul>
                        </li>
                            <li class="has-sub-dropdown">
                                <!-- <span class="dropdown-subtitle" tabindex="0">E-Resources</span> -->
                                 <div class="menu-item sub">
                                    <span>E-Resources</span>
                                    <i class="fas fa-chevron-right arrow"></i>
                                </div>
                                <ul class="sub-dropdown">
                                    <li><a href="https://perpusnas.go.id/">Perpusnas</a></li>
                                </ul>
                            </li>

                            <li class="has-sub-dropdown">
                                <!-- <span class="dropdown-subtitle" tabindex="0">Referensi</span> -->
                                    <div class="menu-item sub">
                                        <span>Referensi</span>
                                        <i class="fas fa-chevron-right arrow"></i>
                                    </div>
                                    <ul class="sub-dropdown">
                                        <li><a href="https://www.instagram.com/avialib_ppicurug?igsh=Z244YjZudThzMDVq">Tanya Pustakawan</a></li>
                                    </ul>
                                </li>

                             <li><a href="https://forms.gle/a1cCkCu37kikXS95A">Silang Pinjam</a></li>
                                

                        
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
                
                  <li class="has-dropdown">
                    <!-- <span class="dropdown-title">LAYANAN KAMI <i class="fas fa-chevron-down"></i></span> step 1-->
                    <div class="menu-item">
                        <span>KERJASAMA</span>
                        <i class="fas fa-chevron-right arrow"></i>
                    </div>

                    <ul class="dropdown">
                        <li><a href="https://library.poltekbangplg.ac.id/">Poltekbang Palembang</a></li>
                        <li><a href="https://digilib.poltekbangsby.ac.id/">Poltekbang Surabaya</a></li>
                        <li><a href="https://icpa-banyuwangi.ac.id/perpustakaan">Api Banyuwangi</a></li>
                        <li><a href="https://poltekbangmakassar.ac.id/">Poltekbang Makasar</a></li>
                        <li><a href="https://perpustakaan.poltekbangjayapura.my.id/">Poltekbang Jayapura</a></li>
                        <li><a href="https://linktr.ee/perpustakaan.poltekbangmedan">Poltekbang Medan</a></li>
                        <li><a href="https://perpus.bp3curug.id/">Bp3 cururg</a></li>
                    </ul>
                </li>


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
