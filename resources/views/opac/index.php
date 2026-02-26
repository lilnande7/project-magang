<?= $this->include('public/layout/header') ?>


<h2 class="mb-4 fw-bold">OPAC - Pencarian</h2>

<div class="card p-3 mb-3">
    <form method="get" action="<?= base_url('opac') ?>" class="row g-2 search-box">

        <div class="col-md-4">
            <input type="text" name="q" value="<?= esc($q) ?>" 
                   class="form-control" placeholder="Cari judul atau penulis...">
        </div>

        <div class="col-md-3">
            <select name="jurusan" class="form-select">
                <option value="">Semua Jurusan</option>
                <option value="D III TPU" <?= $jurusan=='D III TPU'?'selected':'' ?>>D III TPU</option>
            </select>
        </div>

        <div class="col-md-3">
            <select name="sort" class="form-select">
                <option value="title_asc" <?= $sort=='title_asc'?'selected':'' ?>>Judul A-Z</option>
                <option value="title_desc" <?= $sort=='title_desc'?'selected':'' ?>>Judul Z-A</option>
            </select>
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Cari</button>
        </div>
    </form>
</div>

<table class="table table-bordered table-striped table-hover">
    <thead class="table-light">
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Tahun</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1 ?>
        <?php foreach ($bibliografi as $b): ?>
        <tr>
            <td><?= $i++ ?></td>
            <td>
                <a href="<?= base_url('opac/detail/'.$b['id']) ?>" class="fw-bold">
                    <?= esc($b['title']) ?>
                </a>
            </td>
            <td><?= esc($b['author']) ?></td>
            <td><?= esc($b['year']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="mt-3">
    <?= $pager->links() ?>
</div>

<?= $this->include('public/layout/footer') ?>
