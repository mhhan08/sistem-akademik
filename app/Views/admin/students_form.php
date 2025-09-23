<?= $this->extend('layout/template') ?>

<?php
$isEdit = isset($student);
$form_title = $isEdit ? 'Edit Mahasiswa' : 'Tambah Mahasiswa Baru';
$submit_button_text = $isEdit ? 'Update' : 'Simpan';
$form_action = $isEdit ? site_url('admin/students/' . $student['id']) : site_url('admin/students');
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
                    <form id="studentForm" method="post" action="<?= $form_action ?>" novalidate>
                        <?= csrf_field() ?>
                        <?php if ($isEdit): ?>
                            <input type="hidden" name="_method" value="PUT">
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="username" class="form-label fw-semibold">Username</label>
                            <input type="text" id="username" name="username"
                                   value="<?= old('username', $student['username'] ?? '') ?>"
                                   class="form-control">
                            <div id="usernameError" class="invalid-feedback"></div>
                        </div>

                        <div class="mb-3">
                            <label for="full_name" class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" id="full_name" name="full_name"
                                   value="<?= old('full_name', $student['full_name'] ?? '') ?>"
                                   class="form-control">
                            <div id="fullNameError" class="invalid-feedback"></div>
                        </div>

                        <div class="mb-3">
                            <label for="entry_year" class="form-label fw-semibold">Tahun Masuk</label>
                            <input type="number" id="entry_year" name="entry_year"
                                   value="<?= old('entry_year', $student['entry_year'] ?? '') ?>"
                                   class="form-control" placeholder="Contoh: 2022">
                            <div id="entryYearError" class="invalid-feedback"></div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <input type="password" id="password" name="password" class="form-control">
                            <div id="passwordError" class="invalid-feedback"></div>
                            <?php if ($isEdit): ?>
                                <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="<?= site_url('admin/students') ?>" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary"><?= $submit_button_text ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("studentForm");
            const username = document.getElementById("username");
            const fullName = document.getElementById("full_name");
            const entryYear = document.getElementById("entry_year");
            const password = document.getElementById("password");

            // Cek apakah ini form edit atau tambah baru
            const isEditMode = <?= $isEdit ? 'true' : 'false' ?>;

            form.addEventListener("submit", function(e) {
                let isValid = true;

                // --- Reset status validasi ---
                [username, fullName, entryYear, password].forEach(input => {
                    input.classList.remove('is-invalid');
                    const errorEl = document.getElementById(input.id + 'Error');
                    if(errorEl) errorEl.textContent = '';
                });

                // --- Validasi Username ---
                if (username.value.trim().length < 5) {
                    username.classList.add('is-invalid');
                    document.getElementById('usernameError').textContent = 'Username minimal 5 karakter.';
                    isValid = false;
                }

                // --- Validasi Nama Lengkap ---
                if (fullName.value.trim().length < 3) {
                    fullName.classList.add('is-invalid');
                    document.getElementById('fullNameError').textContent = 'Nama lengkap minimal 3 karakter.';
                    isValid = false;
                }

                // --- Validasi Tahun Masuk ---
                const currentYear = new Date().getFullYear();
                if (entryYear.value.length !== 4 || isNaN(entryYear.value) || entryYear.value < 2000 || entryYear.value > currentYear) {
                    entryYear.classList.add('is-invalid');
                    document.getElementById('entryYearError').textContent = `Tahun masuk harus 4 digit antara 2000 - ${currentYear}.`;
                    isValid = false;
                }

                // --- Validasi Password (wajib jika tambah baru, opsional jika edit) ---
                if (!isEditMode && password.value.length < 6) {
                    password.classList.add('is-invalid');
                    document.getElementById('passwordError').textContent = 'Password minimal 6 karakter.';
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                }
            });
        });
    </script>
<?= $this->endSection() ?>