@extends('layouts.app')

@section('css')
<style>
/* ═══════════════════════════════════════════
   STATISTIK PAGE — Big Data Analytics View
   ═══════════════════════════════════════════ */

/* ── Hero Banner ──────────────────────────── */
.stat-hero {
    background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f2942 100%);
    position: relative;
    padding: 90px 0 60px;
    overflow: hidden;
}
.stat-hero::before {
    content: '';
    position: absolute; inset: 0;
    background:
        radial-gradient(circle at 20% 50%, rgba(59,130,246,.18) 0%, transparent 55%),
        radial-gradient(circle at 80% 20%, rgba(139,92,246,.15) 0%, transparent 50%);
}
.stat-hero-grid {
    position: absolute; inset: 0; opacity: .04;
    background-image: linear-gradient(rgba(255,255,255,.6) 1px, transparent 1px),
                      linear-gradient(90deg, rgba(255,255,255,.6) 1px, transparent 1px);
    background-size: 40px 40px;
}
.stat-hero-content { position: relative; z-index: 1; text-align: center; }
.stat-hero-badge {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(59,130,246,.2); border: 1px solid rgba(59,130,246,.4);
    color: #93c5fd; font-size: 12px; font-weight: 600; letter-spacing: 1.5px;
    text-transform: uppercase; padding: 6px 16px; border-radius: 20px;
    margin-bottom: 18px;
}
.stat-hero h1 {
    font-family: 'Playfair Display', serif; font-size: 48px; font-weight: 700;
    color: #fff; margin: 0 0 14px; line-height: 1.2;
}
.stat-hero h1 span { color: #60a5fa; }
.stat-hero p {
    color: rgba(255,255,255,.7); font-size: 16px; max-width: 560px; margin: 0 auto 28px;
    line-height: 1.7;
}
.stat-hero-meta {
    display: flex; align-items: center; justify-content: center; gap: 24px;
    flex-wrap: wrap;
}
.stat-hero-meta span {
    color: rgba(255,255,255,.5); font-size: 13px;
    display: flex; align-items: center; gap: 6px;
}
.stat-hero-meta .dot { width: 6px; height: 6px; border-radius: 50%; background: #22c55e; display: inline-block; animation: pulse-dot 2s infinite; }
@keyframes pulse-dot { 0%,100%{opacity:1} 50%{opacity:.4} }

/* ── Floating Particles ───────────────────── */
.stat-particle {
    position: absolute; border-radius: 50%;
    animation: float-particle linear infinite;
    pointer-events: none;
}
@keyframes float-particle {
    0%   { transform: translateY(100%) rotate(0deg);   opacity: 0; }
    10%  { opacity: 1; }
    90%  { opacity: 1; }
    100% { transform: translateY(-20px) rotate(720deg); opacity: 0; }
}

/* ── Page Wrapper ─────────────────────────── */
.stat-page {
    background: #f8fafc;
    padding-bottom: 80px;
}

/* ── Section Titles ───────────────────────── */
.stat-section-title {
    display: flex; align-items: center; gap: 12px;
    margin: 50px 0 28px;
}
.stat-section-title .icon-wrap {
    width: 42px; height: 42px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0;
}
.stat-section-title h2 {
    font-family: 'Playfair Display', serif; font-size: 24px; font-weight: 700;
    color: #0f172a; margin: 0 0 2px;
}
.stat-section-title p { color: #64748b; font-size: 13px; margin: 0; }

/* ── Summary Cards ────────────────────────── */
.summary-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-top: 32px;
}
@media(max-width:992px){ .summary-grid{ grid-template-columns: repeat(2,1fr); } }
@media(max-width:576px){ .summary-grid{ grid-template-columns: 1fr; } }

.summary-card {
    background: #fff;
    border-radius: 16px;
    padding: 24px 22px;
    box-shadow: 0 2px 12px rgba(0,0,0,.06);
    border: 1px solid #f1f5f9;
    position: relative; overflow: hidden;
    transition: transform .25s, box-shadow .25s;
}
.summary-card:hover { transform: translateY(-4px); box-shadow: 0 8px 28px rgba(0,0,0,.1); }
.summary-card::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
}
.summary-card.blue::before  { background: linear-gradient(90deg,#3b82f6,#6366f1); }
.summary-card.green::before { background: linear-gradient(90deg,#22c55e,#16a34a); }
.summary-card.amber::before { background: linear-gradient(90deg,#f59e0b,#d97706); }
.summary-card.purple::before{ background: linear-gradient(90deg,#a855f7,#7c3aed); }
.summary-card.cyan::before  { background: linear-gradient(90deg,#06b6d4,#0891b2); }
.summary-card.rose::before  { background: linear-gradient(90deg,#f43f5e,#e11d48); }
.summary-card.teal::before  { background: linear-gradient(90deg,#14b8a6,#0d9488); }
.summary-card.indigo::before{ background: linear-gradient(90deg,#6366f1,#4f46e5); }

.sc-icon {
    width: 44px; height: 44px; border-radius: 11px;
    display: flex; align-items: center; justify-content: center;
    font-size: 19px; margin-bottom: 14px;
}
.sc-icon.blue   { background: #eff6ff; color: #3b82f6; }
.sc-icon.green  { background: #f0fdf4; color: #22c55e; }
.sc-icon.amber  { background: #fffbeb; color: #f59e0b; }
.sc-icon.purple { background: #faf5ff; color: #a855f7; }
.sc-icon.cyan   { background: #ecfeff; color: #06b6d4; }
.sc-icon.rose   { background: #fff1f2; color: #f43f5e; }
.sc-icon.teal   { background: #f0fdfa; color: #14b8a6; }
.sc-icon.indigo { background: #eef2ff; color: #6366f1; }

.sc-value {
    font-size: 34px; font-weight: 800; color: #0f172a;
    line-height: 1; margin-bottom: 6px;
    font-family: 'Space Grotesk', sans-serif;
}
.sc-label { font-size: 13px; color: #64748b; font-weight: 500; }
.sc-bg-icon {
    position: absolute; right: 16px; bottom: 10px;
    font-size: 56px; opacity: .05; color: #0f172a;
    pointer-events: none;
}

/* ── Chart Cards ──────────────────────────── */
.chart-card {
    background: #fff; border-radius: 16px;
    padding: 28px 24px;
    box-shadow: 0 2px 12px rgba(0,0,0,.06);
    border: 1px solid #f1f5f9;
    margin-bottom: 24px;
}
.chart-card-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 22px; flex-wrap: wrap; gap: 12px;
}
.chart-card-title {
    font-size: 16px; font-weight: 700; color: #0f172a;
    display: flex; align-items: center; gap: 9px;
}
.chart-card-title i { color: #3b82f6; }
.chart-card-sub { font-size: 12px; color: #94a3b8; margin-top: 3px; }
.chart-badge {
    background: #eff6ff; color: #3b82f6; font-size: 11px;
    font-weight: 600; padding: 4px 10px; border-radius: 8px;
    border: 1px solid #bfdbfe; white-space: nowrap;
}
.chart-canvas-wrap { position: relative; }

/* ── Top Books Table ──────────────────────── */
.top-book-table { width: 100%; border-collapse: collapse; }
.top-book-table thead th {
    background: #f8fafc; color: #64748b;
    font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .8px;
    padding: 10px 14px; border-bottom: 2px solid #e2e8f0;
    text-align: left;
}
.top-book-table tbody tr {
    border-bottom: 1px solid #f1f5f9;
    transition: background .15s;
}
.top-book-table tbody tr:hover { background: #f8fafc; }
.top-book-table tbody td { padding: 12px 14px; font-size: 13.5px; color: #334155; }
.rank-badge {
    width: 28px; height: 28px; border-radius: 8px;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 800; color: #fff;
}
.rank-1 { background: linear-gradient(135deg,#f59e0b,#d97706); }
.rank-2 { background: linear-gradient(135deg,#94a3b8,#64748b); }
.rank-3 { background: linear-gradient(135deg,#cd7c3e,#a85f2a); }
.rank-n { background: #e2e8f0; color: #94a3b8; font-weight: 600; }

.borrow-bar-wrap { display: flex; align-items: center; gap: 10px; }
.borrow-bar-bg {
    flex: 1; height: 7px; background: #f1f5f9; border-radius: 4px; overflow: hidden;
}
.borrow-bar-fill {
    height: 100%; border-radius: 4px;
    background: linear-gradient(90deg,#3b82f6,#6366f1);
    transition: width .8s cubic-bezier(.16,1,.3,1);
}
.borrow-count { font-size: 13px; font-weight: 700; color: #3b82f6; min-width: 28px; text-align: right; }

/* ── Status Donut Legend ──────────────────── */
.donut-legend { list-style: none; padding: 0; margin: 0; }
.donut-legend li {
    display: flex; align-items: center; justify-content: space-between;
    padding: 8px 0; border-bottom: 1px solid #f1f5f9; font-size: 13px;
}
.donut-legend li:last-child { border-bottom: none; }
.donut-legend-dot { width: 12px; height: 12px; border-radius: 3px; flex-shrink: 0; }
.donut-legend-label { display: flex; align-items: center; gap: 8px; color: #334155; }
.donut-legend-val { font-weight: 700; color: #0f172a; }

/* ── Harian Bars ──────────────────────────── */
.harian-grid {
    display: flex; align-items: flex-end; gap: 10px;
    height: 120px; padding-top: 12px;
}
.harian-col {
    flex: 1; display: flex; flex-direction: column; align-items: center; gap: 6px;
}
.harian-bar-wrap {
    flex: 1; width: 100%; display: flex; align-items: flex-end;
}
.harian-bar {
    width: 100%; border-radius: 6px 6px 0 0;
    background: linear-gradient(180deg,#3b82f6,#6366f1);
    min-height: 4px;
    transition: height .8s cubic-bezier(.16,1,.3,1);
    position: relative;
}
.harian-bar:hover::after {
    content: attr(data-val);
    position: absolute; top: -26px; left: 50%; transform: translateX(-50%);
    background: #0f172a; color: #fff; font-size: 11px; font-weight: 700;
    padding: 2px 7px; border-radius: 5px; white-space: nowrap;
}
.harian-label { font-size: 10px; color: #94a3b8; font-weight: 500; text-align: center; }

/* ── Info Footer ──────────────────────────── */
.stat-info-footer {
    background: linear-gradient(135deg,#0f172a,#1e3a5f);
    border-radius: 16px; padding: 28px 32px; margin-top: 40px;
    display: flex; align-items: center; gap: 20px; flex-wrap: wrap;
}
.stat-info-footer i { color: #60a5fa; font-size: 28px; flex-shrink: 0; }
.stat-info-footer h4 { color: #fff; font-size: 16px; font-weight: 700; margin: 0 0 4px; }
.stat-info-footer p { color: rgba(255,255,255,.6); font-size: 13px; margin: 0; }

/* ── Responsive ───────────────────────────── */
.two-col-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
@media(max-width:768px){ .two-col-grid{ grid-template-columns: 1fr; } }

.three-col-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 24px; }
@media(max-width:768px){ .three-col-grid{ grid-template-columns: 1fr; } }

/* ── Export Buttons ───────────────────────── */
.btn-export-chart {
    display: inline-flex; align-items: center; gap: 6px;
    background: #f8fafc; border: 1px solid #e2e8f0;
    color: #64748b; font-size: 11.5px; font-weight: 600;
    padding: 5px 11px; border-radius: 8px; cursor: pointer;
    transition: all .2s; white-space: nowrap; text-decoration: none;
    font-family: 'Space Grotesk', sans-serif;
}
.btn-export-chart:hover {
    background: #3b82f6; border-color: #3b82f6;
    color: #fff; transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59,130,246,.3);
    text-decoration: none;
}
.btn-export-chart i { font-size: 11px; }
.btn-export-chart.loading { pointer-events: none; opacity: .7; }

/* ── Export All Bar ───────────────────────── */
.export-all-bar {
    background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 100%);
    border-radius: 14px; padding: 18px 24px;
    display: flex; align-items: center; justify-content: space-between;
    gap: 16px; flex-wrap: wrap;
    margin-bottom: 8px;
    box-shadow: 0 4px 24px rgba(15,23,42,.15);
}
.export-all-bar-left { display: flex; align-items: center; gap: 14px; }
.export-all-bar-icon {
    width: 40px; height: 40px; border-radius: 10px;
    background: rgba(59,130,246,.2); border: 1px solid rgba(59,130,246,.3);
    display: flex; align-items: center; justify-content: center;
    color: #60a5fa; font-size: 17px; flex-shrink: 0;
}
.export-all-bar h3 { color: #fff; font-size: 15px; font-weight: 700; margin: 0 0 2px; }
.export-all-bar p  { color: rgba(255,255,255,.5); font-size: 12px; margin: 0; }
.export-all-actions { display: flex; gap: 10px; flex-wrap: wrap; }

.btn-export-all-pdf {
    display: inline-flex; align-items: center; gap: 8px;
    background: linear-gradient(135deg, #3b82f6, #6366f1);
    color: #fff; font-size: 13px; font-weight: 700;
    padding: 10px 20px; border-radius: 10px; border: none; cursor: pointer;
    transition: all .25s; white-space: nowrap;
    font-family: 'Space Grotesk', sans-serif;
    box-shadow: 0 4px 16px rgba(59,130,246,.35);
}
.btn-export-all-pdf:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(59,130,246,.45);
    color: #fff; text-decoration: none;
}
.btn-export-all-pdf.loading { pointer-events:none; opacity:.75; }

.btn-export-all-png {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.2);
    color: rgba(255,255,255,.85); font-size: 13px; font-weight: 600;
    padding: 10px 20px; border-radius: 10px; cursor: pointer;
    transition: all .25s; white-space: nowrap;
    font-family: 'Space Grotesk', sans-serif;
}
.btn-export-all-png:hover {
    background: rgba(255,255,255,.15); color: #fff;
    text-decoration: none;
}

/* progress overlay */
#exportOverlay {
    display: none; position: fixed; inset: 0; z-index: 9999;
    background: rgba(15,23,42,.75); backdrop-filter: blur(4px);
    align-items: center; justify-content: center; flex-direction: column; gap: 16px;
}
#exportOverlay.show { display: flex; }
#exportOverlay .eo-box {
    background: #fff; border-radius: 16px; padding: 32px 40px;
    text-align: center; min-width: 280px;
    box-shadow: 0 24px 60px rgba(0,0,0,.3);
}
#exportOverlay .eo-spinner {
    width: 44px; height: 44px; border: 4px solid #e2e8f0;
    border-top-color: #3b82f6; border-radius: 50%;
    animation: spin .8s linear infinite; margin: 0 auto 14px;
}
@keyframes spin { to { transform: rotate(360deg); } }
#exportOverlay .eo-title { font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 4px; }
#exportOverlay .eo-sub   { font-size: 12px; color: #94a3b8; }
</style>
@endsection

@section('content')
{{-- ═══════════════════════════════════
     HERO BANNER
═══════════════════════════════════ --}}
<section class="stat-hero">
    <div class="stat-hero-grid"></div>

    {{-- Floating particles --}}
    @foreach([
        ['width:6px;height:6px;background:#3b82f6;left:10%;animation-duration:12s;animation-delay:0s'],
        ['width:4px;height:4px;background:#a855f7;left:25%;animation-duration:15s;animation-delay:3s'],
        ['width:8px;height:8px;background:#22c55e;left:50%;animation-duration:10s;animation-delay:1s'],
        ['width:5px;height:5px;background:#f59e0b;left:70%;animation-duration:14s;animation-delay:5s'],
        ['width:7px;height:7px;background:#06b6d4;left:85%;animation-duration:11s;animation-delay:2s'],
    ] as $p)
    <div class="stat-particle" style="{{ $p[0] }};bottom:-10px;opacity:.7;"></div>
    @endforeach

    <div class="container stat-hero-content">
        <div class="stat-hero-badge">
            <i class="fas fa-database"></i>
            Big Data Analytics
        </div>
        <h1>Statistik & Analitik<br><span>Perpustakaan PPIC</span></h1>
        <p>Data real-time koleksi, peminjaman, pengunjung, dan tren aktivitas perpustakaan divisualisasikan secara interaktif.</p>
        <div class="stat-hero-meta">
            <span><span class="dot"></span> Data diperbarui secara real-time</span>
            <span><i class="fas fa-calendar-alt"></i> Per {{ now()->format('d F Y') }}</span>
            <span><i class="fas fa-layer-group"></i> {{ number_format($summary['total_koleksi']) }} koleksi terdaftar</span>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════
     MAIN CONTENT
═══════════════════════════════════ --}}
<div class="stat-page">
<div class="container">

    {{-- ── EXPORT ALL BAR ── --}}
    <div class="export-all-bar" style="margin-top:40px">
        <div class="export-all-bar-left">
            <div class="export-all-bar-icon"><i class="fas fa-file-export"></i></div>
            <div>
                <h3>Ekspor Laporan Statistik</h3>
                <p>Unduh seluruh grafik sekaligus dalam satu file</p>
            </div>
        </div>
        <div class="export-all-actions">
            <button id="btnExportAllPdf" class="btn-export-all-pdf" onclick="exportAllPDF()">
                <i class="fas fa-file-pdf"></i> Ekspor Semua ke PDF
            </button>
            <button class="btn-export-all-png" onclick="exportAllZip()">
                <i class="fas fa-images"></i> Semua Grafik (ZIP PNG)
            </button>
        </div>
    </div>

    {{-- ── SECTION 1: Ringkasan Utama ── --}}
    <div class="stat-section-title">
        <div class="icon-wrap" style="background:#eff6ff"><i class="fas fa-chart-bar" style="color:#3b82f6"></i></div>
        <div>
            <h2>Ringkasan Utama</h2>
            <p>Indikator kunci kinerja perpustakaan secara keseluruhan</p>
        </div>
    </div>

    <div class="summary-grid">
        <div class="summary-card blue">
            <div class="sc-icon blue"><i class="fas fa-books"></i></div>
            <div class="sc-value" id="cnt-koleksi">{{ number_format($summary['total_koleksi']) }}</div>
            <div class="sc-label">Total Koleksi Buku</div>
            <i class="fas fa-book sc-bg-icon"></i>
        </div>
        <div class="summary-card green">
            <div class="sc-icon green"><i class="fas fa-check-circle"></i></div>
            <div class="sc-value">{{ number_format($summary['buku_tersedia']) }}</div>
            <div class="sc-label">Buku Tersedia</div>
            <i class="fas fa-check sc-bg-icon"></i>
        </div>
        <div class="summary-card purple">
            <div class="sc-icon purple"><i class="fas fa-tags"></i></div>
            <div class="sc-value">{{ number_format($summary['total_kategori']) }}</div>
            <div class="sc-label">Total Kategori</div>
            <i class="fas fa-tag sc-bg-icon"></i>
        </div>
        <div class="summary-card amber">
            <div class="sc-icon amber"><i class="fas fa-hand-holding-heart"></i></div>
            <div class="sc-value">{{ number_format($summary['total_peminjaman']) }}</div>
            <div class="sc-label">Total Transaksi Pinjam</div>
            <i class="fas fa-exchange-alt sc-bg-icon"></i>
        </div>
        <div class="summary-card cyan">
            <div class="sc-icon cyan"><i class="fas fa-user-friends"></i></div>
            <div class="sc-value">{{ number_format($summary['total_anggota']) }}</div>
            <div class="sc-label">Total Anggota</div>
            <i class="fas fa-users sc-bg-icon"></i>
        </div>
        <div class="summary-card rose">
            <div class="sc-icon rose"><i class="fas fa-hourglass-half"></i></div>
            <div class="sc-value">{{ number_format($summary['peminjaman_aktif']) }}</div>
            <div class="sc-label">Peminjaman Aktif</div>
            <i class="fas fa-clock sc-bg-icon"></i>
        </div>
        <div class="summary-card teal">
            <div class="sc-icon teal"><i class="fas fa-eye"></i></div>
            <div class="sc-value">{{ number_format($summary['total_pengunjung']) }}</div>
            <div class="sc-label">Total Pengunjung Website</div>
            <i class="fas fa-globe sc-bg-icon"></i>
        </div>
        <div class="summary-card indigo">
            <div class="sc-icon indigo"><i class="fas fa-calendar-day"></i></div>
            <div class="sc-value">{{ number_format($summary['pengunjung_hari_ini']) }}</div>
            <div class="sc-label">Pengunjung Hari Ini</div>
            <i class="fas fa-calendar sc-bg-icon"></i>
        </div>
    </div>

    {{-- ── SECTION 2: Tren Peminjaman & Pengunjung ── --}}
    <div class="stat-section-title">
        <div class="icon-wrap" style="background:#f0fdf4"><i class="fas fa-chart-line" style="color:#22c55e"></i></div>
        <div>
            <h2>Tren 12 Bulan Terakhir</h2>
            <p>Visualisasi volume peminjaman dan kunjungan website per bulan</p>
        </div>
    </div>

    <div class="two-col-grid">
        {{-- Chart: Tren Peminjaman --}}
        <div class="chart-card">
            <div class="chart-card-header">
                <div>
                    <div class="chart-card-title"><i class="fas fa-chart-area"></i> Tren Peminjaman Buku</div>
                    <div class="chart-card-sub">12 bulan terakhir • transaksi aktif + dikembalikan</div>
                </div>
                <div style="display:flex;gap:8px;align-items:center">
                    <span class="chart-badge"><i class="fas fa-sync-alt"></i> Real-time</span>
                    <button class="btn-export-chart" onclick="exportChart('chartTrenPeminjaman','Tren_Peminjaman_Buku')">
                        <i class="fas fa-download"></i> PNG
                    </button>
                </div>
            </div>
            <div class="chart-canvas-wrap">
                <canvas id="chartTrenPeminjaman" height="200"></canvas>
            </div>
        </div>

        {{-- Chart: Tren Pengunjung --}}
        <div class="chart-card">
            <div class="chart-card-header">
                <div>
                    <div class="chart-card-title"><i class="fas fa-chart-area" style="color:#a855f7"></i> Tren Pengunjung Website</div>
                    <div class="chart-card-sub">12 bulan terakhir • unique session log</div>
                </div>
                <div style="display:flex;gap:8px;align-items:center">
                    <span class="chart-badge" style="background:#faf5ff;color:#a855f7;border-color:#d8b4fe"><i class="fas fa-users"></i> Web Analytics</span>
                    <button class="btn-export-chart" onclick="exportChart('chartTrenPengunjung','Tren_Pengunjung_Website')">
                        <i class="fas fa-download"></i> PNG
                    </button>
                </div>
            </div>
            <div class="chart-canvas-wrap">
                <canvas id="chartTrenPengunjung" height="200"></canvas>
            </div>
        </div>
    </div>

    {{-- ── SECTION 3: Distribusi Koleksi ── --}}
    <div class="stat-section-title">
        <div class="icon-wrap" style="background:#faf5ff"><i class="fas fa-layer-group" style="color:#a855f7"></i></div>
        <div>
            <h2>Distribusi Koleksi</h2>
            <p>Persebaran buku berdasarkan kategori dan tahun terbit</p>
        </div>
    </div>

    <div class="two-col-grid">
        {{-- Chart: Buku per Kategori --}}
        <div class="chart-card">
            <div class="chart-card-header">
                <div>
                    <div class="chart-card-title"><i class="fas fa-chart-bar" style="color:#6366f1"></i> Koleksi per Kategori</div>
                    <div class="chart-card-sub">{{ $bukuPerKategori->count() }} kategori aktif</div>
                </div>
                <button class="btn-export-chart" onclick="exportChart('chartKategori','Distribusi_Koleksi_per_Kategori')">
                    <i class="fas fa-download"></i> PNG
                </button>
            </div>
            <canvas id="chartKategori" height="220"></canvas>
        </div>

        {{-- Chart: Buku per Tahun Terbit --}}
        <div class="chart-card">
            <div class="chart-card-header">
                <div>
                    <div class="chart-card-title"><i class="fas fa-calendar-alt" style="color:#f59e0b"></i> Koleksi per Tahun Terbit</div>
                    <div class="chart-card-sub">Distribusi usia koleksi perpustakaan</div>
                </div>
                <button class="btn-export-chart" onclick="exportChart('chartTahun','Distribusi_per_Tahun_Terbit')">
                    <i class="fas fa-download"></i> PNG
                </button>
            </div>
            <canvas id="chartTahun" height="220"></canvas>
        </div>
    </div>

    {{-- ── SECTION 4: Top Buku & Status Peminjaman ── --}}
    <div class="stat-section-title">
        <div class="icon-wrap" style="background:#fff7ed"><i class="fas fa-trophy" style="color:#f59e0b"></i></div>
        <div>
            <h2>Analitik Peminjaman</h2>
            <p>Buku terpopuler dan distribusi status transaksi peminjaman</p>
        </div>
    </div>

    <div class="three-col-grid">
        {{-- Top 10 Buku --}}
        <div class="chart-card" style="padding:0;overflow:hidden;">
            <div style="padding:22px 24px 14px; border-bottom:1px solid #f1f5f9;">
                <div class="chart-card-title"><i class="fas fa-trophy" style="color:#f59e0b"></i> Top 10 Buku Terpopuler</div>
                <div class="chart-card-sub">Berdasarkan total frekuensi peminjaman</div>
            </div>
            <div style="overflow-x:auto;">
                <table class="top-book-table">
                    <thead>
                        <tr>
                            <th style="width:44px">#</th>
                            <th>Judul Buku</th>
                            <th style="width:180px">Frekuensi Dipinjam</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $maxPinjam = $topBuku->max('total') ?: 1; @endphp
                        @forelse($topBuku as $i => $buku)
                        <tr>
                            <td>
                                <span class="rank-badge {{ $i===0?'rank-1':($i===1?'rank-2':($i===2?'rank-3':'rank-n')) }}">
                                    {{ $i+1 }}
                                </span>
                            </td>
                            <td>
                                <div style="font-weight:600;color:#1e293b;font-size:13px;line-height:1.4">{{ Str::limit($buku['judul'],45) }}</div>
                                <div style="color:#94a3b8;font-size:11.5px;margin-top:2px">{{ $buku['penulis'] }}</div>
                            </td>
                            <td>
                                <div class="borrow-bar-wrap">
                                    <div class="borrow-bar-bg">
                                        <div class="borrow-bar-fill" style="width:{{ round(($buku['total']/$maxPinjam)*100) }}%"></div>
                                    </div>
                                    <span class="borrow-count">{{ $buku['total'] }}x</span>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" style="text-align:center;color:#94a3b8;padding:32px">
                                <i class="fas fa-inbox" style="font-size:28px;display:block;margin-bottom:8px"></i>
                                Belum ada data peminjaman
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Status Peminjaman --}}
        <div class="chart-card">
            <div class="chart-card-header">
                <div>
                    <div class="chart-card-title"><i class="fas fa-chart-pie" style="color:#f43f5e"></i> Status Peminjaman</div>
                    <div class="chart-card-sub">Distribusi saat ini</div>
                </div>
                <button class="btn-export-chart" onclick="exportChart('chartStatusPinjam','Status_Peminjaman')">
                    <i class="fas fa-download"></i> PNG
                </button>
            </div>
            <div style="max-width:220px;margin:0 auto 20px">
                <canvas id="chartStatusPinjam" height="220"></canvas>
            </div>
            <ul class="donut-legend">
                @foreach($statusPeminjaman as $s)
                <li>
                    <div class="donut-legend-label">
                        <span class="donut-legend-dot" style="background:{{ $s['color'] }}"></span>
                        {{ $s['label'] }}
                    </div>
                    <span class="donut-legend-val">{{ number_format($s['value']) }}</span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- ── SECTION 5: Aktivitas Harian ── --}}
    <div class="stat-section-title">
        <div class="icon-wrap" style="background:#ecfeff"><i class="fas fa-history" style="color:#06b6d4"></i></div>
        <div>
            <h2>Aktivitas Peminjaman Harian</h2>
            <p>7 hari terakhir — volume request peminjaman per hari</p>
        </div>
    </div>

    <div class="chart-card" id="chartHarianCard">
        <div class="chart-card-header">
            <div>
                <div class="chart-card-title"><i class="fas fa-calendar-week" style="color:#06b6d4"></i> Request Peminjaman 7 Hari Terakhir</div>
                <div class="chart-card-sub">Velocity data — frekuensi transaksi harian</div>
            </div>
            <button class="btn-export-chart" onclick="exportHarianChart()">
                <i class="fas fa-download"></i> PNG
            </button>
        </div>
        @php $maxHarian = $avgHarian->max('total') ?: 1; @endphp
        <div class="harian-grid">
            @foreach($avgHarian as $h)
            <div class="harian-col">
                <div class="harian-bar-wrap">
                    <div class="harian-bar"
                         data-val="{{ $h['total'] }}"
                         style="height:{{ max(4, round(($h['total']/$maxHarian)*100)) }}%">
                    </div>
                </div>
                <div class="harian-label">{{ $h['tanggal'] }}</div>
                <div style="font-size:11px;font-weight:700;color:#3b82f6">{{ $h['total'] }}</div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ── INFO FOOTER ── --}}
    <div class="stat-info-footer">
        <i class="fas fa-database"></i>
        <div>
            <h4>Tentang Data Statistik Ini</h4>
            <p>
                Data diambil secara langsung dari basis data sistem perpustakaan yang mencakup
                <strong style="color:#93c5fd">{{ number_format($summary['total_koleksi']) }} koleksi buku</strong>,
                <strong style="color:#93c5fd">{{ number_format($summary['total_peminjaman']) }} transaksi peminjaman</strong>, dan
                <strong style="color:#93c5fd">{{ number_format($summary['total_pengunjung']) }} log pengunjung website</strong>.
                Halaman ini merupakan implementasi konsep <em>Big Data Analytics</em> untuk mendukung pengambilan keputusan berbasis data di lingkungan perpustakaan.
            </p>
        </div>
    </div>

</div>
</div>

{{-- Export Progress Overlay --}}
<div id="exportOverlay">
    <div class="eo-box">
        <div class="eo-spinner"></div>
        <div class="eo-title" id="exportOverlayTitle">Menyiapkan ekspor...</div>
        <div class="eo-sub" id="exportOverlaySub">Mohon tunggu sebentar</div>
    </div>
</div>
@endsection

@section('scripts')
{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
{{-- jsPDF + html2canvas for PDF export --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
(function() {
    // ── Data dari PHP (JSON-safe) ────────────────────────────
    const trenPeminjaman = @json($trenPeminjaman);
    const trenPengunjung = @json($trenPengunjung);
    const bukuPerKategori = @json($bukuPerKategori);
    const bukuPerTahun   = @json($bukuPerTahun);
    const statusPeminjaman = @json($statusPeminjaman);

    // ── Shared chart defaults ─────────────────────────────────
    Chart.defaults.font.family = "'Space Grotesk', 'Poppins', sans-serif";
    Chart.defaults.font.size   = 12;
    Chart.defaults.color       = '#64748b';
    Chart.defaults.plugins.legend.display = false;

    const gridColor = 'rgba(0,0,0,.04)';
    const axisColor = '#e2e8f0';

    function lineChartOptions(color1, color2) {
        return {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleColor: '#f8fafc',
                    bodyColor: '#cbd5e1',
                    borderColor: 'rgba(255,255,255,.1)',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false,
                }
            },
            scales: {
                x: { grid: { display: false }, border: { color: axisColor } },
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, precision: 0 },
                    grid: { color: gridColor },
                    border: { display: false },
                }
            },
            elements: { line: { tension: 0.4, borderWidth: 2.5 }, point: { radius: 3, hoverRadius: 5 } },
            animation: { duration: 1200, easing: 'easeOutQuart' }
        };
    }

    function gradient(ctx, c1, c2) {
        const g = ctx.createLinearGradient(0, 0, 0, ctx.canvas.height);
        g.addColorStop(0,   c1);
        g.addColorStop(1,   c2);
        return g;
    }

    // ── 1. Tren Peminjaman ───────────────────────────────────
    (function() {
        const ctx = document.getElementById('chartTrenPeminjaman').getContext('2d');
        const grad = gradient(ctx, 'rgba(59,130,246,.3)', 'rgba(59,130,246,.02)');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: trenPeminjaman.labels,
                datasets: [{
                    data: trenPeminjaman.data,
                    borderColor: '#3b82f6',
                    backgroundColor: grad,
                    fill: true,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                }]
            },
            options: lineChartOptions('#3b82f6', '#6366f1')
        });
    })();

    // ── 2. Tren Pengunjung ───────────────────────────────────
    (function() {
        const ctx = document.getElementById('chartTrenPengunjung').getContext('2d');
        const grad = gradient(ctx, 'rgba(168,85,247,.3)', 'rgba(168,85,247,.02)');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: trenPengunjung.labels,
                datasets: [{
                    data: trenPengunjung.data,
                    borderColor: '#a855f7',
                    backgroundColor: grad,
                    fill: true,
                    pointBackgroundColor: '#a855f7',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                }]
            },
            options: lineChartOptions('#a855f7', '#7c3aed')
        });
    })();

    // ── 3. Buku per Kategori (Horizontal Bar) ────────────────
    (function() {
        const ctx = document.getElementById('chartKategori').getContext('2d');
        const colors = [
            '#3b82f6','#6366f1','#a855f7','#22c55e',
            '#f59e0b','#06b6d4','#f43f5e','#14b8a6',
            '#84cc16','#e11d48',
        ];
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: bukuPerKategori.map(d => d.name),
                datasets: [{
                    data: bukuPerKategori.map(d => d.total),
                    backgroundColor: bukuPerKategori.map((_, i) => colors[i % colors.length]),
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#f8fafc',
                        bodyColor: '#cbd5e1',
                        borderColor: 'rgba(255,255,255,.1)',
                        borderWidth: 1,
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: {
                            label: ctx => ` ${ctx.raw} buku`
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: { precision: 0 },
                        grid: { color: gridColor },
                        border: { display: false },
                    },
                    y: { grid: { display: false }, border: { color: axisColor } }
                },
                animation: { duration: 1000 }
            }
        });
    })();

    // ── 4. Buku per Tahun Terbit (Line) ──────────────────────
    (function() {
        if (!bukuPerTahun.length) return;
        const ctx = document.getElementById('chartTahun').getContext('2d');
        const grad = gradient(ctx, 'rgba(245,158,11,.3)', 'rgba(245,158,11,.02)');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: bukuPerTahun.map(d => d.tahun),
                datasets: [{
                    data: bukuPerTahun.map(d => d.total),
                    borderColor: '#f59e0b',
                    backgroundColor: grad,
                    fill: true,
                    pointRadius: 2,
                    pointHoverRadius: 5,
                    pointBackgroundColor: '#f59e0b',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { display: false }, tooltip: { backgroundColor:'#0f172a', padding:10, cornerRadius:8, bodyColor:'#cbd5e1', titleColor:'#f8fafc', displayColors:false } },
                scales: {
                    x: { grid: { display: false }, ticks: { maxRotation: 45, autoSkip: true, maxTicksLimit: 10 }, border: { color: axisColor } },
                    y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: gridColor }, border: { display: false } }
                },
                elements: { line: { tension: 0.3, borderWidth: 2 } },
                animation: { duration: 1200 }
            }
        });
    })();

    // ── 5. Status Peminjaman (Donut) ─────────────────────────
    (function() {
        const ctx = document.getElementById('chartStatusPinjam').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: statusPeminjaman.map(d => d.label),
                datasets: [{
                    data: statusPeminjaman.map(d => d.value),
                    backgroundColor: statusPeminjaman.map(d => d.color),
                    borderWidth: 2,
                    borderColor: '#fff',
                    hoverOffset: 8,
                }]
            },
            options: {
                cutout: '68%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a', padding: 10, cornerRadius: 8,
                        bodyColor: '#cbd5e1', titleColor: '#f8fafc',
                        callbacks: { label: ctx => ` ${ctx.raw} transaksi` }
                    }
                },
                animation: { animateRotate: true, duration: 1000 }
            }
        });
    })();

    // ── Counter animasi untuk summary cards ──────────────────
    function animateCounter(el, target, duration) {
        let start = 0;
        const step = target / (duration / 16);
        const timer = setInterval(function() {
            start += step;
            if (start >= target) { el.textContent = target.toLocaleString('id-ID'); clearInterval(timer); return; }
            el.textContent = Math.floor(start).toLocaleString('id-ID');
        }, 16);
    }

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (!entry.isIntersecting) return;
            entry.target.querySelectorAll('.sc-value').forEach(function(el) {
                const raw = parseInt(el.textContent.replace(/\D/g, ''), 10);
                if (!isNaN(raw)) animateCounter(el, raw, 1200);
            });
            observer.unobserve(entry.target);
        });
    }, { threshold: 0.2 });

    document.querySelectorAll('.summary-grid').forEach(g => observer.observe(g));
})();

// ══════════════════════════════════════════════════
//  EXPORT UTILITIES
// ══════════════════════════════════════════════════

/** Registry semua chart canvas + label --*/
const CHART_REGISTRY = [
    { id: 'chartTrenPeminjaman',  label: 'Tren Peminjaman Buku (12 Bulan)',     filename: 'Tren_Peminjaman_Buku' },
    { id: 'chartTrenPengunjung',  label: 'Tren Pengunjung Website (12 Bulan)',  filename: 'Tren_Pengunjung_Website' },
    { id: 'chartKategori',        label: 'Distribusi Koleksi per Kategori',     filename: 'Distribusi_Koleksi_per_Kategori' },
    { id: 'chartTahun',           label: 'Distribusi Koleksi per Tahun Terbit', filename: 'Distribusi_per_Tahun_Terbit' },
    { id: 'chartStatusPinjam',    label: 'Status Peminjaman (Donut)',           filename: 'Status_Peminjaman' },
];

/** Helper: timestamp string */
function nowStamp() {
    const d = new Date();
    return d.getFullYear()
        + ('0'+(d.getMonth()+1)).slice(-2)
        + ('0'+d.getDate()).slice(-2)
        + '_'
        + ('0'+d.getHours()).slice(-2)
        + ('0'+d.getMinutes()).slice(-2);
}

/** Helper: overlay */
function showOverlay(title, sub) {
    document.getElementById('exportOverlayTitle').textContent = title;
    document.getElementById('exportOverlaySub').textContent   = sub || 'Mohon tunggu sebentar...';
    document.getElementById('exportOverlay').classList.add('show');
}
function hideOverlay() {
    document.getElementById('exportOverlay').classList.remove('show');
}

/**
 * Ekspor satu canvas Chart.js → PNG download
 * @param {string} canvasId   - id element <canvas>
 * @param {string} filename   - nama file tanpa ekstensi
 */
function exportChart(canvasId, filename) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) { alert('Grafik tidak ditemukan.'); return; }

    // Buat canvas baru dengan background putih
    const exportCanvas = document.createElement('canvas');
    exportCanvas.width  = canvas.width;
    exportCanvas.height = canvas.height;
    const ctx = exportCanvas.getContext('2d');

    // Background putih
    ctx.fillStyle = '#ffffff';
    ctx.fillRect(0, 0, exportCanvas.width, exportCanvas.height);

    // Tambah watermark / judul
    ctx.fillStyle = '#0f172a';
    ctx.font = 'bold 13px Arial';
    ctx.fillText('Perpustakaan PPIC — ' + (filename.replace(/_/g, ' ')), 12, 18);
    ctx.fillStyle = '#94a3b8';
    ctx.font = '11px Arial';
    ctx.fillText('Dihasilkan: ' + new Date().toLocaleDateString('id-ID', {day:'2-digit',month:'long',year:'numeric'}), 12, 34);

    // Gambar chart di bawah header kecil
    ctx.drawImage(canvas, 0, 40);

    const link = document.createElement('a');
    link.download = 'PPIC_' + filename + '_' + nowStamp() + '.png';
    link.href = exportCanvas.toDataURL('image/png', 1.0);
    link.click();
}

/**
 * Ekspor custom harian bar chart (bukan Chart.js canvas) → PNG
 */
function exportHarianChart() {
    const card = document.getElementById('chartHarianCard');
    if (!card) return;
    showOverlay('Mengambil screenshot grafik...', 'html2canvas sedang bekerja');
    html2canvas(card, {
        backgroundColor: '#ffffff',
        scale: 2,
        useCORS: true,
        logging: false,
    }).then(function(canvas) {
        hideOverlay();
        const link = document.createElement('a');
        link.download = 'PPIC_Aktivitas_Harian_' + nowStamp() + '.png';
        link.href = canvas.toDataURL('image/png', 1.0);
        link.click();
    }).catch(function() {
        hideOverlay();
        alert('Gagal mengekspor grafik. Coba lagi.');
    });
}

/**
 * Ekspor SEMUA grafik ke satu file PDF
 */
async function exportAllPDF() {
    showOverlay('Menyiapkan PDF...', 'Mengambil data semua grafik');
    const btn = document.getElementById('btnExportAllPdf');
    if (btn) btn.classList.add('loading');

    try {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF({ orientation: 'landscape', unit: 'mm', format: 'a4' });
        const pageW = pdf.internal.pageSize.getWidth();
        const pageH = pdf.internal.pageSize.getHeight();
        const margin = 12;
        let isFirstPage = true;

        // ── Cover / Header PDF ──────────────────────────────
        pdf.setFillColor(15, 23, 42);
        pdf.rect(0, 0, pageW, pageH, 'F');

        pdf.setTextColor(255, 255, 255);
        pdf.setFontSize(22); pdf.setFont('helvetica', 'bold');
        pdf.text('Laporan Statistik & Analitik', pageW / 2, 60, { align: 'center' });
        pdf.setFontSize(16); pdf.setFont('helvetica', 'normal');
        pdf.text('Perpustakaan Politeknik Penerbangan Indonesia Curug', pageW / 2, 74, { align: 'center' });

        pdf.setTextColor(147, 197, 253);
        pdf.setFontSize(11);
        pdf.text('Big Data Analytics Dashboard', pageW / 2, 88, { align: 'center' });

        pdf.setTextColor(148, 163, 184);
        pdf.setFontSize(10);
        const now = new Date();
        pdf.text('Dihasilkan: ' + now.toLocaleDateString('id-ID', {weekday:'long',day:'2-digit',month:'long',year:'numeric'}) + ' pukul ' + now.toLocaleTimeString('id-ID'), pageW / 2, 104, { align: 'center' });

        // ── Render setiap Chart.js canvas ──────────────────
        for (let i = 0; i < CHART_REGISTRY.length; i++) {
            const entry = CHART_REGISTRY[i];
            const canvas = document.getElementById(entry.id);
            if (!canvas) continue;

            document.getElementById('exportOverlaySub').textContent =
                'Memproses grafik ' + (i + 1) + ' / ' + (CHART_REGISTRY.length + 1) + ': ' + entry.label;

            // Buat canvas export dengan bg putih
            const ec = document.createElement('canvas');
            ec.width  = canvas.width  || 800;
            ec.height = (canvas.height || 400) + 50;
            const ectx = ec.getContext('2d');
            ectx.fillStyle = '#ffffff';
            ectx.fillRect(0, 0, ec.width, ec.height);

            // Header mini
            ectx.fillStyle = '#0f172a';
            ectx.font = 'bold 14px Arial';
            ectx.fillText(entry.label, 12, 22);
            ectx.fillStyle = '#94a3b8';
            ectx.font = '11px Arial';
            ectx.fillText('Perpustakaan PPIC', 12, 40);
            ectx.drawImage(canvas, 0, 50);

            const imgData = ec.toDataURL('image/png', 1.0);

            pdf.addPage();
            // Hitung dimensi fit ke halaman
            const maxW = pageW - margin * 2;
            const maxH = pageH - margin * 2 - 20;
            const ratio = Math.min(maxW / ec.width, maxH / ec.height);
            const imgW  = ec.width  * ratio;
            const imgH  = ec.height * ratio;
            const imgX  = (pageW - imgW) / 2;
            const imgY  = margin + 10;

            // Footer tiap halaman
            pdf.setFillColor(248, 250, 252);
            pdf.rect(0, 0, pageW, pageH, 'F');
            pdf.setDrawColor(226, 232, 240);
            pdf.rect(margin - 2, margin, pageW - margin * 2 + 4, pageH - margin * 2, 'S');

            pdf.addImage(imgData, 'PNG', imgX, imgY, imgW, imgH);

            // Nomor halaman
            pdf.setTextColor(148, 163, 184);
            pdf.setFontSize(9); pdf.setFont('helvetica', 'normal');
            pdf.text('Halaman ' + (i + 2) + ' dari ' + (CHART_REGISTRY.length + 2), pageW - margin, pageH - 5, { align: 'right' });
            pdf.text('Perpustakaan PPIC — Laporan Statistik', margin, pageH - 5);
        }

        // ── Halaman terakhir: Aktivitas Harian (html2canvas) ─
        document.getElementById('exportOverlaySub').textContent = 'Memproses grafik ' + (CHART_REGISTRY.length + 1) + ' / ' + (CHART_REGISTRY.length + 1) + ': Aktivitas Harian';
        const harianCard = document.getElementById('chartHarianCard');
        if (harianCard) {
            const harianCanvas = await html2canvas(harianCard, {
                backgroundColor: '#ffffff', scale: 2, useCORS: true, logging: false
            });
            const harianImg = harianCanvas.toDataURL('image/png', 1.0);
            pdf.addPage();
            pdf.setFillColor(248, 250, 252);
            pdf.rect(0, 0, pageW, pageH, 'F');
            pdf.setDrawColor(226, 232, 240);
            pdf.rect(margin - 2, margin, pageW - margin * 2 + 4, pageH - margin * 2, 'S');
            const maxW = pageW - margin * 2;
            const maxH = pageH - margin * 2 - 20;
            const ratio = Math.min(maxW / harianCanvas.width, maxH / harianCanvas.height);
            const imgW  = harianCanvas.width  * ratio;
            const imgH  = harianCanvas.height * ratio;
            pdf.addImage(harianImg, 'PNG', (pageW - imgW) / 2, margin + 10, imgW, imgH);
            pdf.setTextColor(148, 163, 184);
            pdf.setFontSize(9);
            pdf.text('Halaman ' + (CHART_REGISTRY.length + 2) + ' dari ' + (CHART_REGISTRY.length + 2), pageW - margin, pageH - 5, { align: 'right' });
            pdf.text('Perpustakaan PPIC — Laporan Statistik', margin, pageH - 5);
        }

        document.getElementById('exportOverlaySub').textContent = 'Menyimpan file PDF...';
        pdf.save('PPIC_Laporan_Statistik_' + nowStamp() + '.pdf');

    } catch (err) {
        console.error('Export PDF error:', err);
        alert('Terjadi kesalahan saat mengekspor PDF. Silakan coba lagi.');
    } finally {
        hideOverlay();
        const btn = document.getElementById('btnExportAllPdf');
        if (btn) btn.classList.remove('loading');
    }
}

/**
 * Ekspor SEMUA grafik sebagai ZIP berisi file-file PNG
 * (fallback: unduh satu per satu)
 */
async function exportAllZip() {
    showOverlay('Mengunduh semua grafik...', 'Grafik diunduh satu per satu sebagai PNG');
    await new Promise(r => setTimeout(r, 400));

    const stamp = nowStamp();
    let count = 0;

    for (const entry of CHART_REGISTRY) {
        const canvas = document.getElementById(entry.id);
        if (!canvas) continue;

        document.getElementById('exportOverlaySub').textContent =
            'Mengunduh ' + (++count) + ' / ' + (CHART_REGISTRY.length + 1) + ': ' + entry.label;

        const ec = document.createElement('canvas');
        ec.width  = canvas.width  || 800;
        ec.height = (canvas.height || 400) + 50;
        const ectx = ec.getContext('2d');
        ectx.fillStyle = '#ffffff';
        ectx.fillRect(0, 0, ec.width, ec.height);
        ectx.fillStyle = '#0f172a'; ectx.font = 'bold 14px Arial';
        ectx.fillText(entry.label, 12, 22);
        ectx.fillStyle = '#94a3b8'; ectx.font = '11px Arial';
        ectx.fillText('Perpustakaan PPIC — ' + new Date().toLocaleDateString('id-ID'), 12, 40);
        ectx.drawImage(canvas, 0, 50);

        const link = document.createElement('a');
        link.download = 'PPIC_' + entry.filename + '_' + stamp + '.png';
        link.href = ec.toDataURL('image/png', 1.0);
        link.click();
        await new Promise(r => setTimeout(r, 350));
    }

    // Harian chart
    document.getElementById('exportOverlaySub').textContent = 'Mengunduh grafik aktivitas harian...';
    const harianCard = document.getElementById('chartHarianCard');
    if (harianCard) {
        const harianCanvas = await html2canvas(harianCard, {
            backgroundColor: '#ffffff', scale: 2, useCORS: true, logging: false
        });
        const link = document.createElement('a');
        link.download = 'PPIC_Aktivitas_Harian_' + stamp + '.png';
        link.href = harianCanvas.toDataURL('image/png', 1.0);
        link.click();
    }

    await new Promise(r => setTimeout(r, 300));
    hideOverlay();
}
</script>
@endsection
