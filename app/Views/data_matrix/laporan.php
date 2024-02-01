<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Pengeluaran</h1>
        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('pesan'); ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Content Row -->

    <div class="row">

        <!-- Area Data -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Laporan Pengeluaran</h6>


                </div>
                <!-- Card Body -->
                <div class="card-body text-center">
                    <h5>Laporan Bulanan Pengeluaran Rental Mobil</h5>
                    <p>Silahkan pilih bulan laporan pengeluaran rental mobil</p>
                    <br>
                    <div class="d-flex justify-content-center mb-5">
                        <form action="/laporan-pengeluaran/bulan" method="post">
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <label for="inputPassword6" class="col-form-label">Pilih Bulan</label>
                                </div>
                                <div class="col-auto">
                                    <select name="bulan" class="form-select" aria-label="Default select example">
                                        <option selected>Pilih . . .</option>
                                        <option value="1">Januari</option>
                                        <option value="2">Februari</option>
                                        <option value="3">Maret</option>
                                        <option value="4">April</option>
                                        <option value="5">Mei</option>
                                        <option value="6">Juni</option>
                                        <option value="7">Juli</option>
                                        <option value="8">Agustus</option>
                                        <option value="9">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                    <input type="hidden" name="tahun" value="<?= date('Y'); ?>">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </div>
                        </form>

                    </div>
                    <hr>
                    <h5>Laporan Tahunan Pengeluaran Rental Mobil</h5>
                    <p>Silahkan pilih tahun laporan pengeluaran rental mobil</p>
                    <br>
                    <div class="d-flex justify-content-center mb-5">
                        <form action="/laporan-pengeluaran/tahun" method="post">
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <label for="inputPassword6" class="col-form-label">Pilih Tahun</label>
                                </div>
                                <div class="col-auto">
                                    <select name="tahun" class="form-select" aria-label="Default select example">
                                        <option selected>Pilih . . .</option>
                                        <?php $tahun = date('Y');
                                        for ($i = 2015; $i <= $tahun; $i++) { ?>
                                            <option value="<?= $i; ?>"><?= $i; ?></option>
                                        <?php } ?>

                                    </select>
                                    <input type="hidden" name="tahun" value="<?= date('Y'); ?>">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
<?= $this->endSection(); ?>