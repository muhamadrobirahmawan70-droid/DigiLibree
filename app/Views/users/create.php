<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun | DigiLibree</title>

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --berry-purple: #673ab7;
            --berry-purple-light: #ede7f6;
            --berry-blue: #2196f3;
            --berry-blue-light: #e3f2fd;
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

        .card-berry {
            border: none;
            border-radius: 16px;
            box-shadow: 0 2px 14px 0 rgb(32 40 45 / 8%) !important;
            background: #ffffff;
        }

        .brand-logo {
            width: 50px;
            height: 50px;
            background: var(--berry-blue-light);
            color: var(--berry-blue);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 26px;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #364152;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            border-radius: 10px;
            padding: 10px 16px;
            border: 1px solid #d8dbe0;
            background: #fafafa;
            font-size: 0.9rem;
            transition: all 0.3s ease-in-out;
        }

        .form-control:focus, .form-select:focus {
            background: #fff;
            border-color: var(--berry-blue);
            box-shadow: 0 0 0 0.2rem rgba(33, 150, 243, 0.1);
        }

        .input-group-text {
            background: #fafafa;
            border: 1px solid #d8dbe0;
            border-right: none;
            border-radius: 10px 0 0 10px;
            color: #697586;
        }

        .input-group .form-control {
            border-radius: 0 10px 10px 0;
        }

        .btn-berry {
            background: var(--berry-purple);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .btn-berry:hover {
            background: #5e35b1;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(103, 58, 183, 0.2);
        }

        .alert {
            border-radius: 12px;
            font-size: 0.85rem;
            border: none;
            background-color: #ffeeee;
            color: #f44336;
        }

        .login-link {
            color: var(--berry-purple);
            font-weight: 700;
            text-decoration: none;
        }

        .login-link:hover {
            text-decoration: underline;
        }

        /* Styling khusus untuk input file agar lebih rapi */
        input[type="file"]::file-selector-button {
            background: var(--berry-purple-light);
            color: var(--berry-purple);
            border: none;
            padding: 5px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.8rem;
            margin-right: 10px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <div class="row justify-content-center w-100 m-0">
            <div class="col-12 col-md-10 col-lg-7 col-xl-5">
                
                <div class="card card-berry p-2 p-md-4">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <div class="brand-logo">
                                <i class="bi bi-person-plus-fill"></i>
                            </div>
                            <h2 class="fw-bold mb-1" style="color: #121926; letter-spacing: -0.5px;">Daftar Akun</h2>
                            <p class="text-muted small">Lengkapi detail data Anda untuk bergabung</p>
                        </div>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert py-3 mb-4 d-flex align-items-center shadow-none">
                                <i class="bi bi-exclamation-circle-fill me-2"></i> 
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('users/store') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>

                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" placeholder="Contoh: Budi Santoso" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control" placeholder="username123" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kata Sandi</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                                    <input type="password" name="password" class="form-control" placeholder="Min. 8 karakter" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Level Akses</label>
                                <select name="role" class="form-select" required>
                                    <option value="" selected disabled>-- Pilih Level --</option>
                                    <option value="anggota">Anggota / Siswa</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Foto Profil <span class="text-muted fw-normal">(Opsional)</span></label>
                                <input type="file" name="foto" class="form-control" accept="image/*">
                                <div class="form-text mt-2 text-muted" style="font-size: 0.75rem;">
                                    <i class="bi bi-info-circle me-1"></i> Format: JPG, PNG (Maksimal 2MB)
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-berry mb-4">
                                    Daftar Sekarang
                                </button>
                                
                                <div class="text-center">
                                    <p class="small text-muted">
                                        Sudah memiliki akun? 
                                        <a href="<?= base_url('login') ?>" class="login-link">Masuk di sini</a>
                                    </p>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <small class="text-muted">&copy; <?= date('Y') ?> <b>DigiLibree</b>. Semua Hak Dilindungi.</small>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>