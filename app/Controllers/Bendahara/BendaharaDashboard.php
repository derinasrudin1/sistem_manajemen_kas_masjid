<?php

namespace App\Controllers\Bendahara;

use App\Models\KasMasukModel;
use App\Models\KasKeluarModel;
use App\Controllers\BaseController;

class BendaharaDashboard extends BaseController
{
    public function index()
    {
        // 1. Ambil ID Masjid dari session
        $userMasjidId = session()->get('id_masjid');

        // Jika karena suatu alasan bendahara tidak punya id_masjid, beri pesan error.
        if (!$userMasjidId) {
            return redirect()->to('/logout')->with('error', 'Sesi tidak valid. Akun Anda tidak terhubung dengan masjid manapun.');
        }

        // 2. Siapkan Model
        $kasMasukModel = new KasMasukModel();
        $kasKeluarModel = new KasKeluarModel();

        // --- 3. Hitung Data untuk Kartu Statistik (dengan filter masjid) ---
        $total_masuk = $kasMasukModel->where('id_masjid', $userMasjidId)
            ->selectSum('jumlah', 'total')->get()->getRow()->total ?? 0;

        $total_keluar = $kasKeluarModel->where('id_masjid', $userMasjidId)
            ->selectSum('jumlah', 'total')->get()->getRow()->total ?? 0;

        $sisa_saldo = $total_masuk - $total_keluar;
        $persentase = ($total_masuk > 0) ? round(($sisa_saldo / $total_masuk) * 100) : 0;

        // --- 4. Hitung Data untuk Grafik Batang (dengan filter masjid) ---
        $barChartLabels = [];
        $pemasukanData = [];
        $pengeluaranData = [];
        for ($i = 11; $i >= 0; $i--) {
            $datePoint = strtotime("-$i months");
            $month = date('m', $datePoint);
            $year = date('Y', $datePoint);
            $formatter = new \IntlDateFormatter('id_ID', \IntlDateFormatter::NONE, \IntlDateFormatter::NONE, null, null, 'MMMM Y');
            $barChartLabels[] = $formatter->format($datePoint);

            $pemasukanBulanan = $kasMasukModel->where('id_masjid', $userMasjidId) // <-- Filter
                ->where('MONTH(tanggal)', $month)
                ->where('YEAR(tanggal)', $year)
                ->selectSum('jumlah', 'total')->get()->getRow()->total ?? 0;
            $pemasukanData[] = (float) $pemasukanBulanan;

            $pengeluaranBulanan = $kasKeluarModel->where('id_masjid', $userMasjidId) // <-- Filter
                ->where('MONTH(tanggal)', $month)
                ->where('YEAR(tanggal)', $year)
                ->selectSum('jumlah', 'total')->get()->getRow()->total ?? 0;
            $pengeluaranData[] = (float) $pengeluaranBulanan;
        }
        $barChartData = ['labels' => $barChartLabels, 'datasets' => [['label' => 'Pemasukan', 'backgroundColor' => 'rgba(26, 179, 148, 0.5)', 'borderColor' => 'rgb(26, 179, 148)', 'data' => $pemasukanData,], ['label' => 'Pengeluaran', 'backgroundColor' => 'rgba(237, 85, 101, 0.5)', 'borderColor' => 'rgb(237, 85, 101)', 'data' => $pengeluaranData,],],];

        // --- 5. Hitung Data untuk Pie Chart Pemasukan (dengan filter masjid & JOIN) ---
        $pemasukanBySumber = $kasMasukModel->where('kas_masuk.id_masjid', $userMasjidId) // <-- Filter
            ->select('sumber_dana.nama_sumber, SUM(kas_masuk.jumlah) as total')
            ->join('sumber_dana', 'sumber_dana.id_sumber_dana = kas_masuk.id_sumber_dana', 'left')
            ->groupBy('sumber_dana.nama_sumber')->findAll();
        $piePemasukanLabels = [];
        $piePemasukanData = [];
        foreach ($pemasukanBySumber as $row) {
            $piePemasukanLabels[] = $row['nama_sumber'] ?? 'Lainnya';
            $piePemasukanData[] = (float) $row['total'];
        }
        $pieChartPemasukan = ['labels' => $piePemasukanLabels, 'datasets' => [['data' => $piePemasukanData,]]];

        // --- 6. Hitung Data untuk Pie Chart Pengeluaran (dengan filter masjid & JOIN) ---
        $pengeluaranByKategori = $kasKeluarModel->where('kas_keluar.id_masjid', $userMasjidId) // <-- Filter
            ->select('kategori_pengeluaran.nama_kategori, SUM(kas_keluar.jumlah) as total')
            ->join('kategori_pengeluaran', 'kategori_pengeluaran.id_kategori = kas_keluar.id_kategori', 'left')
            ->groupBy('kategori_pengeluaran.nama_kategori')->findAll();
        $piePengeluaranLabels = [];
        $piePengeluaranData = [];
        foreach ($pengeluaranByKategori as $row) {
            $piePengeluaranLabels[] = $row['nama_kategori'] ?? 'Lainnya';
            $piePengeluaranData[] = (float) $row['total'];
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
