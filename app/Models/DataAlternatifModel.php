<?php

namespace App\Models;

use CodeIgniter\Model;

class DataAlternatifModel extends Model
{
    protected $table      = 'alternatif';
    protected $primaryKey = 'id_alternatif';
    protected $allowedFields = ['nama_alternatif', 'rt_a', 'rt_b', 'kecamatan', 'kota'];



    public function getAlternatif($id_alternatif = false)
    {
        if ($id_alternatif == false) {
            return $this->findAll();
        }
        return $this->where(['id_alternatif' => $id_alternatif])->first();
    }

    public function hitungAlternatif($id_alternatif)
    {
        $db = \Config\Database::connect();
        $query = $db->table('alternatif');
        $query->selectCount('id_alternatif')->where('id_alternatif', $id_alternatif);
        $result = $query->countAllResults();
        return $result;
    }

    public function hitungAlternatifAll()
    {
        $db = \Config\Database::connect();
        $query = $db->table('alternatif');
        $query->selectCount('id_alternatif');
        $result = $query->countAllResults();
        return $result;
    }

    public function updateAlternatif($data, $id_alternatif)
    {
        $query = $this->db->table('alternatif')->update($data, array('id_alternatif' => $id_alternatif));
        return $query;
    }
    // ...
}
