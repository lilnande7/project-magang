@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/hubungikami.css') }}">
@endsection

@section('content')

<section class="page-hero" style="background-image: url('/images/perpuslabbahasa.png');">
    <div class="page-hero-content">
        <h1>Hubungi Kami</h1>
        <p>
            Ayo Hubungi Kami, 
                <br>"Perpustakaan menyediakan layanan pengaduan melalui fitur Hubungi Kami pada website serta media sosial resmi perpustakaan."
        </p>
    </div>
</section>

<section class="contact-section">
    <div class="contact-card">

        <!-- KIRI : GAMBAR -->
        <div class="contact-image">
            <div class="image-inner">
                <img src="{{ asset('images/sunho.png') }}" alt="Hubungi Kami">
            </div>
        </div>

        <!-- KANAN : FORM -->
        <div class="contact-form">
            <h2 class="section-title">Hubungi Kami</h2>
            <p class="form-desc">
                Silakan tinggalkan pesan, kami akan menghubungi Anda.
            </p>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('contact.submit') }}">
                @csrf
                <div class="form-group">
                    <label for="contact-name">Nama Lengkap</label>
                    <input id="contact-name" type="text" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap" required>
                </div>

                <div class="form-group">
                    <label for="contact-email">Email</label>
                    <input id="contact-email" type="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
                </div>

                <div class="form-group">
                    <label for="contact-message">Pesan</label>
                    <textarea id="contact-message" name="message" rows="4" placeholder="Pesan" required>{{ old('message') }}</textarea>
                </div>

                <button type="submit" class="btn-primary">Kirim Pesan</button>
            </form>
        </div>

    </div>
</section>

<section class="cta-section" data-animate="fadeInUp">
    <div class="cta-card">
        <div>
            <span class="section-label">Apakah anda memiliki pertanyaan?</span>
            <h2>Tim pustakawan siap menjawab semua pertanyaan untukmu.</h2>
            <p>Layanan pertanyaan, konsultasi literasi, atau dukungan event akademik hanya dalam beberapa klik.</p>
        </div>
        <div class="cta-actions">
            <a href="https://www.instagram.com/avialib_ppicurug?igsh=Z244YjZudThzMDVq" class="btn-hero-primary">Referensi </a>
            
        </div>
    </div>
</section>


<section class="location-section">

    <div class="loc-container">

        <div class="loc-header">
            <span>📍 Temukan Kami</span>
            <h2>Lokasi Perpustakaan</h2>
            <p>Kunjungi perpustakaan kami untuk mendapatkan berbagai layanan dan koleksi terbaik.</p>
        </div>

        <div class="loc-grid">

            <!-- Informasi -->
            <div class="loc-card">

                <div class="info-item">
                    <h3>Alamat</h3>

                    <p>
                        Perpustakaan Politeknik Penerbangan Indonesia Curug<br>
                        Raya PLP Curug, Kompleks Bandara Budiarto<br>
                        Serdang Wetan, Kecamatan Legok<br>
                        Tangerang - Banten
                    </p>
                </div>

                <div class="info-item">
                    <h3>Jam Operasional</h3>

                    <p>
                        Senin - Jumat<br>
                        08.00 - 17.00
                    </p>

                    <span class="closed">
                        Sabtu & Minggu : Tutup
                    </span>
                </div>

            </div>

            <!-- Maps -->
            <div class="loc-map">

                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.8111178941813!2d106.56656557429756!3d-6.288540393700426!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69fd3d394e926d%3A0x66d3f7d6385c47f2!2sPerpustakaan%20Sekolah%20Tinggi%20Penerbangan%20Indonesia!5e0!3m2!1sid!2sid!4v1769817099757!5m2!1sid!2sid"
                    loading="lazy"
                    allowfullscreen=""
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>

            </div>

        </div>

    </div>

</section>

@endsection