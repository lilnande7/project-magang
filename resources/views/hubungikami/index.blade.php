@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/hubungikami.css') }}">
@endsection

@section('content')

<section class="hubungikami-hero">
    <div class="hubungikami-hero-overlay"></div>

    <div class="hubungikami-hero-content">
        <h1>Hubungi Kami</h1>
        <p>
            Ayo Hubungi Kami,
            dan <br>sumber pengetahuan untuk mendukung kegiatan akademik.
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
            <h2>Hubungi Kami</h2>
            <p class="form-desc">
                Silakan tinggalkan pesan, kami akan menghubungi Anda.
            </p>

            <form>
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" placeholder="Nama Lengkap">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" placeholder="Email">
                </div>

                <div class="form-group">
                    <label>Pesan</label>
                    <textarea rows="4" placeholder="Pesan"></textarea>
                </div>

                <button class="btn-primary">Kirim Pesan</button>
            </form>
        </div>

    </div>
</section>

<section class="location-section">
    <div class="location-grid">

        <!-- KIRI : INFO -->
        <div class="contact-info">
            <h3>Informasi Lokasi</h3>

            <div class="info-block">
                <strong>Alamat</strong>
                <p>
                    Perpustakaan Politeknik Penerbangan Indonesia Curug<br>
                    Raya PLP Curug, Kompleks Bandara Budiarto<br>
                    Serdang Wetan, Kecamatan Legok<br>
                    Tangerang – Banten
                </p>
            </div>

            <div class="info-block">
                <strong>Jam Operasional</strong>
                <p>
                    Senin – Jumat<br>
                    08.00 – 16.00<br>
                    <span class="closed">Sabtu & Minggu: Libur</span>
                </p>
            </div>
        </div>

        <!-- KANAN : MAP -->
        <div class="map-wrap">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.8111178941813!2d106.56656557429756!3d-6.288540393700426!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69fd3d394e926d%3A0x66d3f7d6385c47f2!2sPerpustakaan%20Sekolah%20Tinggi%20Penerbangan%20Indonesia!5e0!3m2!1sid!2sid!4v1769817099757!5m2!1sid!2sid"
                loading="lazy">
            </iframe>
        </div>

    </div>
</section>

@endsection