<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Welcome Banner Card Admin -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: linear-gradient(135deg, #0e7490 0%, #155e75 100%); color: #fff;">
            <div class="card-body p-4 p-md-5">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
                            <span class="badge badge-role-<?= esc($user['role_code']) ?> px-3 py-2 fs-6 rounded-pill shadow-sm">
                                <i class="bi bi-gear-wide-connected me-1"></i> Role: <?= esc($user['role_name']) ?>
                            </span>
                            <span class="badge badge-skpk-header px-3 py-2 fs-6 rounded-pill shadow-sm">
                                <i class="bi bi-building me-1 text-info"></i> SKPK: <?= esc($user['nama_skpd'] ?? 'BPKD (Admin Teknis)') ?>
                            </span>
                        </div>
                        <h2 class="fw-bold mb-1 text-white">Selamat Datang, Admin <?= esc($user['name']) ?></h2>
                        <p class="text-cyan-100 mb-3 fs-5">
                            Pusat Pengelolaan Master SKPK, Kamus Standar Biaya Umum (SBU/ASB) & User OPD
                        </p>
                        <p class="text-white-50 mb-0 small">
                            Tahun Anggaran: <strong><?= esc($active_year['tahun']) ?></strong> &bull; Tahapan Aktif: <span class="badge bg-warning text-dark text-uppercase"><?= esc($active_year['status_tahapan']) ?></span>
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                        <div class="d-flex flex-column gap-2">
                            <a href="<?= base_url('/users') ?>" class="btn btn-light shadow-sm rounded-3 fw-semibold">
                                <i class="bi bi-people me-2"></i> Pengelolaan User OPD
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stat Cards Admin -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-1 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Total SKPK Terdaftar</div>
                    <div class="fw-bold fs-2 mt-1"><?= count($skpd_list ?? []) ?> Unit</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-building fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-2 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Kamus SBU Aktif</div>
                    <div class="fw-bold fs-2 mt-1"><?= esc($total_sbu ?? 1420) ?> Item</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-journal-bookmark fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-3 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Kamus ASB Standar</div>
                    <div class="fw-bold fs-2 mt-1"><?= esc($total_asb ?? 380) ?> Standar</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-file-earmark-ruled fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-4 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Total Pagu APBK</div>
                    <div class="fw-bold fs-4 mt-1">Rp <?= number_format($stats['total_pagu_murni'], 0, ',', '.') ?></div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-cash-stack fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Table Overview SKPK -->
<div class="row g-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-diagram-3-fill text-info me-2"></i> Master Data SKPK & Pagu Terkunci
                </h5>
                <span class="badge bg-light text-secondary border">TA 2026</span>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Kode SKPK</th>
                                <th>Nama SKPK / OPD</th>
                                <th>Kepala SKPK</th>
                                <th>Pagu APBK Murni</th>
                                <th>Pagu Pergeseran</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($skpd_list as $idx => $s): ?>
                                <tr>
                                    <td class="fw-bold"><?= $idx + 1 ?></td>
                                    <td><code><?= esc($s['kode_skpd']) ?></code></td>
                                    <td class="fw-semibold text-dark"><?= esc($s['nama_skpd']) ?></td>
                                    <td>
                                        <div class="small fw-semibold"><?= esc($s['nama_kepala']) ?></div>
                                        <small class="text-muted">NIP. <?= esc($s['nip_kepala']) ?></small>
                                    </td>
                                    <td class="fw-bold text-success">Rp <?= number_format($s['pagu_total_murni'], 0, ',', '.') ?></td>
                                    <td class="fw-bold text-primary">Rp <?= number_format($s['pagu_total_pergeseran'], 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
