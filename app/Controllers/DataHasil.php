<?php

namespace App\Controllers;

use App\Models\DataAlternatifModel;
use CodeIgniter\Validation\Validation;
use CodeIgniter\Controller;

class DataHasil extends BaseController
{
    public function NilaiMatrix()
    {
        // session();
        helper(['form']);
        $n = 1;
        $data['alternatif'] = $this->dataalternatifModel->findAll();
        foreach ($data['alternatif'] as $row) {
            $dataRow['no'] = $n++;
            $dataRow['nilai'] = $this->datamatrixModel->where('id_alternatif', $row['id_alternatif'])->orderBy('id_kriteria', 'asc')->findAll();
            foreach ($dataRow['nilai'] as $nilai) {
                $dkuadrat['nilai']
                    = $this->datamatrixModel->where('id_kriteria', $nilai['id_kriteria'])->findAll();
            }
            $dataRow['row'] = $row;
            $data['row' . $row['id_alternatif']] = view('hasil_topsis/row_alternatif', $dataRow);
        }
        $data['jml_kriteria'] = $this->datakriteriaModel->hitungKriteria();
        $data['active'] = 'nilai-matrix';
        $data['role'] = $this->groups->getGroupsForUser(user()->id);

        return view('hasil_topsis/nilai_matrix', $data);
    }

    public function normalisasi()
    {

        session();
        $data = [
            // 'session' => $session,
            'alternatif' => $this->dataalternatifModel->getAlternatif(),
            'kriteria' => $this->datakriteriaModel->getKriteria(),
            'db' => \Config\Database::connect(),
            'jml_kriteria' => $this->datakriteriaModel->hitungKriteria(),
            'active'  => 'nilai-normalisasi',
            'role' => $this->groups->getGroupsForUser(user()->id),
            // 'validation' => \Config\Services::validation()
        ];
        return view('hasil_topsis/nilai_matrix_normalisasi', $data);
    }

    public function bobot()
    {

        session();
        $data = [
            // 'session' => $session,
            'matrixmodel' => new \App\Models\DataMatrixModel(),
            'kriteriamodel' => new \App\Models\DataKriteriaModel(),
            'alternatif' => $this->dataalternatifModel->getAlternatif(),
            'kriteria' => $this->datakriteriaModel->getKriteria(),
            'db' => \Config\Database::connect(),
            'jml_kriteria' => $this->datakriteriaModel->hitungKriteria(),
            'active'  => 'bobot-normalisasi',
            'role' => $this->groups->getGroupsForUser(user()->id),
            // 'validation' => \Config\Services::validation()
        ];
        return view('hasil_topsis/nilai_bobot_normalisasi', $data);
    }

    public function ideal()
    {

        $data['criteria'] = $this->datakriteriaModel->getKriteria();
        $data['header'] = 'Matriks Ideal Positif (A+)';
        $data['symbol'] = 'y<sup>+</sup>';
        // $data['matrixAplus'] = $this->datamatrixModel->getidealMatrix('benefit');
        $data['headerMin'] = 'Matriks Ideal Negatif (A-)';
        $data['symbolMin'] = 'y<sup>-</sup>';
        // $data['matrixAminus'] = $this->datamatrixModel->getidealMatrix('cost');
        session();
        $data = [
            // 'session' => $session,
            'matrixmodel' => new \App\Models\DataMatrixModel(),
            'kriteriamodel' => new \App\Models\DataKriteriaModel(),
            'alternatifmodel' => new \App\Models\DataAlternatifModel(),
            'matriksIdealPositif' => $this->hitungMatriksIdeal('benefit'),
            'matriksIdealNegatif' => $this->hitungMatriksIdeal('cost'),
            'header' => 'Matriks Ideal Positif (A+)',
            'criteria' => $this->datakriteriaModel->getKriteria(),
            'symbol' => 'y<sup>+</sup>',
            // 'matrixAplus' => $this->datamatrixModel->getidealMatrix('benefit'),
            'headerMin' => 'Matriks Ideal Negatif (A-)',
            'symbolMin' => 'y<sup>-</sup>',
            // 'matrixAminus' => $this->datamatrixModel->getidealMatrix('cost'),
            'alternatif' => $this->dataalternatifModel->getAlternatif(),
            'kriteria' => $this->datakriteriaModel->getKriteria(),
            'db' => \Config\Database::connect(),
            'h' => $this->datakriteriaModel->hitungKriteria(),
            'active'  => 'matrix-ideal',
            'role' => $this->groups->getGroupsForUser(user()->id),
            // 'validation' => \Config\Services::validation()
        ];
        return view('hasil_topsis/matrix_ideal', $data);
    }

