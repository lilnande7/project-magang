@extends('admin.layout')

@section('title', 'ETL Import Data SLiMS')
@section('page-title', 'ETL Import — Dataset SLiMS 9')

@section('content')
<style>
/* ── ETL Page Styles ── */
.etl-hero {
    background: linear-gradient(135deg,#0f172a 0%,#1e3a5f 60%,#0f2942 100%);
    border-radius: 16px; padding: 28px 32px; margin-bottom: 28px;
    display: flex; align-items: center; gap: 20px; flex-wrap: wrap;
    position: relative; overflow: hidden;
}
.etl-hero::before {
    content:''; position:absolute; inset:0;
    background-image: linear-gradient(rgba(255,255,255,.03) 1px,transparent 1px),
                      linear-gradient(90deg,rgba(255,255,255,.03) 1px,transparent 1px);
    background-size: 32px 32px;
}
.etl-hero-icon {
    width:60px; height:60px; border-radius:14px; flex-shrink:0; z-index:1;
    background:rgba(59,130,246,.2); border:1px solid rgba(59,130,246,.35);
    display:flex; align-items:center; justify-content:center;
    font-size:26px; color:#60a5fa;
}
.etl-hero-text { z-index:1; }
.etl-hero-text h2 { color:#fff; font-size:20px; font-weight:700; margin:0 0 4px; }
.etl-hero-text p  { color:rgba(255,255,255,.6); font-size:13px; margin:0; }
.etl-badge {
    display:inline-flex; align-items:center; gap:6px; z-index:1; margin-left:auto;
    background:rgba(34,197,94,.15); border:1px solid rgba(34,197,94,.3);
    color:#86efac; font-size:11px; font-weight:600; padding:5px 12px; border-radius:20px;
}

/* ── Step cards ── */
.etl-step-card {
    background:#fff; border-radius:14px; padding:24px 26px;
    border:1px solid #e2e8f0; box-shadow:0 2px 10px rgba(0,0,0,.05);
    margin-bottom:20px; position:relative;
}
.etl-step-card .step-num {
    width:32px; height:32px; border-radius:8px; display:inline-flex;
    align-items:center; justify-content:center; font-size:13px; font-weight:800;
    color:#fff; margin-bottom:12px;
}
.etl-step-card h5 { font-size:15px; font-weight:700; color:#0f172a; margin:0 0 6px; }
.etl-step-card p  { font-size:13px; color:#64748b; margin:0; }

/* ── Upload zone ── */
.upload-zone {
    border:2px dashed #cbd5e1; border-radius:12px; padding:36px 24px;
    text-align:center; cursor:pointer; transition:all .2s;
    background:#f8fafc; position:relative;
}
.upload-zone:hover, .upload-zone.drag-over {
    border-color:#3b82f6; background:#eff6ff;
}
.upload-zone input[type=file] {
    position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; z-index:10;
}
.upload-zone-icon { font-size:40px; color:#94a3b8; margin-bottom:12px; }
.upload-zone.has-file { border-color:#22c55e; background:#f0fdf4; }
.upload-zone.has-file .upload-zone-icon { color:#22c55e; }

/* ── Mode selector ── */
.mode-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; }
@media(max-width:768px){ .mode-grid{grid-template-columns:1fr;} }
.mode-card {
    border:2px solid #e2e8f0; border-radius:12px; padding:16px;
    cursor:pointer; transition:all .2s; position:relative;
}
.mode-card input[type=radio] { position:absolute; opacity:0; }
.mode-card.selected, .mode-card:hover { border-color:#3b82f6; background:#eff6ff; }
.mode-card h6 { font-size:14px; font-weight:700; color:#0f172a; margin:0 0 4px; }
.mode-card p  { font-size:11.5px; color:#64748b; margin:0; }
.mode-icon { font-size:22px; margin-bottom:8px; }

/* ── Preview table ── */
.preview-wrap { overflow-x:auto; border-radius:10px; border:1px solid #e2e8f0; }
.preview-table { width:100%; border-collapse:collapse; font-size:12px; }
.preview-table th {
    background:#f1f5f9; color:#475569; font-weight:700; text-transform:uppercase;
    font-size:10px; letter-spacing:.6px; padding:9px 12px; border-bottom:2px solid #e2e8f0;
    white-space:nowrap;
}
.preview-table td {
    padding:8px 12px; border-bottom:1px solid #f1f5f9; color:#334155;
    max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;
}
.preview-table tr:last-child td { border-bottom:none; }

/* ── Progress & Result ── */
.etl-progress {
    background:#fff; border-radius:12px; padding:24px;
    border:1px solid #e2e8f0; display:none;
}
.etl-progress.show { display:block; }
.progress-bar-wrap { background:#f1f5f9; border-radius:99px; height:10px; overflow:hidden; margin:14px 0; }
.progress-bar-fill {
    height:100%; border-radius:99px;
    background:linear-gradient(90deg,#3b82f6,#6366f1);
    transition:width .4s ease; width:0%;
}

.result-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-top:16px; }
@media(max-width:768px){ .result-grid{grid-template-columns:repeat(2,1fr);} }
.result-card {
    border-radius:10px; padding:14px 16px; text-align:center;
}
.result-card .rc-val { font-size:28px; font-weight:800; line-height:1; margin-bottom:4px; }
.result-card .rc-lbl { font-size:12px; font-weight:500; }

.result-card.inserted { background:#f0fdf4; color:#15803d; }
.result-card.updated  { background:#eff6ff; color:#1d4ed8; }
.result-card.skipped  { background:#fffbeb; color:#92400e; }
.result-card.errored  { background:#fff1f2; color:#9f1239; }

.error-log {
    background:#fef2f2; border:1px solid #fecaca; border-radius:10px;
    padding:16px; margin-top:14px; max-height:220px; overflow-y:auto;
}
.error-log p { font-size:12px; color:#991b1b; margin:0 0 6px; font-family:monospace; }
.error-log p:last-child { margin:0; }

/* ── Stat panel ── */
.stat-panel {
    background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px;
    padding:18px 20px; margin-bottom:20px;
    display:flex; align-items:center; gap:24px; flex-wrap:wrap;
}
.stat-panel-item { text-align:center; }
.stat-panel-val { font-size:22px; font-weight:800; color:#0f172a; line-height:1; }
.stat-panel-lbl { font-size:11px; color:#94a3b8; font-weight:500; margin-top:2px; }

/* ── Dry-run badge ── */
.dry-run-badge {
    display:inline-flex; align-items:center; gap:6px;
    background:#fff7ed; border:1px solid #fed7aa; color:#c2410c;
    font-size:11.5px; font-weight:700; padding:5px 12px; border-radius:8px;
}

/* ── Spinner ── */
.spin-icon { animation: spin .8s linear infinite; display:inline-block; }
@keyframes spin { to{transform:rotate(360deg);} }
</style>

{{-- HERO --}}
<div class="etl-hero">
    <div class="etl-hero-icon"><i class="fas fa-database"></i></div>
    <div class="etl-hero-text">
        <h2><i class="fas fa-arrow-right-arrow-left" style="color:#60a5fa;margin-right:8px"></i>ETL Import — SLiMS 9 Dataset</h2>
        <p>Proses Extract → Transform → Load dari file CSV ekspor SLiMS ke database perpustakaan aplikasi</p>
    </div>
    <span class="etl-badge"><i class="fas fa-circle" style="font-size:7px"></i> Big Data Pipeline</span>
</div>

{{-- STAT PANEL --}}
<div class="stat-panel" id="statPanel">
    <div class="stat-panel-item">
        <div class="stat-panel-val">{{ number_format($stats['total_books']) }}</div>
        <div class="stat-panel-lbl">Buku di Database</div>
    </div>
    <div class="stat-panel-item">
        <div class="stat-panel-val">{{ number_format($stats['total_categories']) }}</div>
        <div class="stat-panel-lbl">Kategori</div>
    </div>
    @if($stats['last_import'])
    <div class="stat-panel-item" style="margin-left:auto;text-align:right;">
        <div style="font-size:12px;color:#64748b;font-weight:600;">Import Terakhir</div>
        <div style="font-size:13px;color:#0f172a;font-weight:700;">{{ $stats['last_import']['timestamp'] }}</div>
        <div style="font-size:11px;color:#94a3b8;">
            {{ $stats['last_import']['type'] === 'biblio' ? 'Bibliografi' : 'Eksemplar' }} •
            +{{ $stats['last_import']['inserted'] }} inserted •
            ↺{{ $stats['last_import']['updated'] }} updated
        </div>
    </div>
    @endif
</div>

<div class="row g-4">
    {{-- LEFT COLUMN: Form --}}
    <div class="col-lg-7">

        {{-- STEP 1: Upload --}}
        <div class="etl-step-card">
            <span class="step-num" style="background:linear-gradient(135deg,#3b82f6,#6366f1)">1</span>
            <h5>Upload File CSV</h5>
            <p>Ekspor dari SLiMS 9: Bibliografi (Katalog → Ekspor Bibliografi) atau Eksemplar (Katalog → Ekspor Item)</p>

            <div style="margin-top:16px;">
                <label class="form-label fw-semibold" style="font-size:13px">Tipe Dataset</label>
                <div class="d-flex gap-3 mb-3">
                    <label class="d-flex align-items-center gap-2 cursor-pointer" style="font-size:13px">
                        <input type="radio" name="csv_type" id="typeBiblio" value="biblio" checked
                               onchange="updateTypeUI()"> Bibliografi (biblio)
                    </label>
                    <label class="d-flex align-items-center gap-2 cursor-pointer" style="font-size:13px">
                        <input type="radio" name="csv_type" id="typeItem" value="item"
                               onchange="updateTypeUI()"> Eksemplar (item)
                    </label>
                </div>

                <div class="upload-zone" id="uploadZone">
                    <input type="file" id="csvFileInput" accept=".csv,.txt" onchange="onFileSelected(this)">
                    <div class="upload-zone-icon"><i class="fas fa-file-csv"></i></div>
                    <div id="uploadZoneText">
                        <strong style="font-size:14px;color:#334155">Klik atau seret file CSV ke sini</strong><br>
                        <span style="font-size:12px;color:#94a3b8">Format: .csv • Maks 20 MB</span>
                    </div>
                </div>

                <div id="typeInfo" class="mt-2 p-2 rounded" style="background:#eff6ff;font-size:12px;color:#1d4ed8;display:none;border:1px solid #bfdbfe;">
                </div>
            </div>
        </div>

        {{-- STEP 2: Preview --}}
        <div class="etl-step-card" id="step2Card" style="display:none">
            <span class="step-num" style="background:linear-gradient(135deg,#a855f7,#7c3aed)">2</span>
            <h5>Preview Data</h5>
            <p>5 baris pertama dari file yang diupload — validasi kolom sebelum import</p>

            <div class="mt-3" id="previewContainer">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span id="totalRowsBadge" class="badge bg-primary"></span>
                    <span id="headerCountBadge" class="badge bg-secondary"></span>
                </div>
                <div class="preview-wrap">
                    <table class="preview-table" id="previewTable">
                        <thead id="previewHead"></thead>
                        <tbody id="previewBody"></tbody>
                    </table>
                </div>
            </div>

            <button class="btn btn-primary mt-3" id="btnToStep3" onclick="goToStep3()" style="font-size:13px;">
                <i class="fas fa-arrow-right me-1"></i> Lanjut ke Konfigurasi Import
            </button>
        </div>

        {{-- STEP 3: Mode & Run --}}
        <div class="etl-step-card" id="step3Card" style="display:none">
            <span class="step-num" style="background:linear-gradient(135deg,#22c55e,#16a34a)">3</span>
            <h5>Konfigurasi & Jalankan ETL</h5>
            <p>Pilih mode import, lalu jalankan proses ETL</p>

            <div class="mt-3">
                <label class="form-label fw-semibold" style="font-size:13px">Mode Import</label>
                <div class="mode-grid">
                    <div class="mode-card selected" id="modeInsert" onclick="selectMode('insert_new')">
                        <input type="radio" name="import_mode" value="insert_new" checked>
                        <div class="mode-icon">➕</div>
                        <h6>Insert Baru</h6>
                        <p>Hanya tambah data yang belum ada. Data existing dilewati (aman).</p>
                    </div>
                    <div class="mode-card" id="modeUpsert" onclick="selectMode('upsert')">
                        <input type="radio" name="import_mode" value="upsert">
                        <div class="mode-icon">🔄</div>
                        <h6>Upsert</h6>
                        <p>Tambah baru + update data existing berdasarkan ISBN atau judul.</p>
                    </div>
                    <div class="mode-card" id="modeDryRun" onclick="selectMode('dry_run')">
                        <input type="radio" name="import_mode" value="dry_run">
                        <div class="mode-icon">🔍</div>
                        <h6>Dry-Run</h6>
                        <p>Simulasi saja — tidak ada data yang benar-benar diubah di database.</p>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-3 mt-4 flex-wrap">
                <button class="btn btn-success" id="btnRunETL" onclick="runETL()" style="font-size:14px;padding:10px 24px;font-weight:700;">
                    <i class="fas fa-play me-2"></i> Jalankan ETL
                </button>
                <button class="btn btn-outline-secondary" onclick="resetAll()" style="font-size:13px;">
                    <i class="fas fa-redo me-1"></i> Reset
                </button>
                <span class="dry-run-badge d-none" id="dryRunBadge">
                    <i class="fas fa-flask"></i> Mode Simulasi
                </span>
            </div>
        </div>

        {{-- STEP 4: Progress & Result --}}
        <div class="etl-step-card etl-progress" id="step4Card">
            <span class="step-num" style="background:linear-gradient(135deg,#06b6d4,#0891b2)">4</span>
            <h5 id="progressTitle">Memproses ETL...</h5>
            <p id="progressSub">Harap tunggu, jangan tutup halaman ini</p>

            {{-- Progress Bar --}}
            <div class="progress-bar-wrap" style="margin-top:14px">
                <div class="progress-bar-fill" id="progressBar"></div>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:12px;color:#94a3b8;margin-top:5px">
                <span id="progressChunkInfo"></span>
                <span id="progressPct">0%</span>
            </div>

            {{-- Live Counters (tampil SAAT proses berlangsung) --}}
            <div id="liveCounters" style="display:none;margin-top:16px">
                <div style="font-size:11px;color:#94a3b8;font-weight:600;text-transform:uppercase;letter-spacing:.6px;margin-bottom:8px">
                    <i class="fas fa-circle-notch spin-icon me-1" style="color:#3b82f6"></i>
                    Live Progress
                </div>
                <div class="result-grid">
                    <div class="result-card inserted">
                        <div class="rc-val" id="liveInserted">0</div>
                        <div class="rc-lbl">✅ Inserted</div>
                    </div>
                    <div class="result-card updated">
                        <div class="rc-val" id="liveUpdated">0</div>
                        <div class="rc-lbl">🔄 Updated</div>
                    </div>
                    <div class="result-card skipped">
                        <div class="rc-val" id="liveSkipped">0</div>
                        <div class="rc-lbl">⏭ Skipped</div>
                    </div>
                    <div class="result-card errored">
                        <div class="rc-val" id="liveErrors">0</div>
                        <div class="rc-lbl">❌ Errors</div>
                    </div>
                </div>
            </div>

            {{-- Hasil Akhir --}}
            <div id="resultSection" style="display:none">
                <hr style="border-color:#f1f5f9;margin-top:20px">
                <h6 style="font-weight:700;color:#0f172a;margin-bottom:12px">
                    <i class="fas fa-check-circle text-success me-2"></i>Laporan Hasil ETL
                    <span id="dryRunNote" class="dry-run-badge ms-2 d-none"><i class="fas fa-flask"></i> Simulasi</span>
                </h6>

                <div class="result-grid">
                    <div class="result-card inserted">
                        <div class="rc-val" id="rcInserted">0</div>
                        <div class="rc-lbl">✅ Inserted</div>
                    </div>
                    <div class="result-card updated">
                        <div class="rc-val" id="rcUpdated">0</div>
                        <div class="rc-lbl">🔄 Updated</div>
                    </div>
                    <div class="result-card skipped">
                        <div class="rc-val" id="rcSkipped">0</div>
                        <div class="rc-lbl">⏭ Skipped</div>
                    </div>
                    <div class="result-card errored">
                        <div class="rc-val" id="rcErrors">0</div>
                        <div class="rc-lbl">❌ Errors</div>
                    </div>
                </div>

                <div id="errorLogWrap" style="display:none" class="error-log mt-3">
                    <strong style="font-size:12px;color:#991b1b;display:block;margin-bottom:8px">
                        <i class="fas fa-exclamation-triangle me-1"></i>Error Log (maks 50 ditampilkan)
                    </strong>
                    <div id="errorLogContent"></div>
                </div>

                <div class="d-flex gap-2 mt-3 flex-wrap">
                    <a href="{{ route('admin.books.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-book me-1"></i> Lihat Data Buku
                    </a>
                    <button class="btn btn-outline-secondary btn-sm" onclick="resetAll()">
                        <i class="fas fa-redo me-1"></i> Import File Lain
                    </button>
                </div>
            </div>
        </div>

    </div>

    {{-- RIGHT COLUMN: Info & Panduan --}}
    <div class="col-lg-5">
        {{-- Panduan Kolom --}}
        <div class="card mb-4">
            <div class="card-header" style="font-weight:700;font-size:14px">
                <i class="fas fa-columns me-2 text-primary"></i>Pemetaan Kolom CSV → Database
            </div>
            <div class="card-body p-0">
                <div id="mappingBiblio">
                    <table class="table table-sm mb-0" style="font-size:12px">
                        <thead><tr style="background:#f8fafc">
                            <th style="width:45%;padding:8px 12px">Kolom CSV (SLiMS)</th>
                            <th style="padding:8px 12px">Field Database</th>
                        </tr></thead>
                        <tbody>
                            <tr><td><code>title</code></td><td>books.title</td></tr>
                            <tr><td><code>authors</code></td><td>books.author</td></tr>
                            <tr><td><code>isbn_issn</code></td><td>books.isbn</td></tr>
                            <tr><td><code>publisher_name</code></td><td>books.publisher</td></tr>
                            <tr><td><code>publish_year</code></td><td>books.year</td></tr>
                            <tr><td><code>collation</code></td><td>books.pages (diparse)</td></tr>
                            <tr><td><code>language_name</code></td><td>books.language</td></tr>
                            <tr><td><code>notes</code></td><td>books.description</td></tr>
                            <tr><td><code>classification</code></td><td>books.classification + auto-kategori</td></tr>
                            <tr><td><code>call_number</code></td><td>books.call_number</td></tr>
                            <tr><td><code>place_name</code></td><td>books.place_name</td></tr>
                            <tr><td><code>gmd_name</code></td><td>books.gmd_name</td></tr>
                            <tr><td><code>topics</code></td><td>books.topics + subjects</td></tr>
                            <tr><td><code>item_code</code></td><td>books.item_code</td></tr>
                            <tr><td><code>image</code></td><td>books.cover_image</td></tr>
                        </tbody>
                    </table>
                </div>
                <div id="mappingItem" style="display:none">
                    <table class="table table-sm mb-0" style="font-size:12px">
                        <thead><tr style="background:#f8fafc">
                            <th style="width:35%;padding:8px 12px">Kolom (index)</th>
                            <th style="padding:8px 12px">Keterangan</th>
                        </tr></thead>
                        <tbody>
                            <tr><td><code>[0]</code> item_code</td><td>Kode eksemplar</td></tr>
                            <tr><td><code>[1]</code> call_number</td><td>Nomor panggil → books.call_number</td></tr>
                            <tr><td><code>[2]</code> gmd_name</td><td>Jenis media</td></tr>
                            <tr><td><code>[7]</code> location</td><td>Lokasi rak → books.location</td></tr>
                            <tr><td><code>[11]</code> stock</td><td>Jumlah eksemplar → books.stock</td></tr>
                            <tr><td><code>[18]</code> title</td><td>Judul buku (untuk match)</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Pipeline ETL Diagram --}}
        <div class="card mb-4">
            <div class="card-header" style="font-weight:700;font-size:14px">
                <i class="fas fa-project-diagram me-2 text-success"></i>Pipeline ETL
            </div>
            <div class="card-body">
                <div class="d-flex flex-column gap-2">
                    @foreach([
                        ['extract','📂','Extract','Baca CSV SLiMS row-per-row (SplFileObject streaming)','#eff6ff','#1d4ed8'],
                        ['transform','⚙️','Transform','Parsing <Author>, DDC→kategori, normalisasi ISBN/tahun/halaman','#faf5ff','#7c3aed'],
                        ['load','💾','Load','Upsert/Insert ke tabel books + auto-create kategori','#f0fdf4','#15803d'],
                    ] as [$id,$icon,$label,$desc,$bg,$color])
                    <div style="background:{{ $bg }};border-radius:10px;padding:12px 14px;display:flex;align-items:flex-start;gap:12px">
                        <span style="font-size:20px;line-height:1;margin-top:1px">{{ $icon }}</span>
                        <div>
                            <strong style="font-size:13px;color:{{ $color }}">{{ $label }}</strong>
                            <div style="font-size:12px;color:#475569;margin-top:2px">{{ $desc }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div style="font-size:11.5px;color:#94a3b8;margin-top:14px;padding-top:12px;border-top:1px solid #f1f5f9">
                    <i class="fas fa-info-circle me-1"></i>
                    Auto-kategorisasi berdasarkan kode DDC: 000-099 → Ilmu Komputer, 600-629 → Teknologi & Teknik, dsb.
                </div>
            </div>
        </div>

        {{-- Tips --}}
        <div class="card">
            <div class="card-header" style="font-weight:700;font-size:14px">
                <i class="fas fa-lightbulb me-2 text-warning"></i>Tips & Catatan
            </div>
            <div class="card-body" style="font-size:12.5px;color:#475569">
                <ul class="mb-0 ps-3" style="line-height:2">
                    <li>Gunakan <strong>Dry-Run</strong> terlebih dahulu untuk simulasi tanpa mengubah data</li>
                    <li>Import <strong>Bibliografi dulu</strong>, baru <strong>Eksemplar</strong> untuk update stok</li>
                    <li>Mode <strong>Upsert</strong> mencocokkan duplikat via ISBN atau judul+penulis</li>
                    <li>Kategori baru otomatis dibuat dari kode DDC jika belum ada</li>
                    <li>File CSV maks <strong>20 MB</strong> (~10.000 record)</li>
                    <li>Proses besar (5000+ record) membutuhkan <strong>30–120 detik</strong></li>
                </ul>
            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
let tmpPath   = null;
let csvType   = 'biblio';
let totalRows = 0;
let importMode = 'insert_new';

// ── Type switch ──────────────────────────────────────
function updateTypeUI() {
    csvType = document.querySelector('input[name=csv_type]:checked').value;
    document.getElementById('mappingBiblio').style.display = (csvType === 'biblio') ? '' : 'none';
    document.getElementById('mappingItem').style.display   = (csvType === 'item')   ? '' : 'none';
    const info = document.getElementById('typeInfo');
    if (csvType === 'item') {
        info.style.display = '';
        info.innerHTML = '<i class="fas fa-info-circle me-1"></i><strong>Item CSV</strong>: Tidak punya baris header — langsung data eksemplar. Pastikan sudah import Bibliografi terlebih dahulu.';
    } else {
        info.style.display = 'none';
    }
}

// ── File selected ─────────────────────────────────────
function onFileSelected(input) {
    const files = input.files || input;
    if (!files || !files.length) return;
    const file = files[0];
    const zone = document.getElementById('uploadZone');
    if (zone) zone.classList.add('has-file');
    
    document.getElementById('uploadZoneText').innerHTML =
        '<strong style="font-size:14px;color:#15803d"><i class="fas fa-spinner fa-spin me-1"></i>' + esc(file.name) + '</strong><br>'
        + '<span style="font-size:12px;color:#94a3b8">' + (file.size / 1024 / 1024).toFixed(2) + ' MB • Membaca preview...</span>';

    uploadForPreview(file);
}

// Drag & Drop Handling
const zone = document.getElementById('uploadZone');
if (zone) {
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        zone.addEventListener(eventName, e => {
            e.preventDefault();
            e.stopPropagation();
        }, false);
    });

    ['dragenter', 'dragover'].forEach(eventName => {
        zone.addEventListener(eventName, () => zone.classList.add('drag-over'), false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        zone.addEventListener(eventName, () => zone.classList.remove('drag-over'), false);
    });

    zone.addEventListener('drop', e => {
        const dt = e.dataTransfer;
        const files = dt ? dt.files : null;
        if (files && files.length > 0) {
            const fileInput = document.getElementById('csvFileInput');
            try {
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(files[0]);
                fileInput.files = dataTransfer.files;
            } catch (err) {
                console.warn('DataTransfer warning:', err);
            }
            onFileSelected(files);
        }
    }, false);
}

// ── Upload untuk preview ──────────────────────────────
function uploadForPreview(file) {
    const form = new FormData();
    form.append('csv_file', file);
    form.append('csv_type', document.querySelector('input[name=csv_type]:checked').value);
    form.append('_token', '{{ csrf_token() }}');

    fetch('{{ route("admin.etl.preview") }}', { 
        method: 'POST', 
        body: form,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(r => r.json().then(data => ({ status: r.status, ok: r.ok, data: data })))
    .then(res => {
        if (!res.ok || !res.data.success) {
            let msg = res.data.message || 'Gagal memproses file CSV.';
            if (res.data.errors) {
                msg = Object.values(res.data.errors).flat().join('\n');
            }
            alert('Preview Gagal:\n' + msg);
            resetUploadZone();
            return;
        }
        
        const data = res.data;
        tmpPath   = data.tmp_path;
        csvType   = data.csv_type;
        totalRows = data.total;
        
        document.getElementById('uploadZoneText').innerHTML =
            '<strong style="font-size:14px;color:#15803d"><i class="fas fa-check-circle me-1"></i>' + esc(file.name) + '</strong><br>'
            + '<span style="font-size:12px;color:#15803d">' + (file.size / 1024 / 1024).toFixed(2) + ' MB • Preview berhasil (' + totalRows.toLocaleString('id-ID') + ' baris)</span>';

        renderPreview(data);
        document.getElementById('step2Card').style.display = '';
        document.getElementById('step2Card').scrollIntoView({ behavior: 'smooth', block: 'start' });
    })
    .catch(err => {
        alert('Upload gagal: ' + err.message);
        resetUploadZone();
    });
}

// ── Render preview table ──────────────────────────────
function renderPreview(data) {
    document.getElementById('totalRowsBadge').textContent   = totalRows.toLocaleString('id-ID') + ' total baris';
    document.getElementById('headerCountBadge').textContent = data.headers.length + ' kolom';

    const thead = document.getElementById('previewHead');
    const tbody = document.getElementById('previewBody');
    thead.innerHTML = '<tr>' + data.headers.map(h => '<th>' + esc(h) + '</th>').join('') + '</tr>';
    tbody.innerHTML = data.preview.map(row =>
        '<tr>' + data.headers.map(h => '<td title="' + esc(row[h]||'') + '">' + esc(String(row[h]||'').substring(0,60)) + '</td>').join('') + '</tr>'
    ).join('');
}

// ── Go to step 3 ──────────────────────────────────────
function goToStep3() {
    document.getElementById('step3Card').style.display = '';
    document.getElementById('step3Card').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

// ── Mode selection ────────────────────────────────────
function selectMode(mode) {
    importMode = mode;
    ['Insert','Upsert','DryRun'].forEach(m => document.getElementById('mode' + m).classList.remove('selected'));
    const map = { insert_new: 'Insert', upsert: 'Upsert', dry_run: 'DryRun' };
    document.getElementById('mode' + map[mode]).classList.add('selected');
    document.getElementById('dryRunBadge').classList.toggle('d-none', mode !== 'dry_run');
}

// ── Run ETL — Chunked Real Progress ──────────────────
const CHUNK_SIZE   = 150;   // baris per request
const CHUNK_URL    = '{{ route("admin.etl.chunk") }}';
const CSRF_TOKEN   = '{{ csrf_token() }}';

// Generate session key unik per import
function makeSessionKey() {
    return Date.now().toString(36) + Math.random().toString(36).slice(2, 8);
}

function runETL() {
    if (!tmpPath) { alert('Upload file CSV terlebih dahulu.'); return; }

    // Tampilkan step 4
    const step4 = document.getElementById('step4Card');
    step4.classList.add('show');
    step4.scrollIntoView({ behavior: 'smooth', block: 'start' });

    // Reset UI
    setProgress(0);
    document.getElementById('progressTitle').textContent   = 'Memproses ETL...';
    document.getElementById('progressSub').textContent     = 'Memulai proses... 0 / ' + totalRows.toLocaleString('id-ID') + ' baris';
    document.getElementById('progressChunkInfo').textContent = '';
    document.getElementById('progressPct').textContent     = '0%';
    document.getElementById('resultSection').style.display = 'none';
    document.getElementById('liveCounters').style.display  = '';
    document.getElementById('liveInserted').textContent    = '0';
    document.getElementById('liveUpdated').textContent     = '0';
    document.getElementById('liveSkipped').textContent     = '0';
    document.getElementById('liveErrors').textContent      = '0';
    document.getElementById('dryRunNote').classList.add('d-none');

    document.getElementById('btnRunETL').disabled = true;
    document.getElementById('btnRunETL').innerHTML =
        '<i class="fas fa-circle-notch spin-icon me-2"></i>Memproses...';

    const sessionKey  = makeSessionKey();
    const totalChunks = Math.ceil(totalRows / CHUNK_SIZE);
    const startTime   = Date.now();
    let   chunksDone  = 0;

    // Fungsi rekursif: kirim satu chunk, lalu lanjut ke berikutnya
    function processChunk(offset) {
        const form = new FormData();
        form.append('tmp_path',    tmpPath);
        form.append('csv_type',    csvType);
        form.append('mode',        importMode);
        form.append('offset',      offset);
        form.append('chunk_size',  CHUNK_SIZE);
        form.append('session_key', sessionKey);
        form.append('_token',      CSRF_TOKEN);

        fetch(CHUNK_URL, { method: 'POST', body: form })
            .then(r => {
                if (!r.ok) throw new Error('HTTP ' + r.status);
                return r.json();
            })
            .then(data => {
                if (!data.success) {
                    onError(data.message || 'Server mengembalikan error.');
                    return;
                }

                chunksDone++;

                // ── Update Progress Bar (real!) ──
                const processed = data.next_offset;
                const pct       = totalRows > 0
                    ? Math.min(100, Math.round((processed / totalRows) * 100))
                    : Math.min(100, Math.round((chunksDone / totalChunks) * 100));
                setProgress(pct);

                // ── Update label & chunk info ──
                const elapsed   = (Date.now() - startTime) / 1000;
                const rate      = processed / elapsed;     // baris/detik
                const remaining = totalRows > 0 && rate > 0
                    ? Math.ceil((totalRows - processed) / rate)
                    : null;
                const etaStr = remaining !== null
                    ? (remaining > 60
                        ? Math.ceil(remaining / 60) + ' mnt tersisa'
                        : remaining + ' dtk tersisa')
                    : '';

                document.getElementById('progressSub').textContent =
                    'Memproses... ' + processed.toLocaleString('id-ID') +
                    (totalRows ? ' / ' + totalRows.toLocaleString('id-ID') : '') + ' baris';
                document.getElementById('progressChunkInfo').textContent =
                    'Chunk ' + chunksDone + (totalChunks ? ' / ' + totalChunks : '') +
                    (etaStr ? '  •  ' + etaStr : '');

                // ── Update Live Counters ──
                document.getElementById('liveInserted').textContent = (data.inserted || 0).toLocaleString('id-ID');
                document.getElementById('liveUpdated').textContent  = (data.updated  || 0).toLocaleString('id-ID');
                document.getElementById('liveSkipped').textContent  = (data.skipped  || 0).toLocaleString('id-ID');
                document.getElementById('liveErrors').textContent   = (data.errors   || []).length;

                if (data.done) {
                    // Selesai!
                    setProgress(100);
                    onDone(data);
                } else {
                    // Lanjut chunk berikutnya
                    processChunk(data.next_offset);
                }
            })
            .catch(err => onError('Koneksi gagal pada chunk ' + chunksDone + ': ' + err));
    }

    // Mulai dari offset 0
    processChunk(0);
}

function setProgress(pct) {
    document.getElementById('progressBar').style.width  = pct + '%';
    document.getElementById('progressPct').textContent  = Math.round(pct) + '%';
}

function onDone(data) {
    document.getElementById('btnRunETL').disabled = false;
    document.getElementById('btnRunETL').innerHTML = '<i class="fas fa-play me-2"></i> Jalankan ETL';

    document.getElementById('progressTitle').textContent =
        importMode === 'dry_run' ? '✅ Simulasi Selesai' : '✅ Import Selesai!';
    document.getElementById('progressSub').textContent =
        'Total diproses: ' + (data.next_offset || 0).toLocaleString('id-ID') + ' baris';
    document.getElementById('progressChunkInfo').textContent = '';
    document.getElementById('liveCounters').style.display = 'none';

    // Tampilkan result section
    document.getElementById('resultSection').style.display = '';
    document.getElementById('rcInserted').textContent = (data.inserted || 0).toLocaleString('id-ID');
    document.getElementById('rcUpdated').textContent  = (data.updated  || 0).toLocaleString('id-ID');
    document.getElementById('rcSkipped').textContent  = (data.skipped  || 0).toLocaleString('id-ID');
    document.getElementById('rcErrors').textContent   = (data.errors   || []).length;

    if (importMode === 'dry_run') {
        document.getElementById('dryRunNote').classList.remove('d-none');
    }

    const errWrap = document.getElementById('errorLogWrap');
    if (data.errors && data.errors.length > 0) {
        errWrap.style.display = '';
        document.getElementById('errorLogContent').innerHTML =
            data.errors.map(e => '<p>' + esc(e) + '</p>').join('');
    } else {
        errWrap.style.display = 'none';
    }

    document.getElementById('resultSection').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function onError(msg) {
    document.getElementById('btnRunETL').disabled = false;
    document.getElementById('btnRunETL').innerHTML = '<i class="fas fa-play me-2"></i> Jalankan ETL';
    document.getElementById('progressTitle').textContent = '❌ ETL Gagal';
    document.getElementById('progressSub').textContent   = msg;
    document.getElementById('liveCounters').style.display = 'none';
    console.error('ETL Error:', msg);
}

function resetUploadZone() {
    const zone = document.getElementById('uploadZone');
    if (zone) zone.classList.remove('has-file');
    document.getElementById('uploadZoneText').innerHTML =
        '<strong style="font-size:14px;color:#334155">Klik atau seret file CSV ke sini</strong><br>'
        + '<span style="font-size:12px;color:#94a3b8">Format: .csv • Maks 20 MB</span>';
    document.getElementById('csvFileInput').value = '';
}

function resetAll() {
    tmpPath = null; totalRows = 0;
    document.getElementById('step2Card').style.display = 'none';
    document.getElementById('step3Card').style.display = 'none';
    document.getElementById('step4Card').classList.remove('show');
    resetUploadZone();
    document.getElementById('liveCounters').style.display = 'none';
    document.getElementById('resultSection').style.display = 'none';
    setProgress(0);
}

function esc(str) {
    return String(str)
        .replace(/&/g,'&amp;').replace(/</g,'&lt;')
        .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

// Init
updateTypeUI();
</script>
@endsection
