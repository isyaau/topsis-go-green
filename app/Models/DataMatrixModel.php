<?php

namespace App\Models;

use CodeIgniter\Model;

class DataMatrixModel extends Model
{
    protected $table      = 'nilai_matrix';
    protected $primaryKey = 'id_matrix';
    protected $allowedFields = ['id_alternatif', 'id_kriteria', 'nilai'];
    protected $useTimestamps = true;



    public function getMatrix($id_matrix = false)
    {
        if ($id_matrix == false) {
            return $this->findAll();
        }
        return $this->where(['id_matrix' => $id_matrix])->first();
    }

    public function joinMatrix($id_matrix = false)
    {
        if ($id_matrix == false) {
            $db      = \Config\Database::connect();
            $builder = $db->table('nilai_matrix');
            $builder->select('*');
            $builder->join('alternatif', 'alternatif.id_alternatif = nilai_matrix.id_alternatif');
            $builder->join('kriteria', 'kriteria.id_kriteria = nilai_matrix.id_kriteria');
            $query = $builder->get();
            return $query;
        }
        $db      = \Config\Database::connect();
        $builder = $db->table('nilai_matrix');
        $builder->select('*');
        $builder->join('alternatif', 'alternatif.id_alternatif = nilai_matrix.id_alternatif');
        $builder->join('kriteria', 'kriteria.id_kriteria = nilai_matrix.id_kriteria');
        $builder->where('id_matrix', $id_matrix);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function joinNilaiMatrix($id_alternatif)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('nilai_matrix');
        $builder->select('*');
        $builder->join('alternatif', 'alternatif.id_alternatif = nilai_matrix.id_alternatif');
        $builder->join('kriteria', 'kriteria.id_kriteria = nilai_matrix.id_kriteria');
        $builder->where('nilai_matrix.id_alternatif', $id_alternatif);
        $builder->orderBy('nilai_matrix.id_kriteria', 'asc');
        $query = $builder->get();
        return $query->getResultArray();
    }



