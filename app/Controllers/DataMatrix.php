<?php

namespace App\Controllers;

use CodeIgniter\Validation\Validation;
use CodeIgniter\Controller;

class DataMatrix extends BaseController
{
    public function index()
    {
        session();
        $alternatif = $this->dataalternatifModel;
        $data = [
            // 'session' => $session,
            'alternatif' => $alternatif->getAlternatif(),
            'matrix' => $this->datamatrixModel->getMatrix(),
            'active'  => 'matrix',
            'role' => $this->groups->getGroupsForUser(user()->id),
            // 'validation' => \Config\Services::validation()
        ];
        return view('data_matrix/index', $data);
    }
    public function save()
    {
        // if (!$this->validate([
        //     'nama_pengeluaran' => [
        //         'rules' => 'required',
        //         'errors' => [
        //             'required' => 'Nama Pengeluaran Harus diisi',
        //         ]
        //     ],
        //     'jumlah' => [
        //         'rules' => 'required',
        //         'errors' => [
        //             'required' => 'Jumlah Harus diisi',
        //         ]
        //     ]

        // ])) {
        //     session()->setFlashdata('error', $this->validator->listErrors());
        //     return redirect()->back()->withInput();
        // }

        //cek id alternatif
        $id_alternatif = $this->request->getVar('id_alternatif');
        $cek = $this->dataalternatifModel->hitungAlternatif($id_alternatif);
        $o = 1;
        if ($cek > 0) {
            $this->datamatrixModel->deleteMatrixByAlternatif($id_alternatif);
        }
        $jml_krit = $this->datakriteriaModel->hitungKriteria();

        for ($n = 1; $n <= $jml_krit; $n++) {
            $id_kriteria = $this->request->getVar('id_kriteria' . $o);
            $nilai = $this->request->getVar('nilai' . $o);
            $this->datamatrixModel->save([
                'id_alternatif' => $id_alternatif,
                'id_kriteria' => $id_kriteria,
                'nilai' => $nilai
            ]);
            $o++;
        }

        session()->setFlashdata('pesan', 'Tambah Data Pengeluaran Berhasil');
        return redirect()->to('/data-matrix/detail/' . $id_alternatif);
    }


    public function delete($id_pengeluaran)
    {

        $this->datamatrixModel->delete($id_pengeluaran);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus.');
        return redirect()->to('/data-matrix');
    }

    public function detail($id_alternatif)
    {
        $dataalternatif = $this->dataalternatifModel->getAlternatif($id_alternatif);
        if (empty($dataalternatif)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Alternatif Tidak ditemukan !');
        }
        $data = [
            'title' => 'Data Matrix| SIA',
            'active'  => 'matrix',
            'role' => $this->groups->getGroupsForUser(user()->id),
            'validation' => \Config\Services::validation(),
            'dataalternatif' => $this->dataalternatifModel->getAlternatif($id_alternatif),
            'datamatrix' => $this->datamatrixModel->joinNilaiMatrix($id_alternatif)

        ];
        return view('data_matrix/detail', $data);
    }


    public function create($id_alternatif)
    {
        $dataalternatif = $this->dataalternatifModel->getAlternatif($id_alternatif);
        if (empty($dataalternatif)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Alternatif Tidak ditemukan !');
        }
        $kriteria = $this->datakriteriaModel->getKriteria();
        $data = [
            'title' => 'Data Matrix| SIA',
            'active'  => 'matrix',
            'role' => $this->groups->getGroupsForUser(user()->id),
            'validation' => \Config\Services::validation(),
            'dataalternatif' => $this->dataalternatifModel->getAlternatif($id_alternatif),
            'datamatrix' => $this->datamatrixModel->joinNilaiMatrix($id_alternatif),
            'kriteria' => $kriteria

        ];
        return view('data_matrix/create', $data);
    }

    public function update($id_pengeluaran)
    {
        if (!$this->validate([
            'nama_pengeluaran' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Pengeluaran Harus diisi',
                ]
            ],
            'jumlah' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jumlah Harus diisi',
                ]
            ]

        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $this->datamatrixModel->save([
            'id_pengeluaran' => $id_pengeluaran,
            'nama_pengeluaran' => $this->request->getVar('nama_pengeluaran'),
            'jumlah' => $this->request->getVar('jumlah'),

        ]);
        session()->setFlashdata('pesan', 'Ubah Data Pengeluaran Berhasil');
        return redirect()->to('/data-matrix');
    }
    public function laporan()
    {
        session();
        $data = [
            // 'session' => $session,
            'matrix' => $this->datamatrixModel->getMatrix(),
            'active'  => 'laporan-matrix',
            'role' => $this->groups->getGroupsForUser(user()->id),
            // 'validation' => \Config\Services::validation()
        ];
        return view('data_matrix/laporan', $data);
    }
    public function laporanBulan()
    {
        session();
        $tahun = $this->request->getVar('tahun');
        $bulan = $this->request->getVar('bulan');
        $data = [
            // 'session' => $session,
            'matrix' => $this->datamatrixModel->where('MONTH(created_at)', $bulan)->where('YEAR(created_at)', $tahun)->findAll(),
            'active'  => 'laporan-matrix',
            'bulan'  => $bulan,
            'tahun'  => $tahun,
            'role' => $this->groups->getGroupsForUser(user()->id),
            // 'validation' => \Config\Services::validation()
        ];
        return view('data_matrix/laporan-bulan', $data);
    }
    public function laporanTahun()
    {
        session();
        $tahun = $this->request->getVar('tahun');
        $data = [
            // 'session' => $session,
            'matrix' => $this->datamatrixModel->where('YEAR(created_at)', $tahun)->findAll(),
            'active'  => 'laporan-matrix',
            'tahun'  => $tahun,
            'role' => $this->groups->getGroupsForUser(user()->id),
            // 'validation' => \Config\Services::validation()
        ];
        return view('data_matrix/laporan-tahun', $data);
    }
}
