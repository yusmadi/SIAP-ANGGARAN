<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'role_id',
        'skpd_id',
        'username',
        'email',
        'password_hash',
        'nama_lengkap',
        'nip',
        'jabatan',
        'phone_number',
        'is_active',
        'last_login_at',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Cari pengguna beserta informasi role dan SKPD
     */
    public function getUserWithRelations(string $loginInput)
    {
        return $this->select('users.*, master_roles.role_code, master_roles.role_name, master_skpd.kode_skpd, master_skpd.nama_skpd')
                    ->join('master_roles', 'master_roles.id = users.role_id')
                    ->join('master_skpd', 'master_skpd.id = users.skpd_id', 'left')
                    ->groupStart()
                        ->where('users.username', $loginInput)
                        ->orWhere('users.email', $loginInput)
                    ->groupEnd()
                    ->first();
    }

    /**
     * Update timestamp last_login_at
     */
    public function updateLastLogin(int $userId)
    {
        return $this->update($userId, [
            'last_login_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Dapatkan daftar user lengkap dengan detail role & SKPD
     */
    public function getAllUsersWithDetails()
    {
        return $this->select('users.*, master_roles.role_name, master_roles.role_code, master_skpd.nama_skpd, master_skpd.kode_skpd')
                    ->join('master_roles', 'master_roles.id = users.role_id')
                    ->join('master_skpd', 'master_skpd.id = users.skpd_id', 'left')
                    ->orderBy('users.id', 'ASC')
                    ->findAll();
    }
}
