<?php

namespace App\Controllers\Admin;

use App\Models\KasMasukModel;
use App\Models\KasKeluarModel;
use App\Controllers\BaseController;

class AdminDashboard extends BaseController
{
    protected $kasMasuk;

    public function __construct()
    {
        $this->kasMasuk = new KasMasukModel();
    }

    public function index()
    {
        // 🔐 Proteksi role hanya untuk 'admin'
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }

        $kasMasukModel = new KasMasukModel();
        $kasKeluarModel = new KasKeluarModel();

        $data['kas_masuk'] = $kasMasukModel->orderBy('tanggal', 'DESC')->findAll();

        $data['total_masuk'] = $kasMasukModel->selectSum('jumlah')->first()['jumlah'] ?? 0;
        $data['total_keluar'] = $kasKeluarModel->selectSum('jumlah')->first()['jumlah'] ?? 0;
        $data['sisa_saldo'] = $data['total_masuk'] - $data['total_keluar'];

        if ($data['total_masuk'] > 0) {
            $data['persentase'] = round(($data['sisa_saldo'] / $data['total_masuk']) * 100);
        } else {
            $data['persentase'] = 0;
        }

        return view('dashboard/index', $data);
    }
}
