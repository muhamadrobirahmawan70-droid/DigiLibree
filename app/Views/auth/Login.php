<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DigiLibree - Digital Library</title>

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') ?>" rel="stylesheet">

    <style>
        body {
            /* Warna gradasi yang lebih techy untuk DigiLibree */
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Inter', 'Segoe UI', Roboto, sans-serif;
        }

        .login-card {
            border: none;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2) !important;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .login-header {
            padding: 40px 20px 20px;
            border: none;
        }

        .brand-logo {
            width: 80px;
            height: 80px;
            background: #764ba2;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 40px;
            box-shadow: 0 10px 20px rgba(118, 75, 162, 0.3);
        }

        .brand-name {
            font-weight: 800;
            color: #2d3436;
            letter-spacing: -1px;
            font-size: 1.8rem;
        }

        .form-label {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #636e72;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            border: 2px solid #edf2f7;
            background: #f8fafc;
            transition: all 0.3s;
        }

        .form-control:focus {
            background: #fff;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .btn-login {
            background: linear-gradient(to right, #667eea, #764ba2);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 700;
            text-transform: uppercase;
            transition: all 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
            opacity: 0.9;
        }

        .alert {
            border-radius: 15px;
            border: none;
        }
    </style>
</head>

<body>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card login-card" style="width: 420px;">
            <div class="login-header text-center">
                <div class="brand-logo">
                    <i class="bi bi-collection-play-fill"></i>
                </div>
                <h2 class="brand-name mb-1">DigiLibree</h2>
                <p class="text-muted small">Akses pengetahuan tanpa batas</p>
            </div>

            <div class="card-body p-4">

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger shadow-sm py-2">
                        <i class="bi bi-x-circle-fill me-2"></i> <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('/proses-login') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan ID atau Username" required autofocus>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-login w-100 mb-4">
                        Masuk ke DigiLibree <i class="bi bi-arrow-right ms-2"></i>
                    </button>

                </form>

                <div class="text-center pt-2">
                    <p class="small text-muted mb-3">Belum bergabung dengan kami?</p>
                    <a href="<?= base_url('users/create') ?>" class="btn btn-light border-0 px-4 py-2 rounded-pill text-primary fw-bold">
                        <i class="bi bi-plus-circle-fill me-1"></i> Buat Akun Baru
                    </a>
                    <a href="<?= base_url('restore') ?>" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-database"></i> Restore DB
                    </a>
                </div>

            </div>
            
            <div class="pb-4 text-center">
                <small class="text-muted opacity-50">&copy; <?= date('Y') ?> DigiLibree Team</small>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>