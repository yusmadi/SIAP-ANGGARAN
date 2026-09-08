<?php

namespace App\Controllers;

use App\Models\SkpdModel;
use App\Models\TahunAnggaranModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $session = session();
        $tahunModel = new TahunAnggaranModel();
        $skpdModel  = new SkpdModel();
        $userModel  = new UserModel();

        $activeYear = $tahunModel->getActiveYear() ?? [
            'tahun'          => date('Y'),
            'status_tahapan' => 'penyusunan',
        ];

        $totalUsers = $userModel->countAllResults();
        $totalSkpd  = $skpdModel->countAllResults();
        
        $skpdStats  = $skpdModel->selectSum('pagu_total_murni', 'total_murni')
                                ->selectSum('pagu_total_pergeseran', 'total_pergeseran')
                                ->first();

        $data = [
            'title'           => 'Dashboard Utama',
            'active_year'     => $activeYear,
            'user'            => [
                'name'      => $session->get('nama_lengkap'),
                'username'  => $session->get('username'),
                'role_code' => $session->get('role_code'),
                'role_name' => $session->get('role_name'),
                'nama_skpd' => $session->get('nama_skpd'),
                'jabatan'   => $session->get('jabatan'),
                'nip'       => $session->get('nip'),
            ],
            'stats'           => [
                'total_users'      => $totalUsers,
                'total_skpd'       => $totalSkpd,
                'total_pagu_murni' => $skpdStats['total_murni'] ?? 0,
                'total_pergeseran' => $skpdStats['total_pergeseran'] ?? 0,
            ]
        ];

        return view('dashboard/index', $data);
    }
}
