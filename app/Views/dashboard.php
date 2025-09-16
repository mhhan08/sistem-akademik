<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?>Dashboard<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <h1>Selamat Datang di Dashboard</h1>
    <p>Anda login sebagai <strong><?= session()->get('role') ?></strong>.</p>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

    <p>Silakan gunakan menu navigasi di atas untuk mengakses fitur yang tersedia untuk Anda.</p>
<?= $this->endSection() ?>