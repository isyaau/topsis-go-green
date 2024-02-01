<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Alternatif</h1>
        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('pesan'); ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Area Form -->
        <div class="col-xl3 col-lg-4">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Data</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <?php if (!empty(session()->getFlashdata('error'))) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h5>Periksa Entrian Form</h5>
                            </hr />
                            <?php echo session()->getFlashdata('error'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    <form class="row g-3" action="/data-alternatif/save" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="col-12">
                            <label for="nama_alternatif" class="form-label"> Nama Alternatif (Kelurahan)</label>
                            <input type="text" name="nama_alternatif" value="<?= old('nama_alternatif') ?>" class="form-control" id="inputAddress" placeholder="Nama Kelurahan">
                        </div>
                        <div class="col-6">
                            <label for="rt_a" class="form-label"> RT A</label>
                            <input type="text" name="rt_a" value="<?= old('rt_a') ?>" class="form-control" id="inputAddress" placeholder="RT A">
                        </div>
                        <div class="col-6">
                            <label for="rt_b" class="form-label"> RT B</label>
                            <input type="text" name="rt_b" value="<?= old('rt_b') ?>" class="form-control" id="inputAddress" placeholder="RT B">
                        </div>
                        <div class="col-12">
                            <label for="kecamatan" class="form-label"> Kecamatan</label>
                            <input type="text" name="kecamatan" value="<?= old('kecamatan') ?>" class="form-control" id="inputAddress" placeholder="Kecamatan">
                        </div>
                        <div class="col-12">
                            <label for="kota" class="form-label"> Kota</label>
                            <input type="text" name="kota" value="<?= old('kota') ?>" class="form-control" id="inputAddress" placeholder="Kota">
                        </div>
                        <div class="col-12 mt-5">
                            <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> Tambah</button>
                            <input class="btn btn-danger" type="reset" value="X Batal">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Area Data -->
        <div class="col-xl-8 col-lg-9">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Merk</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <table id="example" class="table" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Alternatif (Kelurahan)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($alternatif as $a) : ?>

                                <tr>

                                    <td><?= $no++ ?></td>
                                    <td><?= $a['nama_alternatif']; ?></td>

                                    <td>
                                        <a href="/data-alternatif/edit/<?= $a['id_alternatif']; ?>" class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm"><i class="fas fa-edit fa-sm text-white-50"></i></a>
                                        <a href="/data-alternatif/detail/<?= $a['id_alternatif']; ?>" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i class="fas fa-info fa-sm text-white-50"></i></a>
                                        <!-- <a href="#" class="btn btn-info btn-sm btn-edit" data-id="<?= $a['id_alternatif']; ?>" data-nama_alternatif="<?= $a['nama_alternatif']; ?>" data-bs-target="#staticBackdrop"> <i class="fas fa-pencil-alt fa-sm text-white-50"></i> Edit</a> -->
                                        <form action="/data-alternatif/<?= $a['id_alternatif']; ?>" method="post" class="d-inline">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" onclick="return confirm('Apakah Anda Yakin ?');"><i class="fas fa-trash fa-sm text-white-50"></i></a> </button>
                                        </form>

                                    </td>

                                </tr>

                            <?php endforeach ?>
                        </tbody>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakaah anda yakin ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="button" class="btn btn-danger">Hapus</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Ubah Data</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="/data-alternatif/update" method="post">
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <label for="nama_alternatif" class="form-label">Nama Merk</label>
                                                    <input type="text" class="form-control nama_alternatif" id="nama_alternatif" name="nama_alternatif" placeholder="Nama Merk">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="hidden" name="id_alternatif" class="id_alternatif">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-info">Simpan</button>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama Alternatif (Kelurahan)</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection(); ?>