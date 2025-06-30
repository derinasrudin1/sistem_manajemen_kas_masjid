<?php

namespace App\Controllers\Bendahara;

use App\Controllers\BaseController;
use App\Models\KasMasukModel;
use App\Models\MasjidModel;
use App\Models\SumberDanaModel;

class KasMasukController extends BaseController
{
    protected $kasMasukModel;
    protected $masjidModel;
    protected $sumberDanaModel;
    protected $uploadPath;

    public function __construct()
    {
        $this->kasMasukModel = new KasMasukModel();
        $this->masjidModel = new MasjidModel();
        $this->sumberDanaModel = new SumberDanaModel();
        $this->uploadPath = FCPATH . 'uploads/bukti_kas_masuk/';

        if (!is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0777, true);
        }
    }

    public function index()
    {
        $userMasjidId = session()->get('id_masjid');

        $data = [
            'title' => 'Kas Masuk',
            // PERUBAHAN: Memastikan kita memanggil fungsi yang benar dari model
            'kas_masuk' => $this->kasMasukModel->getKasMasukWithRelations()
                ->where('kas_masuk.id_masjid', $userMasjidId)
                ->findAll(),
        ];

        return view('bendahara/kas_masuk/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Kas Masuk',
            'sumberDana' => $this->sumberDanaModel->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('bendahara/kas_masuk/create', $data);
    }

    /**
     * PERBAIKAN: Method store() dengan alur yang lebih robust.
     */
    public function store()
    {
        // 1. Aturan Validasi
        $rules = [
            'tanggal' => 'required|valid_date',
            'jumlah' => 'required|numeric|greater_than[0]',
            'id_sumber_dana' => 'required|numeric',
            'bukti' => [
                'rules' => 'uploaded[bukti]|is_image[bukti]|mime_in[bukti,image/jpg,image/jpeg,image/png]|max_size[bukti,2048]',
                'errors' => [
                    'uploaded' => 'Anda harus mengunggah file bukti.',
                    'is_image' => 'File yang diunggah harus berupa gambar.',
                    'mime_in' => 'File bukti harus berformat: jpg, jpeg, atau png.',
                    'max_size' => 'Ukuran file bukti maksimal 2MB.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Siapkan data untuk database terlebih dahulu
        $dataToSave = [
            'tanggal' => $this->request->getPost('tanggal'),
            'jumlah' => $this->request->getPost('jumlah'),
            'id_sumber_dana' => $this->request->getPost('id_sumber_dana'),
            'keterangan' => $this->request->getPost('keterangan'),
            'id_user' => session()->get('id_user'),
            'id_masjid' => session()->get('id_masjid')
        ];

        // 3. Proses upload file
        $fileBukti = $this->request->getFile('bukti');
        if ($fileBukti->isValid() && !$fileBukti->hasMoved()) {
            $namaBukti = $fileBukti->getRandomName();
            try {
                $fileBukti->move($this->uploadPath, $namaBukti);
                // Jika berhasil, tambahkan nama file ke data yang akan disimpan
                $dataToSave['bukti'] = $namaBukti;
            } catch (\Exception $e) {
                // Jika gagal memindahkan file, kembali dengan error
                return redirect()->back()->withInput()->with('error', 'Gagal mengunggah file: ' . $e->getMessage());
            }
        }

        // 4. Simpan ke database
        if ($this->kasMasukModel->save($dataToSave)) {
            return redirect()->to('/bendahara/kas-masuk')->with('success', 'Data kas masuk berhasil ditambahkan.');
        } else {
            // Jika gagal menyimpan ke DB, hapus file yang sudah terlanjur di-upload
            if (isset($dataToSave['bukti']) && file_exists($this->uploadPath . $dataToSave['bukti'])) {
                unlink($this->uploadPath . $dataToSave['bukti']);
            }
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data ke database.');
        }
    }

    public function edit($id)
    {
        $userMasjidId = session()->get('id_masjid');
        $kasMasuk = $this->kasMasukModel->where('id_kas_masuk', $id)
            ->where('id_masjid', $userMasjidId)
            ->first();

        if (!$kasMasuk) {
            return redirect()->to('/bendahara/kas_masuk')->with('error', 'Data tidak ditemukan atau Anda tidak memiliki hak akses.');
        }

        $data = [
            'title' => 'Edit Kas Masuk',
            'kasMasuk' => $kasMasuk,
            'sumberDana' => $this->sumberDanaModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('bendahara/kas_masuk/edit', $data);
    }

    /**
     * PERBAIKAN: Method update() dengan alur yang lebih robust dan lengkap.
     */
    public function update($id)
    {
        // 1. Verifikasi kepemilikan data
        $userMasjidId = session()->get('id_masjid');
        $existingData = $this->kasMasukModel->where('id_kas_masuk', $id)
            ->where('id_masjid', $userMasjidId)
            ->first();

        if (!$existingData) {
            return redirect()->to('/bendahara/kas-masuk')->with('error', 'Data tidak ditemukan atau Anda tidak memiliki hak akses.');
        }

        // 2. Siapkan aturan validasi dasar
        $rules = [
            'tanggal' => 'required|valid_date',
            'jumlah' => 'required|numeric|greater_than[0]',
            'id_sumber_dana' => 'required|numeric',
        ];

        $fileBukti = $this->request->getFile('bukti');

        // 3. Tambahkan aturan validasi untuk file HANYA jika file baru diunggah
        if ($fileBukti && $fileBukti->isValid()) {
            $rules['bukti'] = [
                'rules' => 'is_image[bukti]|mime_in[bukti,image/jpg,image/jpeg,image/png]|max_size[bukti,2048]',
                'errors' => [
                    'is_image' => 'File yang diunggah harus berupa gambar.',
                    'mime_in' => 'File bukti harus berformat: jpg, jpeg, atau png.',
                    'max_size' => 'Ukuran file bukti maksimal 2MB.'
                ]
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 4. Siapkan data untuk diupdate
        $dataToUpdate = [
            'tanggal' => $this->request->getPost('tanggal'),
            'jumlah' => $this->request->getPost('jumlah'),
            'id_sumber_dana' => $this->request->getPost('id_sumber_dana'),
            'keterangan' => $this->request->getPost('keterangan'),
        ];

        // 5. Proses file baru jika ada
        if ($fileBukti && $fileBukti->isValid()) {
            $namaBuktiBaru = $fileBukti->getRandomName();
            try {
                $fileBukti->move($this->uploadPath, $namaBuktiBaru);
                $dataToUpdate['bukti'] = $namaBuktiBaru;
                // Hapus file lama jika ada
                if ($existingData['bukti'] && file_exists($this->uploadPath . $existingData['bukti'])) {
                    unlink($this->uploadPath . $existingData['bukti']);
                }
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('error', 'Gagal mengunggah file baru: ' . $e->getMessage());
            }
        }

        // 6. Lakukan update ke database
        if ($this->kasMasukModel->update($id, $dataToUpdate)) {
            return redirect()->to('/bendahara/kas_masuk')->with('success', 'Data kas masuk berhasil diperbarui.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data.');
        }
    }

    // ... (method delete dan viewBukti Anda tetap sama) ...
    public function delete($id)
    {
        $userMasjidId = session()->get('id_masjid');
        $kasMasuk = $this->kasMasukModel->where('id_kas_masuk', $id)
            ->where('id_masjid', $userMasjidId)
            ->first();

        if (!$kasMasuk) {
            return redirect()->to('/bendahara/kas_masuk')->with('error', 'Data tidak ditemukan atau Anda tidak memiliki hak akses.');
        }

        if ($kasMasuk['bukti'] && file_exists($this->uploadPath . $kasMasuk['bukti'])) {
            unlink($this->uploadPath . $kasMasuk['bukti']);
        }

        if ($this->kasMasukModel->delete($id)) {
            return redirect()->to('/bendahara/kas_masuk')->with('success', 'Data kas masuk berhasil dihapus.');
        } else {
            return redirect()->to('/bendahara/kas_masuk')->with('error', 'Gagal menghapus data.');
        }
    }

    public function viewBukti($filename)
    {
        $path = $this->uploadPath . $filename;

        if (!file_exists($path) || is_dir($path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $mime = mime_content_type($path);
        header('Content-Type: ' . $mime);
        readfile($path);
        exit;
    }
}
