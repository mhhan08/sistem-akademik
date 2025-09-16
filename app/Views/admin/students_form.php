<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<h2><?= isset($student) ? 'Edit Mahasiswa' : 'Tambah Mahasiswa' ?></h2>

<form method="post"
      action="<?= isset($student)
          ? site_url('admin/students/'.$student['id'])
          : site_url('admin/students') ?>">

    <?= csrf_field() ?>
    <?php if (isset($student)): ?>
        <input type="hidden" name="_method" value="PUT">
    <?php endif; ?>

    <div class="mb-3">
        <label>Username:</label>
        <input type="text" name="username"
               value="<?= old('username', $student['username'] ?? '') ?>"
               class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Full Name:</label>
        <input type="text" name="full_name"
               value="<?= old('full_name', $student['full_name'] ?? '') ?>"
               class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Entry Year:</label>
        <input type="number" name="entry_year"
               value="<?= old('entry_year', $student['entry_year'] ?? '') ?>"
               class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Password:</label>
        <input type="password" name="password" class="form-control">
        <?php if (isset($student)): ?>
            <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
        <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="<?= site_url('admin/students') ?>" class="btn btn-secondary">Batal</a>
</form>
<?= $this->endSection() ?>
