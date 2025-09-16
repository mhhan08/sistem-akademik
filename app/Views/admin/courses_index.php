<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?>Kelola Courses<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Kelola Courses</h1>
    <a href="<?= site_url('admin/courses/new') ?>" class="btn btn-primary">Tambah Course Baru</a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success" role="alert">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        Daftar Mata Kuliah
    </div>
    <div class="card-body">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nama Mata Kuliah</th>
                <th>SKS</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($courses)): ?>
                <tr>
                    <td colspan="4" class="text-center">Belum ada data mata kuliah.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($courses as $course): ?>
                    <tr>
                        <td><?= esc($course['id']) ?></td>
                        <td><?= esc($course['course_name']) ?></td>
                        <td><?= esc($course['credits']) ?></td>
                        <td>
                            <!-- Edit -->
                            <a href="<?= site_url('admin/courses/' . $course['id'] . '/edit') ?>"
                               class="btn btn-warning btn-sm">Edit</a>

                            <!-- Delete -->
                            <form action="<?= site_url('admin/courses/' . $course['id']) ?>"
                                  method="post" style="display:inline;">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
