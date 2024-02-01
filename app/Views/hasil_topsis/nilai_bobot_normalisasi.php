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
                    <h6 class="m-0 font-weight-bold text-primary">Nilai Bobot Ternormalisasi</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <h4>Nilai Bobot Ternormalisasi</h4>
                    <p>Nilai bobot yang sudah ternormalisasi akan ditampilkan pada tabel dibawah ini</p>
                    <div class="table-responsive">
                        <table class="table" style="width:100%">
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

                                <?php
                                $i = 0;
                                foreach ($alternatif as $da) :
                                    $idalt = $da['id_alternatif'];
                                ?>
                                    <tr>
                                        <td>
                                            <center><?= ++$i; ?></center>
                                        </td>
                                        <td><?= $da['nama_alternatif']; ?></td>
                                        <?php
                                        $nilai_kuadrat = 0;
                                        foreach ($matrixmodel->getAlternatifMatrix($idalt) as $dn) :
                                            $idk = $dn['id_kriteria'];

                                            $nilai_kuadrat = 0;
                                            foreach ($matrixmodel->getKriteriaMatrix($idk) as $dkuadrat) {
                                                $nilai_kuadrat += ($dkuadrat['nilai'] * $dkuadrat['nilai']);
                                            }

                                            $jml_alternatif = count($alternatif);
                                            $bobot = 0;
                                            $tnilai = 0;
                                            foreach ($matrixmodel->getKriteriaMatrix($idk) as $dbobot) {
                                                $tnilai += $dbobot['nilai'];
                                            }
                                            $bobot = $tnilai / $jml_alternatif;

                                            $b2 = $kriteriamodel->getKriteria($idk);
                                            $nbot = $b2['bobot'];
                                        ?>
                                            <?php if ($dn['nilai'] === null) { ?>
                                                <div class="alert alert-warning d-flex align-items-center" role="alert">
                                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:">
                                                        <use xlink:href="#exclamation-triangle-fill" />
                                                    </svg>
                                                    <div>
                                                        An example warning alert with an icon
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <td align='center'><?= round(($dn['nilai'] / sqrt($nilai_kuadrat)) * $nbot, 3); ?></td>
                                            <?php } ?>
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