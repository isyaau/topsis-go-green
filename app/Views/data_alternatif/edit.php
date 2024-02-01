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
                    <h6 class="m-0 font-weight-bold text-primary">Edit Data Alternatif</h6>
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
                    <form class="row g-3" action="/data-alternatif/update/<?= $dataalternatif['id_alternatif']; ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id_alternatif" value="<?= (old('id_alternatif')) ? old('id_alternatif') : $dataalternatif['id_alternatif']; ?>">
                        <div class="col-12">
                            <label for="nama_alternatif" class="form-label"> Nama Alternatif</label>
                            <input type="text" name="nama_alternatif" value="<?= (old('nama_alternatif')) ? old('nama_alternatif') : $dataalternatif['nama_alternatif']; ?>" class="form-control" id="inputAddress" placeholder="Nama alternatif">
                        </div>
                        <div class="col-6">
                            <label for="rt_a" class="form-label"> RT A</label>
                            <input type="text" name="rt_a" value="<?= (old('rt_a')) ? old('rt_a') : $dataalternatif['rt_a']; ?>" class="form-control" id="inputAddress">
                        </div>
                        <div class="col-6">
                            <label for="rt_b" class="form-label"> RT B</label>
                            <input type="text" name="rt_b" value="<?= (old('rt_b')) ? old('rt_b') : $dataalternatif['rt_b']; ?>" class="form-control" id="inputAddress">
                        </div>
                        <div class="col-12">
                            <label for="kecamatan" class="form-label"> Kecamatan</label>
                            <input type="text" name="kecamatan" value="<?= (old('kecamatan')) ? old('kecamatan') : $dataalternatif['kecamatan']; ?>" class="form-control" id="inputAddress">
                        </div>
                        <div class="col-12 mb-5">
                            <label for="kota" class="form-label"> Kota</label>
                            <input type="text" name="kota" value="<?= (old('kota')) ? old('kota') : $dataalternatif['kota']; ?>" class="form-control" id="inputAddress">
                        </div>
                        <div class="col-12 mt-5">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="/data-alternatif" class="btn btn-warning  float-right">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>