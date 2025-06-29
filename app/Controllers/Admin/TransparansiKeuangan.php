<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KasMasukModel;
use App\Models\KasKeluarModel;
use App\Models\MasjidModel;
use App\Models\LaporanModel;

class TransparansiKeuangan extends BaseController
{
    protected $kasMasukModel;
    protected $kasKeluarModel;
    protected $masjidModel;
    protected $laporanModel;

    public function __construct()
    {
        $this->kasMasukModel = new KasMasukModel();
        $this->kasKeluarModel = new KasKeluarModel();
        $this->masjidModel = new MasjidModel();
        $this->laporanModel = new LaporanModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Transparansi Keuangan Masjid',
            'masjidList' => $this->masjidModel->findAll(),
            'laporan' => $this->laporanModel->getLaporanWithDetails()
        ];

        return view('admin/transparansi_keuangan/index', $data);
    }

    public function createLaporan()
    {
        $data = [
            'title' => 'Buat Laporan Transparansi',
            'masjidList' => $this->masjidModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/transparansi_keuangan/create_laporan', $data);
    }

    public function storeLaporan()
    {
        if (
            !$this->validate([
                'judul' => 'required|max_length[255]',
                'id_masjid' => 'required|numeric',
                'periode_awal' => 'required|valid_date',
                'periode_akhir' => 'required|valid_date',
                'catatan' => 'permit_empty'
            ])
        ) {
            return redirect()->back()->withInput();
        }

        // Hitung total pemasukan dan pengeluaran
        $masjidId = $this->request->getVar('id_masjid');
        $startDate = $this->request->getVar('periode_awal');
        $endDate = $this->request->getVar('periode_akhir');

        $totalPemasukan = $this->kasMasukModel->where('id_masjid', $masjidId)
            ->where('tanggal >=', $startDate)
            ->where('tanggal <=', $endDate)
            ->selectSum('jumlah')
            ->get()
            ->getRow()
            ->jumlah ?? 0;

        $totalPengeluaran = $this->kasKeluarModel->where('id_masjid', $masjidId)
            ->where('tanggal >=', $startDate)
            ->where('tanggal <=', $endDate)
            ->selectSum('jumlah')
            ->get()
            ->getRow()
            ->jumlah ?? 0;

        $saldoAwal = $this->calculateSaldoAwal($masjidId, $startDate);
        $saldoAkhir = $saldoAwal + $totalPemasukan - $totalPengeluaran;

        $this->laporanModel->save([
            'id_masjid' => $masjidId,
            'id_user' => session()->get('id_user'),
            'judul' => $this->request->getVar('judul'),
            'periode_awal' => $startDate,
            'periode_akhir' => $endDate,
            'total_pemasukan' => $totalPemasukan,
            'total_pengeluaran' => $totalPengeluaran,
            'saldo_akhir' => $saldoAkhir,
            'catatan' => $this->request->getVar('catatan')
        ]);

        session()->setFlashdata('pesan', 'Laporan transparansi berhasil dibuat');
        return redirect()->to('/admin/transparansi-keuangan');
    }

    public function publish($id)
    {
        $this->laporanModel->update($id, ['status' => 'published']);
        session()->setFlashdata('pesan', 'Laporan berhasil dipublikasikan');
        return redirect()->back();
    }

    public function unpublish($id)
    {
        $this->laporanModel->update($id, ['status' => 'draft']);
        session()->setFlashdata('pesan', 'Laporan tidak lagi dipublikasikan');
        return redirect()->back();
    }

    public function deleteLaporan($id)
    {
        $this->laporanModel->delete($id);
        session()->setFlashdata('pesan', 'Laporan berhasil dihapus');
        return redirect()->to('/admin/transparansi-keuangan');
    }

    private function calculateSaldoAwal($masjidId, $startDate)
    {
        $totalMasuk = $this->kasMasukModel->where('id_masjid', $masjidId)
            ->where('tanggal <', $startDate)
            ->selectSum('jumlah')
            ->get()
            ->getRow()
            ->jumlah ?? 0;

        $totalKeluar = $this->kasKeluarModel->where('id_masjid', $masjidId)
            ->where('tanggal <', $startDate)
            ->selectSum('jumlah')
            ->get()
            ->getRow()
            ->jumlah ?? 0;

        return $totalMasuk - $totalKeluar;
    }
}