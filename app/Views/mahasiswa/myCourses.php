<?= $this->extend('layout/template') ?>

<?= $this->section('title') ?>Mata Kuliah Saya<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="mb-4">
        <h1>Mata Kuliah yang Anda Ambil</h1>
        <p>Berikut adalah daftar mata kuliah yang sudah Anda daftarkan.</p>
    </div>

    <div class="card">
        <div class="card-header">
            Tabel Mata Kuliah Terdaftar
        </div>
        <div class="card-body">
            <?php if (empty($enrolled_courses)): ?>
                <div class="alert alert-info">
                    Anda belum mengambil mata kuliah apapun.
                </div>
            <?php else: ?>
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
                            <td><?= esc($course['enroll_date']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
<?= $this->endSection() ?>