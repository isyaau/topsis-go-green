<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Matrix</h1>
        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('pesan'); ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Area Form -->
        <div class="col-xl-12 col-lg-4">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Matrix</h6>
                    <a href="/data-matrix/create/<?= $dataalternatif['id_alternatif']; ?>" class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm"><i class="fas fa-edit fa-sm text-white-50"></i> Buat Penilaian/Nilai Ulang</a>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <h5>Nama Alternatif : <?= $dataalternatif['nama_alternatif']; ?></h5>

                    <!-- Tabel Matrix -->
                    <table id="example" class="table" style="width:100%">
                        <thead>
                            <tr>
                                <th style="width: 80px;">
                                    <center>No</center>
                                </th>
                                <th>Kriteria</th>
                                <th style="width: 80px;">
                                    <center>Nilai</center>
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($datamatrix as $m) : ?>

                                <tr>

                                    <td>
                                        <center><?= $no++ ?></center>
                                    </td>
                                    <td><?= $m['nama_kriteria']; ?></td>
                                    <td>
                                        <center><?= $m['nilai']; ?></center>
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
                                    <form action="/data-matrix/update" method="post">
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <label for="nama_alternatif" class="form-label">Nama Alternatif</label>
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
                                <th style="width: 80px;">
                                    <center>No</center>
                                </th>
                                <th>Kriteria</th>
                                <th style="width: 80px;">
                                    <center>Nilai</center>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>