<section class="contact-section">
    <div class="contact-card">

        <!-- KIRI : GAMBAR -->
        <div class="contact-image">
            <div class="image-inner">
                <img src="<?= base_url('assets/img/sunho.png') ?>" alt="Hubungi Kami">
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