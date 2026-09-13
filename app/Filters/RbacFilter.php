<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RbacFilter implements FilterInterface
{
    /**
     * Permission Matrix per Role Code (6 Role Resmi)
     */
    protected array $rolePermissions = [
        'superadmin'  => ['*'], // Akses penuh
        'admin_bpkd'  => [
            'dashboard',
            'users',
            'users/store',
            'users/toggle',
            'skpd',
            'akun',
            'kelompok',
            'jenis',
            'objek',
            'rincian-objek',
            'sub-rincian-objek',
            'sbu',
            'asb',
            'pagu',
        ],
        'kepala_bpkd' => [
            'dashboard',
            'otorisasi',
            'pergeseran',
            'pergeseran/otorisasi-action',
            'sp2d',
            'pagu',
            'laporan',
        ],
        'verifikator_bpkd' => [
            'dashboard',
            'verifikasi',
            'pergeseran',
            'pergeseran/verifikasi-action',
            'sbu',
            'asb',
            'pagu',
        ],
        'perencana_opd' => [
            'dashboard',
            'akun',
            'kelompok',
            'jenis',
            'objek',
            'rincian-objek',
            'sub-rincian-objek',
            'pergeseran',
            'pergeseran/usulan',
            'pergeseran/simpan-usulan',
            'rka',
            'asn',
            'pagu',
        ],
        'pimpinan_eksekutif' => [
            'dashboard',
            'monitoring',
            'laporan',
            'pagu',
        ],
        'operator_bpkd' => [
            'dashboard',
            'pergeseran',
            'pergeseran/entri',
            'sp2d',
            'pagu',
            'sbu',
            'asb',
        ],
    ];

    public function before(RequestInterface $request, $arguments = null)
    {
        $session  = session();
        $roleCode = $session->get('role_code');

        if (!$roleCode) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Superadmin memiliki wewenang penuh
        if ($roleCode === 'superadmin') {
            return;
        }

        $uri = service('uri');
        $segment1 = strtolower($uri->getSegment(1) ?? 'dashboard');
        $segment2 = strtolower($uri->getSegment(2) ?? '');
        $currentPath = $segment2 ? "{$segment1}/{$segment2}" : $segment1;

        $allowedRoutes = $this->rolePermissions[$roleCode] ?? [];

        // Check if current path or segment1 is allowed
        $isAllowed = in_array($currentPath, $allowedRoutes, true) || in_array($segment1, $allowedRoutes, true);

        if (!$isAllowed) {
            $response = service('response');
            $response->setStatusCode(403);
            $response->setBody(view('errors/html/error_403', [
                'role_name'    => $session->get('role_name'),
                'attempted_uri'=> "/{$currentPath}"
            ]));
            return $response;
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed after request
    }
}
