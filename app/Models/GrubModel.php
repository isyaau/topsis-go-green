<?php

namespace App\Models;

use CodeIgniter\Model;

class GrubModel extends Model
{
    protected $table      = 'auth_groups_users';
    protected $allowedFields = [
        'group_id', 'user_id'
    ];



    public function getGrub($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->where(['id' => $id])->first();
    }
    public function joinMobil($id_akun = false)
    {
        if ($id_akun == false) {
            $db      = \Config\Database::connect();
            $builder = $db->table('mobil');
            $builder->select('*');
            $builder->join('merk', 'merk.id_merk = mobil.id_merk');
            $query = $builder->get();
            return $query;
        }
        return $this->where(['id_akun' => $id_akun])->first();
    }

    public function hitungJumlahAkun()
    {
        $akun = $this->query('SELECT * FROM akun');
        return $akun->getNumRows();
    }
    public function updateMerk($data, $id_akun)
    {
        $query = $this->db->table('mobil')->update($data, array('id_akun' => $id_akun));
        return $query;
    }
    // ...
}
