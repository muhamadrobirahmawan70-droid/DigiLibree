<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="p-5 mb-4 bg-white rounded-5 shadow-sm border-0 position-relative overflow-hidden" style="background: linear-gradient(to right, #ffffff, #f8f9ff);">
                <div class="container-fluid py-2 position-relative" style="z-index: 2;">
                    <h1 class="display-5 fw-bold text-primary">Gaspol baca hari ini, <?= session()->get('username'); ?>! 🚀</h1>
                    <p class="col-md-8 fs-5 text-secondary">Akses dashboard <span class="badge bg-primary text-uppercase" style="font-size: 0.9rem;"><?= session()->get('role'); ?></span> DigiLibree.</p>
                    <hr class="my-4 opacity-25">
                    <div class="d-flex align-items-center">
                        <span class="badge bg-soft-primary text-primary p-2 px-3 rounded-pill me-3" style="background-color: #eef2ff;">
                            <i class="bi bi-calendar3 me-2"></i><?= date('l, d F Y'); ?>
                        </span>
                        <span class="text-muted small">Sistem sinkron otomatis. Aman terkendali! ✅</span>
                    </div>
                </div>
                <div class="position-absolute end-0 bottom-0 opacity-10 d-none d-lg-block">
                    <i class="bi bi-rocket-takeoff-fill" style="font-size: 180px; margin-right: 20px; margin-bottom: -30px;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4 g-3">
        <?php if (session()->get('role') == 'admin' || session()->get('role') == 'petugas') : ?>
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-primary border-5 h-100">
                    <p class="text-muted small mb-1 fw-bold text-uppercase">Total Koleksi</p>
                    <h4 class="fw-bold mb-0"><?= number_format($total_buku); ?> <span class="fs-6 fw-normal text-muted">Buku</span></h4>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-success border-5 h-100">
                    <p class="text-muted small mb-1 fw-bold text-uppercase">Peminjaman Aktif</p>
                    <h4 class="fw-bold mb-0"><?= number_format($total_pinjam); ?> <span class="fs-6 fw-normal text-muted">Trx</span></h4>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-warning border-5 h-100">
                    <p class="text-muted small mb-1 fw-bold text-uppercase">Total Member</p>
                    <h4 class="fw-bold mb-0"><?= number_format($total_member); ?> <span class="fs-6 fw-normal text-muted">User</span></h4>
                </div>
            </div>
            

        <?php else : ?>
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-primary border-5 h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                            <i class="bi bi-book text-primary fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-0 fw-bold">Buku Tersedia</p>
                            <h4 class="fw-bold mb-0"><?= number_format($total_buku); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-success border-5 h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 p-2 rounded-3 me-3">
                            <i class="bi bi-journal-check text-success fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-0 fw-bold">Saya Pinjam</p>
                            <h4 class="fw-bold mb-0"><?= number_format($my_pinjam); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 border-start border-info border-5 h-100">
                    <div class="d-flex align-items-center">
                        <div class="bg-info bg-opacity-10 p-2 rounded-3 me-3">
                            <i class="bi bi-clock-history text-info fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-0 fw-bold">Riwayat</p>
                            <h4 class="fw-bold mb-0"><?= number_format($my_history); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
           
        <?php endif; ?>
    </div>
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white py-4 border-0 px-4">
                    <h6 class="m-0 font-weight-bold text-dark fw-bold"><i class="bi bi-lightning-charge-fill text-warning me-2"></i>Akses Navigasi</h6>
                </div>
                <div class="card-body px-4">
                    <div class="row g-3">
                        <?php if (session()->get('role') == 'admin' || session()->get('role') == 'petugas') : ?>
                            <div class="col-sm-6">
                                <a href="<?= base_url('/buku') ?>" class="btn btn-outline-primary border-dashed w-100 py-4 rounded-4 shadow-none text-start px-4">
                                    <i class="bi bi-collection-play d-block fs-2 mb-2"></i>
                                    <span class="fw-bold">Manajemen Buku</span>
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <a href="<?= base_url('users') ?>" class="btn btn-outline-dark w-100 py-4 rounded-4 shadow-none text-start px-4">
                                    <i class="bi bi-people d-block fs-2 mb-2"></i>
                                    <span class="fw-bold">Manajemen User</span>
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <a href="<?= base_url('log') ?>" class="btn btn-outline-secondary w-100 py-4 rounded-4 shadow-none text-start px-4">
                                    <i class="bi bi-clock-history d-block fs-2 mb-2"></i>
                                    <span class="fw-bold">Log Aktivitas</span>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (session()->get('role') == 'anggota') : ?>
                            <div class="col-sm-6">
                                <a href="<?= base_url('/buku') ?>" class="btn btn-primary w-100 py-4 rounded-4 shadow-sm border-0 text-start px-4" style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);">
                                    <i class="bi bi-search d-block fs-2 mb-2 text-white"></i>
                                    <span class="fw-bold text-white">Cari & Pinjam Buku</span>
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <a href="<?= base_url('peminjaman/riwayat') ?>" class="btn btn-outline-info w-100 py-4 rounded-4 shadow-none border-2 text-start px-4">
                                    <i class="bi bi-journal-text d-block fs-2 mb-2"></i>
                                    <span class="fw-bold">Riwayat Pinjaman</span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white h-100 overflow-hidden position-relative" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;">
                <div class="card-body p-4 text-center d-flex flex-column justify-content-center position-relative" style="z-index: 2;">
                    <i class="bi bi-chat-quote fs-1 mb-3 opacity-50"></i>
                    <h5 class="fw-bold mb-3">Quotes Hari Ini</h5>
                    <p class="fst-italic fs-5">"Buku adalah jendela dunia, dan DigiLibree adalah kuncinya."</p>
                    <div class="mt-4 pt-4 border-top border-white border-opacity-25 text-start">
                        <small class="opacity-75"><i class="bi bi-info-circle me-1"></i> Dashboard dipersonalisasi khusus untuk kenyamanan kamu. ✨</small>
                    </div>
                </div>
                <div class="position-absolute top-0 start-0 translate-middle bg-white opacity-10 rounded-circle" style="width: 200px; height: 200px;"></div>
            </div>
        </div>
    </div>

</div>

<style>
    .btn { transition: all 0.3s ease; }
    .btn:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    .border-dashed { border-style: dashed !important; border-width: 2px !important; }
</style>
<?= $this->endSection() ?>