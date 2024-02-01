<tr>
    <td><?= $row->id; ?></td>
    <td><?= $row->fullname; ?></td>
    <td align="center">
        <a href="#" class="btn btn-sm btn-circle btn-active-users" data-id="<?= $row->id; ?>" data-active="<?= $row->active == 1 ? 1 : 0; ?>" title="Klik untuk Mengaktifkan atau Menonaktifkan">
            <?= $row->active == 1 ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-times-circle"></i>'; ?>
        </a>
    </td>
    <td align="center">
        <a href="<?= base_url(); ?>/data-akun/edit/<?= $row->id; ?>" class="btn btn-warning btn-circle btn-sm" title="Ubah Password">
            <i class="fas fa-pen"></i>
        </a>
        <a href="#" class="btn btn-success btn-circle btn-sm btn-change-group" data-id="<?= $row->id; ?>" title="Ubah Grup">
            <i class="fas fa-tasks"></i>
        </a>
        <a href="<?= base_url(); ?>/data-akun/detail/<?= $row->id; ?>" class="btn btn-info btn-circle btn-sm" title="Detail">
            <i class="fas fa-eye"></i>
        </a>
        <form action="/data-akun/<?= $row->id; ?>" method="post" class="d-inline">
            <?= csrf_field(); ?>
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-danger btn-circle btn-sm" onclick="return confirm('Apakah Anda Yakin ?');"> <i class="fas fa-trash"></i> </button>
        </form>
    </td>
</tr>