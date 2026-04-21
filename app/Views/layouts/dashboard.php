<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="p-5 mb-4 bg-white rounded-5 shadow-sm border-0 position-relative overflow-hidden" style="background: linear-gradient(to right, #ffffff, #f8f9ff);">
                <div class="container-fluid py-2 position-relative" style="z-index: 2;">
                    <h1 class="display-5 fw-bold text-primary">Gaspol baca hari ini, <?= session()->get('username'); ?>! 🚀</h1>
                    <p class="col-md-8 fs-5 text-secondary">Selamat datang di <span class="fw-bold text-dark">DigiLibree</span>. Waktunya buka jendela dunia tanpa harus keluar jendela kamar. Mau nambah koleksi atau pantau transaksi? Semua ada di sini!</p>
                    <hr class="my-4 opacity-25">
                    <div class="d-flex align-items-center">
                        <span class="badge bg-soft-primary text-primary p-2 px-3 rounded-pill me-3" style="background-color: #eef2ff;">
                            <i class="bi bi-calendar3 me-2"></i><?= date('l, d F Y'); ?>
                        </span>
                        <span class="text-muted small">ID Session kamu aktif. Aman terkendali! ✅</span>
                    </div>
                </div>
                <div class="position-absolute end-0 bottom-0 opacity-10 d-none d-lg-block">
                    <i class="bi bi-rocket-takeoff-fill" style="font-size: 180px; margin-right: 20px; margin-bottom: -30px;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="m-0 font-weight-bold text-dark fw-bold"><i class="bi bi-lightning-charge-fill text-warning me-2"></i>Pintasan Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <?php if (session()->get('role') == 'admin' || session()->get('role') == 'petugas') : ?>
                        <div class="col-sm-6">
                            <a href="<?= base_url('/buku') ?>" class="btn btn-outline-primary w-100 py-3 rounded-4 border-2 shadow-none border-dashed">
                                <i class="bi bi-plus-lg d-block fs-3 mb-1"></i>
                                <span class="fw-bold">Data Buku 1</span>
                            </a>
                        </div>
                         <?php endif; ?>
                         <?php if (session()->get('role') == 'anggota' || session()->get('role') == 'petugas') : ?>
                        <div class="col-sm-6">
                            <a href="<?= base_url('/buku') ?>" class="btn btn-outline-primary w-100 py-3 rounded-4 border-2 shadow-none border-dashed">
                                <i class="bi bi-plus-lg d-block fs-3 mb-1"></i>
                                <span class="fw-bold">Pinjam Buku Baru</span>
                            </a>
                        </div>
                         <?php endif; ?>
                        <?php if (session()->get('role') == 'admin' || session()->get('role') == 'petugas') : ?>
                        <div class="col-sm-6">
                            <a href="<?= base_url('log') ?>" class="btn btn-outline-info w-100 py-3 rounded-4 border-2 shadow-none">
                                <i class="bi bi-activity d-block fs-3 mb-1"></i>
                                <span class="fw-bold">Cek Log Aktivitas</span>
                            </a>
                        </div>
                        <?php endif; ?>
                        <?php if (session()->get('role') == 'anggota' || session()->get('role') == 'petugas') : ?>
                        <div class="col-sm-6">
                            <a href="<?= base_url('peminjaman/riwayat') ?>" class="btn btn-outline-info w-100 py-3 rounded-4 border-2 shadow-none">
                                <i class="bi bi-activity d-block fs-3 mb-1"></i>
                                <span class="fw-bold">Riwayat Peminjaman</span>
                            </a>
                        </div>
                         <?php endif; ?>
                    </div>
                    <div class="mt-4 p-3 bg-light rounded-4">
                        <small class="text-muted"><i class="bi bi-info-circle me-1"></i> <strong>Tips:</strong> Jangan cuma simpan di rak, simpan juga di ingatan! 🧠</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white h-100 overflow-hidden position-relative" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;">
                <div class="card-body p-4 text-center position-relative" style="z-index: 2;">
                    <i class="bi bi-chat-quote fs-1 mb-3 opacity-50"></i>
                    <h5 class="fw-bold mb-3">Quotes Hari Ini</h5>
                    <p class="fst-italic fs-5">"Buku adalah jendela dunia, dan DigiLibree adalah kuncinya."</p>
                    <div class="mt-4 pt-4 border-top border-white border-opacity-25">
                        <small class="opacity-75">DigiLibree: Tempat di mana jempolmu bekerja untuk otakmu. ✨</small>
                    </div>
                </div>
                <div class="position-absolute top-0 start-0 translate-middle bg-white opacity-10 rounded-circle" style="width: 200px; height: 200px;"></div>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>