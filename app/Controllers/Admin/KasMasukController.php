<?php

namespace App\Controllers\Admin;

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
        $this->uploadPath = WRITEPATH . '../public/uploads/bukti_kas_masuk/';
        
        // Ensure upload directory exists
        if (!is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0777, true);
        }
    }

    public function index()
    {
        $data = [
            'title' => 'Kas Masuk',
            'kasMasuk' => $this->kasMasukModel->getKasMasukWithRelations()->findAll(),
            'masjids' => $this->masjidModel->findAll(),
            'sumberDana' => $this->sumberDanaModel->findAll()
        ];

        return view('admin/kas_masuk/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Kas Masuk',
            'masjids' => $this->masjidModel->findAll(),
            'sumberDana' => $this->sumberDanaModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/kas_masuk/create', $data);
    }

    public function store()
    {
        $rules = [
            'tanggal' => 'required|valid_date',
            'jumlah' => 'required|numeric',
            'sumber' => 'required',
            'id_masjid' => 'required|numeric',
            'bukti' => [
                'uploaded[bukti]',
                'mime_in[bukti,image/jpg,image/jpeg,image/png]',
                'max_size[bukti,2048]',
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fileBukti = $this->request->getFile('bukti');
        
        // Verify file upload
        if (!$fileBukti->isValid()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'File upload error: ' . $fileBukti->getErrorString());
        }

        // Generate unique filename
        $namaBukti = $fileBukti->getRandomName();

        try {
            // Move uploaded file
            if (!$fileBukti->hasMoved()) {
                $fileBukti->move($this->uploadPath, $namaBukti);
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to move uploaded file: ' . $e->getMessage());
        }

        // Prepare data for database
        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'jumlah' => $this->request->getPost('jumlah'),
            'sumber' => $this->request->getPost('sumber'),
            'keterangan' => $this->request->getPost('keterangan'),
            'bukti' => $namaBukti,
            'id_user' => session()->get('id'),
            'id_masjid' => $this->request->getPost('id_masjid')
        ];

        // Save to database
        if ($this->kasMasukModel->save($data)) {
            return redirect()->to('/admin/kas-masuk')
                ->with('message', 'Data kas masuk berhasil ditambahkan');
        } else {
            // Clean up uploaded file if database save fails
            if (file_exists($this->uploadPath . $namaBukti)) {
                unlink($this->uploadPath . $namaBukti);
            }
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data ke database');
        }
    }

    public function edit($id)
    {
        $kasMasuk = $this->kasMasukModel->find($id);

        if (!$kasMasuk) {
            return redirect()->to('/admin/kas-masuk')
                ->with('error', 'Data kas masuk tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Kas Masuk',
            'kasMasuk' => $kasMasuk,
            'masjids' => $this->masjidModel->findAll(),
            'sumberDana' => $this->sumberDanaModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/kas_masuk/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'tanggal' => 'required|valid_date',
            'jumlah' => 'required|numeric',
            'sumber' => 'required',
            'id_masjid' => 'required|numeric'
        ];

        $fileBukti = $this->request->getFile('bukti');
        
        // Add file validation rules only if new file is uploaded
        if ($fileBukti->getName() !== '') {
            $rules['bukti'] = [
                'uploaded[bukti]',
                'mime_in[bukti,image/jpg,image/jpeg,image/png]',
                'max_size[bukti,2048]'
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Get existing data
        $existingData = $this->kasMasukModel->find($id);
        
        // Prepare update data
        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'jumlah' => $this->request->getPost('jumlah'),
            'sumber' => $this->request->getPost('sumber'),
            'keterangan' => $this->request->getPost('keterangan'),
            'id_masjid' => $this->request->getPost('id_masjid')
        ];

        // Handle file upload if new file is provided
        if ($fileBukti->getName() !== '') {
            // Delete old file if exists
            if ($existingData['bukti'] && file_exists($this->uploadPath . $existingData['bukti'])) {
                unlink($this->uploadPath . $existingData['bukti']);
            }

            // Upload new file
            $newName = $fileBukti->getRandomName();
            $fileBukti->move($this->uploadPath, $newName);
            $data['bukti'] = $newName;
        }

        // Update database record
        if ($this->kasMasukModel->update($id, $data)) {
            return redirect()->to('/admin/kas-masuk')
                ->with('message', 'Data kas masuk berhasil diperbarui');
        } else {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data kas masuk');
        }
    }

    public function delete($id)
    {
        $kasMasuk = $this->kasMasukModel->find($id);

        if (!$kasMasuk) {
            return redirect()->to('/admin/kas-masuk')
                ->with('error', 'Data tidak ditemukan');
        }

        // Delete associated file
        if ($kasMasuk['bukti'] && file_exists($this->uploadPath . $kasMasuk['bukti'])) {
            unlink($this->uploadPath . $kasMasuk['bukti']);
        }

        // Delete database record
        if ($this->kasMasukModel->delete($id)) {
            return redirect()->to('/admin/kas-masuk')
                ->with('message', 'Data kas masuk berhasil dihapus');
        } else {
            return redirect()->to('/admin/kas-masuk')
                ->with('error', 'Gagal menghapus data kas masuk');
        }
    }

    public function viewBukti($filename)
    {
        $path = $this->uploadPath . $filename;

        if (!file_exists($path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $mime = mime_content_type($path);
        header('Content-Type: ' . $mime);
        readfile($path);
        exit;
    }
}