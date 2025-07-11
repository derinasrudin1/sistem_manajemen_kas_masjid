<?php

namespace App\Controllers\Bendahara;

use App\Controllers\BaseController;
use App\Models\KasMasukModel;
use App\Models\KasKeluarModel;

class RiwayatTransaksiController extends BaseController
{
    protected $kasMasukModel;
    protected $kasKeluarModel;
    protected $db; // Properti untuk menampung koneksi database

    public function __construct()
    {
        $this->kasMasukModel = new KasMasukModel();
        $this->kasKeluarModel = new KasKeluarModel();
        // PERBAIKAN: Inisialisasi koneksi database
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        // Ambil ID Masjid dari session, ini adalah filter utama
        $idMasjid = session()->get('id_masjid');

        // Ambil filter tanggal dari URL (jika ada)
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        // Ambil data transaksi yang sudah digabung dan difilter
        $transaksi = $this->getMergedTransactions($idMasjid, $startDate, $endDate);

        // Hitung saldo awal berdasarkan filter tanggal
        $saldoAwal = $this->calculateSaldoAwal($idMasjid, $startDate);

        // Hitung total pemasukan dan pengeluaran HANYA dari data yang ditampilkan
        $totalPemasukan = 0;
        $totalPengeluaran = 0;
        foreach ($transaksi as $trx) {
            if ($trx['jenis'] === 'Pemasukan') {
                $totalPemasukan += $trx['jumlah'];
            } else {
                $totalPengeluaran += $trx['jumlah'];
            }
        }

        $data = [
            'title' => 'Riwayat Keuangan',
            'transaksi' => $transaksi,
            'saldoAwal' => $saldoAwal,
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];

        return view('bendahara/riwayat_transaksi/index', $data);
    }

    /**
     * Menggabungkan data dari kas_masuk dan kas_keluar menjadi satu daftar.
     */
    private function getMergedTransactions($idMasjid, $startDate = null, $endDate = null)
    {
        // Query untuk Pemasukan
        $pemasukanQuery = $this->kasMasukModel->builder()
            ->select("tanggal, keterangan, jumlah, 'Pemasukan' as jenis, sumber_dana.nama_sumber as sumber_kategori")
            ->join('sumber_dana', 'sumber_dana.id_sumber_dana = kas_masuk.id_sumber_dana', 'left')
            ->where('kas_masuk.id_masjid', $idMasjid);

        // Query untuk Pengeluaran
        $pengeluaranQuery = $this->kasKeluarModel->builder()
            ->select("tanggal, keterangan, jumlah, 'Pengeluaran' as jenis, kategori as sumber_kategori")
            ->where('kas_keluar.id_masjid', $idMasjid);

        // Terapkan filter tanggal jika ada
        if ($startDate && $endDate) {
            $pemasukanQuery->where('kas_masuk.tanggal >=', $startDate)->where('kas_masuk.tanggal <=', $endDate);
            $pengeluaranQuery->where('kas_keluar.tanggal >=', $startDate)->where('kas_keluar.tanggal <=', $endDate);
        }

        // Gabungkan dengan UNION
        $unionQuery = $pemasukanQuery->union($pengeluaranQuery);
        // Baris ini sekarang akan bekerja karena $this->db sudah ada
        $finalQuery = $this->db->newQuery()->fromSubquery($unionQuery, 'transactions');

        // Urutkan hasil akhir
        return $finalQuery->orderBy('tanggal', 'ASC')->get()->getResultArray();
    }

    /**
     * Menghitung saldo sebelum tanggal mulai laporan.
     */
    private function calculateSaldoAwal($idMasjid, $startDate = null)
    {
        if (!$startDate) {
            return 0;
        }

        $totalMasuk = $this->kasMasukModel->builder()
            ->selectSum('jumlah')
            ->where('id_masjid', $idMasjid)
            ->where('tanggal <', $startDate)
            ->get()->getRow()->jumlah ?? 0;

        $totalKeluar = $this->kasKeluarModel->builder()
            ->selectSum('jumlah')
            ->where('id_masjid', $idMasjid)
            ->where('tanggal <', $startDate)
            ->get()->getRow()->jumlah ?? 0;

        return $totalMasuk - $totalKeluar;
    }
}
