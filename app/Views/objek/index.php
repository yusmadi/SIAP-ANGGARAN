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
                                <i class="bi bi-box me-1"></i> Standar Rekening (Kepmen 900.1-861/2026)
                            </span>
                            <span class="badge bg-warning text-dark px-3 py-1.5 fs-6 rounded-pill fw-bold">
                                Level 4: Objek
                            </span>
                        </div>
                        <h2 class="fw-bold mb-1 text-white">Master Data Objek Rekening</h2>
                        <p class="text-sky-100 mb-0 fs-5">
                            Kelola Objek Rekening (Belanja Gaji & Tunjangan, Barang Pakai Habis, Jasa Kantor, Perjalanan Dinas, dll).
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                        <?php if (in_array(session()->get('role_code'), ['superadmin', 'admin_bpkd'])): ?>
                            <button type="button" class="btn btn-light shadow-sm rounded-3 fw-bold px-4 py-2.5" data-bs-toggle="modal" data-bs-target="#addObjekModal">
                                <i class="bi bi-plus-circle-fill me-2 text-primary"></i> Tambah Objek Baru
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
                    <div class="text-white-50 small fw-semibold text-uppercase">Total Objek Rekening</div>
                    <div class="fw-bold fs-2 mt-1"><?= esc($stats['total_count']) ?> Objek</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-box fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-6">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-2 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Status Objek Aktif</div>
                    <div class="fw-bold fs-2 mt-1"><?= esc($stats['active_count']) ?> Objek</div>
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
            <i class="bi bi-list-task text-primary me-2"></i> Daftar Objek Rekening
        </h5>
        
        <div class="d-flex flex-wrap gap-2 align-items-center" style="max-width: 600px; width: 100%;">
            <form action="<?= base_url('/objek') ?>" method="get" class="d-flex gap-2 w-100">
                <select name="jenis_id" class="form-select form-select-sm border-secondary-subtle" onchange="this.form.submit()">
                    <option value="">-- Semua Jenis Rekening --</option>
                    <?php foreach ($jeniss as $jn): ?>
                        <option value="<?= $jn['id'] ?>" <?= ($jenis_id == $jn['id']) ? 'selected' : '' ?>>
                            [<?= esc($jn['kode_jenis']) ?>] <?= esc($jn['nama_jenis']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <div class="input-group input-group-sm">
                    <input type="text" name="q" class="form-control form-control-sm" placeholder="Cari kode/nama..." value="<?= esc($keyword ?? '') ?>">
                    <?php if (!empty($keyword) || !empty($jenis_id)): ?>
                        <a href="<?= base_url('/objek') ?>" class="btn btn-outline-secondary btn-sm" title="Reset Filter"><i class="bi bi-x-lg"></i></a>
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
                        <th style="width: 140px;">Kode Objek</th>
                        <th>Parent Jenis</th>
                        <th>Nama Objek Rekening</th>
                        <th>Deskripsi</th>
                        <th style="width: 110px;" class="text-center">Status</th>
                        <?php if (in_array(session()->get('role_code'), ['superadmin', 'admin_bpkd'])): ?>
                            <th class="text-center" style="width: 120px;">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($objeks)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                Tidak ada data Objek Rekening yang ditemukan.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($objeks as $idx => $o): ?>
                            <tr>
                                <td class="fw-bold text-secondary"><?= $idx + 1 ?></td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle font-monospace px-2.5 py-1.5 fs-6 fw-bold">
                                        <?= esc($o['kode_objek']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-dark border px-2.5 py-1">
                                        [<?= esc($o['kode_jenis']) ?>] <?= esc($o['nama_jenis']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark fs-5"><?= esc($o['nama_objek']) ?></div>
                                </td>
                                <td>
                                    <span class="text-secondary small"><?= esc($o['deskripsi'] ?? '-') ?></span>
                                </td>
                                <td class="text-center">
                                    <?php if ($o['is_active']): ?>
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
                                                    data-bs-target="#editObjekModal<?= $o['id'] ?>"
                                                    title="Edit Objek">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <a href="<?= base_url('/objek/delete/' . $o['id']) ?>" 
                                               class="btn btn-sm btn-outline-danger" 
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus Objek \'<?= esc($o['nama_objek'], 'js') ?>\'?');"
                                               title="Hapus Objek">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>

                                        <!-- Modal Edit Objek -->
                                        <div class="modal fade" id="editObjekModal<?= $o['id'] ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow rounded-4">
                                                    <form action="<?= base_url('/objek/update/' . $o['id']) ?>" method="post">
                                                        <?= csrf_field() ?>
                                                        <div class="modal-header bg-primary text-white rounded-top-4">
                                                            <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i> Edit Objek Rekening</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-4 text-start">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Parent Jenis</label>
                                                                <select name="jenis_id" class="form-select" required>
                                                                    <?php foreach ($jeniss as $jn): ?>
                                                                        <option value="<?= $jn['id'] ?>" <?= ($o['jenis_id'] == $jn['id']) ? 'selected' : '' ?>>
                                                                            [<?= esc($jn['kode_jenis']) ?>] <?= esc($jn['nama_jenis']) ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Kode Objek</label>
                                                                <input type="text" name="kode_objek" class="form-control" value="<?= esc($o['kode_objek']) ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Nama Objek Rekening</label>
                                                                <input type="text" name="nama_objek" class="form-control" value="<?= esc($o['nama_objek']) ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Deskripsi</label>
                                                                <textarea name="deskripsi" class="form-control" rows="3"><?= esc($o['deskripsi']) ?></textarea>
                                                            </div>
                                                            <div class="form-check form-switch mb-2">
                                                                <input class="form-check-input" type="checkbox" name="is_active" id="isActiveSwitchObjekEdit<?= $o['id'] ?>" value="1" <?= $o['is_active'] ? 'checked' : '' ?>>
                                                                <label class="form-check-label fw-semibold" for="isActiveSwitchObjekEdit<?= $o['id'] ?>">Status Aktif</label>
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

<!-- Modal Tambah Objek Baru -->
<?php if (in_array(session()->get('role_code'), ['superadmin', 'admin_bpkd'])): ?>
    <div class="modal fade" id="addObjekModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <form action="<?= base_url('/objek/store') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-header bg-primary text-white rounded-top-4">
                        <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle-fill me-2"></i> Tambah Objek Rekening Baru</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 text-start">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Parent Jenis</label>
                            <select name="jenis_id" class="form-select" required>
                                <option value="">-- Pilih Jenis Rekening --</option>
                                <?php foreach ($jeniss as $jn): ?>
                                    <option value="<?= $jn['id'] ?>">
                                        [<?= esc($jn['kode_jenis']) ?>] <?= esc($jn['nama_jenis']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kode Objek</label>
                            <input type="text" name="kode_objek" class="form-control" placeholder="Contoh: 5.1.01.01" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Objek Rekening</label>
                            <input type="text" name="nama_objek" class="form-control" placeholder="Contoh: Belanja Gaji dan Tunjangan ASN" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Penjelasan singkat..."></textarea>
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActiveSwitchObjekAdd" value="1" checked>
                            <label class="form-check-label fw-semibold" for="isActiveSwitchObjekAdd">Status Aktif</label>
                        </div>
                    </div>
                    <div class="modal-footer bg-light rounded-bottom-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary fw-semibold"><i class="bi bi-plus-circle me-1"></i> Tambah Objek</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>
