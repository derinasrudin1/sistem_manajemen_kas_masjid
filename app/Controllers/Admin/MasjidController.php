<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\MasjidModel;

class MasjidController extends BaseController
{
    protected $masjidModel;

    public function __construct()
    {
        $this->masjidModel = new MasjidModel();
        helper('form');
    }

    public function index()
    {
        $data = [
            'title' => 'Data Masjid',
            'masjids' => $this->masjidModel->findAll(),
        ];
        return view('admin/masjid/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Data Masjid',
            'validation' => \Config\Services::validation()
        ];
        return view('admin/masjid/create', $data);
    }

    public function store()
    {
        if (!$this->validate($this->masjidModel->validationRules, $this->masjidModel->validationMessages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->masjidModel->save([
            'nama_masjid' => $this->request->getPost('nama_masjid'),
            'alamat' => $this->request->getPost('alamat'),
            'rt_rw' => $this->request->getPost('rt_rw'),
            'nama_takmir' => $this->request->getPost('nama_takmir'),
            'kontak' => $this->request->getPost('kontak')
        ]);

        return redirect()->to('/admin/masjid')->with('message', 'Data masjid berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Data Masjid',
            'masjid' => $this->masjidModel->find($id),
            'validation' => \Config\Services::validation()
        ];
        return view('admin/masjid/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate($this->masjidModel->validationRules, $this->masjidModel->validationMessages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->masjidModel->update($id, [
            'nama_masjid' => $this->request->getPost('nama_masjid'),
            'alamat' => $this->request->getPost('alamat'),
            'rt_rw' => $this->request->getPost('rt_rw'),
            'nama_takmir' => $this->request->getPost('nama_takmir'),
            'kontak' => $this->request->getPost('kontak')
        ]);

        return redirect()->to('/admin/masjid')->with('message', 'Data masjid berhasil diperbarui');
    }

    public function delete($id)
    {
        // Hapus relasi RT-Masjid terlebih dahulu
        $db = \Config\Database::connect();
        $db->table('rt_masjid')->where('id_masjid', $id)->delete();

        // Hapus masjid
        if ($this->masjidModel->delete($id)) {
            return redirect()->to('/admin/masjid')->with('message', 'Data masjid berhasil dihapus');
        } else {
            return redirect()->to('/admin/masjid')->with('error', 'Gagal menghapus data masjid');
        }
    }
}