<?php

namespace App\Models;

use CodeIgniter\Model;

class SubRincianObjekModel extends Model
{
    protected $table            = 'master_sub_rincian_objek';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'rincian_objek_id',
        'kode_sub_rincian_objek',
        'nama_sub_rincian_objek',
        'deskripsi',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getSubRincianObjekWithParents(?int $rincianObjekId = null, ?string $keyword = null)
    {
        $builder = $this->select('master_sub_rincian_objek.*, master_rincian_objek.kode_rincian_objek, master_rincian_objek.nama_rincian_objek')
                        ->join('master_rincian_objek', 'master_rincian_objek.id = master_sub_rincian_objek.rincian_objek_id')
                        ->orderBy('master_sub_rincian_objek.kode_sub_rincian_objek', 'ASC');

        if ($rincianObjekId) {
            $builder->where('master_sub_rincian_objek.rincian_objek_id', $rincianObjekId);
        }

        if ($keyword) {
            $builder->groupStart()
                    ->like('master_sub_rincian_objek.kode_sub_rincian_objek', $keyword)
                    ->orLike('master_sub_rincian_objek.nama_sub_rincian_objek', $keyword)
                    ->orLike('master_rincian_objek.nama_rincian_objek', $keyword)
                    ->groupEnd();
        }

        return $builder->findAll();
    }

    public function getSubRincianObjekPaginated(?int $rincianObjekId = null, ?string $keyword = null, int $perPage = 15)
    {
        $this->select('master_sub_rincian_objek.*, master_rincian_objek.kode_rincian_objek, master_rincian_objek.nama_rincian_objek')
             ->join('master_rincian_objek', 'master_rincian_objek.id = master_sub_rincian_objek.rincian_objek_id')
             ->orderBy('master_sub_rincian_objek.kode_sub_rincian_objek', 'ASC');

        if ($rincianObjekId) {
            $this->where('master_sub_rincian_objek.rincian_objek_id', $rincianObjekId);
        }

        if ($keyword) {
            $this->groupStart()
                 ->like('master_sub_rincian_objek.kode_sub_rincian_objek', $keyword)
                 ->orLike('master_sub_rincian_objek.nama_sub_rincian_objek', $keyword)
                 ->orLike('master_rincian_objek.nama_rincian_objek', $keyword)
                 ->groupEnd();
        }

        return $this->paginate($perPage);
    }

    public function getStats(?int $rincianObjekId = null, ?string $keyword = null): array
    {
        $builder = $this->db->table($this->table)
                            ->join('master_rincian_objek', 'master_rincian_objek.id = master_sub_rincian_objek.rincian_objek_id');

        if ($rincianObjekId) {
            $builder->where('master_sub_rincian_objek.rincian_objek_id', $rincianObjekId);
        }

        if ($keyword) {
            $builder->groupStart()
                    ->like('master_sub_rincian_objek.kode_sub_rincian_objek', $keyword)
                    ->orLike('master_sub_rincian_objek.nama_sub_rincian_objek', $keyword)
                    ->orLike('master_rincian_objek.nama_rincian_objek', $keyword)
                    ->groupEnd();
        }

        $totalCount = (clone $builder)->countAllResults();
        $activeCount = (clone $builder)->where('master_sub_rincian_objek.is_active', 1)->countAllResults();

        return [
            'total_count'  => $totalCount,
            'active_count' => $activeCount,
        ];
    }
}
