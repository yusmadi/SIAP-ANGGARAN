<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Welcome Banner Card Superadmin -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%); color: #fff;">
            <div class="card-body p-4 p-md-5">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-danger px-3 py-1.5 fs-6 rounded-pill">
                                <i class="bi bi-shield-fill-check me-1"></i> <?= esc($user['role_name']) ?>
                            </span>
                            <span class="badge bg-white bg-opacity-20 text-white px-3 py-1.5 fs-6 rounded-pill">
                                System Infrastructure & Security
                            </span>
                        </div>
                        <h2 class="fw-bold mb-1 text-white">Portal Super Administrator, <?= esc($user['name']) ?></h2>
                        <p class="text-indigo-200 mb-3 fs-5">
                            Kontrol Penuh Infrastruktur, Konfigurasi RBAC & Audit Trails SIAP-ANGGARAN
                        </p>
                        <p class="text-white-50 mb-0 small">
                            Status Sistem: <span class="badge bg-success text-white"><i class="bi bi-circle-fill fs-7 me-1"></i> Operational (Clean)</span> &bull; Security Level: High (Immutable Logging Active)
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                        <a href="<?= base_url('/users') ?>" class="btn btn-danger btn-lg shadow-sm rounded-3 fw-semibold">
                            <i class="bi bi-people-fill me-2"></i> Kelola Pengguna & Roles
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stat Cards Infrastructure & Users -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-1 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Total Pengguna Aktif</div>
                    <div class="fw-bold fs-2 mt-1"><?= esc($stats['total_users']) ?> Account</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-person-badge fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-2 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Total Terdaftar SKPK</div>
                    <div class="fw-bold fs-2 mt-1"><?= esc($stats['total_skpd']) ?> Unit Kerja</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-buildings fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-3 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">Total Audit Logs</div>
                    <div class="fw-bold fs-2 mt-1"><?= count($recent_logs ?? []) ?> Rec</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-journal-text fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-3 stat-card-gradient-4 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-white-50 small fw-semibold text-uppercase">System Health</div>
                    <div class="fw-bold fs-3 mt-1">100% Secure</div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-circle p-3">
                    <i class="bi bi-cpu fs-2 text-white"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Audit Log Stream -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-shield-lock text-danger me-2"></i> Audit Trails Aktivitas Terbaru
                </h5>
                <span class="badge bg-light text-secondary border">Real-time Logger</span>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>Event / Aksi</th>
                                <th>Pengguna</th>
                                <th>IP Address</th>
                                <th>Waktu Recorded</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($recent_logs)): ?>
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada aktivitas audit log tercatat.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($recent_logs as $log): ?>
                                    <tr>
                                        <td>
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">
                                                <?= esc($log['action_event']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark"><?= esc($log['nama_lengkap'] ?? $log['username'] ?? 'System') ?></div>
                                            <small class="text-muted">Table: <?= esc($log['table_affected']) ?></small>
                                        </td>
                                        <td><code><?= esc($log['ip_address'] ?? '127.0.0.1') ?></code></td>
                                        <td><small class="text-muted"><?= date('d M Y H:i:s', strtotime($log['created_at'])) ?></small></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- User Role Distribution -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-pie-chart-fill text-primary me-2"></i> Distribusi Role RBAC
                </h5>
            </div>
            <div class="card-body p-4">
                <ul class="list-group list-group-flush">
                    <?php foreach ($roles_count as $r): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                            <div>
                                <span class="badge badge-role-<?= esc($r['role_code']) ?> me-2 px-2 py-1">
                                    <?= esc($r['role_code']) ?>
                                </span>
                                <span class="fw-semibold text-dark"><?= esc($r['role_name']) ?></span>
                            </div>
                            <span class="badge bg-light text-dark fs-6 rounded-pill border px-3">
                                <?= esc($r['user_count']) ?> User
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
