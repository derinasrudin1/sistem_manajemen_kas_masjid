<?php
namespace App\Controllers;
use App\Models\KasKeluarModel;
use App\Models\KasMasukModel;

class KasKeluar extends BaseController
{
    protected $kasKeluar;

    public function __construct()
    {
        $this->kasKeluar = new KasKeluarModel();
    }

    public function index()
    {
        $kasKeluarModel = new KasKeluarModel();
        $kasMasukModel = new KasMasukModel();

        $data['kas_keluar'] = $kasKeluarModel->orderBy('tanggal', 'DESC')->findAll();

        $data['total_keluar'] = $kasKeluarModel->selectSum('jumlah')->first()['jumlah'] ?? 0;
        $data['total_masuk'] = $kasMasukModel->selectSum('jumlah')->first()['jumlah'] ?? 0;
        $data['sisa_saldo'] = $data['total_masuk'] - $data['total_keluar'];
        // $data['kas_keluar'] = $this->kasKeluar->orderBy('tanggal', 'DESC')->findAll();
        return view('kas_keluar/index', $data);
    }

    public function create()
    {
        return view('kas_keluar/create');
    }

    public function store()
    {
        $rules = [
            'tanggal' => 'required|valid_date',
            'jumlah' => 'required|numeric|greater_than_equal_to[0]',
            'kategori' => 'required|min_length[3]|max_length[100]',
            'keterangan' => 'permit_empty|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $tanggal = $this->request->getPost('tanggal');
        if (strtotime($tanggal) > strtotime(date('Y-m-d'))) {
            return redirect()->back()->withInput()->with('errors', ['tanggal' => 'Tanggal tidak boleh di masa depan.']);
        }

        $this->kasKeluar->insert([
            'tanggal' => $tanggal,
            'jumlah' => $this->request->getPost('jumlah'),
            'kategori' => $this->request->getPost('kategori'),
            'keterangan' => $this->request->getPost('keterangan'),
            'id_user' => session('id_user') ?? 1
        ]);

        return redirect()->to('/kaskeluar')->with('success', 'Data kas keluar berhasil disimpan.');
    }

    public function edit($id)
    {
        $data['kas'] = $this->kasKeluar->find($id);
        return view('kas_keluar/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'tanggal' => 'required|valid_date',
            'jumlah' => 'required|numeric|greater_than_equal_to[0]',
            'kategori' => 'required|min_length[3]|max_length[100]',
            'keterangan' => 'permit_empty|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $tanggal = $this->request->getPost('tanggal');
        if (strtotime($tanggal) > strtotime(date('Y-m-d'))) {
            return redirect()->back()->withInput()->with('errors', ['tanggal' => 'Tanggal tidak boleh di masa depan.']);
        }

        $this->kasKeluar->update($id, [
            'tanggal' => $tanggal,
            'jumlah' => $this->request->getPost('jumlah'),
            'kategori' => $this->request->getPost('kategori'),
            'keterangan' => $this->request->getPost('keterangan'),
        ]);

        return redirect()->to('/kaskeluar')->with('success', 'Data kas keluar berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->kasKeluar->delete($id);
        return redirect()->to('/kaskeluar')->with('success', 'Data kas keluar berhasil dihapus.');
    }
}
