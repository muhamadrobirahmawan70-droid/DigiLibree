<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-5" style="background-color: #f8f9ff; min-height: 100vh;">
    
    <div class="row mb-5 animate-fade-in">
        <div class="col-md-8 mx-auto text-center">
            <div class="d-inline-block p-3 bg-white rounded-circle shadow-sm mb-3 border border-light">
                <i class="bi bi-clock-history text-purple-berry display-6"></i>
            </div>
            <h2 class="fw-bold text-dark mb-1" style="letter-spacing: -1.5px;">Jejak Literasi Kamu 🍇</h2>
            <p class="text-muted small">Kumpulan buku yang pernah menemani petualanganmu di DigiLibree.</p>
        </div>
    </div>

    <div class="container">
        <div class="row g-4 justify-content-center">
            <?php if (empty($riwayat)) : ?>
                <div class="col-md-6 text-center py-5 animate-fade-in">
                    <div class="card border-0 shadow-sm rounded-5 p-5 bg-white">
                        <div class="mb-4">
                            <i class="bi bi-folder2-open text-light-gray" style="font-size: 5rem;"></i>
                        </div>
                        <h4 class="fw-bold text-dark">Ups, Raknya Masih Kosong!</h4>
                        <p class="text-muted mb-4">Sepertinya kamu belum meminjam buku apa pun. Ayo mulai petualanganmu sekarang!</p>
                        <a href="<?= base_url('buku') ?>" class="btn btn-berry-gradient rounded-pill px-5 py-3 fw-bold shadow-sm transition-hover text-white">
                            <i class="bi bi-search me-2"></i> Jelajahi Perpustakaan
                        </a>
                    </div>
                </div>
            <?php else : ?>
                <?php foreach ($riwayat as $r) : ?>
                    <div class="col-md-6 col-lg-4 animate-fade-in">
                        <div class="card-history border-0 shadow-sm rounded-5 overflow-hidden bg-white h-100 position-relative">
                            
                            <div class="position-absolute top-0 end-0 m-3" style="z-index: 10;">
                                <span class="badge rounded-pill px-3 py-2 shadow-sm <?= $r['status'] == 'dipinjam' ? 'bg-warning-soft text-warning' : 'bg-success-soft text-success' ?>" style="font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="bi <?= $r['status'] == 'dipinjam' ? 'bi-hourglass-split' : 'bi-check-all' ?> me-1"></i>
                                    <?= $r['status'] ?>
                                </span>
                            </div>

                            <div class="d-flex h-100 flex-column flex-sm-row">
                                <div class="history-side d-flex align-items-center justify-content-center <?= $r['status'] == 'dipinjam' ? 'bg-berry-gradient' : 'bg-success-gradient' ?>">
                                    <div class="text-center text-white p-3">
                                        <i class="bi bi-bookmark-heart display-6 opacity-50"></i>
                                        <div class="extra-small fw-bold opacity-75 mt-2 ls-1 text-uppercase">Archived</div>
                                    </div>
                                </div>
                                
                                <div class="p-4 flex-grow-1 d-flex flex-column">
                                    <div class="mb-auto">
                                        <p class="text-purple-berry extra-small fw-bold mb-1 opacity-75">ID PINJAM: #<?= str_pad($r['id_peminjaman'] ?? $r['id_buku'], 5, '0', STR_PAD_LEFT) ?></p>
                                        <h5 class="fw-bold text-dark text-limit-2 mb-3" title="<?= $r['judul'] ?>">
                                            <?= $r['judul'] ?>
                                        </h5>
                                    </div>

                                    <div class="pt-3 border-top border-light-subtle">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="icon-box-sm bg-purple-soft text-purple-berry me-3"><i class="bi bi-calendar-plus"></i></div>
                                            <div>
                                                <div class="text-muted extra-small fw-bold text-uppercase opacity-50" style="font-size: 0.6rem;">Dipinjam Pada</div>
                                                <div class="fw-bold text-dark small"><?= date('d M Y', strtotime($r['tanggal_pinjam'])) ?></div>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center mb-4">
                                            <?php if ($r['status'] == 'kembali') : ?>
                                                <div class="icon-box-sm bg-success-soft text-success me-3"><i class="bi bi-calendar-check"></i></div>
                                                <div>
                                                    <div class="text-muted extra-small fw-bold text-uppercase opacity-50" style="font-size: 0.6rem;">Selesai Baca</div>
                                                    <div class="fw-bold text-success small"><?= date('d M Y', strtotime($r['tanggal_pengembalian_asli'])) ?></div>
                                                </div>
                                            <?php else : ?>
                                                <div class="icon-box-sm bg-danger-soft text-danger me-3"><i class="bi bi-calendar-x"></i></div>
                                                <div>
                                                    <div class="text-muted extra-small fw-bold text-uppercase opacity-50" style="font-size: 0.6rem;">Batas Waktu</div>
                                                    <div class="fw-bold text-danger small"><?= date('d M Y', strtotime($r['tanggal_kembali'])) ?></div>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <?php if (!empty($r['file_pdf'])) : ?>
                                            <a href="<?= base_url('uploads/buku/pdf/' . $r['file_pdf']) ?>" target="_blank" class="btn btn-berry-gradient w-100 rounded-pill py-2 fw-bold text-white shadow-sm transition-hover">
                                                <i class="bi bi-book-half me-2"></i> Baca E-Book
                                            </a>
                                        <?php else : ?>
                                            <button class="btn btn-light w-100 rounded-pill py-2 fw-bold text-muted border border-light-subtle" disabled>
                                                <i class="bi bi-file-earmark-x me-2"></i> PDF Tidak Tersedia
                                            </button>
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
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
    
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8f9ff; }
    .text-purple-berry { color: #673ab7 !important; }
    .bg-purple-soft { background-color: #f3e5f5; }
    .bg-berry-gradient { background: linear-gradient(135deg, #673ab7 0%, #9c27b0 100%); }
    .bg-success-gradient { background: linear-gradient(135deg, #43a047 0%, #1b5e20 100%); }
    .btn-berry-gradient { background: linear-gradient(135deg, #673ab7 0%, #9c27b0 100%); border: none; }
    .btn-berry-gradient:hover { filter: brightness(1.1); transform: translateY(-2px); box-shadow: 0 5px 15px rgba(103, 58, 183, 0.3); color: white; }

    .ls-1 { letter-spacing: 1px; }
    .extra-small { font-size: 0.65rem; }
    .text-limit-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 2.8rem; line-height: 1.4; }
    .text-light-gray { color: #e2e8f0; }
    .rounded-5 { border-radius: 2rem !important; }

    /* Soft Backgrounds for Badges */
    .bg-warning-soft { background-color: #fff8e1; color: #ff8f00 !important; }
    .bg-success-soft { background-color: #e8f5e9; color: #2e7d32 !important; }
    .bg-danger-soft { background-color: #ffebee; color: #c62828 !important; }

    /* History Card */
    .card-history { transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); border: 1px solid rgba(226, 232, 240, 0.5); }
    .card-history:hover { 
        transform: translateY(-10px); 
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1) !important; 
        border-color: #673ab7;
    }

    .history-side { width: 120px; min-height: 100%; transition: all 0.4s; }
    .card-history:hover .history-side { width: 130px; }

    /* Icon Box */
    .icon-box-sm { 
        width: 35px; 
        height: 35px; 
        border-radius: 12px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-size: 0.9rem;
    }

    /* Animation */
    @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { animation: fadeIn 0.7s ease-out forwards; }

    /* Responsive */
    @media (max-width: 576px) {
        .history-side { width: 100%; height: 80px; min-height: 80px; }
        .card-history:hover .history-side { width: 100%; height: 90px; }
        .rounded-5 { border-radius: 1.5rem !important; }
    }
</style>

<?= $this->endSection() ?>