<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | DigiLibree - Perpustakaan Digital</title>

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --berry-purple: #673ab7;
            --berry-purple-light: #ede7f6;
            --berry-bg: #fafafa;
        }

        body {
            background-color: #e3f2fd; 
            background-image: 
                radial-gradient(at 0% 0%, rgba(103, 58, 183, 0.1) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(33, 150, 243, 0.1) 0px, transparent 50%);
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            display: flex;
            align-items: center;
        }

        .login-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 2px 14px 0 rgb(32 40 45 / 8%) !important;
            background: #ffffff;
            padding: 20px;
        }

        .brand-logo {
            width: 50px;
            height: 50px;
            background: var(--berry-purple-light);
            color: var(--berry-purple);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 28px;
        }

        .brand-name {
            font-weight: 700;
            color: #121926;
            font-size: 1.5rem;
        }

        .text-berry-title {
            color: var(--berry-purple);
            font-weight: 600;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 500;
            color: #364152;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 16px;
            border: 1px solid #d8dbe0;
            background: #fafafa;
            font-size: 0.9rem;
        }

        .form-control:focus {
            background: #fff;
            border-color: var(--berry-purple);
            box-shadow: 0 0 0 0.2rem rgba(103, 58, 183, 0.1);
        }

        .btn-berry {
            background: var(--berry-purple);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .btn-berry:hover {
            background: #5e35b1;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(103, 58, 183, 0.2);
        }

        .btn-outline-berry {
            color: var(--berry-purple);
            border: 1px solid var(--berry-purple-light);
            background: var(--berry-purple-light);
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 10px 20px;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: 0.3s;
        }

        .btn-outline-berry:hover {
            background: var(--berry-purple);
            color: white;
        }

        .alert {
            border-radius: 12px;
            font-size: 0.85rem;
            border: none;
            background-color: #ffeeee;
            color: #f44336;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
                
                <div class="card login-card">
                    <div class="card-body p-3 p-md-4">
                        
                        <div class="text-center mb-4">
                            <div class="brand-logo">
                                <i class="bi bi-collection-play-fill"></i>
                            </div>
                            <h2 class="brand-name mb-1">Halo, Selamat Datang</h2>
                            <p class="text-muted small">Masukkan kredensial Anda untuk melanjutkan</p>
                        </div>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert shadow-none py-3 mb-4 d-flex align-items-center">
                                <i class="bi bi-exclamation-circle-fill me-2"></i> 
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('/proses-login') ?>" method="post">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label class="form-label">Nama Pengguna / Alamat Email</label>
                                <input type="text" name="username" class="form-control" placeholder="admin@digilibree.id" required autofocus>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label">Kata Sandi</label>
                                    
                                </div>
                                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                            </div>

                            <button type="submit" class="btn btn-berry w-100 mb-4">
                                Masuk Sekarang
                            </button>
                        </form>

                        <div class="text-center">
                            <hr class="text-muted opacity-25">
                            <p class="small text-muted mb-3">Belum punya akun?</p>
                            <a href="<?= base_url('users/create') ?>" class="btn-outline-berry w-100">
                                Buat Akun Baru
                            </a>
                            
                            <div class="mt-4">
                                <a href="<?= base_url('restore') ?>" class="text-danger small text-decoration-none">
                                    <i class="bi bi-database"></i> Pulihkan Database Sistem
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="text-center mt-4">
                    <small class="text-muted">&copy; <?= date('Y') ?> <b>DigiLibree</b>. Dibuat dengan ❤️</small>
                </div>

            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>