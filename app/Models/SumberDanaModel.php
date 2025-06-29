<?php

namespace App\Models;

use CodeIgniter\Model;

class SumberDanaModel extends Model
{
    protected $table = 'sumber_dana';
    protected $primaryKey = 'id_sumber';
    protected $allowedFields = ['nama_sumber'];
    protected $useTimestamps = false;

    public function getSumberDana()
    {
        return $this->orderBy('nama_sumber', 'ASC')->findAll();
    }
}