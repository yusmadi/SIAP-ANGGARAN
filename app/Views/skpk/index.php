<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Header Banner Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: #fff;">
            <div class="card-body p-4 p-md-5">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-white bg-opacity-20 text-white px-3 py-1.5 fs-6 rounded-pill">
                                <i class="bi bi-building me-1"></i> Master Data Integrasi
                            </span>
                            <span class="badge bg-warning text-dark px-3 py-1.5 fs-6 rounded-pill fw-bold">
                                Modul SKPK
                            </span>
                        </div>
                        <h2 class="fw-bold mb-1 text-white">Manajemen Master Data SKPK</h2>
                        <p class="text-sky-100 mb-0 fs-5">
                            Kelola data Satuan Kerja Perangkat Kabupaten/Kota (SKPK), NIP Kepala SKPK, serta alokasi Pagu APBK Murni & Pergeseran.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                        <?php if (in_array(session()->get('role_code'), ['superadmin', 'admin_bpkd'])): ?>
                            <button type="button" class="btn btn-light shadow-sm rounded-3 fw-bold px-4 py-2.5" data-bs-toggle="modal" data-bs-target="#addSkpkModal">
                                <i class="bi bi-plus-circle-fill me-2 text-primary"></i> Tambah SKPK Baru
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stat Cards Overview -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-4">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-1 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Total SKPK Terdaftar</div>
                    <div class="fw-bold fs-2 mt-1"><?= esc($stats['total_count']) ?> Unit</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-building fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-4">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-2 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Total Pagu Murni (Seluruh SKPK)</div>
                    <div class="fw-bold fs-4 mt-1">Rp <?= number_format($stats['total_murni'], 0, ',', '.') ?></div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-cash-stack fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-4">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-3 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Total Pagu Pergeseran</div>
                    <div class="fw-bold fs-4 mt-1">Rp <?= number_format($stats['total_pergeseran'], 0, ',', '.') ?></div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-arrow-left-right fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter & Table Card -->
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <h5 class="fw-bold mb-0 text-dark">
            <i class="bi bi-list-task text-primary me-2"></i> Daftar Satuan Kerja (SKPK / OPD)
        </h5>
        
        <!-- Form Search Filter -->
        <form action="<?= base_url('/skpk') ?>" method="get" class="d-flex gap-2" style="max-width: 380px; width: 100%;">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-secondary"></i></span>
                <input type="text" name="q" class="form-control form-control-sm border-start-0 ps-0" placeholder="Cari kode, nama SKPK, atau kepala..." value="<?= esc($keyword ?? '') ?>">
                <?php if (!empty($keyword)): ?>
                    <a href="<?= base_url('/skpk') ?>" class="btn btn-outline-secondary btn-sm" title="Reset Pencarian"><i class="bi bi-x-lg"></i></a>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary btn-sm px-3">Cari</button>
            </div>
        </form>
    </div>

    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Kode SKPK</th>
                        <th>Nama SKPK / OPD</th>
                        <th>Kepala SKPK & NIP</th>
                        <th>Pagu APBK Murni</th>
                        <th>Pagu Pergeseran</th>
                        <th class="text-center" style="width: 140px;">Aksi / Pilihan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($skpds)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                Tidak ada data SKPK yang ditemukan.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($skpds as $idx => $s): ?>
                            <tr class="<?= ($active_skpd_id == $s['id']) ? 'table-primary border-primary' : '' ?>">
                                <td class="fw-bold text-secondary"><?= $idx + 1 ?></td>
                                <td>
                                    <span class="badge bg-light text-dark font-monospace border px-2 py-1 fs-6">
                                        <?= esc($s['kode_skpd']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark fs-5"><?= esc($s['nama_skpd']) ?></div>
                                    <?php if ($active_skpd_id == $s['id']): ?>
                                        <span class="badge bg-success-subtle text-success border border-success border-opacity-25 px-2 py-0.5 rounded-pill small">
                                            <i class="bi bi-check-circle-fill me-1"></i> SKPK Aktif Terpilih
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark"><?= esc($s['nama_kepala']) ?></div>
                                    <small class="text-muted"><i class="bi bi-person-vcard me-1"></i>NIP. <?= esc($s['nip_kepala']) ?></small>
                                </td>
                                <td>
                                    <div class="fw-bold text-success">Rp <?= number_format($s['pagu_total_murni'], 0, ',', '.') ?></div>
                                </td>
                                <td>
                                    <div class="fw-bold text-primary">Rp <?= number_format($s['pagu_total_pergeseran'], 0, ',', '.') ?></div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <!-- Form Pilih / Switch Active Context SKPK -->
                                        <form action="<?= base_url('/skpk/switch') ?>" method="post" class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="skpd_id" value="<?= $s['id'] ?>">
                                            <button type="submit" class="btn btn-sm <?= ($active_skpd_id == $s['id']) ? 'btn-success' : 'btn-outline-primary' ?>" title="Pilih / Aktifkan SKPK ini">
                                                <i class="bi bi-check-square-fill me-1"></i> <?= ($active_skpd_id == $s['id']) ? 'Aktif' : 'Pilih' ?>
                                            </button>
                                        </form>

                                        <?php if (in_array(session()->get('role_code'), ['superadmin', 'admin_bpkd'])): ?>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editSkpkModal<?= $s['id'] ?>"
                                                    title="Edit Data SKPK">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <a href="<?= base_url('/skpk/delete/' . $s['id']) ?>" 
                                               class="btn btn-sm btn-outline-danger" 
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus data SKPK \'<?= esc($s['nama_skpd'], 'js') ?>\'?');"
                                               title="Hapus SKPK">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Modal Edit SKPK -->
                                    <?php if (in_array(session()->get('role_code'), ['superadmin', 'admin_bpkd'])): ?>
                                        <div class="modal fade" id="editSkpkModal<?= $s['id'] ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow rounded-4">
                                                    <form action="<?= base_url('/skpk/update/' . $s['id']) ?>" method="post">
                                                        <?= csrf_field() ?>
                                                        <div class="modal-header bg-primary text-white rounded-top-4">
                                                            <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i> Edit Data SKPK</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-4 text-start">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Kode SKPK</label>
                                                                <input type="text" name="kode_skpd" class="form-control" value="<?= esc($s['kode_skpd']) ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Nama SKPK / OPD</label>
                                                                <input type="text" name="nama_skpd" class="form-control" value="<?= esc($s['nama_skpd']) ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Nama Kepala SKPK</label>
                                                                <input type="text" name="nama_kepala" class="form-control" value="<?= esc($s['nama_kepala']) ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">NIP Kepala SKPK</label>
                                                                <input type="text" name="nip_kepala" class="form-control" value="<?= esc($s['nip_kepala']) ?>" required>
                                                            </div>
                                                            <div class="row g-2">
                                                                <div class="col-6">
                                                                    <label class="form-label fw-semibold">Pagu APBK Murni (Rp)</label>
                                                                    <input type="number" step="0.01" name="pagu_total_murni" class="form-control" value="<?= esc($s['pagu_total_murni']) ?>" required>
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="form-label fw-semibold">Pagu Pergeseran (Rp)</label>
                                                                    <input type="number" step="0.01" name="pagu_total_pergeseran" class="form-control" value="<?= esc($s['pagu_total_pergeseran']) ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer bg-light rounded-bottom-4">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary fw-semibold"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah SKPK Baru -->
