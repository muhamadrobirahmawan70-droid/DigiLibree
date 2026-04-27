<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User | DigiLibree</title>

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            /* Samakan background gradient dengan halaman Login */
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }

        .container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-create {
            border: none;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2) !important;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .brand-logo {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-size: 30px;
            box-shadow: 0 10px 20px rgba(118, 75, 162, 0.2);
        }

        .form-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #636e72;
            font-weight: 700;
        }

        .form-control, .form-select {
            border-radius: 12px;
            padding: 10px 15px;
            border: 2px solid #edf2f7;
            background: #f8fafc;
            transition: all 0.3s;
            font-size: 0.9rem;
        }

        .form-control:focus, .form-select:focus {
            background: #fff;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .input-group-text {
            border-radius: 12px 0 0 12px;
            border: 2px solid #edf2f7;
            border-right: none;
            background-color: #f8fafc;
            color: #764ba2;
        }

        .input-group .form-control {
            border-radius: 0 12px 12px 0;
        }

        .btn-simpan {
            background: linear-gradient(to right, #667eea, #764ba2);
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 700;
            text-transform: uppercase;
            color: white;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .btn-simpan:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
            opacity: 0.9;
            color: white;
        }

        .alert {
            border-radius: 15px;
            font-size: 0.85rem;
            border: none;
        }

        .avatar-preview {
            width: 70px;
            height: 70px;
            background: rgba(118, 75, 162, 0.1);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            color: #764ba2;
            border: 2px dashed #764ba2;
        }

        .text-primary { color: #764ba2 !important; }
    </style>
</head>

<body>

    <div class="container py-5">
        <div class="row justify-content-center w-100">
            <div class="col-md-8 col-lg-5">
                
                <div class="card card-create p-3 p-md-4">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <div class="brand-logo">
                                <i class="bi bi-person-plus-fill"></i>
                            </div>
                            <h3 class="fw-800 mb-1" style="color: #2d3436; font-weight: 800; letter-spacing: -1px;">Registrasi</h3>
                            <p class="text-muted small">Lengkapi data untuk akses DigiLibree</p>
                        </div>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger shadow-sm">
                                <i class="bi bi-x-circle-fill me-2"></i> <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('users/store') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>

                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" placeholder="Nama sesuai identitas" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="nama@mail.com" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control" placeholder="username" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Role Akses</label>
                                <select name="role" class="form-select" required>
                                    <option value="" selected disabled>-- Pilih Hak Akses --</option>
                                    
                                    <option value="anggota">Anggota / Siswa</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Foto Profil <span class="text-muted fw-normal">(Opsional)</span></label>
                                <input type="file" name="foto" class="form-control" accept="image/*">
                                <div class="form-text mt-1" style="font-size: 0.7rem;">
                                    <i class="bi bi-info-circle me-1"></i> JPG/PNG (Max. 2MB)
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-simpan">
                                    Daftar Sekarang <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                                <a href="<?= base_url('login') ?>" class="btn btn-link text-decoration-none btn-sm mt-2 text-muted">
                                    Sudah punya akun? <span class="text-primary fw-bold">Masuk di sini</span>
                                </a>
                            </div>

                        </form>
                    </div>
                </div>

                <div class="text-center mt-4 text-white small opacity-75">
                    &copy; <?= date('Y') ?> <strong>DigiLibree Team</strong>.
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>