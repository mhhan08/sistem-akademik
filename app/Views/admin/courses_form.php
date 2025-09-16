<?= $this->extend('layout/template') ?>

<?php
// Tentukan variabel untuk mode tambah / edit
$isEdit = isset($course);
$form_title = $isEdit ? 'Edit Course' : 'Tambah Course Baru';
$submit_button_text = $isEdit ? 'Update' : 'Simpan';
$form_action = $isEdit ? site_url('admin/courses/' . $course['id']) : site_url('admin/courses');
?>

<?= $this->section('title') ?><?= $form_title ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title"><?= $form_title ?></h1>
            </div>
            <div class="card-body">
                <?php if (session('validation')): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= session('validation')->listErrors() ?>
                    </div>
                <?php endif; ?>

                <form action="<?= $form_action ?>" method="post">
                    <?= csrf_field() ?>
                    <?php if ($isEdit): ?>
                        <input type="hidden" name="_method" value="PUT">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="course_name" class="form-label">Nama Mata Kuliah</label>
                        <input type="text" class="form-control" id="course_name" name="course_name"
                               value="<?= old('course_name', $course['course_name'] ?? '') ?>"
                               placeholder="Contoh: Dasar Pemrograman">
                    </div>

                    <div class="mb-3">
                        <label for="credits" class="form-label">Jumlah SKS</label>
                        <input type="number" class="form-control" id="credits" name="credits"
                               value="<?= old('credits', $course['credits'] ?? '') ?>"
                               placeholder="Contoh: 3">
                    </div>

                    <div class="mt-4">
                        <a href="<?= site_url('admin/courses') ?>" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary"><?= $submit_button_text ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
