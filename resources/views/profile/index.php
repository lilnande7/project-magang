<?= $this->extend('layout/main') ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/profile.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?= $this->include('profile/_hero') ?>

<?= $this->endSection() ?>