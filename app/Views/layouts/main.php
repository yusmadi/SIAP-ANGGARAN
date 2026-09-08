<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'SIAP-PAGU') ?> - Sistem Informasi Akuntabilitas Perencanaan & Pagu Anggaran</title>
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
        .badge-role-superadmin { background-color: #ef4444; color: #fff; }
        .badge-role-perencana  { background-color: #3b82f6; color: #fff; }
        .badge-role-verifikator{ background-color: #f59e0b; color: #fff; }
        .badge-role-pejabat_keuangan { background-color: #10b981; color: #fff; }
        .badge-role-pimpinan   { background-color: #8b5cf6; color: #fff; }
        
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
                            <span class="fw-bold fs-3 text-white d-block">SIAP-PAGU</span>
                            <small class="text-secondary fw-normal fs-6 d-block">Sistem Akuntabilitas Pagu</small>
                        </div>
                    </a>
                </h1>
                
                <div class="px-3 py-2 my-2 bg-dark rounded border border-secondary border-opacity-25 text-white-50 fs-6">
                    <div class="d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-calendar-check text-info me-1"></i> TA 2026</span>
                        <span class="badge bg-warning text-dark px-2">Pergeseran</span>
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

                        <!-- SUPERADMIN MENU -->
                        <?php if ($roleCode === 'superadmin'): ?>
                            <div class="hr-text hr-text-left text-secondary text-uppercase fw-bold mt-3 mb-2 px-3 fs-6">Administrasi Sistem</div>
                            <li class="nav-item">
                                <a class="nav-link <?= (str_contains(current_url(), '/users')) ? 'active' : '' ?>" href="<?= base_url('/users') ?>">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-people-fill text-danger"></i></span>
                                    <span class="nav-link-title">Manajemen User & RBAC</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-secondary" href="#">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-building text-info"></i></span>
                                    <span class="nav-link-title">Master Data SKPD</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <!-- PERENCANA OPD MENU -->
                        <?php if (in_array($roleCode, ['superadmin', 'perencana'])): ?>
                            <div class="hr-text hr-text-left text-secondary text-uppercase fw-bold mt-3 mb-2 px-3 fs-6">Modul Perencanaan</div>
                            <li class="nav-item">
                                <a class="nav-link text-secondary" href="#">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-person-badge text-primary"></i></span>
                                    <span class="nav-link-title">Kebutuhan Belanja ASN</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-secondary" href="#">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-file-earmark-diff text-warning"></i></span>
                                    <span class="nav-link-title">Usulkan Pergeseran Pagu</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <!-- VERIFIKATOR TAPD MENU -->
                        <?php if (in_array($roleCode, ['superadmin', 'verifikator'])): ?>
                            <div class="hr-text hr-text-left text-secondary text-uppercase fw-bold mt-3 mb-2 px-3 fs-6">Modul Verifikasi TAPD</div>
                            <li class="nav-item">
                                <a class="nav-link text-secondary" href="#">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-check2-square text-warning"></i></span>
                                    <span class="nav-link-title">Verifikasi Pergeseran</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-secondary" href="#">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-journal-bookmark text-success"></i></span>
                                    <span class="nav-link-title">Kamus SBU & ASB</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <!-- PEJABAT KEUANGAN (PPKD) MENU -->
                        <?php if (in_array($roleCode, ['superadmin', 'pejabat_keuangan'])): ?>
                            <div class="hr-text hr-text-left text-secondary text-uppercase fw-bold mt-3 mb-2 px-3 fs-6">Modul Otorisasi PPKD</div>
                            <li class="nav-item">
                                <a class="nav-link text-secondary" href="#">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-shield-check text-success"></i></span>
                                    <span class="nav-link-title">Pengesahan Pergeseran</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-secondary" href="#">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-cash-stack text-info"></i></span>
                                    <span class="nav-link-title">Realisasi SP2D</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <!-- PIMPINAN EKSEKUTIF MENU -->
                        <?php if (in_array($roleCode, ['superadmin', 'pimpinan'])): ?>
                            <div class="hr-text hr-text-left text-secondary text-uppercase fw-bold mt-3 mb-2 px-3 fs-6">Eksekutif Monitoring</div>
                            <li class="nav-item">
                                <a class="nav-link text-secondary" href="#">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-graph-up-arrow text-purple"></i></span>
                                    <span class="nav-link-title">Executive Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-secondary" href="#">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="bi bi-file-earmark-pdf text-danger"></i></span>
                                    <span class="nav-link-title">Laporan Pagu & Realisasi</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </aside>

        <!-- Top Header Navigation Bar -->
        <header class="navbar navbar-expand-md navbar-light d-none d-lg-flex sticky-top bg-white border-bottom shadow-sm">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <span class="text-secondary me-2"><i class="bi bi-building"></i> SKPD:</span>
                    <strong class="text-dark me-3"><?= esc(session()->get('nama_skpd') ?? 'Pemerintah Daerah') ?></strong>
                </div>

                <div class="navbar-nav flex-row order-md-last align-items-center gap-3">
                    <!-- User Profile Dropdown -->
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown">
                            <span class="avatar avatar-sm rounded-circle bg-primary-subtle text-primary fw-bold">
                                <?= strtoupper(substr(session()->get('nama_lengkap') ?? 'U', 0, 2)) ?>
                            </span>
                            <div class="d-none d-xl-block ps-2 text-start">
                                <div class="fw-semibold text-dark fs-5"><?= esc(session()->get('nama_lengkap')) ?></div>
                                <div class="mt-1 small text-secondary">
                                    <span class="badge badge-role-<?= esc(session()->get('role_code')) ?> px-2 py-1">
                                        <?= esc(session()->get('role_name')) ?>
                                    </span>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow shadow">
                            <div class="dropdown-header">
                                <strong class="d-block text-dark"><?= esc(session()->get('username')) ?></strong>
                                <small class="text-muted"><?= esc(session()->get('jabatan') ?? 'User SIAP-PAGU') ?></small>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a href="<?= base_url('/logout') ?>" class="dropdown-item text-danger fw-semibold">
                                <i class="bi bi-box-arrow-right me-2"></i> Keluar (Logout)
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
                            <span class="text-muted fs-6">&copy; 2026 SIAP-PAGU &bull; Sistem Informasi Akuntabilitas Perencanaan & Pagu Anggaran</span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Tabler JS & Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
