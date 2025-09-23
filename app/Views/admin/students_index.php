<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?>
    Daftar Mahasiswa
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Daftar Mahasiswa</h1>
        <a href="<?= site_url('admin/students/new') ?>" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm"></i> Tambah Mahasiswa
        </a>
    </div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success shadow-sm">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0 fw-bold">Data Mahasiswa</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Tahun Masuk</th>
                        <th style="width: 150px;">Aksi</th>
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
                                          method="post" class="d-inline delete-form">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
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
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const deleteForms = document.querySelectorAll('.delete-form');

            deleteForms.forEach(form => {
                form.addEventListener('submit', function (event) {
                    event.preventDefault(); // Hentikan submit

                    const userConfirmed = confirm('Apakah Anda yakin ingin menghapus mahasiswa ini?');

                    if (userConfirmed) {
                        form.submit(); // Lanjutkan submit jika dikonfirmasi
                    }
                });
            });
        });
    </script>
<?= $this->endSection() ?>