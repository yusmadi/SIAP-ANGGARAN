<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Welcome Banner Card Perencana OPD -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%); color: #fff;">
            <div class="card-body p-4 p-md-5">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
                            <span class="badge badge-role-<?= esc($user['role_code']) ?> px-3 py-2 fs-6 rounded-pill shadow-sm">
                                <i class="bi bi-person-badge-fill me-1"></i> Role: <?= esc($user['role_name']) ?>
                            </span>
                            <span class="badge badge-skpk-header px-3 py-2 fs-6 rounded-pill shadow-sm">
                                <i class="bi bi-building me-1 text-info"></i> SKPK: <?= esc($user['nama_skpd']) ?>
                            </span>
                        </div>
                        <h2 class="fw-bold mb-1 text-white">Portal Perencana & Program OPD</h2>
                        <p class="text-blue-100 mb-3 fs-5">
                            <?= esc($user['name']) ?> &bull; <?= esc($user['jabatan']) ?>
                        </p>
                        <p class="text-white-50 mb-0 small">
                            Modul Penyusunan RKA, Proyeksi Belanja Pegawai (Gaji & TPP), serta Pengajuan Usulan Pergeseran Pagu SKPK
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                        <button class="btn btn-warning text-dark fw-bold btn-lg shadow-sm rounded-3" onclick="alert('Modul Usulan Pergeseran Pagu OPD akan aktif pada Tahap 2');">
                            <i class="bi bi-plus-circle-fill me-2"></i> Usulkan Pergeseran Pagu
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stat Cards Perencana OPD -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-1 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Pagu Murni SKPK</div>
                    <div class="fw-bold fs-4 mt-1">Rp <?= number_format($my_skpd['pagu_total_murni'] ?? 0, 0, ',', '.') ?></div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-piggy-bank fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-2 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Pagu Hasil Pergeseran</div>
                    <div class="fw-bold fs-4 mt-1">Rp <?= number_format($my_skpd['pagu_total_pergeseran'] ?? 0, 0, ',', '.') ?></div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-graph-up fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-3 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Usulan Pergeseran OPD</div>
                    <div class="fw-bold fs-2 mt-1"><?= count($usulan_history ?? []) ?> Usulan</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-file-earmark-diff fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-4 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Belanja Pegawai (Gaji/TPP)</div>
                    <div class="fw-bold fs-3 mt-1">100% Proyeksi</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-people-fill fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- History Usulan Pergeseran OPD -->
<div class="row g-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-clock-history text-primary me-2"></i> Riwayat & Status Usulan Pergeseran Pagu SKPK
                </h5>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1">Internal OPD</span>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>No. Usulan</th>
                                <th>Perihal Usulan</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Nilai Usulan Pergeseran</th>
                                <th>Status Progress</th>
                                <th class="text-end">Rincian</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usulan_history as $uh): ?>
                                <tr>
                                    <td><code><?= esc($uh['no_usulan']) ?></code></td>
                                    <td class="fw-semibold text-dark"><?= esc($uh['perihal']) ?></td>
                                    <td><small class="text-muted"><?= esc($uh['tanggal']) ?></small></td>
                                    <td class="fw-bold text-primary">Rp <?= number_format($uh['nominal'], 0, ',', '.') ?></td>
                                    <td>
                                        <?php if (str_contains($uh['status'], 'Disetujui')): ?>
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1">
                                                <i class="bi bi-check-circle-fill me-1"></i> <?= esc($uh['status']) ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1">
                                                <i class="bi bi-hourglass-split me-1"></i> <?= esc($uh['status']) ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-outline-primary" onclick="alert('Rincian Usulan Pergeseran OPD akan aktif pada Tahap 2');">
                                            <i class="bi bi-eye me-1"></i> Lihat Detail
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
