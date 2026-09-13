<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Welcome Banner Card Operator BPKD -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: #fff;">
            <div class="card-body p-4 p-md-5">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
                            <span class="badge badge-role-<?= esc($user['role_code']) ?> px-3 py-2 fs-6 rounded-pill shadow-sm">
                                <i class="bi bi-headset me-1"></i> Role: <?= esc($user['role_name']) ?>
                            </span>
                            <span class="badge badge-skpk-header px-3 py-2 fs-6 rounded-pill shadow-sm">
                                <i class="bi bi-building me-1 text-info"></i> SKPK: <?= esc($user['nama_skpd'] ?? 'BPKD (Tim Entri Operasional)') ?>
                            </span>
                        </div>
                        <h2 class="fw-bold mb-1 text-white">Selamat Datang, <?= esc($user['name']) ?>!</h2>
                        <p class="text-sky-100 mb-3 fs-5">
                            <?= esc($user['jabatan'] ?? 'Operator Pengolah Data') ?> &bull; NIP. <?= esc($user['nip'] ?? '-') ?>
                        </p>
                        <p class="text-white-50 mb-0 small">
                            Bertanggung jawab menginput usulan pergeseran pagu anggaran, memproses dokumen entri transaksi, dan mencatat data realisasi SP2D secara presisi.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                        <div class="bg-white bg-opacity-10 p-3 rounded-3 d-inline-block border border-white border-opacity-20 text-start">
                            <div class="text-white-50 small">Target Entri Hari Ini</div>
                            <div class="fw-bold fs-1 text-white mb-0"><?= $total_entri_hari_ini ?? 14 ?> Berkas</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stat Cards Operator BPKD -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-1 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Entri Hari Ini</div>
                    <div class="fw-bold fs-2 mt-1"><?= $total_entri_hari_ini ?? 14 ?> Berkas</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-pencil-square fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-3 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Pending Entri</div>
                    <div class="fw-bold fs-2 mt-1"><?= $total_pending_entri ?? 6 ?> Berkas</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-clock-history fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-2 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Ter-Verifikasi</div>
                    <div class="fw-bold fs-2 mt-1"><?= $total_berkas_diverifikasi ?? 42 ?> Berkas</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-check-circle fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-4 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Tahun Anggaran</div>
                    <div class="fw-bold fs-2 mt-1"><?= esc($active_year['tahun']) ?></div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-calendar-event fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Action Menu Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 h-100 p-3 text-center bg-white border-start border-primary border-4">
            <i class="bi bi-file-earmark-plus text-primary fs-1 mb-2"></i>
            <h6 class="fw-bold text-dark mb-1">Entri Pergeseran Baru</h6>
            <small class="text-muted d-block mb-3">Input data pergeseran pagu usulan SKPK</small>
            <button class="btn btn-sm btn-primary w-100 rounded-2" disabled><i class="bi bi-plus-circle me-1"></i> Mulai Entri Data</button>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 h-100 p-3 text-center bg-white border-start border-info border-4">
            <i class="bi bi-file-earmark-spreadsheet text-info fs-1 mb-2"></i>
            <h6 class="fw-bold text-dark mb-1">Pencatatan SP2D</h6>
            <small class="text-muted d-block mb-3">Input realisasi pengeluaran SP2D</small>
            <button class="btn btn-sm btn-outline-info w-100 rounded-2" disabled><i class="bi bi-journal-plus me-1"></i> Input SP2D</button>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 h-100 p-3 text-center bg-white border-start border-warning border-4">
            <i class="bi bi-journal-check text-warning fs-1 mb-2"></i>
            <h6 class="fw-bold text-dark mb-1">Cek Standar Biaya (SBU)</h6>
            <small class="text-muted d-block mb-3">Lihat batasan harga SBU & ASB</small>
            <button class="btn btn-sm btn-outline-warning w-100 rounded-2" disabled><i class="bi bi-search me-1"></i> Cari SBU/ASB</button>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-3 h-100 p-3 text-center bg-white border-start border-success border-4">
            <i class="bi bi-printer text-success fs-1 mb-2"></i>
            <h6 class="fw-bold text-dark mb-1">Cetak Log Operasional</h6>
            <small class="text-muted d-block mb-3">Export daftar entri transaksi harian</small>
            <button class="btn btn-sm btn-outline-success w-100 rounded-2" disabled><i class="bi bi-download me-1"></i> Export Rekap</button>
        </div>
    </div>
