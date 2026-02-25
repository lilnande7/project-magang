<?= $this->extend('layout/main') ?>


<?= $this->section('css') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/hubungikami.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?= $this->include('hubungikami/_hero') ?>

<?= $this->include('hubungikami/_form') ?>

<?= $this->include('hubungikami/_info') ?>





<?= $this->endSection() ?>