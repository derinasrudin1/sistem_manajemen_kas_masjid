<?php

namespace App\Controllers\Bendahara;

use App\Controllers\BaseController;
use App\Models\ModelKasKeluar; // PERUBAHAN: Disesuaikan dengan nama model baru
use App\Models\KategoriPengeluaranModel;

class KasKeluarController extends BaseController
{
    protected $kasKeluarModel;
    protected $kategoriModel;
    protected $uploadPath;

    public function __construct()
    {
        // PERUBAHAN: Disesuaikan dengan nama model baru
        $this->kasKeluarModel = new ModelKasKeluar();
        $this->kategoriModel = new KategoriPengeluaranModel();
        $this->uploadPath = FCPATH . 'uploads/bukti_kas_keluar/';

        if (!is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0777, true);
        }
    }

    public function index()
    {
        $userMasjidId = session()->get('id_masjid');

        $data = [
            'title' => 'Kas Keluar',
            'kas_keluar' => $this->kasKeluarModel->getKasKeluarWithDetails()
                ->where('kas_keluar.id_masjid', $userMasjidId)
                ->findAll(),
        ];

        return view('bendahara/kas_keluar/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Kas Keluar',
            'kategori' => $this->kategoriModel->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('bendahara/kas_keluar/create', $data);
    }

    public function store()
    {
        $rules = [
            'tanggal' => 'required|valid_date',
            'jumlah' => 'required|numeric|greater_than[0]',
            // 'id_kategori' => 'required|numeric',
            'kategori' => 'required',

            // 'bukti' => ['rules' => 'uploaded[bukti]|is_image[bukti]|max_size[bukti,2048]']
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // $fileBukti = $this->request->getFile('bukti');
        // $namaBukti = $fileBukti->getRandomName();
        // $fileBukti->move($this->uploadPath, $namaBukti);

        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'jumlah' => $this->request->getPost('jumlah'),
            // 'id_kategori' => $this->request->getPost('id_kategori'),
            'kategori' => $this->request->getVar('kategori'),

            'keterangan' => $this->request->getPost('keterangan'),
            // 'bukti' => $namaBukti,
            'id_user' => session()->get('id_user'),
            'id_masjid' => session()->get('id_masjid')
        ];

        $this->kasKeluarModel->save($data);
        return redirect()->to('/bendahara/kas-keluar')->with('success', 'Data kas keluar berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $userMasjidId = session()->get('id_masjid');
        $kasKeluar = $this->kasKeluarModel->where('id_kas_keluar', $id)
            ->where('id_masjid', $userMasjidId)
            ->first();

        if (!$kasKeluar) {
            return redirect()->to('/bendahara/kas-keluar')->with('error', 'Data tidak ditemukan atau Anda tidak memiliki hak akses.');
        }

        $data = [
            'title' => 'Edit Kas Keluar',
            'kasKeluar' => $kasKeluar,
            'kategori' => $this->kategoriModel->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('bendahara/kas_keluar/edit', $data);
    }

    public function update($id)
    {
        $userMasjidId = session()->get('id_masjid');
        $existingData = $this->kasKeluarModel->where('id_kas_keluar', $id)
            ->where('id_masjid', $userMasjidId)
            ->first();

        if (!$existingData) {
            return redirect()->to('/bendahara/kas-keluar')->with('error', 'Data tidak ditemukan atau Anda tidak memiliki hak akses.');
        }

        $rules = [
            'tanggal' => 'required|valid_date',
            'jumlah' => 'required|numeric|greater_than[0]',
            // 'id_kategori' => 'required|numeric',
            'kategori' => 'required',

        ];

        $fileBukti = $this->request->getFile('bukti');
        if ($fileBukti && $fileBukti->isValid()) {
            $rules['bukti'] = ['rules' => 'is_image[bukti]|max_size[bukti,2048]'];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'jumlah' => $this->request->getPost('jumlah'),
            // 'id_kategori' => $this->request->getPost('id_kategori'),
            'kategori' => 'required',

            'keterangan' => $this->request->getPost('keterangan'),
        ];

        if ($fileBukti && $fileBukti->isValid()) {
            if ($existingData['bukti'] && file_exists($this->uploadPath . $existingData['bukti'])) {
                unlink($this->uploadPath . $existingData['bukti']);
            }
            $namaBuktiBaru = $fileBukti->getRandomName();
            $fileBukti->move($this->uploadPath, $namaBuktiBaru);
            $data['bukti'] = $namaBuktiBaru;
        }

        $this->kasKeluarModel->update($id, $data);
        return redirect()->to('/bendahara/kas-keluar')->with('success', 'Data kas keluar berhasil diperbarui.');
    }

    public function delete($id)
    {
        $userMasjidId = session()->get('id_masjid');
        $kasKeluar = $this->kasKeluarModel->where('id_kas_keluar', $id)
            ->where('id_masjid', $userMasjidId)
            ->first();

        if (!$kasKeluar) {
            return redirect()->to('/bendahara/kas-keluar')->with('error', 'Data tidak ditemukan atau Anda tidak memiliki hak akses.');
        }

        if ($kasKeluar['bukti'] && file_exists($this->uploadPath . $kasKeluar['bukti'])) {
            unlink($this->uploadPath . $kasKeluar['bukti']);
        }

        $this->kasKeluarModel->delete($id);
        return redirect()->to('/bendahara/kas-keluar')->with('success', 'Data kas keluar berhasil dihapus.');
    }
}
