<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Lomba Go Green</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="<?= base_url(); ?>/assets/favicon.ico" />
    <!-- Bootstrap Icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
    <!-- SimpleLightbox plugin CSS-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-2"><img src="<?= base_url(); ?>/img/logo-madiun.png" class="mt-3" alt="" width="180px"></div>
            <div class="col text-center">
                <p style="font-size: 25px; line-height:20px; margin-top:35px"><b>PEMERINTAH KOTA MADIUN</b></p>
                <p style="font-size: 25px;line-height:1px; letter-spacing: 2px"><b>DINAS LINGKUNGAN HIDUP</b></p>
                <p class="mt-n5" style="font-size: 14px;line-height:15px">Jl. Salak III Nomor 7A Madiun, Kode Pos : 63131, Jawa Timur<br>Telepon/Faks. (0351) 468876<br>Laman: https://dlh.madiunkota.go.id</p>
            </div>
            <div class="col-2"></div>
        </div>
        <hr class="border border-dark border-2 opacity-100">
        <h5 class="text-center mb-5">Hasil Perhitungan</h5>
        <table class="table table-bordered border-dark mt-5" style="width:100%">
            <thead>
                <tr>
                    <th>
                        <center>Ranking</center>
                    </th>
                    <th>
                        <center>Kelurahan</center>
                    </th>
                    <th>
                        <center>Nilai</center>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($preferensi as $p) : ?>
                    <tr>
                        <td>
                            <center><?= $no++ ?></center>
                        </td>
                        <td><?= $p['nama_alternatif']; ?></td>
                        <td>
                            <center><?= $p['nilai']; ?></center>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>

        </table>
    </div>

    <script>
        window.print();
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>