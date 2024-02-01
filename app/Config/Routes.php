<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Dashboard');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Dashboard::index', ['filter' => 'role:administrator, user']);
$routes->get('/', 'Landing::index');
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'role:administrator, user']);

// Data Alternatif
$routes->get('/data-alternatif', 'DataAlternatif::index', ['filter' => 'auth']);
$routes->get('/data-alternatif/edit/(:num)', 'DataAlternatif::edit/$1', ['filter' => 'auth']);
$routes->get('/data-alternatif/detail/(:num)', 'DataAlternatif::detail/$1', ['filter' => 'auth']);
$routes->post('/data-alternatif/save', 'DataAlternatif::save', ['filter' => 'auth']);
$routes->post('/data-alternatif/update', 'DataAlternatif::update', ['filter' => 'auth']);
$routes->post('/data-alternatif/update/(:num)', 'DataAlternatif::update/$1', ['filter' => 'auth']);
$routes->delete('/data-alternatif/(:num)', 'DataAlternatif::delete/$1', ['filter' => 'auth']);

// Data Kriteria
$routes->get('/data-kriteria', 'DataKriteria::index', ['filter' => 'auth']);
$routes->post('/data-kriteria/save', 'DataKriteria::save', ['filter' => 'auth']);
$routes->delete('/data-kriteria/(:num)', 'DataKriteria::delete/$1', ['filter' => 'auth']);
$routes->get('/data-kriteria/edit/(:num)', 'DataKriteria::edit/$1', ['filter' => 'auth']);
$routes->get('/data-kriteria/detail/(:num)', 'DataKriteria::detail/$1', ['filter' => 'auth']);
$routes->post('/data-kriteria/update/(:num)', 'DataKriteria::update/$1', ['filter' => 'auth']);
$routes->get('/data-kriteria/detail/(:num)', 'DataKriteria::detail/$1', ['filter' => 'auth']);

// Data Matrix
$routes->get('/data-matrix', 'DataMatrix::index', ['filter' => 'auth']);
$routes->post('/data-matrix/save', 'DataMatrix::save', ['filter' => 'auth']);
$routes->delete('/data-matrix/(:num)', 'DataMatrix::delete/$1', ['filter' => 'auth']);
$routes->get('/data-matrix/edit/(:num)', 'DataMatrix::edit/$1', ['filter' => 'auth']);
$routes->post('/data-matrix/update/(:num)', 'DataMatrix::update/$1', ['filter' => 'auth']);
$routes->get('/data-matrix/detail/(:num)', 'DataMatrix::detail/$1', ['filter' => 'auth']);
$routes->get('/data-matrix/create/(:num)', 'DataMatrix::create/$1', ['filter' => 'auth']);
$routes->get('/laporan-matrix', 'DataMatrix::laporan', ['filter' => 'auth']);
$routes->add('/laporan-matrix/bulan', 'DataMatrix::laporanBulan', ['filter' => 'auth']);
$routes->add('/laporan-matrix/tahun', 'DataMatrix::laporanTahun', ['filter' => 'auth']);

// Hasil Topsis
$routes->get('/hasil-topsis/nilai-matrix', 'DataHasil::NilaiMatrix', ['filter' => 'auth']);
$routes->get('/hasil-topsis/nilai-matrix-ternormalisasi', 'DataHasil::normalisasi', ['filter' => 'auth']);
$routes->get('/hasil-topsis/nilai-bobot-ternormalisasi', 'DataHasil::bobot', ['filter' => 'auth']);
$routes->get('/hasil-topsis/matrix-ideal-positif-negatif', 'DataHasil::ideal', ['filter' => 'auth']);
$routes->get('/hasil-topsis/jarak-ideal-positif-negatif', 'DataHasil::jarak', ['filter' => 'auth']);
$routes->get('/hasil-topsis/nilai-preferensi', 'DataHasil::preferensi', ['filter' => 'auth']);
$routes->get('/hasil-topsis/print', 'DataHasil::print');


// Data Pemesan 
$routes->get('/data-pemesan', 'DataPemesan::index', ['filter' => 'auth']);
$routes->post('/data-pemesan/save', 'DataPemesan::save', ['filter' => 'auth']);
$routes->delete('/data-pemesan/(:num)', 'DataPemesan::delete/$1', ['filter' => 'auth']);
$routes->get('/data-pemesan/edit/(:num)', 'DataPemesan::edit/$1', ['filter' => 'auth']);
$routes->post('/data-pemesan/update/(:num)', 'DataPemesan::update/$1', ['filter' => 'auth']);
$routes->get('/data-pemesan/setting/(:num)', 'DataPemesan::setting/$1', ['filter' => 'auth']);
$routes->post('/data-pemesan/upset/(:num)', 'DataPemesan::upset/$1', ['filter' => 'auth']);
$routes->get('/data-pemesan/detail/(:num)', 'DataPemesan::detail/$1', ['filter' => 'auth']);
$routes->post('/data-pemesan/activate', 'DataPemesan::activate', ['filter' => 'auth']);
$routes->post('/data-pemesan/changeGroup', 'DataPemesan::changeGroup', ['filter' => 'auth']);





//Keuntungan
$routes->add('/laporan-keuntungan/tahun', 'DataPesanan::laporanKeuntunganTahun', ['filter' => 'auth']);
$routes->add('/laporan-keuntungan/bulan', 'DataPesanan::laporanKeuntunganBulan', ['filter' => 'auth']);
$routes->get('/laporan-keuntungan', 'DataPesanan::laporanKeuntungan', ['filter' => 'auth']);

// Data Akun 
$routes->get('/data-akun', 'DataAkun::index', ['filter' => 'auth']);
$routes->post('/data-akun/save', 'DataAkun::save', ['filter' => 'auth']);
$routes->delete('/data-akun/(:num)', 'DataAkun::delete/$1', ['filter' => 'auth']);
$routes->get('/data-akun/edit/(:num)', 'DataAkun::edit/$1', ['filter' => 'auth']);
$routes->post('/data-akun/update/(:num)', 'DataAkun::update/$1', ['filter' => 'auth']);
$routes->get('/data-akun/detail/(:num)', 'DataAkun::detail/$1', ['filter' => 'auth']);
$routes->post('/data-akun/activate', 'DataAkun::activate', ['filter' => 'auth']);
$routes->post('/data-akun/changeGroup', 'DataAkun::changeGroup', ['filter' => 'auth']);

// $routes->get('/', 'Login::index');
// $routes->get('/logout', 'Login::logout');
// $routes->get('/register', 'Register::index');
// $routes->post('/register/save', 'Register::save');
// $routes->post('/login/auth', 'Login::auth');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
