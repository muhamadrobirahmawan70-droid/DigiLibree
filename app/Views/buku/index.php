<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-5" style="background-color: #f4f7fe; min-height: 100vh;">

    <div class="row mb-5 align-items-center">
        <div class="col-lg-8">
            <h1 class="display-5 fw-bold text-dark mb-2">DigiLibree <span class="text-primary">Katalog</span></h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Koleksi Buku</li>
                </ol>
            </nav>
        </div>
        <div class="col-lg-4 text-lg-end">
            <?php if (session()->get('role') == 'admin'): ?>
                <a href="<?= base_url('buku/create') ?>" class="btn btn-dark rounded-4 px-4 py-3 shadow-lg border-0 transition-hover">
                    <i class="bi bi-plus-circle-fill me-2"></i> Tambah Koleksi
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-5 p-4 mb-5 bg-white search-panel">
        <form method="get" class="row g-3">
            <div class="col-md-7">
                <div class="input-group input-group-lg border rounded-4 overflow-hidden bg-light custom-input-group">
                    <span class="input-group-text border-0 bg-transparent ps-4 text-primary"><i class="bi bi-search"></i></span>
                    <input type="text" name="keyword" class="form-control border-0 bg-transparent shadow-none" 
                           placeholder="Cari judul, penulis, atau genre..." value="<?= $keyword ?? '' ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group input-group-lg border rounded-4 overflow-hidden bg-light custom-input-group">
                    <span class="input-group-text border-0 bg-transparent ps-3 text-warning"><i class="bi bi-filter-circle-fill"></i></span>
                    <select name="sort" class="form-select border-0 bg-transparent shadow-none small" onchange="this.form.submit()">
                        <option value="">Terbaru</option>
                        <option value="rating" <?= ($sort ?? '') == 'rating' ? 'selected' : '' ?>>⭐ Rating Tertinggi</option>
                        <option value="populer" <?= ($sort ?? '') == 'populer' ? 'selected' : '' ?>>🔥 Paling Populer</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary btn-lg w-100 rounded-4 fw-bold shadow-sm" type="submit">Cari</button>
            </div>
        </form>
    </div>

    <?php if (!$keyword && !empty($buku) && !isset($sort)): ?>
    <div class="mb-5">
        <div class="d-flex align-items-center mb-4">
            <span class="badge bg-primary p-2 me-3 rounded-3 shadow-sm"><i class="bi bi-lightning-fill"></i></span>
            <h3 class="fw-bold m-0 text-dark">Lagi Rame Dipinjam</h3>
        </div>
        <div class="row g-4">
            <?php 
            $top3 = array_slice($buku, 0, 3); 
            foreach ($top3 as $index => $t): 
                if ($t['total_dipinjam'] > 0): 
            ?>
            <div class="col-md-4">
                <div class="trending-item p-4 rounded-5 bg-white shadow-sm border-start border-primary border-5 h-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <span class="badge bg-soft-primary text-primary rounded-pill px-3 py-2 small ls-2 fw-bold text-uppercase"><?= $t['nama_kategori'] ?? 'Umum' ?></span>
                        <div class="h3 fw-black text-light-gray m-0"><?= $index + 1 ?></div>
                    </div>
                    <h4 class="fw-bold my-3 text-dark text-limit-1"><?= $t['judul'] ?></h4>
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle me-2 d-flex align-items-center justify-content-center" style="width:35px; height:35px;">
                            <i class="bi bi-person-fill text-primary"></i>
                        </div>
                        <span class="small text-muted fw-semibold"><?= $t['nama_penulis'] ?? '-' ?></span>
                    </div>
                </div>
            </div>
            <?php endif; endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="row g-4 mt-2">
        <?php foreach ($buku as $b): ?>
            <?php 
                $db = \Config\Database::connect();
                $checkStatus = $db->table('peminjaman')
                    ->where(['id_buku' => $b['id_buku'], 'id_user' => session()->get('id')])
                    ->whereIn('status', ['pending', 'disetujui', 'dipinjam'])
                    ->orderBy('id_peminjaman', 'DESC')->get()->getRowArray();
                
                $sudahSelesai = $db->table('peminjaman')
                    ->where(['id_buku' => $b['id_buku'], 'id_user' => session()->get('id'), 'status' => 'kembali'])
                    ->get()->getRowArray();
            ?>
            
            <div class="col-md-6 col-xl-4">
                <div class="book-card-premium">
                    <div class="card border-0 rounded-5 shadow-sm overflow-hidden h-100 bg-white position-relative">
                        
                        <?php if ($b['rata_rating'] >= 4.5): ?>
                            <div class="position-absolute top-0 end-0 m-3" style="z-index: 10;">
                                <span class="badge bg-warning text-dark rounded-pill shadow-sm py-2 px-3">
                                    <i class="bi bi-patch-check-fill me-1"></i> Best Choice
                                </span>
                            </div>
                        <?php endif; ?>

                        <div class="row g-0 h-100">
                            <div class="col-5 bg-gradient-book p-3 d-flex flex-column justify-content-between text-white position-relative">
                                <div class="badge bg-white bg-opacity-25 rounded-pill py-2 px-3 small border border-white border-opacity-25 glass-badge text-truncate">
                                    <?= $b['nama_rak'] ?? 'Rak -' ?>
                                </div>
                                
                                <div class="text-center my-2">
                                    <?php if (!empty($b['cover']) && file_exists(FCPATH . 'uploads/buku/cover/' . $b['cover'])): ?>
                                        <img src="<?= base_url('uploads/buku/cover/' . $b['cover']) ?>" 
                                             class="img-fluid rounded-3 shadow-lg icon-float" 
                                             style="height: 140px; width: 100%; object-fit: cover; border: 2px solid rgba(255,255,255,0.2);">
                                    <?php else: ?>
                                        <i class="bi bi-journal-bookmark-fill display-3 opacity-50 icon-float"></i>
                                    <?php endif; ?>
                                </div>

                                <div class="text-center small opacity-75 fw-bold letter-spacing-1">ID: B-<?= str_pad($b['id_buku'], 3, '0', STR_PAD_LEFT) ?></div>
                            </div>
                            
                            <div class="col-7 p-4 d-flex flex-column">
                                <div class="mb-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <small class="text-primary fw-bold text-uppercase ls-1 extra-small"><?= $b['nama_kategori'] ?? 'Umum' ?></small>
                                        <?php if ($b['total_dipinjam'] >= 5) : ?>
                                            <span class="text-danger"><i class="bi bi-fire fs-6"></i></span>
                                        <?php endif; ?>
                                    </div>
                                    <h5 class="fw-bold text-dark lh-base text-limit-2 mb-1"><?= $b['judul'] ?></h5>
                                    
                                    <div class="d-flex align-items-center mb-2">
                                        <?php if ($b['rata_rating']): ?>
                                            <div class="text-warning extra-small me-2">
                                                <?php 
                                                    $stars = round($b['rata_rating']);
                                                    for ($i = 1; $i <= 5; $i++) {
                                                        echo ($i <= $stars) ? '<i class="bi bi-star-fill"></i>' : '<i class="bi bi-star"></i>';
                                                    }
                                                ?>
                                                <span class="text-dark fw-bold ms-1"><?= number_format($b['rata_rating'], 1) ?></span>
                                            </div>
                                        <?php else: ?>
                                            <small class="text-muted extra-small">Belum ada ulasan</small>
                                        <?php endif; ?>
                                    </div>

                                    <p class="text-muted small mb-0">Oleh <span class="text-dark fw-semibold"><?= $b['nama_penulis'] ?? '-' ?></span></p>
                                </div>

                                <div class="my-3">
                                    <?php if ($checkStatus): ?>
                                        <div class="status-box <?= $checkStatus['status'] == 'pending' ? 'status-pending' : 'status-active' ?>">
                                            <div class="dot-pulse me-2"></div>
                                            <?= $checkStatus['status'] == 'pending' ? 'Diproses' : 'Sedang Dibaca' ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="d-flex gap-3 border-top pt-2">
                                            <div class="text-start">
                                                <div class="fw-bold text-dark mb-0 small"><?= $b['tersedia'] ?> <small class="text-muted fw-normal">Eks</small></div>
                                                <small class="text-muted extra-small fw-bold text-uppercase">Stok</small>
                                            </div>
                                            <div class="text-start">
                                                <div class="fw-bold text-dark mb-0 small"><?= $b['total_dipinjam'] ?> <small class="text-muted fw-normal">Kali</small></div>
                                                <small class="text-muted extra-small fw-bold text-uppercase">Hits</small>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="action-zone">
                                    <?php if (session()->get('role') == 'admin'): ?>
                                        <div class="d-flex gap-2">
                                            <a href="<?= base_url('buku/edit/' . $b['id_buku']) ?>" class="btn btn-outline-dark btn-sm rounded-3"><i class="bi bi-pencil-square"></i></a>
                                            <a href="<?= base_url('buku/detail/' . $b['id_buku']) ?>" class="btn btn-primary btn-sm rounded-3 flex-grow-1 fw-bold">Detail</a>
                                            <button type="button" class="btn btn-outline-danger btn-sm rounded-3 btn-delete-anim" data-url="<?= base_url('buku/delete/' . $b['id_buku']) ?>"><i class="bi bi-trash3-fill"></i></button>
                                        </div>
                                    <?php else: ?>
                                        <div class="d-grid gap-2">
                                            <a href="<?= base_url('buku/detail/' . $b['id_buku']) ?>" class="btn btn-outline-primary btn-sm rounded-3 fw-bold">Detail</a>
                                            <?php if ($checkStatus): ?>
                                                <a href="<?= base_url('peminjaman') ?>" class="btn btn-light btn-sm rounded-3 fw-bold border">Pantau Status</a>
                                            <?php elseif ($b['tersedia'] > 0): ?>
                                                <form action="<?= base_url('peminjaman/pinjamKilat/' . $b['id_buku']) ?>" method="post">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-primary btn-sm w-100 rounded-3 fw-bold" onclick="return confirm('Pinjam sekarang?')">
                                                        <i class="bi bi-lightning-charge-fill"></i> Pinjam Kilat
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (session()->get('role') != 'admin' && $sudahSelesai): ?>
            <div class="modal fade" id="modalUlasan<?= $b['id_buku'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-4 border-0">
                        <form action="<?= base_url('peminjaman/simpanUlasan') ?>" method="post">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id_buku" value="<?= $b['id_buku'] ?>">
                            <div class="modal-header border-0">
                                <h5 class="modal-title fw-bold">Review: <?= $b['judul'] ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Rating</label>
                                    <select name="rating" class="form-select bg-light border-0">
                                        <option value="5">⭐⭐⭐⭐⭐</option>
                                        <option value="4">⭐⭐⭐⭐</option>
                                        <option value="3">⭐⭐⭐</option>
                                        <option value="2">⭐⭐</option>
                                        <option value="1">⭐</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Komentar</label>
                                    <textarea name="komentar" class="form-control bg-light border-0" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">Kirim Review</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        <?php endforeach; ?>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
    .extra-small { font-size: 0.65rem; }
    .text-limit-1 { overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
    .text-limit-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .bg-soft-primary { background-color: #eef2ff; }
    .book-card-premium { transition: all 0.4s ease; height: 100%; }
    .book-card-premium:hover { transform: translateY(-12px); z-index: 5; }
    .bg-gradient-book { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); }
    .glass-badge { backdrop-filter: blur(4px); }
    .status-box { padding: 8px 12px; border-radius: 12px; font-weight: 700; font-size: 0.75rem; display: inline-flex; align-items: center; width: 100%; justify-content: center; }
    .status-pending { background-color: #fffbeb; color: #b45309; }
    .status-active { background-color: #f0fdf4; color: #15803d; }
    .dot-pulse { width: 6px; height: 6px; border-radius: 50%; background-color: currentColor; animation: pulse 1.5s infinite; }
    @keyframes pulse { 0% { transform: scale(0.95); opacity: 1; } 70% { transform: scale(1.5); opacity: 0; } 100% { transform: scale(0.95); opacity: 0; } }
    @keyframes throwToTrash { 0% { transform: scale(1); opacity: 1; } 100% { transform: scale(0) translateY(500px); opacity: 0; } }
    .item-delete-animation { animation: throwToTrash 0.7s forwards; }
    .ls-1 { letter-spacing: 1px; }
</style>

<script>
document.querySelectorAll('.btn-delete-anim').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const url = this.getAttribute('data-url');
        const card = this.closest('.book-card-premium');
        if (confirm('Hapus buku ini?')) {
            card.classList.add('item-delete-animation');
            setTimeout(() => { window.location.href = url; }, 600);
        }
    });
});
</script>

<?= $this->endSection() ?>