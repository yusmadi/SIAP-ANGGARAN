<?php

namespace App\Models;

use CodeIgniter\Model;

class TahunAnggaranModel extends Model
{
    protected $table            = 'tahun_anggaran';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'tahun',
        'status_tahapan',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getActiveYear()
    {
        return $this->where('is_active', 1)->first();
    }
}
