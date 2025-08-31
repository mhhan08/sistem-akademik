<h2>Update Mahasiswa</h2>

<?php if (isset($mhs)): ?>
<form action="<?= site_url('mahasiswa/update/'.$mhs['NIM']) ?>" method="post">
    <?= csrf_field() ?>

    <label>Nama</label><br>
    <input type="text" name="nama_lengkap" value="<?= esc($mhs['nama_lengkap']) ?>" required><br><br>

    <label>Jenis Kelamin</label><br>
    <input type="radio" name="jenis_kelamin" value="Laki Laki" <?= $mhs['jenis_kelamin']=='Laki Laki'?'checked':'' ?>> Laki Laki
    <input type="radio" name="jenis_kelamin" value="Perempuan" <?= $mhs['jenis_kelamin']=='Perempuan'?'checked':'' ?>> Perempuan
    <br><br>

    <label>Tanggal Lahir</label><br>
    <input type="date" name="tanggal_lahir" value="<?= esc($mhs['tanggal_lahir']) ?>" required><br><br>

    <button type="submit">Simpan Perubahan</button>
</form>
<?php else: ?>
<p>Data mahasiswa tidak ditemukan.</p>
<?php endif; ?>