</div>

<!-- Task Queue Table Card -->
<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-bold text-dark mb-0"><i class="bi bi-list-task text-primary me-2"></i> Daftar Berkas Entri Operasional Terkini</h5>
            <small class="text-muted">Manajemen tugas entri data pergeseran pagu dan SP2D SKPK</small>
        </div>
        <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-semibold">
            <?= count($operator_tasks ?? []) ?> Berkas Aktif
        </span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No. Berkas</th>
                        <th>SKPK Pemohon</th>
                        <th>Uraian Kegiatan / Pergeseran</th>
                        <th>Nominal Pagu</th>
                        <th>Tgl Masuk</th>
                        <th>Status Entri</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($operator_tasks)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada tugas entri berkas.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($operator_tasks as $task): ?>
                            <tr>
                                <td class="ps-4">
                                    <strong class="text-dark"><code><?= esc($task['kode_berkas']) ?></code></strong>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark"><?= esc($task['skpd']) ?></div>
                                </td>
                                <td>
                                    <span class="text-secondary"><?= esc($task['kegiatan']) ?></span>
                                </td>
                                <td>
                                    <strong class="text-dark">Rp <?= number_format($task['nominal'], 0, ',', '.') ?></strong>
                                </td>
                                <td>
                                    <small class="text-muted"><?= esc($task['tgl_masuk']) ?></small>
                                </td>
                                <td>
                                    <?php if ($task['status'] === 'Selesai Entri'): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1 rounded-pill">
                                            <i class="bi bi-check-circle me-1"></i> Selesai Entri
                                        </span>
                                    <?php elseif ($task['status'] === 'Proses Validasi'): ?>
                                        <span class="badge bg-info-subtle text-info border border-info-subtle px-2.5 py-1 rounded-pill">
                                            <i class="bi bi-arrow-repeat me-1"></i> Proses Validasi
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2.5 py-1 rounded-pill">
                                            <i class="bi bi-pencil me-1"></i> Draft Entri
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-sm btn-outline-primary" disabled>
                                        <i class="bi bi-pencil-square me-1"></i> Edit Data
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Standar Operasional Entri Guidelines -->
<div class="card border-0 shadow-sm rounded-3 bg-light p-4">
    <div class="d-flex align-items-center gap-3 mb-3">
        <div class="bg-primary text-white rounded-circle p-2 fs-4">
            <i class="bi bi-info-circle-fill"></i>
        </div>
        <div>
            <h5 class="fw-bold text-dark mb-0">Petunjuk Operasional Operator BPKD</h5>
            <small class="text-muted">Prinsip dasar pengolahan & entri data keuangan dalam sistem</small>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-md-4">
            <div class="p-3 bg-white rounded-3 border">
                <strong class="d-block text-primary mb-1">1. Validasi Berkas Fisik/Digital</strong>
                <p class="small text-muted mb-0">Pastikan lembar usulan pergeseran telah ditandatangani oleh Kepala OPD sebelum diinput ke dalam sistem.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 bg-white rounded-3 border">
                <strong class="d-block text-primary mb-1">2. Kesesuaian SBU & ASB</strong>
                <p class="small text-muted mb-0">Periksa setiap rincian objek belanja agar tidak melebihi Standar Biaya Umum (SBU) yang berlaku pada TA 2026.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-3 bg-white rounded-3 border">
                <strong class="d-block text-primary mb-1">3. Pengiriman ke Verifikator</strong>
                <p class="small text-muted mb-0">Setelah data selesai di-entri, ubah status ke 'Proses Validasi' agar dapat ditelaah oleh Tim Verifikator BPKD.</p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
