<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Welcome Banner Card Pimpinan Eksekutif -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: linear-gradient(135deg, #4c1d95 0%, #6d28d9 100%); color: #fff;">
            <div class="card-body p-4 p-md-5">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
                            <span class="badge badge-role-<?= esc($user['role_code']) ?> px-3 py-2 fs-6 rounded-pill shadow-sm">
                                <i class="bi bi-graph-up-arrow me-1"></i> Role: <?= esc($user['role_name'] ?? 'Pimpinan Eksekutif') ?>
                            </span>
                            <span class="badge badge-skpk-header px-3 py-2 fs-6 rounded-pill shadow-sm">
                                <i class="bi bi-building me-1 text-info"></i> SKPK: <?= esc($user['nama_skpd'] ?? 'Pemerintah Daerah') ?>
                            </span>
                        </div>
                        <h2 class="fw-bold mb-1 text-white">Portal Pimpinan & Eksekutif Daerah</h2>
                        <p class="text-purple-100 mb-3 fs-5">
                            Yth. <?= esc($user['name']) ?> &bull; <?= esc($user['jabatan']) ?>
                        </p>
                        <p class="text-white-50 mb-0 small">
                            Ringkasan Real-time Analisis Integritas Perencanaan, Pagu APBK Pergeseran, & Kinerja Serapan Anggaran Daerah
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                        <div class="bg-white bg-opacity-10 p-3 rounded-3 d-inline-block border border-white border-opacity-20 text-start">
                            <div class="text-white-50 small">Persentase Serapan APBK Total</div>
                            <div class="fw-bold fs-1 text-warning mb-0"><?= esc($serapan_persen ?? 68.4) ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Executive Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-1 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Total APBK Murni</div>
                    <div class="fw-bold fs-4 mt-1">Rp <?= number_format($stats['total_pagu_murni'], 0, ',', '.') ?></div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-bank fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-2 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">APBK Hasil Pergeseran</div>
                    <div class="fw-bold fs-4 mt-1">Rp <?= number_format($stats['total_pergeseran'], 0, ',', '.') ?></div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-arrow-repeat fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-3 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Total Realisasi Belanja</div>
                    <div class="fw-bold fs-4 mt-1">Rp <?= number_format($total_realisasi ?? 457800000000, 0, ',', '.') ?></div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-currency-dollar fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-4 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Tingkat Serapan Anggaran</div>
                    <div class="fw-bold fs-2 mt-1"><?= esc($serapan_persen ?? 68.4) ?>%</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-pie-chart-fill fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ranking Table Serapan SKPK -->
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-bar-chart-line-fill text-purple me-2" style="color: #8b5cf6;"></i> Matriks Kinerja Serapan Anggaran SKPK
                </h5>
                <span class="badge bg-purple text-white px-3 py-1" style="background-color: #8b5cf6;">Eksekutif View</span>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Nama SKPK / OPD</th>
                                <th>Pagu Total</th>
                                <th>Realisasi (SP2D)</th>
                                <th>Persentase Serapan</th>
                                <th>Progress Bar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($top_skpd as $sk): ?>
                                <tr>
                                    <td class="fw-semibold text-dark"><?= esc($sk['nama_skpd']) ?></td>
                                    <td>Rp <?= number_format($sk['pagu'], 0, ',', '.') ?></td>
                                    <td class="fw-bold text-success">Rp <?= number_format($sk['realisasi'], 0, ',', '.') ?></td>
                                    <td class="fw-bold text-purple" style="color: #8b5cf6;"><?= esc($sk['persen']) ?>%</td>
                                    <td style="width: 25%;">
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-purple" role="progressbar" style="width: <?= esc($sk['persen']) ?>%; background-color: #8b5cf6;" aria-valuenow="<?= esc($sk['persen']) ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Executive Summary Card -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i> Laporan Ringkasan Eksekutif
                </h5>
            </div>
            <div class="card-body p-4">
                <p class="text-secondary small mb-4">
                    Ringkasan analitik eksekutif untuk mendukung pengambilan keputusan kebijakan pergeseran APBK oleh Pimpinan Daerah.
                </p>

                <div class="d-grid gap-3">
                    <button class="btn btn-outline-purple text-start p-3 rounded-3" style="border-color: #8b5cf6; color: #6d28d9;" onclick="alert('Laporan Eksekutif Serapan APBK akan aktif pada Tahap 5');">
                        <div class="fw-bold"><i class="bi bi-download me-2"></i> Laporan Serapan Anggaran Per SKPK</div>
                        <small class="text-muted">Format PDF &bull; Kompilasi Realisasi SP2D</small>
                    </button>

                    <button class="btn btn-outline-primary text-start p-3 rounded-3" onclick="alert('Laporan Evaluasi Pergeseran APBK akan aktif pada Tahap 5');">
                        <div class="fw-bold"><i class="bi bi-file-earmark-bar-chart me-2"></i> Laporan Evaluasi Pergeseran Pagu</div>
                        <small class="text-muted">Analisis Perbandingan Pagu Murni vs Pergeseran</small>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
