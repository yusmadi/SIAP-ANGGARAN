<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TargetPendapatanSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $now = date('Y-m-d H:i:s');

        // Check if data already exists
        if ($db->table('target_pendapatan')->countAllResults() > 0) {
            return;
        }

        // Get Active Tahun Anggaran
        $tahun = $db->table('tahun_anggaran')->where('is_active', 1)->get()->getRowArray();
        $tahunId = $tahun ? $tahun['id'] : 1;

        // Get SKPDs
        $skpds = $db->table('master_skpd')->get()->getResultArray();
        if (empty($skpds)) {
            return;
        }

        // Get Sub Rincian Objek for Pendapatan
        $subRincians = $db->table('master_sub_rincian_objek')->get()->getResultArray();
        if (empty($subRincians)) {
            return;
        }

        $skpdBpkd = $skpds[0]['id'];
        $skpdPendidikan = count($skpds) > 1 ? $skpds[1]['id'] : $skpds[0]['id'];

        $sampleTargets = [
            [
                'tahun_anggaran_id'    => $tahunId,
                'skpd_id'              => $skpdBpkd,
                'sub_rincian_objek_id' => $subRincians[0]['id'],
                'target_murni'         => 15000000000.00,
                'target_pergeseran'    => 15500000000.00,
                'target_perubahan'     => 16000000000.00,
                'keterangan'           => 'Target Pendapatan Pajak Daerah TA 2026',
                'created_at'           => $now,
                'updated_at'           => $now,
            ],
            [
                'tahun_anggaran_id'    => $tahunId,
                'skpd_id'              => $skpdBpkd,
                'sub_rincian_objek_id' => count($subRincians) > 1 ? $subRincians[1]['id'] : $subRincians[0]['id'],
                'target_murni'         => 8500000000.00,
                'target_pergeseran'    => 8500000000.00,
                'target_perubahan'     => 9000000000.00,
                'keterangan'           => 'Target Retribusi Daerah Pelayanan Umum & Jasa Usaha',
                'created_at'           => $now,
                'updated_at'           => $now,
            ],
            [
                'tahun_anggaran_id'    => $tahunId,
                'skpd_id'              => $skpdPendidikan,
                'sub_rincian_objek_id' => count($subRincians) > 2 ? $subRincians[2]['id'] : $subRincians[0]['id'],
                'target_murni'         => 120000000000.00,
                'target_pergeseran'    => 120000000000.00,
                'target_perubahan'     => 125000000000.00,
                'keterangan'           => 'Target Penerimaan Transfer Pemerintah Pusat (DAU/DAK)',
                'created_at'           => $now,
                'updated_at'           => $now,
            ],
        ];

        $db->table('target_pendapatan')->insertBatch($sampleTargets);
    }
}
