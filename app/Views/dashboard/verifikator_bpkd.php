<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Welcome Banner Card Verifikator BPKD -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: linear-gradient(135deg, #b45309 0%, #d97706 100%); color: #fff;">
            <div class="card-body p-4 p-md-5">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
                            <span class="badge badge-role-<?= esc($user['role_code']) ?> px-3 py-2 fs-6 rounded-pill shadow-sm">
                                <i class="bi bi-search me-1"></i> Role: <?= esc($user['role_name'] ?? 'Verifikator BPKD') ?>
                            </span>
                            <span class="badge badge-skpk-header px-3 py-2 fs-6 rounded-pill shadow-sm">
                                <i class="bi bi-building me-1 text-info"></i> SKPK: <?= esc($user['nama_skpd'] ?? 'BPKD (Tim Verifikasi)') ?>
                            </span>
                        </div>
                        <h2 class="fw-bold mb-1 text-white">Portal Verifikator BPKD</h2>
                        <p class="text-amber-100 mb-3 fs-5">
                            Petugas Verifikasi: <?= esc($user['name']) ?> &bull; <?= esc($user['jabatan']) ?>
                        </p>
                        <p class="text-white-50 mb-0 small">
                            Memeriksa Kelayakan Regulasi, Parameter Kamus SBU/ASB, serta Kebenaran Usulan Pergeseran Pagu SKPK
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                        <div class="bg-white bg-opacity-10 p-3 rounded-3 d-inline-block border border-white border-opacity-20 text-start">
                            <div class="text-white-50 small">Antrean Usulan Masuk</div>
                            <div class="fw-bold fs-1 text-white mb-0"><?= count($verification_queue ?? []) ?> Usulan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stat Cards Verifikator BPKD -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-1 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Antrean Verifikasi</div>
                    <div class="fw-bold fs-2 mt-1"><?= count($verification_queue ?? []) ?> Usulan</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-hourglass-split fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-2 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Pergeseran Disetujui</div>
                    <div class="fw-bold fs-2 mt-1">12 Berkas</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-check2-all fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-3 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Perlu Revisi OPD</div>
                    <div class="fw-bold fs-2 mt-1">1 Berkas</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-exclamation-circle-fill fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-4 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Ceiling SBU Checked</div>
                    <div class="fw-bold fs-3 mt-1">100% Valid</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-shield-check fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Table Antrean Verifikasi -->
<div class="row g-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-check2-square text-warning me-2"></i> Antrean Penelaahan & Verifikasi Usulan Pergeseran Pagu
                </h5>
                <span class="badge bg-light text-secondary border">Filter: Menunggu Telaah</span>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>No. Usulan</th>
                                <th>SKPK / OPD Pengusul</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Nominal Pergeseran</th>
                                <th>Kesesuaian SBU</th>
                                <th>Status Telaah</th>
                                <th class="text-end">Aksi Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($verification_queue as $v): ?>
                                <tr>
                                    <td><code><?= esc($v['no_usulan']) ?></code></td>
                                    <td class="fw-semibold text-dark"><?= esc($v['skpd']) ?></td>
                                    <td><small class="text-muted"><?= esc($v['tanggal']) ?></small></td>
                                    <td class="fw-bold text-dark">Rp <?= number_format($v['nominal'], 0, ',', '.') ?></td>
                                    <td>
                                        <?php if (str_contains($v['sbu_status'], 'Sesuai')): ?>
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1">
                                                <i class="bi bi-check-circle me-1"></i> <?= esc($v['sbu_status']) ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1">
                                                <i class="bi bi-exclamation-triangle me-1"></i> <?= esc($v['sbu_status']) ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary px-2.5 py-1">
                                            <?= esc($v['status']) ?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-outline-warning fw-semibold" onclick="alert('Modul Verifikasi Berkas akan aktif pada Tahap 3');">
                                            <i class="bi bi-search me-1"></i> Telaah Berkas
                                        </button>
                                    </td>
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
