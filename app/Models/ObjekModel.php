<?php

namespace App\Models;

use CodeIgniter\Model;

class ObjekModel extends Model
{
    protected $table            = 'master_objek';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'jenis_id',
        'kode_objek',
        'nama_objek',
        'deskripsi',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getObjekWithParents(?int $jenisId = null, ?string $keyword = null)
    {
        $builder = $this->select('master_objek.*, master_jenis.kode_jenis, master_jenis.nama_jenis, master_kelompok.nama_kelompok')
                        ->join('master_jenis', 'master_jenis.id = master_objek.jenis_id')
                        ->join('master_kelompok', 'master_kelompok.id = master_jenis.kelompok_id')
                        ->orderBy('master_objek.kode_objek', 'ASC');

        if ($jenisId) {
            $builder->where('master_objek.jenis_id', $jenisId);
        }

        if ($keyword) {
            $builder->groupStart()
                    ->like('master_objek.kode_objek', $keyword)
                    ->orLike('master_objek.nama_objek', $keyword)
                    ->orLike('master_jenis.nama_jenis', $keyword)
                    ->groupEnd();
        }

        return $builder->findAll();
    }
}
