<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKasKeluar extends Model
{
    protected $table = 'kas_keluar';
    protected $primaryKey = 'id_kas_keluar';
    // Menggunakan 'kategori' sesuai dengan struktur tabel Anda
    protected $allowedFields = ['tanggal', 'jumlah', 'kategori', 'keterangan', 'bukti', 'id_user', 'id_masjid'];
    protected $useTimestamps = false;

    /**
     * PERBAIKAN: Fungsi ini sekarang hanya melakukan JOIN yang dibutuhkan (masjid dan users)
     * dan mengembalikan instance Model agar bisa disambung (chainable).
     * JOIN ke tabel kategori_pengeluaran telah dihapus.
     */
    public function getKasKeluarWithDetails()
    {
        // SELECT sekarang tidak lagi mengambil 'nama_kategori' dari tabel lain.
        // Kolom 'kategori' dari tabel 'kas_keluar' akan otomatis terpilih karena ada 'kas_keluar.*'.
        $this->select('kas_keluar.*, masjid.nama_masjid, users.nama as nama_user');

        $this->join('masjid', 'masjid.id_masjid = kas_keluar.id_masjid', 'left');
        $this->join('users', 'users.id_user = kas_keluar.id_user', 'left');

        $this->orderBy('kas_keluar.tanggal', 'DESC');

        // Kembalikan instance Model itu sendiri agar bisa disambung di Controller
        return $this;
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
