<?php

namespace App\Controllers\Bendahara;

use App\Models\KasMasukModel;
use App\Models\KasKeluarModel;
use App\Controllers\BaseController;

class BendaharaDashboard extends BaseController
{
    public function index()
    {
        $userMasjidId = session()->get('id_masjid');

        if (!$userMasjidId) {
            return redirect()->to('/logout')->with('error', 'Sesi tidak valid. Akun Anda tidak terhubung dengan masjid manapun.');
        }

        $kasMasukModel = new KasMasukModel();
        $kasKeluarModel = new KasKeluarModel();

        $currentMonth = date('m');
        $currentYear = date('Y');

        $total_masuk_bulan_ini = $kasMasukModel->where('id_masjid', $userMasjidId)
            ->where('MONTH(tanggal)', $currentMonth)
            ->where('YEAR(tanggal)', $currentYear)
            ->selectSum('jumlah', 'total')->get()->getRow()->total ?? 0;

        $total_keluar_bulan_ini = $kasKeluarModel->where('id_masjid', $userMasjidId)
            ->where('MONTH(tanggal)', $currentMonth)
            ->where('YEAR(tanggal)', $currentYear)
            ->selectSum('jumlah', 'total')->get()->getRow()->total ?? 0;

        // $total_masuk_all_time = $kasMasukModel->where('id_masjid', $userMasjidId)
        //     ->selectSum('jumlah', 'total')->get()->getRow()->total ?? 0;

        // $total_keluar_all_time = $kasKeluarModel->where('id_masjid', $userMasjidId)
        //     ->selectSum('jumlah', 'total')->get()->getRow()->total ?? 0;

        // $sisa_saldo = $total_masuk_all_time - $total_keluar_all_time;
        // $persentase = ($total_masuk_all_time > 0) ? round(($sisa_saldo / $total_masuk_all_time) * 100) : 0;

        $total_masuk = $kasMasukModel->where('id_masjid', $userMasjidId)
            ->selectSum('jumlah', 'total')->get()->getRow()->total ?? 0;

        $total_keluar = $kasKeluarModel->where('id_masjid', $userMasjidId)
            ->selectSum('jumlah', 'total')->get()->getRow()->total ?? 0;

        $sisa_saldo = $total_masuk - $total_keluar;
        $persentase = ($total_masuk > 0) ? round(($sisa_saldo / $total_masuk) * 100) : 0;

        // Hitung Data Grafik Batang (dengan filter masjid) ---
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

        // Hitung Data untuk Pie Chart Pemasukan (dengan filter masjid & JOIN) ---
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

        $pengeluaranByKategori = $kasKeluarModel->where('id_masjid', $userMasjidId)
            ->select('kategori, SUM(jumlah) as total')
            ->groupBy('kategori')->findAll();
        $piePengeluaranLabels = [];
        $piePengeluaranData = [];
        foreach ($pengeluaranByKategori as $row) {
            $piePengeluaranLabels[] = $row['kategori'] ?? 'Lainnya';
            $piePengeluaranData[] = (float) $row['total'];
        }
        $pieChartPengeluaran = ['labels' => $piePengeluaranLabels, 'datasets' => [['data' => $piePengeluaranData,]]];

        $pemasukanBulananBySumber = $kasMasukModel->where('kas_masuk.id_masjid', $userMasjidId)
            ->where('MONTH(tanggal)', $currentMonth)->where('YEAR(tanggal)', $currentYear)
            ->select('sumber_dana.nama_sumber, SUM(kas_masuk.jumlah) as total')
            ->join('sumber_dana', 'sumber_dana.id_sumber_dana = kas_masuk.id_sumber_dana', 'left')
            ->groupBy('sumber_dana.nama_sumber')->findAll();
        $piePemasukanBulananLabels = [];
        $piePemasukanBulananData = [];
        foreach ($pemasukanBulananBySumber as $row) {
            $piePemasukanBulananLabels[] = $row['nama_sumber'] ?? 'Lainnya';
            $piePemasukanBulananData[] = (float) $row['total'];
        }
        $pieChartPemasukanBulanan = ['labels' => $piePemasukanBulananLabels, 'datasets' => [['data' => $piePemasukanBulananData]]];

        $pengeluaranBulananByKategori = $kasKeluarModel->where('id_masjid', $userMasjidId)
            ->where('MONTH(tanggal)', $currentMonth)->where('YEAR(tanggal)', $currentYear)
            ->select('kategori, SUM(jumlah) as total')
            ->groupBy('kategori')->findAll();
        $piePengeluaranBulananLabels = [];
        $piePengeluaranBulananData = [];
        foreach ($pengeluaranBulananByKategori as $row) {
            $piePengeluaranBulananLabels[] = $row['kategori'] ?? 'Lainnya';
            $piePengeluaranBulananData[] = (float) $row['total'];
        }
        $pieChartPengeluaranBulanan = ['labels' => $piePengeluaranBulananLabels, 'datasets' => [['data' => $piePengeluaranBulananData]]];

        // Siapkan Semua Data untuk Dikirim ke View ---
        $data = [
            'title' => 'Dashboard',
            'total_masuk' => $total_masuk,
            'total_keluar' => $total_keluar,
            'sisa_saldo' => $sisa_saldo,
            'persentase' => $persentase,
            'barChartData' => $barChartData,
            'pieChartPemasukan' => $pieChartPemasukan,
            'pieChartPengeluaran' => $pieChartPengeluaran,
            'total_masuk_bulan_ini' => $total_masuk_bulan_ini,
            'total_keluar_bulan_ini' => $total_keluar_bulan_ini,
            'periode_bulan_ini' => 'Bulan ' . date('F Y'),
            'pieChartPemasukanBulanan' => $pieChartPemasukanBulanan,
            'pieChartPengeluaranBulanan' => $pieChartPengeluaranBulanan,
        ];

        return view('dashboard/dashboard_bendahara', $data);
    }
}
