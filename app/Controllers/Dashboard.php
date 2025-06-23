<?php

namespace App\Controllers;

use App\Models\KasMasukModel;
use App\Models\KasKeluarModel;
use App\Models\UserModel;


class Dashboard extends BaseController
{
    protected $kasMasuk;

    public function __construct()
    {
        $this->kasMasuk = new KasMasukModel();
    }

    public function index()
    {
        $kasMasukModel = new KasMasukModel();
        $kasKeluarModel = new KasKeluarModel();

        $data['kas_masuk'] = $kasMasukModel->orderBy('tanggal', 'DESC')->findAll();

        // Hitung total
        $data['total_masuk'] = $kasMasukModel->selectSum('jumlah')->first()['jumlah'] ?? 0;
        $data['total_keluar'] = $kasKeluarModel->selectSum('jumlah')->first()['jumlah'] ?? 0;
        $data['sisa_saldo'] = $data['total_masuk'] - $data['total_keluar'];

        if ($data['total_masuk'] > 0) {
            // Lakukan perhitungan jika aman
            $persentase_raw = ($data['sisa_saldo'] / $data['total_masuk']) * 100;

            // Bulatkan hasilnya (misalnya dengan 2 desimal)
            // $data['persentase'] = round($persentase_raw, 2);
            $data['persentase'] = round($persentase_raw);
        } else {
            // Jika total_masuk adalah 0, set persentase ke 0 untuk menghindari error
            $data['persentase'] = 0;
        }

        // $data['kas_masuk'] = $this->kasMasuk->orderBy('tanggal', 'DESC')->findAll();
        return view('dashboard/index', $data);
    }

}
