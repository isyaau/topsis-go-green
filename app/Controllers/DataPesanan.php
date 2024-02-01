<?php

namespace App\Controllers;

use CodeIgniter\Validation\Validation;
use CodeIgniter\Controller;
use \Myth\Auth\Models\UserModel;
use \Myth\Auth\Password;
use \Myth\Auth\Entities\User;
use \Myth\Auth\Authorization\GroupModel;


class DataPesanan extends BaseController
{
    public function index()
    {
        session();
        $groupModel = new GroupModel();
        if (user()->status == 1) {
            $pesanan = $this->datapesananModel->joinPesanan();
        } elseif (user()->status == 2) {
            $pesanan = $this->datapesananModel->joinPesananCust();
        }
        $mobil = $this->datamobilModel->getMobilStatus();
        $pemesan = $this->datapemesanModel;
        $perjalanan = $this->dataperjalananModel->where('id_perjalanan !=', 0);
        $bayar = $this->databayarModel->where('id_jenisbayar !=', 0);
        $data = [
            // 'session' => $session,
            // 'pesanan' => $pesanan->getPesanan(),
            'mobil' => $mobil->getMobil(),
            'pemesan' => $pemesan->where('id !=', 0)->getPemesan(),
            'perjalanan' => $perjalanan->getPerjalanan(),
            'bayar' => $bayar->getBayar(),
            'joinpesanan' => $pesanan,
            'active'  => 'pesanan',
            'role'  => $groupModel->getGroupsForUser(user()->id),
            // 'validation' => \Config\Services::validation()
        ];
        return view('data_pesanan/index', $data);
    }
    public function save()
    {
        if (!$this->validate([
            'id_pemesan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama pemesan harus diisi',
                ]
            ],
            'id_mobil' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama mobil harus diisi',
                ]
            ],
            'id_perjalanan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Perjalanan Harus diisi'

                ]
            ],
            'id_jenisbayar' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis Bayar harus diisi'
                ]
            ],
            'hari' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Hari Harus diisi'
                ]
            ],
            'tgl_pinjam' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tgl pinjam harus diisi'
                ]
            ],
            'tgl_kembali' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tgl kembali harus diisi'
                ]
            ]
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $this->datapesananModel->save([
            'id_pemesan' => $this->request->getVar('id_pemesan'),
            'id_mobil' => $this->request->getVar('id_mobil'),
            'id_perjalanan' => $this->request->getVar('id_perjalanan'),
            'id_jenisbayar' => $this->request->getVar('id_jenisbayar'),
            'hari' => $this->request->getVar('hari'),
            'tgl_pinjam' => $this->request->getVar('tgl_pinjam'),
            'tgl_kembali' => $this->request->getVar('tgl_kembali'),
            'proses' => $this->request->getVar('proses')
        ]);
        $proses = $this->request->getVar('proses');
        if ($proses == 2) {
            $this->datamobilModel->save([
                'id_mobil' => $this->request->getVar('id_mobil'),
                'status' => 0
            ]);
        }

        session()->setFlashdata('pesan', 'Tambah Data Pesanan Berhasil');
        return redirect()->to('/data-pesanan');
    }


    public function delete($id_pesanan)
    {

        $this->datapesananModel->delete($id_pesanan);
        $this->datamobilModel->save([
            'id_mobil' => $this->request->getVar('id_mobil'),
            'status' => 1
        ]);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus.');
        return redirect()->to('/data-pesanan');
    }

    public function edit($id_pesanan)
    {
        $datapesanan = $this->datapesananModel->getPesanan($id_pesanan);
        if (empty($datapesanan)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Mobil Tidak ditemukan !');
        }
        $groupModel = new GroupModel();
        $pesanan = $this->datapesananModel;
        $pemesan = $this->datapemesanModel;
        $perjalanan = $this->dataperjalananModel;
        $bayar = $this->databayarModel;
        $mobil = $this->datamobilModel->getMobilStatus();
        $data = [
            'title' => 'Ubah Data Pesanan| SIA',
            'active'  => 'pesanan',
            'mobil' => $mobil->getMobil(),
            'pemesan' => $pemesan->where('id !=', 0)->getPemesan(),
            'perjalanan' => $perjalanan->getPerjalanan(),
            'bayar' => $bayar->getBayar(),
            'joinpesanan' => $pesanan->joinPesanan($id_pesanan),
            'validation' => \Config\Services::validation(),
            'merk' => $this->datamerkModel->getMerk(),
            'role'  => $groupModel->getGroupsForUser(user()->id),
            'datapesanan' => $this->datapesananModel->getPesanan($id_pesanan)

        ];
        return view('data_pesanan/edit', $data);
    }

    public function update($id_pesanan)
    {
        if (!$this->validate([
            'id_pemesan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama pemesan harus diisi',
                ]
            ],
            'id_mobil' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama mobil harus diisi',
                ]
            ],
            'id_perjalanan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Perjalanan Harus diisi'

                ]
            ],
            'id_jenisbayar' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis Bayar harus diisi'
                ]
            ],
            'hari' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Hari Harus diisi'
                ]
            ],
            'tgl_pinjam' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tgl pinjam harus diisi'
                ]
            ],
            'tgl_kembali' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tgl kembali harus diisi'
                ]
            ]

        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $this->datapesananModel->save([
            'id_pesanan' => $id_pesanan,
            'id_pemesan' => $this->request->getVar('id_pemesan'),
            'id_mobil' => $this->request->getVar('id_mobil'),
            'id_perjalanan' => $this->request->getVar('id_perjalanan'),
            'id_jenisbayar' => $this->request->getVar('id_jenisbayar'),
            'hari' => $this->request->getVar('hari'),
            'tgl_pinjam' => $this->request->getVar('tgl_pinjam'),
            'tgl_kembali' => $this->request->getVar('tgl_kembali'),
            'proses' => $this->request->getVar('proses')

        ]);
        $proses = $this->request->getVar('proses');
        $mobilbaru = $this->request->getVar('id_mobil');
        $mobillama = $this->request->getVar('id_mobilLama');
        if ($proses == 0) {
            $this->datamobilModel->save([
                'id_mobil' => $this->request->getVar('id_mobil'),
                'status' => 1
            ]);
        }
        if ($proses == 2) {
            $this->datamobilModel->save([
                'id_mobil' => $this->request->getVar('id_mobil'),
                'status' => 1
            ]);
        }
        if ($proses == 1) {
            $this->datamobilModel->save([
                'id_mobil' => $this->request->getVar('id_mobil'),
                'status' => 0
            ]);
        }
        if ($proses == 0 && $mobilbaru != $mobillama) {
            $this->datamobilModel->save([
                'id_mobil' => $this->request->getVar('id_mobilLama'),
                'status' => 1
            ]);
            $this->datamobilModel->save([
                'id_mobil' => $this->request->getVar('id_mobil'),
                'status' => 1
            ]);
        }
        if ($proses == 1 && $mobilbaru != $mobillama) {
            $this->datamobilModel->save([
                'id_mobil' => $this->request->getVar('id_mobilLama'),
                'status' => 1
            ]);
            $this->datamobilModel->save([
                'id_mobil' => $this->request->getVar('id_mobil'),
                'status' => 0
            ]);
        }
        session()->setFlashdata('pesan', 'Ubah Data Pesanan Berhasil');
        return redirect()->to('/data-pesanan');
    }

    public function detail($id_pesanan)
    {

        $datapesanan = $this->datapesananModel->getPesanan($id_pesanan);
        if (empty($datapesanan)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Mobil Tidak ditemukan !');
        }

        $pesanan = $this->datapesananModel;
        $pemesan = $this->datapemesanModel;
        $perjalanan = $this->dataperjalananModel;
        $bayar = $this->databayarModel;
        $mobil = $this->datamobilModel;
        $data = [
            'title' => 'Ubah Data Pesanan| SIA',
            'active'  => 'pesanan',
            'mobil' => $mobil->getMobil(),
            'pemesan' => $pemesan->getPemesan(),
            'perjalanan' => $perjalanan->getPerjalanan(),
            'bayar' => $bayar->getBayar(),
            'joinpesanan' => $pesanan->joinPesanan($id_pesanan),
            'validation' => \Config\Services::validation(),
            'merk' => $this->datamerkModel->getMerk(),
            'role' => $this->groups->getGroupsForUser(user()->id),
            'datapesanan' => $this->datapesananModel->getPesanan($id_pesanan)

        ];
        return view('data_pesanan/detail', $data);
    }


    public function print($id_pesanan)
    {

        $datapesanan = $this->datapesananModel->getPesanan($id_pesanan);
        if (empty($datapesanan)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Mobil Tidak ditemukan !');
        }

        $pesanan = $this->datapesananModel;
        $pemesan = $this->datapemesanModel;
        $perjalanan = $this->dataperjalananModel->where('id_perjalanan !=', 0);
        $bayar = $this->databayarModel->where('id_jenisbayar !=', 0);
        $mobil = $this->datamobilModel;
        $data = [
            'title' => 'Ubah Data Pesanan| SIA',
            'active'  => 'pesanan',
            'mobil' => $mobil->getMobil(),
            'pemesan' => $pemesan->getPemesan(),
            'perjalanan' => $perjalanan->getPerjalanan(),
            'bayar' => $bayar->getBayar(),
            'joinpesanan' => $pesanan->joinPesanan($id_pesanan),
            'validation' => \Config\Services::validation(),
            'merk' => $this->datamerkModel->getMerk(),
            'role' => $this->groups->getGroupsForUser(user()->id),
            'datapesanan' => $this->datapesananModel->getPesanan($id_pesanan)

        ];
        return view('data_pesanan/print', $data);
    }

    public function laporan()
    {
        session();
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
        $groupModel = new GroupModel();
        if (user()->status == 1) {
            $pesanan = $this->datapesananModel->joinPesananLap($bulan, $tahun);
        } elseif (user()->status == 2) {
            $pesanan = $this->datapesananModel->joinPesananCust();
        }
        $mobil = $this->datamobilModel->getMobilStatus();
        $mobilAll = $this->datamobilModel;
        $pemesan = $this->datapemesanModel;
        $perjalanan = $this->dataperjalananModel->where('id_perjalanan !=', 0);
        $bayar = $this->databayarModel->where('id_jenisbayar !=', 0);
        $sumharga = $this->datapesananModel->joinPesananLapSum($bulan, $tahun);
        $data = [
            // 'session' => $session,
            // 'pesanan' => $pesanan->getPesanan(),
            'mobil' => $mobil->getMobil(),
            'bulan' => $bulan,
            'tahun' => $tahun,
            'mobilAll' => $mobilAll->findAll(),
            'joinmobil' => $this->datamobilModel->joinMobil(),
            'pemesan' => $pemesan->where('id !=', 0)->getPemesan(),
            'perjalanan' => $perjalanan->getPerjalanan(),
            'bayar' => $bayar->getBayar(),
            'joinpesanan' => $pesanan,
            'sumharga' => $sumharga,
            'active'  => 'laporan',
            'role'  => $groupModel->getGroupsForUser(user()->id),
            // 'validation' => \Config\Services::validation()
        ];
        foreach ($data['mobilAll'] as $row) {
            $dataRow['jumlah'] = $this->datapesananModel->hitungJumlahMobil($row['id_mobil'], 2, $bulan, $tahun);
            $dataRow['merk'] = $this->datamerkModel->where('id_merk', $row['id_merk'])->findAll();
            $dataRow['total'] = $this->datapesananModel->PesananMobilSum($row['id_mobil'], 2, $bulan, $tahun);
            $dataRow['waktu'] = 1;
            $dataRow['row'] = $row;
            $data['row' . $row['id_mobil']] = view('data_pesanan/row', $dataRow);
        }
        return view('data_pesanan/laporan', $data);
    }
    public function laporanPrint()
    {
        session();
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
        $groupModel = new GroupModel();
        if (user()->status == 1) {
            $pesanan = $this->datapesananModel->joinPesananLap($bulan, $tahun);
        } elseif (user()->status == 2) {
            $pesanan = $this->datapesananModel->joinPesananCust();
        }
        $mobil = $this->datamobilModel->getMobilStatus();
        $mobilAll = $this->datamobilModel;
        $pemesan = $this->datapemesanModel;
        $perjalanan = $this->dataperjalananModel->where('id_perjalanan !=', 0);
        $bayar = $this->databayarModel->where('id_jenisbayar !=', 0);
        $sumharga = $this->datapesananModel->joinPesananLapSum($bulan, $tahun);
        $data = [
            // 'session' => $session,
            // 'pesanan' => $pesanan->getPesanan(),
            'mobil' => $mobil->getMobil(),
            'bulan' => $bulan,
            'tahun' => $tahun,
            'mobilAll' => $mobilAll->findAll(),
            'joinmobil' => $this->datamobilModel->joinMobil(),
            'pemesan' => $pemesan->where('id !=', 0)->getPemesan(),
            'perjalanan' => $perjalanan->getPerjalanan(),
            'bayar' => $bayar->getBayar(),
            'joinpesanan' => $pesanan,
            'sumharga' => $sumharga,
            'active'  => 'laporan',
            'role'  => $groupModel->getGroupsForUser(user()->id),
            // 'validation' => \Config\Services::validation()
        ];
        foreach ($data['mobilAll'] as $row) {
            $dataRow['jumlah'] = $this->datapesananModel->hitungJumlahMobil($row['id_mobil'], 2, $bulan, $tahun);
            $dataRow['merk'] = $this->datamerkModel->where('id_merk', $row['id_merk'])->findAll();
            $dataRow['total'] = $this->datapesananModel->PesananMobilSum($row['id_mobil'], 2, $bulan, $tahun);
            $dataRow['no'] = 1;
            $dataRow['waktu'] = $this->datapesananModel->PesananHariSum($row['id_mobil'], 2, $bulan, $tahun);
            $dataRow['row'] = $row;
            $data['row' . $row['id_mobil']] = view('data_pesanan/row', $dataRow);
        }
        return view('data_pesanan/laporan-print', $data);
    }

    public function laporanTahun()
    {
        session();

        $tahun = $this->request->getVar('tahun');
        $groupModel = new GroupModel();
        if (user()->status == 1) {
            $pesanan = $this->datapesananModel->joinPesananLapTahun($tahun);
        } elseif (user()->status == 2) {
            $pesanan = $this->datapesananModel->joinPesananCust();
        }
        $mobil = $this->datamobilModel->getMobilStatus();
        $mobilAll = $this->datamobilModel;
        $pemesan = $this->datapemesanModel;
        $perjalanan = $this->dataperjalananModel->where('id_perjalanan !=', 0);
        $bayar = $this->databayarModel->where('id_jenisbayar !=', 0);
        $sumharga = $this->datapesananModel->joinPesananLapSumTahun($tahun);
        $data = [
            // 'session' => $session,
            // 'pesanan' => $pesanan->getPesanan(),
            'mobil' => $mobil->getMobil(),
            'tahun' => $tahun,
            'mobilAll' => $mobilAll->findAll(),
            'joinmobil' => $this->datamobilModel->joinMobil(),
            'pemesan' => $pemesan->where('id !=', 0)->getPemesan(),
            'perjalanan' => $perjalanan->getPerjalanan(),
            'bayar' => $bayar->getBayar(),
            'joinpesanan' => $pesanan,
            'sumharga' => $sumharga,
            'active'  => 'laporan',
            'role'  => $groupModel->getGroupsForUser(user()->id),
            // 'validation' => \Config\Services::validation()
        ];
        foreach ($data['mobilAll'] as $row) {
            $dataRow['jumlah'] = $this->datapesananModel->hitungJumlahMobilTahun($row['id_mobil'], 2, $tahun);
            $dataRow['merk'] = $this->datamerkModel->where('id_merk', $row['id_merk'])->findAll();
            $dataRow['total'] = $this->datapesananModel->PesananMobilSumTahun($row['id_mobil'], 2, $tahun);
            $dataRow['no'] = 1;
            $dataRow['waktu'] = $this->datapesananModel->PesananHariSumTahun($row['id_mobil'], 2, $tahun);
            $dataRow['row'] = $row;
            $data['row' . $row['id_mobil']] = view('data_pesanan/row', $dataRow);
        }
        return view('data_pesanan/laporan-tahun', $data);
    }

    public function laporanUnit()
    {
        session();
        $groupModel = new GroupModel();
        $data = [
            'active'  => 'unit',
            'role'  => $groupModel->getGroupsForUser(user()->id),
            // 'validation' => \Config\Services::validation()
        ];

        return view('data_pesanan/laporan-unit', $data);
    }

    public function laporanUnitBulan()
    {
        session();
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
        $groupModel = new GroupModel();
        if (user()->status == 1) {
            $pesanan = $this->datapesananModel->joinPesananLap($bulan, $tahun);
        } elseif (user()->status == 2) {
            $pesanan = $this->datapesananModel->joinPesananCust();
        }
        $mobil = $this->datamobilModel->getMobilStatus();
        $mobilAll = $this->datamobilModel;
        $pemesan = $this->datapemesanModel;
        $perjalanan = $this->dataperjalananModel->where('id_perjalanan !=', 0);
        $bayar = $this->databayarModel->where('id_jenisbayar !=', 0);
        $sumharga = $this->datapesananModel->joinPesananLapSum($bulan, $tahun);
        $data = [
            // 'session' => $session,
            // 'pesanan' => $pesanan->getPesanan(),
            'mobil' => $mobil->getMobil(),
            'bulan' => $bulan,
            'tahun' => $tahun,
            'mobilAll' => $mobilAll->findAll(),
            'joinmobil' => $this->datamobilModel->joinMobil(),
            'pemesan' => $pemesan->where('id !=', 0)->getPemesan(),
            'perjalanan' => $perjalanan->getPerjalanan(),
            'bayar' => $bayar->getBayar(),
            'joinpesanan' => $pesanan,
            'sumharga' => $sumharga,
            'active'  => 'unit',
            'role'  => $groupModel->getGroupsForUser(user()->id),
            // 'validation' => \Config\Services::validation()
        ];
        $no = 1;
        foreach ($data['mobilAll'] as $row) {
            $dataRow['no'] = $no++;
            $dataRow['jumlah'] = $this->datapesananModel->hitungJumlahMobil($row['id_mobil'], 2, $bulan, $tahun);
            $dataRow['merk'] = $this->datamerkModel->where('id_merk', $row['id_merk'])->findAll();
            $dataRow['total'] = $this->datapesananModel->PesananMobilSum($row['id_mobil'], 2, $bulan, $tahun);
            $dataRow['waktu'] = $this->datapesananModel->PesananHariSum($row['id_mobil'], 2, $bulan, $tahun);
            $dataRow['row'] = $row;
            $data['row' . $row['id_mobil']] = view('data_pesanan/row-table', $dataRow);
        }
        return view('data_pesanan/laporan-unit-bulan', $data);
    }

    public function laporanUnitTahun()
    {
        session();

        $tahun = $this->request->getVar('tahun');
        $groupModel = new GroupModel();
        if (user()->status == 1) {
            $pesanan = $this->datapesananModel->joinPesananLapTahun($tahun);
        } elseif (user()->status == 2) {
            $pesanan = $this->datapesananModel->joinPesananCust();
        }
        $mobil = $this->datamobilModel->getMobilStatus();
        $mobilAll = $this->datamobilModel;
        $pemesan = $this->datapemesanModel;
        $perjalanan = $this->dataperjalananModel->where('id_perjalanan !=', 0);
        $bayar = $this->databayarModel->where('id_jenisbayar !=', 0);
        $sumharga = $this->datapesananModel->joinPesananLapSumTahun($tahun);
        $data = [
            // 'session' => $session,
            // 'pesanan' => $pesanan->getPesanan(),
            'mobil' => $mobil->getMobil(),
            'tahun' => $tahun,
            'mobilAll' => $mobilAll->findAll(),
            'joinmobil' => $this->datamobilModel->joinMobil(),
            'pemesan' => $pemesan->where('id !=', 0)->getPemesan(),
            'perjalanan' => $perjalanan->getPerjalanan(),
            'bayar' => $bayar->getBayar(),
            'joinpesanan' => $pesanan,
            'sumharga' => $sumharga,
            'active'  => 'laporan-unit',
            'role'  => $groupModel->getGroupsForUser(user()->id),
            // 'validation' => \Config\Services::validation()
        ];
        $no = 1;
        foreach ($data['mobilAll'] as $row) {
            $dataRow['jumlah'] = $this->datapesananModel->hitungJumlahMobilTahun($row['id_mobil'], 2, $tahun);
            $dataRow['merk'] = $this->datamerkModel->where('id_merk', $row['id_merk'])->findAll();
            $dataRow['total'] = $this->datapesananModel->PesananMobilSumTahun($row['id_mobil'], 2, $tahun);
            $dataRow['no'] = $no++;
            $dataRow['waktu'] = $this->datapesananModel->PesananHariSumTahun($row['id_mobil'], 2, $tahun);
            $dataRow['row'] = $row;
            $data['row' . $row['id_mobil']] = view('data_pesanan/row-table', $dataRow);
        }
        return view('data_pesanan/laporan-unit-tahun', $data);
    }


    public function laporanKeuntungan()
    {
        session();
        $groupModel = new GroupModel();
        $data = [
            'active'  => 'laporan-keuntungan',
            'role'  => $groupModel->getGroupsForUser(user()->id),
            // 'validation' => \Config\Services::validation()
        ];

        return view('data_pesanan/laporan-keuntungan', $data);
    }

    public function laporanKeuntunganBulan()
    {
        session();
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
        $groupModel = new GroupModel();
        if (user()->status == 1) {
            $pesanan = $this->datapesananModel->joinPesananLap($bulan, $tahun);
        } elseif (user()->status == 2) {
            $pesanan = $this->datapesananModel->joinPesananCust();
        }
        $mobil = $this->datamobilModel->getMobilStatus();
        $mobilAll = $this->datamobilModel;
        $pemesan = $this->datapemesanModel;
        $perjalanan = $this->dataperjalananModel->where('id_perjalanan !=', 0);
        $bayar = $this->databayarModel->where('id_jenisbayar !=', 0);
        $sumharga = $this->datapesananModel->joinPesananLapSum($bulan, $tahun);
        $data = [
            // 'session' => $session,
            // 'pesanan' => $pesanan->getPesanan(),
            'mobil' => $mobil->getMobil(),
            'bulan' => $bulan,
            'tahun' => $tahun,
            'mobilAll' => $mobilAll->findAll(),
            'joinmobil' => $this->datamobilModel->joinMobil(),
            'pemesan' => $pemesan->where('id !=', 0)->getPemesan(),
            'perjalanan' => $perjalanan->getPerjalanan(),
            'bayar' => $bayar->getBayar(),
            'pengeluaran' => $this->datapengeluaranModel->where('MONTH(created_at)', $bulan)->where('YEAR(created_at)', $tahun)->findAll(),
            'joinpesanan' => $pesanan,
            'sumharga' => $sumharga,
            'active'  => 'laporan',
            'role'  => $groupModel->getGroupsForUser(user()->id),
            // 'validation' => \Config\Services::validation()
        ];
        return view('data_pesanan/laporan-keuntungan-bulan', $data);
    }

    public function laporanKeuntunganTahun()
    {
        session();

        $tahun = $this->request->getVar('tahun');
        $groupModel = new GroupModel();
        if (user()->status == 1) {
            $pesanan = $this->datapesananModel->joinPesananLapTahun($tahun);
        } elseif (user()->status == 2) {
            $pesanan = $this->datapesananModel->joinPesananCust();
        }
        $mobil = $this->datamobilModel->getMobilStatus();
        $mobilAll = $this->datamobilModel;
        $pemesan = $this->datapemesanModel;
        $perjalanan = $this->dataperjalananModel->where('id_perjalanan !=', 0);
        $bayar = $this->databayarModel->where('id_jenisbayar !=', 0);
        $sumharga = $this->datapesananModel->joinPesananLapSumTahun($tahun);
        $data = [
            // 'session' => $session,
            // 'pesanan' => $pesanan->getPesanan(),
            'mobil' => $mobil->getMobil(),
            'tahun' => $tahun,
            'mobilAll' => $mobilAll->findAll(),
            'joinmobil' => $this->datamobilModel->joinMobil(),
            'pemesan' => $pemesan->where('id !=', 0)->getPemesan(),
            'perjalanan' => $perjalanan->getPerjalanan(),
            'bayar' => $bayar->getBayar(),
            'joinpesanan' => $pesanan,
            'pengeluaran' => $this->datapengeluaranModel->where('YEAR(created_at)', $tahun)->findAll(),
            'sumharga' => $sumharga,
            'active'  => 'laporan',
            'role'  => $groupModel->getGroupsForUser(user()->id),
            // 'validation' => \Config\Services::validation()
        ];
        return view('data_pesanan/laporan-keuntungan-tahun', $data);
    }

    public function getBayar()
    {
        $id_mobil = $this->request->getPost('id_mobil');
        $hari = $this->request->getPost('hari');

        // Mengambil harga dari tabel pertama berdasarkan id_service
        $mobil = $this->datamobilModel->find($id_mobil)['harga'];

        // Menghitung total harga
        $totalPrice = $mobil * $hari;

        // Mengembalikan total harga sebagai respons JSON
        return $this->response->setJSON(['total_price' => number_format($totalPrice, 2, ',', '.')]);
    }
}
