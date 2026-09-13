<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Welcome Banner Card Kepala BPKD / PPKD -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: linear-gradient(135deg, #065f46 0%, #047857 100%); color: #fff;">
            <div class="card-body p-4 p-md-5">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-success px-3 py-1.5 fs-6 rounded-pill fw-bold">
                                <i class="bi bi-award-fill me-1"></i> Otorisator Pengesahan PPKD
                            </span>
                            <span class="badge bg-white bg-opacity-20 text-white px-3 py-1.5 fs-6 rounded-pill">
                                Pejabat Pengelola Keuangan Daerah
                            </span>
                        </div>
                        <h2 class="fw-bold mb-1 text-white">Portal Kepala BPKD / PPKD</h2>
                        <p class="text-emerald-100 mb-3 fs-5">
                            Yth. <?= esc($user['name']) ?> &bull; NIP. <?= esc($user['nip'] ?? '-') ?>
                        </p>
                        <p class="text-white-50 mb-0 small">
                            Wewenang Pengesahan Dokumen Pergeseran Pagu APBK & Otorisasi Pencairan Realisasi SP2D
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                        <div class="bg-white bg-opacity-10 p-3 rounded-3 d-inline-block border border-white border-opacity-20 text-start">
                            <div class="text-white-50 small">Usulan Pergeseran Menunggu</div>
                            <div class="fw-bold fs-1 text-warning mb-0"><?= count($pending_approvals ?? []) ?> Usulan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stat Cards Kepala BPKD / PPKD -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-1 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Pagu APBK Murni Total</div>
                    <div class="fw-bold fs-4 mt-1">Rp <?= number_format($stats['total_pagu_murni'], 0, ',', '.') ?></div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-wallet-fill fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-2 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Pagu Hasil Pergeseran</div>
                    <div class="fw-bold fs-4 mt-1">Rp <?= number_format($stats['total_pergeseran'], 0, ',', '.') ?></div>
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
                    <div class="text-white-50 small fw-semibold text-uppercase">Menunggu Otorisasi</div>
                    <div class="fw-bold fs-2 mt-1"><?= count($pending_approvals ?? []) ?> Berkas</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-pen-fill fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-4 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Realisasi SP2D Terbit</div>
                    <div class="fw-bold fs-4 mt-1">Rp <?= number_format($total_sp2d_terbit ?? 84500000000, 0, ',', '.') ?></div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-check-circle-fill fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pending Approvals Table for Kepala BPKD -->
<div class="row g-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-shield-check text-success me-2"></i> Antrean Usulan Pergeseran Pagu Menunggu Otorisasi Kepala BPKD
                </h5>
                <span class="badge bg-warning text-dark px-3 py-1 fs-6">Tahap: Pengesahan PPKD</span>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>No. Usulan</th>
                                <th>SKPK / OPD Pengusul</th>
                                <th>Tanggal Usul</th>
                                <th>Maksud & Tujuan Pergeseran</th>
                                <th>Nominal Pergeseran</th>
                                <th class="text-end">Aksi Otorisasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pending_approvals as $item): ?>
                                <tr>
                                    <td><code><?= esc($item['no_usulan']) ?></code></td>
                                    <td class="fw-semibold text-dark"><?= esc($item['skpd']) ?></td>
                                    <td><small class="text-muted"><?= esc($item['tanggal']) ?></small></td>
                                    <td><?= esc($item['tujuan']) ?></td>
                                    <td class="fw-bold text-success">Rp <?= number_format($item['nominal'], 0, ',', '.') ?></td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-success fw-semibold" onclick="alert('Modul Pengesahan Dokumen Pergeseran akan aktif pada Tahap 4');">
                                            <i class="bi bi-check-lg me-1"></i> Sahkan & Tanda Tangan
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
