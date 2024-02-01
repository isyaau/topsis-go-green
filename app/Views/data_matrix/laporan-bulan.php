<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/assets/css/style.css">

    <!-- Custom fonts for this template-->
    <link href="<?= base_url(); ?>/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <style>
        /* Kolom dengan display: none akan sepenuhnya dihilangkan dari tampilan */
        .hidden-column-display {
            display: none;
        }

        /* Kolom dengan visibility: hidden tetap memakan ruang, tetapi tidak terlihat */
        .hidden-column-visibility {
            visibility: hidden;
        }

        /* Styling tambahan untuk tampilan tabel */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
    </style>


    <!-- Custom styles for this template-->
    <link href="<?= base_url(); ?>/assets/css/sb-admin-2.min.css" rel="stylesheet">
    <title>Cetak Pengeluaran</title>
</head>

<body>
    <div class="container text-dark">
        <div class="container">
            <?php
            if ($bulan == 1) {
                $Bul = "Januari";
            } elseif ($bulan == 2) {
                $Bul = "Februari";
            } elseif ($bulan == 3) {
                $Bul = "Maret";
            } elseif ($bulan == 4) {
                $Bul = "April";
            } elseif ($bulan == 5) {
                $Bul = "Mei";
            } elseif ($bulan == 6) {
                $Bul = "Juni";
            } elseif ($bulan == 7) {
                $Bul = "Juli";
            } elseif ($bulan == 8) {
                $Bul = "Agustus";
            } elseif ($bulan == 9) {
                $Bul = "September";
            } elseif ($bulan == 10) {
                $Bul = "Oktober";
            } elseif ($bulan == 11) {
                $Bul = "November";
            } elseif ($bulan == 12) {
                $Bul = "Desember";
            } else {
                $Bul = "Belum Dipilih";
            }
            ?>
            <div class="text-center my-5">
                <h3>Laporan Pengeluaran Rental Mobil</h3>
                <h5>Bulan <?= $Bul ? $Bul : "Belum Dipilih"; ?> Tahun <?= $tahun; ?></h5>
            </div>
        </div>

        <table class="table" id="tabelHarga" style="width:100%">
            <thead>
                <tr>
                    <th style="text-align: center;">No</th>
                    <th style="text-align: center;">Tanggal</th>
                    <th style="text-align: center;">Nama Pengeluaran</th>
                    <th style="text-align: center;">Jumlah Pengeluaran</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $no = 1;
                foreach ($pengeluaran as $p) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= date('d-m-Y', strtotime($p['created_at'])); ?></td>
                        <td><?= $p['nama_pengeluaran']; ?></td>
                        <td style="text-align: right;">Rp. <?= number_format($p['jumlah'], 2, ',', '.'); ?></td>
                    </tr>
                <?php endforeach ?>

            </tbody>
        </table>

    </div>
    <script>
        window.print();
    </script>
    <script>
        // Function to calculate the sum of the "Total" column
        function calculateTotalSum() {
            let totalSum = 0;
            const totalCells = document.querySelectorAll("#tabelHarga tbody td:last-child");

            totalCells.forEach(cell => {
                const totalValue = parseFloat(cell.innerText.replace(/[^\d.-]/g, ''));
                totalSum += totalValue;
            });

            return totalSum;
        }

        // Call the function to calculate the total sum
        const totalHargaSpan = document.getElementById("totalHarga");
        const totalSum = calculateTotalSum();
        totalHargaSpan.innerText = `Rp. ${numberWithCommas(totalSum.toFixed(2))}`;

        // Helper function to add thousand separators
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url(); ?>/assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url(); ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url(); ?>/assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url(); ?>/assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="<?= base_url(); ?>/assets/vendor/chart.js/Chart.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="<?= base_url(); ?>/assets/js/demo/chart-area-demo.js"></script>
    <script src="<?= base_url(); ?>/assets/js/demo/chart-pie-demo.js"></script>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
</body>

</html>