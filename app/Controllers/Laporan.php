<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LaporanModel;
use App\Models\MasjidModel;

class Laporan extends BaseController
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
            'title' => 'Transparansi Keuangan Masjid',
            'laporan' => $this->laporanModel->where('status', 'published')
                              ->orderBy('created_at', 'DESC')
                              ->findAll()
        ];

        return view('transparansi_keuangan/public_index', $data);
    }

    public function view($id)
    {
        $laporan = $this->laporanModel->join('masjid', 'masjid.id_masjid = laporan.id_masjid')
                         ->find($id);

        if (!$laporan || $laporan['status'] !== 'published') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => $laporan['judul'],
            'laporan' => $laporan,
            'masjid' => $this->masjidModel->find($laporan['id_masjid'])
        ];

        return view('transparansi_keuangan/public_view', $data);
    }
}