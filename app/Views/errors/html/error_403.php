<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak | SIAP-ANGGARAN</title>
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
            background-color: #0f172a;
            color: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-card {
            background: rgba(30, 41, 59, 0.85);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 1rem;
            max-width: 540px;
            width: 100%;
        }
    </style>
</head>
<body class="p-4">
    <div class="card error-card shadow-lg p-4 p-md-5 text-center">
        <div class="mb-3 text-danger">
            <i class="bi bi-shield-slash-fill display-1"></i>
        </div>
        <h2 class="fw-bold text-white mb-2">HTTP 403 - Akses Ditolak</h2>
        <p class="text-secondary fs-5 mb-4">
            Anda tidak memiliki wewenang untuk mengakses halaman <code><?= esc($attempted_uri ?? '') ?></code>.
        </p>

        <div class="alert alert-danger bg-danger bg-opacity-10 border-danger border-opacity-25 text-danger text-start mb-4 rounded-3">
            <div class="d-flex align-items-center gap-2 mb-1">
                <i class="bi bi-exclamation-octagon-fill"></i>
                <strong class="fs-6">Prinsip Least Privilege RBAC:</strong>
            </div>
            <small class="d-block">
                Sistem SIAP-ANGGARAN membatasi setiap fungsi hanya untuk role pengguna yang berwenang. Akun Anda terdaftar sebagai <strong><?= esc($role_name ?? 'User') ?></strong>.
            </small>
        </div>

        <a href="<?= base_url('/dashboard') ?>" class="btn btn-primary btn-lg rounded-3 fw-semibold">
            <i class="bi bi-house-door-fill me-2"></i> Kembali ke Dashboard
        </a>
    </div>
</body>
</html>
