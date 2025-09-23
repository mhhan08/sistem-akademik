<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?>Kelola Courses<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Kelola Courses</h1>
        <a href="<?= site_url('admin/courses/new') ?>" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm"></i> Tambah Course Baru
        </a>
    </div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success shadow-sm" role="alert">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0 fw-bold">Daftar Mata Kuliah</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nama Mata Kuliah</th>
                        <th>SKS</th>
                        <th style="width: 150px;">Aksi</th>
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
                                    <a href="<?= site_url('admin/courses/' . $course['id'] . '/edit') ?>"
                                       class="btn btn-warning btn-sm">Edit</a>

                                    <form action="<?= site_url('admin/courses/' . $course['id']) ?>"
                                          method="post" class="d-inline delete-form">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const deleteForms = document.querySelectorAll('.delete-form');

            deleteForms.forEach(form => {
                form.addEventListener('submit', function (event) {
                    // Mencegah form dikirim secara langsung
                    event.preventDefault();

                    // Tampilkan dialog konfirmasi
                    const userConfirmed = confirm('Apakah Anda yakin ingin menghapus mata kuliah ini?');

                    // Jika pengguna menekan "OK", maka kirim form
                    if (userConfirmed) {
                        form.submit();
                    }
                    // Jika menekan "Cancel", tidak terjadi apa-apa
                });
            });
        });
    </script>
<?= $this->endSection() ?>