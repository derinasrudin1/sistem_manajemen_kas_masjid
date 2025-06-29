<?php

namespace App\Controllers\Bendahara;

use App\Models\KasMasukModel;
use App\Models\KasKeluarModel;
use App\Models\UserModel;
use App\Controllers\BaseController;


class BendaharaDashboard extends BaseController
{
    protected $kasMasuk;

    public function __construct()
    {
        $this->kasMasuk = new KasMasukModel();
    }

    public function index()
    {
        // 1. Proteksi Halaman
        if (session()->get('role') !== 'bendahara') {
            return redirect()->to('/')->with('error', 'Anda tidak memiliki akses.');
        }

        // 2. Siapkan Model
        $kasMasukModel = new KasMasukModel();
        $kasKeluarModel = new KasKeluarModel();

        // --- 3. Hitung Data untuk Kartu Statistik (Small Boxes) ---
        $total_masuk = $kasMasukModel->selectSum('jumlah', 'total')->get()->getRow()->total ?? 0;
        $total_keluar = $kasKeluarModel->selectSum('jumlah', 'total')->get()->getRow()->total ?? 0;
        $sisa_saldo = $total_masuk - $total_keluar;
        $persentase = ($total_masuk > 0) ? round(($sisa_saldo / $total_masuk) * 100) : 0;

        // --- 4. Hitung Data untuk Grafik Batang (Bar Chart) ---
        $barChartLabels = [];
        $pemasukanData = [];
        $pengeluaranData = [];
        for ($i = 11; $i >= 0; $i--) {
            $datePoint = strtotime("-$i months");
            $month = date('m', $datePoint);
            $year = date('Y', $datePoint);
            $formatter = new \IntlDateFormatter('id_ID', \IntlDateFormatter::NONE, \IntlDateFormatter::NONE, null, null, 'MMMM Y');
            $barChartLabels[] = $formatter->format($datePoint);
            $pemasukanBulanan = $kasMasukModel->where('MONTH(tanggal)', $month)->where('YEAR(tanggal)', $year)->selectSum('jumlah', 'total')->get()->getRow()->total ?? 0;
            $pemasukanData[] = $pemasukanBulanan;
            $pengeluaranBulanan = $kasKeluarModel->where('MONTH(tanggal)', $month)->where('YEAR(tanggal)', $year)->selectSum('jumlah', 'total')->get()->getRow()->total ?? 0;
            $pengeluaranData[] = $pengeluaranBulanan;
        }
        $barChartData = ['labels' => $barChartLabels, 'datasets' => [['label' => 'Pemasukan', 'backgroundColor' => 'rgba(26, 179, 148, 0.5)', 'borderColor' => 'rgb(26, 179, 148)', 'data' => $pemasukanData,], ['label' => 'Pengeluaran', 'backgroundColor' => 'rgba(237, 85, 101, 0.5)', 'borderColor' => 'rgb(237, 85, 101)', 'data' => $pengeluaranData,],],];

        // --- 5. Hitung Data untuk Pie Chart Pemasukan ---
        $pemasukanBySumber = $kasMasukModel->select('sumber, SUM(jumlah) as total')->groupBy('sumber')->findAll();
        $piePemasukanLabels = [];
        $piePemasukanData = [];
        foreach ($pemasukanBySumber as $row) {
            $piePemasukanLabels[] = $row['sumber'];
            $piePemasukanData[] = (float) $row['total']; // Diubah menjadi angka
        }
        $pieChartPemasukan = ['labels' => $piePemasukanLabels, 'datasets' => [['data' => $piePemasukanData,]]];

        // --- 6. Hitung Data untuk Pie Chart Pengeluaran ---
        $pengeluaranByKategori = $kasKeluarModel->select('kategori, SUM(jumlah) as total')->groupBy('kategori')->findAll();
        $piePengeluaranLabels = [];
        $piePengeluaranData = [];
        foreach ($pengeluaranByKategori as $row) {
            $piePengeluaranLabels[] = $row['kategori'];
            $piePengeluaranData[] = (float) $row['total']; // Diubah menjadi angka
        }
        $pieChartPengeluaran = ['labels' => $piePengeluaranLabels, 'datasets' => [['data' => $piePengeluaranData,]]];

        // --- 7. Siapkan Semua Data untuk Dikirim ke View ---
        $data = [
            'title' => 'Dashboard',
            'total_masuk' => $total_masuk,
            'total_keluar' => $total_keluar,
            'sisa_saldo' => $sisa_saldo,
            'persentase' => $persentase,
            'barChartData' => $barChartData,
            'pieChartPemasukan' => $pieChartPemasukan,
            'pieChartPengeluaran' => $pieChartPengeluaran,
        ];


        return view('dashboard/dashboard_bendahara', $data);
    }


}
