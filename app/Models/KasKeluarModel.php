<?php

namespace App\Models;

use CodeIgniter\Model;

class KasKeluarModel extends Model
{
    protected $table = 'kas_keluar';
    protected $primaryKey = 'id_kas_keluar';
    protected $allowedFields = ['tanggal', 'jumlah', 'kategori', 'keterangan', 'bukti', 'id_user', 'id_masjid'];
    protected $useTimestamps = false;
    protected $beforeInsert = ['setUserID'];

    protected function setUserID(array $data)
    {
        $data['data']['id_user'] = session()->get('id_user');
        return $data;
    }

    public function getKasKeluarWithDetails()
    {
        return $this->db->table('kas_keluar')
            ->select('kas_keluar.*, masjid.nama_masjid, users.nama as nama_user')
            ->join('masjid', 'masjid.id_masjid = kas_keluar.id_masjid', 'left')
            ->join('users', 'users.id_user = kas_keluar.id_user', 'left')
            ->orderBy('kas_keluar.tanggal', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getTotalByKategori($startDate = null, $endDate = null, $idMasjid = null)
    {
        $builder = $this->db->table('kas_keluar');
        $builder->select('kategori, SUM(jumlah) as total');

        if ($startDate && $endDate) {
            $builder->where('tanggal >=', $startDate);
            $builder->where('tanggal <=', $endDate);
        }

        if ($idMasjid) {
            $builder->where('id_masjid', $idMasjid);
        }

        $builder->groupBy('kategori');
        return $builder->get()->getResultArray();
    }
}