<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KasMasukModel;
use App\Models\KasKeluarModel;
use App\Models\MasjidModel;

class RiwayatKeuangan extends BaseController
{
    protected $kasMasukModel;
    protected $kasKeluarModel;
    protected $masjidModel;

    public function __construct()
    {
        $this->kasMasukModel = new KasMasukModel();
        $this->kasKeluarModel = new KasKeluarModel();
        $this->masjidModel = new MasjidModel();
    }

    public function index()
    {
        $masjid = $this->request->getGet('masjid');
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        $data = [
            'title' => 'Riwayat Keuangan Masjid',
            'masjidList' => $this->masjidModel->findAll(),
            'selectedMasjid' => $masjid,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'transaksi' => $this->getMergedTransactions($masjid, $startDate, $endDate),
            'saldoAwal' => $this->calculateSaldoAwal($masjid, $startDate),
            'totalPemasukan' => 0,
            'totalPengeluaran' => 0,
            'validation' => \Config\Services::validation()
        ];

        // Hitung total pemasukan dan pengeluaran
        foreach ($data['transaksi'] as $trx) {
            if ($trx['jenis'] === 'masuk') {
                $data['totalPemasukan'] += $trx['jumlah'];
            } else {
                $data['totalPengeluaran'] += $trx['jumlah'];
            }
        }

        return view('admin/riwayat_keuangan/index', $data);
    }

    public function exportPdf()
    {
        $masjid = $this->request->getGet('masjid');
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        $data = [
            'title' => 'Laporan Keuangan Masjid',
            'transaksi' => $this->getMergedTransactions($masjid, $startDate, $endDate),
            'saldoAwal' => $this->calculateSaldoAwal($masjid, $startDate),
            'totalPemasukan' => 0,
            'totalPengeluaran' => 0,
            'masjid' => $masjid ? $this->masjidModel->find($masjid) : null,
            'startDate' => $startDate,
            'endDate' => $endDate
        ];

        // Hitung total
        foreach ($data['transaksi'] as $trx) {
            if ($trx['jenis'] === 'masuk') {
                $data['totalPemasukan'] += $trx['jumlah'];
            } else {
                $data['totalPengeluaran'] += $trx['jumlah'];
            }
        }

        $html = view('admin/riwayat_keuangan/export_pdf', $data);

        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('defaultFont', 'Arial');

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('laporan-keuangan-masjid.pdf', ['Attachment' => true]);
    }

    private function getMergedTransactions($masjid = null, $startDate = null, $endDate = null)
    {
        // Query kas masuk
        $builderMasuk = $this->kasMasukModel->builder();
        $builderMasuk->select("
            id_kas_masuk as id,
            tanggal,
            jumlah,
            sumber as keterangan,
            'masuk' as jenis,
            id_masjid,
            NULL as kategori,
            NULL as bukti
        ");

        if ($masjid) {
            $builderMasuk->where('id_masjid', $masjid);
        }

        if ($startDate && $endDate) {
            $builderMasuk->where('tanggal >=', $startDate);
            $builderMasuk->where('tanggal <=', $endDate);
        }

        $kasMasuk = $builderMasuk->get()->getResultArray();

        // Query kas keluar
        $builderKeluar = $this->kasKeluarModel->builder();
        $builderKeluar->select("
            id_kas_keluar as id,
            tanggal,
            jumlah,
            keterangan,
            'keluar' as jenis,
            id_masjid,
            kategori,
            bukti
        ");

        if ($masjid) {
            $builderKeluar->where('id_masjid', $masjid);
        }

        if ($startDate && $endDate) {
            $builderKeluar->where('tanggal >=', $startDate);
            $builderKeluar->where('tanggal <=', $endDate);
        }

        $kasKeluar = $builderKeluar->get()->getResultArray();

        // Gabungkan dan urutkan berdasarkan tanggal
        $merged = array_merge($kasMasuk, $kasKeluar);
        usort($merged, function ($a, $b) {
            return strtotime($a['tanggal']) - strtotime($b['tanggal']);
        });

        return $merged;
    }

    private function calculateSaldoAwal($masjid = null, $startDate = null)
    {
        if (!$startDate) {
            return 0;
        }

        // Hitung total pemasukan sebelum tanggal awal
        $builderMasuk = $this->kasMasukModel->builder();
        $builderMasuk->selectSum('jumlah');
        if ($masjid) {
            $builderMasuk->where('id_masjid', $masjid);
        }
        $builderMasuk->where('tanggal <', $startDate);
        $totalMasuk = $builderMasuk->get()->getRow()->jumlah ?? 0;

        // Hitung total pengeluaran sebelum tanggal awal
        $builderKeluar = $this->kasKeluarModel->builder();
        $builderKeluar->selectSum('jumlah');
        if ($masjid) {
            $builderKeluar->where('id_masjid', $masjid);
        }
        $builderKeluar->where('tanggal <', $startDate);
        $totalKeluar = $builderKeluar->get()->getRow()->jumlah ?? 0;

        return $totalMasuk - $totalKeluar;
    }
}