    public function getAlternatifMatrix($id_alternatif)
    {

        $db      = \Config\Database::connect();
        $builder = $db->table('nilai_matrix');
        $builder->select('*');
        $builder->where('id_alternatif', $id_alternatif);
        $builder->orderBy('id_matrix', 'ASC');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getKriteriaMatrix($id_kriteria)
    {

        $db      = \Config\Database::connect();
        $builder = $db->table('nilai_matrix');
        $builder->select('*');
        $builder->where('id_kriteria', $id_kriteria);
        $builder->orderBy('id_kriteria', 'ASC');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getAlternatifKriteriaMatrix($id_alternatif, $id_kriteria)
    {

        $db      = \Config\Database::connect();
        $builder = $db->table('nilai_matrix');
        $builder->select('*');
        $builder->where('id_alternatif', $id_alternatif);
        $builder->where('id_kriteria', $id_kriteria);
        $builder->orderBy('id_matrix', 'ASC');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getKriteriabyMatrix($id_kriteria)
    {

        $db      = \Config\Database::connect();
        $builder = $db->table('nilai_matrix');
        $builder->select('*');
        $builder->where('id_kriteria', $id_kriteria);
        $builder->orderBy('id_matrix', 'ASC');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function deleteMatrixByAlternatif($id_alternatif)
    {
        return $this->where('id_alternatif', $id_alternatif)->delete();
    }

    public function hitungJumlahMatrix()
    {
        $user = $this->query('SELECT * FROM nilai_matrix');
        return $user->getNumRows();
    }

    public function getKriteria()
    {

        $db      = \Config\Database::connect();
        $builder = $db->table('kriteria');
        $builder->select('*');
        $builder->orderBy('id_kriteria', 'ASC');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getidealMatrix($sifat)
    {
        $matrix = [];
        $db      = \Config\Database::connect();
        $criteria = $this->getKriteria();

        foreach ($criteria as $c) {
            $n = $db->table('nilai_matrix')
                ->select('nilai,nilai_matrix.id_kriteria AS id_kriteria,')
                ->join('alternatif', 'alternatif.id_alternatif = nilai_matrix.id_alternatif')
                ->join('kriteria', 'kriteria.id_kriteria = nilai_matrix.id_kriteria')
                ->where('nilai_matrix.id_kriteria', $c['id_kriteria'])
                ->orderBy('id_matrix', 'ASC')
                ->get();

            $cValues = [];
            $ymax = [];
            $ymin = [];

            foreach ($n->getResult() as $dn) {
                $idk = $dn->id_kriteria;
                $nilai_kuadrat = 0;

                $k = $db->table('nilai_matrix')
                    ->select('nilai')
                    ->where('id_kriteria', $idk)
                    ->orderBy('id_matrix', 'ASC')
                    ->get();

                foreach ($k->getResult() as $dkuadrat) {
                    $nilai_kuadrat += ($dkuadrat->nilai * $dkuadrat->nilai);
                }

                $jml_alternatif = $this->db->table('alternatif')->countAll();
                $bobot = 0;
                $tnilai = 0;

                $k2 = $db->table('nilai_matrix')
                    ->select('nilai')
                    ->where('id_kriteria', $idk)
                    ->orderBy('id_matrix', 'ASC')
                    ->get();

                foreach ($k2->getResult() as $dbobot) {
                    $tnilai += $dbobot->nilai;
                }

                $bobot = $tnilai / $jml_alternatif;

                $b2 = $db->table('kriteria')->select('bobot')->where('id_kriteria', $idk)->get();
                $nbot = $b2->getRow();
                $bot = $nbot->bobot;

                $v = round(($dn->nilai / sqrt($nilai_kuadrat)) * $bot, 4);

                $ymax[] = $v;
                $ymin[] = $v;
            }

            $cValues['criteria_name'] = $c['nama_kriteria'];

            if ($sifat == 'benefit') {
                $cValues['max_value'] = max($ymax);
                $cValues['min_value'] = min($ymin);
            } else {
                $cValues['max_value'] = min($ymax);
                $cValues['min_value'] = max($ymin);
            }

            $matrix[] = $cValues;
        }

        return $matrix;
    }


    public function hitungDPlus($kriteria, $alternatif)
    {
        $dplus = [];

        foreach ($alternatif as $i => $alt) {
            $idalt = $alt['id_alternatif'];
            $jarakp = 0;
            $ymax = [];

            foreach ($kriteria as $kri) {
                $idk = $kri['id_kriteria'];

                $nilai_matriks = $this->query("SELECT nilai FROM nilai_matrix WHERE id_alternatif = $idalt AND id_kriteria = $idk")->getRow()->nilai;
                $nilai_kuadrat = $this->query("SELECT SUM(nilai*nilai) as nilai_kuadrat FROM nilai_matrix WHERE id_kriteria = $idk")->getRow()->nilai_kuadrat;

                $jml_alternatif = count($alternatif);
                $bobot = array_sum(array_column($this->query("SELECT * FROM nilai_matrix WHERE id_kriteria = $idk")->getResultArray(), 'nilai')) / $jml_alternatif;

                $bobot_input = $this->query("SELECT bobot FROM kriteria WHERE id_kriteria = $idk")->getRow()->bobot;

                $v = round(($nilai_matriks / sqrt($nilai_kuadrat)) * $bobot_input, 4);

                $ymax[] = $v;
            }

            $benefitMax = max($ymax);
            $jarakp = array_sum(array_map(function ($value) use ($benefitMax) {
                return pow($value - $benefitMax, 2);
            }, $ymax));

            $dplus[$i] = round(sqrt($jarakp), 4);
        }

        return $dplus;
    }

    public function hitungMatrix()
    {
        $db = \Config\Database::connect();
        $query = $db->table('nilai_matrix');
        $query->selectCount('id_matrix');
        $result = $query->countAllResults();
        return $result;
    }

    public function hitungJoinMatrix()
    {
        $db = \Config\Database::connect();
        $query = $db->table('nilai_matrix');
        $query->selectCount('id_matrix');
        $query->join('alternatif', 'alternatif.id_alternatif = nilai_matrix.id_alternatif');
        $query->join('kriteria', 'kriteria.id_kriteria = nilai_matrix.id_kriteria');
        $result = $query->countAllResults();
        return $result;
    }
}
