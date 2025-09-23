<?= $this->extend('layout/template') ?>

<?php
$isEdit = isset($course);
$form_title = $isEdit ? 'Edit Course' : 'Tambah Course Baru';
$submit_button_text = $isEdit ? 'Update' : 'Simpan';
$form_action = $isEdit ? site_url('admin/courses/' . $course['id']) : site_url('admin/courses');
?>

<?= $this->section('title') ?><?= $form_title ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><?= $form_title ?></h5>
                </div>
                <div class="card-body">
                    <?php if (session('validation')): ?>
                        <div class="alert alert-danger shadow-sm"><?= session('validation')->listErrors() ?></div>
                    <?php endif; ?>

                    <form id="courseForm" action="<?= $form_action ?>" method="post" novalidate>
                        <?= csrf_field() ?>
                        <?php if ($isEdit): ?>
                            <input type="hidden" name="_method" value="PUT">
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="course_name" class="form-label fw-semibold">Nama Mata Kuliah</label>
                            <input type="text" class="form-control" id="course_name" name="course_name"
                                   value="<?= old('course_name', $course['course_name'] ?? '') ?>"
                                   placeholder="Contoh: Dasar Pemrograman">
                            <div id="courseNameError" class="invalid-feedback"></div>
                        </div>

                        <div class="mb-3">
                            <label for="credits" class="form-label fw-semibold">Jumlah SKS</label>
                            <input type="number" class="form-control" id="credits" name="credits"
                                   value="<?= old('credits', $course['credits'] ?? '') ?>"
                                   placeholder="Contoh: 3">
                            <div id="creditsError" class="invalid-feedback"></div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="<?= site_url('admin/courses') ?>" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary"><?= $submit_button_text ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("courseForm");
            const courseName = document.getElementById("course_name");
            const credits = document.getElementById("credits");

            const courseNameError = document.getElementById("courseNameError");
            const creditsError = document.getElementById("creditsError");

            form.addEventListener("submit", function (e) {
                let isValid = true;

                // --- Reset status validasi setiap kali tombol submit ditekan ---
                courseName.classList.remove("is-invalid");
                credits.classList.remove("is-invalid");
                courseNameError.textContent = "";
                creditsError.textContent = "";

                // --- Validasi Nama Mata Kuliah ---
                if (courseName.value.trim().length < 3) {
                    courseName.classList.add("is-invalid"); // Tambah border merah
                    courseNameError.textContent = "Nama mata kuliah minimal 3 karakter.";
                    isValid = false;
                }

                // --- Validasi SKS ---
                if (credits.value <= 0 || credits.value.trim() === "" || isNaN(credits.value)) {
                    credits.classList.add("is-invalid"); // Tambah border merah
                    creditsError.textContent = "Jumlah SKS harus berupa angka positif.";
                    isValid = false;
                }

                // Jika salah satu tidak valid, hentikan pengiriman form ke server
                if (!isValid) {
                    e.preventDefault();
                }
            });
        });
    </script>
<?= $this->endSection() ?>