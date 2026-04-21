<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center mb-4">
                <a href="<?= base_url('users') ?>" class="btn btn-light rounded-circle shadow-sm me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <h3 class="fw-bold text-dark mb-0">Edit Profil User</h3>
                    <p class="text-muted mb-0">Perbarui informasi akun DigiLibree</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <form action="<?= base_url('users/update/' . $user['id']) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        
                        <div class="row g-4">
                            <div class="col-md-4 text-center border-end">
                                <div class="mb-3">
                                    <label class="form-label d-block fw-bold text-muted">Foto Saat Ini</label>
                                    <div class="position-relative d-inline-block">
                                        <?php if ($user['foto']): ?>
                                            <img src="<?= base_url('uploads/users/' . $user['foto']) ?>" 
                                                 class="rounded-4 shadow-sm border border-4 border-white" 
                                                 style="width: 150px; height: 150px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="rounded-4 bg-light d-flex align-items-center justify-content-center border" 
                                                 style="width: 150px; height: 150px;">
                                                <i class="bi bi-person text-muted display-4"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label for="foto" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                        <i class="bi bi-camera me-1"></i> Ganti Foto
                                    </label>
                                    <input type="file" name="foto" id="foto" class="d-none" accept="image/*">
                                    <small class="d-block text-muted mt-2" style="font-size: 0.7rem;">Format: JPG, PNG (Maks 2MB)</small>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-bold small text-muted text-uppercase">Nama Lengkap</label>
                                        <input type="text" name="nama" class="form-control bg-light border-0 py-2" value="<?= $user['nama'] ?>" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted text-uppercase">Email</label>
                                        <input type="email" name="email" class="form-control bg-light border-0 py-2" value="<?= $user['email'] ?>" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-muted text-uppercase">Username</label>
                                        <input type="text" name="username" class="form-control bg-light border-0 py-2" value="<?= $user['username'] ?>" required>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold small text-muted text-uppercase">Password</label>
                                        <input type="password" name="password" class="form-control bg-light border-0 py-2" placeholder="Biarkan kosong jika tidak ingin mengubah">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold small text-muted text-uppercase">Role / Hak Akses</label>
                                        <select name="role" class="form-select bg-light border-0 py-2">
                                            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                            <option value="petugas" <?= $user['role'] == 'petugas' ? 'selected' : '' ?>>Petugas</option>
                                            <option value="anggota" <?= $user['role'] == 'anggota' ? 'selected' : '' ?>>Anggota</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mt-5 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                                        <i class="bi bi-save me-2"></i>Simpan Perubahan
                                    </button>
                                    <a href="<?= base_url('users') ?>" class="btn btn-light rounded-pill px-4">Batal</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus, .form-select:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        border: 1px solid #0d6efd !important;
    }
    .card {
        animation: slideUp 0.5s ease-out;
    }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<?= $this->endSection() ?>