    private function hitungMatriksIdeal($sifat)
    {
        $matriksIdeal = [];

        foreach ($this->datakriteriaModel->getKriteria() as $kriteria) {
            $idKriteria = $kriteria['id_kriteria'];
            $nilaiKuadrat = 0;
            $ymax = [];

            foreach ($this->datamatrixModel->getKriteriabyMatrix($idKriteria) as $nilai) {
                $nilaiKuadrat += round($nilai['nilai'] * $nilai['nilai'], 4);
            }

            foreach ($this->datamatrixModel->getKriteriabyMatrix($idKriteria) as $nilai) {
                $bobot = round($nilai['nilai'] / sqrt($nilaiKuadrat) * $kriteria['bobot'], 4);
                $ymax[] = $sifat == 'benefit' ? $bobot : -$bobot;
            }

            $matriksIdeal[$idKriteria] = $sifat == 'benefit' ? max($ymax) : min($ymax);
        }

        return $matriksIdeal;
    }

    public function jarak()
    {
        $kriteria = $this->datakriteriaModel->getKriteria();
        $data['kriteria'] = $this->datakriteriaModel->getKriteria();

        // Dapatkan data alternatif
        $data['alternatif'] = $this->dataalternatifModel->getAlternatif();

        $db      = \Config\Database::connect(); // Menggunakan database
        $session = session(); // Menggunakan session
        session();
        $data = [
            // 'session' => $session,
            'matrixmodel' => new \App\Models\DataMatrixModel(),
            'kriteriamodel' => new \App\Models\DataKriteriaModel(),
            'matriksIdealNegatif' => $this->hitungMatriksIdeal('cost'),
            'joinmatrix' => $this->datamatrixModel->hitungJoinMatrix(),
            'alternatif' => $this->dataalternatifModel->getAlternatif(),
            'kriteria' => $this->datakriteriaModel->getKriteria(),
            // 'dplus' => $this->datamatrixModel->hitungDPlus($data['kriteria'], $data['alternatif']),
            'db' => \Config\Database::connect(),
            'jml_kriteria' => $this->datakriteriaModel->hitungKriteria(),
            'active'  => 'jarak-solusi',
            'role' => $this->groups->getGroupsForUser(user()->id),
            // 'validation' => \Config\Services::validation()
        ];

        // session()->set('ymax', $data['dplus']);

        return view('hasil_topsis/jarak_solusi', $data);
    }

    public function preferensi()
    {
        session();
        $data = [
            // 'session' => $session,
            'matrixmodel' => new \App\Models\DataMatrixModel(),
            'kriteriamodel' => new \App\Models\DataKriteriaModel(),
            'matriksIdealPositif' => $this->hitungMatriksIdeal('benefit'),
            'matriksIdealNegatif' => $this->hitungMatriksIdeal('cost'),
            'joinmatrix' => $this->datamatrixModel->hitungJoinMatrix(),

            'alternatif' => $this->dataalternatifModel->getAlternatif(),
            'kriteria' => $this->datakriteriaModel->getKriteria(),
            'db' => \Config\Database::connect(),
            'jml_kriteria' => $this->datakriteriaModel->hitungKriteria(),
            'active'  => 'nilai-preferensi',
            'role' => $this->groups->getGroupsForUser(user()->id),

        ];

        return view('hasil_topsis/nilai_preferensi', $data);
    }


    public function print()
    {
        $session = session();
        $alternatif = $this->dataalternatifModel;
        $kriteria = $this->datakriteriaModel;
        $matrix = $this->datamatrixModel;
        $data = [
            'session' => $session,
            'alternatif' => $alternatif->hitungAlternatifAll(),
            'kriteria' => $kriteria->getKriteria(),
            'matrix' => $matrix->hitungMatrix(),
            'preferensi' => $this->datapreferensiModel->orderBy('nilai', 'desc')->findAll(),

            'active'  => 'dashboard'
        ];
        return view('hasil_topsis/print_preferensi', $data);
    }
}
