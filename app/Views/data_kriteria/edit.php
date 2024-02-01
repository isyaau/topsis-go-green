<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Kriteria</h1>
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
                    <h6 class="p-0 font-weight-bold text-primary">Edit Data</h6>
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
                    <form class="row g-3" action="/data-kriteria/update/<?= $datakriteria['id_kriteria']; ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id_kriteria" value="<?= (old('id_kriteria')) ? old('id_kriteria') : $datakriteria['id_kriteria']; ?>">
                        <div class="col-12">
                            <label for="nama_kriteria" class="form-label">Nama Kriteria</label>
                            <input type="text" name="nama_kriteria" value="<?= (old('nama_kriteria')) ? old('nama_kriteria') : $datakriteria['nama_kriteria']; ?>" class="form-control" id="inputAddress" placeholder="Nama Kriteria">
                        </div>
                        <div class="col-12">
                            <label for="exampleFormControlTextarea1" class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" id="exampleFormControlTextarea1" rows="3"><?= (old('deskripsi')) ? old('deskripsi') : $datakriteria['deskripsi']; ?></textarea>
                        </div>
                        <div class="col-12">
                            <label for="bobot" class="form-label">Bobot</label>
                            <input type="text" name="bobot" value="<?= (old('bobot')) ? old('bobot') : $datakriteria['bobot']; ?>" class="form-control" id="inputAddress" placeholder="Bobot">
                        </div>
                        <div class="col-12">
                            <label for="sifat" class="form-label">Sifat</label>
                            <input type="text" name="sifat" value="<?= (old('sifat')) ? old('sifat') : $datakriteria['sifat']; ?>" class="form-control" id="inputAddress" placeholder="Sifat">
                        </div>
                        <div class="col-12 mt-5">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="/data-kriteria" class="btn btn-warning  float-right">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>