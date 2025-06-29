<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KasKeluarModel;
use App\Models\KategoriPengeluaranModel;
use App\Models\MasjidModel;

class KasKeluar extends BaseController
{
    protected $kasKeluarModel;
    protected $kategoriModel;
    protected $masjidModel;

    public function __construct()
    {
        $this->kasKeluarModel = new KasKeluarModel();
        $this->kategoriModel = new KategoriPengeluaranModel();
        $this->masjidModel = new MasjidModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Kas Keluar',
            'kasKeluar' => $this->kasKeluarModel->getKasKeluarWithDetails(),
            'kategori' => $this->kategoriModel->findAll(),
            'masjid' => $this->masjidModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/kas_keluar/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Kas Keluar',
            'kategori' => $this->kategoriModel->findAll(),
            'masjid' => $this->masjidModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/kas_keluar/create', $data);
    }

    public function store()
    {
        // Validasi input
        $rules = [
            'tanggal' => 'required',
            'jumlah' => 'required|numeric',
            'kategori' => 'required',
            // 'bukti' => [
            //     'rules' => 'uploaded[bukti]|max_size[bukti,2048]|is_image[bukti]|mime_in[bukti,image/jpg,image/jpeg,image/png]',
                
            // ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            // Handle file upload
            // $fileBukti = $this->request->getFile('bukti');
            // if (!$fileBukti->isValid()) {
            //     throw new RuntimeException($fileBukti->getErrorString());
            // }

            // $namaBukti = $fileBukti->getRandomName();
            // $fileBukti->move(WRITEPATH . 'uploads/bukti_kas_keluar', $namaBukti);

            // Simpan data ke database
            $data = [
                'tanggal' => $this->request->getVar('tanggal'),
                'jumlah' => $this->request->getVar('jumlah'),
                'kategori' => $this->request->getVar('kategori'),
                'keterangan' => $this->request->getVar('keterangan'),
                // 'bukti' => $namaBukti,
                'id_user' => session()->get('id_user'),
                'id_masjid' => $this->request->getVar('id_masjid') ?: null
            ];

            if (!$this->kasKeluarModel->save($data)) {
                // Hapus file yang sudah diupload jika gagal simpan ke database
                // if (file_exists(WRITEPATH . 'uploads/bukti_kas_keluar/' . $namaBukti)) {
                //     unlink(WRITEPATH . 'uploads/bukti_kas_keluar/' . $namaBukti);
                // }
                throw new RuntimeException('Gagal menyimpan data ke database');
            }

            session()->setFlashdata('success', 'Data kas keluar berhasil ditambahkan');
            return redirect()->to('/admin/kas-keluar');

        } catch (\Exception $e) {
            // Log error
            log_message('error', $e->getMessage());

            session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Kas Keluar',
            'kasKeluar' => $this->kasKeluarModel->find($id),
            'kategori' => $this->kategoriModel->findAll(),
            'masjid' => $this->masjidModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/kas_keluar/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'tanggal' => 'required',
            'jumlah' => 'required|numeric',
            'kategori' => 'required'
        ];

        // Cek apakah upload file baru
        if ($this->request->getFile('bukti')->getName() != '') {
            $rules['bukti'] = 'uploaded[bukti]|max_size[bukti,2048]|is_image[bukti]|mime_in[bukti,image/jpg,image/jpeg,image/png]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $data = [
            'id_kas_keluar' => $id,
            'tanggal' => $this->request->getVar('tanggal'),
            'jumlah' => $this->request->getVar('jumlah'),
            'kategori' => $this->request->getVar('kategori'),
            'keterangan' => $this->request->getVar('keterangan'),
            'id_user' => session()->get('id_user'),
            'id_masjid' => $this->request->getVar('id_masjid')
        ];

        // Handle file upload jika ada file baru
        $fileBukti = $this->request->getFile('bukti');
        if ($fileBukti->getName() != '') {
            // Hapus file lama
            $kasKeluar = $this->kasKeluarModel->find($id);
            if ($kasKeluar['bukti'] != '') {
                unlink('uploads/bukti_kas_keluar/' . $kasKeluar['bukti']);
            }

            // Upload file baru
            $namaBukti = $fileBukti->getRandomName();
            $fileBukti->move('uploads/bukti_kas_keluar', $namaBukti);
            $data['bukti'] = $namaBukti;
        }

        $this->kasKeluarModel->save($data);

        session()->setFlashdata('pesan', 'Data kas keluar berhasil diubah');
        return redirect()->to('/admin/kas-keluar');
    }

    public function delete($id)
    {
        // Hapus file bukti
        $kasKeluar = $this->kasKeluarModel->find($id);
        if ($kasKeluar['bukti'] != '') {
            unlink('uploads/bukti_kas_keluar/' . $kasKeluar['bukti']);
        }

        $this->kasKeluarModel->delete($id);
        session()->setFlashdata('pesan', 'Data kas keluar berhasil dihapus');
        return redirect()->to('/admin/kas-keluar');
    }

    public function export()
    {
        $data = [
            'kasKeluar' => $this->kasKeluarModel->getKasKeluarWithDetails(),
            'filter' => $this->request->getGet()
        ];

        return view('admin/kas_keluar/export', $data);
    }
}