<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?>
Daftar Mahasiswa
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Daftar Mahasiswa</h3>
    <a href="<?= site_url('admin/students/new') ?>" class="btn btn-primary">Tambah Mahasiswa</a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Username</th>
        <th>Nama Lengkap</th>
        <th>Tahun Masuk</th>
        <th>Aksi</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($students)): ?>
        <?php foreach ($students as $i => $student): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= esc($student['username']) ?></td>
                <td><?= esc($student['full_name']) ?></td>
                <td><?= esc($student['entry_year']) ?></td>
                <td>
                    <a href="<?= site_url('admin/students/'.$student['id'].'/edit') ?>"
                       class="btn btn-warning btn-sm">Edit</a>

                    <form action="<?= site_url('admin/students/'.$student['id']) ?>"
                          method="post" style="display:inline;">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin hapus mahasiswa ini?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="5" class="text-center">Belum ada data mahasiswa.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
<?= $this->endSection() ?>
