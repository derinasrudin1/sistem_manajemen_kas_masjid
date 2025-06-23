<?php

namespace App\Models;

use CodeIgniter\Model;


class KasMasukModel extends Model
{
    protected $table = 'kas_masuk';
    protected $primaryKey = 'id_kas_masuk';

    protected $allowedFields = ['tanggal', 'jumlah', 'sumber', 'keterangan', 'id_user'];

    protected $useTimestamps = false;
}
