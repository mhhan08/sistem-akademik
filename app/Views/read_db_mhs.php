<h2>Daftar Mahasiswa</h2>

<p>
    <a href="<?= site_url('mahasiswa/add') ?>" style="padding:6px 12px; background-color:green; color:white; text-decoration:none; border-radius:4px;">
        + Tambah Mahasiswa
    </a>
</p>


<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>NIM</th>
        <th>Nama Lengkap</th>
        <th>Jenis Kelamin</th>
        <th>Tanggal Lahir</th>
        <th>Aksi</th>
    </tr>
    <?php foreach($Mahasiswa as $mhs): ?>
    <tr>
        <td><?= esc($mhs['NIM']); ?></td>
        <td><?= esc($mhs['nama_lengkap']); ?></td>
        <td><?= esc($mhs['jenis_kelamin']); ?></td>
        <td><?= esc($mhs['tanggal_lahir']); ?></td>
        <td>
            <a href="<?= site_url('mahasiswa/edit/'.$mhs['NIM']) ?>">Edit</a> |
            <a href="<?= site_url('mahasiswa/delete/'.$mhs['NIM']) ?>" onclick="return confirm('Yakin hapus data ini?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
