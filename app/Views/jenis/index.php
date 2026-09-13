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
                                <i class="bi bi-tag me-1"></i> Standar Rekening (Kepmen 900.1-861/2026)
                            </span>
                            <span class="badge bg-warning text-dark px-3 py-1.5 fs-6 rounded-pill fw-bold">
                                Level 3: Jenis
                            </span>
                        </div>
                        <h2 class="fw-bold mb-1 text-white">Master Data Jenis Rekening</h2>
                        <p class="text-sky-100 mb-0 fs-5">
                            Kelola Jenis Rekening untuk Belanja Pegawai, Belanja Barang/Jasa, Belanja Modal, PAD, dll.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                        <?php if (in_array(session()->get('role_code'), ['superadmin', 'admin_bpkd'])): ?>
                            <button type="button" class="btn btn-light shadow-sm rounded-3 fw-bold px-4 py-2.5" data-bs-toggle="modal" data-bs-target="#addJenisModal">
                                <i class="bi bi-plus-circle-fill me-2 text-primary"></i> Tambah Jenis Baru
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
    <div class="col-sm-6 col-lg-6">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-1 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Total Jenis Rekening</div>
                    <div class="fw-bold fs-2 mt-1"><?= esc($stats['total_count']) ?> Jenis</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-tag fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-6">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-2 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Status Jenis Aktif</div>
                    <div class="fw-bold fs-2 mt-1"><?= esc($stats['active_count']) ?> Jenis</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-check-circle-fill fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter & Table Card -->
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <h5 class="fw-bold mb-0 text-dark">
            <i class="bi bi-list-task text-primary me-2"></i> Daftar Jenis Rekening
        </h5>
        
        <div class="d-flex flex-wrap gap-2 align-items-center" style="max-width: 600px; width: 100%;">
            <form action="<?= base_url('/jenis') ?>" method="get" class="d-flex gap-2 w-100">
                <select name="kelompok_id" class="form-select form-select-sm border-secondary-subtle" onchange="this.form.submit()">
                    <option value="">-- Semua Kelompok --</option>
                    <?php foreach ($kelompoks as $kl): ?>
                        <option value="<?= $kl['id'] ?>" <?= ($kelompok_id == $kl['id']) ? 'selected' : '' ?>>
                            [<?= esc($kl['kode_kelompok']) ?>] <?= esc($kl['nama_kelompok']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <div class="input-group input-group-sm">
                    <input type="text" name="q" class="form-control form-control-sm" placeholder="Cari kode/nama..." value="<?= esc($keyword ?? '') ?>">
                    <?php if (!empty($keyword) || !empty($kelompok_id)): ?>
                        <a href="<?= base_url('/jenis') ?>" class="btn btn-outline-secondary btn-sm" title="Reset Filter"><i class="bi bi-x-lg"></i></a>
                    <?php endif; ?>
                    <button type="submit" class="btn btn-primary btn-sm px-3">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th style="width: 140px;">Kode Jenis</th>
                        <th>Parent Kelompok</th>
                        <th>Nama Jenis Rekening</th>
                        <th>Deskripsi</th>
                        <th style="width: 110px;" class="text-center">Status</th>
                        <?php if (in_array(session()->get('role_code'), ['superadmin', 'admin_bpkd'])): ?>
                            <th class="text-center" style="width: 120px;">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($jeniss)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                Tidak ada data Jenis Rekening yang ditemukan.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($jeniss as $idx => $j): ?>
                            <tr>
                                <td class="fw-bold text-secondary"><?= $idx + 1 ?></td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle font-monospace px-2.5 py-1.5 fs-6 fw-bold">
                                        <?= esc($j['kode_jenis']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-dark border px-2.5 py-1">
                                        [<?= esc($j['kode_kelompok']) ?>] <?= esc($j['nama_kelompok']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark fs-5"><?= esc($j['nama_jenis']) ?></div>
                                </td>
                                <td>
                                    <span class="text-secondary small"><?= esc($j['deskripsi'] ?? '-') ?></span>
                                </td>
                                <td class="text-center">
                                    <?php if ($j['is_active']): ?>
                                        <span class="badge bg-success-subtle text-success border border-success border-opacity-25 px-2.5 py-1 rounded-pill">
                                            <i class="bi bi-check-circle-fill me-1"></i> Aktif
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary-subtle text-secondary border px-2.5 py-1 rounded-pill">
                                            Nonaktif
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <?php if (in_array(session()->get('role_code'), ['superadmin', 'admin_bpkd'])): ?>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <button type="button" class="btn btn-sm btn-outline-secondary" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editJenisModal<?= $j['id'] ?>"
                                                    title="Edit Jenis">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <a href="<?= base_url('/jenis/delete/' . $j['id']) ?>" 
                                               class="btn btn-sm btn-outline-danger" 
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus Jenis \'<?= esc($j['nama_jenis'], 'js') ?>\'?');"
                                               title="Hapus Jenis">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>

                                        <!-- Modal Edit Jenis -->
                                        <div class="modal fade" id="editJenisModal<?= $j['id'] ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow rounded-4">
                                                    <form action="<?= base_url('/jenis/update/' . $j['id']) ?>" method="post">
                                                        <?= csrf_field() ?>
                                                        <div class="modal-header bg-primary text-white rounded-top-4">
                                                            <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i> Edit Jenis Rekening</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-4 text-start">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Parent Kelompok</label>
                                                                <select name="kelompok_id" class="form-select" required>
                                                                    <?php foreach ($kelompoks as $kl): ?>
                                                                        <option value="<?= $kl['id'] ?>" <?= ($j['kelompok_id'] == $kl['id']) ? 'selected' : '' ?>>
                                                                            [<?= esc($kl['kode_kelompok']) ?>] <?= esc($kl['nama_kelompok']) ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Kode Jenis</label>
                                                                <input type="text" name="kode_jenis" class="form-control" value="<?= esc($j['kode_jenis']) ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Nama Jenis Rekening</label>
                                                                <input type="text" name="nama_jenis" class="form-control" value="<?= esc($j['nama_jenis']) ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Deskripsi</label>
                                                                <textarea name="deskripsi" class="form-control" rows="3"><?= esc($j['deskripsi']) ?></textarea>
                                                            </div>
                                                            <div class="form-check form-switch mb-2">
                                                                <input class="form-check-input" type="checkbox" name="is_active" id="isActiveSwitchJenisEdit<?= $j['id'] ?>" value="1" <?= $j['is_active'] ? 'checked' : '' ?>>
                                                                <label class="form-check-label fw-semibold" for="isActiveSwitchJenisEdit<?= $j['id'] ?>">Status Aktif</label>
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
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Jenis Baru -->
<?php if (in_array(session()->get('role_code'), ['superadmin', 'admin_bpkd'])): ?>
    <div class="modal fade" id="addJenisModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <form action="<?= base_url('/jenis/store') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-header bg-primary text-white rounded-top-4">
                        <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle-fill me-2"></i> Tambah Jenis Rekening Baru</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 text-start">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Parent Kelompok</label>
                            <select name="kelompok_id" class="form-select" required>
                                <option value="">-- Pilih Kelompok --</option>
                                <?php foreach ($kelompoks as $kl): ?>
                                    <option value="<?= $kl['id'] ?>">
                                        [<?= esc($kl['kode_kelompok']) ?>] <?= esc($kl['nama_kelompok']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kode Jenis</label>
                            <input type="text" name="kode_jenis" class="form-control" placeholder="Contoh: 5.1.01" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Jenis Rekening</label>
                            <input type="text" name="nama_jenis" class="form-control" placeholder="Contoh: Belanja Pegawai" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Penjelasan singkat..."></textarea>
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActiveSwitchJenisAdd" value="1" checked>
                            <label class="form-check-label fw-semibold" for="isActiveSwitchJenisAdd">Status Aktif</label>
                        </div>
                    </div>
                    <div class="modal-footer bg-light rounded-bottom-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary fw-semibold"><i class="bi bi-plus-circle me-1"></i> Tambah Jenis</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>
