<?php

namespace App\Models;

use CodeIgniter\Model;

class KelompokModel extends Model
{
    protected $table            = 'master_kelompok';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'akun_id',
        'kode_kelompok',
        'nama_kelompok',
        'deskripsi',
        'is_active',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get Kelompok along with parent Akun data
     */
    public function getKelompokWithAkun(?int $akunId = null, ?string $keyword = null)
    {
        $builder = $this->select('master_kelompok.*, master_akun.kode_akun, master_akun.nama_akun')
                        ->join('master_akun', 'master_akun.id = master_kelompok.akun_id')
                        ->orderBy('master_kelompok.kode_kelompok', 'ASC');

        if ($akunId) {
            $builder->where('master_kelompok.akun_id', $akunId);
        }

        if ($keyword) {
            $builder->groupStart()
                    ->like('master_kelompok.kode_kelompok', $keyword)
                    ->orLike('master_kelompok.nama_kelompok', $keyword)
                    ->orLike('master_akun.nama_akun', $keyword)
                    ->groupEnd();
        }

        return $builder->findAll();
    }
}
