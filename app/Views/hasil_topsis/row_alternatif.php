<tr>
    <td><?= $no; ?></td>
    <td><?= $row['nama_alternatif']; ?></td>
    <?php foreach ($nilai as $n) : ?>
        <td align="center">
            <?= $n['nilai']; ?>
        </td>
    <?php endforeach ?>
</tr>