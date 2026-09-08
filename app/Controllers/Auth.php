<?php

namespace App\Controllers;

use App\Models\AuditLogModel;
use App\Models\UserModel;

class Auth extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Tampilkan Halaman Login
     */
    public function login()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    /**
     * Proses Autentikasi Login dengan Throttling & Audit Log
     */
    public function process()
    {
        $session = session();
        
        // Throttling / Rate Limiting (Maksimal 5 percobaan gagal per 5 menit)
        $attemptsKey    = 'login_attempts_' . md5($this->request->getIPAddress());
        $failedAttempts = (int) $session->get($attemptsKey) ?? 0;

        if ($failedAttempts >= 5) {
            return redirect()->back()->with('error', 'Terlalu banyak percobaan login gagal. Silakan tunggu beberapa menit sebelum mencoba kembali.');
        }

        // Validasi Rules
        $rules = [
            'login_input' => 'required|min_length[3]',
            'password'    => 'required|min_length[5]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Username/Email dan Password wajib diisi.');
        }

        $loginInput = trim($this->request->getPost('login_input'));
        $password   = $this->request->getPost('password');

        // Cari user di database
        $user = $this->userModel->getUserWithRelations($loginInput);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            $session->set($attemptsKey, $failedAttempts + 1);

            // Audit Log Login Gagal
            AuditLogModel::record(
                'LOGIN_FAILED',
                'users',
                $user ? (string)$user['id'] : '0',
                null,
                ['attempted_username' => $loginInput]
            );

            return redirect()->back()->withInput()->with('error', 'Username / Email atau Password tidak valid.');
        }

        // Cek apakah akun aktif
        if ((int)$user['is_active'] !== 1) {
            return redirect()->back()->withInput()->with('error', 'Akun Anda dinonaktifkan oleh Administrator.');
        }

        // Login Berhasil -> Reset Throttling Counter
        $session->remove($attemptsKey);

        // Update last login timestamp
        $this->userModel->updateLastLogin((int)$user['id']);

        // Set Session Data
        $sessionData = [
            'user_id'      => (int)$user['id'],
            'username'     => $user['username'],
            'nama_lengkap' => $user['nama_lengkap'],
            'email'        => $user['email'],
            'nip'          => $user['nip'],
            'jabatan'      => $user['jabatan'],
            'role_id'      => (int)$user['role_id'],
            'role_code'    => $user['role_code'],
            'role_name'    => $user['role_name'],
            'skpd_id'      => $user['skpd_id'] ? (int)$user['skpd_id'] : null,
            'kode_skpd'    => $user['kode_skpd'] ?? null,
            'nama_skpd'    => $user['nama_skpd'] ?? 'Pemerintah Daerah',
            'is_logged_in' => true,
        ];
        $session->set($sessionData);

        // Audit Log Login Sukses
        AuditLogModel::record(
            'LOGIN_SUCCESS',
            'users',
            (string)$user['id'],
            null,
            ['username' => $user['username'], 'role' => $user['role_code']]
        );

        return redirect()->to('/dashboard')->with('success', "Selamat datang kembali, {$user['nama_lengkap']}!");
    }

    /**
     * Process Logout
     */
    public function logout()
    {
        $session = session();

        if ($session->get('is_logged_in')) {
            AuditLogModel::record(
                'LOGOUT',
                'users',
                (string)$session->get('user_id'),
                null,
                ['username' => $session->get('username')]
            );
        }

        $session->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}
