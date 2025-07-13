<?php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function index()
    {
        // Jika sudah login, langsung arahkan ke dashboard
        if (session()->get('logged_in')) {
            return $this->redirectToDashboard();
        }

        // Kirim data waktu penguncian (jika ada) ke view setiap kali halaman login dimuat
        $data['lockout_time'] = session()->get('lockout_time') ?? 0;

        return view('auth/login', $data);
    }

    public function login()
    {
        $session = session();
        $userModel = new UserModel();

        // Cek apakah user sedang dalam masa tunggu (locked out)
        if ($lockoutTime = $session->get('lockout_time')) {
            if (time() < $lockoutTime) {
                // Cukup kirim pesan error umum, countdown akan ditangani di view
                return redirect()->back()->with('error', "Anda telah gagal login 5 kali. Silakan coba lagi nanti.");
            } else {
                // Jika waktu tunggu sudah habis, hapus catatan percobaan
                $session->remove(['login_attempts', 'lockout_time']);
            }
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $userModel->select('users.*, masjid.nama_masjid')
            ->join('masjid', 'masjid.id_masjid = users.id_masjid', 'left')
            ->where('users.username', $username)
            ->first();

        // Cek jika user ada DAN password cocok
        if ($user && md5($password) === $user['password']) {
            $session->remove(['login_attempts', 'lockout_time']);
            $sessionData = [
                'id_user' => $user['id_user'],
                'username' => $user['username'],
                'nama' => $user['nama'],
                'role' => $user['role'],
                'id_masjid' => $user['id_masjid'],
                'nama_masjid' => $user['nama_masjid'],
                'logged_in' => true,
            ];
            $session->set($sessionData);
            return $this->redirectToDashboard();
        } else {
            $attempts = (int) $session->get('login_attempts') + 1;
            $session->set('login_attempts', $attempts);

            if ($attempts >= 5) {
                // Kunci user selama 1 menit (60 detik)
                $session->set('lockout_time', time() + 60);
                return redirect()->back()->with('error', 'Anda telah gagal login 5 kali. Akun Anda dikunci selama 1 menit.');
            }

            $remainingAttempts = 5 - $attempts;
            return redirect()->back()->with('error', "Username atau password salah. Sisa percobaan: {$remainingAttempts}.");
        }
    }

    protected function redirectToDashboard()
    {
        switch (session()->get('role')) {
            case 'admin':
                return redirect()->to('/admin/dashboard');
            case 'bendahara':
                return redirect()->to('/bendahara/dashboard');
            default:
                return redirect()->to('/');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
