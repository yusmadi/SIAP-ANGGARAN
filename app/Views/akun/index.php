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
                                <i class="bi bi-receipt me-1"></i> Standar Rekening (Permendagri 90/50)
                            </span>
                            <span class="badge bg-warning text-dark px-3 py-1.5 fs-6 rounded-pill fw-bold">
                                Level 1: Akun
                            </span>
                        </div>
                        <h2 class="fw-bold mb-1 text-white">Master Data Akun</h2>
                        <p class="text-sky-100 mb-0 fs-5">
                            Kelola klasifikasi utama Struktur Rekening APBK (Pendapatan, Belanja, & Pembiayaan Daerah).
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                        <?php if (in_array(session()->get('role_code'), ['superadmin', 'admin_bpkd'])): ?>
                            <button type="button" class="btn btn-light shadow-sm rounded-3 fw-bold px-4 py-2.5" data-bs-toggle="modal" data-bs-target="#addAkunModal">
                                <i class="bi bi-plus-circle-fill me-2 text-primary"></i> Tambah Akun Baru
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
                    <div class="text-white-50 small fw-semibold text-uppercase">Total Akun Terdaftar</div>
                    <div class="fw-bold fs-2 mt-1"><?= esc($stats['total_count']) ?> Rekening</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-hash fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-6">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-2 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Status Akun Aktif</div>
                    <div class="fw-bold fs-2 mt-1"><?= esc($stats['active_count']) ?> Akun</div>
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
            <i class="bi bi-list-task text-primary me-2"></i> Daftar Klasifikasi Master Akun
        </h5>
        
        <!-- Form Search Filter -->
        <form action="<?= base_url('/akun') ?>" method="get" class="d-flex gap-2" style="max-width: 380px; width: 100%;">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-secondary"></i></span>
                <input type="text" name="q" class="form-control form-control-sm border-start-0 ps-0" placeholder="Cari kode atau nama akun..." value="<?= esc($keyword ?? '') ?>">
                <?php if (!empty($keyword)): ?>
                    <a href="<?= base_url('/akun') ?>" class="btn btn-outline-secondary btn-sm" title="Reset Pencarian"><i class="bi bi-x-lg"></i></a>
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
                        <th style="width: 60px;">No</th>
                        <th style="width: 140px;">Kode Akun</th>
                        <th>Nama Akun</th>
                        <th>Deskripsi Penjelasan</th>
                        <th style="width: 120px;" class="text-center">Status</th>
                        <?php if (in_array(session()->get('role_code'), ['superadmin', 'admin_bpkd'])): ?>
                            <th class="text-center" style="width: 120px;">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($akuns)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                Tidak ada data Akun yang ditemukan.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($akuns as $idx => $a): ?>
                            <tr>
                                <td class="fw-bold text-secondary"><?= $idx + 1 ?></td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle font-monospace px-3 py-1.5 fs-6 fw-bold">
                                        <?= esc($a['kode_akun']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark fs-5"><?= esc($a['nama_akun']) ?></div>
                                </td>
                                <td>
                                    <span class="text-secondary small"><?= esc($a['deskripsi'] ?? '-') ?></span>
                                </td>
                                <td class="text-center">
                                    <?php if ($a['is_active']): ?>
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
                                                    data-bs-target="#editAkunModal<?= $a['id'] ?>"
                                                    title="Edit Data Akun">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <a href="<?= base_url('/akun/delete/' . $a['id']) ?>" 
                                               class="btn btn-sm btn-outline-danger" 
                                               onclick="return confirm('Apakah Anda yakin ingin menghapus Akun \'<?= esc($a['nama_akun'], 'js') ?>\'?');"
                                               title="Hapus Akun">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>

                                        <!-- Modal Edit Akun -->
                                        <div class="modal fade" id="editAkunModal<?= $a['id'] ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content border-0 shadow rounded-4">
                                                    <form action="<?= base_url('/akun/update/' . $a['id']) ?>" method="post">
                                                        <?= csrf_field() ?>
                                                        <div class="modal-header bg-primary text-white rounded-top-4">
                                                            <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i> Edit Data Akun</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-4 text-start">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Kode Akun</label>
                                                                <input type="text" name="kode_akun" class="form-control" value="<?= esc($a['kode_akun']) ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Nama Akun</label>
                                                                <input type="text" name="nama_akun" class="form-control" value="<?= esc($a['nama_akun']) ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label fw-semibold">Deskripsi</label>
                                                                <textarea name="deskripsi" class="form-control" rows="3"><?= esc($a['deskripsi']) ?></textarea>
                                                            </div>
                                                            <div class="form-check form-switch mb-2">
                                                                <input class="form-check-input" type="checkbox" name="is_active" id="isActiveSwitchEdit<?= $a['id'] ?>" value="1" <?= $a['is_active'] ? 'checked' : '' ?>>
                                                                <label class="form-check-label fw-semibold" for="isActiveSwitchEdit<?= $a['id'] ?>">Status Aktif</label>
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

<!-- Modal Tambah Akun Baru -->
<?php if (in_array(session()->get('role_code'), ['superadmin', 'admin_bpkd'])): ?>
    <div class="modal fade" id="addAkunModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <form action="<?= base_url('/akun/store') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-header bg-primary text-white rounded-top-4">
                        <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle-fill me-2"></i> Tambah Master Akun Baru</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 text-start">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kode Akun</label>
                            <input type="text" name="kode_akun" class="form-control" placeholder="Contoh: 4 atau 5" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Akun</label>
                            <input type="text" name="nama_akun" class="form-control" placeholder="Contoh: BELANJA DAERAH" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Penjelasan singkat klasifikasi akun..."></textarea>
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActiveSwitchAdd" value="1" checked>
                            <label class="form-check-label fw-semibold" for="isActiveSwitchAdd">Status Aktif</label>
                        </div>
                    </div>
                    <div class="modal-footer bg-light rounded-bottom-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary fw-semibold"><i class="bi bi-plus-circle me-1"></i> Tambah Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>
