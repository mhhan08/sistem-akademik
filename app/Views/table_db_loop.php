<table border="1">
    <tr>
        <th>NIM</th>
        <th>Nama Lengkap</th>
        <th>Jenis Kelamin</th>
        <th>Tanggal Lahir</th>
    </tr>
    <?php foreach($mahasiswa as $mhs): ?>
    <tr>
        <td><?= $mhs['NIM']; ?></td>
        <td><?= $mhs['nama_lengkap']; ?></td>
        <td><?= $mhs['jenis_kelamin']; ?></td>
        <td><?= $mhs['tanggal_lahir']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>
