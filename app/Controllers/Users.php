<?php

namespace App\Controllers;

use App\Models\AuditLogModel;
use App\Models\SkpdModel;
use App\Models\UserModel;

class Users extends BaseController
{
    protected UserModel $userModel;
    protected SkpdModel $skpdModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->skpdModel = new SkpdModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Pengguna (Users & RBAC)',
            'users' => $this->userModel->getAllUsersWithDetails(),
            'roles' => $this->userModel->db->table('master_roles')->get()->getResultArray(),
            'skpds' => $this->skpdModel->findAll(),
        ];

        return view('users/index', $data);
    }

    public function store()
    {
        $rules = [
            'username'     => 'required|min_length[3]|is_unique[users.username]',
            'email'        => 'required|valid_email|is_unique[users.email]',
            'password'     => 'required|min_length[6]',
            'nama_lengkap' => 'required',
            'role_id'      => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }

        $userData = [
            'username'      => trim($this->request->getPost('username')),
            'email'         => trim($this->request->getPost('email')),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'nama_lengkap'  => trim($this->request->getPost('nama_lengkap')),
            'nip'           => trim($this->request->getPost('nip')),
            'jabatan'       => trim($this->request->getPost('jabatan')),
            'phone_number'  => trim($this->request->getPost('phone_number')),
            'role_id'       => (int)$this->request->getPost('role_id'),
            'skpd_id'       => $this->request->getPost('skpd_id') ? (int)$this->request->getPost('skpd_id') : null,
            'is_active'     => 1,
        ];

        $newId = $this->userModel->insert($userData);

        AuditLogModel::record('CREATE_USER', 'users', (string)$newId, null, ['username' => $userData['username']]);

        return redirect()->to('/users')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    public function toggleStatus($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/users')->with('error', 'Pengguna tidak ditemukan.');
        }

        $newStatus = (int)$user['is_active'] === 1 ? 0 : 1;
        $this->userModel->update($id, ['is_active' => $newStatus]);

        AuditLogModel::record(
            'TOGGLE_USER_STATUS',
            'users',
            (string)$id,
            ['is_active' => $user['is_active']],
            ['is_active' => $newStatus]
        );

        $statusLabel = $newStatus === 1 ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->to('/users')->with('success', "Status akun {$user['username']} berhasil {$statusLabel}.");
    }
}
