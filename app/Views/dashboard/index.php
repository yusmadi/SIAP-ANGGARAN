<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Welcome Banner Card -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: #fff;">
            <div class="card-body p-4 p-md-5">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
                            <span class="badge badge-role-<?= esc($user['role_code']) ?> px-3 py-2 fs-6 rounded-pill shadow-sm">
                                <i class="bi bi-shield-check me-1"></i> Role: <?= esc($user['role_name']) ?>
                            </span>
                            <span class="badge badge-skpk-header px-3 py-2 fs-6 rounded-pill shadow-sm">
                                <i class="bi bi-building me-1 text-info"></i> SKPK: <?= esc($user['nama_skpd'] ?? 'Pemerintah Daerah') ?>
                            </span>
                        </div>
                        <h2 class="fw-bold mb-1 text-white">Selamat Datang, <?= esc($user['name']) ?>!</h2>
                        <p class="text-secondary mb-3 fs-5">
                            <?= esc($user['jabatan'] ?? 'Pengguna Sistem') ?> <?= $user['nip'] ? '&bull; NIP. ' . esc($user['nip']) : '' ?>
                        </p>
                        <p class="text-white-50 mb-0 small">
                            Anda masuk ke dalam portal <strong>SIAP-ANGGARAN</strong> dengan hak akses terotentikasi berdasarkan matriks wewenang <em>Least Privilege</em>.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                        <div class="bg-white bg-opacity-10 p-3 rounded-3 d-inline-block border border-white border-opacity-10 text-start">
                            <div class="text-secondary small">Tahun Anggaran Aktif</div>
                            <div class="fw-bold fs-2 text-warning mb-1"><?= esc($active_year['tahun']) ?></div>
                            <span class="badge bg-warning text-dark px-2 py-1 text-uppercase">Tahap: <?= esc($active_year['status_tahapan']) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Key Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-1 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold">PAGU APBK MURNI</div>
                    <div class="fw-bold fs-3 mt-1">Rp <?= number_format($stats['total_pagu_murni'], 0, ',', '.') ?></div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-cash-coin fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-2 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold">PAGU PERGESERAN</div>
                    <div class="fw-bold fs-3 mt-1">Rp <?= number_format($stats['total_pergeseran'], 0, ',', '.') ?></div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-arrow-left-right fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-3 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold">TOTAL SKPK / OPD</div>
                    <div class="fw-bold fs-2 mt-1"><?= esc($stats['total_skpd']) ?> SKPK</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-buildings fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-4 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold">TOTAL PENGGUNA</div>
                    <div class="fw-bold fs-2 mt-1"><?= esc($stats['total_users']) ?> User</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-people fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Role Specific Action Module Grid -->
<div class="row g-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-grid-fill me-2 text-primary"></i> Modul Utama Berdasarkan Hak Akses Role</h5>
                <span class="badge badge-role-<?= esc($user['role_code']) ?> px-3 py-1.5 fs-6 shadow-sm">Role: <?= esc($user['role_name']) ?></span>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <?php if (in_array($user['role_code'], ['superadmin', 'admin_bpkd'])): ?>
                        <div class="col-md-4">
                            <div class="p-3 border rounded-3 bg-light h-100">
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <i class="bi bi-people-fill text-danger fs-2"></i>
                                    <div>
                                        <h6 class="fw-bold mb-0 text-dark">Manajemen User & RBAC</h6>
                                        <small class="text-muted">Kelola akun, role, & status pengguna</small>
                                    </div>
                                </div>
                                <a href="<?= base_url('/users') ?>" class="btn btn-sm btn-outline-danger w-100 mt-2">Buka Modul Users</a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (in_array($user['role_code'], ['superadmin', 'admin_bpkd', 'perencana_opd'])): ?>
                        <div class="col-md-4">
                            <div class="p-3 border rounded-3 bg-light h-100">
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <i class="bi bi-person-badge text-primary fs-2"></i>
                                    <div>
                                        <h6 class="fw-bold mb-0 text-dark">Kebutuhan Belanja ASN</h6>
                                        <small class="text-muted">Proyeksi gaji & TPP bulanan SKPK</small>
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-outline-primary w-100 mt-2" disabled>Akses Perencana OPD (Tahap 2)</button>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (in_array($user['role_code'], ['superadmin', 'admin_bpkd', 'verifikator_bpkd', 'operator_bpkd'])): ?>
                        <div class="col-md-4">
                            <div class="p-3 border rounded-3 bg-light h-100">
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <i class="bi bi-check2-square text-warning fs-2"></i>
                                    <div>
                                        <h6 class="fw-bold mb-0 text-dark">Verifikasi & Entri BPKD</h6>
                                        <small class="text-muted">Verifikasi usulan & entri pergeseran pagu</small>
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-outline-warning w-100 mt-2" disabled>Akses Operasional BPKD</button>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (in_array($user['role_code'], ['superadmin', 'admin_bpkd', 'kepala_bpkd'])): ?>
                        <div class="col-md-4">
                            <div class="p-3 border rounded-3 bg-light h-100">
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <i class="bi bi-shield-check text-success fs-2"></i>
                                    <div>
                                        <h6 class="fw-bold mb-0 text-dark">Otorisasi Kepala BPKD/PPKD</h6>
                                        <small class="text-muted">Pengesahan DPA & dokumen pergeseran</small>
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-outline-success w-100 mt-2" disabled>Akses Kepala BPKD (Tahap 3 & 4)</button>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (in_array($user['role_code'], ['superadmin', 'pimpinan_eksekutif', 'kepala_bpkd'])): ?>
                        <div class="col-md-4">
                            <div class="p-3 border rounded-3 bg-light h-100">
                                <div class="d-flex align-items-center gap-3 mb-2">
                                    <i class="bi bi-graph-up-arrow text-purple fs-2"></i>
                                    <div>
                                        <h6 class="fw-bold mb-0 text-dark">Eksekutif Monitoring</h6>
                                        <small class="text-muted">Ringkasan serapan pagu real-time</small>
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-outline-secondary w-100 mt-2" disabled>Akses Eksekutif (Tahap 5)</button>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
