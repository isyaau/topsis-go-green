<?php

namespace App\Models;

use CodeIgniter\Model;

class DataKriteriaModel extends Model
{
    protected $table      = 'kriteria';
    protected $primaryKey = 'id_kriteria';
    protected $allowedFields = ['nama_kriteria', 'deskripsi', 'bobot', 'sifat'];



    public function getKriteria($id_kriteria = false)
    {
        if ($id_kriteria == false) {
            return $this->orderBy('id_kriteria', 'asc')->findAll();
        }
        return $this->where(['id_kriteria' => $id_kriteria])->first();
    }

    public function hitungKriteria()
    {
        $db = \Config\Database::connect();
        $query = $db->table('kriteria');
        $query->selectCount('id_kriteria');
        $result = $query->countAllResults();
        return $result;
    }

    public function getBobotKriteria($id_kriteria)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('kriteria');
        $builder->select('bobot');
        $builder->where('id_kriteria', $id_kriteria);
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function hitungJumlahKriteria()
    {
        $user = $this->query('SELECT * FROM kriteria');
        return $user->getNumRows();
    }
    public function updateKriteria($data, $id_kriteria)
    {
        $query = $this->db->table('kriteria')->update($data, array('id_kriteria' => $id_kriteria));
        return $query;
    }
    // ...
}
