<?php

namespace App\Controllers;
use App\Models\KasMasukModel;
use App\Models\KasKeluarModel;

class RiwayatTransaksi extends BaseController
{
    public function index()
    {
        $kasMasukModel = new KasMasukModel();
        $kasKeluarModel = new KasKeluarModel();
        $kasMasuk = $kasMasukModel
            ->select("tanggal, 'Masuk' AS jenis, jumlah, sumber, '-' AS kategori, keterangan")
            ->findAll();

        $kasKeluar = $kasKeluarModel
            ->select("tanggal, 'Keluar' AS jenis, jumlah, '-' AS sumber, kategori, keterangan")
            ->findAll();

        $riwayat = array_merge($kasMasuk, $kasKeluar);

        // Urutkan berdasarkan tanggal DESC
        usort($riwayat, fn($a, $b) => strtotime($b['tanggal']) - strtotime($a['tanggal']));

        // Hitung total
        $totalMasuk = $kasMasukModel->selectSum('jumlah')->first()['jumlah'];
        $totalKeluar = $kasKeluarModel->selectSum('jumlah')->first()['jumlah'];
        $sisaSaldo = $totalMasuk - $totalKeluar;

        return view('riwayat/index', [
            'title' => 'Riwayat Transaksi',
            'riwayat' => $riwayat,
            'totalMasuk' => $totalMasuk,
            'totalKeluar' => $totalKeluar,
            'sisaSaldo' => $sisaSaldo
        ]);
    }
}
