<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Hasil Topsis</h1>
        <?php if (session()->getFlashdata('pesan')) : ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('pesan'); ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Content Row -->

    <div class="row">
        <!-- Area Data -->
        <div class="col-xl-12 col-lg-9">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Nilai Matrix</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <h4>Nilai Matrix</h4>
                    <p>Perolehan Nilai akan ditampilkan pada menu ini</p>
                    <table class="table" style="width:100%">
                        <thead>
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Nama</th>
                                <th colspan="<?= $jml_kriteria; ?>">
                                    <center>Kriteria</center>
                                </th>
                            </tr>
                            <tr>
                                <?php for ($n = 1; $n <= $jml_kriteria; $n++) { ?>
                                    <th>
                                        <center>C<?= $n; ?></center>
                                    </th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($alternatif as $rw) {
                                $row = "row" . $rw['id_alternatif'];
                                echo $$row;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection(); ?>