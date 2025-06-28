<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LaporanModel;
use App\Models\MasjidModel;

class LaporanController extends BaseController
{
    protected $laporanModel;
    protected $masjidModel;

    public function __construct()
    {
        $this->laporanModel = new LaporanModel();
        $this->masjidModel = new MasjidModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Master Data Laporan',
            'laporans' => $this->laporanModel->getLaporanWithRelations()->findAll(),
            'masjids' => $this->masjidModel->findAll()
        ];

        return view('admin/laporan/index', $data);
    }

    public function generate()
    {
        $data = [
            'title' => 'Generate Laporan Baru',
            'masjids' => $this->masjidModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/laporan/generate', $data);
    }

    public function store()
    {
        $rules = [
            'id_masjid' => 'required|numeric',
            'judul' => 'required|max_length[255]',
            'periode_awal' => 'required|valid_date',
            'periode_akhir' => 'required|valid_date',
            'catatan' => 'permit_empty'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Hitung total pemasukan dan pengeluaran
        $totals = $this->calculateTotals(
            $this->request->getPost('id_masjid'),
            $this->request->getPost('periode_awal'),
            $this->request->getPost('periode_akhir')
        );

        $data = [
            'id_masjid' => $this->request->getPost('id_masjid'),
            'id_user' => session()->get('id'),
            'judul' => $this->request->getPost('judul'),
            'periode_awal' => $this->request->getPost('periode_awal'),
            'periode_akhir' => $this->request->getPost('periode_akhir'),
            'total_pemasukan' => $totals['pemasukan'],
            'total_pengeluaran' => $totals['pengeluaran'],
            'saldo_akhir' => $totals['pemasukan'] - $totals['pengeluaran'],
            'catatan' => $this->request->getPost('catatan')
        ];

        $this->laporanModel->save($data);

        return redirect()->to('/admin/laporan')->with('message', 'Laporan berhasil digenerate');
    }

    public function show($id)
    {
        $laporan = $this->laporanModel->getLaporanWithRelations()->find($id);

        if (!$laporan) {
            return redirect()->to('/admin/laporan')->with('error', 'Laporan tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Laporan',
            'laporan' => $laporan,
            'transaksi' => $this->getTransaksiLaporan(
                $laporan['id_masjid'],
                $laporan['periode_awal'],
                $laporan['periode_akhir']
            )
        ];

        return view('admin/laporan/show', $data);
    }

    public function print($id)
    {
        $laporan = $this->laporanModel->getLaporanWithRelations()->find($id);

        if (!$laporan) {
            return redirect()->to('/admin/laporan')->with('error', 'Laporan tidak ditemukan');
        }

        $data = [
            'title' => 'Cetak Laporan',
            'laporan' => $laporan,
            'transaksi' => $this->getTransaksiLaporan(
                $laporan['id_masjid'],
                $laporan['periode_awal'],
                $laporan['periode_akhir']
            )
        ];

        return view('admin/laporan/print', $data);
    }

    public function delete($id)
    {
        $this->laporanModel->delete($id);
        return redirect()->to('/admin/laporan')->with('message', 'Laporan berhasil dihapus');
    }

    protected function calculateTotals($idMasjid, $periodeAwal, $periodeAkhir)
    {
        $db = \Config\Database::connect();

        // Hitung total pemasukan
        $pemasukan = $db->table('kas_masuk')
            ->selectSum('jumlah')
            ->where('id_masjid', $idMasjid)
            ->where('tanggal >=', $periodeAwal)
            ->where('tanggal <=', $periodeAkhir)
            ->get()
            ->getRow()->jumlah ?? 0;

        // Hitung total pengeluaran
        $pengeluaran = $db->table('kas_keluar')
            ->selectSum('jumlah')
            ->where('id_masjid', $idMasjid)
            ->where('tanggal >=', $periodeAwal)
            ->where('tanggal <=', $periodeAkhir)
            ->get()
            ->getRow()->jumlah ?? 0;

        return [
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran
        ];
    }

    protected function getTransaksiLaporan($idMasjid, $periodeAwal, $periodeAkhir)
    {
        $db = \Config\Database::connect();

        // Gabungkan transaksi masuk dan keluar
        $masuk = $db->table('kas_masuk')
            ->select("'masuk' as jenis, tanggal, jumlah, sumber as keterangan, bukti")
            ->where('id_masjid', $idMasjid)
            ->where('tanggal >=', $periodeAwal)
            ->where('tanggal <=', $periodeAkhir);

        $keluar = $db->table('kas_keluar')
            ->select("'keluar' as jenis, tanggal, jumlah, kategori as keterangan, bukti")
            ->where('id_masjid', $idMasjid)
            ->where('tanggal >=', $periodeAwal)
            ->where('tanggal <=', $periodeAkhir);

        return $masuk->union($keluar)
            ->orderBy('tanggal', 'ASC')
            ->get()
            ->getResultArray();
    }
}