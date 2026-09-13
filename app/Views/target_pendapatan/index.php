<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Header Banner Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: linear-gradient(135deg, #059669 0%, #0284c7 100%); color: #fff;">
            <div class="card-body p-4 p-md-5">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                            <span class="badge bg-white bg-opacity-20 text-white px-3 py-1.5 fs-6 rounded-pill">
                                <i class="bi bi-graph-up-arrow me-1"></i> APBK (Target)
                            </span>
                            <span class="badge bg-warning text-dark px-3 py-1.5 fs-6 rounded-pill fw-bold">
                                TA <?= esc($activeYear['tahun'] ?? date('Y')) ?> - Status: <?= esc(strtoupper($activeYear['status_tahapan'] ?? 'PENYUSUNAN')) ?>
                            </span>
                        </div>
                        <h2 class="fw-bold mb-1 text-white">Target Pendapatan Daerah</h2>
                        <p class="text-emerald-100 mb-0 fs-5">
                            Pengelolaan Target Pendapatan Asli Daerah (PAD), Transfer, dan Lain-Lain Pendapatan Sah per SKPD / OPD.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                        <?php if (in_array($roleCode, ['superadmin', 'admin_bpkd', 'perencana_opd', 'operator_bpkd'])): ?>
                            <button type="button" class="btn btn-light shadow-sm rounded-3 fw-bold px-4 py-2.5" data-bs-toggle="modal" data-bs-target="#addTargetModal">
                                <i class="bi bi-plus-circle-fill me-2 text-success"></i> Tambah Target Pendapatan
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
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 p-3 text-white" style="background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Target Murni</div>
                    <div class="fw-bold fs-3 mt-1">Rp <?= number_format($stats['total_target_murni'], 0, ',', '.') ?></div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-cash-coin fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 p-3 text-white" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Target Pergeseran</div>
                    <div class="fw-bold fs-3 mt-1">Rp <?= number_format($stats['total_target_pergeseran'], 0, ',', '.') ?></div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-graph-up fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 p-3 text-white" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Target Perubahan</div>
                    <div class="fw-bold fs-3 mt-1">Rp <?= number_format($stats['total_target_perubahan'], 0, ',', '.') ?></div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-sliders fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 p-3 text-white" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Jumlah Item Rekening</div>
                    <div class="fw-bold fs-2 mt-1"><?= esc($stats['total_items']) ?> Item</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-journals fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Flash Notifications -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="bi bi-check-circle-fill me-2 fs-4"></i>
            <div><?= session()->getFlashdata('success') ?></div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
            <div><?= session()->getFlashdata('error') ?></div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Filter & Table Card -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-4">
        <!-- Filter Form -->
        <form method="get" action="<?= base_url('/target-pendapatan') ?>" class="row g-3 align-items-end mb-4">
            <div class="col-md-4">
                <label class="form-label fw-semibold text-secondary">Filter SKPD / OPD</label>
                <select name="skpd_id" class="form-select border-1" <?= ($roleCode === 'perencana_opd' && $userSkpdId) ? 'disabled' : '' ?>>
                    <option value="">-- Semua SKPD --</option>
                    <?php foreach ($skpdList as $skpd): ?>
                        <option value="<?= $skpd['id'] ?>" <?= ($skpd_id == $skpd['id']) ? 'selected' : '' ?>>
                            [<?= esc($skpd['kode_skpd']) ?>] <?= esc($skpd['nama_skpd']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if ($roleCode === 'perencana_opd' && $userSkpdId): ?>
                    <input type="hidden" name="skpd_id" value="<?= $userSkpdId ?>">
                <?php endif; ?>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold text-secondary">Cari Kode / Nama Rekening / Keterangan</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                    <input type="text" name="q" class="form-control" placeholder="Kata kunci..." value="<?= esc($keyword) ?>">
                </div>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-semibold text-secondary">Tampilkan</label>
                <select name="per_page" class="form-select border-1" onchange="this.form.submit()">
                    <option value="10" <?= $perPage == 10 ? 'selected' : '' ?>>10 per halaman</option>
                    <option value="15" <?= $perPage == 15 ? 'selected' : '' ?>>15 per halaman</option>
                    <option value="25" <?= $perPage == 25 ? 'selected' : '' ?>>25 per halaman</option>
                    <option value="50" <?= $perPage == 50 ? 'selected' : '' ?>>50 per halaman</option>
                </select>
            </div>

            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary fw-bold w-100">
                    <i class="bi bi-filter me-1"></i> Filter
                </button>
                <a href="<?= base_url('/target-pendapatan') ?>" class="btn btn-light border w-100 text-secondary">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                </a>
            </div>
        </form>

        <!-- Data Table -->
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle border">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center" style="width: 50px;">No</th>
                        <th>SKPD / OPD</th>
                        <th>Kode & Nama Rekening Pendapatan</th>
                        <th class="text-end">Target Murni (Rp)</th>
                        <th class="text-end">Target Pergeseran (Rp)</th>
                        <th class="text-end">Target Perubahan (Rp)</th>
                        <th class="text-center">Keterangan</th>
                        <th class="text-center" style="width: 110px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($targets)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                Tidak ada data Target Pendapatan ditemukan.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php 
                        $no = ($currentPage - 1) * $perPage + 1;
                        foreach ($targets as $item): 
                        ?>
                            <tr>
                                <td class="text-center fw-semibold text-secondary"><?= $no++ ?></td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary border px-2 py-1 mb-1 d-inline-block">
                                        <?= esc($item['kode_skpd'] ?? '-') ?>
                                    </span>
                                    <div class="fw-bold text-dark"><?= esc($item['nama_skpd'] ?? 'Semua SKPD') ?></div>
                                </td>
                                <td>
                                    <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle px-2 py-1 me-1 mb-1 d-inline-block">
                                        <i class="bi bi-tag-fill me-1"></i><?= esc($item['kode_sub_rincian_objek'] ?? '-') ?>
                                    </span>
                                    <div class="fw-semibold text-dark"><?= esc($item['nama_sub_rincian_objek'] ?? '-') ?></div>
                                    <?php if (!empty($item['nama_rincian_objek'])): ?>
                                        <small class="text-muted d-block fs-7">(<?= esc($item['nama_rincian_objek']) ?>)</small>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end fw-bold text-primary">
                                    Rp <?= number_format($item['target_murni'], 2, ',', '.') ?>
                                </td>
                                <td class="text-end fw-bold text-success">
                                    Rp <?= number_format($item['target_pergeseran'], 2, ',', '.') ?>
                                </td>
                                <td class="text-end fw-bold text-warning-emphasis">
                                    Rp <?= number_format($item['target_perubahan'], 2, ',', '.') ?>
                                </td>
                                <td class="text-center">
                                    <small class="text-secondary"><?= esc($item['keterangan'] ?: '-') ?></small>
                                </td>
                                <td class="text-center">
                                    <?php if (in_array($roleCode, ['superadmin', 'admin_bpkd', 'perencana_opd', 'operator_bpkd'])): ?>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-outline-warning edit-btn"
                                                    data-id="<?= $item['id'] ?>"
                                                    data-skpd_id="<?= $item['skpd_id'] ?>"
                                                    data-sub_rincian_objek_id="<?= $item['sub_rincian_objek_id'] ?>"
                                                    data-target_murni="<?= $item['target_murni'] ?>"
                                                    data-target_pergeseran="<?= $item['target_pergeseran'] ?>"
                                                    data-target_perubahan="<?= $item['target_perubahan'] ?>"
                                                    data-keterangan="<?= esc($item['keterangan']) ?>"
                                                    title="Edit Target">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-danger delete-btn"
                                                    data-id="<?= $item['id'] ?>"
                                                    data-title="[<?= esc($item['kode_sub_rincian_objek']) ?>] <?= esc($item['nama_sub_rincian_objek']) ?>"
                                                    title="Hapus Target">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    <?php else: ?>
                                        <span class="badge bg-light text-muted border">Read-only</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <?php if (!empty($targets)): ?>
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 pt-3 border-top">
                <div class="text-muted small mb-2 mb-md-0">
                    Menampilkan data <?= (($currentPage - 1) * $perPage) + 1 ?> hingga <?= min($currentPage * $perPage, $stats['total_items']) ?> dari total <?= $stats['total_items'] ?> entri.
                </div>
                <div>
                    <?= $pager ? $pager->links('default', 'bootstrap_full') : '' ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Tambah Target -->
<div class="modal fade" id="addTargetModal" tabindex="-1" aria-labelledby="addTargetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header bg-success text-white rounded-top-4">
                <h5 class="modal-title fw-bold" id="addTargetModalLabel">
                    <i class="bi bi-plus-circle me-2"></i> Tambah Target Pendapatan Daerah
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('/target-pendapatan/store') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">SKPD / OPD Pengelola <span class="text-danger">*</span></label>
                            <select name="skpd_id" class="form-select" required>
                                <option value="">-- Pilih SKPD --</option>
                                <?php foreach ($skpdList as $skpd): ?>
                                    <option value="<?= $skpd['id'] ?>" <?= ($userSkpdId == $skpd['id']) ? 'selected' : '' ?>>
                                        [<?= esc($skpd['kode_skpd']) ?>] <?= esc($skpd['nama_skpd']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Rekening Pendapatan <span class="text-danger">*</span></label>
                            <select name="sub_rincian_objek_id" class="form-select" required>
                                <option value="">-- Pilih Rekening Sub Rincian --</option>
                                <?php foreach ($subRincianList as $sub): ?>
                                    <option value="<?= $sub['id'] ?>">
                                        [<?= esc($sub['kode_sub_rincian_objek']) ?>] <?= esc($sub['nama_sub_rincian_objek']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Target Murni (Rp) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" name="target_murni" class="form-control" placeholder="0.00" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Target Pergeseran (Rp)</label>
                            <input type="number" step="0.01" min="0" name="target_pergeseran" class="form-control" placeholder="Kosongkan jika sama">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Target Perubahan (Rp)</label>
                            <input type="number" step="0.01" min="0" name="target_perubahan" class="form-control" placeholder="Kosongkan jika sama">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Keterangan / Dasar Hukum</label>
                            <textarea name="keterangan" class="form-control" rows="2" placeholder="Catatan atau keterangan tambahan (opsional)"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success fw-bold px-4">
                        <i class="bi bi-save me-1"></i> Simpan Target
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Target -->
<div class="modal fade" id="editTargetModal" tabindex="-1" aria-labelledby="editTargetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header bg-warning text-dark rounded-top-4">
                <h5 class="modal-title fw-bold" id="editTargetModalLabel">
                    <i class="bi bi-pencil-square me-2"></i> Edit Target Pendapatan APBK
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editTargetForm" method="post">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">SKPD / OPD Pengelola <span class="text-danger">*</span></label>
                            <select name="skpd_id" id="edit_skpd_id" class="form-select" required>
                                <option value="">-- Pilih SKPD --</option>
                                <?php foreach ($skpdList as $skpd): ?>
                                    <option value="<?= $skpd['id'] ?>">
                                        [<?= esc($skpd['kode_skpd']) ?>] <?= esc($skpd['nama_skpd']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Rekening Pendapatan <span class="text-danger">*</span></label>
                            <select name="sub_rincian_objek_id" id="edit_sub_rincian_objek_id" class="form-select" required>
                                <option value="">-- Pilih Rekening Sub Rincian --</option>
                                <?php foreach ($subRincianList as $sub): ?>
                                    <option value="<?= $sub['id'] ?>">
                                        [<?= esc($sub['kode_sub_rincian_objek']) ?>] <?= esc($sub['nama_sub_rincian_objek']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Target Murni (Rp) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" name="target_murni" id="edit_target_murni" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Target Pergeseran (Rp)</label>
                            <input type="number" step="0.01" min="0" name="target_pergeseran" id="edit_target_pergeseran" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Target Perubahan (Rp)</label>
                            <input type="number" step="0.01" min="0" name="target_perubahan" id="edit_target_perubahan" class="form-control">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Keterangan / Dasar Hukum</label>
                            <textarea name="keterangan" id="edit_keterangan" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning fw-bold px-4">
                        <i class="bi bi-check-circle me-1"></i> Perbarui Target
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Hapus Target -->
<div class="modal fade" id="deleteTargetModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header bg-danger text-white rounded-top-4">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-exclamation-triangle me-2"></i> Konfirmasi Hapus Target
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <p class="fs-5 mb-1">Apakah Anda yakin ingin menghapus data target pendapatan berikut?</p>
                <div id="deleteTargetTitle" class="fw-bold text-danger fs-5 my-2"></div>
                <p class="text-muted small mb-0">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer bg-light rounded-bottom-4 justify-content-center">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                <a id="deleteTargetConfirmBtn" href="#" class="btn btn-danger fw-bold px-4">
                    <i class="bi bi-trash me-1"></i> Ya, Hapus Data
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Dynamic Modal Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const editBtns = document.querySelectorAll('.edit-btn');
    editBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const skpdId = this.getAttribute('data-skpd_id');
            const subRincianId = this.getAttribute('data-sub_rincian_objek_id');
            const targetMurni = this.getAttribute('data-target_murni');
            const targetPergeseran = this.getAttribute('data-target_pergeseran');
            const targetPerubahan = this.getAttribute('data-target_perubahan');
            const keterangan = this.getAttribute('data-keterangan');

            document.getElementById('editTargetForm').action = '<?= base_url('/target-pendapatan/update/') ?>' + id;
            document.getElementById('edit_skpd_id').value = skpdId;
            document.getElementById('edit_sub_rincian_objek_id').value = subRincianId;
            document.getElementById('edit_target_murni').value = targetMurni;
            document.getElementById('edit_target_pergeseran').value = targetPergeseran;
            document.getElementById('edit_target_perubahan').value = targetPerubahan;
            document.getElementById('edit_keterangan').value = keterangan;

            const editModal = new bootstrap.Modal(document.getElementById('editTargetModal'));
            editModal.show();
        });
    });

    const deleteBtns = document.querySelectorAll('.delete-btn');
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const title = this.getAttribute('data-title');

            document.getElementById('deleteTargetTitle').innerText = title;
            document.getElementById('deleteTargetConfirmBtn').href = '<?= base_url('/target-pendapatan/delete/') ?>' + id;

            const deleteModal = new bootstrap.Modal(document.getElementById('deleteTargetModal'));
            deleteModal.show();
        });
    });
});
</script>

<?= $this->endSection() ?>
