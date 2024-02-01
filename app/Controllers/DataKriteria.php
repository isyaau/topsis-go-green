<?php

namespace App\Controllers;

use CodeIgniter\Validation\Validation;
use CodeIgniter\Controller;

class DataKriteria extends BaseController
{
    public function index()
    {
        session();

        $kriteria = $this->datakriteriaModel->getKriteria();
        $data = [
            // 'session' => $session,
            'kriteria' => $kriteria,
            'active'  => 'kriteria',
            'role' => $this->groups->getGroupsForUser(user()->id),
            // 'validation' => \Config\Services::validation()
        ];
        return view('data_kriteria/index', $data);
    }
    public function save()
    {
        if (!$this->validate([
            'nama_kriteria' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama kriteria Harus diisi',
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi Harus diisi',
                ]
            ],
            'bobot' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Bobot Harus diisi',
                ]
            ],
            'sifat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Sifat Harus diisi',
                ]
            ],

        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $this->datakriteriaModel->save([
            'nama_kriteria' => $this->request->getVar('nama_kriteria'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'bobot' => $this->request->getVar('bobot'),
            'sifat' => $this->request->getVar('sifat'),

        ]);
        session()->setFlashdata('pesan', 'Tambah Data Kriteria Berhasil');
        return redirect()->to('/data-kriteria');
    }


    public function delete($id_kriteria)
    {

        $this->datakriteriaModel->delete($id_kriteria);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus.');
        return redirect()->to('/data-kriteria');
    }
    public function detail($id_kriteria)
    {
        $datakriteria = $this->datakriteriaModel->getKriteria($id_kriteria);
        if (empty($datakriteria)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Kriteria Tidak ditemukan !');
        }
        $data = [
            'title' => 'Ubah Data Kriteria| SIA',
            'active'  => 'kriteria',
            'validation' => \Config\Services::validation(),
            'role' => $this->groups->getGroupsForUser(user()->id),
            'datakriteria' => $this->datakriteriaModel->getKriteria($id_kriteria)

        ];
        return view('data_kriteria/detail', $data);
    }

    public function edit($id_kriteria)
    {
        $datakriteria = $this->datakriteriaModel->getKriteria($id_kriteria);
        if (empty($datakriteria)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data Kriteria Tidak ditemukan !');
        }
        $data = [
            'title' => 'Ubah Data Kriteria| SIA',
            'active'  => 'kriteria',
            'validation' => \Config\Services::validation(),
            'role' => $this->groups->getGroupsForUser(user()->id),
            'datakriteria' => $this->datakriteriaModel->getKriteria($id_kriteria)

        ];
        return view('data_kriteria/edit', $data);
    }

    public function update($id_kriteria)
    {
        if (!$this->validate([
            'nama_kriteria' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Kriteria Harus diisi',
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi Harus diisi',
                ]
            ],
            'bobot' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Bobot Harus diisi',
                ]
            ],
            'sifat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Sifat Harus diisi',
                ]
            ]

        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $this->datakriteriaModel->save([
            'id_kriteria' => $id_kriteria,
            'nama_kriteria' => $this->request->getVar('nama_kriteria'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'bobot' => $this->request->getVar('bobot'),
            'sifat' => $this->request->getVar('sifat'),

        ]);
        session()->setFlashdata('pesan', 'Ubah Data Kriteria Berhasil');
        return redirect()->to('/data-kriteria');
    }
}
