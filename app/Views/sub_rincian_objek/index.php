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
                                <i class="bi bi-card-list me-1"></i> Standar Rekening (Kepmen 900.1-861/2026)
                            </span>
                            <span class="badge bg-warning text-dark px-3 py-1.5 fs-6 rounded-pill fw-bold">
                                Level 6: Sub Rincian Objek
                            </span>
                        </div>
                        <h2 class="fw-bold mb-1 text-white">Master Data Sub Rincian Objek</h2>
                        <p class="text-sky-100 mb-0 fs-5">
                            Kelola Sub Rincian Objek (Tingkat Rekening Detail Penganggaran RKA/DPA APBK).
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                        <?php if (in_array(session()->get('role_code'), ['superadmin', 'admin_bpkd'])): ?>
                            <button type="button" class="btn btn-light shadow-sm rounded-3 fw-bold px-4 py-2.5" data-bs-toggle="modal" data-bs-target="#addSubRincianModal">
                                <i class="bi bi-plus-circle-fill me-2 text-primary"></i> Tambah Sub Rincian Baru
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
                    <div class="text-white-50 small fw-semibold text-uppercase">Total Sub Rincian Objek</div>
                    <div class="fw-bold fs-2 mt-1"><?= esc($stats['total_count']) ?> Rekening</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-card-list fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-6">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-2 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Status Sub Rincian Aktif</div>
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
            <i class="bi bi-list-task text-primary me-2"></i> Daftar Sub Rincian Objek Rekening
        </h5>
        
        <div class="d-flex flex-wrap gap-2 align-items-center" style="max-width: 680px; width: 100%;">
            <form action="<?= base_url('/sub-rincian-objek') ?>" method="get" class="d-flex gap-2 w-100 flex-wrap flex-sm-nowrap">
                <select name="per_page" class="form-select form-select-sm border-secondary-subtle" style="min-width: 100px; max-width: 110px;" onchange="this.form.submit()" title="Jumlah data per halaman">
                    <option value="10" <?= $perPage == 10 ? 'selected' : '' ?>>10 / hal</option>
                    <option value="15" <?= $perPage == 15 ? 'selected' : '' ?>>15 / hal</option>
                    <option value="25" <?= $perPage == 25 ? 'selected' : '' ?>>25 / hal</option>
                    <option value="50" <?= $perPage == 50 ? 'selected' : '' ?>>50 / hal</option>
                    <option value="100" <?= $perPage == 100 ? 'selected' : '' ?>>100 / hal</option>
                </select>

                <select name="rincian_objek_id" class="form-select form-select-sm border-secondary-subtle" onchange="this.form.submit()">
                    <option value="">-- Semua Rincian Objek --</option>
                    <?php foreach ($rincianObjeks as $ro): ?>
                        <option value="<?= $ro['id'] ?>" <?= ($rincian_objek_id == $ro['id']) ? 'selected' : '' ?>>
                            [<?= esc($ro['kode_rincian_objek']) ?>] <?= esc($ro['nama_rincian_objek']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <div class="input-group input-group-sm">
                    <input type="text" name="q" class="form-control form-control-sm" placeholder="Cari kode/nama..." value="<?= esc($keyword ?? '') ?>">
                    <?php if (!empty($keyword) || !empty($rincian_objek_id) || $perPage != 15): ?>
                        <a href="<?= base_url('/sub-rincian-objek') ?>" class="btn btn-outline-secondary btn-sm" title="Reset Filter"><i class="bi bi-x-lg"></i></a>
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
                        <th style="width: 200px;">Kode Sub Rincian Objek</th>
                        <th>Parent Rincian Objek</th>
                        <th>Nama Sub Rincian Objek</th>
                        <th>Deskripsi</th>
                        <th style="width: 110px;" class="text-center">Status</th>
                        <?php if (in_array(session()->get('role_code'), ['superadmin', 'admin_bpkd'])): ?>
                            <th class="text-center" style="width: 120px;">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($subRincianObjeks)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                Tidak ada data Sub Rincian Objek Rekening yang ditemukan.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php 
                        $no = ($currentPage - 1) * $perPage + 1;
                        foreach ($subRincianObjeks as $idx => $sro): 
                        ?>
                            <tr>
                                <td class="fw-bold text-secondary"><?= $no++ ?></td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle font-monospace px-2.5 py-1.5 fs-6 fw-bold">
                                        <?= esc($sro['kode_sub_rincian_objek']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-dark border px-2.5 py-1">
                                        [<?= esc($sro['kode_rincian_objek']) ?>] <?= esc($sro['nama_rincian_objek']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark fs-5"><?= esc($sro['nama_sub_rincian_objek']) ?></div>
                                </td>
                                <td>
                                    <span class="text-secondary small"><?= esc($sro['deskripsi'] ?? '-') ?></span>
                                </td>
                                <td class="text-center">
                                    <?php if ($sro['is_active']): ?>
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
                                                    data-bs-target="#editSubRincianModal<?= $sro['id'] ?>"
                                                    title="Edit Sub Rincian">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <a href="<?= base_url('/sub-rincian-objek/delete/' . $sro['id']) ?>" 
                                               class="btn btn-sm btn-outline-danger" 
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus Sub Rincian Objek \'<?= esc($sro['nama_sub_rincian_objek'], 'js') ?>\'?');"
                                               title="Hapus Sub Rincian Objek">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>

                                        <!-- Modal Edit Sub Rincian Objek -->
                                        <div class="modal fade" id="editSubRincianModal<?= $sro['id'] ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow rounded-4">
                                                    <form action="<?= base_url('/sub-rincian-objek/update/' . $sro['id']) ?>" method="post">
                                                        <?= csrf_field() ?>
                                                        <div class="modal-header bg-primary text-white rounded-top-4">
                                                            <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i> Edit Sub Rincian Objek</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-4 text-start">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Parent Rincian Objek</label>
                                                                <select name="rincian_objek_id" class="form-select" required>
                                                                    <?php foreach ($rincianObjeks as $ro): ?>
                                                                        <option value="<?= $ro['id'] ?>" <?= ($sro['rincian_objek_id'] == $ro['id']) ? 'selected' : '' ?>>
                                                                            [<?= esc($ro['kode_rincian_objek']) ?>] <?= esc($ro['nama_rincian_objek']) ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Kode Sub Rincian Objek</label>
                                                                <input type="text" name="kode_sub_rincian_objek" class="form-control" value="<?= esc($sro['kode_sub_rincian_objek']) ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Nama Sub Rincian Objek</label>
                                                                <input type="text" name="nama_sub_rincian_objek" class="form-control" value="<?= esc($sro['nama_sub_rincian_objek']) ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Deskripsi</label>
                                                                <textarea name="deskripsi" class="form-control" rows="3"><?= esc($sro['deskripsi']) ?></textarea>
                                                            </div>
                                                            <div class="form-check form-switch mb-2">
                                                                <input class="form-check-input" type="checkbox" name="is_active" id="isActiveSwitchSubRincianEdit<?= $sro['id'] ?>" value="1" <?= $sro['is_active'] ? 'checked' : '' ?>>
                                                                <label class="form-check-label fw-semibold" for="isActiveSwitchSubRincianEdit<?= $sro['id'] ?>">Status Aktif</label>
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

    <!-- Card Footer / Pagination -->
    <div class="card-footer bg-transparent border-top py-3 px-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
        <?php 
        $totalItems = $pager ? $pager->getTotal() : count($subRincianObjeks);
        $startItem  = $totalItems > 0 ? ($currentPage - 1) * $perPage + 1 : 0;
        $endItem    = min($currentPage * $perPage, $totalItems);
        ?>
        <div class="small text-muted">
            <?php if ($totalItems > 0): ?>
                Menampilkan <strong><?= $startItem ?></strong> - <strong><?= $endItem ?></strong> dari <strong><?= number_format($totalItems) ?></strong> data Sub Rincian Objek
            <?php else: ?>
                Menampilkan 0 data Sub Rincian Objek
            <?php endif; ?>
        </div>

        <div>
            <?= $pager ? $pager->links('default', 'bootstrap_full') : '' ?>
        </div>
    </div>
</div>

<!-- Modal Tambah Sub Rincian Objek Baru -->
<?php if (in_array(session()->get('role_code'), ['superadmin', 'admin_bpkd'])): ?>
    <div class="modal fade" id="addSubRincianModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <form action="<?= base_url('/sub-rincian-objek/store') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-header bg-primary text-white rounded-top-4">
                        <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle-fill me-2"></i> Tambah Sub Rincian Objek Baru</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 text-start">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Parent Rincian Objek</label>
                            <select name="rincian_objek_id" class="form-select" required>
                                <option value="">-- Pilih Rincian Objek --</option>
                                <?php foreach ($rincianObjeks as $ro): ?>
                                    <option value="<?= $ro['id'] ?>">
                                        [<?= esc($ro['kode_rincian_objek']) ?>] <?= esc($ro['nama_rincian_objek']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kode Sub Rincian Objek</label>
                            <input type="text" name="kode_sub_rincian_objek" class="form-control" placeholder="Contoh: 5.1.01.01.0001.00001" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Sub Rincian Objek</label>
                            <input type="text" name="nama_sub_rincian_objek" class="form-control" placeholder="Contoh: Belanja Gaji Pokok PNSD - Golongan I s/d IV" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Penjelasan singkat..."></textarea>
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActiveSwitchSubRincianAdd" value="1" checked>
                            <label class="form-check-label fw-semibold" for="isActiveSwitchSubRincianAdd">Status Aktif</label>
                        </div>
                    </div>
                    <div class="modal-footer bg-light rounded-bottom-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary fw-semibold"><i class="bi bi-plus-circle me-1"></i> Tambah Sub Rincian Objek</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>
