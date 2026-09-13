<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FoundationSeeder extends Seeder
{
    public function run()
    {
        // 1. Seed Master Roles (6 Role Resmi)
        $roles = [
            [
                'id'          => 1,
                'role_code'   => 'superadmin',
                'role_name'   => 'Super Administrator',
                'description' => 'Pengelola penuh infrastruktur, konfigurasi & pengguna sistem',
            ],
            [
                'id'          => 2,
                'role_code'   => 'admin_bpkd',
                'role_name'   => 'Admin',
                'description' => 'Administrator operasional teknis BPKD (kelola pengguna, master SKPK, SBU/ASB)',
            ],
            [
                'id'          => 3,
                'role_code'   => 'kepala_bpkd',
                'role_name'   => 'Kepala BPKD/PPKD',
                'description' => 'Otorisator pengesahan dokumen pergeseran & pengeluaran anggaran BPKD/PPKD',
            ],
            [
                'id'          => 4,
                'role_code'   => 'verifikator_bpkd',
                'role_name'   => 'Verifikator BPKD',
                'description' => 'Pemeriksa administratif, regulasi, dan penelaah usulan pergeseran anggaran',
            ],
            [
                'id'          => 5,
                'role_code'   => 'perencana_opd',
                'role_name'   => 'Perencana/Kepegawaian/Program OPD',
                'description' => 'Penyusun RKA, proyeksi belanja pegawai/ASN, dan pengusul pergeseran pagu OPD',
            ],
            [
                'id'          => 6,
                'role_code'   => 'pimpinan_eksekutif',
                'role_name'   => 'Pimpinan/Eksekutif',
                'description' => 'Akses pemantauan & analisis eksekutif ringkasan serapan anggaran',
            ],
            [
                'id'          => 7,
                'role_code'   => 'operator_bpkd',
                'role_name'   => 'Operator BPKD',
                'description' => 'Operator teknis entri data pergeseran pagu, pencatatan SP2D, & realisasi anggaran BPKD',
            ],
        ];

        foreach ($roles as $role) {
            $this->db->table('master_roles')->upsert($role);
        }

        // 2. Seed Master SKPK
        $skpds = [
            [
                'id'                    => 1,
                'kode_skpd'             => '5.02.0.00.0.00.01.0000',
                'nama_skpd'             => 'Badan Pengelola Keuangan dan Aset Daerah (BPKD)',
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

        // 4. Seed Demo Users (6 Role Akun)
        $defaultPasswordHash = password_hash('user123', PASSWORD_BCRYPT);
        $adminPasswordHash   = password_hash('admin123', PASSWORD_BCRYPT);

        $users = [
            [
                'id'            => 1,
                'role_id'       => 1, // Super Administrator
                'skpd_id'       => 1, // BPKD
                'username'      => 'superadmin',
                'email'         => 'admin@siap-anggaran.go.id',
                'password_hash' => $adminPasswordHash,
                'nama_lengkap'  => 'Administrator Utama SIAP-ANGGARAN',
                'nip'           => '19850101 201001 1 001',
                'jabatan'       => 'System Administrator',
                'phone_number'  => '081234567890',
                'is_active'     => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'id'            => 2,
                'role_id'       => 2, // Admin
                'skpd_id'       => 1, // BPKD
                'username'      => 'admin',
                'email'         => 'admin.bpkd@pemda.go.id',
                'password_hash' => $defaultPasswordHash,
                'nama_lengkap'  => 'Rahmat Hidayat, S.Kom',
                'nip'           => '19870512 201101 1 003',
                'jabatan'       => 'Administrator Operasional BPKD',
                'phone_number'  => '081234567891',
                'is_active'     => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'id'            => 3,
                'role_id'       => 3, // Kepala BPKD/PPKD
                'skpd_id'       => 1, // BPKD
                'username'      => 'kepalabpkd',
                'email'         => 'kepala.bpkd@pemda.go.id',
                'password_hash' => $defaultPasswordHash,
                'nama_lengkap'  => 'Dr. H. Ahmad Fauzi, SE, M.Si',
                'nip'           => '19750812 199803 1 002',
                'jabatan'       => 'Kepala BPKD / PPKD',
                'phone_number'  => '081122334455',
                'is_active'     => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'id'            => 4,
                'role_id'       => 4, // Verifikator BPKD
                'skpd_id'       => 1, // BPKD
                'username'      => 'verifikatorbpkd',
                'email'         => 'verifikator.bpkd@pemda.go.id',
                'password_hash' => $defaultPasswordHash,
                'nama_lengkap'  => 'Ir. Budi Santoso, M.Si',
                'nip'           => '19810625 200604 1 002',
                'jabatan'       => 'Tim Verifikator BPKD',
                'phone_number'  => '081377889900',
                'is_active'     => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'id'            => 5,
                'role_id'       => 5, // Perencana/Kepegawaian/Program OPD
                'skpd_id'       => 3, // Dinas Pendidikan
                'username'      => 'perencanaopd',
                'email'         => 'perencana.opd@pemda.go.id',
                'password_hash' => $defaultPasswordHash,
                'nama_lengkap'  => 'Rina Wulandari, S.E.',
                'nip'           => '19890314 201402 2 003',
                'jabatan'       => 'Kasubag Program & Keuangan OPD',
                'phone_number'  => '081298765432',
                'is_active'     => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'id'            => 6,
                'role_id'       => 6, // Pimpinan/Eksekutif
                'skpd_id'       => null,
                'username'      => 'pimpinan',
                'email'         => 'pimpinan@pemda.go.id',
                'password_hash' => $defaultPasswordHash,
                'nama_lengkap'  => 'Drs. H. Syarifuddin, M.Si',
                'nip'           => '19680918 199303 1 005',
                'jabatan'       => 'Sekretaris Daerah (Sekda)',
                'phone_number'  => '081199001122',
                'is_active'     => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'id'            => 7,
                'role_id'       => 7, // Operator BPKD
                'skpd_id'       => 1, // BPKD
                'username'      => 'operatorbpkd',
                'email'         => 'operator.bpkd@pemda.go.id',
                'password_hash' => $defaultPasswordHash,
                'nama_lengkap'  => 'Agus Prasetyo, A.Md',
                'nip'           => '19920817 201801 1 004',
                'jabatan'       => 'Operator Pengolah Data BPKD',
                'phone_number'  => '081244556677',
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
