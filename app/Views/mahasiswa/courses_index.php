<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?>Ambil Mata Kuliah<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="mb-4">
        <h1>Daftar Mata Kuliah Tersedia</h1>
        <p>Silakan pilih mata kuliah yang ingin Anda ambil.</p>
    </div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

    <div class="card">
        <div class="card-header">
            Tabel Mata Kuliah
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                <tr>
                    <th>Nama Mata Kuliah</th>
                    <th>SKS</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($courses as $course): ?>
                    <tr>
                        <td><?= esc($course['course_name']) ?></td>
                        <td><?= esc($course['credits']) ?></td>
                        <td>
                            <a href="<?= site_url('mahasiswa/enroll/' . $course['id']) ?>" class="btn btn-success btn-sm">Ambil MK</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?= $this->endSection() ?>