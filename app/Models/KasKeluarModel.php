<?php

namespace App\Models;

use CodeIgniter\Model;

class KasKeluarModel extends Model
{
    protected $table = 'kas_keluar';
    protected $primaryKey = 'id_kas_keluar';
    protected $allowedFields = ['tanggal', 'jumlah', 'kategori', 'keterangan', 'id_user'];
    protected $useTimestamps = false; // karena kolom created_at dan updated_at tidak ada
}
