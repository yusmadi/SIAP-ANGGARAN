<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-dark mb-1">Manajemen Pengguna & Hak Akses (RBAC)</h3>
        <p class="text-secondary mb-0">Kelola akun pengguna, penugasan role, dan status aktifasi dalam sistem</p>
    </div>
    <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
        <i class="bi bi-person-plus-fill me-2"></i> Tambah Pengguna Baru
    </button>
</div>

<!-- Users Data Table Card -->
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Pengguna & NIP</th>
                        <th>Username & Email</th>
                        <th>Role RBAC</th>
                        <th>SKPK / OPD</th>
                        <th>Status</th>
                        <th>Terakhir Login</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">Belum ada data pengguna.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $index => $u): ?>
                            <tr>
                                <td class="ps-4 fw-semibold"><?= $index + 1 ?></td>
                                <td>
                                    <div class="fw-bold text-dark"><?= esc($u['nama_lengkap']) ?></div>
                                    <small class="text-muted"><?= esc($u['jabatan'] ?? '-') ?> <?= $u['nip'] ? '(' . esc($u['nip']) . ')' : '' ?></small>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark"><code><?= esc($u['username']) ?></code></div>
                                    <small class="text-muted"><?= esc($u['email']) ?></small>
                                </td>
                                <td>
                                    <span class="badge badge-role-<?= esc($u['role_code']) ?> px-2.5 py-1">
                                        <?= esc($u['role_name']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-dark fw-medium"><?= esc($u['nama_skpd'] ?? 'Pemerintah Daerah') ?></span>
                                </td>
                                <td>
                                    <?php if ((int)$u['is_active'] === 1): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1">Non-Aktif</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?= $u['last_login_at'] ? date('d M Y H:i', strtotime($u['last_login_at'])) : 'Belum pernah' ?>
                                    </small>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="<?= base_url('/users/toggle/' . $u['id']) ?>" 
                                       class="btn btn-sm <?= (int)$u['is_active'] === 1 ? 'btn-outline-danger' : 'btn-outline-success' ?>"
                                       onclick="return confirm('Apakah Anda yakin ingin mengubah status akun ini?');">
                                        <i class="bi <?= (int)$u['is_active'] === 1 ? 'bi-person-x' : 'bi-person-check' ?> me-1"></i>
                                        <?= (int)$u['is_active'] === 1 ? 'Non-aktifkan' : 'Aktifkan' ?>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-3 border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="addUserModalLabel"><i class="bi bi-person-plus me-2"></i> Tambah Pengguna Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('/users/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control" placeholder="Contoh: perencana_bpkad" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" placeholder="user@skpk.go.id" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama beserta gelar" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">NIP</label>
                            <input type="text" name="nip" class="form-control" placeholder="19800101 200501 1 001">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" placeholder="Kasubag Program / Pengelola">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Role Access (RBAC) <span class="text-danger">*</span></label>
                            <select name="role_id" class="form-select" required>
                                <option value="">-- Pilih Role --</option>
                                <?php foreach ($roles as $r): ?>
                                    <option value="<?= $r['id'] ?>"><?= esc($r['role_name']) ?> (<?= esc($r['role_code']) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">SKPK / OPD</label>
                            <select name="skpd_id" class="form-select">
                                <option value="">-- Tidak Terikat SKPK (Pimpinan/Admin) --</option>
                                <?php foreach ($skpds as $s): ?>
                                    <option value="<?= $s['id'] ?>"><?= esc($s['nama_skpd']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
