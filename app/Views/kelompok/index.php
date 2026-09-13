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
                                <i class="bi bi-folder2-open me-1"></i> Standar Rekening (Permendagri 90/50)
                            </span>
                            <span class="badge bg-warning text-dark px-3 py-1.5 fs-6 rounded-pill fw-bold">
                                Level 2: Kelompok
                            </span>
                        </div>
                        <h2 class="fw-bold mb-1 text-white">Master Data Kelompok Rekening</h2>
                        <p class="text-sky-100 mb-0 fs-5">
                            Kelola kelompok belanja, pendapatan, dan pembiayaan (Belanja Operasi, Belanja Modal, PAD, dll).
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                        <?php if (in_array(session()->get('role_code'), ['superadmin', 'admin_bpkd'])): ?>
                            <button type="button" class="btn btn-light shadow-sm rounded-3 fw-bold px-4 py-2.5" data-bs-toggle="modal" data-bs-target="#addKelompokModal">
                                <i class="bi bi-plus-circle-fill me-2 text-primary"></i> Tambah Kelompok Baru
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
                    <div class="text-white-50 small fw-semibold text-uppercase">Total Kelompok Rekening</div>
                    <div class="fw-bold fs-2 mt-1"><?= esc($stats['total_count']) ?> Kelompok</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-folder2-open fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-6">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-2 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Status Kelompok Aktif</div>
                    <div class="fw-bold fs-2 mt-1"><?= esc($stats['active_count']) ?> Kelompok</div>
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
            <i class="bi bi-list-task text-primary me-2"></i> Daftar Kelompok Rekening
        </h5>
        
        <div class="d-flex flex-wrap gap-2 align-items-center" style="max-width: 600px; width: 100%;">
            <!-- Filter Parent Akun -->
            <form action="<?= base_url('/kelompok') ?>" method="get" class="d-flex gap-2 w-100">
                <select name="akun_id" class="form-select form-select-sm border-secondary-subtle" onchange="this.form.submit()">
                    <option value="">-- Semua Master Akun --</option>
                    <?php foreach ($akuns as $ak): ?>
                        <option value="<?= $ak['id'] ?>" <?= ($akun_id == $ak['id']) ? 'selected' : '' ?>>
                            [<?= esc($ak['kode_akun']) ?>] <?= esc($ak['nama_akun']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <div class="input-group input-group-sm">
                    <input type="text" name="q" class="form-control form-control-sm" placeholder="Cari kode/nama..." value="<?= esc($keyword ?? '') ?>">
                    <?php if (!empty($keyword) || !empty($akun_id)): ?>
                        <a href="<?= base_url('/kelompok') ?>" class="btn btn-outline-secondary btn-sm" title="Reset Filter"><i class="bi bi-x-lg"></i></a>
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
                        <th style="width: 140px;">Kode Kelompok</th>
                        <th>Parent Akun</th>
                        <th>Nama Kelompok Rekening</th>
                        <th>Deskripsi Penjelasan</th>
                        <th style="width: 110px;" class="text-center">Status</th>
                        <?php if (in_array(session()->get('role_code'), ['superadmin', 'admin_bpkd'])): ?>
                            <th class="text-center" style="width: 120px;">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($kelompoks)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                Tidak ada data Kelompok yang ditemukan.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($kelompoks as $idx => $k): ?>
                            <tr>
                                <td class="fw-bold text-secondary"><?= $idx + 1 ?></td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle font-monospace px-2.5 py-1.5 fs-6 fw-bold">
                                        <?= esc($k['kode_kelompok']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-dark border px-2.5 py-1">
                                        [<?= esc($k['kode_akun']) ?>] <?= esc($k['nama_akun']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark fs-5"><?= esc($k['nama_kelompok']) ?></div>
                                </td>
                                <td>
                                    <span class="text-secondary small"><?= esc($k['deskripsi'] ?? '-') ?></span>
                                </td>
                                <td class="text-center">
                                    <?php if ($k['is_active']): ?>
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
                                                    data-bs-target="#editKelompokModal<?= $k['id'] ?>"
                                                    title="Edit Kelompok">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <a href="<?= base_url('/kelompok/delete/' . $k['id']) ?>" 
                                               class="btn btn-sm btn-outline-danger" 
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus Kelompok \'<?= esc($k['nama_kelompok'], 'js') ?>\'?');"
                                               title="Hapus Kelompok">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>

                                        <!-- Modal Edit Kelompok -->
                                        <div class="modal fade" id="editKelompokModal<?= $k['id'] ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow rounded-4">
                                                    <form action="<?= base_url('/kelompok/update/' . $k['id']) ?>" method="post">
                                                        <?= csrf_field() ?>
                                                        <div class="modal-header bg-primary text-white rounded-top-4">
                                                            <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i> Edit Kelompok Rekening</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-4 text-start">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Parent Akun</label>
                                                                <select name="akun_id" class="form-select" required>
                                                                    <?php foreach ($akuns as $ak): ?>
                                                                        <option value="<?= $ak['id'] ?>" <?= ($k['akun_id'] == $ak['id']) ? 'selected' : '' ?>>
                                                                            [<?= esc($ak['kode_akun']) ?>] <?= esc($ak['nama_akun']) ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Kode Kelompok</label>
                                                                <input type="text" name="kode_kelompok" class="form-control" value="<?= esc($k['kode_kelompok']) ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Nama Kelompok Rekening</label>
                                                                <input type="text" name="nama_kelompok" class="form-control" value="<?= esc($k['nama_kelompok']) ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Deskripsi</label>
                                                                <textarea name="deskripsi" class="form-control" rows="3"><?= esc($k['deskripsi']) ?></textarea>
                                                            </div>
                                                            <div class="form-check form-switch mb-2">
                                                                <input class="form-check-input" type="checkbox" name="is_active" id="isActiveSwitchKelompokEdit<?= $k['id'] ?>" value="1" <?= $k['is_active'] ? 'checked' : '' ?>>
                                                                <label class="form-check-label fw-semibold" for="isActiveSwitchKelompokEdit<?= $k['id'] ?>">Status Aktif</label>
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

<!-- Modal Tambah Kelompok Baru -->
<?php if (in_array(session()->get('role_code'), ['superadmin', 'admin_bpkd'])): ?>
    <div class="modal fade" id="addKelompokModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <form action="<?= base_url('/kelompok/store') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-header bg-primary text-white rounded-top-4">
                        <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle-fill me-2"></i> Tambah Kelompok Rekening Baru</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 text-start">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Parent Akun</label>
                            <select name="akun_id" class="form-select" required>
                                <option value="">-- Pilih Master Akun --</option>
                                <?php foreach ($akuns as $ak): ?>
                                    <option value="<?= $ak['id'] ?>">
                                        [<?= esc($ak['kode_akun']) ?>] <?= esc($ak['nama_akun']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kode Kelompok</label>
                            <input type="text" name="kode_kelompok" class="form-control" placeholder="Contoh: 5.1" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Kelompok Rekening</label>
                            <input type="text" name="nama_kelompok" class="form-control" placeholder="Contoh: BELANJA OPERASI" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Penjelasan singkat kelompok rekening..."></textarea>
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActiveSwitchKelompokAdd" value="1" checked>
                            <label class="form-check-label fw-semibold" for="isActiveSwitchKelompokAdd">Status Aktif</label>
                        </div>
                    </div>
                    <div class="modal-footer bg-light rounded-bottom-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary fw-semibold"><i class="bi bi-plus-circle me-1"></i> Tambah Kelompok</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>
