<?php

namespace App\Controllers;

use CodeIgniter\Validation\Validation;
use CodeIgniter\Controller;

class DataAlternatif extends BaseController
{
    public function index()
    {
        session();

        $alternatif = $this->dataalternatifModel;
        $data = [
            // 'session' => $session,
            'alternatif' => $alternatif->getAlternatif(),
            'active'  => 'alternatif',
            'role' => $this->groups->getGroupsForUser(user()->id),
            // 'validation' => \Config\Services::validation()
        ];
        return view('data_alternatif/index', $data);
    }
    public function save()
    {
        if (!$this->validate([
            'nama_alternatif' => [
                'rules' => 'required|is_unique[alternatif.nama_alternatif]',
                'errors' => [
                    'required' => 'Nama merk Harus diisi',
                    'is_unique' => 'Nama merk sudah ada. Nama merk tidak boleh sama'
                ]
            ],
            'rt_a' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'RT A Harus diisi',
                ],

            ],
            'rt_b' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'RT B Harus diisi',
                ],

            ],
            'kecamatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kecamatan Harus diisi',
                ],

            ],
            'kota' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kota Harus diisi',
                ],

            ]

        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $this->dataalternatifModel->save([
            'nama_alternatif' => $this->request->getVar('nama_alternatif'),
            'rt_a' => $this->request->getVar('rt_a'),
            'rt_b' => $this->request->getVar('rt_b'),
            'kecamatan' => $this->request->getVar('kecamatan'),
            'kota' => $this->request->getVar('kota'),

        ]);
        session()->setFlashdata('pesan', 'Tambah Data Alternatif Berhasil');
        return redirect()->to('/data-alternatif');
    }


    public function delete($id_alternatif)
    {

        $this->dataalternatifModel->delete($id_alternatif);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus.');
        return redirect()->to('/data-alternatif');
    }
    public function detail($id_alternatif)
    {
        $dataalternatif = $this->dataalternatifModel->getAlternatif($id_alternatif);
        if (empty($dataalternatif)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Alternatif Tidak ditemukan !');
        }
        $data = [
            'title' => 'Ubah Data Alternatif| SIA',
            'active'  => 'alternatif',
            'role' => $this->groups->getGroupsForUser(user()->id),
            'validation' => \Config\Services::validation(),
            'dataalternatif' => $this->dataalternatifModel->getAlternatif($id_alternatif)

        ];
        return view('data_alternatif/detail', $data);
    }

    public function edit($id_alternatif)
    {
        $dataalternatif = $this->dataalternatifModel->getAlternatif($id_alternatif);
        if (empty($dataalternatif)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Alternatif Tidak ditemukan !');
        }
        $data = [
            'title' => 'Ubah Data Alternatif| SIA',
            'active'  => 'alternatif',
            'role' => $this->groups->getGroupsForUser(user()->id),
            'validation' => \Config\Services::validation(),
            'dataalternatif' => $this->dataalternatifModel->getAlternatif($id_alternatif)

        ];
        return view('data_alternatif/edit', $data);
    }

    public function update($id_alternatif)
    {
        if (!$this->validate([
            'nama_alternatif' => [
                'rules' => 'required|is_unique[alternatif.nama_alternatif]',
                'errors' => [
                    'required' => 'Nama merk Harus diisi',
                    'is_unique' => 'Nama merk sudah ada. Nama merk tidak boleh sama'
                ]
            ],
            'rt_a' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'RT A Harus diisi',
                ],

            ],
            'rt_b' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'RT B Harus diisi',
                ],

            ],
            'kecamatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kecamatan Harus diisi',
                ],

            ],
            'kota' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kota Harus diisi',
                ],

            ]

        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $this->dataalternatifModel->save([
            'id_alternatif' => $id_alternatif,
            'nama_alternatif' => $this->request->getVar('nama_alternatif'),
            'rt_a' => $this->request->getVar('rt_a'),
            'rt_b' => $this->request->getVar('rt_b'),
            'kecamatan' => $this->request->getVar('kecamatan'),
            'kota' => $this->request->getVar('kota'),
        ]);
        session()->setFlashdata('pesan', 'Ubah Data Alternatif Berhasil');
        return redirect()->to('/data-alternatif');
    }
    // public function update()
    // {

    //     $merk = $this->dataalternatifModel;
    //     $id = $this->request->getPost('id');
    //     $data = array(
    //         'nama_alternatif'        => $this->request->getPost('nama_alternatif'),
    //     );
    //     $merk->updateMerk($data, $id);
    //     return redirect()->to('/data-alternatif');
    // }
}
