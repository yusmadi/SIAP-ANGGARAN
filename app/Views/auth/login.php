<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIAP-PAGU</title>
    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 & Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0284c7 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            border: 1px solid rgba(255, 255, 255, 0.15);
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(12px);
            border-radius: 1.25rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
        }
        .demo-card {
            background: rgba(15, 23, 42, 0.85);
            color: #f8fafc;
            border-radius: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .btn-brand {
            background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%);
            color: #fff;
            font-weight: 600;
            border: none;
        }
        .btn-brand:hover {
            background: linear-gradient(135deg, #0369a1 0%, #1d4ed8 100%);
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center align-items-center g-4">
            <!-- Left Side: Login Form -->
            <div class="col-lg-5 col-md-8">
                <div class="card login-card p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-circle p-3 mb-3 shadow-sm" style="width: 64px; height: 64px;">
                            <i class="bi bi-wallet2 fs-1"></i>
                        </div>
                        <h3 class="fw-bold text-dark mb-1">SIAP-PAGU</h3>
                        <p class="text-muted small">Sistem Informasi Akuntabilitas Perencanaan & Pagu Anggaran</p>
                    </div>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 fs-6 p-3 mb-4" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show rounded-3 fs-6 p-3 mb-4" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('/auth/process') ?>" method="POST">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="login_input" class="form-label fw-semibold text-dark">Username atau Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person"></i></span>
                                <input type="text" name="login_input" id="login_input" class="form-control bg-light border-start-0 ps-0" placeholder="Masukkan username atau email" value="<?= old('login_input') ?>" required autofocus>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <label for="password" class="form-label fw-semibold text-dark mb-0">Password</label>
                            </div>
                            <div class="input-group mt-2">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-key"></i></span>
                                <input type="password" name="password" id="password" class="form-control bg-light border-start-0 ps-0" placeholder="Masukkan password" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-brand w-100 py-2.5 rounded-3 shadow-sm mb-3">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Masuk ke Sistem
                        </button>
                    </form>

                    <div class="text-center text-muted small mt-3">
                        Kepatuhan Regulasi Permendagri No. 77/2020 & 90/2019
                    </div>
                </div>
            </div>

            <!-- Right Side: Demo Credentials Card -->
            <div class="col-lg-5 col-md-8">
                <div class="card demo-card p-4 shadow-lg">
                    <div class="d-flex align-items-center gap-2 mb-3 border-bottom border-secondary border-opacity-50 pb-2">
                        <i class="bi bi-shield-lock-fill text-warning fs-3"></i>
                        <div>
                            <h5 class="fw-bold mb-0 text-white">Akun Demo RBAC 5 Role</h5>
                            <small class="text-secondary">Klik tombol akun untuk mengisi form otomatis</small>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-dark table-hover table-sm text-start align-middle mb-0" style="font-size: 0.85rem;">
                            <thead>
                                <tr class="text-secondary">
                                    <th>Role</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="badge bg-danger">Superadmin</span></td>
                                    <td><code>superadmin</code></td>
                                    <td><code>admin123</code></td>
                                    <td>
                                        <button type="button" class="btn btn-xs btn-outline-info py-0 px-2 fs-7" onclick="fillLogin('superadmin', 'admin123')">Pilih</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-primary">Perencana OPD</span></td>
                                    <td><code>perencana</code></td>
                                    <td><code>user123</code></td>
                                    <td>
                                        <button type="button" class="btn btn-xs btn-outline-info py-0 px-2 fs-7" onclick="fillLogin('perencana', 'user123')">Pilih</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-warning text-dark">Verifikator TAPD</span></td>
                                    <td><code>verifikator</code></td>
                                    <td><code>user123</code></td>
                                    <td>
                                        <button type="button" class="btn btn-xs btn-outline-info py-0 px-2 fs-7" onclick="fillLogin('verifikator', 'user123')">Pilih</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-success">PPKD / Keuangan</span></td>
                                    <td><code>ppkd</code></td>
                                    <td><code>user123</code></td>
                                    <td>
                                        <button type="button" class="btn btn-xs btn-outline-info py-0 px-2 fs-7" onclick="fillLogin('ppkd', 'user123')">Pilih</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-purple" style="background-color: #8b5cf6;">Pimpinan Eksekutif</span></td>
                                    <td><code>pimpinan</code></td>
                                    <td><code>user123</code></td>
                                    <td>
                                        <button type="button" class="btn btn-xs btn-outline-info py-0 px-2 fs-7" onclick="fillLogin('pimpinan', 'user123')">Pilih</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="alert alert-info bg-info bg-opacity-10 border-info border-opacity-25 text-info mt-3 mb-0 p-2 rounded small">
                        <i class="bi bi-info-circle me-1"></i> Setiap percobaan login dicatat ke dalam <strong>Audit Logs</strong> immutable. Maximum login failure throttling diterapkan otomatis.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function fillLogin(username, password) {
            document.getElementById('login_input').value = username;
            document.getElementById('password').value = password;
        }
    </script>
</body>
</html>
