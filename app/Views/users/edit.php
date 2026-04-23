<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-5" style="background-color: #f4f7fe; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            
            <div class="d-flex align-items-center mb-5 animate-fade-in">
                <a href="<?= base_url('users') ?>" class="btn btn-white rounded-circle shadow-sm me-3 d-flex align-items-center justify-content-center back-btn" style="width: 48px; height: 48px;">
                    <i class="bi bi-arrow-left text-primary fs-5"></i>
                </a>
                <div>
                    <h2 class="fw-bold text-dark mb-0" style="letter-spacing: -1.5px;">Pengaturan Profil</h2>
                    <p class="text-muted small mb-0">Kelola informasi pribadi dan pengaturan keamanan akun Anda</p>
                </div>
            </div>

            <div class="card border-0 shadow-lg rounded-5 overflow-hidden bg-white main-profile-card">
                <div class="card-body p-0">
                    <form action="<?= base_url('users/update/' . $user['id']) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        
                        <div class="profile-header-bg"></div>

                        <div class="px-4 px-md-5">
                            <div class="row">
                                <div class="col-md-4 mt-n5 mb-4 text-center">
                                    <div class="avatar-wrapper position-relative d-inline-block shadow-lg rounded-circle p-1 bg-white">
                                        <?php if ($user['foto']): ?>
                                            <img src="<?= base_url('uploads/users/' . $user['foto']) ?>" 
                                                 id="img-preview"
                                                 class="rounded-circle border border-4 border-white shadow-inner" 
                                                 style="width: 170px; height: 170px; object-fit: cover; display: block;">
                                        <?php else: ?>
                                            <div id="img-placeholder" 
                                                 class="rounded-circle bg-light d-flex align-items-center justify-content-center border border-4 border-white mx-auto" 
                                                 style="width: 170px; height: 170px;">
                                                <i class="bi bi-person-fill text-secondary opacity-50" style="font-size: 5.5rem;"></i>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <label for="foto" class="btn btn-primary rounded-circle position-absolute d-flex align-items-center justify-content-center shadow-lg camera-trigger" 
                                               style="width: 45px; height: 45px; bottom: 8px; right: 8px; border: 4px solid #fff; cursor: pointer;">
                                            <i class="bi bi-camera-fill"></i>
                                        </label>
                                        <input type="file" name="foto" id="foto" class="d-none" accept="image/*" onchange="previewImage()">
                                    </div>
                                    
                                    <div class="mt-4 animate-up">
                                        <h4 class="fw-bold text-dark mb-1"><?= $user['nama'] ?></h4>
                                        <p class="text-primary fw-semibold small mb-2">@<?= $user['username'] ?></p>
                                        <div class="d-flex justify-content-center">
                                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-4 py-2 fw-bold shadow-sm" style="font-size: 0.7rem; text-uppercase; letter-spacing: 1.5px; border: 1px solid rgba(13, 110, 253, 0.1);">
                                                <i class="bi bi-shield-lock-fill me-2"></i><?= $user['role'] ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-8 py-lg-5 py-4 pb-5">
                                    <div class="row g-4">
                                        <div class="col-12">
                                            <label class="form-label fw-bold text-dark small text-uppercase ls-1 ms-1">Nama Lengkap</label>
                                            <div class="input-group-custom">
                                                <i class="bi bi-person icon-left text-primary"></i>
                                                <input type="text" name="nama" class="form-control-custom" value="<?= $user['nama'] ?>" required placeholder="Masukkan nama lengkap">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-dark small text-uppercase ls-1 ms-1">Alamat Email</label>
                                            <div class="input-group-custom">
                                                <i class="bi bi-envelope icon-left text-primary"></i>
                                                <input type="email" name="email" class="form-control-custom" value="<?= $user['email'] ?>" required placeholder="email@contoh.com">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-dark small text-uppercase ls-1 ms-1">Username</label>
                                            <div class="input-group-custom">
                                                <i class="bi bi-at icon-left text-primary"></i>
                                                <input type="text" name="username" class="form-control-custom" value="<?= $user['username'] ?>" required placeholder="username_kamu">
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="p-4 rounded-4 bg-light bg-opacity-50 border border-dashed">
                                                <label class="form-label fw-bold text-dark small text-uppercase ls-1">Keamanan Akun</label>
                                                <p class="text-muted extra-small mb-3">Isi password baru hanya jika ingin mengganti password saat ini.</p>
                                                <div class="input-group-custom bg-white">
                                                    <i class="bi bi-key icon-left text-primary"></i>
                                                    <input type="password" name="password" class="form-control-custom" placeholder="••••••••••••">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label fw-bold text-dark small text-uppercase ls-1 ms-1">Hak Akses Sistem</label>
                                            <div class="input-group-custom">
                                                <i class="bi bi-layers icon-left text-primary"></i>
                                                <select name="role" class="form-select-custom">
                                                    <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Administrator</option>
                                                    <option value="petugas" <?= $user['role'] == 'petugas' ? 'selected' : '' ?>>Petugas Perpustakaan</option>
                                                    <option value="anggota" <?= $user['role'] == 'anggota' ? 'selected' : '' ?>>Anggota Aktif</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-5 d-flex flex-column flex-sm-row gap-3">
                                        <button type="submit" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow-lg transition-hover flex-grow-1 flex-sm-grow-0">
                                            <i class="bi bi-check-circle-fill me-2"></i> Simpan Perubahan
                                        </button>
                                        <a href="<?= base_url('users') ?>" class="btn btn-light rounded-pill px-5 py-3 fw-bold text-muted border flex-grow-1 flex-sm-grow-0">
                                            Batalkan
                                        </a>
                                    </div>
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
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
    
    body { font-family: 'Plus Jakarta Sans', sans-serif; letter-spacing: -0.2px; }
    
    .profile-header-bg {
        background: linear-gradient(135deg, #4f46e5 0%, #0d6efd 100%);
        height: 140px;
        position: relative;
    }

    .ls-1 { letter-spacing: 0.5px; }
    .extra-small { font-size: 0.75rem; }
    .mt-n5 { margin-top: -95px !important; }

    /* Custom Form Styling */
    .input-group-custom {
        position: relative;
        display: flex;
        align-items: center;
        background: #f8faff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        transition: all 0.3s ease;
    }

    .input-group-custom:focus-within {
        background: #fff;
        border-color: #0d6efd;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
    }

    .form-control-custom, .form-select-custom {
        width: 100%;
        padding: 12px 16px 12px 48px;
        border: none;
        background: transparent;
        outline: none;
        font-weight: 500;
        color: #1e293b;
    }

    .form-select-custom {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 16px 12px;
    }

    .icon-left {
        position: absolute;
        left: 18px;
        font-size: 1.1rem;
    }

    /* Buttons & Actions */
    .btn-white { background: #fff; color: #0d6efd; }
    .back-btn:hover { transform: translateX(-5px); background: #0d6efd; color: #fff !important; }
    
    .camera-trigger:hover { transform: scale(1.1); }
    
    .transition-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .transition-hover:hover { transform: translateY(-3px); box-shadow: 0 12px 24px rgba(13, 110, 253, 0.25) !important; }

    /* Animations */
    .animate-up { animation: slideUp 0.6s ease-out; }
    .animate-fade-in { animation: fadeIn 0.8s ease-out; }
    
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .avatar-wrapper img { transition: all 0.4s ease; }
    .avatar-wrapper:hover img { transform: scale(1.03); }
</style>

<script>
    function previewImage() {
        const foto = document.querySelector('#foto');
        const avatarWrapper = document.querySelector('.avatar-wrapper');
        const existingImg = document.querySelector('#img-preview');
        const placeholder = document.querySelector('#img-placeholder');
        
        if (foto.files && foto.files[0]) {
            const reader = new FileReader();
            reader.readAsDataURL(foto.files[0]);

            reader.onload = function(e) {
                if(placeholder) {
                    const newImg = document.createElement('img');
                    newImg.id = "img-preview";
                    newImg.className = "rounded-circle border border-4 border-white shadow-inner";
                    newImg.style = "width: 170px; height: 170px; object-fit: cover; display: block;";
                    newImg.src = e.target.result;
                    placeholder.replaceWith(newImg);
                } else {
                    existingImg.src = e.target.result;
                }
            }
        }
    }
</script>

<?= $this->endSection() ?>