<?php

namespace App\Models;

use CodeIgniter\Model;

class DataPreferensiModel extends Model
{
    protected $table      = 'nilai_preferensi';
    protected $allowedFields = ['nama_alternatif, nilai'];
}
