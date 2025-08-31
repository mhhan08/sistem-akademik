<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Biodata</title>
</head>
<body>
    <h1>Pengisian Biodata</h1>

    <?php if(session()->getFlashdata('success')): ?>
        <p style="color:green;"><?= session()->getFlashdata('success'); ?></p>
    <?php endif; ?>

    <form action="<?= site_url('mahasiswa/add/simpan') ?>" method="post">
        <?= csrf_field() ?>
        <label>NIM</label><br>
        <input type="text" name="NIM" required><br><br>

        <label>Nama</label><br>
        <input type="text" name="nama_lengkap" required><br><br>

        <label>Jenis Kelamin</label><br>
        <input type="radio" id="L" value="Laki Laki" name="jenis_kelamin" required>
        <label for="L">Laki Laki</label>
        <input type="radio" id="P" value="Perempuan" name="jenis_kelamin" required>
        <label for="P">Perempuan</label><br><br>

        <label>Tanggal Lahir</label><br>
        <input type="date" name="tanggal_lahir" required><br><br>

        <button type="submit">Simpan</button>
    </form>
</body>
</html>
