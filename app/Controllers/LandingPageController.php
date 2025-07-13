<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KasMasukModel;
use App\Models\KasKeluarModel;
use App\Models\MasjidModel;

class LandingPageController extends BaseController
{
    protected $kasMasukModel;
    protected $kasKeluarModel;
    protected $masjidModel; // Definisikan properti
    protected $db;

    public function __construct()
    {
        $this->kasMasukModel = new KasMasukModel();
        $this->kasKeluarModel = new KasKeluarModel();
        $this->masjidModel = new MasjidModel(); // Inisialisasi MasjidModel
        $this->db = \Config\Database::connect();
    }

    /**
     * Menampilkan halaman utama publik dengan filter.
     */
    public function index()
    {
        // Ambil ID masjid yang dipilih dari filter (URL)
        $idMasjid = $this->request->getGet('id_masjid');

        $data = [
            'title' => 'Selamat Datang di Sistem Kas Masjid',
            'transaksi' => $this->getMergedTransactions($idMasjid, 50), // Kirim idMasjid ke fungsi
            'masjidList' => $this->masjidModel->findAll(), // Ambil semua data masjid untuk dropdown
            'selectedMasjid' => $idMasjid, // Kirim ID yang dipilih untuk menandai di dropdown
        ];

        return view('public_landing', $data);
    }


    private function getMergedTransactions($idMasjid = null, $limit = null)
    {
        // Query untuk Pemasukan
        $pemasukanQuery = $this->kasMasukModel->builder()
            ->select("kas_masuk.tanggal, 'Pemasukan' as jenis, kas_masuk.keterangan, kas_masuk.jumlah, masjid.nama_masjid")
            ->join('sumber_dana', 'sumber_dana.id_sumber_dana = kas_masuk.id_sumber_dana', 'left')
            ->join('masjid', 'masjid.id_masjid = kas_masuk.id_masjid', 'left');

        // Query untuk Pengeluaran
        $pengeluaranQuery = $this->kasKeluarModel->builder()
            ->select("kas_keluar.tanggal, 'Pengeluaran' as jenis, kas_keluar.keterangan, kas_keluar.jumlah, masjid.nama_masjid")
            ->join('masjid', 'masjid.id_masjid = kas_keluar.id_masjid', 'left');

        // Terapkan filter masjid jika dipilih
        if ($idMasjid) {
            $pemasukanQuery->where('kas_masuk.id_masjid', $idMasjid);
            $pengeluaranQuery->where('kas_keluar.id_masjid', $idMasjid);
        }

        // Gabungkan dengan UNION
        $unionQuery = $pemasukanQuery->union($pengeluaranQuery);
        $finalQuery = $this->db->newQuery()->fromSubquery($unionQuery, 'transactions');

        $finalQuery->orderBy('tanggal', 'DESC');
        if ($limit) {
            $finalQuery->limit($limit);
        }

        return $finalQuery->get()->getResultArray();
    }
}
