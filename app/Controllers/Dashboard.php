<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use \Myth\Auth\Authorization\GroupModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $session = session();
        $alternatif = $this->dataalternatifModel;
        $kriteria = $this->datakriteriaModel;
        $matrix = $this->datamatrixModel;
        $akun = $this->dataakunModel;
        $groupModel = new GroupModel();
        $data = [
            'session' => $session,
            'role' => $groupModel->getGroupsForUser(user()->id),
            'akun' => $akun->hitungJumlahAkun(),
            'alternatif' => $alternatif->hitungAlternatifAll(),
            'kriteria' => $kriteria->hitungKriteria(),
            'matrix' => $matrix->hitungMatrix(),
            'preferensi' => $this->datapreferensiModel->orderBy('nilai', 'desc')->findAll(),

            'active'  => 'dashboard'
        ];
        return view('dashboard/index', $data);
    }
}