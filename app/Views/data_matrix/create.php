<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Form Penilaian</h1>
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
                    <h6 class="p-0 font-weight-bold text-primary">Form Penilaian <?= $dataalternatif['nama_alternatif'] ?></h6>
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
                    <form class="row g-3" action="/data-matrix/save" method="post" enctype="multipart/form-data">
                        <div class="col-12">
                            <label for="nama_kriteria" class="form-label">Nama Alternatif</label>
                            <input type="text" value="<?= $dataalternatif['nama_alternatif'] ?>" class="form-control" id="inputAddress" placeholder="Nama Kriteria" disabled>
                            <input type="hidden" value="<?= $dataalternatif['id_alternatif'] ?>" name="id_alternatif" class="form-control" id="inputAddress">
                        </div>
                        <?php $no = 1;
                        foreach ($kriteria as $p) : ?>
                            <div class="col-12">
                                <label for="nama_kriteria" class="form-label"><?= $p['deskripsi']; ?></label>
                                <input type="hidden" value="<?= $p['id_kriteria']; ?>" name="id_kriteria<?= $no ?>" class="form-control" id="inputAddress" placeholder="Nama Kriteria">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="nilai<?= $no ?>" value="1" id="nilai<?= $no ?>">
                                    <label class="form-check-label" for="nilai<?= $no ?>">
                                        1
                                    </label> <br>
                                    <input class="form-check-input" type="radio" name="nilai<?= $no ?>" value="2" id="nilai<?= $no ?>">
                                    <label class="form-check-label" for="nilai<?= $no ?>">
                                        2
                                    </label><br>
                                    <input class="form-check-input" type="radio" name="nilai<?= $no ?>" value="3" id="nilai<?= $no ?>">
                                    <label class="form-check-label" for="nilai<?= $no ?>">
                                        3
                                    </label><br>
                                    <input class="form-check-input" type="radio" name="nilai<?= $no ?>" value="4" id="nilai<?= $no ?>">
                                    <label class="form-check-label" for="nilai<?= $no ?>">
                                        4
                                    </label><br>
                                    <input class="form-check-input" type="radio" name="nilai<?= $no ?>" value="5" id="nilai<?= $no ?>">
                                    <label class="form-check-label" for="nilai<?= $no ?>">
                                        5
                                    </label>
                                </div>
                            </div>
                            <?php $no++; ?>
                        <?php endforeach ?>
                        <div class="col-12 mt-5">
                            <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> Tambah</button>
                            <input class="btn btn-danger" type="reset" value="X Batal">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Area Data -->


    </div>
</div>
<?= $this->endSection(); ?>