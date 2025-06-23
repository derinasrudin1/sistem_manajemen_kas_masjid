<?php

namespace App\Controllers;

use App\Models\KasMasukModel;
use App\Models\KasKeluarModel;
use App\Models\UserModel;


class KasMasuk extends BaseController
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
        // $data['kas_masuk'] = $this->kasMasuk->orderBy('tanggal', 'DESC')->findAll();
        return view('kas_masuk/index', $data);
    }

    public function create()
    {
        return view('kas_masuk/create');
    }

    public function store()
    {
        // 1. Aturan validasi lengkap
        $rules = [
            'tanggal' => 'required|valid_date',
            'jumlah' => 'required|numeric|greater_than_equal_to[0]',
            'sumber' => 'required|min_length[3]|max_length[100]',
            'keterangan' => 'permit_empty|max_length[255]'
        ];

        $messages = [
            'tanggal' => [
                'required' => 'Tanggal wajib diisi.',
                'valid_date' => 'Format tanggal tidak valid.',
                'before_or_equal' => 'Tanggal tidak boleh melebihi hari ini.'
            ],
            'jumlah' => [
                'required' => 'Jumlah wajib diisi.',
                'numeric' => 'Jumlah harus berupa angka.',
                'greater_than_equal_to' => 'Jumlah tidak boleh negatif.'
            ],
            'sumber' => [
                'required' => 'Sumber wajib diisi.',
                'min_length' => 'Sumber minimal 3 karakter.',
                'max_length' => 'Sumber maksimal 100 karakter.'
            ],
            'keterangan' => [
                'max_length' => 'Keterangan maksimal 255 karakter.'
            ]
        ];

        // 2. Jalankan validasi
        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $tanggal = $this->request->getPost('tanggal');
        if (strtotime($tanggal) > strtotime(date('Y-m-d'))) {
            return redirect()->back()->withInput()->with('errors', ['tanggal' => 'Tanggal tidak boleh di masa depan.']);
        }

        // Simpan data
        $this->kasMasuk->insert([
            'tanggal' => $tanggal,
            'jumlah' => $this->request->getPost('jumlah'),
            'sumber' => $this->request->getPost('sumber'),
            'keterangan' => $this->request->getPost('keterangan'),
            'id_user' => session('id_user') ?? 1
        ]);


        return redirect()->to('/kasmasuk')->with('success', 'Data kas masuk berhasil disimpan.');
    }


    public function delete($id)
    {
        $this->kasMasuk->delete($id);
        return redirect()->to('/kasmasuk')->with('success', 'Data kas masuk berhasil dihapus.');
    }
    public function edit($id)
    {

        $kas = $this->kasMasuk->find($id);
        if (!$kas) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }
        return view('kas_masuk/edit', ['kas' => $kas]);
    }

    public function update($id)
    {
        // 1. Aturan validasi lengkap
        $rules = [
            'tanggal' => 'required|valid_date',
            'jumlah' => 'required|numeric|greater_than_equal_to[0]',
            'sumber' => 'required|min_length[3]|max_length[100]',
            'keterangan' => 'permit_empty|max_length[255]'
        ];

        $messages = [
            'tanggal' => [
                'required' => 'Tanggal wajib diisi.',
                'valid_date' => 'Format tanggal tidak valid.',
                'before_or_equal' => 'Tanggal tidak boleh melebihi hari ini.'
            ],
            'jumlah' => [
                'required' => 'Jumlah wajib diisi.',
                'numeric' => 'Jumlah harus berupa angka.',
                'greater_than_equal_to' => 'Jumlah tidak boleh negatif.'
            ],
            'sumber' => [
                'required' => 'Sumber wajib diisi.',
                'min_length' => 'Sumber minimal 3 karakter.',
                'max_length' => 'Sumber maksimal 100 karakter.'
            ],
            'keterangan' => [
                'max_length' => 'Keterangan maksimal 255 karakter.'
            ]
        ];

        // 2. Jalankan validasi
        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $tanggal = $this->request->getPost('tanggal');
        if (strtotime($tanggal) > strtotime(date('Y-m-d'))) {
            return redirect()->back()->withInput()->with('errors', ['tanggal' => 'Tanggal tidak boleh di masa depan.']);
        }

        $this->kasMasuk->update($id, [
            'tanggal' => $this->request->getPost('tanggal'),
            'jumlah' => $this->request->getPost('jumlah'),
            'sumber' => $this->request->getPost('sumber'),
            'keterangan' => $this->request->getPost('keterangan'),
        ]);

        return redirect()->to('/kasmasuk')->with('success', 'Data kas masuk berhasil diperbarui.');
    }

}
