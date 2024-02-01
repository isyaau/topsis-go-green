<?php

namespace App\Models;

use CodeIgniter\Model;

class AkunModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'email', 'username', 'fullname', 'jenis_kelamin', 'alamat', 'foto', 'password_hash', 'reset_hash', 'reset_at', 'reset_expires', 'activate_hash',
        'status', 'status_message', 'active', 'force_pass_reset', 'permissions', 'deleted_at',
    ];



    public function getAkun($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->where(['id' => $id])->first();
    }
    public function joinAkun($id = false)
    {
        if ($id == false) {
            $db      = \Config\Database::connect();
            $builder = $db->table('users');
            $builder->select('*');
            $builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
            $builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
            $builder->where('group_id', 1);
            $query = $builder->get();
            return $query;
        }
        return $this->where(['id' => $id])->first();
    }

    public function hitungJumlahAkun()
    {
        $akun = $this->query('SELECT * FROM users');
        return $akun->getNumRows();
    }
    public function updateMerk($data, $id_akun)
    {
        $query = $this->db->table('mobil')->update($data, array('id_akun' => $id_akun));
        return $query;
    }
    // ...
}
