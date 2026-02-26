<?= $this->extend('layout/main') ?>


<?= $this->section('css') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/layanan.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?= $this->include('layanan/_hero') ?>
<?= $this->include('layanan/_fasilitas') ?>
<!-- <?= $this->include('layanan/_layanan_utama') ?> -->

<?= $this->endSection() ?>