<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use \Myth\Auth\Authorization\GroupModel;

class Landing extends BaseController
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
            'alternatif' => $alternatif->hitungAlternatifAll(),
            'kriteria' => $kriteria->getKriteria(),
            'matrix' => $matrix->hitungMatrix(),
            'preferensi' => $this->datapreferensiModel->orderBy('nilai', 'desc')->findAll(),

            'active'  => 'dashboard'
        ];
        return view('index', $data);
    }
}
