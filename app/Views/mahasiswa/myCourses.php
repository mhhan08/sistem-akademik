<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?>Mata Kuliah Saya<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="mb-4">
        <h1 class="h3">Mata Kuliah yang Anda Ambil</h1>
        <p>Berikut adalah daftar mata kuliah yang sudah Anda daftarkan semester ini.</p>
    </div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success shadow-sm"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0 fw-bold">Tabel Mata Kuliah Terdaftar</h6>
        </div>
        <div class="card-body">
            <?php if (empty($enrolled_courses)): ?>
                <div class="text-center p-5">
                    <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Anda belum mengambil mata kuliah apapun.</h5>
                    <a href="<?= site_url('mahasiswa/courses') ?>" class="btn btn-primary mt-3">Ambil Mata Kuliah Sekarang</a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="table-dark">
                        <tr>
                            <th>Nama Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Tanggal Ambil</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($enrolled_courses as $course): ?>
                            <tr>
                                <td><?= esc($course['course_name']) ?></td>
                                <td><?= esc($course['credits']) ?></td>
                                <td><?= date('d F Y', strtotime(esc($course['enroll_date']))) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        <?php if (!empty($enrolled_courses)): ?>
            <div class="card-footer fw-bold fs-5">
                Total SKS yang Diambil: <span class="text-primary"><?= esc($total_credits) ?> SKS</span>
            </div>
        <?php endif; ?>
    </div>

<?= $this->endSection() ?>