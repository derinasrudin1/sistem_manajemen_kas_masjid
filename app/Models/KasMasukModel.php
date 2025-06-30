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
        'id_masjid',
        'id_sumber_dana'
    ];
    protected $useTimestamps = false;

    public function getKasMasukWithRelations()
    {
        $this->select('kas_masuk.*, masjid.nama_masjid, users.nama as nama_user, sumber_dana.nama_sumber');
        $this->join('masjid', 'masjid.id_masjid = kas_masuk.id_masjid', 'left');
        $this->join('users', 'users.id_user = kas_masuk.id_user', 'left');
        $this->join('sumber_dana', 'sumber_dana.id_sumber_dana = kas_masuk.id_sumber_dana', 'left');
        $this->orderBy('kas_masuk.tanggal', 'DESC');

        // PERUBAHAN: Kembalikan instance Model itu sendiri.
        return $this;
    }

}