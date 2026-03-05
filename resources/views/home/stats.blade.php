{{-- ===== STATISTICS SECTION ===== --}}
<section class="stats-section">
    <div class="stats-grid">
        <div class="stat-card" data-animate="fadeInUp" data-delay="0">
            <div class="stat-icon"><i class="fas fa-books"></i></div>
            <h3 class="stat-number" data-count="{{ $stats['total_books'] ?? 0 }}">0</h3>
            <p>Total Koleksi Buku</p>
        </div>
        <div class="stat-card" data-animate="fadeInUp" data-delay="150">
            <div class="stat-icon"><i class="fas fa-book-open"></i></div>
            <h3 class="stat-number" data-count="{{ $stats['available_books'] ?? 0 }}">0</h3>
            <p>Buku Tersedia</p>
        </div>
        <div class="stat-card" data-animate="fadeInUp" data-delay="300">
            <div class="stat-icon"><i class="fas fa-tags"></i></div>
            <h3 class="stat-number" data-count="{{ $stats['total_categories'] ?? 0 }}">0</h3>
            <p>Kategori Buku</p>
        </div>
        <div class="stat-card" data-animate="fadeInUp" data-delay="450">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <h3 class="stat-number" data-count="{{ $stats['total_members'] ?? 0 }}">0</h3>
            <p>Anggota Aktif</p>
        </div>
    </div>
</section>
