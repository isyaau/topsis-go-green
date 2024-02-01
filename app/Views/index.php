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
    <link href="<?= base_url(); ?>/assets/css/styles_landing.css" rel="stylesheet" />
</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#page-top">Lomba Go Green</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto my-2 my-lg-0">
                    <li class="nav-item"><a class="nav-link mt-2" href="#about">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link mt-2" href="#services">Kriteria</a></li>
                    <li class="nav-item"><a class="nav-link mt-2" href="#portfolio">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link mt-2" href="#contact">Hasil Penilaian</a></li>
                    <?php if (user() != null) { ?>
                        <li class="nav-item"><a class="btn btn-success" href="/dashboard">My Dashboard</a></li>
                    <?php } else { ?>
                        <li class="nav-item"><a class="btn btn-success" href="/dashboard">Login</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Masthead-->
    <header class="masthead">
        <div class="container px-4 px-lg-5 h-100">
            <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-8 align-self-end">
                    <h1 class="text-white font-weight-bold">GO GREEN AND CLEAN TINGKAT KOTA MADIUN</h1>
                    <hr class="divider" />
                </div>
                <div class="col-lg-8 align-self-baseline">
                    <p class="text-white-75 mb-5">Mari kita bersama-sama menjaga lingkungan kita dengan berpartisipasi dalam kegiatan GO GREEN AND CLEAN Tingkat Kota Madiun.</p>
                    <a class="btn btn-primary btn-xl" href="#about">Find Out More</a>
                </div>
            </div>
        </div>
    </header>
    <!-- About-->
    <section class="page-section bg-primary" id="about">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="text-white mt-0">Kami telah menemukan apa yang kamu cari tau!</h2>
                    <hr class="divider divider-light" />
                    <p class="text-white-75 mb-4">Kami senang mengabarkan bahwa kami telah menemukan yang kamu butuhkan yaitu informasi tentang kriteria penilaian lomba go green. Informasi ini penting untuk membantu kamu mempersiapkan proposal dan presentasi yang sesuai dengan tema dan tujuan lomba. Kami harap informasi ini bermanfaat dan semoga kamu berhasil dalam lomba go green.</p>
                    <a class="btn btn-light btn-xl" href="#services">Cek Kriteria Penilaian!</a>
                </div>
            </div>
        </div>
    </section>
    <!-- Services-->
    <section class="page-section" id="services">
        <div class="container px-4 px-lg-5">
            <h2 class="text-center mt-0">Kriteria Penilaian</h2>
            <hr class="divider" />
            <div class="row gx-4 gx-lg-5">
                <?php foreach ($kriteria as $k) : ?>
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="mt-5">
                            <div class="mb-2"><i class="bi-gem fs-1 text-primary"></i></div>
                            <h3 class="h4 mb-2"><?= $k['nama_kriteria']; ?></h3>
                            <p class="text-muted mb-0"><?= $k['deskripsi']; ?></p>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </section>
    <!-- Portfolio-->
    <div id="portfolio">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-lg-4 col-sm-6">
                    <a class="portfolio-box" href="<?= base_url(); ?>/assets/img/portfolio/fullsize/1.jpg" title="Lomba Go Green">
                        <img class="img-fluid" src="<?= base_url(); ?>/assets/img/portfolio/thumbnails/1.jpg" alt="..." />
                        <div class="portfolio-box-caption">
                            <div class="project-category text-white-50">Dokumentasi</div>
                            <div class="project-name">Lomba Go Green</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a class="portfolio-box" href="<?= base_url(); ?>/assets/img/portfolio/fullsize/2.jpg" title="Lomba Go Green">
                        <img class="img-fluid" src="<?= base_url(); ?>/assets/img/portfolio/thumbnails/2.jpg" alt="..." />
                        <div class="portfolio-box-caption">
                            <div class="project-category text-white-50">Dokumentasi</div>
                            <div class="project-name">Lomba Go Green</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a class="portfolio-box" href="<?= base_url(); ?>/assets/img/portfolio/fullsize/3.jpg" title="Lomba Go Green">
                        <img class="img-fluid" src="<?= base_url(); ?>/assets/img/portfolio/thumbnails/3.jpg" alt="..." />
                        <div class="portfolio-box-caption">
                            <div class="project-category text-white-50">Dokumentasi</div>
                            <div class="project-name">Lomba Go Green</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a class="portfolio-box" href="<?= base_url(); ?>/assets/img/portfolio/fullsize/4.jpg" title="Lomba Go Green">
                        <img class="img-fluid" src="<?= base_url(); ?>/assets/img/portfolio/thumbnails/4.jpg" alt="..." />
                        <div class="portfolio-box-caption">
                            <div class="project-category text-white-50">Dokumentasi</div>
                            <div class="project-name">Lomba Go Green</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a class="portfolio-box" href="<?= base_url(); ?>/assets/img/portfolio/fullsize/5.jpg" title="Lomba Go Green">
                        <img class="img-fluid" src="<?= base_url(); ?>/assets/img/portfolio/thumbnails/5.jpg" alt="..." />
                        <div class="portfolio-box-caption">
                            <div class="project-category text-white-50">Dokumentasi</div>
                            <div class="project-name">Lomba Go Green</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a class="portfolio-box" href="<?= base_url(); ?>/assets/img/portfolio/fullsize/6.jpg" title="Lomba Go Green">
                        <img class="img-fluid" src="<?= base_url(); ?>/assets/img/portfolio/thumbnails/6.jpg" alt="..." />
                        <div class="portfolio-box-caption p-3">
                            <div class="project-category text-white-50">Dokumentasi</div>
                            <div class="project-name">Lomba Go Green</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Call to action-->
    <section class="page-section bg-dark text-white">
        <div class="container px-4 px-lg-5 text-center">
            <h2 class="mb-4">Download Hasil Perolehan!</h2>
            <a class="btn btn-light btn-xl" href="/hasil-topsis/print" target="_blank">Unduh Sekarang!</a>
        </div>
    </section>
    <!-- Contact-->
    <section class="page-section" id="contact">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8 col-xl-6 text-center">
                    <h2 class="mt-0">Ayo Cek Kemenanganmu!</h2>
                    <hr class="divider" />
                    <p class="text-muted mb-5">Kamu siap untuk melihat hasil akhir dari perhitungan penilaian daerahmu!</p>
                </div>
            </div>
            <div class="row gx-4 gx-lg-5 justify-content-center mb-5">
                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Ranking Hasil Perhitungan</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <table class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Ranking</th>
                                        <th>Kelurahan</th>
                                        <th>Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($preferensi as $p) : ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $p['nama_alternatif']; ?></td>
                                            <td><?= $p['nilai']; ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-4 text-center mb-5 mb-lg-0">
                    <i class="bi-phone fs-2 mb-3 text-muted"></i>
                    <div>+(62) 8768686997</div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer-->
    <footer class="bg-light py-5">
        <div class="container px-4 px-lg-5">
            <div class="small text-center text-muted">Copyright &copy; 2024 - SPKL TOPSIS</div>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SimpleLightbox plugin JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
    <!-- Core theme JS-->
    <script src="<?= base_url(); ?>/assets/js/scripts_landing.js"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>