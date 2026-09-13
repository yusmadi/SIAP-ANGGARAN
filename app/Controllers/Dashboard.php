<?php

namespace App\Controllers;

use App\Models\AuditLogModel;
use App\Models\SkpdModel;
use App\Models\TahunAnggaranModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $session    = session();
        $tahunModel = new TahunAnggaranModel();
        $skpdModel  = new SkpdModel();
        $userModel  = new UserModel();
        $auditModel = new AuditLogModel();

        $activeYear = $tahunModel->getActiveYear() ?? [
            'tahun'          => date('Y'),
            'status_tahapan' => 'pergeseran',
        ];

        $selectedSkpdId = $session->get('skpd_id');

        $totalUsers = $userModel->countAllResults();
        $totalSkpd  = $skpdModel->countAllResults();

        $statQuery = $skpdModel->selectSum('pagu_total_murni', 'total_murni')
                               ->selectSum('pagu_total_pergeseran', 'total_pergeseran');
        if ($selectedSkpdId) {
            $statQuery->where('id', $selectedSkpdId);
        }
        $skpdStats = $statQuery->first();

        $roleCode = $session->get('role_code') ?? 'superadmin';

        $data = [
            'title'       => 'Dashboard Utama - SIAP-ANGGARAN',
            'active_year' => $activeYear,
            'user'        => [
                'name'      => $session->get('nama_lengkap'),
                'username'  => $session->get('username'),
                'role_code' => $roleCode,
                'role_name' => $session->get('role_name'),
                'nama_skpd' => $session->get('nama_skpd'),
                'jabatan'   => $session->get('jabatan'),
                'nip'       => $session->get('nip'),
                'skpd_id'   => $session->get('skpd_id'),
            ],
            'stats'       => [
                'total_users'      => $totalUsers,
                'total_skpd'       => $totalSkpd,
                'total_pagu_murni' => $skpdStats['total_murni'] ?? 0,
                'total_pergeseran' => $skpdStats['total_pergeseran'] ?? 0,
            ],
        ];

        // Tambahan data spesifik per role
        switch ($roleCode) {
            case 'superadmin':
                $data['recent_logs'] = $auditModel->select('audit_logs.*, users.username, users.nama_lengkap')
                                                  ->join('users', 'users.id = audit_logs.user_id', 'left')
                                                  ->orderBy('audit_logs.id', 'DESC')
                                                  ->limit(8)
                                                  ->findAll();
                $data['roles_count'] = $userModel->db->table('master_roles')
                                                  ->select('master_roles.role_name, master_roles.role_code, COUNT(users.id) as user_count')
                                                  ->join('users', 'users.role_id = master_roles.id', 'left')
                                                  ->groupBy('master_roles.id')
                                                  ->get()
                                                  ->getResultArray();
                return view('dashboard/superadmin', $data);

            case 'admin_bpkd':
                $data['skpd_list'] = $skpdModel->orderBy('kode_skpd', 'ASC')->findAll();
                $data['total_sbu'] = 1420; // Data master SBU
                $data['total_asb'] = 380;  // Data master ASB
                return view('dashboard/admin_bpkd', $data);

            case 'kepala_bpkd':
                $data['pending_approvals'] = [
                    ['no_usulan' => 'USL/2026/BPKD/004', 'skpd' => 'Dinas Pendidikan dan Kebudayaan', 'tanggal' => '11 Sep 2026', 'nominal' => 450000000, 'tujuan' => 'Pergeseran Antar Rincian Belanja Pegawai & Operasional'],
                    ['no_usulan' => 'USL/2026/BPKD/003', 'skpd' => 'Dinas Kesehatan', 'tanggal' => '10 Sep 2026', 'nominal' => 280000000, 'tujuan' => 'Reelokasi Pagu Penanganan Stunting Bulanan'],
                    ['no_usulan' => 'USL/2026/BPKD/002', 'skpd' => 'BAPPEDA', 'tanggal' => '09 Sep 2026', 'nominal' => 125000000, 'tujuan' => 'Pemberian TPP Evaluasi Program Strategis Daerah'],
                ];
                $data['total_sp2d_terbit'] = 84500000000;
                return view('dashboard/kepala_bpkd', $data);

            case 'verifikator_bpkd':
                $data['verification_queue'] = [
                    ['no_usulan' => 'USL/2026/BPKD/005', 'skpd' => 'Dinas Pekerjaan Umum', 'tanggal' => '11 Sep 2026', 'nominal' => 620000000, 'sbu_status' => 'Sesuai SBU', 'status' => 'Menunggu Verifikasi'],
                    ['no_usulan' => 'USL/2026/BPKD/004', 'skpd' => 'Dinas Pendidikan dan Kebudayaan', 'tanggal' => '11 Sep 2026', 'nominal' => 450000000, 'sbu_status' => 'Sesuai SBU', 'status' => 'Siap Otorisasi'],
                    ['no_usulan' => 'USL/2026/BPKD/003', 'skpd' => 'Dinas Kesehatan', 'tanggal' => '10 Sep 2026', 'nominal' => 280000000, 'sbu_status' => 'Perlu Klarifikasi SBU', 'status' => 'Revisi Regulasi'],
                ];
                return view('dashboard/verifikator_bpkd', $data);

            case 'perencana_opd':
                $userSkpdId = $session->get('skpd_id') ?? 1;
                $userSkpd   = $skpdModel->find($userSkpdId);
                $data['my_skpd'] = $userSkpd ?? [
                    'nama_skpd' => 'Dinas Pendidikan dan Kebudayaan',
                    'pagu_total_murni' => 320000000000.00,
                    'pagu_total_pergeseran' => 320000000000.00,
                ];
                $data['usulan_history'] = [
                    ['no_usulan' => 'USL/2026/OPD/001', 'perihal' => 'Usulan Pergeseran Pagu Belanja Pegawai TPP', 'tanggal' => '08 Sep 2026', 'nominal' => 150000000, 'status' => 'Disetujui TAPD'],
                    ['no_usulan' => 'USL/2026/OPD/002', 'perihal' => 'Penyesuaian Biaya Honorarium Narasumber SBU', 'tanggal' => '11 Sep 2026', 'nominal' => 45000000, 'status' => 'Proses Verifikasi BPKD'],
                ];
                return view('dashboard/perencana_opd', $data);

            case 'pimpinan_eksekutif':
                $data['serapan_persen'] = 68.4;
                $data['total_realisasi'] = 457800000000;
                $data['top_skpd'] = [
                    ['nama_skpd' => 'Dinas Pendidikan dan Kebudayaan', 'pagu' => 320000000000, 'realisasi' => 230400000000, 'persen' => 72.0],
                    ['nama_skpd' => 'Badan Pengelola Keuangan dan Aset Daerah', 'pagu' => 125000000000, 'realisasi' => 88750000000, 'persen' => 71.0],
                    ['nama_skpd' => 'Dinas Kesehatan', 'pagu' => 185000000000, 'realisasi' => 120250000000, 'persen' => 65.0],
                    ['nama_skpd' => 'BAPPEDA', 'pagu' => 45000000000, 'realisasi' => 28350000000, 'persen' => 63.0],
                ];
                return view('dashboard/pimpinan_eksekutif', $data);

            case 'operator_bpkd':
                $data['operator_tasks'] = [
                    ['kode_berkas' => 'BRK/2026/089', 'skpd' => 'Dinas Pendidikan dan Kebudayaan', 'kegiatan' => 'Entri Pergeseran Sub-Kegiatan Belanja Pegawai', 'status' => 'Draft Entri', 'tgl_masuk' => '11 Sep 2026', 'nominal' => 450000000],
                    ['kode_berkas' => 'BRK/2026/088', 'skpd' => 'Dinas Kesehatan', 'kegiatan' => 'Input Pencairan SP2D Non-Gaji Stunting', 'status' => 'Selesai Entri', 'tgl_masuk' => '10 Sep 2026', 'nominal' => 280000000],
                    ['kode_berkas' => 'BRK/2026/087', 'skpd' => 'BAPPEDA', 'kegiatan' => 'Pencatatan Pergeseran Pagu Tambahan TPP', 'status' => 'Proses Validasi', 'tgl_masuk' => '09 Sep 2026', 'nominal' => 125000000],
                    ['kode_berkas' => 'BRK/2026/086', 'skpd' => 'Dinas Pekerjaan Umum', 'kegiatan' => 'Entri Pagu Pergeseran Sarpras Infrastruktur', 'status' => 'Draft Entri', 'tgl_masuk' => '09 Sep 2026', 'nominal' => 620000000],
                ];
                $data['total_entri_hari_ini'] = 14;
                $data['total_pending_entri'] = 6;
                $data['total_berkas_diverifikasi'] = 42;
                return view('dashboard/operator_bpkd', $data);

            default:
                return view('dashboard/index', $data);
        }
    }
}

