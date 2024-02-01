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
                    <h6 class="m-0 font-weight-bold text-primary">Nila Matrix Ideal Positif/Negatif</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!-- Matriks Ideal Positif (A+) -->
                    <div class="box-header">
                        <h3 class="box-title">Matriks Ideal Positif (A<sup>+</sup>)</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th colspan="<?= $h ?>">
                                        <center>Kriteria</center>
                                    </th>
                                </tr>
                                <tr>
                                    <?php foreach ($kriteria as $k) : ?>
                                        <th>
                                            <center><?= $k['nama_kriteria'] ?></center>
                                        </th>
                                    <?php endforeach; ?>
                                </tr>
                                <tr>

                                    <?php for ($n = 1; $n <= $h; $n++) : ?>
                                        <th>
                                            <center>y<sub><?= $n ?></sub><sup>+</sup></center>
                                        </th>
                                    <?php endfor; ?>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php foreach ($kriteria as $da) : ?>
                                        <?php
                                        $idalt = $da['id_kriteria'];

                                        $n = $matrixmodel->getKriteriaMatrix($idalt);

                                        $c = 0;
                                        $ymax = [];
                                        $nbot = $kriteriamodel->getKriteria($idalt); // Definisikan $nbot di sini

                                        foreach ($n as $dn) {
                                            $idk = $dn['id_kriteria'];

                                            $nilai_kuadrat = 0;
                                            $k = $matrixmodel->getKriteriaMatrix($idk);

                                            foreach ($k as $dkuadrat) {
                                                $nilai_kuadrat += ($dkuadrat['nilai'] * $dkuadrat['nilai']);
                                            }

                                            $jml_alternatif = count($alternatifmodel->getAlternatif());

                                            $bobot = 0;
                                            $tnilai = 0;

                                            foreach ($k as $dbobot) {
                                                $tnilai += $dbobot['nilai'];
                                            }

                                            $bobot = $tnilai / $jml_alternatif;

                                            $nbot = $kriteriamodel->getKriteria($idk);
                                            $bot = $nbot['bobot'];

                                            $v = round(($dn['nilai'] / sqrt($nilai_kuadrat)) * $bot, 4);

                                            $ymax[$c] = $v;
                                            $c++;
                                        }

                                        if (!empty($ymax)) {
                                            if ($nbot['sifat'] == 'benefit') {
                                                echo "<td><center>" . max($ymax) . "</center></td>";
                                            } else {
                                                echo "<td><center>" . min($ymax) . "</center></td>";
                                            }
                                        } else {
                                            echo "<td><center>Undefined</center></td>";
                                        }
                                        ?>
                                    <?php endforeach; ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Matriks Ideal Negatif (A-) -->
                    <div class="box-header mt-5">
                        <h3 class="box-title">Matriks Ideal Negatif (A<sup>-</sup>)</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th colspan="<?= $h ?>">
                                        <center>Kriteria</center>
                                    </th>
                                </tr>
                                <tr>
                                    <?php foreach ($kriteria as $k) : ?>
                                        <th>
                                            <center><?= $k['nama_kriteria'] ?></center>
                                        </th>
                                    <?php endforeach; ?>
                                </tr>
                                <tr>
                                    <?php for ($n = 1; $n <= $h; $n++) : ?>
                                        <th>
                                            <center>y<sub><?= $n ?></sub><sup>-</sup>
                                            </center>
                                        </th>
                                    <?php endfor; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php foreach ($kriteria as $da) : ?>
                                        <?php
                                        $idalt = $da['id_kriteria'];

                                        $n = $matrixmodel->getKriteriaMatrix($idalt);

                                        $c = 0;
                                        $ymax = [];
                                        $nbot = $kriteriamodel->getKriteria($idalt); // Definisikan $nbot di sini

                                        foreach ($n as $dn) {
                                            $idk = $dn['id_kriteria'];

                                            $nilai_kuadrat = 0;
                                            $k = $matrixmodel->getKriteriaMatrix($idk);

                                            foreach ($k as $dkuadrat) {
                                                $nilai_kuadrat += ($dkuadrat['nilai'] * $dkuadrat['nilai']);
                                            }

                                            $jml_alternatif = count($alternatifmodel->getAlternatif());

                                            $bobot = 0;
                                            $tnilai = 0;

                                            foreach ($k as $dbobot) {
                                                $tnilai += $dbobot['nilai'];
                                            }

                                            $bobot = $tnilai / $jml_alternatif;

                                            $nbot = $kriteriamodel->getKriteria($idk);
                                            $bot = $nbot['bobot'];

                                            $v = round(($dn['nilai'] / sqrt($nilai_kuadrat)) * $bot, 4);

                                            $ymax[$c] = $v;
                                            $c++;
                                        }

                                        if (!empty($ymax)) {
                                            if ($nbot['sifat'] == 'cost') {
                                                echo "<td><center>" . max($ymax) . "<center></td>";
                                            } else {
                                                echo "<td><center>" . min($ymax) . "<center></td>";
                                            }
                                        } else {
                                            echo "<td><center>Undefined<center></td>";
                                        }
                                        ?>
                                    <?php endforeach; ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection(); ?>