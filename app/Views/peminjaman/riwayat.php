<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-5" style="background-color: #f4f7fe; min-height: 100vh;">
    
    <div class="row mb-5">
        <div class="col-md-8 mx-auto text-center">
            <div class="d-inline-block p-3 bg-white rounded-circle shadow-sm mb-3">
                <i class="bi bi-journal-check text-primary display-6"></i>
            </div>
            <h2 class="fw-bold text-dark mb-1" style="letter-spacing: -1px;">Riwayat Membaca Kamu 📚</h2>
            <p class="text-muted">Setiap buku yang kamu baca adalah satu langkah menuju pengetahuan baru.</p>
        </div>
    </div>

    <div class="container">
        <div class="row g-4 justify-content-center">
            <?php if (empty($riwayat)) : ?>
                <div class="col-md-6 text-center py-5">
                    <div class="card border-0 shadow-sm rounded-5 p-5 bg-white">
                        <i class="bi bi-emoji-smile text-light-gray display-1 mb-3"></i>
                        <h4 class="fw-bold text-muted">Wah, rak bukumu masih kosong!</h4>
                        <p class="text-muted small mb-4">Mari buat petualangan pertamamu hari ini.</p>
                        <a href="<?= base_url('buku') ?>" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">Jelajahi Perpustakaan</a>
                    </div>
                </div>
            <?php else : ?>
                <?php foreach ($riwayat as $r) : ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card-history border-0 shadow-sm rounded-5 overflow-hidden bg-white h-100">
                            <div class="d-flex h-100">
                                
                                <div class="history-cover d-flex align-items-center justify-content-center <?= $r['status'] == 'dipinjam' ? 'bg-primary' : 'bg-success' ?>">
                                    <div class="text-center text-white">
                                        <i class="bi bi-book-half display-6 opacity-50"></i>
                                        <div class="small fw-bold opacity-75 mt-2 ls-1">READ</div>
                                    </div>
                                </div>
                                
                                <div class="p-4 flex-grow-1 d-flex flex-column">
                                    <div class="mb-auto">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <span class="badge rounded-pill px-3 py-1 shadow-none <?= $r['status'] == 'dipinjam' ? 'bg-warning-soft text-warning' : 'bg-success-soft text-success' ?>" style="font-size: 0.65rem; font-weight: 800; text-uppercase;">
                                                <i class="bi <?= $r['status'] == 'dipinjam' ? 'bi-hourglass-split' : 'bi-check-circle-fill' ?> me-1"></i>
                                                <?= $r['status'] ?>
                                            </span>
                                        </div>
                                        <h5 class="fw-bold text-dark text-limit-2 mb-1" title="<?= $r['judul'] ?>"><?= $r['judul'] ?></h5>
                                        <p class="text-muted extra-small fw-semibold mb-3">ID: #<?= str_pad($r['id_buku'], 4, '0', STR_PAD_LEFT) ?></p>
                                    </div>

                                    <div class="mt-3 pt-3 border-top border-light">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="icon-box-sm bg-light text-muted me-2"><i class="bi bi-calendar-event"></i></div>
                                            <div class="small">
                                                <div class="text-muted extra-small fw-bold text-uppercase opacity-50">Tgl Pinjam</div>
                                                <div class="fw-bold text-dark"><?= date('d M Y', strtotime($r['tanggal_pinjam'])) ?></div>
                                            </div>
                                        </div>

                                        <?php if ($r['status'] == 'kembali') : ?>
                                            <div class="d-flex align-items-center">
                                                <div class="icon-box-sm bg-success-soft text-success me-2"><i class="bi bi-calendar-check"></i></div>
                                                <div class="small">
                                                    <div class="text-muted extra-small fw-bold text-uppercase opacity-50">Selesai Baca</div>
                                                    <div class="fw-bold text-success"><?= date('d M Y', strtotime($r['tanggal_pengembalian_asli'])) ?></div>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <div class="d-flex align-items-center">
                                                <div class="icon-box-sm bg-danger-soft text-danger me-2"><i class="bi bi-calendar-x"></i></div>
                                                <div class="small">
                                                    <div class="text-muted extra-small fw-bold text-uppercase opacity-50">Harus Kembali</div>
                                                    <div class="fw-bold text-danger"><?= date('d M Y', strtotime($r['tanggal_kembali'])) ?></div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
    
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
    .ls-1 { letter-spacing: 1px; }
    .extra-small { font-size: 0.65rem; }
    .text-limit-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 3rem; }
    .text-light-gray { color: #e2e8f0; }

    /* Soft Colors */
    .bg-warning-soft { background-color: #fffbeb; }
    .bg-success-soft { background-color: #f0fdf4; }
    .bg-danger-soft { background-color: #fef2f2; }

    /* History Card */
    .card-history { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border: 1px solid transparent; }
    .card-history:hover { 
        transform: translateY(-8px); 
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08) !important; 
        border-color: #e2e8f0;
    }

    .history-cover { width: 100px; min-height: 220px; transition: all 0.3s; }
    .card-history:hover .history-cover { width: 110px; }

    /* Icon Box */
    .icon-box-sm { 
        width: 28px; 
        height: 28px; 
        border-radius: 8px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-size: 0.8rem;
    }

    /* Custom Responsive */
    @media (max-width: 576px) {
        .history-cover { width: 80px; }
        .card-history:hover .history-cover { width: 80px; }
    }
</style>

<?= $this->endSection() ?>