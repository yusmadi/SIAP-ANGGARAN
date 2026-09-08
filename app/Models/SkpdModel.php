<?php

namespace App\Models;

use CodeIgniter\Model;

class SkpdModel extends Model
{
    protected $table            = 'master_skpd';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'kode_skpd',
        'nama_skpd',
        'nama_kepala',
        'nip_kepala',
        'pagu_total_murni',
        'pagu_total_pergeseran',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
