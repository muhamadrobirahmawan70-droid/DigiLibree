<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4" style="min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-11 col-xl-9">
            
            <div class="d-flex align-items-center mb-4 animate-fade-in">
                <a href="<?= base_url('users') ?>" class="btn btn-white rounded-circle shadow-sm me-3 d-flex align-items-center justify-content-center back-btn" style="width: 45px; height: 45px;">
                    <i class="bi bi-arrow-left text-purple-berry fs-5"></i>
                </a>
                <div>
                    <h3 class="fw-bold text-dark mb-0">Pengaturan <span class="text-purple-berry">Profil</span></h3>
                    <p class="text-muted small mb-0">Update informasi pribadi dan keamanan akun kamu di sini.</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-5 overflow-hidden bg-white main-profile-card">
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
                                                 class="rounded-circle border border-4 border-white" 
                                                 style="width: 160px; height: 160px; object-fit: cover; display: block;">
                                        <?php else: ?>
                                            <div id="img-placeholder" 
                                                 class="rounded-circle bg-light d-flex align-items-center justify-content-center border border-4 border-white mx-auto" 
                                                 style="width: 160px; height: 160px;">
                                                <i class="bi bi-person-fill text-purple-berry opacity-25" style="font-size: 5rem;"></i>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <label for="foto" class="btn btn-purple-berry rounded-circle position-absolute d-flex align-items-center justify-content-center shadow camera-trigger" 
                                               style="width: 42px; height: 42px; bottom: 5px; right: 5px; border: 3px solid #fff; cursor: pointer;">
                                            <i class="bi bi-camera-fill small"></i>
                                        </label>
                                        <input type="file" name="foto" id="foto" class="d-none" accept="image/*" onchange="previewImage()">
                                    </div>
                                    
                                    <div class="mt-3 animate-up">
                                        <h5 class="fw-bold text-dark mb-0"><?= $user['nama'] ?></h5>
                                        <p class="text-purple-berry small fw-semibold mb-3">@<?= $user['username'] ?></p>
                                        <div class="d-flex justify-content-center">
                                            <span class="badge-berry bg-purple-soft text-purple-berry fw-bold text-uppercase" style="letter-spacing: 1px;">
                                                <i class="bi bi-shield-check me-1"></i><?= $user['role'] ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-8 py-4 py-lg-5 pb-5">
                                    <div class="row g-4">
                                        <div class="col-12">
                                            <label class="form-label fw-bold text-muted extra-small text-uppercase ls-1 ms-1">Nama Lengkap</label>
                                            <div class="input-group-custom">
                                                <i class="bi bi-person icon-left text-purple-berry"></i>
                                                <input type="text" name="nama" class="form-control-custom" value="<?= $user['nama'] ?>" required placeholder="Masukkan nama lengkap">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-muted extra-small text-uppercase ls-1 ms-1">Alamat Email</label>
                                            <div class="input-group-custom">
                                                <i class="bi bi-envelope icon-left text-purple-berry"></i>
                                                <input type="email" name="email" class="form-control-custom" value="<?= $user['email'] ?>" required placeholder="email@contoh.com">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-muted extra-small text-uppercase ls-1 ms-1">Username</label>
                                            <div class="input-group-custom">
                                                <i class="bi bi-at icon-left text-purple-berry"></i>
                                                <input type="text" name="username" class="form-control-custom" value="<?= $user['username'] ?>" required placeholder="username_kamu">
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="p-4 rounded-4 bg-purple-soft-light border border-dashed border-purple-berry border-opacity-25">
                                                <label class="form-label fw-bold text-dark extra-small text-uppercase ls-1">Ubah Password</label>
                                                <p class="text-muted extra-small mb-3">Kosongkan jika tidak ingin mengganti password.</p>
                                                <div class="input-group-custom bg-white">
                                                    <i class="bi bi-key icon-left text-purple-berry"></i>
                                                    <input type="password" name="password" class="form-control-custom" placeholder="••••••••••••">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                        <label class="form-label fw-bold text-muted extra-small text-uppercase ls-1 ms-1">Hak Akses Sistem</label>
                                        <div class="input-group-custom">
                                         <i class="bi bi-layers icon-left text-purple-berry"></i>
        
                                            <?php if (session()->get('role') == 'admin') : ?>
                                            <select name="role" class="form-select-custom">
                                            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Administrator</option>
                                            <option value="petugas" <?= $user['role'] == 'petugas' ? 'selected' : '' ?>>Petugas Perpustakaan</option>
                                            <option value="anggota" <?= $user['role'] == 'anggota' ? 'selected' : '' ?>>Anggota Aktif</option>
                                            </select>
                                            <?php else : ?>
                                            <select class="form-select-custom bg-light cursor-not-allowed" disabled style="cursor: not-allowed;">
                                            <option selected><?= ucfirst($user['role']) ?></option>
                                            </select>
                                            <input type="hidden" name="role" value="<?= $user['role'] ?>">
                                            <small class="text-danger extra-small ms-2">*Hanya Admin yang dapat mengubah hak akses.</small>
                                             <?php endif; ?>
        
                                            </div>
                                            </div>

                                    <div class="mt-5 d-flex gap-3">
                                        <button type="submit" class="btn btn-purple-berry rounded-pill px-5 py-2 fw-bold shadow-sm flex-grow-1 flex-sm-grow-0">
                                            Simpan Profil
                                        </button>
                                        <a href="<?= base_url('users') ?>" class="btn btn-light rounded-pill px-5 py-2 fw-bold text-muted border flex-grow-1 flex-sm-grow-0">
                                            Batal
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
    .text-purple-berry { color: #673ab7; }
    .btn-purple-berry { background: #673ab7; color: white; border: none; }
    .btn-purple-berry:hover { background: #5e35b1; color: white; transform: translateY(-2px); }
    
    .profile-header-bg {
        background: linear-gradient(45deg, #673ab7 0%, #9575cd 100%);
        height: 120px;
    }

    .bg-purple-soft { background: #f3e5f5; }
    .bg-purple-soft-light { background: #f9f6ff; }
    .badge-berry { padding: 6px 16px; border-radius: 10px; font-size: 0.7rem; }
    
    .extra-small { font-size: 0.65rem; }
    .ls-1 { letter-spacing: 1px; }
    .mt-n5 { margin-top: -80px !important; }

    /* Input Styling */
    .input-group-custom {
        position: relative;
        background: #f8f9fa;
        border: 1px solid #eee;
        border-radius: 12px;
        transition: 0.3s;
    }
    .input-group-custom:focus-within {
        background: #fff;
        border-color: #673ab7;
        box-shadow: 0 0 0 3px rgba(103, 58, 183, 0.1);
    }
    .form-control-custom, .form-select-custom {
        width: 100%;
        padding: 10px 15px 10px 45px;
        border: none;
        background: transparent;
        outline: none;
        font-size: 0.9rem;
    }
    .icon-left { position: absolute; left: 15px; top: 12px; font-size: 1.1rem; }

    .btn-white { background: #fff; color: #673ab7; border: 1px solid #eee; }
    .back-btn:hover { background: #673ab7; color: #fff !important; }
    
    .main-profile-card { border-radius: 1.5rem !important; }
    .rounded-4 { border-radius: 1rem !important; }
    .rounded-5 { border-radius: 1.5rem !important; }

    /* Animations */
    @keyframes slideUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-up { animation: slideUp 0.5s ease-out; }
</style>

<script>
    function previewImage() {
        const foto = document.querySelector('#foto');
        const imgPreview = document.querySelector('#img-preview');
        const placeholder = document.querySelector('#img-placeholder');
        
        if (foto.files && foto.files[0]) {
            const reader = new FileReader();
            reader.readAsDataURL(foto.files[0]);
            reader.onload = function(e) {
                if(placeholder) {
                    const newImg = document.createElement('img');
                    newImg.id = "img-preview";
                    newImg.className = "rounded-circle border border-4 border-white";
                    newImg.style = "width: 160px; height: 160px; object-fit: cover; display: block;";
                    newImg.src = e.target.result;
                    placeholder.replaceWith(newImg);
                } else {
                    imgPreview.src = e.target.result;
                }
            }
        }
    }
</script>

<?= $this->endSection() ?>