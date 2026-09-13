<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisModel extends Model
{
    protected $table            = 'master_jenis';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'kelompok_id',
        'kode_jenis',
        'nama_jenis',
        'deskripsi',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getJenisWithKelompok(?int $kelompokId = null, ?string $keyword = null)
    {
        $builder = $this->select('master_jenis.*, master_kelompok.kode_kelompok, master_kelompok.nama_kelompok, master_akun.kode_akun, master_akun.nama_akun')
                        ->join('master_kelompok', 'master_kelompok.id = master_jenis.kelompok_id')
                        ->join('master_akun', 'master_akun.id = master_kelompok.akun_id')
                        ->orderBy('master_jenis.kode_jenis', 'ASC');

        if ($kelompokId) {
            $builder->where('master_jenis.kelompok_id', $kelompokId);
        }

        if ($keyword) {
            $builder->groupStart()
                    ->like('master_jenis.kode_jenis', $keyword)
                    ->orLike('master_jenis.nama_jenis', $keyword)
                    ->orLike('master_kelompok.nama_kelompok', $keyword)
                    ->groupEnd();
        }

        return $builder->findAll();
    }
}
