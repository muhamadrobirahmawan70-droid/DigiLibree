<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User | DigiLibree</title>

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4e73df;
            --soft-bg: #f8faff;
        }

        body {
            background-color: var(--soft-bg);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #2d3436;
        }

        .container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-create {
            border: none;
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(78, 115, 223, 0.08);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .header-app h3 {
            letter-spacing: -1px;
        }

        .form-label {
            font-size: 0.85rem;
            margin-bottom: 0.6rem;
            color: #5f6c7b;
            padding-left: 4px;
        }

        .form-control, .form-select {
            border-radius: 15px;
            padding: 12px 18px;
            border: 1.5px solid #edf2f7;
            background-color: #fcfdfe;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .form-control:focus, .form-select:focus {
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.1);
            border-color: var(--primary-color);
        }

        .input-group-text {
            border-radius: 15px 0 0 15px;
            border: 1.5px solid #edf2f7;
            border-right: none;
            background-color: #fcfdfe;
            color: #a0aec0;
        }

        .input-group .form-control {
            border-radius: 0 15px 15px 0;
        }

        .btn-simpan {
            border-radius: 18px;
            padding: 14px;
            font-weight: 700;
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            border: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-top: 10px;
        }

        .btn-simpan:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(34, 74, 190, 0.25);
            opacity: 0.9;
        }

        .alert {
            border-radius: 15px;
            font-size: 0.9rem;
        }

        .avatar-preview {
            width: 80px;
            height: 80px;
            background: #f1f5f9;
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: var(--primary-color);
            border: 2px dashed #cbd5e1;
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <div class="row justify-content-center w-100">
            <div class="col-md-7 col-lg-5">
                
                <div class="text-center mb-4 header-app">
                    <h3 class="fw-800 text-primary mb-1">
                        <i class="bi bi-box-seam-fill me-2"></i>DigiLibree<span class="text-dark">App</span>
                    </h3>
                    <p class="text-muted small px-4">Bergabunglah dengan komunitas pembaca digital kami dan akses ribuan koleksi buku</p>
                </div>

                <div class="card card-create p-2 p-md-4">
                    <div class="card-body">
                        <div class="avatar-preview">
                            <i class="bi bi-person-plus fs-2"></i>
                        </div>
                        <h5 class="fw-800 mb-4 text-center">Registrasi Anggota</h5>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger border-0 shadow-sm mb-4">
                                <i class="bi bi-shield-exclamation me-2"></i> <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('users/store') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" placeholder="Contoh: Andi Wijaya" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="andi@mail.com" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Username</label>
                                    <input type="text" name="username" class="form-control" placeholder="andi_123" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                                    <input type="password" name="password" class="form-control" placeholder="Kombinasi angka & huruf" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Role Akses</label>
                                <select name="role" class="form-select" required>
                                    <option value="" selected disabled>-- Pilih Hak Akses --</option>
                                    <option value="admin">Administrator</option>
                                    <option value="petugas">Petugas Perpus</option>
                                    <option value="anggota">Anggota / Siswa</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Foto Profil <span class="text-muted fw-normal">(Opsional)</span></label>
                                <input type="file" name="foto" class="form-control" accept="image/*">
                                <div class="form-text mt-2" style="font-size: 0.75rem;">
                                    <i class="bi bi-info-circle-fill me-1 text-primary"></i> Gunakan foto formal format JPG/PNG (Max. 2MB)
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-simpan">
                                    <i class="bi bi-rocket-takeoff me-2"></i>Buat Akun Sekarang
                                </button>
                                <a href="<?= base_url('login') ?>" class="btn btn-link text-decoration-none text-muted btn-sm mt-2">
                                    Sudah punya akun? <span class="text-primary fw-bold border-bottom border-primary border-2">Masuk</span>
                                </a>
                            </div>

                        </form>
                    </div>
                </div>

                <div class="text-center mt-5 text-muted small opacity-75">
                    &copy; <?= date('Y') ?> <strong>DigiLibree App</strong>. <br>
                    Crafted with <i class="bi bi-heart-fill text-danger mx-1"></i> for better literacy.
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>