<?php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function index()
    {
        // Redirect if already logged in
        if (session()->get('logged_in')) {
            return $this->redirectToDashboard();
        }
        return view('auth/login');
    }

    public function login()
    {
        $session = session();
        $userModel = new UserModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $userModel->where('username', $username)->first();

        if ($user) {
            // Verify password (using password_verify if you switch to hashed passwords)
            if (md5($password) === $user['password']) { // Remove md5 when you switch to hashing
                $sessionData = [
                    'id_user' => $user['id_user'],
                    'username' => $user['username'],
                    'nama' => $user['nama'],
                    'role' => $user['role'],
                    'logged_in' => true,
                ];
                $session->set($sessionData);

                return $this->redirectToDashboard();
            }
        }

        return redirect()->back()->with('error', 'Username atau password salah');
    }

    protected function redirectToDashboard()
    {
        switch (session()->get('role')) {
            case 'admin':
                return redirect()->to('/admin/dashboard');
            case 'bendahara':
                return redirect()->to('/bendahara/dashboard');
            case 'rt':
                return redirect()->to('/rt/dashboard');
            default:
                return redirect()->to('/');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth');
    }
}