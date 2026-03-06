{{-- ===== SEARCH & DISCOVERY SECTION ===== --}}
<section class="search-section" id="searchSection">
    <div class="search-grid">
        <div class="search-content" data-animate="fadeInLeft">
            <span class="section-label">Pencarian Koleksi</span>
            <h2>Temukan referensi terbaik dalam hitungan detik</h2>
            <p>Lebih dari {{ number_format($stats['total_books'] ?? 0) }} buku, jurnal, dan repository dapat kamu jelajahi secara daring.</p>
            <ul class="search-highlights">
                <li><i class="fas fa-bolt"></i> Pencarian lintas judul, penulis, dan kata kunci</li>
                <li><i class="fas fa-cloud"></i> Koleksi digital tersedia 24/7</li>
                <li><i class="fas fa-headset"></i> Bantuan pustakawan secara real-time</li>
            </ul>
        </div>
        <div class="search-form-wrapper" data-animate="fadeInRight">
            <form action="https://digilib.ppicurug.ac.id" method="GET" class="search-form" target="_blank">
                <label>Cari katalog</label>
                <div class="search-input-group">
                    <i class="fas fa-search"></i>
                    <input type="text" name="q" placeholder="Masukkan judul, penulis, atau kata kunci...">
                </div>
                <button type="submit" class="btn-search">Mulai Telusuri</button>
            </form>
        </div>
    </div>
</section>