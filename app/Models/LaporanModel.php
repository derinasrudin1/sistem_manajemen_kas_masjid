<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanModel extends Model
{
    protected $table = 'laporan';
    protected $primaryKey = 'id_laporan';
    protected $allowedFields = [
        'id_masjid',
        'id_user',
        'judul',
        'periode_awal',
        'periode_akhir',
        'total_pemasukan',
        'total_pengeluaran',
        'saldo_akhir',
        'catatan'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = '';

    public function getLaporanWithRelations()
    {
        return $this->select('laporan.*, masjid.nama_masjid, users.nama as nama_user')
            ->join('masjid', 'masjid.id_masjid = laporan.id_masjid', 'left')
            ->join('users', 'users.id_user = laporan.id_user', 'left')
            ->orderBy('laporan.created_at', 'DESC');
    }

    public function getLaporanWithDetails()
    {
        return $this->db->table('laporan')
            ->select('laporan.*, masjid.nama_masjid, users.nama as nama_user')
            ->join('masjid', 'masjid.id_masjid = laporan.id_masjid')
            ->join('users', 'users.id_user = laporan.id_user')
            ->orderBy('laporan.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }
}