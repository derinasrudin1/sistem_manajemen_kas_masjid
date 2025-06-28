<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper('form');
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen User',
            'users' => $this->userModel->findAll(),
            'roles' => ['admin', 'bendahara', 'rt']
        ];
        return view('admin/user/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah User Baru',
            'roles' => ['admin', 'bendahara', 'rt'],
            'validation' => \Config\Services::validation()
        ];
        return view('admin/user/create', $data);
    }

    public function store()
    {
        $rules = [
            'username' => 'required|is_unique[users.username]|min_length[5]',
            'password' => 'required|min_length[6]',
            'nama' => 'required',
            'role' => 'required|in_list[admin,bendahara,rt]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->userModel->save([
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'), // Auto MD5 via model
            'nama' => $this->request->getPost('nama'),
            'role' => $this->request->getPost('role')
        ]);

        return redirect()->to('/admin/users')->with('message', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit User',
            'user' => $this->userModel->find($id),
            'roles' => ['admin', 'bendahara', 'rt'],
            'validation' => \Config\Services::validation()
        ];
        return view('admin/user/edit', $data);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);

        $usernameRules = 'required|min_length[5]';
        if ($this->request->getPost('username') != $user['username']) {
            $usernameRules .= '|is_unique[users.username]';
        }

        $rules = [
            'username' => $usernameRules,
            'nama' => 'required',
            'role' => 'required|in_list[admin,bendahara,rt]'
        ];

        // Password is optional in update
        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'nama' => $this->request->getPost('nama'),
            'role' => $this->request->getPost('role')
        ];

        // Only update password if provided
        if ($this->request->getPost('password')) {
            $data['password'] = $this->request->getPost('password'); // Auto MD5 via model
        }

        $this->userModel->update($id, $data);

        return redirect()->to('/admin/users')->with('message', 'User berhasil diperbarui');
    }

    public function delete($id)
    {
        // Prevent admin from deleting themselves
        if (session()->get('id_user') == $id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }

        if ($this->userModel->delete($id)) {
            return redirect()->to('/admin/users')->with('message', 'User berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus user');
        }
    }
}