<?php

namespace App\Models;

use CodeIgniter\Model;

class KasMasukModel extends Model
{
    protected $table = 'kas_masuk';
    protected $primaryKey = 'id_kas_masuk';
    protected $allowedFields = [
        'tanggal',
        'jumlah',
        'sumber',
        'keterangan',
        'bukti',
        'id_user',
        'id_masjid'
    ];
    protected $useTimestamps = false;

    public function getKasMasukWithRelations()
    {
        return $this->select('kas_masuk.*, masjid.nama_masjid, users.nama as nama_user')
                   ->join('masjid', 'masjid.id_masjid = kas_masuk.id_masjid', 'left')
                   ->join('users', 'users.id_user = kas_masuk.id_user', 'left')
                   ->orderBy('kas_masuk.tanggal', 'DESC');
    }
}