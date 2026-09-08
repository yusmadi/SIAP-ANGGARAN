<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FoundationSeeder extends Seeder
{
    public function run()
    {
        // 1. Seed Master Roles
        $roles = [
            [
                'id'          => 1,
                'role_code'   => 'superadmin',
                'role_name'   => 'Super Administrator',
                'description' => 'Pengelola penuh infrastruktur & pengguna sistem',
            ],
            [
                'id'          => 2,
                'role_code'   => 'perencana',
                'role_name'   => 'Perencana SKPD',
                'description' => 'Penyusun RKA dan pengusul pergeseran pagu SKPD',
            ],
            [
                'id'          => 3,
                'role_code'   => 'verifikator',
                'role_name'   => 'Verifikator TAPD / BPKAD',
                'description' => 'Pemeriksa administratif dan regulasi pergeseran pagu',
            ],
            [
                'id'          => 4,
                'role_code'   => 'pejabat_keuangan',
                'role_name'   => 'PPKD / Kepala BPKAD',
                'description' => 'Otorisator pengesahan dokumen pergeseran dan pengeluaran',
            ],
            [
                'id'          => 5,
                'role_code'   => 'pimpinan',
                'role_name'   => 'Pimpinan Daerah / Eksekutif',
                'description' => 'Akses pemantauan eksekutif ringkasan serapan pagu',
            ],
        ];

        foreach ($roles as $role) {
            $this->db->table('master_roles')->upsert($role);
        }

        // 2. Seed Master SKPD
        $skpds = [
            [
                'id'                    => 1,
                'kode_skpd'             => '5.02.0.00.0.00.01.0000',
                'nama_skpd'             => 'Badan Pengelola Keuangan dan Aset Daerah (BPKAD)',
                'nama_kepala'           => 'Dr. H. Ahmad Fauzi, SE, M.Si',
                'nip_kepala'            => '19750812 199803 1 002',
                'pagu_total_murni'      => 125000000000.00,
                'pagu_total_pergeseran' => 125000000000.00,
                'created_at'            => date('Y-m-d H:i:s'),
                'updated_at'            => date('Y-m-d H:i:s'),
            ],
            [
                'id'                    => 2,
                'kode_skpd'             => '5.01.0.00.0.00.01.0000',
                'nama_skpd'             => 'Badan Perencanaan Pembangunan Daerah (BAPPEDA)',
                'nama_kepala'           => 'Drs. Bambang Sugipto, M.AP',
                'nip_kepala'            => '19720415 199703 1 004',
                'pagu_total_murni'      => 45000000000.00,
                'pagu_total_pergeseran' => 45000000000.00,
                'created_at'            => date('Y-m-d H:i:s'),
                'updated_at'            => date('Y-m-d H:i:s'),
            ],
            [
                'id'                    => 3,
                'kode_skpd'             => '1.01.0.00.0.00.01.0000',
                'nama_skpd'             => 'Dinas Pendidikan dan Kebudayaan',
                'nama_kepala'           => 'Hj. Siti Rahmah, M.Pd',
                'nip_kepala'            => '19701120 199512 2 001',
                'pagu_total_murni'      => 320000000000.00,
                'pagu_total_pergeseran' => 320000000000.00,
                'created_at'            => date('Y-m-d H:i:s'),
                'updated_at'            => date('Y-m-d H:i:s'),
            ],
            [
                'id'                    => 4,
                'kode_skpd'             => '1.02.0.00.0.00.01.0000',
                'nama_skpd'             => 'Dinas Kesehatan',
                'nama_kepala'           => 'dr. Hendra Wijaya, Sp.OG',
                'nip_kepala'            => '19780210 200312 1 003',
                'pagu_total_murni'      => 185000000000.00,
                'pagu_total_pergeseran' => 185000000000.00,
                'created_at'            => date('Y-m-d H:i:s'),
                'updated_at'            => date('Y-m-d H:i:s'),
            ],
        ];

        foreach ($skpds as $skpd) {
            $this->db->table('master_skpd')->upsert($skpd);
        }

        // 3. Seed Tahun Anggaran
        $tahun = [
            'id'             => 1,
            'tahun'          => 2026,
            'status_tahapan' => 'pergeseran',
            'is_active'      => 1,
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
        ];
        $this->db->table('tahun_anggaran')->upsert($tahun);

        // 4. Seed Demo Users
        $defaultPasswordHash = password_hash('user123', PASSWORD_BCRYPT);
        $adminPasswordHash   = password_hash('admin123', PASSWORD_BCRYPT);

        $users = [
            [
                'id'            => 1,
                'role_id'       => 1, // Superadmin
                'skpd_id'       => 1, // BPKAD
                'username'      => 'superadmin',
                'email'         => 'admin@siap-pagu.go.id',
                'password_hash' => $adminPasswordHash,
                'nama_lengkap'  => 'Administrator Utama SIAP-PAGU',
                'nip'           => '19850101 201001 1 001',
                'jabatan'       => 'System Administrator',
                'phone_number'  => '081234567890',
                'is_active'     => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'id'            => 2,
                'role_id'       => 2, // Perencana
                'skpd_id'       => 1, // BPKAD
                'username'      => 'perencana',
                'email'         => 'perencana@bpkad.go.id',
                'password_hash' => $defaultPasswordHash,
                'nama_lengkap'  => 'Rina Wulandari, S.E.',
                'nip'           => '19890314 201402 2 003',
                'jabatan'       => 'Kasubag Program & Keuangan BPKAD',
                'phone_number'  => '081298765432',
                'is_active'     => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'id'            => 3,
                'role_id'       => 3, // Verifikator
                'skpd_id'       => 2, // BAPPEDA
                'username'      => 'verifikator',
                'email'         => 'verifikator@tapd.go.id',
                'password_hash' => $defaultPasswordHash,
                'nama_lengkap'  => 'Ir. Budi Santoso, M.Si',
                'nip'           => '19810625 200604 1 002',
                'jabatan'       => 'Tim Verifikator TAPD Bappeda',
                'phone_number'  => '081377889900',
                'is_active'     => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'id'            => 4,
                'role_id'       => 4, // PPKD / Pejabat Keuangan
                'skpd_id'       => 1, // BPKAD
                'username'      => 'ppkd',
                'email'         => 'ppkd@bpkad.go.id',
                'password_hash' => $defaultPasswordHash,
                'nama_lengkap'  => 'Dr. H. Ahmad Fauzi, SE, M.Si',
                'nip'           => '19750812 199803 1 002',
                'jabatan'       => 'Kepala BPKAD / PPKD',
                'phone_number'  => '081122334455',
                'is_active'     => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'id'            => 5,
                'role_id'       => 5, // Pimpinan Eksekutif
                'skpd_id'       => null,
                'username'      => 'pimpinan',
                'email'         => 'sekda@pemda.go.id',
                'password_hash' => $defaultPasswordHash,
                'nama_lengkap'  => 'Drs. H. Syarifuddin, M.Si',
                'nip'           => '19680918 199303 1 005',
                'jabatan'       => 'Sekretaris Daerah (Sekda)',
                'phone_number'  => '081199001122',
                'is_active'     => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
        ];

        foreach ($users as $user) {
            $this->db->table('users')->upsert($user);
        }
    }
}
