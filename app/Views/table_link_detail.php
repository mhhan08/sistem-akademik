<table border="1">
    <tr>
        <th>No</th>
        <th>NIM</th>
    </tr>
       <?php $no=1; foreach($mahasiswa as $mhs): ?>
    <tr>
        <td>
            <?= $no;?>
        </td>
        <td>
        <a href="<?= base_url('mahasiswa/table/'.$mhs['NIM']); ?>"><?= $mhs['NIM']; $no++;?></a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
