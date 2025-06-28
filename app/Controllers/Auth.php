<?php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function index()
    {
        return view('auth/login');
    }

    public function login()
    {
        $session = session();
        $userModel = new UserModel();

        $username = $this->request->getPost('username');
        $password = md5($this->request->getPost('password')); // Gunakan md5 di sini

        $user = $userModel->where('username', $username)->where('password', $password)->first();

        if ($user) {
            $sessionData = [
                'id_user' => $user['id_user'],
                'username' => $user['username'],
                'nama' => $user['nama'],
                'role' => $user['role'],
                'logged_in' => true,
            ];
            $session->set($sessionData);

            // Redirect sesuai role
            if ($user['role'] == 'admin') {
                return redirect()->to('/admin/dashboard');
            } elseif ($user['role'] == 'bendahara') {
                return redirect()->to('/bendahara/dashboard');
            } elseif ($user['role'] == 'rt') {
                return redirect()->to('/rt/dashboard');
            }
        } else {
            return redirect()->back()->with('error', 'Username atau password salah');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
