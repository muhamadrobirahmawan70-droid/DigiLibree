<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-5" style="background-color: #f4f7fe; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            
            <div class="d-flex align-items-center mb-4">
                <a href="<?= base_url('users') ?>" class="btn btn-white rounded-circle shadow-sm me-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                    <i class="bi bi-chevron-left text-primary fw-bold"></i>
                </a>
                <div>
                    <h2 class="fw-bold text-dark mb-0" style="letter-spacing: -1px;">Pengaturan Profil</h2>
                    <p class="text-muted small mb-0">Perbarui identitas dan hak akses akun</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-5 overflow-hidden bg-white">
                <div class="card-body p-0">
                    <form action="<?= base_url('users/update/' . $user['id']) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        
                        <div class="bg-primary bg-gradient" style="height: 120px; opacity: 0.9;"></div>

                        <div class="px-4 px-md-5">
                            <div class="row">
                                <div class="col-md-4 mt-n5 mb-4 mb-md-5 text-center">
                                    <div class="position-relative d-inline-block shadow-lg rounded-circle p-1 bg-white" style="margin-top: -20px;">
                                        <?php if ($user['foto']): ?>
                                            <img src="<?= base_url('uploads/users/' . $user['foto']) ?>" 
                                                 id="img-preview"
                                                 class="rounded-circle border border-4 border-white" 
                                                 style="width: 160px; height: 160px; object-fit: cover; display: block;">
                                        <?php else: ?>
                                            <div id="img-placeholder" 
                                                 class="rounded-circle bg-light d-flex align-items-center justify-content-center border border-4 border-white mx-auto" 
                                                 style="width: 160px; height: 160px;">
                                                <i class="bi bi-person-fill text-muted" style="font-size: 5rem;"></i>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <label for="foto" class="btn btn-primary rounded-circle position-absolute d-flex align-items-center justify-content-center shadow" 
                                               style="width: 42px; height: 42px; bottom: 5px; right: 5px; border: 3px solid #fff; cursor: pointer;">
                                            <i class="bi bi-camera-fill"></i>
                                        </label>
                                        <input type="file" name="foto" id="foto" class="d-none" accept="image/*" onchange="previewImage()">
                                    </div>
                                    
                                    <div class="mt-3">
                                        <h5 class="fw-bold text-dark mb-1"><?= $user['nama'] ?></h5>
                                        <p class="text-muted small mb-0">@<?= $user['username'] ?></p>
                                        <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 mt-2 fw-bold" style="font-size: 0.65rem; text-uppercase; letter-spacing: 1px;">
                                            <i class="bi bi-shield-check me-1"></i><?= $user['role'] ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-8 py-4 pb-5">
                                    <div class="row g-4">
                                        <div class="col-12">
                                            <label class="form-label fw-bold text-muted small text-uppercase ls-">Nama Lengkap</label>
                                            <div class="input-group border rounded-4 overflow-hidden bg-light border-0">
                                                <span class="input-group-text bg-transparent border-0 ps-3"><i class="bi bi-person text-primary"></i></span>
                                                <input type="text" name="nama" class="form-control bg-transparent border-0 py-2" value="<?= $user['nama'] ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-muted small text-uppercase ls-1">Email</label>
                                            <div class="input-group border rounded-4 overflow-hidden bg-light border-0">
                                                <span class="input-group-text bg-transparent border-0 ps-3"><i class="bi bi-envelope text-primary"></i></span>
                                                <input type="email" name="email" class="form-control bg-transparent border-0 py-2" value="<?= $user['email'] ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-muted small text-uppercase ls-1">Username</label>
                                            <div class="input-group border rounded-4 overflow-hidden bg-light border-0">
                                                <span class="input-group-text bg-transparent border-0 ps-3"><i class="bi bi-at text-primary"></i></span>
                                                <input type="text" name="username" class="form-control bg-transparent border-0 py-2" value="<?= $user['username'] ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label fw-bold text-muted small text-uppercase ls-1">Password Baru</label>
                                            <div class="input-group border rounded-4 overflow-hidden bg-light border-0">
                                                <span class="input-group-text bg-transparent border-0 ps-3"><i class="bi bi-lock text-primary"></i></span>
                                                <input type="password" name="password" class="form-control bg-transparent border-0 py-2" placeholder="Biarkan kosong jika tidak diganti">
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label fw-bold text-muted small text-uppercase ls-1">Role Akun</label>
                                            <div class="input-group border rounded-4 overflow-hidden bg-light border-0">
                                                <span class="input-group-text bg-transparent border-0 ps-3"><i class="bi bi-layers text-primary"></i></span>
                                                <select name="role" class="form-select bg-transparent border-0 py-2 fw-semibold">
                                                    <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                                    <option value="petugas" <?= $user['role'] == 'petugas' ? 'selected' : '' ?>>Petugas</option>
                                                    <option value="anggota" <?= $user['role'] == 'anggota' ? 'selected' : '' ?>>Anggota</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-5 d-flex gap-2">
                                        <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm transition-hover">
                                            Simpan Perubahan
                                        </button>
                                        <a href="<?= base_url('users') ?>" class="btn btn-light rounded-pill px-4 py-2 fw-bold text-muted">Batal</a>
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
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
    
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
    .ls-1 { letter-spacing: 1px; }
    .mt-n5 { margin-top: -80px !important; } /* Disesuaikan agar pas di tengah garis */
    
    .btn-white { background: #fff; border: none; }
    .btn-white:hover { background: #f8faff; color: #0d6efd; transform: scale(1.05); transition: 0.2s; }

    .input-group:focus-within {
        background-color: #fff !important;
        box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.2);
        border: 0px !important;
    }

    .transition-hover { transition: 0.3s; }
    .transition-hover:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3) !important; }

    .bg-primary-subtle { background-color: #eef4ff !important; }

    /* Fix image preview agar tetap bulat sempurna */
    #img-preview { object-fit: cover; border-radius: 50%; }

    /* Animation */
    .card { animation: fadeInScale 0.5s ease-out; }
    @keyframes fadeInScale {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
    function previewImage() {
        const foto = document.querySelector('#foto');
        const imgPreview = document.querySelector('#img-preview') || document.querySelector('#img-placeholder');
        
        if (foto.files && foto.files[0]) {
            const fileFoto = new FileReader();
            fileFoto.readAsDataURL(foto.files[0]);

            fileFoto.onload = function(e) {
                if(imgPreview.id === 'img-placeholder') {
                    const newImg = document.createElement('img');
                    newImg.className = "rounded-circle border border-4 border-white shadow";
                    newImg.style = "width: 160px; height: 160px; object-fit: cover; display: block;";
                    newImg.id = "img-preview";
                    newImg.src = e.target.result;
                    imgPreview.parentNode.replaceChild(newImg, imgPreview);
                } else {
                    imgPreview.src = e.target.result;
                }
            }
        }
    }
</script>

<?= $this->endSection() ?>