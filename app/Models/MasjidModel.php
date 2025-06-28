<?php
namespace App\Models;

use CodeIgniter\Model;

class MasjidModel extends Model
{
    protected $table = 'masjid';
    protected $primaryKey = 'id_masjid';
    protected $allowedFields = ['nama_masjid', 'alamat', 'rt_rw', 'nama_takmir', 'kontak'];
    protected $useTimestamps = true;
    protected $validationRules = [
        'nama_masjid' => 'required|min_length[3]',
        'alamat' => 'required',
        'rt_rw' => 'required',
        'nama_takmir' => 'required',
        'kontak' => 'required|numeric|min_length[10]'
    ];
    protected $validationMessages = [
        'kontak' => [
            'numeric' => 'Nomor kontak harus berupa angka'
        ]
    ];
}