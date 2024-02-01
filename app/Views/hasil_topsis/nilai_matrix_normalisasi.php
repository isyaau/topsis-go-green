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
                    <h6 class="m-0 font-weight-bold text-primary">Nilai Matrix Ternormalisasi</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <h4>Nilai Matrix Ternormalisasi</h4>
                    <p>Nilai matrix yang telah ternormalisasi akan ditampilkan pada tebel dibawah ini </p>
                    <div class="table-responsive">
                        <table class="table" style="width:100%" align="center">
                            <thead>
                                <tr>
                                    <th rowspan="2">
                                        <center>No</center>
                                    </th>
                                    <th rowspan="2">
                                        <center>Nama</center>
                                    </th>
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
                                <?php foreach ($alternatif as $index => $alt) : ?>
                                    <tr>
                                        <td>
                                            <center><?= $index + 1 ?></center>
                                        </td>
                                        <td><?= $alt['nama_alternatif'] ?></td>
                                        <?php foreach ($kriteria as $k) : ?>
                                            <?php
                                            $nilai_kuadrat = 0;

                                            $nilai_matrik = $db->table('nilai_matrix')
                                                ->where('id_alternatif', $alt['id_alternatif'])
                                                ->where('id_kriteria', $k['id_kriteria'])
                                                ->get()
                                                ->getRow();

                                            $nilai_matrik_all = $db->table('nilai_matrix')
                                                ->where('id_kriteria', $k['id_kriteria'])
                                                ->get()
                                                ->getResult();

                                            foreach ($nilai_matrik_all as $row) {
                                                $nilai_kuadrat += $row->nilai * $row->nilai;
                                            }
                                            ?>
                                            <?php $alertShown = false;
                                            try { ?>
                                                <td align='center'><?= round($nilai_matrik->nilai / sqrt($nilai_kuadrat), 3) ?></td>

                                                <?php } catch (Exception $e) {
                                                if (!$alertShown) {
                                                    // Tandai bahwa pesan alert sudah ditampilkan
                                                    $alertShown = true;

                                                    // Tampilkan pesan alert
                                                ?>
                                                    <div class="alert alert-warning" role="alert">
                                                        Data Kosong!
                                                    </div>
                                            <?php }
                                            } ?>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection(); ?>