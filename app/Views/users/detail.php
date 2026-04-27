<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container py-5" style="background-color: #f8f9ff; min-height: 100vh;">
    <div class="row justify-content-center g-4">
        
        <div class="col-lg-5 col-xl-4">
            <div class="sticky-top" style="top: 20px;">
                <h5 class="fw-bold text-dark mb-3 ps-2">Kartu Anggota Digital 💳</h5>
                
                <div class="member-card-gradient shadow-lg position-relative overflow-hidden animate-fade-in">
                    <div class="card-circle-1"></div>
                    <div class="card-circle-2"></div>
                    
                    <div class="card-content p-4 text-white">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <h6 class="fw-bold mb-0" style="letter-spacing: 2px;">BERRY LIBRARY</h6>
                                <small class="opacity-75">Electronic Member Card</small>
                            </div>
                            <i class="bi bi-wifi fs-4 opacity-50"></i>
                        </div>

                        <div class="row align-items-center g-3">
                            <div class="col-auto">
                                <div class="bg-white p-1 rounded-3 shadow">
                                    <?php if ($user['foto']): ?>
                                        <img src="<?= base_url('uploads/users/' . $user['foto']) ?>" 
                                             class="rounded-2" style="width: 85px; height: 110px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="rounded-2 bg-light d-flex align-items-center justify-content-center" style="width: 85px; height: 110px;">
                                            <i class="bi bi-person-fill text-muted fs-1"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col">
                                <h5 class="fw-bold mb-1 text-uppercase ls-1"><?= $user['nama'] ?></h5>
                                <p class="mb-2 extra-small fw-medium opacity-90 font-monospace">
                                    ID: BRY-<?= str_pad($user['id'], 5, '0', STR_PAD_LEFT) ?>
                                </p>
                                <div class="badge bg-white text-purple-berry rounded-pill px-3 py-1 extra-small fw-bold">
                                    <i class="bi bi-patch-check-fill me-1"></i> <?= strtoupper($user['role']) ?>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-between align-items-end">
                            <div class="extra-small">
                                <p class="opacity-75 mb-0">Member Since</p>
                                <p class="fw-bold mb-0">2024</p> </div>
                            <div class="bg-white p-2 rounded-2 shadow-sm">
                                <i class="bi bi-qr-code text-dark fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 d-grid gap-2">
                    <?php if (session()->get('role') == 'admin') : ?>
                    <a href="<?= base_url('users') ?>" class="btn btn-light rounded-pill fw-bold text-muted border py-2">
                        <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar
                    </a>
                     <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-5 animate-fade-in" style="animation-delay: 0.1s;">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold text-dark mb-0">Detail Informasi</h4>
                        <?php if (session()->get('role') == 'admin' || session()->get('id') == $user['id']) : ?>
                            <a href="<?= base_url('users/edit/' . $user['id']) ?>" class="btn btn-warning rounded-pill px-4 fw-bold shadow-sm">
                                <i class="bi bi-pencil-square me-2"></i> Edit Profil
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="text-muted small text-uppercase fw-bold ls-1">Nama Lengkap</label>
                            <p class="fs-5 fw-semibold text-dark border-bottom pb-2"><?= $user['nama'] ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small text-uppercase fw-bold ls-1">Alamat Email</label>
                            <p class="fs-5 fw-semibold text-dark border-bottom pb-2"><?= $user['email'] ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small text-uppercase fw-bold ls-1">Username</label>
                            <p class="fs-5 fw-semibold text-dark border-bottom pb-2">@<?= $user['username'] ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small text-uppercase fw-bold ls-1">Hak Akses</label>
                            <p class="fs-5 fw-semibold text-dark border-bottom pb-2">
                                <span class="badge bg-purple-soft text-purple-berry px-3 rounded-pill"><?= ucfirst($user['role']) ?></span>
                            </p>
                        </div>
                        <div class="col-12">
                            <label class="text-muted small text-uppercase fw-bold ls-1">Password</label>
                            <p class="fs-5 fw-semibold text-dark border-bottom pb-2 text-muted small italic">******** <small class="ms-2 text-muted opacity-50">(Encrypted)</small></p>
                        </div>
                    </div>

                    <div class="alert alert-info border-0 rounded-4 mt-5 d-flex align-items-center">
                        <i class="bi bi-info-circle-fill fs-4 me-3"></i>
                        <small>Data ini bersifat rahasia dan hanya dapat diubah oleh pemilik akun atau administrator sistem.</small>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
    
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
    .text-purple-berry { color: #673ab7 !important; }
    .bg-purple-soft { background-color: rgba(103, 58, 183, 0.1); }
    .ls-1 { letter-spacing: 1px; }
    .extra-small { font-size: 0.75rem; }
    .rounded-5 { border-radius: 2rem !important; }

    /* Card Gradient Style */
    .member-card-gradient {
        background: linear-gradient(135deg, #673ab7 0%, #9c27b0 100%);
        border-radius: 24px;
        min-height: 240px;
        z-index: 1;
    }

    .card-circle-1 {
        position: absolute;
        width: 180px;
        height: 180px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        top: -40px;
        right: -40px;
        z-index: -1;
    }

    .card-circle-2 {
        position: absolute;
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        bottom: -20px;
        left: -20px;
        z-index: -1;
    }

    /* Animation */
    .animate-fade-in {
        animation: fadeIn 0.6s ease-out forwards;
        opacity: 0;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .btn-warning { background: #ffc107; color: #000; border: none; transition: 0.3s; }
    .btn-warning:hover { transform: scale(1.05); background: #ffca2c; }
</style>

<?= $this->endSection() ?>