<?php

namespace App\Models;

use CodeIgniter\Model;

class TargetPendapatanModel extends Model
{
    protected $table            = 'target_pendapatan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'tahun_anggaran_id',
        'skpd_id',
        'sub_rincian_objek_id',
        'target_murni',
        'target_pergeseran',
        'target_perubahan',
        'target_pergeseran_setelah_perubahan',
        'keterangan',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getTargetPendapatanPaginated(?int $skpdId = null, ?int $tahunId = null, ?string $keyword = null, int $perPage = 15)
    {
        $this->select('target_pendapatan.*, 
                       master_skpd.kode_skpd, master_skpd.nama_skpd, 
                       master_sub_rincian_objek.kode_sub_rincian_objek, master_sub_rincian_objek.nama_sub_rincian_objek,
                       master_rincian_objek.nama_rincian_objek,
                       tahun_anggaran.tahun as tahun_anggaran')
             ->join('master_skpd', 'master_skpd.id = target_pendapatan.skpd_id', 'left')
             ->join('master_sub_rincian_objek', 'master_sub_rincian_objek.id = target_pendapatan.sub_rincian_objek_id', 'left')
             ->join('master_rincian_objek', 'master_rincian_objek.id = master_sub_rincian_objek.rincian_objek_id', 'left')
             ->join('tahun_anggaran', 'tahun_anggaran.id = target_pendapatan.tahun_anggaran_id', 'left')
             ->orderBy('master_skpd.kode_skpd', 'ASC')
             ->orderBy('master_sub_rincian_objek.kode_sub_rincian_objek', 'ASC');

        if ($skpdId) {
            $this->where('target_pendapatan.skpd_id', $skpdId);
        }

        if ($tahunId) {
            $this->where('target_pendapatan.tahun_anggaran_id', $tahunId);
        }

        if ($keyword) {
            $this->groupStart()
                 ->like('master_skpd.kode_skpd', $keyword)
                 ->orLike('master_skpd.nama_skpd', $keyword)
                 ->orLike('master_sub_rincian_objek.kode_sub_rincian_objek', $keyword)
                 ->orLike('master_sub_rincian_objek.nama_sub_rincian_objek', $keyword)
                 ->orLike('target_pendapatan.keterangan', $keyword)
                 ->groupEnd();
        }

        return $this->paginate($perPage);
    }

    public function getStats(?int $skpdId = null, ?int $tahunId = null, ?string $keyword = null): array
    {
        $builder = $this->db->table($this->table)
                            ->join('master_skpd', 'master_skpd.id = target_pendapatan.skpd_id', 'left')
                            ->join('master_sub_rincian_objek', 'master_sub_rincian_objek.id = target_pendapatan.sub_rincian_objek_id', 'left');

        if ($skpdId) {
            $builder->where('target_pendapatan.skpd_id', $skpdId);
        }

        if ($tahunId) {
            $builder->where('target_pendapatan.tahun_anggaran_id', $tahunId);
        }

        if ($keyword) {
            $builder->groupStart()
                    ->like('master_skpd.kode_skpd', $keyword)
                    ->orLike('master_skpd.nama_skpd', $keyword)
                    ->orLike('master_sub_rincian_objek.kode_sub_rincian_objek', $keyword)
                    ->orLike('master_sub_rincian_objek.nama_sub_rincian_objek', $keyword)
                    ->orLike('target_pendapatan.keterangan', $keyword)
                    ->groupEnd();
        }

        $totalItems = (clone $builder)->countAllResults();

        $sumQuery = (clone $builder)->selectSum('target_murni', 'sum_murni')
                                   ->selectSum('target_pergeseran', 'sum_pergeseran')
                                   ->selectSum('target_perubahan', 'sum_perubahan')
                                   ->selectSum('target_pergeseran_setelah_perubahan', 'sum_pergeseran_setelah_perubahan')
                                   ->get()
                                   ->getRowArray();

        return [
            'total_items'                          => $totalItems,
            'total_target_murni'                   => (float) ($sumQuery['sum_murni'] ?? 0),
            'total_target_pergeseran'              => (float) ($sumQuery['sum_pergeseran'] ?? 0),
            'total_target_perubahan'               => (float) ($sumQuery['sum_perubahan'] ?? 0),
            'total_target_pergeseran_setelah_perubahan' => (float) ($sumQuery['sum_pergeseran_setelah_perubahan'] ?? 0),
        ];
    }

    /**
     * Get sub rincian objek options specifically under Akun 4 (Pendapatan Daerah) or all available if none restricted.
     */
    public function getPendapatanSubRincianObjeks(): array
    {
        $items = $this->db->table('master_sub_rincian_objek')
                        ->select('master_sub_rincian_objek.id, master_sub_rincian_objek.kode_sub_rincian_objek, master_sub_rincian_objek.nama_sub_rincian_objek')
                        ->join('master_rincian_objek', 'master_rincian_objek.id = master_sub_rincian_objek.rincian_objek_id')
                        ->join('master_objek', 'master_objek.id = master_rincian_objek.objek_id')
                        ->join('master_jenis', 'master_jenis.id = master_objek.jenis_id')
                        ->join('master_kelompok', 'master_kelompok.id = master_jenis.kelompok_id')
                        ->join('master_akun', 'master_akun.id = master_kelompok.akun_id')
                        ->where('master_akun.kode_akun', '4') // Akun 4 = Pendapatan
                        ->where('master_sub_rincian_objek.is_active', 1)
                        ->orderBy('master_sub_rincian_objek.kode_sub_rincian_objek', 'ASC')
                        ->get()
                        ->getResultArray();

        if (empty($items)) {
            $items = $this->db->table('master_sub_rincian_objek')
                            ->select('id, kode_sub_rincian_objek, nama_sub_rincian_objek')
                            ->where('is_active', 1)
                            ->orderBy('kode_sub_rincian_objek', 'ASC')
                            ->get()
                            ->getResultArray();
        }

        return $items;
    }
}
