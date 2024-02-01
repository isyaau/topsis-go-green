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
                    <h6 class="m-0 font-weight-bold text-primary">Jarak Solusi Ideal Matrix Positif/Negatif</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <?php
                    $hasil = $joinmatrix;
                    if ($hasil == false) {  ?>
                        <p>eror</p>
                    <?php } else { ?>
                        <div class="box-header">
                            <h3 class="box-title">Jarak Solusi Ideal Positif (D<sup>+</sup>)</h3>
                        </div>

                        <table id="example" class="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 80px;">
                                        <center>Nomor</center>
                                    </th>
                                    <th>
                                        <center>Nama</center>
                                    </th>
                                    <th>
                                        <center>D<sup>+</sup></center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $k21 = \Config\Database::connect(); // Your database connection here;

                                $i2 = 1;
                                $i3 = 0;
                                $maxarray = [];
                                $a2 = $k21->query("SELECT * FROM kriteria ORDER BY id_kriteria ASC")->getResultArray();
                                echo "<tr>";

                                foreach ($a2 as $da2) {
                                    $idalt2 = $da2['id_kriteria'];

                                    $n2 = $k21->query("SELECT * FROM nilai_matrix WHERE id_kriteria='$idalt2' ORDER BY id_matrix ASC")->getResultArray();
                                    $jarakp2 = 0;
                                    $c2 = 0;
                                    $ymax2 = [];

                                    foreach ($n2 as $dn2) {
                                        $idk2 = $dn2['id_kriteria'];

                                        $nilai_kuadrat2 = 0;
                                        $k2 = $k21->query("SELECT * FROM nilai_matrix WHERE id_kriteria='$idk2' ORDER BY id_matrix ASC")->getResultArray();

                                        foreach ($k2 as $dkuadrat2) {
                                            $nilai_kuadrat2 += ($dkuadrat2['nilai'] * $dkuadrat2['nilai']);
                                        }

                                        $jml_alternatif2 = $k21->query("SELECT * FROM alternatif");
                                        $jml_a2 = $jml_alternatif2->getNumRows();

                                        $bobot2 = 0;
                                        $tnilai2 = 0;

                                        $k22 = $k21->query("SELECT * FROM nilai_matrix WHERE id_kriteria='$idk2' ORDER BY id_matrix ASC")->getResultArray();

                                        foreach ($k22 as $dbobot2) {
                                            $tnilai2 += $dbobot2['nilai'];
                                        }

                                        $bobot2 = $tnilai2 / $jml_a2;

                                        $b2 = $k21->query("SELECT * FROM kriteria WHERE id_kriteria='$idk2'");
                                        $nbot2 = $b2->getRowArray();
                                        $bot2 = $nbot2['bobot'];

                                        $v2 = round(($dn2['nilai'] / sqrt($nilai_kuadrat2)) * $bot2, 4);

                                        $ymax2[$c2] = $v2;
                                        $c2++;

                                        if ($nbot2['sifat'] == 'benefit') {
                                            $mak2 = max($ymax2);
                                        } else {
                                            $mak2 = min($ymax2);
                                        }
                                    }

                                    foreach ($ymax2 as $nymax2) {
                                        $jarakp2 += pow($nymax2 - $mak2, 2);
                                    }

                                    $maxarray[$i3] = $mak2;

                                    // print_r($maxarray);
                                    $i2++;
                                    $i3++;
                                }

                                // Store $maxarray in session
                                session()->set('ymax', $maxarray);

                                // Array Baris

                                $k21 = \Config\Database::connect(); // Your database connection here

                                $i = 1;
                                $ii = 0;
                                $dpreferensi = [];
                                $a = $k21->query("SELECT * FROM alternatif ORDER BY id_alternatif ASC")->getResultArray();
                                echo "<tr>";

                                while ($da = current($a)) {
                                    $idalt = $da['id_alternatif'];

                                    $n = $k21->query("SELECT * FROM nilai_matrix WHERE id_alternatif='$idalt' ORDER BY id_matrix ASC")->getResultArray();
                                    $jarakp = 0;
                                    $c = 0;
                                    $ymax = [];
                                    $arraymaks = [];

                                    foreach ($n as $dn) {
                                        $idk = $dn['id_kriteria'];
                                        // print_r($idk);
                                        $nilai_kuadrat = 0;
                                        $k = $k21->query("SELECT * FROM nilai_matrix WHERE id_kriteria='$idk' ORDER BY id_matrix ASC")->getResultArray();

                                        foreach ($k as $dkuadrat) {
                                            $nilai_kuadrat += ($dkuadrat['nilai'] * $dkuadrat['nilai']);
                                        }

                                        $jml_alternatif = $k21->query("SELECT * FROM alternatif ORDER BY id_alternatif ASC");
                                        $jml_a = $jml_alternatif->getNumRows();

                                        $bobot = 0;
                                        $tnilai = 0;

                                        $k2 = $k21->query("SELECT * FROM nilai_matrix WHERE id_kriteria='$idk' ORDER BY id_matrix ASC")->getResultArray();

                                        foreach ($k2 as $dbobot) {
                                            $tnilai += $dbobot['nilai'];
                                        }

                                        $bobot = $tnilai / $jml_a;

                                        $b2 = $k21->query("SELECT * FROM kriteria WHERE id_kriteria='$idk'");
                                        $nbot = $b2->getRowArray();
                                        $bot = $nbot['bobot'];

                                        $v = round(($dn['nilai'] / sqrt($nilai_kuadrat)) * $bot, 4);

                                        $ymax[$c] = $v;
                                        // print_r($ymax);
                                        $c++;
                                        $mak = max($ymax);
                                    }

                                    foreach ($ymax as $nymax => $value) {
                                        $maks = session()->get('ymax')[$nymax];
                                        // print_r($maks);
                                        // echo $maks . " - ";
                                        $final = sqrt($jarakp = $jarakp + pow($value - $maks, 2));
                                    }

                                    echo "<tr>
                                <td><center>$i</center></td>
                                <td><center>{$da['nama_alternatif']}</center></td>
                                <td><center>" . round($final, 4) . "</center></td>
                                </tr>";

                                    $dpreferensi[$ii] = round($final, 4);
                                    session()->set('dplus', $dpreferensi);

                                    $i++;
                                    $ii++;
                                    next($a);
                                } ?>
                            </tbody>
                        </table>

                        <!-- Tampilkan nilai DMIN -->


                        <div class="mt-5">
                            <h3 class="box-title ">Jarak Solusi Ideal Negatif (D<sup>-</sup>)</h3>
                        </div>

                        <table id="example" class="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 80px;">
                                        <center>Nomor</center>
                                    </th>
                                    <th>
                                        <center>Nama</center>
                                    </th>
                                    <th>
                                        <center>D<sup>-</sup></center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                //buat array kolom

                                $k21 = \Config\Database::connect(); // Your database connection here;

                                $i2 = 1;
                                $i3 = 0;
                                $minarray = [];
                                $a2 = $k21->query("SELECT * FROM kriteria ORDER BY id_kriteria ASC")->getResultArray();
                                echo "<tr>";

                                while ($da2 = current($a2)) {
                                    $idalt2 = $da2['id_kriteria'];

                                    $n2 = $k21->query("SELECT * FROM nilai_matrix WHERE id_kriteria='$idalt2' ORDER BY id_matrix ASC")->getResultArray();
                                    $jarakp2 = 0;
                                    $c2 = 0;
                                    $ymin2 = [];

                                    foreach ($n2 as $dn2) {
                                        $idk2 = $dn2['id_kriteria'];

                                        $nilai_kuadrat2 = 0;
                                        $k2 = $k21->query("SELECT * FROM nilai_matrix WHERE id_kriteria='$idk2' ORDER BY id_matrix ASC")->getResultArray();

                                        foreach ($k2 as $dkuadrat2) {
                                            $nilai_kuadrat2 += ($dkuadrat2['nilai'] * $dkuadrat2['nilai']);
                                        }

                                        $jml_alternatif2 = $k21->query("SELECT * FROM alternatif ORDER BY id_alternatif ASC");
                                        $jml_a2 = $jml_alternatif2->getNumRows();

                                        $bobot2 = 0;
                                        $tnilai2 = 0;

                                        $k22 = $k21->query("SELECT * FROM nilai_matrix WHERE id_kriteria='$idk2' ORDER BY id_matrix ASC")->getResultArray();

                                        foreach ($k22 as $dbobot2) {
                                            $tnilai2 += $dbobot2['nilai'];
                                        }

                                        $bobot2 = $tnilai2 / $jml_a2;

                                        $b2 = $k21->query("SELECT * FROM kriteria WHERE id_kriteria='$idk2'");
                                        $nbot2 = $b2->getRowArray();
                                        $bot2 = $nbot2['bobot'];

                                        $v2 = round(($dn2['nilai'] / sqrt($nilai_kuadrat2)) * $bot2, 4);

                                        $ymin2[$c2] = $v2;
                                        $c2++;

                                        if ($nbot2['sifat'] == 'cost') {
                                            $min2 = max($ymin2);
                                        } else {
                                            $min2 = min($ymin2);
                                        }
                                    }

                                    foreach ($ymin2 as $nymin2) {
                                        $jarakp2 += pow($nymin2 - $min2, 2);
                                    }

                                    $minarray[$i3] = $min2;
                                    // print_r($minarray);
                                    $i2++;
                                    $i3++;
                                    next($a2);
                                }

                                session()->set('ymin', $minarray);

                                //array baris//////////////////////////////////////////////////
                                $db = \Config\Database::connect(); // Koneksi database

                                $i = 1;
                                $ii = 0;
                                $id_alt = [];

                                $alternatif = $db->query("SELECT * FROM alternatif ORDER BY id_alternatif ASC")->getResultArray();
                                echo "<tr>";

                                foreach ($alternatif as $da) {
                                    $idalt = $da['id_alternatif'];

                                    // Ambil nilai
                                    $nilai = $db->query("SELECT * FROM nilai_matrix WHERE id_alternatif='$idalt' ORDER BY id_matrix ASC")->getResultArray();

                                    $jarakp = 0;
                                    $c = 0;
                                    $ymax = [];
                                    $arraymin = [];

                                    foreach ($nilai as $dn) {
                                        $idk = $dn['id_kriteria'];

                                        // Nilai kuadrat
                                        $nilai_kuadrat = 0;
                                        $kuadrat = $db->query("SELECT * FROM nilai_matrix WHERE id_kriteria='$idk' ORDER BY id_matrix ASC")->getResultArray();

                                        foreach ($kuadrat as $dkuadrat) {
                                            $nilai_kuadrat += ($dkuadrat['nilai'] * $dkuadrat['nilai']);
                                        }

                                        // Hitung jumlah alternatif
                                        $jml_alternatif = $db->query("SELECT * FROM alternatif ORDER BY id_alternatif ASC")->getNumRows();
                                        $jml_a = $jml_alternatif;

                                        // Nilai bobot kriteria (rata-rata)
                                        $bobot = 0;
                                        $tnilai = 0;
                                        $bobotModel = $db->query("SELECT * FROM nilai_matrix WHERE id_kriteria='$idk' ORDER BY id_matrix ASC")->getResultArray();

                                        foreach ($bobotModel as $dbobot) {
                                            $tnilai += $dbobot['nilai'];
                                        }

                                        $bobot = $tnilai / $jml_a;

                                        // Nilai bobot input
                                        $b2 = $db->query("SELECT * FROM kriteria WHERE id_kriteria='$idk'")->getRowArray();
                                        $bot = $b2['bobot'];

                                        $v = round(($dn['nilai'] / sqrt($nilai_kuadrat)) * $bot, 4);

                                        $ymin[$c] = $v;
                                        $c++;
                                        $min = max($ymin);
                                    }

                                    // Hitung D+
                                    foreach ($ymin as $nymin => $value) {
                                        $mins = session()->get('ymin')[$nymin];
                                        // echo $mins . " - ";
                                        $final = sqrt($jarakp = $jarakp + pow($value - $mins, 2));
                                    }

                                    echo "<tr>
                <td><center>$i</center></td>
                <td><center>{$da['nama_alternatif']}</center></td>
                <td><center>" . round($final, 4) . "</center></td>
                </tr>";

                                    // Session min
                                    $dpreferensi[$ii] = round($final, 4);
                                    session()->set('dmin', $dpreferensi);

                                    // Ambil id alternatif
                                    $id_alt[$ii] = $da['id_alternatif'];
                                    session()->set('id_alt', $id_alt);

                                    $i++;
                                    $ii++;
                                }
                                ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>



<?= $this->endSection(); ?>