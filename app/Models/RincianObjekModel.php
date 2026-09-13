<?php

namespace App\Models;

use CodeIgniter\Model;

class RincianObjekModel extends Model
{
    protected $table            = 'master_rincian_objek';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'objek_id',
        'kode_rincian_objek',
        'nama_rincian_objek',
        'deskripsi',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getRincianObjekWithParents(?int $objekId = null, ?string $keyword = null)
    {
        $builder = $this->select('master_rincian_objek.*, master_objek.kode_objek, master_objek.nama_objek')
                        ->join('master_objek', 'master_objek.id = master_rincian_objek.objek_id')
                        ->orderBy('master_rincian_objek.kode_rincian_objek', 'ASC');

        if ($objekId) {
            $builder->where('master_rincian_objek.objek_id', $objekId);
        }

        if ($keyword) {
            $builder->groupStart()
                    ->like('master_rincian_objek.kode_rincian_objek', $keyword)
                    ->orLike('master_rincian_objek.nama_rincian_objek', $keyword)
                    ->orLike('master_objek.nama_objek', $keyword)
                    ->groupEnd();
        }

        return $builder->findAll();
    }
}
