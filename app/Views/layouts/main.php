<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'SIAP-ANGGARAN') ?> - Sistem Informasi Akuntabilitas Perencanaan & Anggaran</title>
    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tabler Core CSS & Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --tblr-font-sans-serif: 'Inter', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }
        body {
            font-family: var(--tblr-font-sans-serif);
            background-color: #f4f6fa;
        }
        .brand-gradient {
            background: linear-gradient(135deg, #1e3a8a 0%, #0284c7 100%);
        }
        .sidebar-brand {
            background: rgba(15, 23, 42, 0.95);
        }
        .sidebar-brand .nav-link {
            color: rgba(255, 255, 255, 0.75) !important;
            transition: all 0.2s ease-in-out;
            border-radius: 6px;
            margin: 2px 8px;
            padding: 8px 12px;
        }
        .sidebar-brand .nav-link:hover {
            color: #ffffff !important;
            background-color: rgba(255, 255, 255, 0.08) !important;
        }
        .sidebar-brand .nav-link.active {
            color: #38bdf8 !important;
            background-color: rgba(14, 165, 233, 0.15) !important;
            font-weight: 600 !important;
        }
        .sidebar-brand .nav-link.active .nav-link-icon {
            color: #38bdf8 !important;
        }
        .sidebar-brand .hr-text {
            color: rgba(255, 255, 255, 0.45) !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        
        /* Sidebar Dropdown Styling */
        .sidebar-brand .dropdown-menu {
            background-color: #1e293b !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3) !important;
            padding: 6px;
            border-radius: 8px;
        }
        .sidebar-brand .dropdown-item {
            color: rgba(255, 255, 255, 0.85) !important;
            padding: 8px 12px;
            font-size: 0.875rem;
            border-radius: 6px;
            margin-bottom: 2px;
            transition: all 0.2s ease-in-out;
        }
        .sidebar-brand .dropdown-item:hover, 
        .sidebar-brand .dropdown-item:focus {
            color: #ffffff !important;
            background-color: rgba(56, 189, 248, 0.18) !important;
            padding-left: 15px;
        }
        .sidebar-brand .dropdown-toggle::after {
            color: rgba(255, 255, 255, 0.6);
        }
        .badge-role-superadmin         { background-color: #ef4444; color: #fff; }
        .badge-role-admin_bpkd         { background-color: #06b6d4; color: #fff; }
        .badge-role-kepala_bpkd        { background-color: #10b981; color: #fff; }
        .badge-role-verifikator_bpkd   { background-color: #f59e0b; color: #fff; }
        .badge-role-perencana_opd      { background-color: #3b82f6; color: #fff; }
        .badge-role-pimpinan_eksekutif { background-color: #8b5cf6; color: #fff; }
        .badge-role-operator_bpkd      { background-color: #0284c7; color: #fff; }
        
        .stat-card-gradient-1 { background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%); color: #fff; }
        .stat-card-gradient-2 { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #fff; }
        .stat-card-gradient-3 { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #fff; }
        .stat-card-gradient-4 { background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: #fff; }

        .navbar-vertical.navbar-expand-lg {
            width: 16rem;
        }
        @media (min-width: 992px) {
            .page-wrapper {
                margin-left: 16rem;
            }
        }

        /* Master Data Menu & Top Header Styling */
        .btn-master-data {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.08) 0%, rgba(37, 99, 235, 0.08) 100%) !important;
            border: 1px solid rgba(14, 165, 233, 0.25) !important;
            color: #0284c7 !important;
            font-size: 0.8125rem !important;
            font-weight: 700 !important;
            letter-spacing: 0.03em;
            padding: 7px 14px !important;
            border-radius: 8px !important;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
            box-shadow: 0 2px 4px rgba(2, 132, 199, 0.06) !important;
        }
        .btn-master-data:hover,
        .btn-master-data:focus,
        .show > .btn-master-data {
            background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%) !important;
            border-color: transparent !important;
            color: #ffffff !important;
            box-shadow: 0 4px 14px rgba(2, 132, 199, 0.35) !important;
            transform: translateY(-1px);
        }
        .btn-master-data .master-data-icon-badge {
            width: 24px;
            height: 24px;
            border-radius: 6px;
            background-color: rgba(2, 132, 199, 0.15);
            color: #0284c7;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.25s ease;
        }
        .btn-master-data:hover .master-data-icon-badge,
        .show > .btn-master-data .master-data-icon-badge {
            background-color: rgba(255, 255, 255, 0.25);
            color: #ffffff;
        }

        /* Top Header Dropdown Menu Styling */
        .dropdown-menu-header {
            min-width: 220px;
            background-color: #ffffff !important;
            border: 1px solid rgba(226, 232, 240, 0.9) !important;
            box-shadow: 0 12px 28px -4px rgba(15, 23, 42, 0.12), 0 4px 12px -2px rgba(15, 23, 42, 0.06) !important;
            border-radius: 10px !important;
            padding: 6px !important;
            animation: fadeInDown 0.2s cubic-bezier(0, 0, 0.2, 1);
        }

        /* Top Navbar Dropdown Items Hover & Active Effect */
        .dropdown-menu-header .dropdown-item {
            color: #334155 !important;
            font-size: 0.875rem;
            font-weight: 500;
            padding: 9px 14px;
            border-radius: 6px;
            display: flex !important;
            align-items: center !important;
            gap: 0.75rem !important; /* Proper breathing room between icon and label */
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            margin-bottom: 2px;
        }
        .dropdown-menu-header .dropdown-item:last-child {
            margin-bottom: 0;
        }

        /* Icon & Chevron animation with fixed icon container width */
        .dropdown-menu-header .dropdown-item .menu-icon {
            width: 22px;
            height: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: transform 0.2s ease, color 0.2s ease;
        }
        .dropdown-menu-header .dropdown-item .submenu-arrow {
            transition: transform 0.2s ease, color 0.2s ease;
        }

        /* Hovered & Focused State */
        .dropdown-menu-header .dropdown-item:hover,
        .dropdown-menu-header .dropdown-item:focus,
        .dropdown-menu-header .dropdown-submenu:hover > .dropdown-item {
            color: #0284c7 !important;
            background-color: #f0f9ff !important;
            padding-left: 16px !important;
        }
        .dropdown-menu-header .dropdown-item:hover .menu-icon,
        .dropdown-menu-header .dropdown-submenu:hover > .dropdown-item .menu-icon {
            transform: scale(1.15);
        }
        .dropdown-menu-header .dropdown-submenu:hover > .dropdown-item .submenu-arrow {
            transform: translateX(4px);
            color: #0284c7 !important;
        }

        /* Active / Selected State */
        .dropdown-menu-header .dropdown-item.active,
        .dropdown-menu-header .dropdown-item:active {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%) !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            box-shadow: 0 4px 10px rgba(2, 132, 199, 0.25);
            padding-left: 14px !important;
        }
        .dropdown-menu-header .dropdown-item.active .menu-icon,
        .dropdown-menu-header .dropdown-item.active i,
        .dropdown-menu-header .dropdown-item.active .submenu-arrow,
        .dropdown-menu-header .dropdown-item:active .menu-icon,
        .dropdown-menu-header .dropdown-item:active i {
            color: #ffffff !important;
        }

        /* Nested Dropdown Submenu Positioning & Smooth Animation */
        .dropdown-submenu {
            position: relative;
        }
        .dropdown-submenu > .dropdown-menu {
            top: -6px;
            left: 100%;
            margin-left: 6px;
            display: none;
            box-shadow: 0 12px 28px -4px rgba(15, 23, 42, 0.15) !important;
        }
        .dropdown-submenu:hover > .dropdown-menu,
        .dropdown-submenu:focus-within > .dropdown-menu {
            display: block;
            animation: fadeInRight 0.2s cubic-bezier(0, 0, 0.2, 1);
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(-6px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>
<body class="layout-fluid">
    <div class="page">
        <!-- Sidebar Navbar (Least Privilege Navigation) -->
        <aside class="navbar navbar-vertical navbar-expand-lg navbar-dark sidebar-brand shadow-sm">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark pt-3 pb-2 px-2">
                    <a href="<?= base_url('/dashboard') ?>" class="text-decoration-none text-white d-flex align-items-center gap-2">
                        <i class="bi bi-wallet2 text-info fs-2"></i>
                        <div class="text-start">
                            <span class="fw-bold fs-3 text-white d-block">SIAP-ANGGARAN</span>
                            <small class="text-secondary fw-normal fs-6 d-block">Sistem Akuntabilitas Anggaran</small>
                        </div>
                    </a>
                </h1>
                
                <div class="px-3 py-2 my-2 bg-dark rounded border border-secondary border-opacity-25 text-white-50 fs-6">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-1">
                        <span><i class="bi bi-calendar-check text-info me-1"></i> TA 2026</span>
                        <span class="badge bg-warning text-dark px-2">Digitalisasi penganggaran</span>
                    </div>
                </div>

                <div class="collapse navbar-collapse" id="sidebar-menu">
                    <ul class="navbar-nav pt-lg-3">
                        <li class="nav-item">
                            <a class="nav-link <?= (current_url() == base_url('/dashboard')) ? 'active' : '' ?>" href="<?= base_url('/dashboard') ?>">
                                <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-speedometer2"></i></span>
                                <span class="nav-link-title">Dashboard</span>
                            </a>
                        </li>

                        <?php $roleCode = session()->get('role_code'); ?>



                        <!-- 2. SATU-DATA ANGGARAN -->
                        <?php if (in_array($roleCode, ['superadmin', 'admin_bpkd', 'perencana_opd', 'verifikator_bpkd', 'operator_bpkd', 'kepala_bpkd'])): ?>
                            <div class="hr-text hr-text-left text-uppercase fw-bold mt-3 mb-2 px-3 fs-6">Satu-Data Anggaran</div>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-people text-primary"></i></span>
                                    <span class="nav-link-title">Data Kepegawaian</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-bank text-info"></i></span>
                                    <span class="nav-link-title">Data TKDD</span>
                                </a>
                            </li>
                            <?php $isApbkTargetActive = str_contains(current_url(), 'target-pendapatan'); ?>
                            <li class="nav-item dropdown <?= $isApbkTargetActive ? 'active' : '' ?>">
                                <a class="nav-link dropdown-toggle <?= $isApbkTargetActive ? 'active' : '' ?>" href="#sidebar-apbk" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="<?= $isApbkTargetActive ? 'true' : 'false' ?>">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-clipboard-data text-info"></i></span>
                                    <span class="nav-link-title">APBK (Target)</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-dark <?= $isApbkTargetActive ? 'show' : '' ?>">
                                    <a class="dropdown-item <?= (current_url() == base_url('/target-pendapatan')) ? 'active' : '' ?>" href="<?= base_url('/target-pendapatan') ?>">
                                        <i class="bi bi-graph-up-arrow text-success me-2"></i> Pendapatan
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="bi bi-cart-check text-warning me-2"></i> Belanja
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="bi bi-cash-stack text-purple me-2"></i> Pembiayaan
                                    </a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#sidebar-realisasi" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-pie-chart text-success"></i></span>
                                    <span class="nav-link-title">Realisasi APBK</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-dark">
                                    <a class="dropdown-item" href="#">
                                        <i class="bi bi-graph-up-arrow text-success me-2"></i> Pendapatan
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="bi bi-cart-check text-warning me-2"></i> Belanja
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="bi bi-cash-stack text-purple me-2"></i> Pembiayaan
                                    </a>
                                </div>
                            </li>
                        <?php endif; ?>

                        <!-- 3. STANDAR HARGA -->
                        <?php if (in_array($roleCode, ['superadmin', 'admin_bpkd', 'verifikator_bpkd', 'perencana_opd'])): ?>
                            <div class="hr-text hr-text-left text-uppercase fw-bold mt-3 mb-2 px-3 fs-6">Standar Harga</div>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-journal-bookmark text-success"></i></span>
                                    <span class="nav-link-title">Standar Biaya Umum (SBU)</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-calculator text-info"></i></span>
                                    <span class="nav-link-title">Analisis Standar Biaya (ASB)</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <!-- 4. PERGESERAN -->
                        <?php if (in_array($roleCode, ['superadmin', 'admin_bpkd', 'perencana_opd', 'verifikator_bpkd', 'operator_bpkd', 'kepala_bpkd'])): ?>
                            <div class="hr-text hr-text-left text-uppercase fw-bold mt-3 mb-2 px-3 fs-6">Pergeseran</div>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-file-earmark-diff text-warning"></i></span>
                                    <span class="nav-link-title">Usulkan Pergeseran Pagu</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-check2-square text-info"></i></span>
                                    <span class="nav-link-title">Verifikasi & Entri Pergeseran</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-shield-check text-success"></i></span>
                                    <span class="nav-link-title">Pengesahan Pergeseran</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <!-- 5. EKSEKUTIF MONITORING -->
                        <?php if (in_array($roleCode, ['superadmin', 'pimpinan_eksekutif', 'kepala_bpkd', 'admin_bpkd'])): ?>
                            <div class="hr-text hr-text-left text-uppercase fw-bold mt-3 mb-2 px-3 fs-6">Eksekutif Monitoring</div>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-graph-up-arrow text-purple"></i></span>
                                    <span class="nav-link-title">Executive Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-file-earmark-pdf text-danger"></i></span>
                                    <span class="nav-link-title">Laporan Pagu & Realisasi</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <!-- 6. SISTEM -->
                        <?php if (in_array($roleCode, ['superadmin', 'admin_bpkd'])): ?>
                            <div class="hr-text hr-text-left text-uppercase fw-bold mt-3 mb-2 px-3 fs-6">Sistem</div>
                            <li class="nav-item">
                                <a class="nav-link <?= (str_contains(current_url(), '/users')) ? 'active' : '' ?>" href="<?= base_url('/users') ?>">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-people-fill text-danger"></i></span>
                                    <span class="nav-link-title">Manajemen User & RBAC</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-shield-lock text-warning"></i></span>
                                    <span class="nav-link-title">Audit Log & Security</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </aside>

        <!-- Top Header Navigation Bar -->
        <header class="navbar navbar-expand navbar-light sticky-top bg-white border-bottom shadow-sm">
            <div class="container-fluid px-3 px-lg-4">
                <div class="d-flex align-items-center gap-3">
                    <?php if (in_array($roleCode, ['superadmin', 'admin_bpkd', 'perencana_opd'])): ?>
                        <div class="nav-item dropdown ms-2 ms-lg-3">
                            <a class="nav-link dropdown-toggle btn-master-data d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                                <span class="master-data-icon-badge">
                                    <i class="bi bi-database fs-6"></i>
                                </span>
                                <span>MASTER DATA</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-header mt-1">
                                <a class="dropdown-item <?= (str_contains(current_url(), '/skpk')) ? 'active' : '' ?>" href="<?= base_url('/skpk') ?>">
                                    <i class="bi bi-building text-info fs-5 menu-icon"></i>
                                    <span>SKPK</span>
                                </a>
                                <div class="dropdown-submenu">
                                    <a class="dropdown-item justify-content-between <?= (str_contains(current_url(), '/akun') || str_contains(current_url(), '/kelompok') || str_contains(current_url(), '/jenis') || str_contains(current_url(), '/objek') || str_contains(current_url(), '/rincian-objek') || str_contains(current_url(), '/sub-rincian-objek')) ? 'active' : '' ?>" href="#">
                                        <div class="d-flex align-items-center gap-3">
                                            <i class="bi bi-receipt text-warning fs-5 menu-icon"></i>
                                            <span>Akun</span>
                                        </div>
                                        <i class="bi bi-chevron-right fs-6 text-muted submenu-arrow ms-2"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-header">
                                        <a class="dropdown-item <?= (str_contains(current_url(), '/akun')) ? 'active' : '' ?>" href="<?= base_url('/akun') ?>">
                                            <i class="bi bi-hash text-secondary menu-icon"></i> <span>Akun</span>
                                        </a>
                                        <a class="dropdown-item <?= (str_contains(current_url(), '/kelompok')) ? 'active' : '' ?>" href="<?= base_url('/kelompok') ?>">
                                            <i class="bi bi-folder2-open text-primary menu-icon"></i> <span>Kelompok</span>
                                        </a>
                                        <a class="dropdown-item <?= (str_contains(current_url(), '/jenis')) ? 'active' : '' ?>" href="<?= base_url('/jenis') ?>">
                                            <i class="bi bi-tag text-info menu-icon"></i> <span>Jenis</span>
                                        </a>
                                        <a class="dropdown-item <?= (str_contains(current_url(), '/objek')) ? 'active' : '' ?>" href="<?= base_url('/objek') ?>">
                                            <i class="bi bi-box text-success menu-icon"></i> <span>Objek</span>
                                        </a>
                                        <a class="dropdown-item <?= (str_contains(current_url(), '/rincian-objek')) ? 'active' : '' ?>" href="<?= base_url('/rincian-objek') ?>">
                                            <i class="bi bi-list-nested text-warning menu-icon"></i> <span>Rincian Objek</span>
                                        </a>
                                        <a class="dropdown-item <?= (str_contains(current_url(), '/sub-rincian-objek')) ? 'active' : '' ?>" href="<?= base_url('/sub-rincian-objek') ?>">
                                            <i class="bi bi-card-list text-danger menu-icon"></i> <span>Sub Rincian Objek</span>
                                        </a>
                                    </div>
                                </div>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-diagram-3 text-primary fs-5 menu-icon"></i>
                                    <span>PPD</span>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!in_array($roleCode, ['superadmin', 'admin_bpkd'])): ?>
                        <div class="d-flex align-items-center gap-2">
                            <span class="text-secondary fw-medium fs-5 d-none d-sm-inline-flex align-items-center gap-1">
                                <i class="bi bi-building text-primary"></i> SKPK:
                            </span>
                            <?php if (in_array($roleCode, ['pimpinan_eksekutif', 'kepala_bpkd', 'verifikator_bpkd', 'operator_bpkd'])): ?>
                                <form action="<?= base_url('/skpk/switch') ?>" method="post" class="d-inline-block m-0">
                                    <?= csrf_field() ?>
                                    <select name="skpd_id" class="form-select form-select-sm border-secondary-subtle fw-bold text-dark rounded-2 shadow-none" onchange="this.form.submit()" style="min-width: 220px; max-width: 340px; cursor: pointer;">
                                        <option value="" <?= empty(session()->get('skpd_id')) ? 'selected' : '' ?>>-- Seluruh SKPK (Pemda) --</option>
                                        <?php 
                                        $headerSkpds = (new \App\Models\SkpdModel())->orderBy('kode_skpd', 'ASC')->findAll();
                                        foreach ($headerSkpds as $hSkpd): 
                                        ?>
                                            <option value="<?= $hSkpd['id'] ?>" <?= (session()->get('skpd_id') == $hSkpd['id']) ? 'selected' : '' ?>>
                                                <?= esc($hSkpd['kode_skpd']) ?> - <?= esc($hSkpd['nama_skpd']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </form>
                            <?php else: ?>
                                <span class="text-dark fw-bold fs-5"><?= esc(session()->get('nama_skpd') ?? 'Pemerintah Daerah') ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="navbar-nav flex-row order-md-last align-items-center ms-auto gap-3">
                    <!-- User Profile Dropdown (Logout Menu) -->
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex align-items-center lh-1 text-reset p-1 rounded-2 text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false" role="button" id="userProfileDropdown">
                            <span class="avatar avatar-sm rounded-circle bg-primary-subtle text-primary fw-bold me-2">
                                <?= strtoupper(substr(session()->get('nama_lengkap') ?? 'U', 0, 2)) ?>
                            </span>
                            <div class="text-start me-1">
                                <div class="fw-semibold text-dark fs-5 align-middle d-flex align-items-center">
                                    <span><?= esc(session()->get('nama_lengkap')) ?></span>
                                    <i class="bi bi-chevron-down ms-1.5 text-secondary fs-6"></i>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end shadow-md border-0 rounded-3 mt-2" aria-labelledby="userProfileDropdown" style="min-width: 230px;">
                            <div class="dropdown-header bg-light rounded-top py-2.5 px-3">
                                <strong class="d-block text-dark mb-0 fs-5"><?= esc(session()->get('nama_lengkap')) ?></strong>
                                <small class="text-muted d-block">@<?= esc(session()->get('username')) ?></small>
                                <small class="text-secondary d-block mt-1"><i class="bi bi-person-badge me-1"></i><?= esc(session()->get('jabatan') ?? 'User SIAP-ANGGARAN') ?></small>
                            </div>
                            <div class="dropdown-divider my-1"></div>
                            <a href="<?= base_url('/logout') ?>" class="dropdown-item text-danger fw-semibold py-2 px-3 d-flex align-items-center gap-2">
                                <i class="bi bi-box-arrow-right fs-5 text-danger"></i>
                                <span>Keluar (Logout)</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Wrapper Content -->
        <div class="page-wrapper p-4">
            <div class="container-fluid">
                <!-- Flash Notification Messages -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-3 mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-3 mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Dynamic Content View -->
                <?= $this->renderSection('content') ?>
            </div>

            <!-- Footer -->
            <footer class="footer footer-transparent d-print-none mt-5 pt-4 border-top">
                <div class="container-fluid">
                    <div class="row text-center align-items-center flex-row-reverse">
                        <div class="col-lg-auto ms-lg-auto">
                            <span class="text-muted fs-6">Tahap 1: Fondasi & Autentikasi RBAC</span>
                        </div>
                        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                            <span class="text-muted fs-6">&copy; 2026 SIAP-ANGGARAN &bull; Sistem Informasi Akuntabilitas Perencanaan & Anggaran</span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Tabler JS Bundle (Includes Bootstrap 5 JS) -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
</body>
</html>
