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
                                <i class="bi bi-list-nested me-1"></i> Standar Rekening (Kepmen 900.1-861/2026)
                            </span>
                            <span class="badge bg-warning text-dark px-3 py-1.5 fs-6 rounded-pill fw-bold">
                                Level 5: Rincian Objek
                            </span>
                        </div>
                        <h2 class="fw-bold mb-1 text-white">Master Data Rincian Objek Rekening</h2>
                        <p class="text-sky-100 mb-0 fs-5">
                            Kelola Rincian Objek (Gaji Pokok PNS, Tunjangan Keluarga, ATK, Listrik, Internet, Perjalanan Dinas, PC, dll).
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                        <?php if (in_array(session()->get('role_code'), ['superadmin', 'admin_bpkd'])): ?>
                            <button type="button" class="btn btn-light shadow-sm rounded-3 fw-bold px-4 py-2.5" data-bs-toggle="modal" data-bs-target="#addRincianObjekModal">
                                <i class="bi bi-plus-circle-fill me-2 text-primary"></i> Tambah Rincian Objek Baru
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
                    <div class="text-white-50 small fw-semibold text-uppercase">Total Rincian Objek</div>
                    <div class="fw-bold fs-2 mt-1"><?= esc($stats['total_count']) ?> Rekening</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-list-nested fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-6">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-2 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Status Rincian Objek Aktif</div>
                    <div class="fw-bold fs-2 mt-1"><?= esc($stats['active_count']) ?> Rekening</div>
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
            <i class="bi bi-list-task text-primary me-2"></i> Daftar Rincian Objek Rekening
        </h5>
        
        <div class="d-flex flex-wrap gap-2 align-items-center" style="max-width: 600px; width: 100%;">
            <form action="<?= base_url('/rincian-objek') ?>" method="get" class="d-flex gap-2 w-100">
                <select name="objek_id" class="form-select form-select-sm border-secondary-subtle" onchange="this.form.submit()">
                    <option value="">-- Semua Objek Rekening --</option>
                    <?php foreach ($objeks as $ob): ?>
                        <option value="<?= $ob['id'] ?>" <?= ($objek_id == $ob['id']) ? 'selected' : '' ?>>
                            [<?= esc($ob['kode_objek']) ?>] <?= esc($ob['nama_objek']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <div class="input-group input-group-sm">
                    <input type="text" name="q" class="form-control form-control-sm" placeholder="Cari kode/nama..." value="<?= esc($keyword ?? '') ?>">
                    <?php if (!empty($keyword) || !empty($objek_id)): ?>
                        <a href="<?= base_url('/rincian-objek') ?>" class="btn btn-outline-secondary btn-sm" title="Reset Filter"><i class="bi bi-x-lg"></i></a>
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
                        <th style="width: 170px;">Kode Rincian Objek</th>
                        <th>Parent Objek</th>
                        <th>Nama Rincian Objek</th>
                        <th>Deskripsi</th>
                        <th style="width: 110px;" class="text-center">Status</th>
                        <?php if (in_array(session()->get('role_code'), ['superadmin', 'admin_bpkd'])): ?>
                            <th class="text-center" style="width: 120px;">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($rincianObjeks)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                Tidak ada data Rincian Objek Rekening yang ditemukan.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($rincianObjeks as $idx => $ro): ?>
                            <tr>
                                <td class="fw-bold text-secondary"><?= $idx + 1 ?></td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle font-monospace px-2.5 py-1.5 fs-6 fw-bold">
                                        <?= esc($ro['kode_rincian_objek']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-dark border px-2.5 py-1">
                                        [<?= esc($ro['kode_objek']) ?>] <?= esc($ro['nama_objek']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark fs-5"><?= esc($ro['nama_rincian_objek']) ?></div>
                                </td>
                                <td>
                                    <span class="text-secondary small"><?= esc($ro['deskripsi'] ?? '-') ?></span>
                                </td>
                                <td class="text-center">
                                    <?php if ($ro['is_active']): ?>
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
                                                    data-bs-target="#editRincianModal<?= $ro['id'] ?>"
                                                    title="Edit Rincian Objek">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <a href="<?= base_url('/rincian-objek/delete/' . $ro['id']) ?>" 
                                               class="btn btn-sm btn-outline-danger" 
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus Rincian Objek \'<?= esc($ro['nama_rincian_objek'], 'js') ?>\'?');"
                                               title="Hapus Rincian Objek">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>

                                        <!-- Modal Edit Rincian Objek -->
                                        <div class="modal fade" id="editRincianModal<?= $ro['id'] ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow rounded-4">
                                                    <form action="<?= base_url('/rincian-objek/update/' . $ro['id']) ?>" method="post">
                                                        <?= csrf_field() ?>
                                                        <div class="modal-header bg-primary text-white rounded-top-4">
                                                            <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i> Edit Rincian Objek</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-4 text-start">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Parent Objek</label>
                                                                <select name="objek_id" class="form-select" required>
                                                                    <?php foreach ($objeks as $ob): ?>
                                                                        <option value="<?= $ob['id'] ?>" <?= ($ro['objek_id'] == $ob['id']) ? 'selected' : '' ?>>
                                                                            [<?= esc($ob['kode_objek']) ?>] <?= esc($ob['nama_objek']) ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Kode Rincian Objek</label>
                                                                <input type="text" name="kode_rincian_objek" class="form-control" value="<?= esc($ro['kode_rincian_objek']) ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Nama Rincian Objek</label>
                                                                <input type="text" name="nama_rincian_objek" class="form-control" value="<?= esc($ro['nama_rincian_objek']) ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Deskripsi</label>
                                                                <textarea name="deskripsi" class="form-control" rows="3"><?= esc($ro['deskripsi']) ?></textarea>
                                                            </div>
                                                            <div class="form-check form-switch mb-2">
                                                                <input class="form-check-input" type="checkbox" name="is_active" id="isActiveSwitchRincianEdit<?= $ro['id'] ?>" value="1" <?= $ro['is_active'] ? 'checked' : '' ?>>
                                                                <label class="form-check-label fw-semibold" for="isActiveSwitchRincianEdit<?= $ro['id'] ?>">Status Aktif</label>
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

<!-- Modal Tambah Rincian Objek Baru -->
<?php if (in_array(session()->get('role_code'), ['superadmin', 'admin_bpkd'])): ?>
    <div class="modal fade" id="addRincianObjekModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <form action="<?= base_url('/rincian-objek/store') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-header bg-primary text-white rounded-top-4">
                        <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle-fill me-2"></i> Tambah Rincian Objek Baru</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 text-start">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Parent Objek</label>
                            <select name="objek_id" class="form-select" required>
                                <option value="">-- Pilih Objek Rekening --</option>
                                <?php foreach ($objeks as $ob): ?>
                                    <option value="<?= $ob['id'] ?>">
                                        [<?= esc($ob['kode_objek']) ?>] <?= esc($ob['nama_objek']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kode Rincian Objek</label>
                            <input type="text" name="kode_rincian_objek" class="form-control" placeholder="Contoh: 5.1.01.01.0001" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Rincian Objek</label>
                            <input type="text" name="nama_rincian_objek" class="form-control" placeholder="Contoh: Belanja Gaji Pokok PNS/PNSD" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Penjelasan singkat..."></textarea>
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActiveSwitchRincianAdd" value="1" checked>
                            <label class="form-check-label fw-semibold" for="isActiveSwitchRincianAdd">Status Aktif</label>
                        </div>
                    </div>
                    <div class="modal-footer bg-light rounded-bottom-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary fw-semibold"><i class="bi bi-plus-circle me-1"></i> Tambah Rincian Objek</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>
