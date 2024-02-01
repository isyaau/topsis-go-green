<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Pengeluaran</h1>
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
                    <h6 class="m-0 font-weight-bold text-primary">Edit Data</h6>
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
                    <form class="row g-3" action="/data-pengeluaran/update/<?= $datapengeluaran['id_pengeluaran']; ?>" method="post" enctype="multipart/form-data">
                        <div class="col-12">
                            <label for="nama_pengeluaran" class="form-label">Nama Pengeluaran</label>
                            <input type="text" name="nama_pengeluaran" value="<?= (old('nama_pengeluaran')) ? old('nama_pengeluaran') : $datapengeluaran['nama_pengeluaran']; ?>" class="form-control" id="inputAddress" placeholder="Nama Pengeluaran">
                        </div>
                        <div class="col-12">
                            <label for="jumlah" class="form-label">Jumlah Pengeluaran (Rp)</label>
                            <input type="text" name="jumlah" value="<?= (old('jumlah')) ? old('jumlah') : $datapengeluaran['jumlah']; ?>" class="form-control" id="inputAddress" placeholder="Jumlah">
                        </div>
                        <div class="col-12 mt-5">
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="/data-pengeluaran" class="btn btn-warning  float-right">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>