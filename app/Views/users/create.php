<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User | DigiLibree</title>

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/bootstrap-icons-1.13.1/bootstrap-icons.css') ?>" rel="stylesheet">
    
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card-create {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }
        .form-control, .form-select {
            border-radius: 10px;
            padding: 10px 15px;
            border: 1px solid #dee2e6;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 0.25 mil rem rgba(13, 110, 253, 0.1);
            border-color: #0d6efd;
        }
        .btn-simpan {
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-simpan:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-primary"><i class="bi bi-person-plus-fill me-2"></i>DigiLibree<span class="text-dark">App</span></h3>
                    <p class="text-muted">Buat akun baru untuk bergabung di perpustakaan digital</p>
                </div>

                <div class="card card-create p-4">
                    <div class="card-body">
                        <h5 class="fw-bold mb-4 text-center">Form Registrasi User</h5>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger border-0 rounded-3 mb-4">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('users/store') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="email@contoh.com" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Username</label>
                                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="password" class="form-control border-start-0" placeholder="Minimal 6 karakter" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Role User</label>
                                <select name="role" class="form-select" required>
                                    <option value="" selected disabled>-- Pilih Hak Akses --</option>
                                    <option value="admin">Admin (Full Akses)</option>
                                    <option value="petugas">Petugas (Kelola Buku)</option>
                                    <option value="anggota">Anggota (Peminjam)</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Foto Profil</label>
                                <input type="file" name="foto" class="form-control" accept="image/*">
                                <div class="form-text text-muted"><i class="bi bi-info-circle me-1"></i>Format JPG/PNG, maksimal 2MB.</div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-simpan">
                                    <i class="bi bi-check-circle me-2"></i>Daftar Sekarang
                                </button>
                                <a href="<?= base_url('login') ?>" class="btn btn-link text-decoration-none text-muted btn-sm">
                                    Sudah punya akun? <span class="text-primary fw-bold">Masuk di sini</span>
                                </a>
                            </div>

                        </form>
                    </div>
                </div>

                <div class="text-center mt-4 text-muted small">
                    &copy; <?= date('Y') ?> DigiLibree App. Crafted with <i class="bi bi-heart-fill text-danger"></i>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>