<?php if (in_array(session()->get('role_code'), ['superadmin', 'admin_bpkd'])): ?>
    <div class="modal fade" id="addSkpkModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <form action="<?= base_url('/skpk/store') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-header bg-primary text-white rounded-top-4">
                        <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle-fill me-2"></i> Tambah Master SKPK Baru</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 text-start">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kode SKPK</label>
                            <input type="text" name="kode_skpd" class="form-control" placeholder="Contoh: 1.01.0.00.0.00.01.0000" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama SKPK / OPD</label>
                            <input type="text" name="nama_skpd" class="form-control" placeholder="Contoh: Dinas Komunikasi, Informatika dan Persandian" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Kepala SKPK</label>
                            <input type="text" name="nama_kepala" class="form-control" placeholder="Contoh: Dr. H. Iskandar, M.Si" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">NIP Kepala SKPK</label>
                            <input type="text" name="nip_kepala" class="form-control" placeholder="Contoh: 19760512 200112 1 003" required>
                        </div>
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="form-label fw-semibold">Pagu APBK Murni (Rp)</label>
                                <input type="number" step="0.01" name="pagu_total_murni" class="form-control" value="0" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold">Pagu Pergeseran (Rp)</label>
                                <input type="number" step="0.01" name="pagu_total_pergeseran" class="form-control" value="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light rounded-bottom-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary fw-semibold"><i class="bi bi-check-lg me-1"></i> Simpan SKPK</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
